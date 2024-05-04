<?php
function updateProperty($body)
{
    global $wpdb;
    $propertyTable = $wpdb->prefix . 'alkamal_property';
    $notificationTable = $wpdb->prefix . 'alkamal_notification';
    $property = $wpdb->get_row("
    SELECT p.*, n.alertTime 
    FROM $propertyTable p
    INNER JOIN $notificationTable n ON p.id = n.propertyId
     WHERE p.id = " . $body['id']);

    if (!$property) {
        return new WP_Error(
            'rest_no_property',
            'Property not found',
            array('status' => 404)
        );
    }

    $propertyData = array();
    foreach (array('propertyName', 'address', 'area' , 'startAt', 'status', 'endAt', 'images', 'rentValue', 'depositValue', 'meterPrice', 'paperContractNumber', 'digitlyContractNumber', 'insurance', 'commission', 'annualIncrease') as $key) {
        if (isset($body[$key]) && !empty($body[$key])) {
            if ($key == 'images') {
                $reqImages = $body[$key];
                $imgArr = array();
                if ($property->images) {
                    $oldImages = explode(',', $property->images);
                    foreach ($oldImages as $oldImage) {
                        wp_delete_attachment($oldImage, false);
                    }
                }
                $i = 0;
                foreach ($reqImages as $img) {
                    $i++;
                    $image_data = base64_decode($img);
                    $image_name = $propertyData['propertyName'] . "-" . "$i" . "." . "jpeg";
                    $temp_file = wp_tempnam($image_name);
                    if (file_put_contents($temp_file, $image_data) === FALSE) {
                        return new WP_Error(
                            'rest_image_save_error',
                            'Failed to save image',
                            array('status' => 500)
                        );
                    }
                    file_put_contents($temp_file, $image_data);
                    $file_type = wp_check_filetype($image_name);
                    $file_array = array(
                        'name' => $image_name,
                        'type' => $file_type['type'],
                        'tmp_name' => $temp_file,
                        'error' => UPLOAD_ERR_OK,
                        'size' => filesize($temp_file)
                    );
                    $attachment_id = media_handle_sideload($file_array, 0);
                    if (is_wp_error($attachment_id)) {
                        return new WP_Error(
                            'rest_image_handle_error',
                            'Failed to handle image',
                            array('status' => 500)
                        );
                    }
                    $attachment_data = wp_generate_attachment_metadata($attachment_id, $temp_file);
                    if (is_wp_error($attachment_data)) {
                        return new WP_Error(
                            'rest_image_metadata_error',
                            'Failed to generate image metadata',
                            array('status' => 500)
                        );
                    }
                    wp_update_attachment_metadata($attachment_id, $attachment_data);
                    unlink($temp_file);
                    array_push($imgArr, $attachment_id);
                }
                $images = implode(',', $imgArr);
                $propertyData[$key] = $images;
            } 
            elseif($key == 'startAt'){
                if(isset($body['rentValue']) && !empty($body['rentValue'])){
                $propertyData['shiftedPayment'] = $body['startAt'];
            }
            else{
                $propertyData['shiftedPayment'] = $property->rentValue;
            }
        }
            else {
                $propertyData[$key] = $body[$key];
            }

        }
    }
    $wpdb->update($propertyTable, $propertyData, array('id' => $property->id));
    $notData = array();
    $notData['notificationAlert'] = $property->alertTime;
    $notData['paymentSystem']  = $property->paymentSystem;
    $notData['startAt'] = $property->startAt;
    $notData['propertyId'] = $property->id;
    if(isset($body['startAt'])){
        $notData['startAt'] = $body['startAt'];
        $numdays = $property->paymentSystem - $notData['alertTime'];
        $finalNotday = strtotime("+$numdays days", strtotime($notData['startAt']));
        $sqlDateFormat = date('Y-m-d H:i:s', $finalNotday); // Format the timestamp as YYYY-MM-DD for SQL
        $notData['nextNotificationDate'] = $sqlDateFormat;

        
    }
    if(isset($body['notificationAlert'] )){
        $notData['alertTime'] = $body['alertTime'];
        $numdays = $property->paymentSystem - $notData['alertTime'];
        $finalNotday = strtotime("+$numdays days", strtotime($notData['startAt']));
        $sqlDateFormat = date('Y-m-d H:i:s', $finalNotday); // Format the timestamp as YYYY-MM-DD for SQL
        $notData['nextNotificationDate'] = $sqlDateFormat;
    }
    if(isset($body['paymentSystem'])){
        $notData['paymentSystem'] = $body['paymentSystem'];
    
        if(isset($body['isCustom']) && $body['isCustom'] == 1){
            $nextnot = (int) $body['paymentSystem'] - (int) $body['notificationAlert'];
            $finalNotday = strtotime("+$nextnot days", strtotime($notData['startAt'])); 
        }
        elseif(isset($body['isCustom']) && $body['isCustom'] == 1){
            $days = (int) $body['paymentSystem'] / 30 ;
            $nextnot = $days- (int) $body['notificationAlert'];
            $finalNotday = strtotime("+$nextnot months", strtotime($notData['startAt']));
            $sqlDateFormat = date('Y-m-d H:i:s', $finalNotday); // Format the timestamp as YYYY-MM-DD for SQL
            $notData['nextNotificationDate'] = $sqlDateFormat;    
        }
        
    }


    

    $wpdb->update($notificationTable, $notData, array('propertyId' => $property->id));

    wp_send_json_success("Property updated successfully", 200);
}

function updateElectricity($body)
{
    global $wpdb;
    $electricityTable = $wpdb->prefix . 'alkamal_electricity';

    $electricity = $wpdb->get_row("SELECT * FROM $electricityTable WHERE id = " . $body['id']);

    if (!$electricity) {
        return new WP_Error(
            'rest_no_electricity',
            'Electricity not found',
            array('status' => 404)
        );
    }

    $electricityData = array();
    foreach (array('propertyId', 'sourceOfElectricity', 'electricCounterNumber', 'accountNumber', 'bill', 'receipt', 'bond' , 'paymentStatus' , 'landlordId') as $key) {
        if (isset($body[$key]) && !empty($body[$key])) {
            if (in_array($key, array('bill', 'receipt', 'bond'))) {
                $reqImages = $body[$key];
                $imgArr = array();
                    if (isset($electricity->{$key}) && !empty($electricity->{$key})) {
                        $oldImages = explode(',', $electricity->{$key});
                        foreach ($oldImages as $oldImage) {
                            wp_delete_attachment($oldImage, false);
                        }
                    }
                $i = 0;
                foreach ($reqImages as $img) {
                    $i++;
                    $image_data = base64_decode($img);
                    $image_name = $electricityData['sourceOfElectricity'] . "-" . "$i" . "." . "jpeg";
                    $temp_file = wp_tempnam($image_name);
                    if (file_put_contents($temp_file, $image_data) === FALSE) {
                        return new WP_Error(
                            'rest_image_save_error',
                            'Failed to save image',
                            array('status' => 500)
                        );
                    }
                    file_put_contents($temp_file, $image_data);
                    $file_type = wp_check_filetype($image_name);
                    $file_array = array(
                        'name' => $image_name,
                        'type' => $file_type['type'],
                        'tmp_name' => $temp_file,
                        'error' => UPLOAD_ERR_OK,
                        'size' => filesize($temp_file)
                    );
                    $attachment_id = media_handle_sideload($file_array, 0);
                    if (is_wp_error($attachment_id)) {
                        return new WP_Error(
                            'rest_image_handle_error',
                            'Failed to handle image',
                            array('status' => 500)
                        );
                    }
                    $attachment_data = wp_generate_attachment_metadata($attachment_id, $temp_file);
                    if (is_wp_error($attachment_data)) {
                        return new WP_Error(
                            'rest_image_metadata_error',
                            'Failed to generate image metadata',
                            array('status' => 500)
                        );
                    }
                    wp_update_attachment_metadata($attachment_id, $attachment_data);
                    unlink($temp_file);
                    array_push($imgArr, $attachment_id);
                }
                $bill = implode(',', $imgArr);
                $electricityData[$key] = $bill;
            } else {
                $electricityData[$key] = $body[$key];
            }
        }
    }

    $wpdb->update($electricityTable, $electricityData, array('id' => $electricity->id));

    wp_send_json_success("Electricity updated successfully", 200);
}

function updateInternet($body)
{
    global $wpdb;
    $internetTable = $wpdb->prefix . 'alkamal_internet';

    $internet = $wpdb->get_row("SELECT * FROM $internetTable WHERE id = " . $body['id']);

    if (!$internet) {
        return new WP_Error(
            'rest_no_internet',
            'Internet not found',
            array('status' => 404)
        );
    }

    $internetData = array();
    foreach (array('propertyId', 'internetCompany', 'startAt', 'endAt', 'transactionNumber', 'accountNumber', 'bill', 'receipt', 'bond') as $key) {
        if (isset($body[$key]) && !empty($body[$key])) {
            if (in_array($key, array('bill', 'receipt', 'bond'))) {
                $reqImages = $body[$key];
                $imgArr = array();
                    if (isset($internet->{$key}) && !empty($internet->{$key})) {
                        $oldImages = explode(',', $internet->{$key});
                        foreach ($oldImages as $oldImage) {
                            wp_delete_attachment($oldImage, false);
                        }
                    }
                $i = 0;
                foreach ($reqImages as $img) {
                    $i++;
                    $image_data = base64_decode($img);
                    $image_name = $internetData['sourceOfElectricity'] . "-" . "$i" . "." . "jpeg";
                    $temp_file = wp_tempnam($image_name);
                    if (file_put_contents($temp_file, $image_data) === FALSE) {
                        return new WP_Error(
                            'rest_image_save_error',
                            'Failed to save image',
                            array('status' => 500)
                        );
                    }
                    file_put_contents($temp_file, $image_data);
                    $file_type = wp_check_filetype($image_name);
                    $file_array = array(
                        'name' => $image_name,
                        'type' => $file_type['type'],
                        'tmp_name' => $temp_file,
                        'error' => UPLOAD_ERR_OK,
                        'size' => filesize($temp_file)
                    );
                    $attachment_id = media_handle_sideload($file_array, 0);
                    if (is_wp_error($attachment_id)) {
                        return new WP_Error(
                            'rest_image_handle_error',
                            'Failed to handle image',
                            array('status' => 500)
                        );
                    }
                    $attachment_data = wp_generate_attachment_metadata($attachment_id, $temp_file);
                    if (is_wp_error($attachment_data)) {
                        return new WP_Error(
                            'rest_image_metadata_error',
                            'Failed to generate image metadata',
                            array('status' => 500)
                        );
                    }
                    wp_update_attachment_metadata($attachment_id, $attachment_data);
                    unlink($temp_file);
                    array_push($imgArr, $attachment_id);
                }
                $bill = implode(',', $imgArr);
                $internetData[$key] = $bill;
            } else {
                $internetData[$key] = $body[$key];
            }
        }
    }

    $wpdb->update($internetTable, $internetData, array('id' => $internet->id));

    wp_send_json_success("Internet updated successfully", 200);
}
