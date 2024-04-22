<?php

function getLandlord($body) {
    
    $id = $body['id'];
    global $wpdb;

    $table_name = $wpdb->prefix . "alkamal_landlord";
    $propertyTable = $wpdb->prefix . "alkamal_property";

    $result = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name a
        INNER JOIN $propertyTable b
        ON a.id = b.landlordId 
        WHERE a.id = $id"));
    $result->image = wp_get_attachment_image_url($result->image);

    return $id;

}