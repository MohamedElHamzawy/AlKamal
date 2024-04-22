<?php

function userUpdate($body)
{

    global $wpdb;
    $data = array();
    $usersTable = $wpdb->prefix . 'alkamal_user';

    $user = $wpdb->get_row("SELECT * FROM $usersTable WHERE id = " . $body['id']);
    if ($user) {
        if (isset($body['username']) && !empty($body['username'])) {
            $data["username"] = $body['username'];
        }
        if (isset($body['oldpassword']) && !empty($body['oldpassword'])) {
            if ($body['oldpassword'] != $user->password) {
                return array('message' => 'password not match', 'status' => '401');
            }
            if (isset($body['confirmPassword']) && !empty($body['confirmPassword']) && isset($body['newpassword']) && !empty($body['newpassword']) &&  $body['newpassword'] == $body['confirmPassword']) {
                $data['password'] = $body['newpassword'];
            }
            else {
                return array('message' => 'password and confirm password not match', 'status' => '401');}
        }
        if (isset($body['name']) && !empty($body['name'])) {
            $data['name'] = $body['name'];
        }
        
        $wpdb->update($usersTable, $data, array('id' => $user->id));
        return new WP_REST_Response([
            'message' => 'user has been updated successfully',
            'user' => $data
        ], 200);
    }
}
