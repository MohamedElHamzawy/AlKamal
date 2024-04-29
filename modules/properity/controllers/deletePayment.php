<?php
function deletePayment($body){
    global $wpdb;
    $tablePayments = $wpdb->prefix . "alkamal_payment";
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