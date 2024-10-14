<?php

namespace App\Helpar;

use Firebase\JWT\JWT;
use Mockery\Exception;

class JWTToken
{
    public static function CreateToken($userEmail):string{
        $key=env('JWT_KEY');
        $payload = [
            'iss'=>'laravel-token',
            'iat'=>time(),
            'exp'=>time() + 3600,
            'userEmail'=>$userEmail
        ];

        return JWT::encode($payload, $key,'HS256');
    }

    public static function CreateTokenForSetPassword($userEmail):string{
        $key=env('JWT_KEY');
        $payload = [
            'iss'=>'laravel-token',
            'iat'=>time(),
            'exp'=>time() + 300,
            'userEmail'=>$userEmail
        ];

        return JWT::encode($payload, $key,'HS256');
    }

    function VerifyToken($token):string
    {
        try {
            $key=env('JWT_KEY');
            $decoded = JWT::decode($token,new key($key,'HS256'));
            return $decoded->userEmail;
        }
        catch (Exception $e)
        {
            return 'unauthorized';
        }
    }
}
