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


    $signatureDataUrl = $_POST['signature'];
    $daysUntil = $_POST['validUntil'];

    // Create the signatures_uploads directory if it doesn't exist
    $uploadsDirectory = 'signatures_uploads/';
    if (!file_exists($uploadsDirectory)) {
        mkdir($uploadsDirectory, 0777, true); // Create directory recursively
    }

    // Remove the prefix from the data URL
    $base64Image = str_replace('data:image/png;base64,', '', $signatureDataUrl);

    // Decode the base64-encoded image data
    $signatureData = base64_decode($base64Image);

    // Generate a unique file name for the PNG file
    $fileName = 'signature_' . uniqid() . '.png';

    // Set the file path where the PNG file will be saved
    $filePath = $uploadsDirectory . $fileName;

    // Save the image data to a file
    if (file_put_contents($filePath, $signatureData) !== false) {

        if (!empty($content)) {
            // Assuming 'admin' should have a specific value (replace 'default_value' with the desired value)
            $adminValue = 'default_value';

            // Insert the announcement into the database using a prepared statement
            $insertQuery = "INSERT INTO announcements (message, admin,signature,valid_until) VALUES (?, ?,?,?)";
            $statement = mysqli_prepare($conn, $insertQuery);

            if ($statement) {
                mysqli_stmt_bind_param($statement, 'sssi', $content, $adminValue,$fileName,$daysUntil);

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
        // Failed to save image
        echo 'Failed to save image.';
    }




    // Validate the input
    
} else {
    // Handle invalid request method
    $response = array('success' => false, 'message' => 'Invalid request method. Please use POST.');
    echo json_encode($response);
}

// Close the database connection
$conn->close();
