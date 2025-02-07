<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyTelegramIp
{
    /**
     * Rangos de IP de Telegram.
     */
    private $telegramIpRanges = [
        '149.154.160.0/20',
        '91.108.4.0/22'
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $clientIp = $request->ip();

        // Verificar si la IP está dentro de los rangos de Telegram
        if (!$this->isIpFromTelegram($clientIp)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }

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
}
