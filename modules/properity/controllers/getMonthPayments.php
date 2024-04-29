<?php
function getMonthPayments(){

    global  $wpdb;
    $paymentstable = $wpdb->prefix . 'alkamal_payment';
    $notificationtable = $wpdb->prefix . 'alkamal_notification';
    $propertytable = $wpdb->prefix . 'alkamal_property';
    $sql = "SELECT SUM(c.rentValue) AS rentValue  FROM $notificationtable AS a  INNER JOIN $propertytable AS c ON a.propertyId = c.id AND c.isDeleted = 0 WHERE MONTH(DATE_ADD(a.nextNotificationDate, INTERVAL a.alertTime DAY)) = MONTH(NOW()); ";
    $rentValue = $wpdb->get_results($wpdb->prepare($sql));
    $sql = "SELECT SUM(a.amount) as depositValue FROM $paymentstable AS a WHERE MONTH(a.createdAt) = MONTH(NOW()) ; ";
    $depositValue = $wpdb->get_results($wpdb->prepare($sql));
    $response = array(
        'rentValue' => $rentValue[0]->rentValue,
        'depositValue' => $depositValue[0]->depositValue,
        'persentage' => ($rentValue[0]->rentValue - $depositValue[0]->depositValue) / $rentValue[0]->rentValue * 100
    );

    return $response;
}