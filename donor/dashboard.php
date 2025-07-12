<?php
    
    require_once("../includes/session.inc.php");
    require_once("../includes/dbh.inc.php");
    require_once("../includes/template.php");
    if (!isset($_SESSION["donor"])) {
        header("Location: login.php");
        die();
    }

    if (!isset($_GET['home']) && !isset($_GET["profile"]) && !isset($_GET["donate_blood"]) && !isset($_GET["donations_history"]) && !isset($_GET["logout"])) {
        // Redirect to the same page with the 'blood' parameter added
        header('Location:dashboard.php?home=1');
    }

    if (isset($_GET["logout"])) {
        // Unset all session variables
        unset($_SESSION["donor"]);
        // Destroy the session
        session_destroy();
        header("Location:../index.php");
        die();
    }

    function print_error(string $error)
    {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '$error',
                confirmButtonText: 'Close'
            });
          </script>";
    }

    function check_errors()
    {
        if (isset($_SESSION["donor_error_donate"])) {
            $errors = $_SESSION["donor_error_donate"];
            echo "<script>";
            foreach ($errors as $error) {
                echo "
                    Swal.fire({
                        icon: 'error',
                        title: 'Request Error',
                        text: '$error',
                        confirmButtonText: 'Close'
                    });
                ";
            }
            echo "</script>";
            unset($_SESSION["donor_error_donate"]);
        }
    }

    function check_profile_errors()
    {
        if (isset($_SESSION["donor_error_profile"])) {
            $errors = $_SESSION["donor_error_profile"];
            echo "<script>";
            foreach ($errors as $error) {
                echo "
                    Swal.fire({
                        icon: 'error',
                        title: 'Profile Error',
                        text: '$error',
                        confirmButtonText: 'Close'
                    });
                ";
            }
            echo "</script>";
            unset($_SESSION["patient_erdonor_error_profileror_profile"]);
        }    
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.E. Bloodbound Healthcare</title>
    <!-- Include Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/blood-drop.svg" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Apply custom styles for the form -->
    <style>
        html, body {
            min-height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Sora', sans-serif;
        }

        .navbar-nav .nav-item a , .dropdown a {
            position: relative;
            color: #777;
            text-transform: uppercase;
            margin-right: 10px;
            text-decoration: none;
            overflow: hidden;
        }

        .navbar {
            background: linear-gradient(to right, #00008b, #0000cd, #1e90ff);
        }


        .dropdown-menu , .dropdown-menu a:hover {
            background-color: #f8f88f; /* Change the color to match your navbar background */
        }

        .navbar-nav  li a:hover , .dropdown a:hover {
            color: #1abc9c !important;
        }
    </style>
</head>
<body style="background-color: #f5f5dc;">
    <!-- Bootstrap navigation bar with responsive button -->
    <div class="container" style="margin-bottom: 100px;">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-shading" style="background-color:#f8f88f;">
    <!-- <nav class="navbar navbar-expand-lg navbar-light" style="background-color:#FF0000;"> -->
    <a class="navbar-brand" href="../donor/dashboard.php" style="color: #f9d8d8;font-size:15px;letter-spacing:2px;">S.E. Bloodbound Healthcare</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" style="color: #f9d8d8; font-size:13px;" href="?home=1">Home</a>
                </li>
                <li>
                    <?php
                    echo 
                    '
                    <div class="dropdown">
                        <a class="btn dropdown-toggle" style="color: #f9d8d8; font-size:13px;" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-left:0px;">
                            '.$_SESSION['donor'].'
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <a class="dropdown-item" style="color: #000000; font-size:13px;" href="?profile=1">Profile</a>
                            </li>
                            <li>
                                <button onclick="confirmLogout()" style="color: #000000; font-size:13px;" class="dropdown-item">LOGOUT</button>
                            </li>
                        </ul>
                    </div>
                    ';
                    ?>
                </li>
            </ul>
        </div>
    </nav>
    </div>
    <?php
        check_errors();
        check_profile_errors();
    ?>
    <?php

        if(isset($_GET))
        {
            if(count($_GET) > 1)
            {
                print_error("Link Corrupted!! Correct the link.......");
            }
            else
            {
                $getOne = key($_GET);
            }
        }
        
        if ($getOne && $getOne==='home')
        {

            if (!isset($_SESSION["welcome_donor_message"]) && isset($_SESSION["donor"])) {
                // Set the session variable to prevent the alert from showing again
                $_SESSION["welcome_donor_message"] = true;
            
                // Include SweetAlert and display the alert with JavaScript
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                echo '
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "Welcome, ' . htmlspecialchars($_SESSION["donor"]) . '!",
                                text: "We are happy to have you with us.",
                                icon: "success",
                                confirmButtonText: "Close",
                                confirmButtonColor: "#3085d6",  // Button color
                                backdrop: `
                                    rgba(0, 0, 0, 0.4)  /* Simple dark backdrop */
                                `,
                                customClass: {
                                    popup: "custom-popup",
                                    title: "custom-title",
                                    content: "custom-content",
                                    confirmButton: "custom-button"
                                }
                            });
                        });
                    </script>
                ';
            }
            
            $val = reset($_GET);

            if($val!=='1') 
            {
                print_error("Link Corrupted!! Correct the link.......");
                die();
            }
            
            $input = [
                "Donor",
                "Donate",
                "Make a new blood donation appointment.",
                "donate",
                "Donation",
                "View your past blood donation records.",
                "donations"
            ];
            
            home_template($input);

        }
        else if ($getOne && $getOne==='profile')
        {

            $val = reset($_GET);

            if($val!=='1') 
            {
                print_error("Link Corrupted!! Correct the link.......");
                die();
            }

            check_profile_errors();

            $query = "SELECT * from donor where username=:username;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":username",$_SESSION["donor"]);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            profile_template($row,'Donor');
        }
        else if ($getOne && $getOne==='donate_blood')
        {

            $val = reset($_GET);

            if($val!=='1') 
            {
                print_error("Link Corrupted!! Correct the link.......");
                die();
            }

            check_errors();

            donate_request_template("donate.php","Donate Blood","Contact Number","disease","Donate");

        }
        else if ($getOne && $getOne==='donations_history')
        {

            $val = reset($_GET);

            if($val!=='1') 
            {
                print_error("Link Corrupted!! Correct the link.......");
                die();
            }

            $query = "SELECT id from donor where username=:current_username;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":current_username", $_SESSION['donor']);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $donor_id = $result["id"];
            
            $query = "SELECT * from donate where donor_id=:id order by id desc;;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id",$donor_id);
            $stmt->execute();

            $cnt=0;

            echo '<div class="container mt-5 mb-5">
                    <h2 class="text-center mb-4">Donation History</h2>
                    <div class="row align-items-center">';

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                history_template($row,"Contact","disease");

                $cnt++;
            }

            echo '</div>
            </div>';

            if($cnt==0) print_error("No donations history!");

            // Close the PDO connection
            $pdo = null;
        }

    ?>

    <!-- Include Bootstrap JS and jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out of your session.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the logout URL
                    window.location.href = "dashboard.php?logout=1";
                }
            });
        }
    </script>
</body>
</html>