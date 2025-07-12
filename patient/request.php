<?php

declare(strict_types=1);
require_once("../includes/session.inc.php");
require_once("../includes/dbh.inc.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Get form data
        $reason = $_POST["reason"];
        $unit = $_POST["unit"];
        $errors = [];

        if (empty($reason) || $unit == null) {
            $errors["request_empty"] = "Fill all fields!";
        }
        if ($unit && $unit < 0) {
            $errors["request_negative"] = "Blood units cannot be negative!";
        }

        // Image upload logic
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


        // If there are any errors, redirect with the errors
        if ($errors) {
            $_SESSION["patient_error_request"] = $errors;
            header("Location: dashboard.php?request_blood=1");
            die();
        }

        // Fetch user data from database
        $query = "SELECT blood FROM patient WHERE username=:current_username;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":current_username", $_SESSION['patient']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $blood = $result["blood"];

        $query = "SELECT id FROM patient WHERE username=:current_username;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":current_username", $_SESSION['patient']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $patient_id = $result["id"];

        // Insert request into database
        $query = "INSERT INTO request(username, patient_id, reason, blood, unit, image) VALUES(:current_username, :id, :reason, :blood, :unit, :image)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":current_username", $_SESSION["patient"]);
        $stmt->bindParam(":reason", $reason);
        $stmt->bindParam(":blood", $blood);
        $stmt->bindParam(":id", $patient_id);
        $stmt->bindParam(":unit", $unit);
        $stmt->bindParam(":image", $imagePath); // Bind the image path
        $stmt->execute();


        header("Location: dashboard.php?requests_history=1");
        $pdo = null;
        $stmt = null;
        die();

    } catch (PDOException $e) {
        echo $e;
    }
} else {
    header("Location: dashboard.php");
    die();
}
?>