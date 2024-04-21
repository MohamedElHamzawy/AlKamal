<?php

function update($body){

    global $wpdb;

    $usersTable = $wpdb->prefix . 'users';

    $user = $wpdb->get_row("SELECT * FROM $usersTable WHERE id = " . $body['id']);
    if ($user) {
        if ($body['name']) {
    $user->name = $body['name'];
        }
        if($body['password']){
    $user->password = $body['password'];

}
$wpdb->update($usersTable, $user, array('id' => $user->id));
return new WP_REST_Response([
    'message' => 'user has been updated successfully',
    'user' => $user
], 200);
}

}