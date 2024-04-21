<?php

class Landlord{
    public $name;
    public $phone;
    public $email;
    public $image;
}



function updateLandlord($body){

    $lord = new Landlord();
    global $wpdb;
    $landlordTable = $wpdb->prefix . 'alkamal_landlord';
    $landlord = $wpdb->get_row("SELECT * FROM $landlordTable WHERE id = " . $body['id']);
    if (!$landlord) {
        return array(
            'landlord not found' => "Landlord : ".$body['id']." not found",
            'status' => '200'
        );
    }
    else{
        if(isset($body['name']) && !empty($body['name'])){
            $lord->name = $body['name'];
        }
        if(isset($body['phone']) && !empty($body['phone'])){
            $lord->phone = $body['phone'];
        }
        if(isset($body['email']) && !empty($body['email'])){
            $lord->email = $body['email'];
        }
        if(isset($body['image']) && !empty($body['image'])){
            $lord->image = $body['image'];
        }

        $wpdb->update($landlordTable, $lord , array('id' => $body['id']));

        return array(
            'message' => 'Landlord has been updated successfully'
        );
    }






}