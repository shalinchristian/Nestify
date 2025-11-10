<?php
ob_start(); // Start output buffering to prevent header issues
include 'db.php';
include 'header.php'; // Ensure no output before this file is included

if (!isset($_SESSION['dealer_id'])) {
    $_SESSION['message'] = 'Unauthorized access. Please log in.';
    header('Location: AgentLogin.php');
    exit();
}

$dealer_id = $_SESSION['dealer_id'];

if (!isset($_GET['property_id'])) {
    $_SESSION['message'] = 'Invalid property selection.';
    header('Location: my_property.php');
    exit();
}

$property_id = $_GET['property_id'];
$stmt = $conn->prepare("SELECT * FROM Properties WHERE property_id = ? AND dealer_id = ?");
$stmt->bind_param("ii", $property_id, $dealer_id);
$stmt->execute();
$result = $stmt->get_result();
$property = $result->fetch_assoc();
$stmt->close();

if (!$property) {
    $_SESSION['message'] = 'Property not found or unauthorized access.';
    header('Location: my_property.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body style="background: url('images/1.jpg') no-repeat center center fixed; background-size: cover;">
    <div class="dashboard-container">
        <h2>Edit Property</h2>

        <?php if (isset($_SESSION['message'])): ?>
            <p class="alert"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>

        <form action="update_property.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="property_id" value="<?php echo $property['property_id']; ?>">
            
            <label>Property Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($property['title']); ?>" required>

            <label>Description:</label>
            <textarea name="description" required><?php echo htmlspecialchars($property['description']); ?></textarea>

            <label>Category:</label>
            <select name="category" required>
                <option value="Apartment" <?php if ($property['category'] == 'Apartment') echo 'selected'; ?>>Apartment</option>
                <option value="House" <?php if ($property['category'] == 'House') echo 'selected'; ?>>House</option>
                <option value="Villa" <?php if ($property['category'] == 'Villa') echo 'selected'; ?>>Villa</option>
                <option value="Studio" <?php if ($property['category'] == 'Studio') echo 'selected'; ?>>Studio</option>
                <option value="Commercial" <?php if ($property['category'] == 'Commercial') echo 'selected'; ?>>Commercial</option>
            </select>

            <label>Price (₹):</label>
            <input type="number" name="price" step="0.01" value="<?php echo $property['price']; ?>" required>

            <label>Location:</label>
            <input type="text" name="location" value="<?php echo htmlspecialchars($property['location']); ?>" required>

            <label>Bedrooms:</label>
            <input type="number" name="bedrooms" value="<?php echo $property['bedrooms']; ?>" required>

            <label>Bathrooms:</label>
            <input type="number" name="bathrooms" value="<?php echo $property['bathrooms']; ?>" required>

            <label>Area (sq ft):</label>
            <input type="number" name="area" value="<?php echo $property['area']; ?>" required>

            <label>Furnished:</label>
            <select name="furnished" required>
                <option value="Yes" <?php if ($property['furnished'] == 'Yes') echo 'selected'; ?>>Yes</option>
                <option value="No" <?php if ($property['furnished'] == 'No') echo 'selected'; ?>>No</option>
                <option value="Semi" <?php if ($property['furnished'] == 'Semi') echo 'selected'; ?>>Semi</option>
            </select>

            <label>Availability:</label>
            <select name="availability" required>
                <option value="Available" <?php if ($property['availability'] == 'Available') echo 'selected'; ?>>Available</option>
                <option value="Rented" <?php if ($property['availability'] == 'Rented') echo 'selected'; ?>>Rented</option>
                <option value="Pending" <?php if ($property['availability'] == 'Pending') echo 'selected'; ?>>Pending</option>
            </select>

            <label>Property Images (Upload new if needed):</label>
            <input type="file" name="property_images[]" accept="image/jpeg, image/png, image/jpg" multiple>

            <button type="submit">Update Property</button>
        </form>
    </div>

    <script>
        // Fade out message after 3 seconds
        setTimeout(() => {
            let alertBox = document.querySelector('.alert');
            if (alertBox) {
                alertBox.style.opacity = '0';
                setTimeout(() => alertBox.remove(), 500);
            }
        }, 3000);
    </script>
</body>
</html>

<?php
ob_end_flush(); // End output buffering and send output
?>  