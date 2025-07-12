<?php

require_once("../includes/session.inc.php");
require_once("../includes/dbh.inc.php");
require_once("../includes/template.php");
if (!isset($_SESSION["patient"])) {
    header("Location: login.php");
    die();
}

if (!isset($_GET['home']) && !isset($_GET["profile"]) && !isset($_GET["request_blood"]) && !isset($_GET["requests_history"]) && !isset($_GET["logout"])) {
    // Redirect to the same page with the 'blood' parameter added
    header('Location:dashboard.php?home=1');
}

if (isset($_GET["logout"])) {
    // Unset all session variables
    unset($_SESSION["patient"]);
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
    if (isset($_SESSION["patient_error_request"])) {
        $errors = $_SESSION["patient_error_request"];
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
        unset($_SESSION["patient_error_request"]);
    }
}

function check_profile_errors()
{
    if (isset($_SESSION["patient_error_profile"])) {
        $errors = $_SESSION["patient_error_profile"];
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
        unset($_SESSION["patient_error_profile"]);
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
        html,
        body {
            min-height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Sora', sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, #7a0f0f, #b30000);
            /* Darkish red gradient */
        }

        .navbar-nav .nav-item a,
        .dropdown a {
            position: relative;
            color: #777;
            text-transform: uppercase;
            margin-right: 10px;
            text-decoration: none;
            overflow: hidden;
        }

        .dropdown-menu,
        .dropdown-menu a:hover {
            background-color: #f8f88f;
            /* Change the color to match your navbar background */
        }

        .navbar-nav li a:hover {
            color: #1abc9c !important;
        }
    </style>

    <style>
        #animated-image {
            width: 25px;
            /* Set to a smaller size */
            height: 25px;
            /* Match the width for consistent scaling */
            margin: auto;
            animation: beat 1s infinite;
            /* Heartbeat animation */
            transform-origin: center;
        }

        @keyframes beat {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
                /* Slightly larger at the peak */
            }
        }
    </style>




</head>

<body style="background-color: #f5f5dc;">
    <!-- Bootstrap navigation bar with responsive button -->
    <div class="container" style="margin-bottom: 100px;">
        <nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-shading" style="background-color:#f8f88f;">
            <!-- <nav class="navbar navbar-expand-lg navbar-light" style="background-color:#FF0000;"> -->
            <a class="navbar-brand" href="../patient/dashboard.php"
                style="color: #f9d8d8;font-size:15px;letter-spacing:2px;">S.E. Bloodbound Healthcare</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="?home=1" style="color: #f9d8d8; font-size:13px; ">Home</a>
                    </li>

                    <li>
                        <?php
                        echo
                            '
        <div class="dropdown">
            <a class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-left:0px; color: #f9d8d8; font-size:13px; ">
                ' . $_SESSION['patient'] . '
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

    function blood_group(int $name, string $val)
    {
        $blood_map = [
            "AP" => "A+",
            "AN" => "A-",
            "BP" => "B+",
            "BN" => "B-",
            "ABP" => "AB+",
            "ABN" => "AB-",
            "OP" => "O+",
            "ON" => "O-",
        ];

        echo
            '
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="text-center">
                <img id="animated-image" src="../images/blood-drop.svg" alt="">
                <p class="mt-2">' . $blood_map[$val] . '</p>
                <p class="mt-2">' . $name . '</p>
                </div>
            </div>
        ';
    }

    if (isset($_GET)) {
        if (count($_GET) > 1) {
            print_error("Link Corrupted!! Correct the link.......");
        } else {
            $getOne = key($_GET);
        }
    }

    if ($getOne && $getOne === 'home') {

        if (!isset($_SESSION["welcome_patient_message"]) && isset($_SESSION["patient"])) {
            // Set the session variable to prevent the alert from showing again
            $_SESSION["welcome_patient_message"] = true;

            // Include SweetAlert and display the alert with JavaScript
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                Swal.fire({
                                    title: "Welcome, ' . htmlspecialchars($_SESSION["patient"]) . '!",
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

        if ($val !== '1') {
            print_error("Link Corrupted!! Correct the link.......");
            die();
        }

        check_errors();

        $id = 1;
        $query = "SELECT * from blood where id=:id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);



        echo '
             <div class="form-container">
                            <h2 class="text-center">Available Blood Stock</h2>
                            </div>
            <div class="container">
            <div class="row" style="margin-top:50px;">';
        blood_group($row["AP"], "AP");
        blood_group($row["AN"], 'AN');
        blood_group($row["BP"], "BP");
        blood_group($row["BN"], "BN");
        blood_group($row["ABP"], "ABP");
        blood_group($row["ABN"], "ABN");
        blood_group($row["OP"], "OP");
        blood_group($row["ON"], "ON");
        echo '</div>
            ';


        $val = reset($_GET);

        if ($val !== '1') {
            print_error("Link Corrupted!! Correct the link.......");
            die();
        }

        $input = [
            "Patient",
            "Request",
            "Submit a request for blood donation.",
            "request",
            "Request",
            "View your past blood donation requests.",
            "requests"
        ];

        home_template($input);

    } else if ($getOne && $getOne === 'profile') {

        $val = reset($_GET);

        if ($val !== '1') {
            print_error("Link Corrupted!! Correct the link.......");
            die();
        }

        check_profile_errors();

        $query = "SELECT * from patient where username=:username;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $_SESSION["patient"]);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        profile_template($row, "Patient");

    } else if ($getOne && $getOne === 'request_blood') {

        $val = reset($_GET);

        if ($val !== '1') {
            print_error("Link Corrupted!! Correct the link.......");
            die();
        }

        check_errors();

        donate_request_template("request.php", "Request Blood", "Contact Number", "reason", "Request");

    } else if ($getOne && $getOne === 'requests_history') {

        $val = reset($_GET);

        if ($val !== '1') {
            print_error("Link Corrupted!! Correct the link.......");
            die();
        }

            $query = "SELECT id from patient where username=:current_username;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":current_username", $_SESSION['patient']);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $patient_id = $result["id"];

            $query = "SELECT * from request where patient_id=:id order by id desc;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $patient_id);
            $stmt->execute();

            $cnt = 0;

            echo '<div class="container mt-5 mb-5">
                            <h2 class="text-center mb-4">Request History</h2>
                            <div class="row align-items-center">
                        ';

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                history_template($row, "Contact", "reason");

                $cnt++;
            }

            echo '</div>
                    </div>';

            if ($cnt == 0)
                print_error("No requests history!");

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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const icon = document.getElementById("animated-image");

            // Set the animation duration dynamically
            function setBeatSpeed(speed) {
                icon.style.animationDuration = speed;
            }

            // Example: Adjust speed based on conditions or user interaction
            setBeatSpeed("0.8s"); // Faster heartbeat
        });
    </script>

</body>

</html>