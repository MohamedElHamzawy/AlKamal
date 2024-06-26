<?php

require 'controllers/login.php';
require 'controllers/getUser.php';
require 'controllers/token.php';
require 'controllers/register.php';
require 'controllers/getAll.php';
require 'controllers/update.php';
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
    register_rest_route("alkamal/v0", '/user', array(
        'methods' => 'GET',
        'callback' => 'getUser',
        'args' => array(
            'get_query_pram' => array(
                'id' => array(
                    'type' => 'string || integer',
                    'required' => true
                )
            )
        )
    ));
    register_rest_route("alkamal/v0", '/user/token/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'userToken',
        'args' => array(
            'token' => array(
                'type' => 'string',
                'required' => true
            )

        )
    ));
    register_rest_route("alkamal/v0", '/user', array(
        'methods' => 'POST',
        'callback' => 'userRegister',
        'args' => array(
            'username' => array(
                'type' => 'string',
                'required' => true
            ),
            'password' => array(
                'type' => 'string',
                'required' => true
            ),
            'name' => array(
                'type' => 'string',
                'required' => true
            )
        )
    ));
    register_rest_route("alkamal/v0", '/user/(?P<id>\d+)', array(
        'methods' => 'PUT',
        'callback' => 'userUpdate',
        'args' => array(
            'name' => array(
                'type' => 'string',
                'required' => false
            ),
            'username' => array(
                'type' => 'string',
                'required' => false
            ),
            'newPassword' => array(
                'type' => 'string',
                'required' => false
            ),
            'oldPassword' => array(
                'type' => 'string',
                'required' => false
            ),
            'confirmPassword' => array(
                'type' => 'string',
                'required' => false
            )
        )
    ));
    register_rest_route("alkamal/v0", '/users', array(
        'methods' => 'GET',
        'callback' => 'getAll',

    ));
}

