<?php
require 'controllers/create.php';
require 'controllers/getAll.php';
require 'controllers/update.php';
require 'controllers/delete.php';
require 'controllers/deletePropertyLandlord.php';
require 'controllers/paymentStatus.php';
require 'controllers/getProperty.php';
require 'controllers/getAllPayments.php';
require 'controllers/deletePayment.php';
require 'controllers/updatePayment.php';
function properity_rest_api_init()
{
    $namespace = 'alkamal/v0';

    register_rest_route("$namespace", '/property/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'getProperty',
        'args' => array(
            'get_query_params' => array(
                'id' => array(
                    'type' => 'string || integer',
                    'required' => true
                )
            )
        )
    ));

    register_rest_route("$namespace", '/property', array(
        'methods' => 'GET',
        'callback' => 'getAllProperties',
    ));

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
            ),
            'paymentSystem' => array(
                'type' => 'string',
                'required' => true,
            ),
            'notificationAlert' => array(
                'type' => 'string',
                'required' => true,
            ),
        )

    ));

    register_rest_route("$namespace", '/property/(?P<id>\d+)', array(
        'methods' => 'PUT',
        'callback' => 'updateProperty',
        'args' => array(
            'propertyName' => array(
                'type' => 'string || array || integer',
            ),
            'address' => array(
                'type' => 'string || array || integer',
            ),
            'area' => array(
                'type' => 'string || array || integer',
            ),
            'status' => array(
                'type' => 'string || array || integer',
            ),
            'startAt' => array(
                'type' => 'string || array || integer',
            ),
            'endAt' => array(
                'type' => 'string || array || integer',
            ),
            'images' => array(
                'type' => 'string || array || integer',
            ),
            'rentValue' => array(
                'type' => 'string || array || integer',
            ),
            'depositValue' => array(
                'type' => 'string || array || integer',
            ),
            'meterPrice' => array(
                'type' => 'string || array || integer',
            ),
            'paperContractNumber' => array(
                'type' => 'string || array || integer',
            ),
            'digitlyContractNumber' => array(
                'type' => 'string || array || integer',
            ),
            'insurance' => array(
                'type' => 'string || array || integer',
            ),
            'commission' => array(
                'type' => 'string || array || integer',
            ),
            'annualIncrease' => array(
                'type' => 'string || array || integer',
            ),
            'landlord' => array(
                'type' => 'string || array || integer',
            ),
        )
    ));

    register_rest_route("$namespace", '/internet/(?P<id>\d+)', array(
        'methods' => 'PUT',
        'callback' => 'updateInternet',
        'args' => array(
            'internetCompany' => array(
                'type' => 'string || array || integer',
            ),
            'startAt' => array(
                'type' => 'string || array || integer',
            ),
            'endAt' => array(
                'type' => 'string || array || integer',
            ),
            'transactionNumber' => array(
                'type' => 'string || array || integer',
            ),
            'accountNumber' => array(
                'type' => 'string || array || integer',
            ),
            'bill' => array(
                'type' => 'string || array || integer',
            ),
            'receipt' => array(
                'type' => 'string || array || integer',
            ),
            'bond' => array(
                'type' => 'string || array || integer',
            ),
        ),
    ));

    register_rest_route("$namespace", '/electricity/(?P<id>\d+)', array(
        'methods' => 'PUT',
        'callback' => 'updateElectricity',
        'args' => array(
            'sourceOfElectricity' => array(
                'type' => 'string || array || integer',
            ),
            'electricCounterNumber' => array(
                'type' => 'string || array || integer',
            ),
            'accountNumber' => array(
                'type' => 'string || array || integer',
            ),
            'bill' => array(
                'type' => 'string || array || integer',
            ),
            'receipt' => array(
                'type' => 'string || array || integer',
            ),
            'bond' => array(
                'type' => 'string || array || integer',
            ),
        ),
    ));

    register_rest_route("$namespace", '/property/(?P<id>\d+)', array(
        'methods' => 'DELETE',
        'callback' => 'deleteProperty',
    ));

    register_rest_route("$namespace", '/propertylandlord/(?P<id>\d+)', array(
        'methods' => 'PUT',
        'callback' => 'deletePropertyLandlord',
    ));
    register_rest_route("$namespace", "/property/payment/(?P<id>\d+)", array(
        'methods' => 'PUT',
        'callback' => 'createPayment',
        'args' => array(
            'amount' => array(
                'type' => 'string',
                'required' => true
            )
        )
    ));
    register_rest_route("$namespace", "/payments", array(
        'methods' => 'GET',
        'callback' => 'getAllPayments',
        'args' => array(
            'get_query_params' => array(
                'page' => array(
                    'type' => 'integer || string',
                    'required' => false
                ),
                'perPage' => array(
                    'type' => 'integer || string',
                    'required' => false
                ),
                'currentMonth' => array(
                    'type' => 'boolean',
                    'required' => false
                )
            )
        )
    ));
    register_rest_route("$namespace", "/payment/(?P<id>\d+)", array(
        'methods' => 'DELETE',
        'callback' => 'deletePayment',
    ));
    register_rest_route("$namespace", "/payment/(?P<id>\d+)", array(
        'methods' => 'PUT',
        'callback' => 'updatePayment',
        'args' => array(
            'amount' => array(
                'type' => 'string',
                'required' => true
            )
        )
    ));
}
