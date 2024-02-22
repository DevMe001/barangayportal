<?php
// Include your database connection code here

// Establish a database connection. Replace with your actual database connection code.
$servername = "your_db_server";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "your_db_name";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query the database for new requests
$sql = "SELECT COUNT(*) as count FROM tblrequest WHERE Status = 0"; // Assuming 0 represents pending requests
$query = mysqli_query($conn, $sql);

if (!$query) {
    die("Error in SQL query: " . mysqli_error($conn));
}

$result = mysqli_fetch_assoc($query);

// Close the database connection
mysqli_close($conn);

// Return the result as JSON
header('Content-Type: application/json');
echo json_encode($result);
