<?php 
function getAll(){
    global $wpdb;
    $table_name = $wpdb->prefix . "alkamal_user";
    $result = $wpdb->get_results("SELECT * FROM $table_name");
    return $result;
}