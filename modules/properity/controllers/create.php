<?php
function createProperty($body)
{
    global $wpdb;

    $propertyData = array();
    $propertyTable = $wpdb->prefix . 'alkamal_property';

    foreach (array('paymentSystem', 'propertyName', 'address', 'area', 'status', 'startAt', 'endAt', 'images', 'rentValue', 'depositValue', 'meterPrice', 'paperContractNumber', 'digitlyContractNumber', 'insurance', 'commission', 'annualIncrease') as $key) {
        if (isset($body[$key]) && !empty($body[$key])) {
            if ($key == 'images') {
                $reqImages = $body[$key];
                $imgArr = array();
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
            } else {
                $propertyData[$key] = $body[$key];
            }
        }
    }

    try {
        $res = $wpdb->insert($propertyTable, $propertyData);
        $propertyId = $wpdb->insert_id;

        if (isset($body['electricity']) && !empty($body['electricity'])) {
            $electricityTable = $wpdb->prefix . 'alkamal_electricity';
            foreach ($body['electricity'] as $electricity) {
                $electricityData = array();
                $electricityData['propertyId'] = $propertyId;
                foreach (array('sourceOfElectricity', 'electricCounterNumber', 'accountNumber', 'bill', 'receipt', 'bond') as $key) {
                    if (isset($electricity[$key]) && !empty($electricity[$key])) {
                        if (in_array($key, array('bill', 'receipt', 'bond'))) {
                            $reqImages = $electricity[$key];
                            $imgArr = array();
                            $i = 0;
                            foreach ($reqImages as $img) {
                                $i++;
                                $image_data = base64_decode($img);
                                $image_name = $propertyData['propertyName'] . "-" . "electricity" . "-" . "$key" . "-" . "$i" . "." . "jpeg";
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
                            $electricityData[$key] = $images;
                        } else {
                            $electricityData[$key] = $electricity[$key];
                        }
                    }
                }
                $wpdb->insert($electricityTable, $electricityData);
            }
        }

        if (isset($body['internet']) && !empty($body['internet'])) {
            $internetTable = $wpdb->prefix . 'alkamal_internet';
            $internetData = array();
            $internet = $body['internet'];
            $internetData['propertyId'] = $propertyId;
            foreach (array('internetCompany', 'startAt', 'endAt', 'transactionNumber', 'accountNumber', 'bill', 'receipt', 'bond') as $key) {
                if (isset($internet[$key]) && !empty($internet[$key])) {
                    if (in_array($key, array('bill', 'receipt', 'bond'))) {
                        $reqImages = $internet[$key];
                        $imgArr = array();
                        $i = 0;
                        foreach ($reqImages as $img) {
                            $i++;
                            $image_data = base64_decode($img);
                            $image_name = $propertyData['propertyName'] . "-" . "internet" . "-" . "$key" . "-" . "$i" . "." . "jpeg";
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
                        $internetData[$key] = $images;
                    } else {
                        $internetData[$key] = $internet[$key];
                    }
                }
            }
            $wpdb->insert($internetTable, $internetData);
        }

        // Notification table data
        $notificationTable = $wpdb->prefix . 'alkamal_notification';
        $notificationData = array();
        $notificationData['propertyId'] = $propertyId;
        $notificationData['alertTime'] = $body['notificationAlert'];
        $currentTime = date('Y-m-d H:i:s'); // Get current date and time in YYYY-MM-DD HH:II:SS format
        $nextnot = (int) $body['paymentSystem'] - (int) $body['notificationAlert'];
        $twoDaysFromNow = strtotime("+$nextnot days", strtotime($currentTime)); // Add 2 days to the timestamp
        $sqlDateFormat = date('Y-m-d', $twoDaysFromNow); // Format the timestamp as YYYY-MM-DD for SQL
        $notificationData['nextNotificationDate'] = $sqlDateFormat;
        $wpdb->insert($notificationTable, $notificationData);


        return array(
           'propertyId' => $wpdb->insert_id,
           'lastquery' => $wpdb->last_query,
            );
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage(), 401);
    }
}
