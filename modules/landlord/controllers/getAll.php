<?php

function getAllLandlords(){

    global $wpdb;

    $landlordTable = $wpdb->prefix . 'alkamal_landlord';

    $getLandlords = $wpdb->get_results("SELECT * FROM $landlordTable");

    for ($i=0; $i < count($getLandlords); $i++) { 
        $getLandlords[$i]->image = wp_get_attachment_url($getLandlords[$i]->image);
    }
    

    return $getLandlords;

}