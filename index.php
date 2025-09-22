<?php
include 'db.php'; // DB connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wardrobe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>My Digital Wardrobe</h1>
    </header>

    <main>
        <section class="add-item-form">
            <h2>Add New Clothing Item</h2>
            <form action="add.php" method="post" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Item Name (e.g., Blue T-Shirt)" required>
                <input type="text" name="type" placeholder="Item Type (e.g., Shirt)" required>
                <input type="text" name="color" placeholder="Color (e.g., Blue)" required>
                <label for="image">Upload Image:</label>
                <input type="file" name="image" id="image" accept="image/*" required>
                <button type="submit">Add Item</button>
            </form>
        </section>

        <section class="wardrobe-display">
            <h2>My Clothes</h2>
            <div class="clothing-grid">
                <?php
                // Fetch clothes
                $sql = "SELECT id, name, type, color, image_path FROM clothes ORDER BY id DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output items
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='clothing-item'>";
                        echo "<img src='" . htmlspecialchars($row["image_path"]) . "' alt='" . htmlspecialchars($row["name"]) . "'>";
                        echo "<h3>" . htmlspecialchars($row["name"]) . "</h3>";
                        echo "<p><strong>Type:</strong> " . htmlspecialchars($row["type"]) . "</p>";
                        echo "<p><strong>Color:</strong> " . htmlspecialchars($row["color"]) . "</p>";
                        // Delete link
                        echo "<a href='delete.php?id=" . $row["id"] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Your wardrobe is empty. Add some clothes!</p>";
                }
                $conn->close(); // Close DB
                ?>
            </div>
        </section>
    </main>

</body>
</html>