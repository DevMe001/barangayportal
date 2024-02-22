<?php
include('includes/header.php');
include('../includes/session.php');
$sql = "SELECT * FROM announcements WHERE valid_until != 0 ORDER BY created_at DESC";
$result = $conn->query($sql);

$announcements = [];
while ($row = $result->fetch_assoc()) {
    if (isset($row["message"])) {

    $validDay = $row['valid_until'];

    $currentDayOfMonth = date('j');
    $validDate = $currentDayOfMonth + $validDay;


    if($currentDayOfMonth === $validDate){

        $update = "UPDATE announcements SET valid_until=0";
        $conn->query($update);
    }

        $announcements[] = $row;


    }
}


$countAnnounment = count($announcements) > 0 ? true : false;




?>
<body>
	
	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

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
						<p class="font-18 max-width-600">We're thrilled to have you join our vibrant and diverse group of citizens. Whether you're a long-time resident or new to the neighborhood, this community is a place where everyone's contributions are celebrated.</p>
					</div>
				</div>
			</div>

			<!-- Weather Information -->
			<div class="card-box height-100-p pd-20 min-height-200px">
				<div class="d-flex justify-content-between pb-10">
					<div class="h5 mb-0">Weather in Philippines</div>
				</div>
				<div class="font-18" id="weather-info">
					<!-- Weather information will be displayed here -->
				</div>
			</div>

			<!-- Current Time -->
			<div class="card-box height-100-p pd-20 min-height-200px">
				<div class="d-flex justify-content-between">
					<div class="h5 mb-0">Current Time in Philippines</div>
				</div>
				<div class="font-18" id="time-info">
					<!-- Current time will be displayed here -->
				</div>
			</div>
			
			<!-- Announcements Section -->
<div class="card-box mb-30">
    <div class="pd-20">
        <h2 class="text-blue h4">Announcements</h2>
    </div>
    <div class="pb-20">
        <div class="announcement-container">
            <?php
            // Check if announcements are available before using foreach
            if ($countAnnounment) {
                // Sort announcements by date (oldest to newest)
                usort($announcements, function ($a, $b) {
                    return strtotime($a['created_at']) - strtotime($b['created_at']);
                });

                foreach ($announcements as $announcement) {


                    $days = $announcement['valid_until'];

                        if($days == 1){
                           $days =  $days.' day';
                        }
                        if($days > 1){
                           $days =  $days . ' days';
                        }
                        

                        $className = $days == 0 ? "announcement-item d-none" : 'announcement-item';
                  ?>
                 <div class="<?php echo $className ?>">
                 <div class="announcement-date d-flex justify-content-between">
                    <p>
                        <?php echo date('F j, Y', strtotime($announcement['created_at'])) ?>
                    </p>
                     <p>
                        <span>Expired:</span>
                        <?php 
                        
                            echo $days;
                        
                        ?>
                    </p>
                 </div>
                 <div class="announcement-message"> <?php echo $announcement['message'] ?></div>
                 </div>
                  <?php
                }
            } else {
                ?>
                <div class="no-announcement px-3">No announcements available</div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<style>
    .announcement-container {
        display: flex;
        flex-direction: column;
    }

    .announcement-item {
        background-color: #3498db; /* Blue background color */
        color: #fff; /* White text color */
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
    }

    .announcement-item:hover {
        background-color: #2980b9; /* Darker blue on hover */
    }

    .announcement-date {
        font-size: 14px;
        color: #ecf0f1; /* Light gray text color */
    }

    .announcement-message {
        font-size: 16px;
        margin-top: 8px;
    }

    .no-announcement {
        font-size: 16px;
        color: #555;
    }
</style>


			<div class="row">
				<!-- Other Sections (Barangay Users, Barangay Setup, Admin) -->
				<!-- ... (Your existing code for these sections) ... -->
			</div>




			
		<!-- History Section -->
<div class="card-box mb-30">
   
    <div class="pb-20 row">
        
      <div class='col-12 col-md-8 pl-5'>
    <div class="pd-20">
        <h2 class="text-blue h4 pt-5">HISTORY</h2>
    </div>
          <table class="data-table table stripe hover wrap">
            <thead>
                <tr>
                    <th>REQUEST</th>
                    <th>REQUEST DATE</th>
                    <th>EXPIRY DATE</th>
                    <th>VALIDITY PERIOD (DAYS)</th>
                   
                   
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch history data from tblrequest for the current user
                $history_query = mysqli_query($conn, "SELECT * FROM tblrequest WHERE empid = '$session_id' ORDER BY empid DESC ");
                while ($row = mysqli_fetch_assoc($history_query)) {

                    $getApproval = '';

                    $status = $stats = $row['Status'];
                    $adminStats = $stats = $row['admin_status'];


                    if ($status == 1 && $adminStats == 1) {
                        $getApproval = 'Approved';
                    }
                    if ($status === 0 || $adminStats == 0) {
                        $getApproval = 'Pending';
                    } else {
                        $getApproval = 'Rejected';
                    }


                    ?>
                    <tr>
                        <td>
                            <?php echo $row['RequestType']; ?>
                        </td>
                        <td>
                            <?php echo $row['PostingDate']; ?>
                        </td>
                        <td>
                            <?php echo $row['ToDate']; ?>
                        </td>
                        <td>
                            <?php echo $row['num_days']; ?>
                        </td>
        
        
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
      </div>
        <section class='col-12 col-md-4 py-5'>
                    <h2 class="text-blue h4 text-center">Status of approval</h2>
            <div style="max-height:21rem;overflow:auto;" class="profile-timeline">
                    
            <?php
                $queryHistory = mysqli_query($conn, "SELECT * FROM tblrequest WHERE empid = '$session_id' GROUP BY RequestType  ");
                while ($row = mysqli_fetch_assoc($queryHistory)) {
                        $id = $row['id'];
                        ?>
                        <div class="timeline-month">
                            <h5>
                                <?php echo $row['PostingDate']; ?>
                            </h5>
                        </div>
                        <div class="profile-timeline-list">
                            <ul>
                
                                <li>
                                    <!-- <div class="date">
                                        <?php echo $row['num_days']; ?> Days
                                    </div> -->
                                    <div class="task-name"><i class="ion-ios-chatboxes"></i>
                                        <?php echo $row['RequestType']; ?>
                                    </div>
                                    <!-- <p>
                                        <?php echo $row['Description']; ?>
                                    </p> -->
                
                                    <div class="task-time">
                                        <?php $stats = $row['Status'];
                                        if ($stats == 1) {
                                            ?>
                                            <span style="color: green">Approved</span>
                                        <?php }
                                        if ($stats == 2) { ?>
                                            <span style="color: red">Rejected</span>
                                        <?php }
                                        if ($stats == 0) { ?>
                                            <span style="color: blue">Pending</span>
                                        <?php } ?>
                                    </div>
                
                                </li>
                
                
                            </ul>
                        </div>
                    <?php } ?>
                </div>
               
        </section>
    </div>
</div>


			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	
	<!-- Weather Information JavaScript -->
	<script>
    // Replace 'YOUR_API_KEY' with your OpenWeatherMap API key
    const apiKey = '988857664c06465190b7d46afa1533f8';
    const city = 'Manila';

    fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`)
        .then(response => response.json())
        .then(data => {
            const weatherInfo = document.getElementById('weather-info');
            const temperature = data.main.temp;
            const description = data.weather[0].description;

            weatherInfo.innerHTML = `Current Temperature: ${temperature}°C<br>Weather: ${description}`;
        })
        .catch(error => console.error('Error fetching weather data:', error));
	</script>

	<!-- Current Time JavaScript -->
	<script>
		function updateTime() {
			const timeInfo = document.getElementById('time-info');
			const options = { timeZone: 'Asia/Manila', hour: 'numeric', minute: 'numeric', second: 'numeric' };
			const currentTime = new Date().toLocaleTimeString('en-US', options);
			timeInfo.textContent = `Current Time: ${currentTime}`;
		}

		updateTime();
		setInterval(updateTime, 1000); // Update time every second
	</script>

	<!-- Include other scripts -->
	<?php include('includes/scripts.php')?>
	



            
</body>
</html>


