<?php
function deleteLandlord($body){

    $id = $body['id'];
    global $wpdb;
    $tableProerty = "{$wpdb->prefix}alkamal_property";
    $propdata = array('landlordId' => NULL);
    $where = array('landlordId' => $id);
    $result = $wpdb->update($tableProerty, $propdata, $where);
    $tableLandlord = "{$wpdb->prefix}alkamal_landlord";
    $where = array('id' => $id);
    $result = $wpdb->delete($tableLandlord, $where);
    if ($result === false) {
        return array(
            'status' => false,
            'message' => 'Error while deleting landlord',
            'details' => $wpdb->last_error,
            'table' => $tableLandlord,
            'where' => $where
        );
    }
    else{
    return new WP_REST_Response([
        'message' => 'landlord has been deleted successfully'
    ], 200);
}}