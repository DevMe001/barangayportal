<?php
include('includes/header.php');
include('../includes/session.php');
include('../includes/config.php');

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM announcements ORDER BY id DESC LIMIT 5"; // Adjust the query as needed
$result = $conn->query($sql);

$announcements = array();

if ($result) {
    // Check if the query was successful
    if ($result->num_rows > 0) {
        // Fetching data from the result set
        while ($row = $result->fetch_assoc()) {
            $announcements[] = array(
                'id' => $row['id'],  // Add the id field
                'title' => $row['title'],
                'content' => $row['content']
                // Add more fields if needed
            );
        }
    }
} else {
    // Handle query error
    echo "Error executing query: " . $conn->error;
}

// Close the database connection
$conn->close();

// Return announcements as JSON
header('Content-Type: application/json');
echo json_encode($announcements);
?>
