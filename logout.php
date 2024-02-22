<?php
include('includes/config.php');


session_start();

$id=$_SESSION['alogin'];

$update = "UPDATE tblemployees SET is_active=0 WHERE emp_id='$id'";
mysqli_query($conn, $update);



$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 60*60,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}






unset($_SESSION['alogin']);
session_destroy(); // destroy session
header("location:index.php"); 


