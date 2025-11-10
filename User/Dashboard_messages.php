<?php
include 'db.php';
include 'header.php';

$user_id = $_SESSION['user_id'] ?? 0; // Get logged-in user ID

$query = "SELECT m.*, d.fullname AS dealer_name, p.title AS property_title 
            FROM message m 
            JOIN dealers d ON m.dealer_id = d.dealer_id
            JOIN properties p ON m.property_id = p.property_id
            WHERE m.user_id = $user_id
            ORDER BY m.created_at DESC";
$result = mysqli_query($conn, $query);

// Get cart count
$cart_query = "SELECT COUNT(*) AS count FROM cart WHERE user_id = $user_id";
$cart_result = mysqli_query($conn, $cart_query);
$cart_count = mysqli_fetch_assoc($cart_result)['count'];

// Get favorites count
$fav_query = "SELECT COUNT(*) AS count FROM favorites WHERE user_id = $user_id";
$fav_result = mysqli_query($conn, $fav_query);
$fav_count = mysqli_fetch_assoc($fav_result)['count'];

// Get Messages count
$msg_query = "SELECT COUNT(*) AS count FROM Message WHERE user_id = $user_id";
$msg_result = mysqli_query($conn, $msg_query);
$msg_count = mysqli_fetch_assoc($msg_result)['count'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Messages | Nestify</title>
    <link rel="icon" href="images/Nestify-Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .section-title {
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin-top: 6%
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #333;
            margin-top: 10%;
        }

        .message-box {
            background: #fafafa;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            text-align: left;
        }

        .message-box p {
            margin: 5px 0;
            color: #555;
        }

        .message-box strong {
            color: #000;
        }

        .no-messages {
            color: #888;
            font-size: 16px;
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
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .chat-btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            /* Blue color */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: 0.3s ease-in-out;
            margin-top: 10px;
        }

        .chat-btn:hover {
            background-color: #0056b3;
            /* Darker blue */
            transform: scale(1.05);
        }
    </style>
</head>

<body>
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
    <div class="section-title">My Messages</div>

    <div class="container">

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="message-box">
                    <p><strong>Property Name:</strong> <?= htmlspecialchars($row['property_title']); ?></p>
                    <p><strong>Dealer Name:</strong> <?= htmlspecialchars($row['dealer_name']); ?></p>
                    <p><strong>Message:</strong> <?= nl2br(htmlspecialchars($row['message'])); ?></p>
                    <p><strong>Dealer Response:</strong>
                        <?= $row['dealer_response'] ? nl2br(htmlspecialchars($row['dealer_response'])) : '<span style="color: red;">Dealer has not responded yet!</span>'; ?>
                    </p>

                    <!-- Show "Chat with Agent" button only if dealer has responded -->
                    <?php if (!empty($row['dealer_response'])): ?>
                        <button class="chat-btn" onclick="openChat('<?= $row['property_id']; ?>')">Chat with Agent</button>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-messages">No messages sent yet.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 Nestify | All rights reserved.</p>
    </footer>
    <script>
        function openChat(propertyId) {
            window.location.href = "property_chat.php?property_id=" + propertyId;
        }
    </script>

</body>

</html>

<?php mysqli_close($conn); ?>