<?php

function getUser($data){

    global $wpdb;
    $usersTable = $wpdb->prefix . 'alkamal_user';
    $id = $data['id'];
    $user = $wpdb->get_row("SELECT * FROM $usersTable WHERE id = $id");
    if (!$user) {
        return array(
            'user not found' => "user : ".$id." not found",
            'status' => '200'
        );
    }
    return $user;
}