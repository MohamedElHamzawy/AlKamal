<?php
function rest_api_launch_activation()
{
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    global $wpdb;

    dbDelta("CREATE TABLE " . $wpdb->prefix . "alkamal_property (
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        propertyName TEXT,
        address TEXT NOT NULL,
        area VARCHAR(25) NOT NULL,
        status VARCHAR(25) NOT NULL,
        startAt DATETIME,
        endAt DATETIME,
        images LONGTEXT NOT NULL,
        rentValue FLOAT,
        depositValue FLOAT,
        meterPrice FLOAT,
        paperContractNumber TEXT,
        digitlyContractNumber TEXT,
        insurance FLOAT,
        commission FLOAT,
        annualIncrease FLOAT,
        paymentStatus VARCHAR(25) NOT NULL DEFAULT 'unpaid',
        landlordId BIGINT,
        FOREIGN KEY (landlordId) REFERENCES " . $wpdb->prefix . "alkamal_landlord(id) ON DELETE CASCADE
    )");
    dbDelta("CREATE TABLE " . $wpdb->prefix . "alkamal_electricity (
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        propertyId BIGINT NOT NULL,
        FOREIGN KEY (propertyId) REFERENCES " . $wpdb->prefix . "alkamal_property(id) ON DELETE CASCADE,
        sourceOfElectricity TEXT,
        electricCounterNumber TEXT,
        accountNumber TEXT,
        bill LONGTEXT,
        receipt LONGTEXT,
        bond LONGTEXT
    )");
    dbDelta("CREATE TABLE " . $wpdb->prefix . "alkamal_internet (
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        propertyId BIGINT NOT NULL,
        FOREIGN KEY (propertyId) REFERENCES " . $wpdb->prefix . "alkamal_property(id) ON DELETE CASCADE,
        internetCompany TEXT,
        startAt DATETIME,
        endAt DATETIME,
        transactionNumber TEXT,
        accountNumber TEXT,
        bill LONGTEXT,
        receipt LONGTEXT,
        bond LONGTEXT
    )");

    dbDelta("CREATE TABLE " . $wpdb->prefix . "alkamal_landlord (
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        name TEXT,
        email TEXT,
        image LONGTEXT,
        phone TEXT
        )");
    dbDelta("CREATE TABLE " . $wpdb->prefix . "alkamal_user (
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        name TEXT,
        username TEXT,
        password TEXT,
        token TEXT
        )");
}
