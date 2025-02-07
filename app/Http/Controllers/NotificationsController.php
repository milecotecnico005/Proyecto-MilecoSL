<?php

namespace App\Http\Controllers;

use App\Models\ConfigModel;
use App\Models\TelegramGroup;
use Dotenv\Dotenv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class NotificationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $dotenv = Dotenv::createImmutable(base_path());
        $dotenv->load();
    }

    public function sendMessageT($message, $chat_id, $media = []){
        $token = env('TELEGRAM_BOT_TOKEN');
        $comunError = "cURL error 35: Recv failure: Connection was reset";

        try {
            // Enviar el mensaje de texto
            $response = Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chat_id,
                'text' => $message
            ]);

            // Enviar cada archivo adjunto (imagen, video o audio) con su comentario
            foreach ($media as $index => $item) {
                $url = '';
                $caption = substr($item['comment'] ?? 'Sin comentario', 0, 1024);

                // Determinar la URL y el campo a enviar según el tipo de archivo
                if ($item['type'] === 'photo') {
                    $url = "https://api.telegram.org/bot$token/sendPhoto";
                    $field = 'photo';
                } elseif ($item['type'] === 'video') {
                    $url = "https://api.telegram.org/bot$token/sendVideo";
                    $field = 'video';
                } elseif ($item['type'] === 'audio') {
                    $url = "https://api.telegram.org/bot$token/sendAudio";
                    $field = 'audio';
                } elseif ($item['type'] === 'document') {
                    $url = "https://api.telegram.org/bot$token/sendDocument";
                    $field = 'document';
                }

                if ($url) {
                    // Enviar el archivo adjunto
                    Http::attach($field, file_get_contents($item['path']), basename($item['path']))
                        ->post($url, [
                            'chat_id' => $chat_id,
                            'caption' => $caption,  // Añadir el pie de foto o comentario
                        ]);
                }
            }

            if ($response->successful()) {
                return response()->json(['status' => 'Mensaje enviado con éxito'], 200);
            } else {
                return response()->json([
                    'status' => 'Error al enviar el mensaje',
                    'error' => $response->json()
                ], $response->status());
            }
        } catch (Exception $e) {
            if (strpos($e->getMessage(), $comunError) !== false) {
                // Intentar enviar el mensaje de nuevo
                return $this->retrySend($message, $chat_id, $media);
            } else {
                return response()->json([
                    'status' => 'Error al conectar con Telegram',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
    }

    public function retrySend($message, $chat_id, $media){
        $token = env('TELEGRAM_BOT_TOKEN');
        try {
            $response = Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chat_id,
                'text' => $message
            ]);

            foreach ($media as $index => $item) {
                $url = '';
                $caption = $item['comment'] ?? 'Sin comentario';

                if ($item['type'] === 'photo') {
                    $url = "https://api.telegram.org/bot$token/sendPhoto";
                    $field = 'photo';
                } elseif ($item['type'] === 'video') {
                    $url = "https://api.telegram.org/bot$token/sendVideo";
                    $field = 'video';
                } elseif ($item['type'] === 'audio') {
                    $url = "https://api.telegram.org/bot$token/sendAudio";
                    $field = 'audio';
                } elseif ($item['type'] === 'document') {
                    $url = "https://api.telegram.org/bot$token/sendDocument";
                    $field = 'document';
                }

                if ($url) {
                    Http::attach($field, file_get_contents($item['path']), basename($item['path']))
                        ->post($url, [
                            'chat_id' => $chat_id,
                            'caption' => $caption,
                        ]);
                }
            }

            if ($response->successful()) {
                return response()->json(['status' => 'Mensaje enviado con éxito en el segundo intento'], 200);
            } else {
                return response()->json([
                    'status' => 'Error al enviar el mensaje en el segundo intento',
                    'error' => $response->json()
                ], $response->status());
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Error al conectar con Telegram en el segundo intento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getCurrentChatIdByConfig($config){

        $chat_id = ConfigModel::where($config, '!=', null)
        ->orderBy('id', 'desc')
        ->first();

        return $chat_id->{$config};
    }

    public function sendMessageTelegram($chat_id, $message, $media = [])
    {
        $this->sendMessageT($message, $chat_id, $media);
    }
}