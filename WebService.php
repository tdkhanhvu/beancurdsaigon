<?php
    require('mysql.php');
    $result = array();
    $mysql = new MySQL();
    $request = "GetOrders";

    if (isset($_POST['request']))
        $request = $_POST['request'];

    switch($request) {
        case "GetOrders":
            $result = $mysql->getOrders(null);
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
        case "GetOrderByStaff":
            $result = $mysql->getOrders($_POST['id']);
            break;
        case "CreateOrder":
            $result = $mysql->createOrder($_POST['name'],$_POST['address'],$_POST['phone'],
                $_POST['email'], $_POST['phone'], $_POST['message'], $_POST['date_schedule'],
                json_decode($_POST['products'], true));
            break;
        case "UpdateOrder":
            $result = $mysql->updateOrder($_POST['order_id'], $_POST['staff_id'], $_POST['status']);
            break;
        case "UpdateStaff":
            $result = $mysql->updateStaff($_POST['id'], $_POST['name'], $_POST['image']
                , $_POST['phone'], $_POST['available']);
            break;
        case "CalculateCost":
            $result = $mysql->calculateCost(json_decode($_POST['products'], true));
        default:
            break;
    }

    echo json_encode($result);
?>