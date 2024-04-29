<?php

function getAllPayments($body)
{
    if (!isset($body['currentMonth'])) {

        global $wpdb;
        $tablePayments = $wpdb->prefix . "alkamal_payment";
        $tableProperties = $wpdb->prefix . "alkamal_property";
        $sql = "SELECT payments.amount, payments.createdAt, properties.propertyName
            FROM $tablePayments payments
            INNER JOIN $tableProperties properties ON payments.propertyId = properties.id
            ORDER BY payments.createdAt DESC";
        if (isset($body['perpage']) && isset($body['page'])) {
            $per_page = $body['perpage'];
            $page_number = $body['page'];
            $offset = ($page_number - 1) * $per_page;
            $sql = $sql . "LIMIT $per_page OFFSET $offset ";
        }
        $payments = $wpdb->get_results($sql);
        $result = new WP_REST_Response($payments, 200);
        $result->set_headers(array('Cache-Control' => 'no-cache'));
        return $result;
    } else {
        global $wpdb;
        $tablePayments = $wpdb->prefix . "alkamal_payment";
        $tableProperties = $wpdb->prefix . "alkamal_property";
        $currentMonth = date('m'); // Numeric representation of the month (01-12)
        $currentYear = date('Y');  // Year (YYYY format)

        $sql = "SELECT payments.amount, payments.createdAt, properties.propertyName
                FROM $tablePayments payments
                INNER JOIN $tableProperties properties ON payments.propertyId = properties.id
                WHERE MONTH(payments.createdAt) = $currentMonth 
                AND YEAR(payments.createdAt) = $currentYear
                ORDER BY payments.createdAt DESC";
        if (isset($body['perpage']) && isset($body['page'])) {
            $per_page = $body['perpage'];
            $page_number = $body['page'];
            $offset = ($page_number - 1) * $per_page;
            $sql = $sql . "LIMIT $per_page OFFSET $offset ";
        }
        $payments = $wpdb->get_results($sql);
        $result = new WP_REST_Response($payments, 200);
        $result->set_headers(array('Cache-Control' => 'no-cache'));
        return $result;
    }
}
