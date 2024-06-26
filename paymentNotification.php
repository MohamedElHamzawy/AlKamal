<?php
function sendunpaidnotfication()
{
    global $wpdb;
    $notTable = $wpdb->prefix . "alkamal_notification";
    $propTable = $wpdb->prefix . "alkamal_properties";
    $tableUser = $wpdb->prefix . "alkamal_user";
    $notifications = $wpdb->get_results("SELECT notif.nextNotificationDate , notif.lastNotificationDate , notif.propertyId , notif.id notificationId , notif.alertTime , prop.id propertyId , prop.paymentSystem , prop.propertyName
    FROM $notTable  notif
    INNER JOIN $propTable  prop ON $notTable.propertyId = $propTable.id 
     WHERE prop.isDeleted = 0");
    $notificationInAction  = array();
    foreach ($notifications as $notification) {
        if ($notification->nextNotificationDate = date('Y-m-d')) {
            array_push($notificationInAction, $notification);
        }
    }
    $resultUser = $wpdb->get_results("SELECT * FROM $tableUser");
    foreach ($resultUser as $user) {
        foreach ($notificationInAction as $notification) {
            $notBody = $notification->propertyName . ' Need To Be Paid';
            $title = 'Warning';
            $token = $user->token;
            $data = array(
                "priority" => "high",
                "data" => array(
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                    "body" => $notBody,
                    "title" => $title,
                    "status" => 'done',
                    'apartment' => $notification->propertyId
                ),
                "notification" => array(
                    "android_channel_id" => "high_importance_channel",
                    "body" => $notBody,
                    "title" => $title,
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
            $days = $notification->paymentSystem - $notification->alertTime;
            $nextmonthnotif = date('Y-m-d', strtotime('+{$days} days', strtotime($notification->nextNotificationDate))); 
            $wpdb->update($notTable, array('nextNotificationDate' => $nextmonthnotif , 'lastNotificationDate' => date('Y-m-d')), array('id' => $notification->notificationId));
        }
    }
}
