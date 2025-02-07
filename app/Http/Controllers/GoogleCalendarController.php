<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoogleCalendarController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName('MilecoSL');
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setRedirectUri(config('services.google.redirect'));
        $this->client->addScope(Calendar::CALENDAR);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('consent');
    }

    public function redirectToGoogle()
    {
        $authUrl = $this->client->createAuthUrl();
        return redirect()->away($authUrl);
    }

    public function handleGoogleCallback(Request $request)
    {
        $this->client->authenticate($request->get('code'));
        $accessToken = $this->client->getAccessToken();

        // Guardar el token en la base de datos o en sesión
        session(['google_access_token' => $accessToken]);

        if (isset($accessToken['refresh_token'])) {
            session(['google_refresh_token' => $accessToken['refresh_token']]);
        }

        return redirect('/admin/orders'); // Redirigir a la página deseada
    }

    public function createEvent(array $operarios, $jobDetails, $messageExtra = null)
    {
        try {
            $this->checkAndRefreshToken();

            $service = new \Google\Service\Calendar($this->client);
    
            // Combina la fecha y la hora en formato ISO 8601
            $startDateTime = $jobDetails['fecha_visita'] . 'T' . $jobDetails['start_time'] . ':00+02:00';
            $endDateTime = $jobDetails['fecha_visita'] . 'T' . $jobDetails['end_time'] . ':00+02:00';
    
            // Crear una lista de asistentes (operarios)
            $attendees = [];
            foreach ($operarios as $operario) {
                $attendees[] = ['email' => $operario["emailOperario"]];
            }
    
            $event = new \Google\Service\Calendar\Event([
                'summary' => 'Trabajo asignado: ' . $jobDetails['asunto'],
                'start' => [
                    'dateTime' => $startDateTime,
                    'timeZone' => 'Europe/Madrid',
                ],
                'end' => [
                    'dateTime' => $endDateTime,
                    'timeZone' => 'Europe/Madrid',
                ],
                'attendees' => $attendees, // Asigna todos los operarios como asistentes
                'reminders' => [
                    'useDefault' => false,
                    'overrides' => [
                        ['method' => 'email', 'minutes' => 24 * 60], // 24 horas antes
                        ['method' => 'popup', 'minutes' => 60], // 1 hora antes
                    ],
                ],
                'description' => $messageExtra,
                'colorId' => 5, // Color del evento
            ]);
    
            $calendarId = 'primary'; // Puedes cambiar esto si quieres usar otro calendario
            $event = $service->events->insert($calendarId, $event);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al crear el evento en Google Calendar',
                'error' => $th->getMessage(),
            ]);
        }
        

    }

    public function listEvents($operarioEmail)
    {
        $this->checkAndRefreshToken();

        $service = new Calendar($this->client);

        $calendarId = 'primary';
        $optParams = [
            'timeMin' => date('c'),
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
        ];
        $results = $service->events->listEvents($calendarId, $optParams);

        $res = [
            'items' => $results->getItems(),
            'status' => $results->status,
        ];
        return response()->json($res);
    }

    public function checkGoogleToken()
    {
        if (session('google_access_token')) {
            $accessToken = session('google_access_token');
            $this->client->setAccessToken($accessToken);

            // Verificar si el token ha expirado
            if ($this->client->isAccessTokenExpired()) {
                return false;
            }
            return true;
        }
        return false; // No hay token
    }

    private function checkAndRefreshToken()
    {
        if (session('google_access_token')) {
            $this->client->setAccessToken(session('google_access_token'));

            if ($this->client->isAccessTokenExpired()) {
                if (session('google_refresh_token')) {
                    // Refrescar el token de acceso utilizando el Refresh Token
                    $this->client->fetchAccessTokenWithRefreshToken(session('google_refresh_token'));
                    session(['google_access_token' => $this->client->getAccessToken()]);
                } else {
                    // Si no hay un Refresh Token disponible, redirigir al login
                    throw new \Exception("No se puede refrescar el token de acceso, inicia sesión de nuevo.");
                }
            }
        } else {
            throw new \Exception("No se ha encontrado un token de acceso válido.");
        }
    }
}
