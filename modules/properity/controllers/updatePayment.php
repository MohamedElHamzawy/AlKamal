<?php
function updatePayment($body)
{
    global $wpdb;
    $paymentTable = $wpdb->prefix . 'alkamal_payment';
    if (!isset($body['amount']) || empty($body['amount'])) {
        $data = array(
            'amount' => $body['amount'],
        );
    }
    $wpdb->update($paymentTable, $data, array('id' => $body['id']));
    return new WP_REST_Response([
        'message' => 'payment has been updated successfully'
    ], 200);
}
