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

// Get messages for the agent
$msg_query = "SELECT m.*, u.Name AS user_name, p.title AS property_title 
              FROM message m 
              JOIN users u ON m.user_id = u.Id 
              JOIN properties p ON m.property_id = p.property_id 
              WHERE m.dealer_id = $dealer_id 
              ORDER BY m.created_at DESC";
$msg_result = mysqli_query($conn, $msg_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Messages | Nestify</title>

    <link rel="icon" href="images/Nestify-Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .text-center {
            text-align: center;
            margin-top: 6%;
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

        .reply-form {
            margin-top: 10px;
        }

        .reply-form textarea {
            width: 100%;
            height: 60px;
            padding: 5px;
            border-radius: 5px;
        }

        .reply-form button {
            margin-top: 5px;
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .top-icons {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 20px;
            margin-top: 4%;
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
            bottom: 0;
            width: 100%;
            text-align: center;
            background-color: #001f3d;
            color: white;
            padding: 15px;
        }
    </style>
</head>

<body>
    <div class="top-icons">
        <a href="Dashboard_messages.php">
            <i class="fas fa-envelope"></i>
            <span class="badge"><?php echo $msg_count; ?></span>
        </a>
        <a href="Dashboard.php">
            <i class="fas fa-user"></i>
        </a>
    </div>
    <h2 class="text-center">Messages</h2>
    <div class="container">
        <?php if (mysqli_num_rows($msg_result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($msg_result)): ?>
                <div class="message-box">
                    <p><strong>Property Name:</strong> <?= htmlspecialchars($row['property_title']); ?></p>
                    <p><strong>Client Name:</strong> <?= htmlspecialchars($row['user_name']); ?></p>
                    <p><strong>Message:</strong> <?= nl2br(htmlspecialchars($row['message'])); ?></p>
                    <p><strong>Dealer Response:</strong>
                        <?= $row['dealer_response'] ? nl2br(htmlspecialchars($row['dealer_response'])) : '<span style="color: red;">No response yet!</span>'; ?>
                    </p>

                    <!-- If dealer hasn't responded, show Send Reply button -->
                    <?php if (empty($row['dealer_response'])): ?>
                        <form class="reply-form" method="post" action="reply_message.php">
                            <textarea name="dealer_response" placeholder="Type your response here..."></textarea>
                            <input type="hidden" name="message_id" value="<?= $row['message_id']; ?>">
                            <?php 
                                $_SESSION['user_id'] = $row['user_id'];

                            ?>
                            <button type="submit">Send Reply</button>

                        </form>

                        <!-- If dealer has responded, show "Chat with User" button -->
                    <?php else: ?>
                        <button class="chat-btn" onclick="openChat('<?= $row['message_id'] ; ?>')">Chat with User</button>
                    <?php endif; ?>

                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No messages yet.</p>
        <?php endif; ?>
    </div>
    <script>
        function openChat(messageId) {
            window.location.href = "agent_chat.php?message_id=" + messageId;
        }
    </script>

    <footer>
        <p>&copy; 2025 Nestify | All rights reserved.</p>
    </footer>
</body>

</html>

<?php mysqli_close($conn); ?>