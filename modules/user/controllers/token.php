<?php

function userToken($data)
{

    global $wpdb;
    $userTable = $wpdb->prefix . 'alkamal_user';

    $user = $wpdb->get_row("SELECT * FROM $userTable WHERE id = " . $data['id']);
    if (!$user) {
        return array(
            'message' => 'user not found'
        );
    } else {
        $token = $data['token'];
        $wpdb->update($userTable, array('token' => $token), array('id' => $data['id']));
        return array(
            'message' => 'token updated successfully'
        );
    }
}
