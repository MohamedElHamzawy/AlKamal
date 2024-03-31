<?php
require 'controllers/login.php';
function user_rest_api_init()
{
    register_rest_route("alkamal/v0", '/user/login', array(
        'methods' => 'POST',
        'callback' => 'userLogin',
        'args' => array(
            'username' => array(
                'type' => 'string',
                'required' => true
            ),
            'password' => array(
                'type' => 'string',
                'required' => true
            )
        )
    ));
}
