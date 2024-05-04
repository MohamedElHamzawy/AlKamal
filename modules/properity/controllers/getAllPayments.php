<?php
class getAllPayments
{
    public $id;
    public $propertyId;
    public $amount;
    public $createdAt;
    public $propertyName;
    public $image;
}
class getAllPaymentsResponse
{
    public $payments;
    public $totalPages;
    public $rentValue = 0;
    public $collectedValue = 0;
    public $persentage = 0;
}
function getAllPayments($body)
{
    global $wpdb;
    $totalPages = 1;
    $tablePayments = $wpdb->prefix . "alkamal_payment";
    $tableProperties = $wpdb->prefix . "alkamal_property";
    $tableNotification = $wpdb->prefix . "alkamal_notification";

    $per_page = (int) $body['perPage'];
    $page_number = (int) $body['page'];
    $offset = (int) ($page_number - 1) * $per_page;

    $sql = "SELECT payments.id id, payments.propertyId propertyId, payments.amount amount, payments.createdAt createdAt, properties.propertyName propertyName, properties.images image
    FROM $tablePayments payments 
    INNER JOIN $tableProperties properties ON payments.propertyId = properties.id AND properties.isDeleted = 0 
    ORDER BY payments.createdAt DESC ";

    $payments = $wpdb->get_results($wpdb->prepare($sql));

    if ($wpdb->num_rows > 0) {
        foreach ($payments as $payment) {
            $payment->image = explode(',', $payment->image)[0];
            if (wp_get_attachment_url($payment->image) != false) {
                $payment->image  = wp_get_attachment_url($payment->image);
            }
        }
    }


    $sql = "SELECT SUM(c.rentValue) AS rentValue  
    FROM $tableNotification AS a  
    INNER JOIN $tableProperties AS c ON a.propertyId = c.id AND c.isDeleted = 0 
    WHERE MONTH(DATE_ADD(a.nextNotificationDate, INTERVAL a.alertTime DAY)) = MONTH(NOW()); ";
    $rentValue = $wpdb->get_results($wpdb->prepare($sql));
    $sql = "SELECT SUM(a.amount) as depositValue 
    FROM $tablePayments AS a
    INNER JOIN $tableProperties AS c ON a.propertyId = c.id AND c.isDeleted = 0 
    WHERE MONTH(a.createdAt) = MONTH(NOW()) ; ";
    $depositValue = $wpdb->get_results($wpdb->prepare($sql));
    $res = new getAllPaymentsResponse();
    $res->payments = $payments;
    $res->totalPages = $totalPages;
    $shiftedPayment = $wpdb->get_var($wpdb->prepare(
        "SELECT SUM(shiftedPayment) FROM $tableProperties WHERE isDeleted = 0 "
    ));
    if (is_numeric($rentValue[0]->rentValue) && $rentValue[0]->rentValue > 1) {
        if ($shiftedPayment != null) {
            $res->rentValue = (int) $rentValue[0]->rentValue + (int) $shiftedPayment;
            // $res->rentValue = (int) $rentValue[0]->rentValue;
        }
    }
    if (is_numeric($depositValue[0]->depositValue) && $depositValue[0]->depositValue > 1) {
        $res->collectedValue = (int) $depositValue[0]->depositValue;
    }
    if ($res->rentValue > 0) {
        $res->persentage = (int) (($res->collectedValue / $res->rentValue)) * 100;
    } else {
        $res->persentage = 100;
    }


    $result = new WP_REST_Response($res, 200);
    $result->set_headers(array('Cache-Control' => 'no-cache'));
    return $result;
}
