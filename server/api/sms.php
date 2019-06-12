<?php
    require_once("./config.php");

    $con = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);

    if (!$con) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $method = $_SERVER['REQUEST_METHOD'];
    switch ($method) {
        case 'GET':
            $sql = "select * from sms";
            break;
        case 'POST':
            $sms_text = $_POST["sms_text"];
            $sms_count = $_POST["sms_count"];

            $sql = "insert into contacts (sms_text, sms_count) values ('$sms_text', '$sms_count')";
            break;
    }

    $result = mysqli_query($con,$sql);

    if (!$result) {
        http_response_code(404);
        die(mysqli_error($con));
    } else {
        echo json_encode($result);
    }

    $con->close();
?>
