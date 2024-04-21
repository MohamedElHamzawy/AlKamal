<?php
function createLandlord($data){

    global $wpdb;



    $landlordTable = $wpdb->prefix . 'alkamal_landlord';
    $propertyTable = $wpdb->prefix . 'alkamal_property';
    $landlord = array(
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'image' => $data['image']

    );

    $wpdb->insert($landlordTable, $landlord);
    $landlordID = $wpdb->insert_id;
    $wpdb->update($propertyTable, array('landlordId' => $landlordID) , array('id' => $data['propertyId']));
}

