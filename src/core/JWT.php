<?php

namespace Service\Api\core;

use Exception;

final class JWT
{
    private static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    public static function encode(array $payload, int $ttl): string
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
        ];

        $payload['iat'] = time();
        $payload['exp'] = time() + $ttl;

        $segments = [
            self::base64UrlEncode(json_encode($header)),
            self::base64UrlEncode(json_encode($payload)),
        ];

        $signature = hash_hmac(
            'sha256',
            implode('.', $segments),
            $_ENV["JWT_SECRET"],
            true
        );

        $segments[] = self::base64UrlEncode($signature);

        return implode('.', $segments);
    }

    public static function decode(string $jwt): array
    {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            throw new Exception('Token inválido');
        }

        [$header64, $payload64, $signature64] = $parts;

        $signatureCheck = self::base64UrlEncode(
            hash_hmac(
                'sha256',
                "$header64.$payload64",
                $_ENV["JWT_SECRET"],
                true
            )
        );

        if (!hash_equals($signatureCheck, $signature64)) {
            throw new Exception('Assinatura inválida');
        }

        $payload = json_decode(self::base64UrlDecode($payload64), true);

        if (($payload['exp'] ?? 0) < time()) {
            throw new Exception('Token expirado');
        }

        return $payload;
    }
}
