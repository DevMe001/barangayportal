<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<body>
	
	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class = "main-container">
		<div class="pd-ltr-20">
			<div class="page-header">
				<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Request Portal</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Rejected Clearance</li>
								</ol>
							</nav>
						</div>
				</div>
			</div>

			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">REJECTED</h2>
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">STAFF</th>
								<th>TYPE</th>
								<th>APPLIED DATE</th>
								<th>STAFF STATUS</th>
								<th>REG. STATUS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php 
								$status = 2;
								$admin_status = 2;
								$sql = "SELECT tblrequest.id as lid, tblemployees.FirstName, tblemployees.LastName, tblemployees.location, tblemployees.emp_id, tblrequest.RequestType, tblrequest.PostingDate, tblrequest.Status, tblrequest.admin_status FROM tblrequest JOIN tblemployees ON tblrequest.empid = tblemployees.emp_id WHERE tblrequest.Status = '$status' AND tblrequest.admin_status = '$admin_status' ORDER BY lid DESC";
								$query = mysqli_query($conn, $sql) or die(mysqli_error());
								while ($row = mysqli_fetch_array($query)) {
								?>
								<td class="table-plus">
									<div class="name-avatar d-flex align-items-center">
										<div class="avatar mr-2 flex-shrink-0">
											<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 shadow" width="40" height="40" alt="">
										</div>
										<div class="txt">
											<div class="weight-600"><?php echo $row['FirstName']." ".$row['LastName'];?></div>
										</div>
									</div>
								</td>
								<td><?php echo $row['RequestType']; ?></td>
								<td><?php echo $row['PostingDate']; ?></td>
								<td>
									<?php
									$stats = $row['Status'];
									if ($stats == 1) {
										echo '<span style="color: green">Approved</span>';
									} elseif ($stats == 2) {
										echo '<span style="color: red">Rejected</span>';
									} elseif ($stats == 0) {
										echo '<span style="color: blue">Pending</span>';
									}
									?>
								</td>
								<td>
									<?php
									$stats = $row['admin_status'];
									if ($stats == 1) {
										echo '<span style="color: green">Approved</span>';
									} elseif ($stats == 2) {
										echo '<span style="color: red">Rejected</span>';
									} elseif ($stats == 0) {
										echo '<span style="color: blue">Pending</span>';
									}
									?>
								</td>
								<td>
									<div class="table-actions">
										<a title="VIEW" href="details.php?requestid=<?php echo $row['lid'];?>"><i class="dw dw-eye" data-color="#265ed7"></i></a>	
									</div>
								</td>
							</tr>
							<?php }?>
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
	<script src="../src.plugins/datatables/js/buttons.print.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.html5.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.flash.min.js"></script>
	<script src="../src/plugins/datatables/js/vfs_fonts.js"></script>
	
	<script src="../vendors/scripts/datatable-setting.js"></script>
</body>
</html>
