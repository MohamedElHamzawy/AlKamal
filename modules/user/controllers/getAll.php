<?php 
function getAll(){
    global $wpdb;
    $table_name = $wpdb->prefix . "users";
    $result = $wpdb->get_results("SELECT * FROM $table_name");
    return $result;
}