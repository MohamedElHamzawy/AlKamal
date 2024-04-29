<?php

function createPayment($body)
{
    global $wpdb;
    $table_name = $wpdb->prefix . "alkamal_payment";
    $data = array(
        'amount' => $body['amount'],
        'propertyId' => $body['id'],
    );

    $result = $wpdb->insert($table_name, $data);
    if ($result === false) {
        return array(
            'message' => 'Error while creating payment',
            'details' => $wpdb->last_error,
            'table' => $table_name,
            'data' => $data,
        );
    }

    return array(
        'message' => "Payment Status updated successfully",
    );
}
