<?php
require __DIR__ . '/../../../vendor/autoload.php';

use Firebase\JWT\JWT;

function userLogin($body)
{
    $username = $body['username'];
    $password = $body['password'];

    if (isset($username) && $username != '' && isset($password) && $password != '' ) {
        
    global $wpdb;
    $usersTable = $wpdb->prefix . 'alkamal_user';
    $user = $wpdb->get_row("SELECT * FROM $usersTable WHERE username = '$username'");

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
    global $wpdb;
    $tokensTable = $wpdb->prefix . 'alkamal_user';
    $wpdb->update($tokensTable, array(
        'token' => $token
    ), array('id' => $user->id));

    return array(
        'message' => 'user has been logged in successfully',
        'userID' => $user->id,
        'token' => $token,
        'name' => $user->name,
        'username' => $user->username
    );
}

}
