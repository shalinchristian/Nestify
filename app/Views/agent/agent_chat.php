<?php
require_once CONFIG_PATH . '/database.php';
include VIEW_PATH . '/agent/partials/Header.php';

if (!isset($_SESSION['dealer_id'])) {
    $_SESSION['message'] = 'Unauthorized access. Please log in.';
    header('Location: Frontend_Login.php');
    exit();
}

$dealer_id = intval($_SESSION['dealer_id']);
$message_id = intval($_GET['message_id']);

$msg_query = "SELECT * FROM message WHERE message_id = ?";
$msg_result = db_query($conn, $msg_query, "i", $message_id);
$msg = mysqli_fetch_assoc($msg_result);

$user_id = intval($msg['user_id']);
$property_id = intval($msg['property_id']);

$user_query = "SELECT * FROM users WHERE id = ?";
$user_result = db_query($conn, $user_query, "i", $user_id);
$user_detail = mysqli_fetch_assoc($user_result);

// Fetch property details
$property_query = "SELECT * FROM properties WHERE property_id = ?";
$property_result = db_query($conn, $property_query, "i", $property_id);
$property = mysqli_fetch_assoc($property_result);

// Fetch chat messages
$chat_query = "SELECT * FROM chats 
               WHERE (sender_id = ? AND receiver_id = ? AND property_id = ?) 
                  OR (sender_id = ? AND receiver_id = ? AND property_id = ?) 
                --   AND property_id = ?
               ORDER BY timestamp ASC";
$chat_result = db_query($conn, $chat_query, "iiiiiii", $dealer_id, $user_id, $property_id, $user_id, $dealer_id, $property_id, $property_id);

// echo $dealer_id. " :" . $user_id . ":" . $property_id;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with User | Nestify</title>
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

        .chat-container {
            margin-top: 50px;
            max-width: 600px;
            margin: 100px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .chat-box {
            height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            background: #fafafa;
            border-radius: 5px;
        }

        .chat-box {
            width: 100%;
            max-height: 400px;
            overflow-y: auto;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
        }

        /* Common message styling */
        .message {
            max-width: 60%;
            padding: 10px 15px;
            margin: 5px;
            border-radius: 18px;
            font-size: 14px;
            word-wrap: break-word;
            display: inline-block;
            position: relative;
        }

        /* Sent messages (Right side - Blue) */
        .sent {
            background: #007bff;
            /* Keep the blue color */
            color: white;
            align-self: flex-end;
            text-align: right;
            margin-right: 10px;
        }

        /* Received messages (Left side - Light Gray) */
        .received {
            background: #ddd;
            /* Light gray for contrast */
            color: black;
            align-self: flex-start;
            text-align: left;
            margin-left: 10px;
        }

        .message-form {
            margin-top: 10px;
            display: flex;
        }

        .message-form textarea {
            flex: 1;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .send-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        .send-btn :hover {
            background: #28a745;
        }

        /* Success Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
            display: none;
            font-weight: bold;
            z-index: 1000;
        }


        /* Error Message */
        .notification.error {
            background: #dc3545;
        }

        /* Close Button */
        .notification .close-btn {
            cursor: pointer;
            margin-left: 15px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div id="notification" class="notification"></div>

    <?php if (isset($_SESSION['message_sent'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                showNotification("<?php echo $_SESSION['message_sent']; ?>");
            });
        </script>
        <?php unset($_SESSION['message_sent']); ?>
    <?php endif; ?>



    <div class="chat-container">
        <h2 style="text-align: center;">Chat with Client</h2>
        <!-- Property Details -->
        <div class="property-details">
            <h3>Property Details</h3>
            <p><strong>Property Name:</strong> <?= htmlspecialchars($property['title']); ?></p>
            <p><strong>Client Name:</strong> <?= htmlspecialchars($user_detail['Name']); ?></p>
            <p><strong>Location:</strong> <?= htmlspecialchars($property['location']); ?></p>
            <p><strong>Price:</strong> ₹<?= htmlspecialchars($property['price']); ?></p>
        </div>

        <div class="chat-box" id="chatBox">
            <?php while ($row = mysqli_fetch_assoc($chat_result)): ?>
                <div class="message <?= ($row['sender_id'] == $dealer_id) ? 'sent' : 'received'; ?>">
                    <p><?= nl2br(htmlspecialchars($row['message'])); ?></p>
                    <small><?= date('h:i A', strtotime($row['timestamp'])); ?></small>
                </div>
            <?php endwhile; ?>
        </div>

        <form id="chatForm" class="message-form">
            <textarea id="messageInput" placeholder="Type a message..." required></textarea>
            <button type="submit" class="send-btn">Send</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $("#chatForm").submit(function(event) {
                event.preventDefault();
                var message = $("#messageInput").val().trim();
                if (message === '') return;

                $.post("send_chat_message.php", {
                    sender_id: <?= $dealer_id ?>,
                    receiver_id: <?= $user_id ?>,
                    property_id: <?= $property_id ?>,
                    message: message
                }, function(response) {
                    if (response === "success") {
                        $("#messageInput").val("");
                        $("#chatBox").append('<div class="message sent"><p>' + message + '</p><small>Just now</small></div>');
                        $("#chatBox").scrollTop($("#chatBox")[0].scrollHeight);
                        alert("Message send.");
                        // Show success notification
                        showNotification(jsonResponse.success, "success");
                    } else {
                        alert("Message failed to send.");
                    }
                });
            });
        });

        function showNotification(message) {
            var notification = document.getElementById("notification");
            notification.innerText = message;
            notification.style.display = "block";

            setTimeout(function() {
                notification.style.display = "none";
            }, 3000); // Hides after 3 seconds
        }
    </script>
    <footer>
        <p>&copy; 2025 Nestify | All rights reserved.</p>
    </footer>

</body>

</html>

<?php mysqli_close($conn); ?>