<?php

include 'db.php';

// get id
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // fetch image path
    $stmt_select = $conn->prepare("SELECT image_path FROM clothes WHERE id = ?");
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    if ($row = $result->fetch_assoc()) {
        $image_path = $row['image_path'];

        // delete file if present
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
    $stmt_select->close();

    // delete DB record
    $stmt_delete = $conn->prepare("DELETE FROM clothes WHERE id = ?");
    $stmt_delete->bind_param("i", $id);

    if ($stmt_delete->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt_delete->close();
}

$conn->close();
?>
