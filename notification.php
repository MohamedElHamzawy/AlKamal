<?php
function sendunpaidnotfication()
{
    global $wpdb;
    $tableProperty = $wpdb->prefix . "alkamal_property";
    $sql = "SELECT propertyName FROM $tableProperty WHERE paymentStatus = 'unpaid'";
    $resultProperty = $wpdb->get_results($sql);
    $notBody = "You have " . count($resultProperty) . " unpaid properties. Tap to check them out.";

    $tableUser = $wpdb->prefix . "alkamal_user";
    $resultUser = $wpdb->get_results("SELECT * FROM $tableUser");
    foreach ($resultUser as $user) {
        $token = $user->token;
        $data = array(
            "priority" => "high",
            "data" => array(
                "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                "body" => $notBody,
                "title" => "قوافل الكمال",
                "status" => 'done',
                'screen' => "PropertiesView"
            ),
            "notification" => array(
                "android_channel_id" => "high_importance_channel",
                "body" => $notBody,
                "title" => "قوافل الكمال",
                "sound" => "default",
                "playSound" => true,
            ),
            "to" => $token,

        );
        $data_string = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: key=AAAAmHNAqYA:APA91bE4BOu8gBo5hbTqYHnQZswUfOfcQZW3eD3UaH_3gKDu0Ufx6pxZmw7cotCm96ZQnRv3oz6hn-Rn9Prz8hSo96Fg5InbJean6BySbGm3fNAInKSNCjpSAD_OZBbkNaC97Nnz5Ski'
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        $result = curl_exec($ch);
    }
}