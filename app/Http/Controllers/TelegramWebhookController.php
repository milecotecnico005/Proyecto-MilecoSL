<?php

namespace App\Http\Controllers;

use App\Models\telegramGropsUsers;
use App\Models\TelegramGroup;
use App\Models\TelegramUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TelegramWebhookController extends Controller
{
     /**
     * Rangos de IP de Telegram.
     */
    private $telegramIpRanges = [
        '154.56.33.90/20',
        '91.108.4.0/22'
    ];

    /**
     * Verificar si la IP está dentro de los rangos de Telegram.
     */
    private function isIpFromTelegram($ip)
    {
        foreach ($this->telegramIpRanges as $range) {
            if ($this->ipInRange($ip, $range)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Verificar si una IP está dentro de un rango CIDR.
     */
    private function ipInRange($ip, $range)
    {
        list($range, $netmask) = explode('/', $range, 2);
        $rangeDecimal = ip2long($range);
        $ipDecimal = ip2long($ip);
        $wildcardDecimal = pow(2, (32 - $netmask)) - 1;
        $netmaskDecimal = ~$wildcardDecimal;

        return (($ipDecimal & $netmaskDecimal) == ($rangeDecimal & $netmaskDecimal));
    }

    public function telegramWebhook(Request $request){
        
        $clientIp = $request->ip();
        // Verificar si la IP está dentro de los rangos de Telegram
        if (!$this->isIpFromTelegram($clientIp)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        // Obtener el payload de la solicitud (la actualización de Telegram)
        $update = $request->all();
        // Verificar si es una actualización de un grupo donde se ha agregado el bot
        if (isset($update['message']) && isset($update['message']['chat'])) {
            $chat = $update['message']['chat'];

            // Verificar si es un grupo privado (supergroup o group)
            if ($chat['type'] === 'supergroup' || $chat['type'] === 'group') {
                $chatId = $chat['id'];
                $chatTitle = $chat['title'];

                // verificar si el grupo ya existe en la base de datos
                $group = TelegramGroup::where('chat_id', $chatId)->first();

                if (!$group) {
                    // Almacenar el grupo en la base de datos si no existe
                    $group = TelegramGroup::firstOrCreate(
                        ['chat_id' => $chatId],
                        ['name' => $chatTitle]
                    );
                }

            }
        }

        // Verificar si hay nuevos miembros en un mensaje
        if (isset($update['message']['new_chat_members'])) {
            $chatId = $update['message']['chat']['id'];
            $chatTitle = $update['message']['chat']['title'];

            // Buscar el grupo en la base de datos
            $telegramGroup = TelegramGroup::where('chat_id', $chatId)->first();

            // Verificar que el grupo se haya encontrado
            if ($telegramGroup) {
                foreach ($update['message']['new_chat_members'] as $newMember) {
                    $userId = $newMember['id'];
                    $firstName = $newMember['first_name'];
                    $lastName = $newMember['last_name'] ?? null;
                    $username = $newMember['username'] ?? null;

                    // Guardar el usuario en la base de datos
                    $telegramUser = TelegramUser::updateOrCreate(
                        ['telegram_id' => $userId],
                        [
                            'first_name' => $firstName,
                            'last_name' => $lastName,
                            'username' => $username,
                        ]
                    );

                    // verificar si el usuario ya está en el grupo
                    $groupUser = telegramGropsUsers::where('user_id', $telegramUser->id)
                        ->where('group_id', $telegramGroup->id)
                        ->first();

                    if (!$groupUser) {
                        // guardar la relación entre el usuario y el grupo
                        telegramGropsUsers::firstOrCreate([
                            'user_id' => $telegramUser->id,
                            'group_id' => $telegramGroup->id,
                        ]);
                    }

                    // Enviar un mensaje privado al nuevo usuario
                    $this->sendPrivateMessage($userId, "¡Hola $firstName! Bienvenido al grupo $chatTitle.");

                    // verifcar si el usuario tiene un nombre de usuario
                    if ($username) {
                        // Mencionar al usuario en el grupo
                        $this->sendMessage($chatId, "¡Todos, denle la bienvenida a @$username!");
                    } else {
                        // Mencionar al usuario en el grupo por su nombre
                        $this->sendMessage($chatId, "¡Todos, denle la bienvenida a $firstName!");
                    }


                }
            } else {
                // Manejar el caso donde el grupo no se encuentra
            }
        }

        // verificar si hay un nuevo canal ( los canales son diferentes a los grupos )
        if (isset($update['message']['new_chat_members']) && $update['message']['chat']['type'] === 'channel') {
            $chatId = $update['message']['chat']['id'];
            $chatTitle = $update['message']['chat']['title'];

            // Buscar el canal en la base de datos
            $telegramGroup = TelegramGroup::where('chat_id', $chatId)->first();

            // Verificar que el canal se haya encontrado
            if ($telegramGroup) {
                foreach ($update['message']['new_chat_members'] as $newMember) {
                    $userId = $newMember['id'];
                    $firstName = $newMember['first_name'];
                    $lastName = $newMember['last_name'] ?? null;
                    $username = $newMember['username'] ?? null;

                    // Guardar el usuario en la base de datos
                    $telegramUser = TelegramUser::updateOrCreate(
                        ['telegram_id' => $userId],
                        [
                            'first_name' => $firstName,
                            'last_name' => $lastName,
                            'username' => $username,
                        ]
                    );

                    // verificar si el usuario ya está en el canal
                    $groupUser = telegramGropsUsers::where('user_id', $telegramUser->id)
                        ->where('group_id', $telegramGroup->id)
                        ->first();

                    if (!$groupUser) {
                        // guardar la relación entre el usuario y el canal
                        telegramGropsUsers::firstOrCreate([
                            'user_id' => $telegramUser->id,
                            'group_id' => $telegramGroup->id,
                        ]);
                    }

                    // Enviar un mensaje privado al nuevo usuario
                    $this->sendPrivateMessage($userId, "¡Hola $firstName! Bienvenido al canal $chatTitle.");

                    // verifcar si el usuario tiene un nombre de usuario
                    if ($username) {
                        // Mencionar al usuario en el canal
                        $this->sendMessage($chatId, "¡Todos, denle la bienvenida a @$username!");
                    } else {
                        // Mencionar al usuario en el canal por su nombre
                        $this->sendMessage($chatId, "¡Todos, denle la bienvenida a $firstName!");
                    }
                }
            } else {
                // Manejar el caso donde el canal no se encuentra
            }
        }

        // verificar si han actualizado el canal o el grupo
        if (isset($update['message']['new_chat_title'])) {
            $chatId = $update['message']['chat']['id'];
            $chatTitle = $update['message']['new_chat_title'];

            // Buscar el grupo o canal en la base de datos
            $telegramGroup = TelegramGroup::where('chat_id', $chatId)->first();

            // Verificar que el grupo o canal se haya encontrado
            if ($telegramGroup) {
                // Actualizar el nombre del grupo o canal
                $telegramGroup->update(['name' => $chatTitle]);
            } else {
                // Manejar el caso donde el grupo o canal no se encuentra
            }
        }

        // Devolver una respuesta vacía para Telegram
        return response()->json(['status' => 'ok'], 200);
    }

    /**
     * Enviar un mensaje privado a un usuario de Telegram.
     */
    private function sendPrivateMessage($userId, $message)
    {
        $token = env('TELEGRAM_BOT_TOKEN');

        // Asegúrate de que $message sea un string
        if (is_array($message)) {
            $message = json_encode($message); // Convierte el array a JSON
        }

        $response = Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $userId,
            'text' => $message
        ]);

        if ($response->successful()) {
        } else {
        }

        return $response;
    }

    /**
     * Enviar un mensaje a un grupo de Telegram.
     */
    private function sendMessage($chatId, $message)
    {
        $token = env('TELEGRAM_BOT_TOKEN');

        // Asegúrate de que $message sea un string
        if (is_array($message)) {
            $message = json_encode($message); // Convierte el array a JSON
        }

        $response = Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message
        ]);

        if ($response->successful()) {
        } else {
        }

        return $response;
    }
}
