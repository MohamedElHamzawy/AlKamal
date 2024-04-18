<?php
function deleteProperty($body)
{
    global $wpdb;
    $id = $body['id'];
    $propertyTable = $wpdb->prefix . 'alkamal_property';
    $wpdb->delete($propertyTable, array('id' => $id));
}
