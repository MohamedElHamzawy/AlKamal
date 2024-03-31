<?php
function createProperty($body)
{
    global $wpdb;
    $properityData = array();
    $properityTable = $wpdb->prefix . 'alkamal_property';
    $contractData = array();
    $contractTable = $wpdb->prefix . 'alkamal_contract';
    $electricData = array();
    $electricTable = $wpdb->prefix . 'alkamal_electric';
    $internetData = array();
    $internetTable = $wpdb->prefix . 'alkamal_internet';

    if (isset($body['title'])) {
        $properityData['title'] = $body['title'];
    }
    if (isset($body['address'])) {
        $properityData['address'] = $body['address'];
    }
    if (isset($body['image'])) {
        $properityData['image'] = $body['image'];
    }
    if (isset($body['area'])) {
        $properityData['area'] = $body['area'];
    }
    if (isset($body['contract_from'])) {
        $contractData['contract_from'] = $body['contract_from'];
    }
    if (isset($body['contract_to'])) {
        $contractData['contract_to'] = $body['contract_to'];
    }
    if (isset($body['rent'])) {
        $contractData['rent'] = $body['rent'];
    }
    if (isset($body['deposit'])) {
        $contractData['deposit'] = $body['deposit'];
    }
    if (isset($body['paperContract'])) {
        $contractData['paperContract'] = $body['paperContract'];
    }
    if (isset($body['eContract'])) {
        $contractData['eContract'] = $body['eContract'];
    }
    if (isset($body['insurance'])) {
        $contractData['insurance'] = $body['insurance'];
    }
    if (isset($body['commission'])) {
        $contractData['commission'] = $body['commission'];
    }
    if (isset($body['incrementalRatio'])) {
        $contractData['incrementalRatio'] = $body['incrementalRatio'];
    }
    if (isset($body['electricSource'])) {
        $electricData['electricSource'] = $body['electricSource'];
    }
    if (isset($body['electricMeter'])) {
        $electricData['electricMeter'] = $body['electricMeter'];
    }
    if (isset($body['meterNumber'])) {
        $electricData['meterNumber'] = $body['meterNumber'];
    }
    if (isset($body['electricReceipt'])) {
        $electricData['electricReceipt'] = $body['electricReceipt'];
    }
    if (isset($body['internetCompany'])) {
        $internetData['internetCompany'] = $body['internetCompany'];
    }
    if (isset($body['internetNumber'])) {
        $internetData['internetNumber'] = $body['internetNumber'];
    }
    if (isset($body['internetFrom'])) {
        $internetData['internetFrom'] = $body['internetFrom'];
    }
    if (isset($body['internetTo'])) {
        $internetData['internetTo'] = $body['internetTo'];
    }

    try {
        $wpdb->insert($properityTable, $properityData);
        $propertyId = $wpdb->insert_id;
        $contractData['propertyId'] = $propertyId;
        $wpdb->insert($contractTable, $contractData);
        $electricData['propertyId'] = $propertyId;
        $wpdb->insert($electricTable, $electricData);
        $internetData['propertyId'] = $propertyId;
        $wpdb->insert($internetTable, $internetData);
        wp_send_json_success("Property created successfully", 200);
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage(), 401);
    }
}
