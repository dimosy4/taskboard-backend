<?php
namespace App\Support;
final class Config {
    private static array $data = [];
    public static function load(string $file): void { self::$data = require $file; }
    public static function get(string $path, mixed $default = null): mixed {
        $value = self::$data;
        foreach (explode('.', $path) as $part) {
            if (!is_array($value) || !array_key_exists($part, $value)) return $default;
            $value = $value[$part];
        }
        return is_string($value) && str_starts_with($value, 'enc:') ? self::decrypt(substr($value,4)) : $value;
    }
    private static function key(): string {
        $key = base64_decode(getenv('APP_KEY') ?: '', true);
        if ($key === false || strlen($key) !== 32) throw new \RuntimeException('APP_KEY must be base64 of 32 random bytes');
        return $key;
    }
    public static function encrypt(string $plain): string {
        $iv = random_bytes(12); $tag = '';
        $cipher = openssl_encrypt($plain, 'aes-256-gcm', self::key(), OPENSSL_RAW_DATA, $iv, $tag);
        if ($cipher === false) throw new \RuntimeException('Encryption failed');
        return 'enc:' . base64_encode($iv.$tag.$cipher);
    }
    private static function decrypt(string $encoded): string {
        $bytes = base64_decode($encoded, true);
        if ($bytes === false || strlen($bytes) < 28) throw new \RuntimeException('Invalid encrypted config');
        $plain = openssl_decrypt(substr($bytes,28), 'aes-256-gcm', self::key(), OPENSSL_RAW_DATA, substr($bytes,0,12), substr($bytes,12,16));
        if ($plain === false) throw new \RuntimeException('Decryption failed');
        return $plain;
    }
}
