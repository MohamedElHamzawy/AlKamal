<?php

function getAll(){

    global $wpdb;

    $getLandlords = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}landlords");

    return $getLandlords;

}