<?php
include 'db.php';
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit();
}

$user_id = intval($_SESSION['user_id']);

// Get cart items
$query = "SELECT properties.property_id, properties.dealer_id, properties.title, properties.description, properties.category, properties.price, properties.location, properties.bedrooms, properties.bathrooms, properties.area, properties.furnished, properties.availability, properties.images, properties.created_at FROM cart 
        JOIN properties ON cart.property_id = properties.property_id 
        WHERE cart.user_id = $user_id";
$result = mysqli_query($conn, $query);

// Get cart count
$cart_query = "SELECT COUNT(*) AS count FROM cart WHERE user_id = $user_id";
$cart_result = mysqli_query($conn, $cart_query);
$cart_count = mysqli_fetch_assoc($cart_result)['count'];

// Get favorites count
$fav_query = "SELECT COUNT(*) AS count FROM favorites WHERE user_id = $user_id";
$fav_result = mysqli_query($conn, $fav_query);
$fav_count = mysqli_fetch_assoc($fav_result)['count'];

// Get message count
$msg_query = "SELECT COUNT(*) AS count FROM message WHERE user_id = $user_id";
$msg_result = mysqli_query($conn, $msg_query);
$msg_count = mysqli_fetch_assoc($msg_result)['count'];
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart | Nestify</title>
    <link rel="icon" href="images/Nestify-Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .section-title {
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin-top: 1%
        }
        .cart-container {
            flex-grow: 1;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            max-width: 1200px;
            margin: 40px auto;
        }
        .property-container {
            display: flex;
            flex-direction: column;
            width: 45%;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            position: relative;
        }
        .property-image-box img {
            width: 100%;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }
        .property-details {
            padding: 10px;
        }
        .property-details h2 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }
        .cart-btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            background-color: red;
            color: white;
            transition: all 0.3s ease-in-out;
        }
        .cart-btn:hover {
            background-color: darkred;
        }
        .top-icons {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 20px;
            top: 15%;
        }
        .top-icons a {
            color: #001f3d;
            font-size: 20px;
            transition: 0.3s;
            position: relative;
        }
        .top-icons a:hover {
            color: #4db8ff;
        }
        .badge {
            background: red;
            color: white;
            font-size: 12px;
            border-radius: 50%;
            padding: 0px 5px;
            position: absolute;
            top: -5px;
            right: -10px;
        }
        footer {
            color: white;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- Top Icons -->
    <div class="top-icons">
        <a href="Dashboard_cart.php">
            <i class="fas fa-shopping-cart"></i>
            <span class="badge"><?php echo $cart_count; ?></span>
        </a>
        <a href="Dashboard_favorites.php">
            <i class="fas fa-heart"></i>
            <span class="badge"><?php echo $fav_count; ?></span>
        </a>
        <a href="Dashboard_messages.php">
            <i class="fas fa-envelope"></i>
            <span class="badge"><?php echo $msg_count;?></span>
        </a>
        <a href="Dashboard.php">
            <i class="fas fa-user"></i>
        </a>
    </div>

    <div class="section-title">My Cart</div>

    <div class="cart-container">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="property-container">
                    <div class="property-image-box">
                        <img src="../<?php echo json_decode($row['images'])[0]; ?>" alt="Property Image">
                    </div>
                    <div class="property-details">
                        <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                        <table class="property-details-table">
                            <tr><td>Location:</td><td><?php echo htmlspecialchars($row['location']); ?></td></tr>
                            <tr><td>Price:</td><td>₹<?php echo number_format($row['price'], 2); ?></td></tr>
                            <tr><td>Bedrooms:</td><td><?php echo htmlspecialchars($row['bedrooms']); ?></td></tr>
                            <tr><td>Bathrooms:</td><td><?php echo htmlspecialchars($row['bathrooms']); ?></td></tr>
                            <tr><td>Area:</td><td><?php echo htmlspecialchars($row['area']); ?> sq ft</td></tr>
                            <tr><td>Furnished:</td><td><?php echo htmlspecialchars($row['furnished']); ?></td></tr>
                            <tr><td>Availability:</td><td><?php echo htmlspecialchars($row['availability']); ?></td></tr>
                            <tr><td>Category:</td><td><?php echo htmlspecialchars($row['category']); ?></td></tr>
                            <tr><td>Description:</td><td><?php echo htmlspecialchars($row['description']); ?></td></tr>
                            <tr><td>Created At:</td><td><?php echo htmlspecialchars($row['created_at']); ?></td></tr>
                        </table><br>
                        <button class="cart-btn" onclick="removeFromCart(<?php echo $row['property_id']; ?>)">
                            Remove from Cart
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; font-size: 18px;">No properties in your cart.</p>
        <?php endif; ?>
    </div>

    <script>
        function removeFromCart(propertyId) {
            $.post("remove_from_cart.php", { property_id: propertyId }, function(response) {
                if (response.trim() === "success") {
                    location.reload();
                } else {
                    alert("Failed to remove from cart.");
                }
            });
        }
    </script>

    <footer>
        <p>&copy; 2025 Nestify | All rights reserved.</p>
    </footer>
</body>
</html>