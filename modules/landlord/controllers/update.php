<?php

function updateLandlord($body)
{

    $lord = array();
    global $wpdb;
    $landlordTable = $wpdb->prefix . 'alkamal_landlord';
    $landlord = $wpdb->get_row("SELECT * FROM $landlordTable WHERE id = " . $body['id']);
    if (!$landlord) {
        return array(
            'landlord not found' => "Landlord : " . $body['id'] . " not found",
            'status' => '200'
        );
    } else {
        if (isset($body['name']) && !empty($body['name'])) {
            $lord["name"] = $body['name'];
        }
        if (isset($body['phone']) && !empty($body['phone'])) {
            $lord["phone"] = $body['phone'];
        }
        if (isset($body['email']) && !empty($body['email'])) {
            $lord["email"] = $body['email'];
        }
        if (isset($body['image']) && !empty($body['image'])) {
            
            $reqImages = $body['image'];
            $oldImgId = $landlord->image;
            wp_delete_attachment($oldImgId);
            $imgArr = array();
            $i = 0;
            foreach ($reqImages as $img) {
                $i++;
                $image_data = base64_decode($img);
                $image_name = $landlord->name . "-" . "1" . "." . "jpeg";
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
            $lord["image"] = $images;
            $wpdb->update($landlordTable, $lord, array('id' => $body['id']));

        }
        if (isset($body['propertyId']) && !empty($body['propertyId'])) {
            $propertyTable = $wpdb->prefix . 'alkamal_property';
            $data = array('landlordId' => $body['id']);
            $where = array('id' => $body['propertyId']);
            $wpdb->update($propertyTable, $data, $where);
        }
        
    }

    return array(
        'message' => 'Landlord has been updated successfully',
        "landlord" => $lord,
        "propertyId" => $body['propertyId']
    );
}
