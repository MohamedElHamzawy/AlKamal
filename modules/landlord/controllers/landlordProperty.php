<?php
require_once(ABSPATH . 'wp-content/plugins/rest-api-launch/modules/properity/controllers/getProperty.php');
function getLandlordPropertys($body)
{
    global $wpdb;

    $landlordProperty = array();

    $propertyTable = $wpdb->prefix . 'alkamal_property';

    $properties = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$propertyTable} WHERE landlordId = %d AND isDeleted = 0",
        $body['id']
    ));
    foreach ($properties as $property) {
        $propdata = array(
            'id' => $property->id
        );
        $prop = getProperty($propdata);
        array_push($landlordProperty, $prop[0]);
    }

    $result = new WP_REST_Response($landlordProperty, 200);
    $result->set_headers(array('Cache-Control' => 'no-cache'));

    return $result;
}
