<?php

require 'controllers/create.php';
require 'controllers/getAll.php';
require 'controllers/update.php';
require 'controllers/delete.php';
require 'controllers/get.php';
require 'controllers/landlordProperty.php';

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
                'required' => false
            ),
            'phone' => array(
                'type' => 'string',
                'required' => true
            ),
            'image' => array(
                'type' => 'string',
                'required' => false,
            ),
            'propertyId' => array(
                'type' => 'string',
                'required' => true
            ),
            )));

    register_rest_route($namespace, '/landlord/(?P<id>\d+)', array(
        'methods' => 'PUT',
        'callback' => 'updateLandlord',
        'args' => array(
            'name' => array(
                'type' => 'string',
                'required' => false
            ),
            'email' => array(
                'type' => 'string',
                'required' => false

            ),
            'phone' => array(
                'type' => 'string',
                'required' => false

            ),
            'propertyId' => array(
                'type' => 'string',
                'required' => false
            ),
            'image' => array(
                'type' => 'string',
                'required' => false

            )),
    ));

    register_rest_route($namespace, '/landlord/(?P<id>\d+)', array(
        'methods' => 'DELETE',
        'callback' => 'deleteLandlord',
    ));

    register_rest_route($namespace, '/landlord-property/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'getLandlordPropertys',
        'args' => array(
            'get_query_pram' => array(
                'id' => array(
                    'type' => 'string',
                    'required' => true
                )
                ))
    ));

}
    
