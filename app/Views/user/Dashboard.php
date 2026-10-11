<?php
require_once CONFIG_PATH . '/database.php';
include VIEW_PATH . '/user/partials/Header.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: AuthenticationPage.php');
    exit();
}

$user_id = intval($_SESSION['user_id']);

// Get user data from users table
$user_query = "SELECT Name, Email FROM users WHERE Id = ?";
$user_result = db_query($conn, $user_query, "i", $user_id);
$user_data = mysqli_fetch_assoc($user_result);

// Get cart count
$cart_query = "SELECT COUNT(*) AS count FROM cart WHERE user_id = ?";
$cart_result = db_query($conn, $cart_query, "i", $user_id);
$cart_count = mysqli_fetch_assoc($cart_result)['count'];

// Get favorites count
$fav_query = "SELECT COUNT(*) AS count FROM favorites WHERE user_id = ?";
$fav_result = db_query($conn, $fav_query, "i", $user_id);
$fav_count = mysqli_fetch_assoc($fav_result)['count'];


// Get message count
$msg_query = "SELECT COUNT(*) AS count FROM message WHERE user_id = ?";
$msg_result = db_query($conn, $msg_query, "i", $user_id);
$msg_count = mysqli_fetch_assoc($msg_result)['count'];

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Nestify</title>
    
    <!-- Favicon -->
    <link rel="icon" href="images/Nestify-Logo.png" type="image/x-icon">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="Style.css">
    
    <style>
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #f7f7f7;
        }
        .main-content {
            padding: 20px;
            width: 100%;
            position: relative;
        }
        .content-section {
            margin-top: 30px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .forgot-password-btn, .payment-history-btn {
            display: inline-block;
            padding: 10px 15px;
            background: #ff4d4d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.3s;
            text-align: center;
            margin-top: 10px;
        }
        .forgot-password-btn:hover, .payment-history-btn:hover {
            background: #cc0000;
        }
        .top-icons {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 20px;
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
            text-align: center;
            color: white;
            position: relative;
            width: 100%;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <div class="main-content">
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
                <span class="badge"><?php echo $msg_count; ?></span>
            </a>
            <a href="Dashboard.php">
                <i class="fas fa-user"></i>
            </a>
        </div>

        <h2>Welcome, <?php echo htmlspecialchars($user_data['Name']); ?>!</h2>
        <div class="content-section">
            <h3>User Details</h3>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['Email']); ?></p>
            <a href="forgot_password.php" class="forgot-password-btn">Forgot Password?</a>
        </div>
        
        <div class="content-section">
            <h3>Payment History</h3>
            <a href="payment_history.php" class="payment-history-btn">View Payment History</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Nestify | All rights reserved.</p>
    </footer>
</body>
</html>