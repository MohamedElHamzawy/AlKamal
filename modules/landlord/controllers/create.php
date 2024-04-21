<?php
function createLandlord($data){

    global $wpdb;

    $landlordTable = $wpdb->prefix . 'alkamal_landlord';

    $wpdb->insert($landlordTable, $data);
}

