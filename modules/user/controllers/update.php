<?php

function update($body)
{

    global $wpdb;

    $usersTable = $wpdb->prefix . 'users';

    $user = $wpdb->get_row("SELECT * FROM $usersTable WHERE id = " . $body['id']);
    if ($user) {
        if (isset($body['username']) && !empty($body['username'])) {
            $user->name = $body['username'];
        }
        if (isset($body['password']) && !empty($body['password'])) {
            if ($body['password'] != $user->password) {
                return array('message' => 'password not match', 'status' => '401');
            }
            if (isset($body['confirmPassword']) && !empty($body['confirmPassword']) && $body['password'] == $body['confirmPassword']) {
                $user->password = $body['password'];
            }
            else {
                return array('message' => 'password and confirm password not match', 'status' => '401');}
        }
        if (isset($body['name']) && !empty($body['name'])) {
            $user->name = $body['name'];
        }
        $wpdb->update($usersTable, $user, array('id' => $user->id));
        return new WP_REST_Response([
            'message' => 'user has been updated successfully',
            'user' => $user
        ], 200);
    }
}
