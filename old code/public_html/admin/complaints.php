<?php
include('includes/header.php');
include('../includes/session.php');

// Set open_basedir to include the allowed paths
ini_set('open_basedir', '/opt/awex-pages:/storage/ssd3/546/21672546:/new/allowed/path');

$complaintAdded = false;
$feedbackAdded = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission for both complaints and feedback
    if (isset($_POST['content'])) {
        // Complaint submission
        $content = $_POST['content'];
        $content = mysqli_real_escape_string($conn, $content);

        $insertQuery = "INSERT INTO complaints (content) VALUES (?)";
        $statement = mysqli_prepare($conn, $insertQuery);

        if ($statement) {
            mysqli_stmt_bind_param($statement, 's', $content);

            if (mysqli_stmt_execute($statement)) {
                $complaintAdded = true;
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            mysqli_stmt_close($statement);
        }
    } elseif (isset($_POST['feedback'])) {
        // Feedback submission
        $feedbackContent = $_POST['feedback'];
        $complaintId = $_POST['complaint_id'];

        $feedbackContent = mysqli_real_escape_string($conn, $feedbackContent);

        $updateFeedbackQuery = "UPDATE complaints SET feedback = ? WHERE id = ?";
        $updateFeedbackStatement = mysqli_prepare($conn, $updateFeedbackQuery);

        if ($updateFeedbackStatement) {
            mysqli_stmt_bind_param($updateFeedbackStatement, 'si', $feedbackContent, $complaintId);

            if (mysqli_stmt_execute($updateFeedbackStatement)) {
                // Handle photo upload if provided
                if (!empty($_FILES['feedback_photo']['name'])) {
                    $uploadDir = "../vendors/images/"; // Update with the absolute path
                    $uploadFile = $uploadDir . basename($_FILES['feedback_photo']['name']);

                    if (move_uploaded_file($_FILES['feedback_photo']['tmp_name'], $uploadFile)) {
                        // Store the uploaded photo file name in the database
                        $updatePhotoQuery = "UPDATE complaints SET feedback_photo = ? WHERE id = ?";
                        $updatePhotoStatement = mysqli_prepare($conn, $updatePhotoQuery);

                        if ($updatePhotoStatement) {
                            mysqli_stmt_bind_param($updatePhotoStatement, 'si', basename($_FILES['feedback_photo']['name']), $complaintId);
                            mysqli_stmt_execute($updatePhotoStatement);
                        } else {
                            echo "Error updating photo: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Move failed. Debugging information: ";
                        print_r(error_get_last());
                    }
                }

                $feedbackAdded = true;
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            mysqli_stmt_close($updateFeedbackStatement);
        }
    }
}

// Check if the user is an admin before allowing delete functionality
if (isset($_GET['delete']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
    $deleteId = $_GET['delete'];

    // Perform the deletion
    $deleteQuery = "DELETE FROM complaints WHERE id = ?";
    $deleteStatement = mysqli_prepare($conn, $deleteQuery);

    if ($deleteStatement) {
        mysqli_stmt_bind_param($deleteStatement, 'i', $deleteId);

        if (mysqli_stmt_execute($deleteStatement)) {
            // Deletion successful
            header("Location: complaints.php"); // Redirect to refresh the page
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($deleteStatement);
    }
}
?>

<body>
    <?php include('includes/navbar.php') ?>
    <?php include('includes/right_sidebar.php') ?>
    <?php include('includes/left_sidebar.php') ?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Complaints</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Complaints</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <h2 class="text-blue h4">Submit a Complaint</h2>
                </div>
                <div class="pb-20">
                    <!-- Complaint Form -->
                    
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="content">Complaint Content:</label>
                            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                        </div>
                        <!-- Add input for attaching a photo -->
                        <div class="form-group">
                            <label for="photo">Attach Photo:</label>
                            <input type="file" class="form-control-file" id="photo" name="photo">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Complaint</button>
                    </form>
                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Portal</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Complaints</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <h2 class="text-blue h4">All Complaints</h2>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th class="datatable-nosort">ID</th>
                                <th>Content</th>
                                <th>Photo</th>
                                <th>Timestamp</th>
                                <th class="datatable-nosort">Feedback</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $complaintsQuery = "SELECT * FROM complaints ORDER BY id DESC";
                            $complaintsResult = mysqli_query($conn, $complaintsQuery) or die(mysqli_error());
                            while ($complaint = mysqli_fetch_array($complaintsResult)) {
                            ?>
                                <tr>
                                    <td><?php echo $complaint['id']; ?></td>
                                    <!-- Add a style to make sure the text is visible -->
                                    <td style="color: black;"><?php echo htmlspecialchars($complaint['content']); ?></td>
                                    <td>
                                        <?php
                                        // Display photo if available
                                        if (!empty($complaint['photo'])) {
                                            echo '<img src="../vendors/images/' . $complaint['photo'] . '" alt="Complaint Photo" style="max-width: 100px;">';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $complaint['timestamp']; ?></td>
                                    <td>
                                        <!-- Feedback form -->
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="feedback">Feedback:</label>
                                                <textarea class="form-control" id="feedback" name="feedback" rows="4" required <?php if (!empty($complaint['feedback'])) echo 'disabled'; ?>><?php if (!empty($complaint['feedback'])) echo htmlspecialchars($complaint['feedback']); ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="feedback-photo">Attach Photo:</label>
                                                <input type="file" class="form-control-file" id="feedback-photo" name="feedback_photo" <?php if (!empty($complaint['feedback'])) echo 'disabled'; ?>>
                                            </div>
                                            <input type="hidden" name="complaint_id" value="<?php echo $complaint['id']; ?>">
                                            <button type="submit" class="btn btn-success" <?php if (!empty($complaint['feedback'])) echo 'disabled'; ?>>Submit Feedback</button>
                                        </form>
                                    </td>
                                    <td>
                                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                                            <?php if(empty($complaint['feedback'])): ?>
                                                <a href="complaints.php?delete=<?php echo $complaint['id']; ?>" onclick="return confirm('Are you sure you want to delete this complaint?')">
                                                    <i class="dw dw-delete-3"></i> Delete
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add your JavaScript and other dependencies here -->

            <?php if ($complaintAdded): ?>
                <script>
                    // Display a pop-up notification
                    alert("Complaint submitted successfully!");
                </script>
            <?php endif; ?>

            <?php if ($feedbackAdded): ?>
                <script>
                    // Display a pop-up notification
                    alert("Feedback submitted successfully!");
                </script>
            <?php endif; ?>
        </div>
    </div>

    <script src="../vendors/scripts/core.js"></script>
    <script src="../vendors/scripts/script.min.js"></script>
    <script src="../vendors/scripts/process.js"></script>
    <script src="../vendors/scripts/layout-settings.js"></script>
    <script src="../src/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>

    <!-- buttons for Export datatable -->
    <script src="../src/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.print.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.flash.min.js"></script>
    <script src="../src/plugins/datatables/js/vfs_fonts.js"></script>

    <script src="../vendors/scripts/datatable-setting.js"></script>
</body>
</html>
