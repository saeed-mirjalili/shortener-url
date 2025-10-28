<?php
namespace App\Support;

class ShortCode{
    public static function generate(int $len =7): string {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';
        for ($i =0; $i < $len; $i++) {
            $code .= $alphabet[random_int(0, strlen($alphabet) -1)];
        }
        return $code;
    }
}
