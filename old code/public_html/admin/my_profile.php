<?php
session_start();

// Check if the user is logged in (user session is set)
if (isset($_SESSION['user_data'])) {
    $userData = $_SESSION['user_data'];
    $username = $userData['username'];

    // Display a success message
    echo "Welcome, $username! You are successfully logged in.";
} else {
    // If the user session is not set, redirect to the login page
    header('Location: login.php');
    exit;
}
?>
