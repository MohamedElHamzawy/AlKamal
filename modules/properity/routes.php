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
                'type' => 'string || integer || float',
            ),
            'address' => array(
                'type' => 'string || integer || float',
            ),
            'image' => array(
                'type' => 'string || integer || float'
            ),
            'area' => array(
                'type' => 'string || integer || float',
            ),
            'contract_from' => array(
                'type' => 'string || integer || float',
            ),
            'contract_to' => array(
                'type' => 'string || integer || float',
            ),
            'rent' => array(
                'type' => 'string || integer || float',
            ),
            'deposit' => array(
                'type' => 'string || integer || float',
            ),
            'paperContract' => array(
                'type' => 'string || integer || float',
            ),
            'eContract' => array(
                'type' => 'string || integer || float',
            ),
            'insurance' => array(
                'type' => 'string || integer || float',
            ),
            'commission' => array(
                'type' => 'string || integer || float',
            ),
            'incrementalRatio' => array(
                'type' => 'string || integer || float',
            ),
            'electricSource' => array(
                'type' => 'string || integer || float',
            ),
            'electricMeter' => array(
                'type' => 'string || integer || float',
            ),
            'meterNumber' => array(
                'type' => 'string || integer || float',
            ),
            'electricReceipt' => array(
                'type' => 'string || integer || float',
            ),
            "internetCompany" => array(
                'type' => 'string || integer || float',
            ),
            "internetNumber" => array(
                'type' => 'string || integer || float',
            ),
            "internetFrom" => array(
                'type' => 'string || integer || float',
            ),
            "internetTo" => array(
                'type' => 'string || integer || float',
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
                'type' => 'string || integer || float',
                'required' => true
            ),
            'address' => array(
                'type' => 'string || integer || float',
                'required' => true
            ),
            'image' => array(
                'type' => 'string || integer || float'
            ),
            'area' => array(
                'type' => 'string || integer || float',
            ),
            'contract_from' => array(
                'type' => 'string || integer || float',
            ),
            'contract_to' => array(
                'type' => 'string || integer || float',
            ),
            'rent' => array(
                'type' => 'string || integer || float',
                'required' => true
            ),
            'deposit' => array(
                'type' => 'string || integer || float',
                'required' => true
            ),
            'paperContract' => array(
                'type' => 'string || integer || float',
                'required' => true
            ),
            'eContract' => array(
                'type' => 'string || integer || float',
                'required' => true
            ),
            'insurance' => array(
                'type' => 'string || integer || float',
            ),
            'commission' => array(
                'type' => 'string || integer || float',
            ),
            'incrementalRatio' => array(
                'type' => 'string || integer || float',
            ),
            'electricSource' => array(
                'type' => 'string || integer || float',
            ),
            'electricMeter' => array(
                'type' => 'string || integer || float',
            ),
            'meterNumber' => array(
                'type' => 'string || integer || float',
            ),
            'electricReceipt' => array(
                'type' => 'string || integer || float',
            ),
            "internetCompany" => array(
                'type' => 'string || integer || float',
            ),
            "internetNumber" => array(
                'type' => 'string || integer || float',
            ),
            "internetFrom" => array(
                'type' => 'string || integer || float',
            ),
            "internetTo" => array(
                'type' => 'string || integer || float',
            )
        )
    ));
}
