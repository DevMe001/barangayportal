<?php
include('includes/header.php');
include('../includes/session.php');

if (isset($_POST['apply'])) {
    $empid = $session_id;
    $request_type = $_POST['request_type'];
    $fromdate = date('Y-m-d', strtotime($_POST['date_from']));
    $todate = date('Y-m-d', strtotime($_POST['date_to']));
    $description = $_POST['description'];
    $status = 0;
    $isread = 0;
    $datePosting = date("Y-m-d");

    // Fetch user details from the database
    $query = $dbh->prepare("SELECT FirstName, LastName, EmailId FROM tblemployees WHERE emp_id = :empid");
    $query->bindParam(':empid', $empid, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
       // Insert the request and user information into the database
        $sql = "INSERT INTO tblrequest(FirstName, LastName, EmailId, RequestType, ToDate, FromDate, Description, Status, IsRead, empid, PostingDate) VALUES (:firstname, :lastname, :emailid, :request_type, :fromdate, :todate, :description, :status, :isread, :empid, :datePosting)";
        $query = $dbh->prepare($sql);

        // Bind the user details
        $query->bindParam(':firstname', $user['FirstName'], PDO::PARAM_STR);
        $query->bindParam(':lastname', $user['LastName'], PDO::PARAM_STR);
        $query->bindParam(':emailid', $user['EmailId'], PDO::PARAM_STR);

        // Bind other request details
        $query->bindParam(':request_type', $request_type, PDO::PARAM_STR);
        $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
        $query->bindParam(':todate', $todate, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':isread', $isread, PDO::PARAM_STR);
        $query->bindParam(':empid', $empid, PDO::PARAM_STR);
        $query->bindParam(':datePosting', $datePosting, PDO::PARAM_STR);

        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId) {
            echo "<script>alert('Request was successful.');</script>";
            echo "<script type='text/javascript'> document.location = 'history.php'; </script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    } else {
        echo "<script>alert('User information not found.');</script>";
    }
}
?>
<body>
    <!-- Rest of your HTML code remains the same -->
</body>
</html>


<body>
    
    <?php include('includes/navbar.php')?>

    <?php include('includes/right_sidebar.php')?>

    <?php include('includes/left_sidebar.php')?>

    <div class="mobile-menu-overlay"></div>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pb-20">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Request Application</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Apply Request</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div style="margin-left: 50px; margin-right: 50px;" class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Official Form</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" action="">
                            <section>

                                <?php if ($role_id = 'Resident'): ?>
                                <?php $query= mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id'")or die(mysqli_error());
                                    $row = mysqli_fetch_array($query);
                                ?>
                        
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label >First Name </label>
                                            <input name="firstname" type="text" class="form-control wizard-required" required="true" readonly autocomplete="off" value="<?php echo $row['FirstName']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label >Last Name </label>
                                            <input name="lastname" type="text" class="form-control" readonly required="true" autocomplete="off" value="<?php echo $row['LastName']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <input name="email" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['EmailId']; ?>">
                                        </div>
                                    </div>
                                    <?php endif ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Request :</label>
                                            <select name="request_type" id="request_type" class="custom-select form-control" required="true" autocomplete="off" onchange="checkOther()">
                                            <option value="">Select Request...</option>
                                            <?php $sql = "SELECT  RequestType from tblrequesttype";
                                            $query = $dbh -> prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt=1;
                                            if($query->rowCount() > 0)
                                            {
                                            foreach($results as $result)
                                            {   ?>                                            
                                            <option value="<?php echo htmlentities($result->RequestType);?>"><?php echo htmlentities($result->RequestType);?></option>
                                            <?php }} ?>
                                            <option value="Other">Other</option> <!-- Add an option for "Other" -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="other_request_div" style="display: none;"> <!-- Add a div for the custom text input -->
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Other Request :</label>
                                            <input name="other_request" id="other_request" type="text" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Issuance Date :</label>
                                            <input name="date_from" type="text" class="form-control date-picker" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Date :</label>
                                            <input name="date_to" type="text" class="form-control date-picker" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                        <div class="form-group">
                                            <label>Description (PLEASE INCLUDE THE NEEDED DETAILES):</label>
                                            <textarea id="textarea1" name="description" class="form-control" required length="150" maxlength="150" required="true" autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-size:16px;"><b></b></label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="apply" id="apply" data-toggle="modal">Apply&nbsp;Request</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>

            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <!-- js -->
    <?php include('includes/scripts.php')?>
    <script>
        // Function to show/hide the custom text input based on the selected request type
        function checkOther() {
            var requestType = document.getElementById("request_type").value;
            var otherRequestDiv = document.getElementById("other_request_div");
            var otherRequestInput = document.getElementById("other_request");
            if (requestType === "Other") {
                otherRequestDiv.style.display = "block";
                otherRequestInput.required = true;
            } else {
                otherRequestDiv.style.display = "none";
                otherRequestInput.required = false;
            }
        }
    </script>
</body>
</html>
