<?php
include('includes/header.php');
include('../includes/session.php');

$complaintAdded = false;

// Handle complaint submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    $content = $_POST['content'];
    $content = mysqli_real_escape_string($conn, $content);

    $insertQuery = "INSERT INTO complaints (content) VALUES (?)";
    $statement = mysqli_prepare($conn, $insertQuery);

    if ($statement) {
        mysqli_stmt_bind_param($statement, 's', $content);

        if (mysqli_stmt_execute($statement)) {
            $complaintAdded = true;

            // Handle photo upload if provided
            if (!empty($_FILES['photo']['name'])) {
                $uploadDir = "../vendors/images/";
                $uploadFile = $uploadDir . basename($_FILES['photo']['name']);

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                    // Store the uploaded photo file name in the database
                    $complaintId = mysqli_insert_id($conn);
                    $updatePhotoQuery = "UPDATE complaints SET photo = ? WHERE id = ?";
                    $updatePhotoStatement = mysqli_prepare($conn, $updatePhotoQuery);

                    if ($updatePhotoStatement) {
                        mysqli_stmt_bind_param($updatePhotoStatement, 'si', basename($_FILES['photo']['name']), $complaintId);
                        mysqli_stmt_execute($updatePhotoStatement);
                    }
                }
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($statement);
    }
}

// Fetch complaints and associated feedback for display
$complaintsQuery = "SELECT c.id, c.content, c.timestamp, c.feedback_photo, c.photo, c.feedback
                    FROM complaints c
                    LEFT JOIN feedback f ON c.id = f.complaint_id
                    ORDER BY c.id DESC";

$complaintsResult = mysqli_query($conn, $complaintsQuery) or die(mysqli_error($conn));
$complaints = mysqli_fetch_all($complaintsResult, MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ... (head section remains unchanged) -->
</head>

<body>
    <?php include('includes/navbar.php') ?>
    <?php include('includes/right_sidebar.php') ?>
    <?php include('includes/left_sidebar.php') ?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20">
            <!-- Complaint submission form -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h2 class="text-blue h4">Submit a Complaint</h2>
                </div>
                <div class="pb-20">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="content">Complaint Content:</label>
                            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="photo">Attach Photo:</label>
                            <input type="file" class="form-control-file" id="photo" name="photo">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Complaint</button>
                    </form>
                </div>
            </div>

            <!-- Complaint History -->
            <div class="card-box mb-30">
                <div style="gap:0.5rem;"  class="pd-20 d-flex justify-content-start align-items-baseline">
                    <h2 class="text-blue h4">Complaint History (<?php echo count($complaints) > 0 ? count($complaints) : 0 ?>)</h2>
                   
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($complaints as $complaint): ?>
                                <tr>
                                    <td><?php echo $complaint['id']; ?></td>
                                    <td style="color: black;"><?php echo htmlspecialchars($complaint['content']); ?></td>
                                    <td>
                                        <?php if (!empty($complaint['photo'])): ?>
                                            <img src="../vendors/images/<?php echo $complaint['photo']; ?>" alt="Complaint Photo" style="max-width: 100px;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $complaint['timestamp']; ?></td>
                                    <td>
                                        <?php if (!empty($complaint['feedback'])): ?>
                                            <!-- Display feedback button if feedback exists -->
                                            <a href="#" style='background:#524d7d' class="btn btn-secondary text-center ml-10" data-toggle="modal" data-target="#feedbackModal<?php echo $complaint['id']; ?>">
                                                <div style="gap:1rem;"" class="d-flex justify-content-around align-items-center">
                                                        View     <div style='
                                   width: 25px;
                                    height: 30;
                                    background: rgba(255, 0, 0,0.5);
                                    border-radius: 100%;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    color: #ffffff;
                                    padding: 0.2rem;
                                    position:relative;
                                    '>
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
  <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901"/>
                </svg>  <sup style='font-size:0.6rem;position:absolute; top:0.6rem;left:1.3rem;font-weight:700; color:#ff0000;' class='sub'>
                 !
                                                
                                                    </sup>
                                                </div>
                                                </div>
                                            </a>
                                        <?php else: ?>
                                            <!-- Display clickable feedback button if no feedback exists -->
                                               <a href="#" style='background:rgba(82, 77, 125, 0.7);min-width:7rem;border:none;outline:none;' class="btn btn-secondary" data-toggle="modal" data-target="#feedbackModal<?php echo $complaint['id']; ?>">
                                                View  
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal for Feedback -->
            <?php foreach ($complaints as $complaint): ?>
                <?php if (!empty($complaint['feedback_photo']) && !empty($complaint['feedback'])): ?>
                    <div class="modal fade" id="feedbackModal<?php echo $complaint['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="feedbackModalLabel">Feedback for Complaint ID: <?php echo $complaint['id']; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Display feedback content -->
                                    
                                    <p><strong>Feedback:</strong> <?php echo htmlspecialchars($complaint['feedback']); ?></p>
                                    <!-- Display feedback image -->
                                    <img src="../vendors/images/<?php echo $complaint['feedback_photo']; ?>" alt="Feedback Image" style="max-width: 100px;">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
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