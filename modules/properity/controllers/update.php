<?php
function updateProperty($body)
{
    global $wpdb;
    $propertyTable = $wpdb->prefix . 'alkamal_property';

    $property = $wpdb->get_row("SELECT * FROM $propertyTable WHERE id = " . $body['id']);

    if (!$property) {
        return new WP_Error(
            'rest_no_property',
            'Property not found',
            array('status' => 404)
        );
    }

    $propertyData = array();
    foreach (array('propertyName', 'address', 'area', 'status', 'startAt', 'endAt', 'images', 'rentValue', 'depositValue', 'meterPrice', 'paperContractNumber', 'digitlyContractNumber', 'insurance', 'commission', 'annualIncrease') as $key) {
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
            } else {
                $propertyData[$key] = $body[$key];
            }
        }
    }

    $wpdb->update($propertyTable, $propertyData, array('id' => $property->id));

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
    foreach (array('propertyId', 'sourceOfElectricity', 'electricCounterNumber', 'accountNumber', 'bill', 'receipt', 'bond') as $key) {
        if (isset($body[$key]) && !empty($body[$key])) {
            if (in_array($key, array('bill', 'receipt', 'bond'))) {
                $reqImages = $body[$key];
                $imgArr = array();
                foreach (array('bill', 'receipt', 'bond') as $imageType) {
                    if (isset($electricity->{$imageType}) && !empty($electricity->{$imageType})) {
                        $oldImages = explode(',', $electricity->{$imageType});
                        foreach ($oldImages as $oldImage) {
                            wp_delete_attachment($oldImage, false);
                        }
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
                foreach (array('bill', 'receipt', 'bond') as $imageType) {
                    if (isset($internet->{$imageType}) && !empty($internet->{$imageType})) {
                        $oldImages = explode(',', $internet->{$imageType});
                        foreach ($oldImages as $oldImage) {
                            wp_delete_attachment($oldImage, false);
                        }
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
