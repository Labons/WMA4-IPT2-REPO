<?php

include 'db.php'; // DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    // Handle POST
    // Sanitize input
    $name = htmlspecialchars($_POST['name']);
    $type = htmlspecialchars($_POST['type']);
    $color = htmlspecialchars($_POST['color']);

    // Upload setup
    $target_dir = "uploads/"; // Upload folder
    $target_file = $target_dir . uniqid() . basename($_FILES["image"]["name"]); // Unique filename
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Size limit (5MB)
    if ($_FILES["image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allowed types
    if(!in_array($imageFileType, ["jpg","jpeg","png","gif"])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Insert record
            $stmt = $conn->prepare("INSERT INTO clothes (name, type, color, image_path) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $type, $color, $target_file);

            if ($stmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>
