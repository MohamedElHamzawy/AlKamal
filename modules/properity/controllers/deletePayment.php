<?php
function deletePayment($body){
    global $wpdb;
    $tablePayments = $wpdb->prefix . "alkamal_payment";
    $paymentAmount = $wpdb->get_row($wpdb->prepare(
        "SELECT amount , propertyId FROM $tablePayments WHERE id = %d",$body['id']
    ));
    $tableProperties = $wpdb->prefix . "alkamal_property";
    $propertyAmount = $wpdb->get_var($wpdb->prepare(
        "SELECT shiftedPayment FROM $tableProperties WHERE id = %d LIMIT 1",$paymentAmount->propertyId
    ));
    $newShiftedpayments = $propertyAmount + $paymentAmount->amount;
    $res = $wpdb->update($tableProperties, array('shiftedPayment' => $newShiftedpayments), array('id' => $paymentAmount->propertyId));
    if($res === false){
        return array(
            'status' => false,
            'message' => 'Error while deleting payment',
            'details' => $wpdb->last_error,
            'table' => $tablePayments,
            'where' => array('id' => $body['id'])
        );
    }
    $result = $wpdb->delete($tablePayments, array('id' => $body['id']));
    if($result === false){
        return array(
            'status' => false,
            'message' => 'Error while deleting payment',
            'details' => $wpdb->last_error,
            'table' => $tablePayments,
            'where' => array('id' => $body['id'])
        );
    }
    return new WP_REST_Response([
        'message' => 'payment has been deleted successfully'
    ], 200);
}