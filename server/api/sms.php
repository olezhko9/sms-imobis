<?php
    require_once("../config.php");
    require_once("../models/sms.php");

    $con = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);

    if (!$con) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $method = $_SERVER['REQUEST_METHOD'];
    switch ($method) {
        case 'GET':
            echo get_all_sms($con);
            break;
        case 'POST':
            $sms_text = $_POST["sms_text"];
            $sms_count = $_POST["sms_count"];
            echo save_sms($con, $sms_text, $sms_count);
            break;
    }

    $con->close();
?>
