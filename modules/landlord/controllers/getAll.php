<?php

class landlord{
    public $name;
    public $email;
    public $phone;
    public $image;
    public $propertyId;
    public $propety;
}
class property{
    public $id;
    public $name;
}
function getAllLandlords(){
    $ll = new landlord();
    global $wpdb;
    $landlordTable = $wpdb->prefix . 'alkamal_landlord';
    $propertyTable = $wpdb->prefix . 'alkamal_property';
    $getLandlords = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $landlordTable"
    ));
    $landlords = [];
    $prop = new property();
    foreach ($getLandlords as $key) {
        $ll->name = $key->name;
        $ll->email = $key->email;
        $ll->phone = $key->phone;
        $ll->image = wp_get_attachment_url($key->image);;

        $properties = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $propertyTable WHERE landlord_id = %d",
            $key->id
        ));

            $prop->id = $properties->id;
            $prop->name = $properties->property_name;
            array_push($ll->propety, $prop);

        array_push($landlords, $ll);
    }
    return $getLandlords;
}