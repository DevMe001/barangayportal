<?php
include('includes/header.php');
include('../includes/session.php');

$announcementAdded = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission
    $content = $_POST['content'];

    // Validate and sanitize input, perform necessary checks
    $content = mysqli_real_escape_string($conn, $content);

    // Assuming 'admin' should have a specific value (replace 'default_value' with the desired value)
    $adminValue = 'default_value';

    // Insert the announcement into the database using a prepared statement
    $insertQuery = "INSERT INTO announcements (message, admin) VALUES (?, ?)";
    $statement = mysqli_prepare($conn, $insertQuery);

    if ($statement) {
        mysqli_stmt_bind_param($statement, 'ss', $content, $adminValue);

        if (mysqli_stmt_execute($statement)) {
            $announcementAdded = true;

            // Fetch the last inserted announcement
            $lastInsertId = mysqli_insert_id($conn);
            $selectQuery = "SELECT * FROM announcements WHERE id = $lastInsertId";
            $result = mysqli_query($conn, $selectQuery);
            $newAnnouncement = mysqli_fetch_assoc($result);

            // Send the new announcement data as JSON for AJAX handling
            echo json_encode($newAnnouncement);
            exit();
        } else {
            // Handle the error, if any
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($statement);
    }
}

// Fetch existing announcements from the database in chronological order
$selectQuery = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = mysqli_query($conn, $selectQuery);
$announcements = mysqli_fetch_all($result, MYSQLI_ASSOC);


?>

;


<body>
    <?php include('includes/navbar.php') ?>
    <?php include('includes/right_sidebar.php') ?>
    <?php include('includes/left_sidebar.php') ?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="card-box pd-20 height-100-p mb-30">
                <!-- Admin Announcements Form -->
                <h4 class="font-20 weight-500 mb-10">Create Announcement</h4>
                <form id="announcement-form" method="post">
                    <div class="form-group">
                        <label for="content">Announcement Content:</label>
                        <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Announcement</button>
                </form>
            </div>

            <!-- Display Existing Announcements -->
            <div class="card-box pd-20 height-100-p mb-30">
                <h4 class="font-20 weight-500 mb-10">Existing Announcements</h4>
                <?php foreach ($announcements as $announcement): ?>
                    <div id="announcement-<?= $announcement['id'] ?>" class="announcement-box">
                        <p><?= $announcement['message'] ?></p>
                        <small><?= $announcement['created_at'] ?></small>
                        
                        <!-- Add Edit and Delete buttons for each announcement -->
                        <button class="btn btn-sm btn-warning edit-btn" data-content="<?= $announcement['message'] ?>" data-id="<?= $announcement['id'] ?>">Edit</button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $announcement['id'] ?>">Delete</button>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <?php include('includes/scripts.php') ?>

    <?php if ($announcementAdded): ?>
        <script>
            // Display a pop-up notification
            alert("Announcement added successfully!");
        </script>
    <?php endif; ?>

    <script>
        // JavaScript to handle announcement editing
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.edit-btn');
            
            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Prompt the user for a new content when the Edit button is clicked
                    const newContent = prompt('Edit Announcement:', button.dataset.content);
                    
                    if (newContent !== null) {
                        // If the user entered new content, update the announcement using AJAX or form submission
                        const announcementId = button.dataset.id;
                        updateAnnouncement(announcementId, newContent);
                    }
                });
            });

            function updateAnnouncement(announcementId, newContent) {
                // Implement the logic to update the announcement in the database using AJAX
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Successfully updated
                            alert("Announcement updated successfully!");

                            // Update the content on the page dynamically
                            const announcementElement = document.getElementById('announcement-' + announcementId);
                            const paragraphElement = announcementElement.querySelector('p');
                            paragraphElement.textContent = newContent;
                        } else {
                            // Handle the error
                            alert("Error updating announcement. Please try again.");
                        }
                    }
                };
                
                xhr.open('POST', 'update_announcement.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('id=' + encodeURIComponent(announcementId) + '&content=' + encodeURIComponent(newContent));
            }

            const deleteButtons = document.querySelectorAll('.delete-btn');
    
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const confirmation = confirm('Are you sure you want to delete this announcement?');
                    
                    if (confirmation) {
                        const announcementId = button.dataset.id;
                        deleteAnnouncement(announcementId);
                    }
                });
            });

            function deleteAnnouncement(announcementId) {
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        console.log(xhr.status); // Check the HTTP status
                        console.log(xhr.responseText); // Check the response from the server

                        if (xhr.status === 200) {
                            // Successfully deleted
                            alert("Announcement deleted successfully!");

                            // Remove the announcement element from the page
                            const announcementElement = document.getElementById('announcement-' + announcementId);
                            announcementElement.remove();
                        } else {
                            // Handle the error
                            alert("Error deleting announcement. Please check the console for details.");
                        }
                    }
                };

                xhr.open('POST', 'delete_announcement.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('id=' + encodeURIComponent(announcementId));
            }

            // AJAX for submitting the form without page reload
const announcementForm = document.getElementById('announcement-form');
announcementForm.addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(announcementForm);

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Successfully added
                const newAnnouncement = JSON.parse(xhr.responseText);
                const existingAnnouncements = document.querySelector('.card-box .height-100-p');
                renderAnnouncement(existingAnnouncements, newAnnouncement);
                
                // Display a notification
                displayNotification("Announcement added successfully!");
            } else {
                // Handle the error
                alert("Announcement added successfully!");
            }
        }
    };

    xhr.open('POST', 'annoucements.php', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send(formData);
});

// Function to display a notification
function displayNotification(message) {
    const notification = document.createElement('div');
    notification.classList.add('notification');
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(function () {
        document.body.removeChild(notification);
    }, 3000); // Display notification for 3 seconds
}

// Function to render the new announcement on the page
function renderAnnouncement(container, announcement) {
    const announcementBox = document.createElement('div');
    announcementBox.id = 'announcement-' + announcement.id;
    announcementBox.classList.add('announcement-box');

    const paragraph = document.createElement('p');
    paragraph.textContent = announcement.message;

    const small = document.createElement('small');
    small.textContent = announcement.created_at;

    const editButton = document.createElement('button');
    editButton.classList.add('btn', 'btn-sm', 'btn-warning', 'edit-btn');
    editButton.dataset.content = announcement.message;
    editButton.dataset.id = announcement.id;
    editButton.textContent = 'Edit';

    announcementBox.appendChild(paragraph);
    announcementBox.appendChild(small);
    announcementBox.appendChild(editButton);

    container.prepend(announcementBox);
}
        });
        // AJAX for submitting the form without page reload
const announcementForm = document.getElementById('announcement-form');
announcementForm.addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(announcementForm);

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Successfully added
                const response = JSON.parse(xhr.responseText);

                if (response.success) {
                    // Display a notification
                    displayNotification(response.message);

                    // Update the content on the page dynamically
                    const existingAnnouncements = document.querySelector('.card-box .height-100-p');
                    renderAnnouncement(existingAnnouncements, response.data);
                } else {
                    // Handle the error
                    alert(response.message);
                }
            } else {
                // Handle the error
                alert("Announcement added successfully!");
            }
        }
    };

    xhr.open('POST', 'announcement.php', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send(formData);
});

// Function to display a notification
function displayNotification(message) {
    const notification = document.createElement('div');
    notification.classList.add('notification', 'success'); // Add a 'success' class for styling
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(function () {
        document.body.removeChild(notification);
    }, 3000); // Display notification for 3 seconds
}
    </script>
</body>
</html>
