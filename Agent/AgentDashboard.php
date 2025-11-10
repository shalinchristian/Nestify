<?php
include 'db.php';
include 'header.php'; // Include the header file

if (!isset($_SESSION['dealer_id'])) {
?>
<h1 style="
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
    font-size: 36px;
    text-align: center;
    color: red;
">
    Login First!
</h1>
<?php
    $_SESSION['message'] = 'Unauthorized access. Please log in.';
    header('Location: AgentLogin.php');
    exit();
}

$dealer_id = $_SESSION['dealer_id'];
$dealer_name = $_SESSION['dealer_name'];

// Fetch properties added by the agent
$stmt = $conn->prepare("SELECT * FROM Properties WHERE dealer_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $dealer_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard - Add Property</title>
    <link rel="icon" href="images/Nestify-Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="Style.css">
</head>

<body style="background: url('images/1.jpg') no-repeat center center fixed; background-size: cover;">
    <div class="dashboard-container">
        <h2>Welcome, <?php echo htmlspecialchars($dealer_name); ?>!</h2>
        <p>Add a new property listing below.</p>

        <?php if (isset($_SESSION['message'])): ?>
            <p class="alert"><?php echo $_SESSION['message'];
                                unset($_SESSION['message']); ?></p>
        <?php endif; ?>

        <form action="AddProperty.php" method="POST" enctype="multipart/form-data">
            <label>Property Title:</label>
            <input type="text" name="title" required>

            <label>Description:</label>
            <textarea name="description" required></textarea>

            <label>Category:</label>
            <select name="category" required>
                <option value="Apartment">Apartment</option>
                <option value="House">House</option>
                <option value="Villa">Villa</option>
                <option value="Studio">Studio</option>
                <option value="Commercial">Commercial</option>
            </select>

            <label>Price (₹):</label>
            <input type="number" name="price" step="0.01" required>

            <label>Location:</label>
            <input type="text" name="location" required>

            <label>Bedrooms:</label>
            <input type="number" name="bedrooms" required>

            <label>Bathrooms:</label>
            <input type="number" name="bathrooms" required>

            <label>Area (sq ft):</label>
            <input type="number" name="area" required>

            <label>Furnished:</label>
            <select name="furnished" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
                <option value="Semi">Semi</option>
            </select>

            <label>Availability:</label>
            <select name="availability" required>
                <option value="Available">Available</option>
                <option value="Rented">Rented</option>
                <option value="Pending">Pending</option>
            </select>

            <label>Property Images:</label>
            <input type="file" name="property_images[]" accept="image/jpeg, image/png, image/jpg" multiple required>

            <button type="submit">Add Property</button>
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
    <footer>
        <p>&copy; 2025 Nestify | All rights reserved.</p>
    </footer>
</body>

</html>