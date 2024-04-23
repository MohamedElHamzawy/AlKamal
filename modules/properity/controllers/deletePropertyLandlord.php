<?php

function deletePropertyLandlord($data){
    global $wpdb;
    $propertyTable = $wpdb->prefix . 'alkamal_property';

    $dataRequest = array('landlordId' => NULL); 

    $whereRequest = array('id' => $data['id']);

    $wpdb->update($propertyTable, $dataRequest, $whereRequest);
    return array(
        'status' => true

    );
}