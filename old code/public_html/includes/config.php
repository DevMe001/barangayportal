<?php

define('DB_HOST','localhost');
define('DB_USER','id21672546_barangayportal');
define('DB_PASS','Elzxcasd1_');
define('DB_NAME','id21672546_barangayportal');

$conn = mysqli_connect('localhost','id21672546_barangayportal','Elzxcasd1_','id21672546_barangayportal') or die(mysqli_error());

// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}

?>
