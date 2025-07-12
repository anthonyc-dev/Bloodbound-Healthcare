<?php

declare(strict_types=1);
require_once("../includes/session.inc.php");
require_once("../includes/dbh.inc.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Form Data
        $disease = $_POST["disease"];
        $unit = $_POST["unit"];
        $errors = [];

        // Validation
        if (empty($disease) || $unit === null) {
            $errors["donate_empty"] = "Fill all fields!";
        }
        if ($unit && $unit < 0) {
            $errors["donate_negative"] = "Blood units cannot be negative!";
        }

        // Image Upload Logic
        $imagePath = ''; // Default empty path
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $imageTmpName = $_FILES['image']['tmp_name'];
            $imageName = $_FILES['image']['name'];
            $imagePath = '../images/' . basename($imageName);

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($imageTmpName, $imagePath)) {
                echo 'Image uploaded successfully!';
            } else {
                echo 'Failed to upload image.';
            }
        } else {
            echo 'No image uploaded or there was an error.';
            $imagePath = ''; // Assign an empty string if no image uploaded
        }

        // Handle Errors
        if ($errors) {
            $_SESSION["donor_error_donate"] = $errors;
            header("Location:dashboard.php?donate_blood=1");
            die();
        }

        // Fetch Donor Data
        $query = "SELECT blood FROM donor WHERE username=:current_username;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":current_username", $_SESSION['donor']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $blood = $result["blood"];

        $query = "SELECT id FROM donor WHERE username=:current_username;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":current_username", $_SESSION['donor']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $donor_id = $result["id"];

        // Insert Donation Data
        $query = "INSERT INTO donate(username, donor_id, disease, blood, unit, image) VALUES (:current_username, :id, :disease, :blood, :unit, :image);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":current_username", $_SESSION["donor"]);
        $stmt->bindParam(":disease", $disease);
        $stmt->bindParam(":blood", $blood);
        $stmt->bindParam(":id", $donor_id);
        $stmt->bindParam(":unit", $unit);
        $stmt->bindParam(":image", $imagePath);
        $stmt->execute();

        // Redirect to Donations History
        header("Location:dashboard.php?donations_history=1");
        $pdo = null;
        $stmt = null;
        die();
    } catch (PDOException $e) {
        // Log the error instead of echoing it
        error_log($e->getMessage(), 3, "/var/log/app_errors.log");
        echo "An error occurred. Please try again later.";
    }
} else {
    header("Location:dashboard.php");
    die();
}

?>
