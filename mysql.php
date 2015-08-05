<?php
require_once('./email/mail.php');
require_once('./email/sendMail.php');

class MySQL {
	// Private PDO object
    private $mysqli;
    private $email;

	// Construction
	public function __construct() {
        date_default_timezone_set('Asia/Saigon');
        if ($_SERVER['SERVER_NAME'] == 'localhost') {
            $this->mysqli = mysqli_connect('localhost', 'root', '', 'beancurdsaigon');
        }
        else {
            $this->mysqli = mysqli_connect('toibalocom.ipagemysql.com', 'beancurdsaigon', 'beancurdsaigon', 'beancurdsaigon');
        }

        /*
         * This is the "official" OO way to do it,
         * BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
         */
        if ($this->mysqli->connect_error) {
            die('Connect Error (' . $this->mysqli->connect_errno . ') '
                . $this->mysqli->connect_error);
        }

        /*
         * Use this instead of $connect_error if you need to ensure
         * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
         */
        if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
        }

        $this->email = new SendMail;
	}

	/***************************************************
	 ***************************************************
	 *********************	Query 	********************
	 ***************************************************
	 ***************************************************/
    public function selectFromTable($table, $args = null, $crits = null, $limit = '',
                                    $order='') {
        $query = 'SELECT ';

        // Criteria
        if ($crits == null) {
            $query .= "* from $table ";
        }
        else {
            for($i = 0; $i < count($crits) - 1; $i++) {
                $query .= $crits[$i] . ", ";
            }
            $query .= $crits[$i] . " from $table ";
        }

        // Argument
        if ($args != null) {
            $query .= ' WHERE ';
            for($i = 0; $i < count($args) - 1; $i++) {
                $query .= $args[$i][0] . ' = "' . $args[$i][1] . '"" AND ';
            }
            $query .= $args[$i][0] . ' = "' . $args[$i][1] . '"';
        }
        if ($order != '') {
            $query .= ' ORDER BY '.$order;
        }

        $query .= ' '.$limit;

        $data = array();

        /* Select queries return a resultset */
        if ($result = $this->mysqli->query($query)) {
            while ($row = $result->fetch_array())
            {
                $data[] = $row;
            }

            /* free result set */
            $result->close();
        }

        // No result
        return $data;
    }


	/***************************************************
	 ***************************************************
	 *********************	Insert 	********************
	 ***************************************************
	 ***************************************************/

    private function insertIntoTable($table, $args = null) {
        $query = 'INSERT INTO ' . $table . '(';

        for($i = 0; $i < count($args) - 1; $i++) {
            $query .= $args[$i][0] . ', ';
        }
        $query .= $args[$i][0] . ')';

        // Argument
        if ($args != null) {
            $query .= ' VALUES(';
            for($i = 0; $i < count($args) - 1; $i++) {
                $query .= '"' . $args[$i][1] . '", ';
            }
            $query .= '"' . $args[$i][1] . '")';
        }

        if ($this->mysqli->query($query)){
            return $this->mysqli->insert_id;
        }
        else {
            return -1;
        }
    }

    public function getAllStatus() {
        return $this->selectFromTable('status',null,null,'', '');
    }

    public function getAllStaffs() {
        return $this->selectFromTable('staff',null,null,'', '');
    }

    public function getOrders() {
        $orders = $this->selectFromTable('orders',null,null,'', ' id DESC');
        $result = array();

        foreach ($orders as $order) {
            $el = array();
            foreach(array('id','date_create','date_schedule','date_deliver',
                        'staff_id','message', 'status', 'beancurd_cost',
                        'delivery_cost', 'discount_cost', 'total_cost') as $attr) {
                $el[$attr] = $order[$attr];
            }

            $temp = $this->selectFromTable('contact', array(array('id', $order['contact_id'])));
            $contact = $temp[0];
            foreach(array('id','name','email','address','phone') as $attr) {
                $el['contact_'.$attr] = $contact[$attr];
            }

            $staffs = $this->selectFromTable('staff', array(array('id', $order['staff_id'])));
            if (sizeof($staffs) > 0) {
                $staff = $staffs[0];
                foreach(array('name','image','phone') as $attr) {
                    $el['staff_'.$attr] = $staff[$attr];
                }
            }

            $products = array();
            $product_list = $this->selectFromTable('order_product', array(array('order_id', $order['id'])));

            foreach($product_list as $product_item) {
                $product = array();
                $temp = $this->selectFromTable('product', array(array('id', $product_item['product_id'])));
                $product_info = $temp[0];

                $product['quantity'] = $product_item['quantity'];
                $product['price'] = $product_item['price'];
                $product['name'] = $product_info['name'];

                array_push($products, $product);
            }
            $el['products'] = $products;
            array_push($result, $el);
        }
        return $result;
    }

    public function getProducts() {
        return $this->selectFromTable('product',null,null,'', ' id DESC');
    }

    public function calculateCost($products) {
        $delivery_cost = 0;
        $discount_cost = 0;

        $beancurd_cost = 0;
        foreach ($products as $product) {
            $temp = $this->selectFromTable('product', array(array('id', $product['id'])));
            $product_info = $temp[0];
            $beancurd_cost += $product['quantity'] * $product_info['price'];
        }

        if ($beancurd_cost > 0)
            $delivery_cost = 20000;

        if ($beancurd_cost > 150000)
            $discount_cost = $beancurd_cost / 10;

        $total_cost = $beancurd_cost + $delivery_cost - $discount_cost;

        $result = array();
        $result['beancurd_cost'] = $beancurd_cost;
        $result['delivery_cost'] = $delivery_cost;
        $result['discount_cost'] = $discount_cost;
        $result['total_cost'] = $total_cost;

        return $result;
    }
	// Insert into reply
	public function createOrder($name, $address, $phone, $email, $message, $date_schedule,
            $products) {
        $contact_id = $this->insertIntoTable('contact',
            array(
                array('name', $name),
                array('email', $email),
                array('address', $address),
                array('phone', $phone)
                )
        );

        $costs = $this->calculateCost($products);
        $order_id = $this->insertIntoTable('orders',
            array(
                array('contact_id', $contact_id),
                array('date_create', date('Y-m-d H:i:s')),
                array('date_schedule', date('Y-m-d ').$date_schedule.':00'),
                array('beancurd_cost', $costs['beancurd_cost']),
                array('delivery_cost', $costs['delivery_cost']),
                array('discount_cost', $costs['discount_cost']),
                array('total_cost', $costs['total_cost']),
                array('message', $message)
            )
        );

        $orders = array();
        foreach ($products as $product) {
            $temp = $this->selectFromTable('product', array(array('id', $product['id'])));
            $product_info = $temp[0];

            $this->insertIntoTable('order_product',
                array(
                    array('order_id', $order_id),
                    array('product_id', $product['id']),
                    array('quantity', $product['quantity']),
                    array('price', $product_info['price'])
                ));
            $order = array();
            $order['image'] =  $product_info['image'];
            $order['price'] = $product_info['price'];
            $order['name'] = $product_info['name'];
            $order['quantity'] = $product['quantity'];
            $order['total'] = $product_info['price'] * $product['quantity'];

            array_push($orders, $order);
        }

        $this->email->sendOrderPlacedMail($name, $email, $phone, $address, $date_schedule,
            $costs['delivery_cost'], $costs['discount_cost'], $costs['total_cost'], $orders);
		return 1;
    }


	/***************************************************
	 ***************************************************
	 *********************	Update 	********************
	 ***************************************************
	 ***************************************************/

    private function updateTable($table, $args = null, $crits = null) {
        $query = 'UPDATE ' . $table . ' SET ';

        if ($args != null) {
            for($i = 0; $i < count($args) - 1; $i++) {
                $query .= $args[$i][0] . ' = "' . $args[$i][1] . '", ';
            }
            $query .= $args[$i][0] . ' = "' . $args[$i][1] . '"';
        }

        // Argument
        if ($crits != null) {
            $query .= ' WHERE ';
            for($i = 0; $i < count($crits) - 1; $i++) {
                $query .= $crits[$i][0] . ' = "' . $crits[$i][1] . '" AND ';
            }
            $query .= $crits[$i][0] . ' = "' . $crits[$i][1] . '"';
        }

        $results = $this->mysqli->query($query);
        if ($results){
            return true;
        }
        else {
            return false;
        }
    }

    public function updateOrder($orderId, $staffId, $status, $date_deliver) {
        $this->updateTable('orders', array(array('staff_id', $staffId),array('status',$status)),
                          array(array('id', $orderId)), array(array('date_deliver', $date_deliver)));

        $temp = $this->selectFromTable('orders', array(array('id', $orderId)));
        $order = $temp[0];

        $temp = $this->selectFromTable('contact', array(array('id', $order['contact_id'])));
        $contact = $temp[0];

        $temp = $this->selectFromTable('staff', array(array('id', $order['staff_id'])));
        $staff = $temp[0];

        $order_products = $this->selectFromTable('order_product', array(array('order_id',
                            $order['id'])));

        $orders = array();

        foreach($order_products as $order_product){
            $temp = $this->selectFromTable('product', array(array('id', $order_product['product_id'])));
            $product_info = $temp[0];

            $order_temp = array();
            $order_temp['image'] =  $product_info['image'];
            $order_temp['price'] = $order_product['price'];
            $order_temp['name'] = $product_info['name'];
            $order_temp['quantity'] = $order_product['quantity'];
            $order_temp['total'] = $order_product['price'] * $order_product['quantity'];
            array_push($orders, $order_temp);
        }

        if ($status == 1)
        $this->email->sendOrderDeliveringMail($contact['name'], $contact['email'], $contact['phone'],
            $contact['address'], $order['date_schedule'], $order['delivery_cost'],
            $order['discount_cost'], $order['total_cost'], $orders, $staff);
        else if ($status == 2)
            $this->email->sendOrderDeliveredMail($order['id'], $contact['name'], $contact['email'],
                $contact['phone'], $contact['address'], $order['date_deliver'], $order['delivery_cost'],
                $order['discount_cost'], $order['total_cost'], $orders, $staff);
        return 1;
    }

    public function updateStaff($id, $name, $image, $phone, $available) {
        $this->updateTable('staff', array(array('name',$name),array('image', $image),
                array('phone', $phone),array('available', $available)),
            array(array('id', $id)));

        return 1;
    }
	/***************************************************
	 ***************************************************
	 *********************	Delete 	********************
	 ***************************************************
	 ***************************************************/

    private function deleteFromTable($table, $crits) {
        $query = 'DELETE FROM ' . $table;

        // Argument
        if ($crits != null) {
            $query .= ' WHERE ';
            for($i = 0; $i < count($crits) - 1; $i++) {
                $query .= $crits[$i][0] . ' = "' . $crits[$i][1] . '" AND ';
            }
            $query .= $crits[$i][0] . ' = "' . $crits[$i][1] . '"';
        }

        if ($this->mysqli->query($query)){
            return true;
        }
        else {
            return false;
        }
    }

    // Destruction
    public function __destruct() {
        $this->dbh = null;
    }
}