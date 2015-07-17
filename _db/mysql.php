<?php

class MySQL {
	// Private PDO object
	private $dbh;

	// Construction
	public function __construct() {
		if ($_SERVER['SERVER_NAME'] == 'localhost') {
			$this->dbh = new PDO('mysql:host=localhost;dbname=beancurdsaigon', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
		}
		else {
			$this->dbh = new PDO('mysql:host=localhost;dbname=beancurdsaigon', 'root', 'admindb', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
		}

		$this->items = array('thread', 'comment', 'reply');
		$this->votes = array('up', 'down');
		$this->user_types = array('fb_id');
	}

	/***************************************************
	 ***************************************************
	 *********************	Query 	********************
	 ***************************************************
	 ***************************************************/
	private function selectFromTable($table, $args = null, $crits = null, $limit = '') {
		$query = 'SELECT ';

		// Criteria
		if($crits == null) {
			$query .= " * from $table ";
		}
		else {
			for($i = 0; $i < count($crits) - 1; $i++) {
				$query .= $crits[$i] . ", ";
			}
			$query .= $crits[$i] . " from $table ";
		}

		// Argument
		if($args != null) {
			$query .= " WHERE ";
			for($i = 0; $i < count($args) - 1; $i++) {
				$query .= $args[$i][0] . " = :_" . $args[$i][0] . " AND ";
			}
			$query .= $args[$i][0] . " = :_" . $args[$i][0];
		}

		$query .= ' '.$limit;

		try {
			$stm = $this->dbh->prepare($query);

			// Argument Binding
			if($args != null) {
				for($i = 0; $i < count($args); $i++) {
					$stm->bindValue(':_'.$args[$i][0], $args[$i][1], PDO::PARAM_INT);
				}
			}

			$stm->execute();
			return $stm->fetchAll();
		}
		catch(PDOException $e) {
		    echo $e->getMessage();
		}

		// No result
		return null;
	}


	/***************************************************
	 ***************************************************
	 *********************	Insert 	********************
	 ***************************************************
	 ***************************************************/

	private function insertIntoTable($table, $args = null) {
		$query = 'INSERT INTO ' . $table . '(';

		for($i = 0; $i < count($args) - 1; $i++) {
			$query .= $args[$i][0] . ", ";
		}
		$query .= $args[$i][0] . ")";

		// Argument
		if($args != null) {
			$query .= ' VALUES(';
			for($i = 0; $i < count($args) - 1; $i++) {
				$query .= ':_' . $args[$i][0] . ", ";
			}
			$query .= ':_' . $args[$i][0] . ")";
		}

		try {
			$stm = $this->dbh->prepare($query);

			// Param Binding
			if($args != null) {
				for($i = 0; $i < count($args); $i++) {
					$stm->bindParam(':_'.$args[$i][0], $args[$i][1], PDO::PARAM_INT);
				}
			}

			$stm->execute();
			return $this->dbh->lastInsertId('id');
		}
		catch(PDOException $e) {
		    echo $e->getMessage();
		}

		// No result
		return -1;
	}

    public function getAllCategoriesForCompany($comp_id) {
        $result = $this->selectFromTable('ind_com', array(array('company', $comp_id)));
        return $this->selectFromTable('category_type', array(array('industry', $result[0]['industry'])));
    }

	// Insert into reply
	public function createOrder($name, $address, $phone, $email, $phone, $message, $order_date,
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
                array('date_deliver', $order_date.':00'),
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

		return $contact_id;
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
				$query .= $args[$i][0] . "=?, ";
			}
			$query .= $args[$i][0] . "=? ";
		}

		// Argument
		if($crits != null) {
			$query .= ' WHERE ';
			for($i = 0; $i < count($crits) - 1; $i++) {
				$query .= $crits[$i][0] . "=? ";
			}
			$query .= $crits[$i][0] . "=?";
		}

		try {
			$stm = $this->dbh->prepare($query);

			// Param Binding
			$values = array();
			foreach ($args as $arg) {
				$values[] = $arg[1];
			}
			foreach ($crits as $crit) {
				$values[] = $crit[1];
			}

			$stm->execute($values);
			return true;
		}
		catch(PDOException $e) {
		    echo $e->getMessage();
		}

		// No result
		return false;
	}

	/***************************************************
	 ***************************************************
	 *********************	Delete 	********************
	 ***************************************************
	 ***************************************************/

	private function deleteFromTable($table, $crits) {
		$query = 'DELETE FROM ' . $table;

		// Argument
		if($crits != null) {
			$query .= ' WHERE ';
			for($i = 0; $i < count($crits) - 1; $i++) {
				$query .= $crits[$i][0] . '= :_' . $crits[$i][0] . ' AND ';
			}
			$query .= $crits[$i][0] . '= :_' . $crits[$i][0];
		}

		// return $query;

		try {
			$stm = $this->dbh->prepare($query);

			// Param Binding
			$values = array();
			foreach ($crits as $crit) {
				$values['_'.$crit[0]] = $crit[1];
			}

			$stm->execute($values);
			return true;
		}
		catch(PDOException $e) {
		    echo $e->getMessage();
		}

		// No result
		return false;
	}

	// Destruction
	public function __destruct() {
		$this->dbh = null;
	}
}