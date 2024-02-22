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

    // Validate the input
    if ($announcementId > 0) {
        // Perform the deletion
        $deleteQuery = "DELETE FROM announcements WHERE id = ?";
        $statement = mysqli_prepare($conn, $deleteQuery);

        if ($statement) {
            mysqli_stmt_bind_param($statement, 'i', $announcementId);

            if (mysqli_stmt_execute($statement)) {
                // Deletion successful
                echo "Announcement deleted successfully!";

                // Add cache control headers
                header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
                header("Pragma: no-cache");
                header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Past date to encourage expiration
            } else {
                // Deletion failed
                echo "Error deleting announcement: " . mysqli_error($conn);
            }

            mysqli_stmt_close($statement);
        }
    } else {
        // Handle invalid input
        echo "Invalid input. Please provide a valid announcement ID.";
    }
} else {
    // Handle invalid request method
    echo "Invalid request method. Please use POST.";
}

// Close the database connection
$conn->close();
?>
