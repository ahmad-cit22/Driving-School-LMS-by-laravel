<?php
function send_sms($number, $message) {
    $url = "https://msg.elitbuzz-bd.com/smsapi";
    $data = [
        "api_key" => getenv("SMS_API"),
        "type" => "unicode",
        "contacts" => $number,
        "senderid" => getenv("SENDER_ID"),
        "msg" => $message,
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function bangla_digit($digit) {
    return str_replace(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'], $digit);
}

function generate_id_no($id) {
    return '#' . substr(uniqid(), 5, 5) . $id;
}
