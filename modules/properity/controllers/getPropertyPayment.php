<?php
function getPropertyPayment($body)
{
    global $wpdb;
    $per_page = $body['perPage'];
    $page_number = $body['page'];
    $offset = ($page_number - 1) * $per_page;
    $table_name = $wpdb->prefix . "alkamal_payment";
    $result = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$table_name} WHERE propertyId = %d  LIMIT $per_page OFFSET $offset ",
        $body['id']
    ));
    $totalRows = $wpdb->get_var($wpdb->prepare("
    SELECT COUNT(*) AS total_count
    FROM {$table_name}
    WHERE propertyId = %d;" , $body['id']));
    $totalPages = ceil($totalRows / $per_page);
    $ress = array(
        'payments' => $result,
        'totalPages' => $totalPages
        
    );
    $response = new WP_REST_Response($ress, 200);
    $response->set_headers(array('Cache-Control' => 'no-cache'));
    return $ress;
}
