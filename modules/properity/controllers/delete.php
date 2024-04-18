<?php
function deleteProperty($body)
{
    global $wpdb;
    $id = $body['id'];
    $propertyTable = $wpdb->prefix . 'alkamal_property';
    $wpdb->delete($propertyTable, array('id' => $id));

    return new WP_REST_Response([
        'message' => 'property has been delted successfully'
    ], 200);
}
