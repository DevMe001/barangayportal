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
    $content = isset($_POST['content']) ? mysqli_real_escape_string($conn, $_POST['content']) : '';

    // Validate the input
    if (!empty($content)) {
        // Assuming 'admin' should have a specific value (replace 'default_value' with the desired value)
        $adminValue = 'default_value';

        // Insert the announcement into the database using a prepared statement
        $insertQuery = "INSERT INTO announcements (message, admin) VALUES (?, ?)";
        $statement = mysqli_prepare($conn, $insertQuery);

        if ($statement) {
            mysqli_stmt_bind_param($statement, 'ss', $content, $adminValue);

            if (mysqli_stmt_execute($statement)) {
                // If the insertion is successful, fetch the last inserted announcement
                $lastInsertId = mysqli_insert_id($conn);
                $selectQuery = "SELECT * FROM announcements WHERE id = $lastInsertId";
                $result = mysqli_query($conn, $selectQuery);
                $newAnnouncement = mysqli_fetch_assoc($result);

                // Send the new announcement data as JSON for AJAX handling
                $response = array('success' => true, 'message' => 'Announcement added successfully!', 'data' => $newAnnouncement);
                echo json_encode($response);
            } else {
                // Handle the error, if any
                echo "Error: " . mysqli_error($conn);
            }

            mysqli_stmt_close($statement);
        }
    } else {
        // Handle invalid input
        $response = array('success' => false, 'message' => 'Invalid input. Please provide valid data.');
        echo json_encode($response);
    }
} else {
    // Handle invalid request method
    $response = array('success' => false, 'message' => 'Invalid request method. Please use POST.');
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
