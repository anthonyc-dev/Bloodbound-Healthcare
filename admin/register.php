<?php
    
    
    require_once("../includes/session.inc.php");
    require_once("../includes/template.php");
    if(isset($_SESSION["admin"]) && isset($_GET["register"]) && $_GET["register"]==="success")
    {
        header("Location:dashboard.php");
    }
    function check_errors()
{
    if (isset($_SESSION["admin_error_register"])) {
        $errors = $_SESSION["admin_error_register"];
        echo "<script>";
        $delay = 0; // Initialize delay

        foreach ($errors as $error) {
            // Display each error with a delay
            echo "
                setTimeout(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Registration Error',
                        text: '$error',
                        confirmButtonText: 'Close'
                    });
                }, $delay);
            ";
            $delay += 1000; // Increase delay for the next error (1 second between each)
        }

        echo "</script>";
        unset($_SESSION["admin_error_register"]);
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
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/blood-drop.svg" type="image/x-icon">
    <!-- Apply custom styles for the form -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        html, body {
            min-height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Sora', sans-serif;
        }
        .form-container {
            border-radius: 10px;
            padding: 20px;
            margin: 10px auto 50px;
            max-width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .active , .active:hover {
            background-color: #1abc9c; /* Highlight color for the active button */
            color:#fff;
        }
        .btn {
            border: 1px #1ac9bc solid;
            margin: 5px;
        }

        .navbar {
            background: linear-gradient(to right, #00008b, #0000cd, #1e90ff);
        }

        .navbar-brand {
            color: #f9d8d8 !important;
        }

        .custom-text-center {
            padding: 10px;
            max-width: 400px;
            margin: auto;
        }
        @media (min-width: 576px) {
            .text-center {
                display: flex;
                justify-content: center;
            }
            .btn {
                flex: 1;
            }
        }
    </style>
</head>
<body style="background-color: #f5f5dc;">
    <div class="container" style="margin-top:80px;">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color:#f8f88f;">
        <a class="navbar-brand" href="../index.php" style="color: #777;font-size:15px;letter-spacing:2px;">S.E. Bloodbound Healthcare</a>
    </nav>
        <?php 
            check_errors();
        ?>
        <div class="text-center custom-text-center">
            <a class="btn" href="../donor/register.php">As Donor</a>
            <a class="btn active" href="../patient/register.php">As Patient</a>
        </div>
        <!-- Patient Register Form -->
        <div style="display:block;">
            <?php register_template("Patient Register"); ?>
        </div>
    </div>
    <!-- Include Bootstrap JS and jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
</body>
</html>
