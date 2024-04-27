<?php

function updatePaymentStatus($body)
{
    global $wpdb;
    $table_name = $wpdb->prefix . "alkamal_payment";
    $data = array(
        'amount' => $body['amount'],
        'propertyId' => $body['id'],
    );

    $result = $wpdb->insert($table_name, $data);
    if ($result === false) {
        return false;
    }

    // $table_notification = $wpdb->prefix . "alkamal_notification";
    // $table_property = $wpdb->prefix . "alkamal_property";
    // $query = $wpdb->get_var("SELECT anot.lastNotificationDate lastNotificationDate , aprop.paymentSystem paymentSystem
    // FROM $table_notification anot
    // INNER JOIN $table_property aprop ON anot.propertyId = aprop.id
    //  WHERE propertyId = '$body[id]' ");
    // $notdate = strtotime("+{$query['paymentSystem']} days", strtotime($query['lastNotificationDate'])); 
    // $sqlDateFormat = date('Y-m-d', $notdate); // Format the timestamp as YYYY-MM-DD for SQL
    // $notificationData['nextNotificationDate'] = $sqlDateFormat;
    // $result = $wpdb->update($table_notification, $notificationData, array('propertyId' => $body['id']));


    return array(
        'message' => "Payment Status updated successfully",
    );
}
