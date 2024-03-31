<?php
function rest_api_launch_activation()
{
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    global $wpdb;
    dbDelta("CREATE TABLE " . $wpdb->prefix . "alkamal_property (
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        title TEXT NOT NULL,
        address LONGTEXT NOT NULL,
        image BIGINT NOT NULL,
        area VARCHAR(25) NOT NULL
    )");
    dbDelta("CREATE TABLE " . $wpdb->prefix . "alkamal_contract (
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        propertyId BIGINT NOT NULL,
        contract_from DATETIME NOT NULL,
        contract_to DATETIME NOT NULL,
        rent FLOAT,
        deposit FLOAT,
        paperContract TEXT,
        eContract TEXT,
        insurance FLOAT,
        commission FLOAT,
        incrementalRatio FLOAT
    )");
    dbDelta("CREATE TABLE " . $wpdb->prefix . "alkamal_electric (
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        propertyId BIGINT NOT NULL,
        electricSource TEXT NOT NULL,
        electricMeter TEXT NOT NULL,
        meterNumber TEXT NOT NULL,
        electricReceipt TEXT NOT NULL
    )");
    dbDelta("CREATE TABLE " . $wpdb->prefix . "alkamal_internet (
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        propertyId BIGINT NOT NULL,
        internetCompany TEXT NOT NULL,
        internetNumber TEXT NOT NULL,
        internetFrom DATETIME NOT NULL,
        internetTo DATETIME NOT NULL
    )");
}
