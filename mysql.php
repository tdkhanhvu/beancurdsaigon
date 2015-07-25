<?php

class MySQL {
	// Private PDO object
    private $mysqli;

	// Construction
	public function __construct() {
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
        $result['aaData'] =  array();
        foreach ($orders as $order) {
            $temp = array();
            array_push($temp, $order['id']);
            array_push($temp,$order['contact_id']);
            array_push($temp,$order['date_create']);
            array_push($temp,$order['date_schedule']);
            array_push($temp,$order['date_deliver']);

            array_push($result['aaData'], $temp);
        }
        return $result;
    }

    public function getProducts() {
        return $this->selectFromTable('product',null,null,'', ' id DESC');
    }

	// Insert into reply
	public function createOrder($name, $address, $phone, $email, $phone, $message, $date_schedule,
            $products) {
        $products = json_decode($products, true);
        $contact_id = $this->insertIntoTable('contact',
            array(
                array('name', $name),
                array('email', $email),
                array('address', $address),
                array('phone', $phone)
                )
        );

        $order_id = $this->insertIntoTable('orders',
            array(
                array('contact_id', $contact_id),
                array('date_create', date('Y-m-d H:i:s')),
                array('date_schedule', $date_schedule.':00'),
                array('message', $message)
            )
        );


        foreach ($products as $product) {
            $this->insertIntoTable('order_product',
                array(
                    array('order_id', $order_id),
                    array('product_id', $product['id']),
                    array('quantity', $product['quantity'])
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