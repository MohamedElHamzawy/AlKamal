<?php
function createProperty($body)
{
    global $wpdb;

    $propertyData = array();
    $propertyTable = $wpdb->prefix . 'alkamal_property';

    foreach (array('title', 'address', 'area', 'status', 'startAt', 'endAt', 'images', 'rentValue', 'depositValue', 'meterPrice', 'paperContractNumber', 'digitlyContractNumber', 'insurance', 'commission', 'annualIncrease') as $key) {
        if (isset($body[$key]) && !empty($body[$key])) {
            // if ($key == 'images') {
            //     $reqImages = $body[$key];
            //     $imgArr = array();
            //     $i = 0;
            //     foreach ($reqImages as $img) {
            //         $i++;
            //         $parts = explode(',', $img);
            //         if (count($parts) != 2) {
            //             return new WP_Error(
            //                 'rest_invalid_image',
            //                 'Invalid image data',
            //                 array('status' => 400)
            //             );
            //         }
            //         $image_header = $parts[0];
            //         $image_data = base64_decode($parts[1]);

            //         $image_info = explode(';', $image_header);
            //         if (count($image_info) != 2) {
            //             return new WP_Error(
            //                 'rest_invalid_image_header',
            //                 'Invalid image header',
            //                 array('status' => 400)
            //             );
            //         }
            //         $mime_type = explode(':', $image_info[0]);
            //         if (count($mime_type) != 2) {
            //             return new WP_Error(
            //                 'rest_invalid_image_mime',
            //                 'Invalid image mime type',
            //                 array('status' => 400)
            //             );
            //         }
            //         $extension = str_replace('image/', '', $mime_type[1]);
            //         $image_name = $propertyData['title'] . "-" . "$i" . "." . "$extension";
            //         $temp_file = wp_tempnam($image_name);
            //         if (file_put_contents($temp_file, $image_data) === FALSE) {
            //             return new WP_Error(
            //                 'rest_image_save_error',
            //                 'Failed to save image',
            //                 array('status' => 500)
            //             );
            //         }

            //         $file_array = array(
            //             'name' => $image_name,
            //             'type' => $mime_type[1],
            //             'tmp_name' => $temp_file,
            //             'error' => 0,
            //             'size' => filesize($temp_file)
            //         );
            //         $attachment_id = media_handle_sideload($file_array, 0);
            //         if (is_wp_error($attachment_id)) {
            //             return new WP_Error(
            //                 'rest_image_handle_error',
            //                 'Failed to handle image',
            //                 array('status' => 500)
            //             );
            //         }
            //         $attachment_data = wp_generate_attachment_metadata($attachment_id, $temp_file);
            //         if (is_wp_error($attachment_data)) {
            //             return new WP_Error(
            //                 'rest_image_metadata_error',
            //                 'Failed to generate image metadata',
            //                 array('status' => 500)
            //             );
            //         }
            //         wp_update_attachment_metadata($attachment_id, $attachment_data);
            //         if (unlink($temp_file) === FALSE) {
            //             return new WP_Error(
            //                 'rest_image_delete_error',
            //                 'Failed to delete temporary image',
            //                 array('status' => 500)
            //             );
            //         }
            //         array_push($imgArr, $attachment_id);
            //     }
            //     $images = implode(',', $imgArr);
            //     $propertyData[$key] = $images;
            // } else {
            $propertyData[$key] = $body[$key];
            // }
        }
    }
    $propertyData['electricity'] = $body['electricity'];
    $propertyData['internet'] = $body['internet'];

    return $propertyData;

    // try {
    // $wpdb->insert($propertyTable, $propertyData);
    // $propertyId = $wpdb->insert_id;

    // if (isset($body['electricity']) && !empty($body['electricity'])) {
    //     $electricityTable = $wpdb->prefix . 'alkamal_electricity';
    //     foreach ($body['electricity'] as $electricity) {
    //         $electricityData = array();
    //         $electricityData['propertyId'] = $propertyId;
    //         foreach (array('sourceOfElectricity', 'electricCounterNumber', 'accountNumber', 'bill', 'receipt', 'bond') as $key) {
    //             if (isset($electricity[$key]) && !empty($electricity[$key])) {
    //                 if (in_array($key, array('bill', 'receipt', 'bond'))) {
    //                     $reqImages = $body[$key];
    //                     $imgArr = array();
    //                     $i = 0;
    //                     foreach ($reqImages as $img) {
    //                         $i++;
    //                         $parts = explode(',', $img);
    //                         $image_header = $parts[0];
    //                         $image_data = base64_decode($parts[1]);

    //                         $image_info = explode(';', $image_header);
    //                         $mime_type = explode(':', $image_info[0])[1];
    //                         $extension = str_replace('image/', '', $mime_type);
    //                         $image_name = $electricityData['electricCounterNumber'] . "-" . "$i" . "." . "$extension";
    //                         $temp_file = wp_tempnam($image_name);
    //                         file_put_contents($temp_file, $image_data);

    //                         $file_array = array(
    //                             'name' => $image_name,
    //                             'type' => $mime_type,
    //                             'tmp_name' => $temp_file,
    //                             'error' => 0,
    //                             'size' => filesize($temp_file)
    //                         );
    //                         $attachment_id = media_handle_sideload($file_array, 0);
    //                         $attachment_data = wp_generate_attachment_metadata($attachment_id, $temp_file);
    //                         wp_update_attachment_metadata($attachment_id, $attachment_data);
    //                         unlink($temp_file);
    //                         array_push($imgArr, $attachment_id);
    //                     }
    //                     $images = implode(',', $imgArr);
    //                     $electricityData[$key] = $images;
    //                 } else {
    //                     $electricityData[$key] = $electricity[$key];
    //                 }
    //             }
    //         }
    //         $wpdb->insert($electricityTable, $electricityData);
    //     }
    // }

    // if (isset($body['internet']) && !empty($body['internet'])) {
    //     $internetTable = $wpdb->prefix . 'alkamal_internet';
    //     foreach ($body['internet'] as $internet) {
    //         $internetData = array();
    //         $internetData['propertyId'] = $propertyId;
    //         foreach (array('internetCompany', 'startAt', 'endAt', 'transactionNumber', 'bill', 'receipt', 'bond') as $key) {
    //             if (isset($internet[$key]) && !empty($internet[$key])) {
    //                 if (in_array($key, array('bill', 'receipt', 'bond'))) {
    //                     $reqImages = $body[$key];
    //                     $imgArr = array();
    //                     $i = 0;
    //                     foreach ($reqImages as $img) {
    //                         $i++;
    //                         $parts = explode(',', $img);
    //                         $image_header = $parts[0];
    //                         $image_data = base64_decode($parts[1]);

    //                         $image_info = explode(';', $image_header);
    //                         $mime_type = explode(':', $image_info[0])[1];
    //                         $extension = str_replace('image/', '', $mime_type);
    //                         $image_name = $internetData['internetCompany'] . "-" . "$i" . "." . "$extension";
    //                         $temp_file = wp_tempnam($image_name);
    //                         file_put_contents($temp_file, $image_data);

    //                         $file_array = array(
    //                             'name' => $image_name,
    //                             'type' => $mime_type,
    //                             'tmp_name' => $temp_file,
    //                             'error' => 0,
    //                             'size' => filesize($temp_file)
    //                         );
    //                         $attachment_id = media_handle_sideload($file_array, 0);
    //                         $attachment_data = wp_generate_attachment_metadata($attachment_id, $temp_file);
    //                         wp_update_attachment_metadata($attachment_id, $attachment_data);
    //                         unlink($temp_file);
    //                         array_push($imgArr, $attachment_id);
    //                     }
    //                     $images = implode(',', $imgArr);
    //                     $internetData[$key] = $images;
    //                 } else {
    //                     $internetData[$key] = $internet[$key];
    //                 }
    //             }
    //         }

    //         $wpdb->insert($internetTable, $internetData);
    //     }
    // }

    //     wp_send_json_success("Property created successfully", 200);
    // } catch (Exception $e) {
    //     wp_send_json_error($e->getMessage(), 401);
    // }
}
