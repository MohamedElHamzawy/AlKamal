<?php
class getAllPayments
{
    public $id;
    public $amount;
    public $createdAt;
    public $propertyName;
    public $image;
}
function getAllPayments($body)
{
    if (!isset($body['currentMonth'])) {
        global $wpdb;
        $totalPages = 1;
        $tablePayments = $wpdb->prefix . "alkamal_payment";
        $tableProperties = $wpdb->prefix . "alkamal_property";
        $sql = "SELECT * FROM $tablePayments payments ORDER BY payments.createdAt DESC  ";

        $Payments = $wpdb->get_results($wpdb->prepare($sql));
        if (isset($body['perPage']) && is_numeric($body['perPage']) && isset($body['page']) && is_numeric($body['page'])  ) {
            $per_page = (int) $body['perPage'];
            $page_number =(int) $body['page'];
            $offset = (int) ($page_number - 1) * $per_page;
            $payments = array_slice($Payments, $offset, $per_page);
            $totalPages = ceil((int) (count($Payments)) / (int) $per_page);
        }
        $responsePayments = array();
        if ($wpdb->num_rows > 0) {
            foreach ($payments as $payment) {
                $prop =  $wpdb->get_results($wpdb->prepare("SELECT * FROM $tableProperties WHERE id = %d", $payment->propertyId))[0];
                $image = explode(',', $prop->images)[0];
                $pay = new getAllPayments();
                if (wp_get_attachment_url($image) != false) {
                    $pay->image = wp_get_attachment_url($image);
                }
                $pay->id = $payment->id;
                $pay->amount = $payment->amount;
                $pay->createdAt = $payment->createdAt;
                $pay->propertyName = $prop->propertyName;
                array_push($responsePayments, $pay);
            }
        } else {
            $image = explode(',', $payments[0]->images)[0];
            if (wp_get_attachment_url($image) != false) {
                $payments->images = wp_get_attachment_url($image);
            }
        }
        $res = array(
            'payments' => $responsePayments ,
        'totalPages' => $totalPages);
        $result = new WP_REST_Response($res, 200);
        $result->set_headers(array('Cache-Control' => 'no-cache'));
        return $result;
    } else {
        global $wpdb;
        $tablePayments = $wpdb->prefix . "alkamal_payment";
        $tableProperties = $wpdb->prefix . "alkamal_property";
        $currentMonth = date('m'); // Numeric representation of the month (01-12)
        $currentYear = date('Y');  // Year (YYYY format)

        $sql = "SELECT SUM(payments.amount) as amount
                FROM $tablePayments payments
                INNER JOIN $tableProperties properties ON payments.propertyId = properties.id
                WHERE MONTH(payments.createdAt) = $currentMonth 
                AND YEAR(payments.createdAt) = $currentYear
                ORDER BY payments.createdAt DESC  ";

        $payments = $wpdb->get_results($wpdb->prepare($sql));
        $amount = $payments[0]->amount;
        $result = new WP_REST_Response($amount, 200);
        $result->set_headers(array('Cache-Control' => 'no-cache'));
        return $amount;
    }
}
