<?php

function create($body){

    global $wpdb;
    $usersTable = $wpdb->prefix . 'alkamal_user';
    $data = [
        'name' => $body['name'],
        'password' => $body['password']
    ];
    $wpdb->insert($usersTable, $data);

}