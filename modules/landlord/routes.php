<?php

require 'controllers/create.php';
require 'controllers/getAll.php';
require 'controllers/update.php';
require 'controllers/delete.php';
require 'controllers/get.php';


add_action('rest_api_init', "landlord_rest_api_init");

function landlord_rest_api_init(){
    $namespace = 'alkamal/v0';


    register_rest_route($namespace, '/landlord', array(

        'methods' => 'GET',
        'callback' => 'getAllLandlords',

    ));

    register_rest_route($namespace, '/landlord', array(
        'methods' => 'POST',
        'callback' => 'createLandlord',
        'args' => array(
            'name' => array(
                'type' => 'string',
                'required' => true
            ),
            'email' => array(
                'type' => 'string',
                'required' => true
            ),
            'phone' => array(
                'type' => 'string',
                'required' => true
            ),
            'image' => array(
                'type' => 'string',
                'required' => true
            )),
    ));

    register_rest_route($namespace, '/landlord(?P<id>\d+)', array(
        'methods' => 'PUT',
        'callback' => 'updateLandlord',
        'args' => array(
            'name' => array(
                'type' => 'string',
                'required' => true
            ),
            'email' => array(
                'type' => 'string',
                'required' => true
            ),
            'phone' => array(
                'type' => 'string',
                'required' => true
            ),
            'image' => array(
                'type' => 'string',
                'required' => true
            )),
    ));

    register_rest_route($namespace, '/landlord(?P<id>\d+)', array(
        'methods' => 'DELETE',
        'callback' => 'deleteLandlord',
    ));
    
}