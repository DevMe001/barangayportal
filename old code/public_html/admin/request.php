<?php include('includes/header.php'); ?>
<?php include('../includes/session.php'); ?>
<?php
if (isset($_GET['delete'])) {
    $request_id = $_GET['delete'];
    $sql = "DELETE FROM tblrequest WHERE id = $request_id";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "<script>alert('request deleted Successfully');</script>";
        echo "<script type='text/javascript'> document.location = 'request.php'; </script>";
    }
}
?>

<body>
   
    <?php include('includes/navbar.php'); ?>

    <?php include('includes/right_sidebar.php'); ?>

    <?php include('includes/left_sidebar.php'); ?>

    <div class="mobile-menu-overlay"></div>

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
                                <li class="breadcrumb-item active" aria-current="page">All Applications</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <h2 class="text-blue h4">ALL APPLICATIONS</h2>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">NAME</th>
                                <th>TYPE</th>
                                <th>APPLIED DATE</th>
                                <th>STAFF STATUS</th>
                                <th>REG. STATUS</th>
                                <th class="datatable-nosort">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT tblrequest.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.location,tblemployees.emp_id,tblrequest.RequestType,tblrequest.PostingDate,tblrequest.Status, tblrequest.admin_status from tblrequest join tblemployees on tblrequest.empid=tblemployees.emp_id order by lid desc";
                            $query = mysqli_query($conn, $sql) or die(mysqli_error());
                            while ($row = mysqli_fetch_array($query)) {
                            ?>

                            <tr>
                                <td class="table-plus">
                                    <div class="name-avatar d-flex align-items-center">
                                        <div class="avatar mr-2 flex-shrink-0">
                                            <img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 shadow" width="40" height="40" alt="">
                                        </div>
                                        <div class="txt">
                                            <div class="weight-600"><?php echo $row['FirstName']." ".$row['LastName']; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $row['RequestType']; ?></td>
                                <td><?php echo $row['PostingDate']; ?></td>
                                <td><?php
                                    $stats = $row['Status'];
                                    if ($stats == 1) {
                                ?>
                                    <span style="color: green">Approved</span>
                                <?php } elseif ($stats == 2) { ?>
                                    <span style="color: red">Rejected</span>
                                <?php } elseif ($stats == 0) { ?>
                                    <span style="color: blue">Pending</span>
                                <?php } ?>
                                </td>
                                <td><?php
                                    $stats = $row['admin_status'];
                                    if ($stats == 1) {
                                ?>
                                    <span style="color: green">Approved</span>
                                <?php } elseif ($stats == 2) { ?>
                                    <span style="color: red">Rejected</span>
                                <?php } elseif ($stats == 0) { ?>
                                    <span style="color: blue">Pending</span>
                                <?php } ?>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="details.php?requestid=<?php echo $row['lid']; ?>"><i class="dw dw-eye"></i> View</a>
                                             <a class="dropdown-item" href="request.php?delete=<?php echo $row['lid']; ?>" onclick="return confirm('Are you sure you want to delete this request?')"><i class="dw dw-delete-3"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <!-- js -->

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
