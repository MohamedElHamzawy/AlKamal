<?php

function getAllPayments($body)
{
    global $wpdb;
    $tablePayments = $wpdb->prefix . "alkamal_payment";
    $tableProperties = $wpdb->prefix . "alkamal_property";
    $sql = "SELECT payments.amount, payments.createdAt, properties.propertyName
            FROM $tablePayments payments
            INNER JOIN $tableProperties properties ON payments.propertyId = properties.id
            ORDER BY payments.createdAt DESC";
    $payments = $wpdb->get_results($sql);
    if (!isset($body['page']) or !isset($body['perpage'])) {
        return $payments;
    } else {
        $totalPages = ceil(count($payments) / $body['perpage']);
        if ($totalPages < $body['page']) {
            return "total pages is". $totalPages;
        } else {
        $pagedata = array_slice($payments, ($body['page'] - 1) * $body['perpage'], $body['perpage']);
        return $pagedata;
    }
}
}
