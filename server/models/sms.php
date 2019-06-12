<?php

function get_all_sms($con) {
    $query = "SELECT * FROM sms";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die(mysqli_error($con));
    }

    $response = array();
    for ($i = 0; $i < mysqli_num_rows($result); $i++) {
        $row = mysqli_fetch_assoc($result);
        $response[] = $row;
    }

    return json_encode($response);
}

function save_sms($con, $sms_text, $sms_count) {
    $query = "insert into sms (sms_text, sms_count) values ('$sms_text', '$sms_count')";
    sprintf("INSERT INTO sms (sms_text, sms_count) VALUES ('%s', '%d')",
        mysqli_real_escape_string($con, sms_text), $sms_count);
    $result = mysqli_query($con, $query);

    if (!$result) {
        die(mysqli_error($con));
    }

    return json_encode($result);
}
?>
