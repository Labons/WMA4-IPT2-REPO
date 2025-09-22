<?php
// DB credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wardrobe_db";

// Connect
$conn = new mysqli($servername, $username, $password, $dbname);

// Abort on error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
