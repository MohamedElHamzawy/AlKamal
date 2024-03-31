<?php
require __DIR__ . '/../../../vendor/autoload.php';

use Firebase\JWT\JWT;

function userLogin($body)
{
    $username = $body['username'];
    $password = $body['password'];

    if ($username !== 'admin' || $password !== 'admin') {
        wp_send_json_error("Invalid username or password", 401);
    }

    $payload = array(
        'iss' => 'http://alkamal.local/',
        'aud' => 'http://alkamal.local/',
        'iat' => time(),
        'exp' => time() + 3600,
        'username' => $username
    );
    $token = JWT::encode($payload, 'OCTAGATOR_ALKAMAL_SECRET', 'HS256');
    wp_send_json_success("Bearer $token", 200);
}
