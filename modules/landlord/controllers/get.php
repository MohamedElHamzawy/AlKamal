<?php

function getLandlord($body) {
    
    $id = $body['id'];
    global $wpdb;

    $table_name = $wpdb->prefix . "alkamal_landlord";

    $result = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");
    $result->image = wp_get_attachment_image_url($result->image);

    return $result;

}