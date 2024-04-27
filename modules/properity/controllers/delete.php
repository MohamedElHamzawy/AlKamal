<?php
function deleteProperty($body)
{
    global $wpdb;
    $id = $body['id'];
    $propertyTable = $wpdb->prefix . 'alkamal_property';
    $data = array('isDeleted' => '1');
    $wpdb->update($propertyTable, $data, array('id' => $id));

    return new WP_REST_Response([
        'message' => 'property has been delted successfully'
    ], 200);
}
