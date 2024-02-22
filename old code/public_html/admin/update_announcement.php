<?php
include('../includes/session.php');
include('../includes/config.php');

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract and sanitize input
    $announcementId = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $newContent = isset($_POST['content']) ? mysqli_real_escape_string($conn, $_POST['content']) : '';

    // Validate the input
    if ($announcementId > 0 && !empty($newContent)) {
        // Update the announcement in the database using a prepared statement
        $updateQuery = "UPDATE announcements SET message = ? WHERE id = ?";
        $statement = mysqli_prepare($conn, $updateQuery);

        if ($statement) {
            mysqli_stmt_bind_param($statement, 'si', $newContent, $announcementId);

            if (mysqli_stmt_execute($statement)) {
                // If the update is successful, send a success response
                echo "Announcement updated successfully!";
            } else {
                // Handle the error, if any
                echo "Error updating announcement: " . mysqli_error($conn);
            }

            mysqli_stmt_close($statement);
        }
    } else {
        // Handle invalid input
        echo "Invalid input. Please provide valid data.";
    }
} else {
    // Handle invalid request method
    echo "Invalid request method. Please use POST.";
}

// Close the database connection
$conn->close();
?>
