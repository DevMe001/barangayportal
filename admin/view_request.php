<?php error_reporting(0);?>
<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<style>
    input[type="text"] {
        font-size: 16px;
        color: #0f0d1b;
        font-family: Verdana, Helvetica;
    }

    .btn-outline:hover {
        color: #fff;
        background-color: #524d7d;
        border-color: #524d7d;
    }

    textarea {
        font-size: 16px;
        color: #0f0d1b;
        font-family: Verdana, Helvetica;
    }

    .text_area {
        height: 8em;
        font-size: 16px;
        color: #0f0d1b;
        font-family: Verdana, Helvetica;
    }
</style>

<body>
    <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo"><img src="../vendors/images/deskapp-logo-svg.png" alt=""></div>
            <div class='loader-progress' id="progress_div">
                <div class='bar' id='bar1'></div>
            </div>
            <div class='percent' id='percent1'>0%</div>
            <div class="loading-text">
                Loading...
            </div>
        </div>
    </div>

    <?php include('includes/navbar.php')?>

    <?php include('includes/right_sidebar.php')?>

    <?php include('includes/left_sidebar.php')?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>REQUEST DETAILS</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Portal</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Request Details</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <form method="post" action="">

                        <?php
                        if (!isset($_GET['edit']) && empty($_GET['edit'])) {
                            header('Location: index.php');
                        } else {

                            $lid = intval($_GET['edit']);
                            $sql = "SELECT tblrequest.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id,tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId,tblrequest.RequestType,tblrequest.ToDate,tblrequest.FromDate,tblrequest.Description,tblrequest.PostingDate,tblrequest.Status,tblrequest.AdminRemark,tblrequest.admin_status,tblrequest.registra_remarks,tblrequest.AdminRemarkDate,tblrequest.num_days from tblrequest join tblemployees on tblrequest.empid=tblemployees.emp_id where tblrequest.id=:lid";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':lid', $lid, PDO::PARAM_STR);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = 1;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $result) {
                        ?>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-size: 16px;"><b>Full Name</b></label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->FirstName . " " . $result->LastName); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div alass="form-group">
                                                <label style="font-size: 16px;"><b>Email Address</b></label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->EmailId); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-size: 16px;"><b>Gender</b></label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-success" readonly value="<?php echo htmlentities($result->Gender); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-size: 16px;"><b>Phone Number</b></label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->Phonenumber); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-size: 16px;"><b>Request Type</b></label>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->RequestType); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label style="font-size: 16px;" class="col-sm-12 col-md-2 col-form-label"><b>Applied Date</b></label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="text" class="selectpicker form-control" data-style="btn-outline-success" readonly value="<?php echo htmlentities($result->PostingDate); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label style="font-size: 16px;" class="col-sm-12 col-md-2 col-form-label"><b>Description</b></label>
                                        <div class="col-sm-12 col-md-10">
                                            <textarea name="" class="form-control text_area" readonly type="text"><?php echo htmlentities($result->Description); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label style="font-size: 16px;" class="col-sm-12 col-md-2 col-form-label"><b>HOD Remarks</b></label>
                                        <div class="col-sm-12 col-md-10">
                                            <?php
                                            if ($result->AdminRemark == "") : ?>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Waiting for Approval"; ?>">
                                            <?php else : ?>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->AdminRemark); ?>">
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label style="font-size: 16px;" class="col-sm-12 col-md-2 col-form-label"><b>Reg. Remarks</b></label>
                                        <div class="col-sm-12 col-md-10">
                                            <?php
                                            if ($result->registra_remarks == "") : ?>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Waiting for Approval"; ?>">
                                            <?php else : ?>
                                                <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->registra_remarks); ?>">
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label style="font-size: 16px;"><b>Action Taken Date</b></label>
                                                <?php
                                                if ($result->AdminRemarkDate == "") : ?>
                                                    <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "NA"; ?>">
                                                <?php else : ?>
                                                    <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->AdminRemarkDate); ?>">
                                                <?php endif ?>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label style="font-size: 16px;"><b>Leave Status From HOD</b></label>
                                                <?php $stats = $result->Status; ?>
                                                <?php
                                                if ($stats == 1) : ?>
                                                    <input type="text" style="color: green;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Approved"; ?>">
                                                <?php elseif ($stats == 2) : ?>
                                                    <input type="text" style="color: red; font-size: 16px;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Rejected"; ?>">
                                                <?php else : ?>
                                                    <input type="text" style="color: blue;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Pending"; ?>">
                                                <?php endif ?>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label style="font-size: 16px;"><b>Registra/Registry Status</b></label>
                                                <?php $stats = $result->admin_status; ?>
                                                <?php
                                                if ($stats == 1) : ?>
                                                    <input type="text" style="color: green;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Approved"; ?>">
                                                <?php elseif ($stats == 2) : ?>
                                                    <input type="text" style="color: red; font-size: 16px;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Rejected"; ?>">
                                                <?php else : ?>
                                                    <input type="text" style="color: blue;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Pending"; ?>">
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>

                        <?php $cnt++;
                                }
                            }
                        } ?>
                    </form>
                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <!-- js -->

    <?php include('includes/scripts.php')?>
</body>
</html>
