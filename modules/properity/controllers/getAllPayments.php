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

    // $sql1 = "SELECT SUM(c.rentValue) AS rentValue  
    // FROM $tableNotification AS a  
    // INNER JOIN $tableProperties AS c ON a.propertyId = c.id AND c.isDeleted = 0 
    // WHERE MONTH(DATE_ADD(a.nextNotificationDate, INTERVAL a.alertTime DAY)) = MONTH(NOW()); OR a.lastNotificationDate = NULL ";
    // $sql2 = "SELECT SUM(a.amount) as depositValue 
    // FROM $tablePayments AS a
    // INNER JOIN $tableProperties AS c ON a.propertyId = c.id AND c.isDeleted = 0 
    // WHERE MONTH(a.createdAt) = MONTH(NOW()) ; ";
    // $rentValue = $wpdb->get_results($wpdb->prepare($sql1));
    // $depositValue = $wpdb->get_results($wpdb->prepare($sql2));
    // $shiftedPayment = $wpdb->get_var($wpdb->prepare(
    //     "SELECT SUM(shiftedPayment) FROM $tableProperties WHERE isDeleted = 0"
    // ));

    $sql = "SELECT SUM(a.rentValue) AS rentValue, SUM(a.shiftedPayment) AS shiftedPayment
      FROM $tableNotification AS c 
      INNER JOIN $tableProperties AS a ON c.propertyId = a.id AND a.isDeleted = 0
      WHERE MONTH(DATE_ADD(c.nextNotificationDate, INTERVAL c.alertTime DAY)) = MONTH(NOW());";

    $report = $wpdb->get_results($wpdb->prepare($sql))[0];
    $sql = "SELECT SUM(a.amount) as CollectedValue
      FROM $tablePayments AS a
      INNER JOIN $tableProperties AS b ON a.propertyId = b.id AND b.isDeleted = 0
      WHERE MONTH(a.createdAt) = MONTH(NOW()) ;";
    $collectedValue = $wpdb->get_var($wpdb->prepare($sql));
    $rentValue = $report->rentValue;
    $shiftedPayment = $report->shiftedPayment;
    $depositValue = $collectedValue;
    $res = new getAllPaymentsResponse();
    $res->payments = $payments;
    $res->totalPages = $totalPages;
    if(!is_numeric($rentValue)){
        $rentValue = 0;
    }
    if(!is_numeric($shiftedPayment)){
        $shiftedPayment = 0;
    }
    if(!is_numeric($depositValue)){
        $depositValue = 0;
    }

    $res->rentValue = (float) $rentValue - (float) $shiftedPayment;
    $res->collectedValue = (float) $depositValue;

    // if(is_numeric($rentValue) && $rentValue > 1){
    //     $res->rentValue = (float) $rentValue + (float) $shiftedPayment;
    // if (is_numeric($shiftedPayment) && $shiftedPayment > 1) {
    //     if ($shiftedPayment != null) {
    //         $res->rentValue = (float)$rentValue - (float) $shiftedPayment;
             //// $res->rentValue = (int) $rentValue[0]->rentValue;
    //     }
    // }}
    // if (is_numeric($depositValue) && $depositValue > 1) {
    //     $res->collectedValue = (float) $depositValue;
    // }
    if ($res->rentValue > 0) {
        $res->persentage = (float) number_format((float) ((float) ($res->collectedValue / (float) $res->rentValue)) * 100.00 , 2,'.', '');
    } else {
        $res->persentage = 0;
    }


    $result = new WP_REST_Response($res, 200);
    $result->set_headers(array('Cache-Control' => 'no-cache'));
    return $result;
}
