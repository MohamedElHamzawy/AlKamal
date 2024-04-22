<?php

function userRegister($body){

    global $wpdb;
    $usersTable = $wpdb->prefix . 'alkamal_user';
    $data = [
        'name' => $body['name'],
        'username' => $body['username'],
        'password' => $body['password'],
        
    ];
    $wpdb->insert($usersTable, $data);

    return array(
        'message' => 'user has been created successfully',
    );
    

}