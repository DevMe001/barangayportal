<?php
include('includes/header.php');
include('../includes/session.php');

$announcementAdded = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission
    $content = $_POST['content'];

    // Validate and sanitize input, perform necessary checks
    $content = mysqli_real_escape_string($conn, $content);

    // Assuming 'admin' should have a specific value (replace 'default_value' with the desired value)
    $adminValue = 'default_value';

    // Insert the announcement into the database using a prepared statement
    $insertQuery = "INSERT INTO announcements (message, admin) VALUES (?, ?)";
    $statement = mysqli_prepare($conn, $insertQuery);

    if ($statement) {
        mysqli_stmt_bind_param($statement, 'ss', $content, $adminValue);

        if (mysqli_stmt_execute($statement)) {
            $announcementAdded = true;

            // Fetch the last inserted announcement
            $lastInsertId = mysqli_insert_id($conn);
            $selectQuery = "SELECT * FROM announcements WHERE id = $lastInsertId";
            $result = mysqli_query($conn, $selectQuery);
            $newAnnouncement = mysqli_fetch_assoc($result);

            // Send the new announcement data as JSON for AJAX handling
            echo json_encode($newAnnouncement);
            exit();
        } else {
            // Handle the error, if any
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($statement);
    }
}

// Fetch existing announcements from the database in chronological order
$selectQuery = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = mysqli_query($conn, $selectQuery);
$announcements = mysqli_fetch_all($result, MYSQLI_ASSOC);


?>

;

  <style>
    #sig-canvas {
  border: 2px dotted #CCCCCC;
  border-radius: 15px;
  cursor: crosshair;
}
.right{
    margin-left:15rem;
}


  </style>
<body>
    <?php include('includes/navbar.php') ?>
    <?php include('includes/right_sidebar.php') ?>
    <?php include('includes/left_sidebar.php') ?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="card-box pd-20 height-100-p mb-30">
                <!-- Admin Announcements Form -->
                <h4 class="font-20 weight-500 mb-10">Create Announcement</h4>
                <form id="announcement-form" method="post">
                    <div class="form-group">
                      
                       <div class="row">
                        
                        <div class="col-12 col-md-12"> 
                          <label>Valid until:</label>
                           <select name="validUntil" class="custom-select form-control mb-2">
                          <option value="1">1 day</option>
                          <option value="2">2 days</option>
                          <option value="3">3 days</option>
                          <option value="4">4 days</option>
                          <option value="5">5 days</option>
                          <option value="6">6 days</option>
                          <option value="7">7 days</option>
                        </select>
                        </div>
                       </div>
                         <label for="content">Announcement Content:</label>
                        <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                    </div>

                <div class="row">
                  
                    <div class="position-relative col-md-12 d-flex justify-content-center">

                        
                        <canvas id="sig-canvas" width="300" height="160">
                            Get a better browser, bro.
                        </canvas>

                        
                       
                     <button type="button"  class="btn btn-default h4 position-absolute right" id="sig-clearBtn">&times; </button>

                     <button id='sig-submitBtn' type="button"  class="btn btn-default h4 position-absolute fixed-bottom text-info d-none" id="sig-clearBtn"><span class='btn btn-outline-primary px-5 py-2'>SAVE</span> </button>

                    </div>
                  
                    <div class="col-md-12 d-flex justify-content-center my-2">
                         <h4>Signature</h4>
                    </div>



                </div>

                     <div class="col-md-12 d-flex justify-content-center my-4">
                    
                     <button type="submit" class="btn btn-primary">Create Announcement</button>

                    </div>

                </form>
            </div>

            <style>
              .limit-text {
                width: 40ch;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap; /* Use white-space: nowrap; to prevent wrapping */
            }
            </style>

            <!-- Display Existing Announcements -->
            <div class="card-box pd-20 height-100-p mb-30">
                <h4 class="font-20 weight-500 mb-10">Existing Announcements</h4>
                <?php foreach ($announcements as $announcement): ?>
                    <div id="announcement-<?= $announcement['id'] ?>" class="announcement-box row">
                    <div class="col-12 col-md-4">
                         <p class='limit-text'><?= $announcement['message'] ?>
                        </p>
                      
                    </div>

                   <div class="col-12 col-md-3">
                        <small>
                            <?= $announcement['created_at'] ?>
                        </small>
                  </div>

                  <div class="col-12 col-md-2">
                      <?php
                            if($announcement['signature'] != ''){
                                ?>
                                 <img
                        src="./signatures_uploads/<?php echo $announcement['signature'] ?>" class="" alt="signature" width='80' height='80'/>
                                <?php
                      }else{
                        ?>
                         <small>
                            No signature
                        </small>
                        <?php
                      }

                        ?>
                       
                    </div>

                    <div class="col-12 col-md-3">
                        <!-- Add Edit and Delete buttons for each announcement -->
                        <button class="btn btn-sm btn-warning edit-btn" data-content="<?= $announcement['message'] ?>"
                            data-id="<?= $announcement['id'] ?>">Edit</button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $announcement['id'] ?>">Delete</button>
                    </div>


                    </div>
                <?php endforeach; ?>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <?php include('includes/scripts.php') ?>

    <?php if ($announcementAdded): ?>
        <script>
            // Display a pop-up notification
            alert("Announcement added successfully!");
        </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // JavaScript to handle announcement editing
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.edit-btn');
            
            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Prompt the user for a new content when the Edit button is clicked
                    const newContent = prompt('Edit Announcement:', button.dataset.content);
                    
                    if (newContent !== null) {
                        // If the user entered new content, update the announcement using AJAX or form submission
                        const announcementId = button.dataset.id;
                        updateAnnouncement(announcementId, newContent);
                    }
                });
            });

            function updateAnnouncement(announcementId, newContent) {
                // Implement the logic to update the announcement in the database using AJAX
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Successfully updated
                            alert("Announcement updated successfully!");

                            // Update the content on the page dynamically
                            const announcementElement = document.getElementById('announcement-' + announcementId);
                            const paragraphElement = announcementElement.querySelector('p');
                            paragraphElement.textContent = newContent;
                        } else {
                            // Handle the error
                            alert("Error updating announcement. Please try again.");
                        }
                    }
                };
                
                xhr.open('POST', 'update_announcement.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('id=' + encodeURIComponent(announcementId) + '&content=' + encodeURIComponent(newContent));
            }

            const deleteButtons = document.querySelectorAll('.delete-btn');
    
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const confirmation = confirm('Are you sure you want to delete this announcement?');
                    
                    if (confirmation) {
                        const announcementId = button.dataset.id;
                        deleteAnnouncement(announcementId);
                    }
                });
            });

            function deleteAnnouncement(announcementId) {
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        console.log(xhr.status); // Check the HTTP status
                        console.log(xhr.responseText); // Check the response from the server

                        if (xhr.status === 200) {
                            // Successfully deleted
                            alert("Announcement deleted successfully!");

                            // Remove the announcement element from the page
                            const announcementElement = document.getElementById('announcement-' + announcementId);
                            announcementElement.remove();
                        } else {
                            // Handle the error
                            alert("Error deleting announcement. Please check the console for details.");
                        }
                    }
                };

                xhr.open('POST', 'delete_announcement.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('id=' + encodeURIComponent(announcementId));
            }

            // AJAX for submitting the form without page reload
const announcementForm = document.getElementById('announcement-form');
announcementForm.addEventListener('submit', function (event) {
    event.preventDefault();


    const canvaSrc =  document.getElementById("sig-canvas").toDataURL();

    

    const formData = new FormData(announcementForm);
        formData.append('signature',canvaSrc);

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {

        if (this.readyState === 4) {
			if (this.status === 200) {

				let newAnnouncement = JSON.parse(this.responseText);

                console.log(newAnnouncement,'get new announcement');
				
             
                if(newAnnouncement.success){
                    
                 Swal.fire({
                position: "center",
                icon: "success",
                title: newAnnouncement.message,
                showConfirmButton: false,
                timer: 1500
                });

                setTimeout(() => {
                    location.reload();
                }, 5000);
        
                }else{
                    
                  Swal.fire({
                    position: "center",
                    icon: "error",
                    title: newAnnouncement.message,
                    showConfirmButton: false,
                    timer: 1500
                    });
                }

			} else {
				
                 Swal.fire({
                position: "center",
                icon: "error",
                title: 'Forbidden request',
                showConfirmButton: false,
                timer: 1500
                });
			}
		}

    };

    xhr.open('POST', 'annoucements.php', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send(formData);
});

// Function to display a notification
function displayNotification(message) {
    const notification = document.createElement('div');
    notification.classList.add('notification');
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(function () {
        document.body.removeChild(notification);
    }, 3000); // Display notification for 3 seconds
}

// Function to render the new announcement on the page
function renderAnnouncement(container, announcement) {
    const announcementBox = document.createElement('div');
    announcementBox.id = 'announcement-' + announcement.id;
    announcementBox.classList.add('announcement-box');

    const paragraph = document.createElement('p');
    paragraph.textContent = announcement.message;

    const small = document.createElement('small');
    small.textContent = announcement.created_at;

    const editButton = document.createElement('button');
    editButton.classList.add('btn', 'btn-sm', 'btn-warning', 'edit-btn');
    editButton.dataset.content = announcement.message;
    editButton.dataset.id = announcement.id;
    editButton.textContent = 'Edit';

    announcementBox.appendChild(paragraph);
    announcementBox.appendChild(small);
    announcementBox.appendChild(editButton);

    container.prepend(announcementBox);
}
        });
        // AJAX for submitting the form without page reload
// const announcementForm = document.getElementById('announcement-form');
// announcementForm.addEventListener('submit', function (event) {
//     event.preventDefault();

//     const formData = new FormData(announcementForm);

//     const xhr = new XMLHttpRequest();
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === XMLHttpRequest.DONE) {
//             if (xhr.status === 200) {
//                 // Successfully added
//                 const response = JSON.parse(xhr.responseText);

//                 if (response.success) {
//                     // Display a notification
//                     displayNotification(response.message);

//                     // Update the content on the page dynamically
//                     const existingAnnouncements = document.querySelector('.card-box .height-100-p');
//                     renderAnnouncement(existingAnnouncements, response.data);
//                 } else {
//                     // Handle the error
//                     alert(response.message);
//                 }
//             } else {
//                 // Handle the error
//                 alert("Announcement added successfully!");
//             }
//         }
//     };

//     xhr.open('POST', 'announcement.php', true);
//     xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
//     xhr.send(formData);
// });

// Function to display a notification
function displayNotification(message) {
    const notification = document.createElement('div');
    notification.classList.add('notification', 'success'); // Add a 'success' class for styling
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(function () {
        document.body.removeChild(notification);
    }, 3000); // Display notification for 3 seconds
}
    </script>
</body>
</html>


  <script>
    (function() {
      window.requestAnimFrame = (function(callback) {
        return window.requestAnimationFrame ||
          window.webkitRequestAnimationFrame ||
          window.mozRequestAnimationFrame ||
          window.oRequestAnimationFrame ||
          window.msRequestAnimaitonFrame ||
          function(callback) {
            window.setTimeout(callback, 1000 / 60);
          };
      })();

      var canvas = document.getElementById("sig-canvas");
      var ctx = canvas.getContext("2d");
      ctx.strokeStyle = "#000000";
      ctx.lineWidth = 2;

      var drawing = false;
      var mousePos = {
        x: 0,
        y: 0
      };
      var lastPos = mousePos;

      canvas.addEventListener("mousedown", function(e) {
        drawing = true;
        lastPos = getMousePos(canvas, e);
         $('#sig-submitBtn').addClass('d-none');
      }, false);

      canvas.addEventListener("mouseup", function(e) {
        drawing = false;
        
        $('#sig-submitBtn').removeClass('d-none')
      }, false);

      canvas.addEventListener("mousemove", function(e) {
        mousePos = getMousePos(canvas, e);
      }, false);

      // Add touch event support for mobile
      canvas.addEventListener("touchstart", function(e) {

      }, false);

      canvas.addEventListener("touchmove", function(e) {
        var touch = e.touches[0];
        var me = new MouseEvent("mousemove", {
          clientX: touch.clientX,
          clientY: touch.clientY
        });
        canvas.dispatchEvent(me);
      }, false);

      canvas.addEventListener("touchstart", function(e) {
        mousePos = getTouchPos(canvas, e);
        var touch = e.touches[0];
        var me = new MouseEvent("mousedown", {
          clientX: touch.clientX,
          clientY: touch.clientY
        });
        canvas.dispatchEvent(me);
      }, false);

      canvas.addEventListener("touchend", function(e) {
        var me = new MouseEvent("mouseup", {});

      

        canvas.dispatchEvent(me);

        
      }, false);

      function getMousePos(canvasDom, mouseEvent) {
        var rect = canvasDom.getBoundingClientRect();
        return {
          x: mouseEvent.clientX - rect.left,
          y: mouseEvent.clientY - rect.top
        }
      }

      function getTouchPos(canvasDom, touchEvent) {
        var rect = canvasDom.getBoundingClientRect();
        return {
          x: touchEvent.touches[0].clientX - rect.left,
          y: touchEvent.touches[0].clientY - rect.top
        }
      }

      function renderCanvas() {
        if (drawing) {
          ctx.moveTo(lastPos.x, lastPos.y);
          ctx.lineTo(mousePos.x, mousePos.y);
          ctx.stroke();
          lastPos = mousePos;

         
        }
      }

          // Function to enable scrolling
    function enableScroll() {
      document.body.style.overflow = '';
    }

    // Function to disable scrolling
    function disableScroll() {
      document.body.style.overflow = 'hidden';
    }



      // Prevent scrolling when touching the canvas
      document.body.addEventListener("touchstart", function(e) {
        if (e.target == canvas) {
              disableScroll();
          e.preventDefault();
        }
      }, false);
      document.body.addEventListener("touchend", function(e) {
        if (e.target == canvas) {
            enableScroll();
          e.preventDefault();

         
        }

 

      }, false);
      document.body.addEventListener("touchmove", function(e) {
        if (e.target == canvas) {
          e.preventDefault();
        }
      }, false);

      (function drawLoop() {
        requestAnimFrame(drawLoop);
        renderCanvas();
    
      })();

      
      function disableCanvasInteraction() {
            canvas.style.pointerEvents = 'none';
        }

        // Function to enable interaction with the canvas
        function enableCanvasInteraction() {
            canvas.style.pointerEvents = 'auto';
        }


      function clearCanvas() {
        canvas.width = canvas.width;
         $('#sig-submitBtn').addClass('d-none');
         enableCanvasInteraction();
        var ctx = canvas.getContext("2d");
        ctx.strokeStyle = "#222222";
        ctx.lineWidth = 2;
      }


      // Set up the UI
   
      var sigImage = document.getElementById("sig-image");
      var clearBtn = document.getElementById("sig-clearBtn");
      var submitBtn = document.getElementById("sig-submitBtn");
      clearBtn.addEventListener("click", function(e) {
        clearCanvas();
        sigImage.setAttribute("src", "");
      }, false);
      submitBtn.addEventListener("click", function(e) {
        var dataUrl = canvas.toDataURL();
     
          const ctx = canvas.getContext("2d");
          ctx.fillStyle = 'white';
          ctx.fillRect(0, 0, canvas.width, canvas.height);

            const img = new Image();
            img.onload = () => {
                ctx.drawImage(img, 0, 0);
            };
            img.src = dataUrl;

            

        $('#sig-submitBtn').addClass('d-none');

        disableCanvasInteraction();
      }, false);

    })();
  </script>

