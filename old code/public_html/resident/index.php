<?php
include('includes/header.php');
include('../includes/session.php');
$sql = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = $conn->query($sql);

$announcements = [];
while ($row = $result->fetch_assoc()) {
    if (isset($row["message"])) {
        $announcements[] = $row;
    }
}
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
            if (!empty($announcements)) {
                // Sort announcements by date (oldest to newest)
                usort($announcements, function ($a, $b) {
                    return strtotime($a['created_at']) - strtotime($b['created_at']);
                });

                foreach ($announcements as $announcement) {
                    echo '<div class="announcement-item">';
                    echo '<div class="announcement-date">' . date('F j, Y', strtotime($announcement['created_at'])) . '</div>';
                    echo '<div class="announcement-message">' . $announcement['message'] . '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="no-announcement">No announcements available</div>';
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
    <div class="pd-20">
        <h2 class="text-blue h4">HISTORY</h2>
    </div>
    <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
            <thead>
                <tr>
                    <th class="table-plus">REQUEST</th>
                    <th>REQUEST DATE</th>
                    <th>EXPIRY DATE</th>
                    <th>VALIDITY PERIOD (DAYS)</th>
                    <th>RESIDENT CLEARANCE HOD STATUS</th>
                    <th>RESIDENT CLEARANCE REGISTRATION STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch history data from tblrequest for the current user
                $history_query = mysqli_query($conn, "SELECT * FROM tblrequest WHERE empid = '$session_id'");
                while ($row = mysqli_fetch_assoc($history_query)) {
                    echo "<tr>";
                    echo "<td>{$row['RequestType']}</td>"; // Assuming 'RequestType' is the request field
                    echo "<td>{$row['PostingDate']}</td>"; // Assuming 'PostingDate' is the request date field
                    echo "<td>{$row['ToDate']}</td>"; // Assuming 'ToDate' is the expiry date field
                    echo "<td>{$row['num_days']}</td>"; // Assuming 'num_days' is the validity period field
                    echo "<td>{$row['Status']}</td>"; // Assuming 'Status' is the hod status field
                    echo "<td>{$row['admin_status']}</td>"; // Assuming 'admin_status' is the registration status field
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
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
