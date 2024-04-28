<?php
require(realpath(dirname(__FILE__) . '../../properity/controllers/getProperty.php'));

function getLandlordPropertys($body)
{
    global $wpdb;
 
    $landlordProperty = array() ;

    $propertyTable = $wpdb->prefix . 'alkamal_property';

    $properties = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$propertyTable} WHERE landlordId = {$body['id']} AND isDeleted = 0"));
            if(!$properties){
                return [];
            }else{
                for($i = 0; $i < count($properties); $i++){
                    $propdata = array(
                        'id' => $properties[$i]->id
                    );
                    $prop = getProperty($propdata);
                    array_push($landlordProperty, $prop);
                }
            }

    return $landlordProperty;

}