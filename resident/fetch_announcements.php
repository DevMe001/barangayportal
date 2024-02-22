<?php
include('includes/header.php');
include('../includes/session.php');

// Fetch announcements from the database
$announcementQuery = "SELECT * FROM announcements ORDER BY id DESC";
$announcementResult = mysqli_query($conn, $announcementQuery);
$announcements = mysqli_fetch_all($announcementResult, MYSQLI_ASSOC);

// Return announcements as JSON
header('Content-Type: application/json');
echo json_encode($announcements);
?>