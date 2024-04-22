<?php

class landlordData{
    public $id;
    public $name;
    public $email;
    public $phone;
    public $image;
    public $propety = array();    
}
class propertyData{
    public $id;
    public $name;
}
function getAllLandlords(){
    global $wpdb;
    $landlordTable = $wpdb->prefix . 'alkamal_landlord';
    $propertyTable = $wpdb->prefix . 'alkamal_property';
    $getLandlords = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $landlordTable"
    ));
    $landlords = [];
    foreach ($getLandlords as $key) {
        $prop = new propertyData();
        $ll = new landlordData();
        $ll->id = $key->id;
        $ll->name = $key->name;
        $ll->email = $key->email;
        $ll->phone = $key->phone;
        $ll->image = wp_get_attachment_url($key->image);;
        $properties = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$propertyTable} WHERE landlordId = {$key->id}"));
            if(!$properties){
                $prop->id = '';
                $prop->name = '';
                array_push( $ll->propety,  $prop);
            }else{
                for($i = 0; $i < count($properties); $i++){
                    $prop->id = $properties[$i]->id;
                    $prop->name = $properties[$i]->propertyName;
                    array_push(  $ll->propety,  $prop);
                }
            }
        array_push($landlords, $ll);
    }
    return $landlords;
}