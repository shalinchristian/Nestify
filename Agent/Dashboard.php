<?php
include 'db.php';
include 'Header.php';

// Check if the agent is logged in
if (!isset($_SESSION['dealer_id'])) {
    echo "Agent not logged in.";
    exit();
}

$dealer_id = intval($_SESSION['dealer_id']);

// Get agent data from dealers table
$dealer_query = "SELECT fullname, email FROM dealers WHERE dealer_id = $dealer_id";
$dealer_result = mysqli_query($conn, $dealer_query);
$dealer_data = mysqli_fetch_assoc($dealer_result);

// Get message count
$msg_query = "SELECT COUNT(*) AS count FROM message WHERE dealer_id = $dealer_id";
$msg_result = mysqli_query($conn, $msg_query);
$msg_count = mysqli_fetch_assoc($msg_result)['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard | Nestify</title>
    
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
        h2{
            margin-top: 1%;
        }
        .main-content {
            padding: 20px;
            width: 100%;
            position: relative;
            flex: 1;
        }
        .content-section {
            margin-top: 30px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            background-color: #001f3d;
            padding: 15px;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
        }
        .forgot-password-btn {
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
        .forgot-password-btn:hover {
            background: #cc0000;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <!-- Top Icons -->
        <div class="top-icons">
            <a href="Dashboard_messages.php">
                <i class="fas fa-envelope"></i>
                <span class="badge"><?php echo $msg_count; ?></span>
            </a>
            <a href="Dashboard.php">
                <i class="fas fa-user"></i>
            </a>
        </div>

        <h2>Welcome, <?php echo htmlspecialchars($dealer_data['fullname']); ?>!</h2>
        <div class="content-section">
            <h3>Agent Details</h3>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($dealer_data['email']); ?></p>
            <a href="forgot_password.php" class="forgot-password-btn">Forgot Password?</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Nestify | All rights reserved.</p>
    </footer>
</body>
</html>