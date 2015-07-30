<?php
    require('mysql.php');
    $result = array();
    $mysql = new MySQL();
    $request = "GetOrders";

    if (isset($_POST['request']))
        $request = $_POST['request'];

    switch($request) {
        case "GetOrders":
            $result = $mysql->getOrders();
            break;
        case "GetAllStatus":
            $result = $mysql->getAllStatus();
            break;
        case "GetAllStaffs":
            $result = $mysql->getAllStaffs();
            break;
        case "GetProducts":
            $result = $mysql->getProducts();
            break;
        case "CreateOrder":
            $result = $mysql->createOrder($_POST['name'],$_POST['address'],$_POST['phone'],
                $_POST['email'], $_POST['phone'], $_POST['message'], $_POST['date_schedule'],
                json_decode($_POST['products'], true));
            break;
        case "CalculateCost":
            $result = $mysql->calculateCost(json_decode($_POST['products'], true));
        default:
            break;
    }

    echo json_encode($result);
?>