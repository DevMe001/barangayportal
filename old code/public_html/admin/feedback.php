<?php
include('includes/header.php');
include('../includes/session.php');

$feedbackAdded = false;

// Check if a delete request is made for feedback
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    
    // Perform the deletion
    $deleteQuery = "DELETE FROM feedback WHERE id = ?";
    $deleteStatement = mysqli_prepare($conn, $deleteQuery);

    if ($deleteStatement) {
        mysqli_stmt_bind_param($deleteStatement, 'i', $deleteId);

        if (mysqli_stmt_execute($deleteStatement)) {
            // Deletion successful
            header("Location: feedback.php"); // Redirect to refresh the page
            exit();
        } else {
            // Handle the error, if any
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($deleteStatement);
    }
}

// Handle the form submission for feedback
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission
    $feedbackContent = $_POST['feedback_content'];

    // Validate and sanitize input, perform necessary checks
    $feedbackContent = mysqli_real_escape_string($conn, $feedbackContent);

    // Insert the feedback into the database using prepared statement
    $insertFeedbackQuery = "INSERT INTO feedback (content) VALUES (?)";
    $feedbackStatement = mysqli_prepare($conn, $insertFeedbackQuery);

    if ($feedbackStatement) {
        mysqli_stmt_bind_param($feedbackStatement, 's', $feedbackContent);

        if (mysqli_stmt_execute($feedbackStatement)) {
            $feedbackAdded = true;
        } else {
            // Handle the error, if any
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($feedbackStatement);
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
                            <h4>Feedback</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Feedback</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <h2 class="text-blue h4">Submit Feedback</h2>
                </div>
                <div class="pb-20">
                    <!-- Feedback Form -->
                    <form method="post">
                        <div class="form-group">
                            <label for="feedback_content">Feedback Content:</label>
                            <textarea class="form-control" id="feedback_content" name="feedback_content" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
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
                                <li class="breadcrumb-item active" aria-current="page">Feedback</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <h2 class="text-blue h4">All Feedback</h2>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th class="datatable-nosort">ID</th>
                                <th>Content</th>
                                <th>Timestamp</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $feedbackQuery = "SELECT * FROM feedback ORDER BY id DESC";
                            $feedbackResult = mysqli_query($conn, $feedbackQuery) or die(mysqli_error());
                            while ($feedback = mysqli_fetch_array($feedbackResult)) {
                            ?>
                                <tr>
                                    <td><?php echo $feedback['id']; ?></td>
                                    <!-- Add a style to make sure the text is visible -->
                                    <td style="color: black;"><?php echo htmlspecialchars($feedback['content']); ?></td>
                                    <td><?php echo $feedback['timestamp']; ?></td>
                                    <td>
                                        <a href="feedback.php?delete=<?php echo $feedback['id']; ?>" onclick="return confirm('Are you sure you want to delete this feedback?')">
                                            <i class="dw dw-delete-3"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add your JavaScript and other dependencies here -->

    <?php if ($feedbackAdded): ?>
        <script>
            // Display a pop-up notification
            alert("Feedback submitted successfully!");
        </script>
    <?php endif; ?>

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
