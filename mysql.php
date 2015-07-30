<?php

class MySQL {
	// Private PDO object
    private $mysqli;

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

    public function getOrders() {
        $orders = $this->selectFromTable('orders',null,null,'', ' id DESC');
        $result = array();

        foreach ($orders as $order) {
            $contact = $this->selectFromTable('contact', array(array('id', $order['contact_id'])))[0];
            $el = array();
            foreach(['id','date_create','date_schedule','date_deliver',
                        'staff_id','message', 'status'] as $attr) {
                $el[$attr] = $order[$attr];
            }
            $el['contact_id'] = $contact['id'];
            $el['contact_name'] = $contact['name'];
            $el['contact_email'] = $contact['email'];
            $el['contact_address'] = $contact['address'];
            $el['contact_phone'] = $contact['phone'];

            $products = array();
            $product_list = $this->selectFromTable('order_product', array(array('order_id', $order['id'])));

            foreach($product_list as $product_item) {
                $product = array();
                $product_info = $this->selectFromTable('product', array(array('id', $product_item['product_id'])))[0];

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
            $product_info = $this->selectFromTable('product', array(array('id', $product['id'])))[0];
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
	public function createOrder($name, $address, $phone, $email, $phone, $message, $date_schedule,
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


        foreach ($products as $product) {
            $product_info = $this->selectFromTable('product', array(array('id', $product['id'])))[0];

            $this->insertIntoTable('order_product',
                array(
                    array('order_id', $order_id),
                    array('product_id', $product['id']),
                    array('quantity', $product['quantity']),
                    array('price', $product_info['price'])
                ));
        }

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