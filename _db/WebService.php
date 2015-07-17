<?php
    include('mysql.php');

    $request = "CreateOrder";

    if (isset($_POST['request']))
        $request = $_POST['request'];

    $mysql = new MySQL();
    $result = array();

    switch($request) {
        case "CreateOrder":
            $result = $mysql->createOrder($_POST['name'],$_POST['address'],$_POST['phone'],
                $_POST['email'], $_POST['phone'], $_POST['message'], $_POST['order_date'],
                $_POST['products']);
            break;
        default:
            break;
    }

    echo json_encode($result);

?>