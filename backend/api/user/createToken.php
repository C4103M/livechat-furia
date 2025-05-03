<?php 
//JWT - JSON Web Token
require '../../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
$config = require '../../config/key.php';

$chave_secreta = $config['key'];
$algoritmo = $config['algoritmo'];

function createPayLoad(array $user):array
{
    $agora = time();
    $expiracao = $agora + (60 * 60 * 5); // 5 hora de expiração
    $payload = [
        'iat' => $agora,
        'exp' => $expiracao,
        'iss' => 'http://localhost:8080',
        'aud' => 'http://localhost:5173',
        'data' => [
            'id' => $user['id'],
            'nome' => $user['name'],
            'email' => $user['email'],
            'foto' => $user['img'],
            'isAdmin' => $user['isAdmin'],
        ]
    ];
    return $payload;
}

function createToken(array $payload): string
{
    global $chave_secreta;
    global $algoritmo;
    $jwt = JWT::encode($payload, $chave_secreta, $algoritmo);
    return $jwt;
}
