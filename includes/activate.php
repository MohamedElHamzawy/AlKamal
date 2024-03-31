<?php
function rest_api_launch_activation()
{
    if (!current_user_can('activate_plugins')) {
        return;
    }
    require ABSPATH . 'wp-admin/includes/upgrade.php';
    global $wpdb;
    dbDelta("CREATE TABLE" . $wpdb->prefix . "prperty(
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        title TEXT NOT NULL,
        address LONGTEXT NOT NULL,
        image BIGINT NOT NULL,
        area VARCHAR(25) NOT NULL
    )");
    dbDelta("CREATE TABLE" . $wpdb->prefix . "contract(
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        propertyId BIGINT NOT NULL,
        from DATETIME NOT NULL,
        to DATETIME NOT NULL,
        rent FLOAT,
        deposit FLOAT,
        paperContract TEXT,
        eContract TEXT,
        insurance FLOAT,
        commission FLOAT,
        incrementalRatio FLOAT,
    )");
    dbDelta("CREATE TABLE" . $wpdb->prefix . "electric(
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        propertyId BIGINT NOT NULL,
        electricSource TEXT NOT NULL,
        electricMeter TEXT NOT NULL,
        meterNumber TEXT NOT NULL,
        electricReceipt TEXT NOT NULL,
    )");
    dbDelta("CREATE TABLE" . $wpdb->prefix . "internet(
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        propertyId BIGINT NOT NULL,
        internetCompany TEXT NOT NULL,
        internetNumber TEXT NOT NULL,
        internetFrom DATETIME NOT NULL,
        internetTo DATETIME NOT NULL,
    )");
}
