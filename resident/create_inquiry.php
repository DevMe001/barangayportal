<?php
include('includes/header.php');
include('../includes/session.php');

$inquiryAdded = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission
    $content = $_POST['content'];

    // Validate and sanitize input, perform necessary checks
    $content = mysqli_real_escape_string($conn, $content);

    // Insert the inquiry into the database using prepared statement
    $insertQuery = "INSERT INTO inquiries (content) VALUES (?)";
    $statement = mysqli_prepare($conn, $insertQuery);

    if ($statement) {
        mysqli_stmt_bind_param($statement, 's', $content);

        if (mysqli_stmt_execute($statement)) {
            $inquiryAdded = true;
        } else {
            // Handle the error, if any
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($statement);
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
            <div class="card-box pd-20 height-100-p mb-30">
                <!-- Inquiry Form -->
                <h4 class="font-20 weight-500 mb-10">Submit Inquiry</h4>
                <form method="post">
                    <div class="form-group">
                        <label for="content">Inquiry Content:</label>
                        <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Inquiry</button>
                </form>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <?php include('includes/scripts.php') ?>

    <?php if ($inquiryAdded): ?>
        <script>
            // Display a pop-up notification
            alert("Inquiry submitted successfully!");
        </script>
    <?php endif; ?>
</body>
</html>
