<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.E. Bloodbound Healthcare</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Include Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/blood-drop.svg" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        html {
            min-height: 100%;
            position: relative;
        }

        /* Apply Sora font to the entire body */
        body {
            font-family: 'Sora', sans-serif;
            background: linear-gradient(to right, #4b0000, #8b0000, #a50000);
            color: #f9d8d8;
        }

        /* Add hover effect for links */
        .navbar-nav .nav-item a {
            position: relative;
            color: #fff;
            margin-right: 5px;
            text-decoration: none;
            overflow: hidden;
        }

        .navbar-nav li a:hover {
            color: #f9d8d8 !important;
        }

        /* Header and footer with a darkish blue gradient */
        .navbar {
            background: linear-gradient(135deg, #001f4d, #003366);
        }

        .navbar-brand {
            color: #f9d8d8 !important;
        }

        .footer {
            background: linear-gradient(135deg, #001f4d, #003366);
            color: #f9d8d8;
        }
    </style>
</head>

<body>
    <!-- Bootstrap navigation bar with responsive button -->
    <div class="container" style="margin-bottom: 50px;">
        <nav class="navbar navbar-expand-lg fixed-top">
            <a class="navbar-brand" href="index.php" style="font-size:15px;letter-spacing:2px;">S.E. Bloodbound
                Healthcare</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" style="font-size:13px;" href="patient/register.php">REGISTER</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="font-size:13px;" href="patient/login.php">LOGIN</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class='container text-center' style="padding-top: 100px;padding-bottom:50px;">
        <h1 class="display-6">S.E. Bloodbound Healthcare</h1>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <p class="lead mt-3">
                    This system is designed to efficiently manage blood donations, donors, and recipients, ensuring the
                    availability of safe and life-saving blood for those in need.
                </p>
                <p class="lead mt-3 mb-5">
                    Join us in the mission to save lives. Register as a donor or recipient and help make a difference!
                </p>
            </div>
            <div class="col-lg-6">
                <img id="animated-image" src="images/home.svg" alt="" class="img-fluid d-none d-lg-block">
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: 'Welcome to S.E. Bloodbound Healthcare!',
            text: 'We are glad to have you here.',
            icon: 'success',
            confirmButtonText: 'Proceed',
            confirmButtonColor: '#4CAF50',  // Green color for the confirm button
            background: '#f4f4f4',  // Light background color
            titleTextColor: '#2c3e50',  // Dark color for title text
            textColor: '#34495e',  // Slightly lighter text color
            backdrop: `
            rgba(0, 0, 0, 0.6)  /* Darker, semi-transparent backdrop */
        `,
            customClass: {
                popup: 'custom-popup',
                title: 'custom-title',
                content: 'custom-content',
                confirmButton: 'custom-button'
            }
        });
    </script>

    <style>
        /* Custom styles for the SweetAlert */
        .custom-popup {
            border-radius: 15px;
            padding: 20px;
            font-family: 'Arial', sans-serif;
        }

        .custom-title {
            font-size: 30px;
            font-weight: bold;
            color: #1d3c6a;
        }

        .custom-content {
            font-size: 18px;
            font-weight: normal;
            color: #555;
        }

        .custom-button {
            background-color: #4CAF50;
            /* Green button */
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            border: none;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .custom-button:hover {
            background-color: #45a049;
            cursor: pointer;
        }
    </style>



</body>
<footer class="footer" style="padding: 15px; font-size:12px; text-align: right; position: absolute; bottom: 0; width: 100%;">
    &copy; <a style="color:#f9d8d8;" href="#">Idea by Salman | Esparcia</a><a style="color:#f9d8d8;"
        href="#"></a>
</footer>

</html>