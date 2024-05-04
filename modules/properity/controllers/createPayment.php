<?php

function createPayment($body)
{
    global $wpdb;
    $table_name = $wpdb->prefix . "alkamal_payment";
    $table_property = $wpdb->prefix . "alkamal_property";
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
    $shiftedPayment = $wpdb->get_var($wpdb->prepare(
        "SELECT shiftedPayment FROM {$table_property} WHERE id = %d LIMIT 1",$body['id']
    ));
    $shiftedPayment = (int) $shiftedPayment - (int) $body['amount'];
    $wpdb->update($table_property, array('shiftedPayment' => $shiftedPayment), array('id' => $body['id'])); 
    return array(
        'message' => "Payment Status updated successfully",
    );
}
