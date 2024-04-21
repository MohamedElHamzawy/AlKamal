<?php

function delete($body){

    global $wpdb;

    $userTable = $wpdb->prefix . 'alkamal_user';

    $user = $wpdb->get_row("SELECT * FROM $userTable WHERE id = " . $body['id']);
    




}