<?php

function delete($body){

    global $wpdb;

    $userTable = $wpdb->prefix . 'users';

    $user = $wpdb->get_row("SELECT * FROM $userTable WHERE id = " . $body['id']);
    




}