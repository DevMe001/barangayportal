<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<link rel="stylesheet" type="text/css" href="wahaha.css">
<script src="your-script.js"></script>

<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>
	 <style>
        /* Styles for the phishing pop-up */
        .popup-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 9999;
        }
        /* Styles for the overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="card-box pd-20 height-100-p mb-30">
				<div class="row align-items-center">
					<div class="col-md-4 user-icon">
						<img src="../vendors/images/bernando1.png" alt="">
					</div>
					<div class="col-md-8">

						<?php $query= mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id'")or die(mysqli_error());
								$row = mysqli_fetch_array($query);
						?>

						<h4 class="font-20 weight-500 mb-10 text-capitalize">
							Welcome back <div class="weight-600 font-30 text-blue"><?php echo $row['FirstName']. " " .$row['LastName']; ?>,</div>
						</h4>
						<p class="font-18 max-width-600">We are delighted to extend a warm welcome to each of you as you take on your important roles in our community. Your commitment to serving our community is both admirable and invaluable.</p>
					</div>
				</div>
			</div>
			<div class="title pb-20">
				<h2 class="h3 mb-0">Data Information</h2>
			</div>
			<div class="row pb-10">
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$sql = "SELECT emp_id from tblemployees";
						$query = $dbh->prepare($sql);
						$query->execute();
						$empcount = $query->rowCount();
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo $empcount; ?></div>
								<div class="font-14 text-secondary weight-500">Total Users</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-user-2"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class = "card-box height-100-p widget-style3">
					<?php
						$status = 1;
						$sql = "SELECT id from tblrequest where status=:status";
						$query = $dbh->prepare($sql);
						$query->bindParam(':status', $status, PDO::PARAM_STR);
						$query->execute();
						$requestcount = $query->rowCount();
					?>
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo $requestcount; ?></div>
								<div class="font-14 text-secondary weight-500">Approved Clearance</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#09cc06"><span class="icon-copy fa fa-hourglass"></span></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
					<?php
						$status = 0;
						$sql = "SELECT id from tblrequest where status=:status";
						$query = $dbh->prepare($sql);
						$query->bindParam(':status', $status, PDO::PARAM_STR);
						$query->execute();
						$requestcount = $query->rowCount();
					?>
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo $requestcount; ?></div>
								<div class="font-14 text-secondary weight-500">Pending Clearance</div>
							</div>
							<div class="widget-icon">
								<div class="icon"><i class="icon-copy fa fa-hourglass-end" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
					<?php
						$status = 2;
						$sql = "SELECT id from tblrequest where status=:status";
						$query = $dbh->prepare($sql);
						$query->bindParam(':status', $status, PDO::PARAM_STR);
						$query->execute();
						$requestcount = $query->rowCount();
					?>
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo $requestcount; ?></div>
								<div class="font-14 text-secondary weight-500">Rejected Clearance</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#ff5b5b"><i class="icon-copy fa fa-hourglass-o" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between pb-10">
							<div class="h5 mb-0">Barangay Users</div>
							<div class="table-actions">
								<a title="VIEW" href="staff.php"><i class="icon-copy ion-disc" data-color="#17a2b8"></i></a>	
							</div>
						</div>
						<div class="user-list">
							<ul>
								<?php
		                         $query = mysqli_query($conn,"select * from tblemployees ORDER BY tblemployees.emp_id desc limit 4") or die(mysqli_error());
		                         while ($row = mysqli_fetch_array($query)) {
		                         $id = $row['emp_id'];
		                             ?>

								<li class="d-flex align-items-center justify-content-between">
									<div class="name-avatar d-flex align-items-center pr-2">
										<div class="avatar mr-2 flex-shrink-0">
											<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 box-shadow" width="50" height="50" alt="">
										</div>
										<div class="txt">
											<span class="badge badge-pill badge-sm" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo $row['Department']; ?></span>
											<div class="font-14 weight-600"><?php echo $row['FirstName'] . " " . $row['LastName']; ?></div>
											<div class="font-12 weight-500" data-color="#b2b1b6"><?php echo $row['EmailId']; ?></div>
										</div>
									</div>
									<div class="font-12 weight-500" data-color="#17a2b8"><?php echo $row['Phonenumber']; ?></div>
								</li>
								<?php }?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between">
							<div class="h5 mb-0">Barangay Setup</div>
							<div class="table-actions">
								<a title="VIEW" href="staff.php"><i class="icon-copy ion-disc" data-color="#17a2b8"></i></a>	
							</div>
						</div>

						<div id="application-chart"></div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between">
							<div class="h5 mb-0">Admin</div>
							<div class="table-actions">
								<a title="VIEW" href="staff.php"><i class="icon-copy ion-disc" data-color="#17a2b8"></i></a>	
							</div>
						</div>

						<div class="user-list">
							<ul>
								<?php
		                         $query = mysqli_query($conn,"select * from tblemployees where role = 'Admin' ORDER BY tblemployees.emp_id desc limit 4") or die(mysqli_error());
		                         while ($row = mysqli_fetch_array($query)) {
		                         $id = $row['emp_id'];
		                             ?>

								<li class="d-flex align-items-center justify-content-between">
									<div class="name-avatar d-flex align-items-center pr-2">
										<div class="avatar mr-2 flex-shrink-0">
											<img src="<?php echo $row['location']; ?>" class="border-radius-100 box-shadow" width="50" height="50" alt="">
										</div>
										<div class="txt">
											<span class="badge badge-pill badge-sm" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo $row['Department']; ?></span>
											<div class="font-14 weight-600"><?php echo $row['FirstName'] . " " . $row['LastName']; ?></div>
											<div class="font-12 weight-500" data-color="#b2b1b6"><?php echo $row['EmailId']; ?></div>
										</div>
									</div>
									<div class="font-12 weight-500" data-color="#17a2b8"><?php echo $row['Phonenumber']; ?></div>
								</li>
								<?php }?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			 <!-- Button to trigger the phishing pop-up -->
            <button onclick="showPhishingPopup()" class="btn btn-danger">Click Here for Free Gift!</button>

            <!-- Phishing pop-up container -->
            <div id="phishingPopup" class="popup-container">
                <p>This is a limited time offer! Claim your free gift now by entering your personal information below:</p>
                <!-- Add form fields for collecting sensitive information -->
                <form>
                    <input type="text" placeholder="Full Name" required><br>
                    <input type="email" placeholder="Email Address" required><br>
                    <input type="password" placeholder="Password" required><br>
                    <button type="submit">Claim Now</button>
                </form>
            </div>

            <!-- Overlay to darken the background when the pop-up is displayed -->
            <div id="overlay" class="overlay"></div>

			<div class="card-box mb-30">
				<div class="pd-20">
					<h2 class="text-blue h4">LATEST CLEARANCE APPLICATIONS</h2>
				</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">NAME</th>
								<th>TYPE</th>
								<th>APPLIED DATE</th>
								<th>HOD STATUS</th>
								<th>REG. STATUS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$status = 1;
								$sql = "SELECT tblrequest.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.location,tblemployees.emp_id,tblrequest.RequestType,tblrequest.PostingDate,tblrequest.Status, tblrequest.admin_status from tblrequest join tblemployees on tblrequest.empid=tblemployees.emp_id where tblrequest.Status= '$status' order by lid desc limit 5";
								$query = mysqli_query($conn, $sql) or die(mysqli_error());
								$cnt = 1;
								while ($row = mysqli_fetch_array($query)) { ?>
								<tr>
									<td class="table-plus">
										<div class="name-avatar d-flex align-items-center">
											<div class="txt mr-2 flex-shrink-0">
												<b><?php echo htmlentities($cnt);?></b>
											</div>
											<div class="txt">
												<div class="weight-600"><?php echo $row['FirstName']." ".$row['LastName'];?></div>
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
												<a class = "dropdown-item" href="admin_dashboard.php?requestid=<?php echo $row['lid']; ?>"><i class="dw dw-delete-3"></i> Delete</a>
											</div>
										</div>
									</td>
								</tr>
								<?php $cnt++; } ?>
						</tbody>
					</table>
			   </div>
			</div>

			<div class="pb-20 text-center">
				<a href="request.php" class="btn btn-primary btn-lg alarming-button" id="alarming-button">View All Requests</a>
			</div>

			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->
	
	

	<?php include('includes/scripts.php')?>
	 <script>
        function showPhishingPopup() {
            document.getElementById('phishingPopup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }
    </script>
</body>
</html>
