<?php

function getAllLandlords(){

    global $wpdb;

    $getLandlords = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}alkamal_landlord");

    return $getLandlords;

}