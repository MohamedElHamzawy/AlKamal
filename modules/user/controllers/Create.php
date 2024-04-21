<?php

function create($body){

    global $wpdb;
    $usersTable = $wpdb->prefix . 'users';
    $data = [
        'name' => $body['name'],
        'password' => $body['password']
    ];
    $wpdb->insert($usersTable, $data);

}