<?php

function getAllProperties()
{
    global $wpdb;
    $getPropertyData = $wpdb->get_results(
        "SELECT * 
        FROM {$wpdb->prefix}alkamal_property AS a
        INNER JOIN {$wpdb->prefix}alkamal_electricity AS b
        ON a.id = b.propertyId
        INNER JOIN {$wpdb->prefix}alkamal_internet AS c
        ON a.id = c.propertyId
        "
    );

    return $getPropertyData;
}
