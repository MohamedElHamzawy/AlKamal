<?php
function updatePayment($body)
{
    global $wpdb;
    $paymentTable = $wpdb->prefix . 'alkamal_payment';
    $data = array(
        'amount' => $body['amount'],
    );
    $where = array('id' => $body['id']);
    $propId = $wpdb->get_var($wpdb->prepare(
        "SELECT propertyId, amount FROM $paymentTable WHERE id = %d",
        $body['id']
    ));
    $wpdb->update($paymentTable, $data, $where);
    $amountDiff = (int) ($body['amount']) - (int) ($propId['amount']);
    $propTable = $wpdb->prefix . 'alkamal_property';
    $shiftedpayments = $wpdb->get_var($wpdb->prepare(
        "SELECT shiftedPayment FROM $propTable WHERE id = %d",
        $propId
    ));
    $newshiftedpayments = (int) $shiftedpayments + $amountDiff;
    $wpdb->update($propTable, array('shiftedPayment' => $newshiftedpayments), array('id' => $propId['propertyId']));
    return new WP_REST_Response([
        'message' => 'payment has been updated successfully'
    ], 200);
}
