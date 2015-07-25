<?php
ini_set('display_errors', 1);
require('mysql.php');
$mysql = new MySQL();

echo '<pre>';
print_r($mysql->getProducts());
echo '</pre>';
?>
	