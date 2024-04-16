<?php
require 'controllers/create.php';
function properity_rest_api_init()
{
    $namespace = 'alkamal/v0';
    // register_rest_route("$namespace", '/property', array(
    //     'methods' => 'GET',
    //     'callback' => 'getAllProperties',
    // ));

    // register_rest_route("$namespace", '/property/(?P<id>\d+)', array(
    //     'methods' => 'GET',
    //     'callback' => 'getProperty',
    // ));

    register_rest_route("$namespace", '/property', array(
        'methods' => 'POST',
        'callback' => 'createProperty',
        'args' => array(
            'propertyName' => array(
                'type' => 'string',
            ),
            'address' => array(
                'type' => 'string',
            ),
            'area' => array(
                'type' => 'string',
            ),
            'status' => array(
                'type' => 'string',
            ),
            'startAt' => array(
                'type' => 'string',
            ),
            'endAt' => array(
                'type' => 'string',
            ),
            'images' => array(
                'type' => 'array',
            ),
            'rentValue' => array(
                'type' => 'number',
            ),
            'depositValue' => array(
                'type' => 'number',
            ),
            'meterPrice' => array(
                'type' => 'number',
            ),
            'paperContractNumber' => array(
                'type' => 'string',
            ),
            'digitlyContractNumber' => array(
                'type' => 'string',
            ),
            'insurance' => array(
                'type' => 'number',
            ),
            'commission' => array(
                'type' => 'number',
            ),
            'annualIncrease' => array(
                'type' => 'number',
            ),
            'elecricity' => array(
                'type' => 'array',
            ),
            'internet' => array(
                'type' => 'array || object || string',
            )
        )

    ));

    // register_rest_route("$namespace", '/property/(?P<id>\d+)', array(
    //     'methods' => 'DELETE',
    //     'callback' => 'deleteProperty',
    // ));

    // register_rest_route("$namespace", '/property/(?P<id>\d+)', array(
    //     'methods' => 'PUT',
    //     'callback' => 'updateProperty',
    //     'args' => array(
    //         'title' => array(
    //             'type' => 'string || integer || float',
    //             'required' => true
    //         ),
    //         'address' => array(
    //             'type' => 'string || integer || float',
    //             'required' => true
    //         ),
    //         'image' => array(
    //             'type' => 'string || integer || float'
    //         ),
    //         'area' => array(
    //             'type' => 'string || integer || float',
    //         ),
    //         'contract_from' => array(
    //             'type' => 'string || integer || float',
    //         ),
    //         'contract_to' => array(
    //             'type' => 'string || integer || float',
    //         ),
    //         'rent' => array(
    //             'type' => 'string || integer || float',
    //             'required' => true
    //         ),
    //         'deposit' => array(
    //             'type' => 'string || integer || float',
    //             'required' => true
    //         ),
    //         'paperContract' => array(
    //             'type' => 'string || integer || float',
    //             'required' => true
    //         ),
    //         'eContract' => array(
    //             'type' => 'string || integer || float',
    //             'required' => true
    //         ),
    //         'insurance' => array(
    //             'type' => 'string || integer || float',
    //         ),
    //         'commission' => array(
    //             'type' => 'string || integer || float',
    //         ),
    //         'incrementalRatio' => array(
    //             'type' => 'string || integer || float',
    //         ),
    //         'electricSource' => array(
    //             'type' => 'string || integer || float',
    //         ),
    //         'electricMeter' => array(
    //             'type' => 'string || integer || float',
    //         ),
    //         'meterNumber' => array(
    //             'type' => 'string || integer || float',
    //         ),
    //         'electricReceipt' => array(
    //             'type' => 'string || integer || float',
    //         ),
    //         "internetCompany" => array(
    //             'type' => 'string || integer || float',
    //         ),
    //         "internetNumber" => array(
    //             'type' => 'string || integer || float',
    //         ),
    //         "internetFrom" => array(
    //             'type' => 'string || integer || float',
    //         ),
    //         "internetTo" => array(
    //             'type' => 'string || integer || float',
    //         )
    //     )
    // ));
}
