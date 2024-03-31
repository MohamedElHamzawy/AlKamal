<?php
require 'controllers/create.php';
function properity_rest_api_init()
{
    $namespace = 'alkamal/v0';
    register_rest_route("$namespace", '/properity', array(
        'methods' => 'GET',
        'callback' => 'getAllProperties',
    ));

    register_rest_route("$namespace", '/properity/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'getProperty',
    ));

    register_rest_route("$namespace", '/properity', array(
        'methods' => 'POST',
        'callback' => 'createProperty',
        'args' => array(
            'title' => array(
                'type' => 'string',
            ),
            'address' => array(
                'type' => 'string',
            ),
            'image' => array(
                'type' => 'string'
            ),
            'area' => array(
                'type' => 'string',
            ),
            'contract_from' => array(
                'type' => 'string',
            ),
            'contract_to' => array(
                'type' => 'string',
            ),
            'rent' => array(
                'type' => 'string',
            ),
            'deposit' => array(
                'type' => 'string',
            ),
            'paperContract' => array(
                'type' => 'string',
            ),
            'eContract' => array(
                'type' => 'string',
            ),
            'insurance' => array(
                'type' => 'string',
            ),
            'commission' => array(
                'type' => 'string',
            ),
            'incrementalRatio' => array(
                'type' => 'string',
            ),
            'electricSource' => array(
                'type' => 'string',
            ),
            'electricMeter' => array(
                'type' => 'string',
            ),
            'meterNumber' => array(
                'type' => 'string',
            ),
            'electricReceipt' => array(
                'type' => 'string',
            ),
            "internetCompany" => array(
                'type' => 'string',
            ),
            "internetNumber" => array(
                'type' => 'string',
            ),
            "internetFrom" => array(
                'type' => 'string',
            ),
            "internetTo" => array(
                'type' => 'string',
            )
        )
    ));

    register_rest_route("$namespace", '/properity/(?P<id>\d+)', array(
        'methods' => 'DELETE',
        'callback' => 'deleteProperty',
    ));

    register_rest_route("$namespace", '/properity/(?P<id>\d+)', array(
        'methods' => 'PUT',
        'callback' => 'updateProperty',
        'args' => array(
            'title' => array(
                'type' => 'string',
                'required' => true
            ),
            'address' => array(
                'type' => 'string',
                'required' => true
            ),
            'image' => array(
                'type' => 'string'
            ),
            'area' => array(
                'type' => 'string',
            ),
            'contract_from' => array(
                'type' => 'string',
            ),
            'contract_to' => array(
                'type' => 'string',
            ),
            'rent' => array(
                'type' => 'string',
                'required' => true
            ),
            'deposit' => array(
                'type' => 'string',
                'required' => true
            ),
            'paperContract' => array(
                'type' => 'string',
                'required' => true
            ),
            'eContract' => array(
                'type' => 'string',
                'required' => true
            ),
            'insurance' => array(
                'type' => 'string',
            ),
            'commission' => array(
                'type' => 'string',
            ),
            'incrementalRatio' => array(
                'type' => 'string',
            ),
            'electricSource' => array(
                'type' => 'string',
            ),
            'electricMeter' => array(
                'type' => 'string',
            ),
            'meterNumber' => array(
                'type' => 'string',
            ),
            'electricReceipt' => array(
                'type' => 'string',
            ),
            "internetCompany" => array(
                'type' => 'string',
            ),
            "internetNumber" => array(
                'type' => 'string',
            ),
            "internetFrom" => array(
                'type' => 'string',
            ),
            "internetTo" => array(
                'type' => 'string',
            )
        )
    ));
}
