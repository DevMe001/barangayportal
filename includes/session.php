<?php
// Start session at the beginning of your script
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check whether the session variable SESS_MEMBER_ID is present or not
if (!isset($_SESSION['alogin']) || empty($_SESSION['alogin'])) {
    header("Location: ../index.php");
    exit();
}

$session_id = $_SESSION['alogin'];
$session_depart = $_SESSION['arole'];
?>
