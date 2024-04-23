<?php

function updatePaymentStatus($body)
{
    global $wpdb;
    $table_name = $wpdb->prefix . "alkamal_property";
    $data = array(
        'paymentStatus' => $body['paymentStatus']
    );
    $where = array(
        'id' => $body['id']
    );
    $result = $wpdb->update($table_name, $data, $where);
    if ($result === false) {
        return false;
    }

    return array(
        'message' => "Payment Status Updated to ". $body['paymentStatus'] . " successfully",
    );
}
