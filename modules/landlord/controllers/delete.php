<?php
function deleteLandlord($body){

    $id = $body['id'];
    global $wpdb;
    $landlordTable = $wpdb->prefix . 'alkamal_landlord';
    $wpdb->delete($landlordTable, array('id' => $id));
    return new WP_REST_Response([
        'message' => 'landlord has been deleted successfully'
    ], 200);
}