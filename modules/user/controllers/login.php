<?php
require __DIR__ . '/../../../vendor/autoload.php';

use Firebase\JWT\JWT;

function userLogin($body)
{
    $username = $body['username'];
    $password = $body['password'];

    if (isset($username) && $username != '' && isset($password) && $password != '' ) {
        
    global $wpdb;
    $usersTable = $wpdb->prefix . 'users';
    $user = $wpdb->get_row("SELECT * FROM $usersTable WHERE name = '$username'");

        if (!$user){
            wp_send_json_error("username is not signed", 401);
        }

    if ($password !== $user->password) {
        wp_send_json_error("Invalid username or password", 401);
    }

    $payload = array(
        'iss' => 'http://alkamal.local/',
        'aud' => 'http://alkamal.local/',
        'iat' => time(),
        'exp' => time() + 3600,
        'user' => $user
    );
    $token = JWT::encode($payload, 'OCTAGATOR_ALKAMAL_SECRET', 'HS256');

    // Save token in database
    global $wpdb;
    $tokensTable = $wpdb->prefix . 'user_tokens';
    $wpdb->insert($tokensTable, array(
        'user_id' => $user->id,
        'token' => $token
    ));

    wp_send_json_success("Bearer $token", 200);
}
}
