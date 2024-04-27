<?php


// function save_image( $base64_img, $title ) {

// 	// Upload dir.
// 	$upload_dir  = wp_upload_dir();
// 	$upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

// 	$img             = str_replace( 'data:image/jpeg;base64,', '', $base64_img );
// 	$img             = str_replace( ' ', '+', $img );
// 	$decoded         = base64_decode( $img );
// 	$filename        = $title . '.jpeg';
// 	$file_type       = 'image/jpeg';
// 	$hashed_filename = md5( $filename . microtime() ) . '_' . $filename;

// 	// Save the image in the uploads directory.
// 	$upload_file = file_put_contents( $upload_path . $hashed_filename, $decoded );

// 	$attachment = array(
// 		'post_mime_type' => $file_type,
// 		'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $hashed_filename ) ),
// 		'post_content'   => '',
// 		'post_status'    => 'inherit',
// 		'guid'           => $upload_dir['url'] . '/' . basename( $hashed_filename )
// 	);

// 	$attach_id = wp_insert_attachment( $attachment, $upload_dir['path'] . '/' . $hashed_filename );
// }




function createLandlord($data){

    global $wpdb;

 $img = $data['image'];

 if(!empty($img)){
        $image_data = base64_decode($img);
        $image_name = $data['name'] . "-" . "photo" . "." . "jpeg";
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
}

    $landlordTable = $wpdb->prefix . 'alkamal_landlord';
    $propertyTable = $wpdb->prefix . 'alkamal_property';
    $landlord = array(
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'image' => $attachment_id

    );

    $wpdb->insert($landlordTable, $landlord);
    $landlordID = $wpdb->insert_id;


    // $imageName = $landlord['name'] . "-" . "1" . "." . "jpeg";
    // save_image($data['image'], $data['name']);



    $wpdb->update($propertyTable, array('landlordId' => $landlordID) , array('id' => $data['propertyId']));
    return array(
        'id' => $landlordID,
        'name' => $landlord['name'],
        'email' => $landlord['email'],
        'phone' => $landlord['phone'],
        'image' => $landlord['image'],
        'message' => 'Landlord has been created successfully'
    );
}

