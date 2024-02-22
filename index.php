<?php
session_start();
include('includes/config.php');

// Function to get the count of pending requests
function getRequestCount() {
    global $conn;
    $sql = "SELECT COUNT(*) AS requestCount FROM tblrequest WHERE Status = 0";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['requestCount'];
}

// Verify reCAPTCHA response
function verifyRecaptcha($secret, $response) {
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => $secret,
        'response' => $response
    );

    $options = array(
        'http' => array (
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded', // Explicitly set content type
            'content' => http_build_query($data)
        )
    );

    $context  = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    return json_decode($verify);
}

if (isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $recaptchaResponse = $_POST['g-recaptcha-response']; // Captcha response

    // Secret key for reCAPTCHA
    // for production
    // $secret = '6Lc_3WIpAAAAALwvbXfeHTK23jMIE_CjGGyDqsHY';


    // for localhost
    $secret = '6LdnfHwpAAAAAHOVedeJ-u-EyTRMHxJrMrLdDinS';

    // Verify the reCAPTCHA response
    $recaptchaResult = verifyRecaptcha($secret, $recaptchaResponse);


    // develop mode

    // $sql = "SELECT * FROM tblemployees WHERE EmailId ='$username' AND Password ='$password'";
    // $query = mysqli_query($conn, $sql);
    // $count = mysqli_num_rows($query);

    // if ($count > 0) {
    //     while ($row = mysqli_fetch_assoc($query)) {
    //         if($row['is_active'] == 1){
    //         echo "<script>alert('Only one valid account to login'); document.location = 'index.php'; </script>";
    //         }else{
    //             $_SESSION['alogin'] = $row['emp_id'];
    //             $_SESSION['arole'] = $row['Department'];

    //             if ($row['role'] == 'Admin') {

    //                 // update status
    //                 $selectedId = $row['emp_id'];
    //                 $update = "UPDATE tblemployees SET is_active=1 WHERE  emp_id='$selectedId' ";
    //                 mysqli_query($conn, $update);

    //                 // Get request count for admin
    //                 $requestCount = getRequestCount();
    //                 echo "<script>alert('You have $requestCount pending requests.'); document.location = 'admin/admin_dashboard.php'; </script>";
    //             } elseif ($row['role'] == 'Resident') {
    //                 $_SESSION['alogin'] = $row['emp_id'];
    //                 $_SESSION['arole'] = $row['Department'];
    //                 echo "<script type='text/javascript'> document.location = 'resident/index.php'; </script>";
    //             } else {
    //                 // Get request count for staff
    //                 $requestCount = getRequestCount();
    //                 echo "<script>alert('You have $requestCount pending requests.'); document.location = 'staff/index.php'; </script>";
    //             }
    //         }
    //     }
    // } else {
    //     echo "<script>alert('Invalid Details');</script>";
    // }

    if ($recaptchaResult->success) {
        // reCAPTCHA verification successful production mode

        $sql = "SELECT * FROM tblemployees WHERE EmailId ='$username' AND Password ='$password'";
        $query = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($query);

        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                // $_SESSION['alogin'] = $row['emp_id'];
                // $_SESSION['arole'] = $row['Department'];

                // if ($row['role'] == 'Admin') {
                //     // Get request count for admin
                //     $requestCount = getRequestCount();
                //     echo "<script>alert('You have $requestCount pending requests.'); document.location = 'admin/admin_dashboard.php'; </script>";
                // } elseif ($row['role'] == 'Resident') {
                //     $_SESSION['alogin'] = $row['emp_id'];
                //     $_SESSION['arole'] = $row['Department'];
                //     echo "<script type='text/javascript'> document.location = 'resident/index.php'; </script>";
                // } else {
                //     // Get request count for staff
                //     $requestCount = getRequestCount();
                //     echo "<script>alert('You have $requestCount pending requests.'); document.location = 'staff/index.php'; </script>";
                // }
                if ($row['is_active'] == 1) {
                    echo "<script>alert('Only one valid account to login'); document.location = 'index.php'; </script>";
                } else {
                    $_SESSION['alogin'] = $row['emp_id'];
                    $_SESSION['arole'] = $row['Department'];

                    if ($row['role'] == 'Admin') {

                        // update status
                        $selectedId = $row['emp_id'];
                        $update = "UPDATE tblemployees SET is_active=1 WHERE  emp_id='$selectedId' ";
                        mysqli_query($conn, $update);

                        // Get request count for admin
                        $requestCount = getRequestCount();
                        echo "<script>alert('You have $requestCount pending requests.'); document.location = 'admin/admin_dashboard.php'; </script>";
                    } elseif ($row['role'] == 'Resident') {
                        $_SESSION['alogin'] = $row['emp_id'];
                        $_SESSION['arole'] = $row['Department'];
                        echo "<script type='text/javascript'> document.location = 'resident/index.php'; </script>";
                    } else {
                        // Get request count for staff
                        $requestCount = getRequestCount();
                        echo "<script>alert('You have $requestCount pending requests.'); document.location = 'staff/index.php'; </script>";
                    }
                }
            }
        } else {
            echo "<script>alert('Invalid Details');</script>";
        }
    } else {
        // reCAPTCHA verification failed
        echo "<script>alert('Please complete the CAPTCHA');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Barangay Information Portal</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/style.css">

    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-119386393-1');
    </script>
</head>
<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="login.html">
                    <img src="vendors/imag" alt="">
                </a>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="vendors/images/bernando1.png" alt="">
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Welcome To Barangay Portal</h2>
                        </div>
                        <form name="signin" method="post">
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" placeholder="Email ID" name="username" id="username">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy fa fa-envelope-o" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" placeholder="**********"name="password" id="password">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="g-recaptcha" data-sitekey="6LdnfHwpAAAAAMVKW3_XCKaAyuWTl6ztY_6Cj_QF"></div> <!-- Add reCAPTCHA widget -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                       <input class="btn btn-primary btn-lg btn-block" name="signin" id="signin" type="submit" value="Sign In">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js -->
    <script src="vendors/scripts/core.js"></script>
    <script src="vendors/scripts/script.min.js"></script>
    <script src="vendors/scripts/process.js"></script>
    <script src="vendors/scripts/layout-settings.js"></script>
</body>
</html>




