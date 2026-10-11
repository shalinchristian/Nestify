<?php
require_once CONFIG_PATH . '/database.php';
include VIEW_PATH . '/user/partials/Header.php';
// session_start();

if (!isset($_GET['property_id'])) {
    die("Invalid request.");
}

$property_id = intval($_GET['property_id']);
$user_id = intval($_SESSION['user_id']);

// Fetch property details
$property_query = "SELECT * FROM properties WHERE property_id = ?";
$property_result = db_query($conn, $property_query, "i", $property_id);
$property = mysqli_fetch_assoc($property_result);

if (!$property) {
    die("Property not found.");
}
$dealer_id = $property['dealer_id'];
$property_id = $property['property_id'];

// Get dealer_id from property
if (!$dealer_id) {
    die("Dealer not found!");
}

$d_query = "SELECT * FROM dealers WHERE dealer_id = ?";
$d_result = db_query($conn, $d_query, "i", $dealer_id);
$d_name = mysqli_fetch_assoc($d_result);


$chat_query = "SELECT * FROM chats WHERE (sender_id = ? AND receiver_id = ? AND property_id = ?) 
                OR (sender_id = ? AND receiver_id = ? AND property_id = ?)";
$chat_result = db_query($conn, $chat_query, "iiiiii", $dealer_id, $user_id, $property_id, $user_id, $dealer_id, $property_id);
$chat = mysqli_fetch_assoc($chat_result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with Agent</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/Nestify-Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .property-details {
            text-align: left;
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .chat-box {
            height: 300px;
            overflow-y: auto;
            padding: 10px;
            background: #fafafa;
            border-radius: 5px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .message {
            padding: 10px;
            margin: 5px;
            border-radius: 10px;
            max-width: 80%;
            display: inline-block;
        }

        .sent {
            background: #007bff;
            color: white;
            text-align: right;
            float: right;
        }

        .received {
            background: #ddd;
            text-align: left;
            float: left;
        }

        textarea {
            width: 100%;
            height: 50px;
            margin-top: 10px;
            border-radius: 5px;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #28a745;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            font-size: 16px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 1000;
            animation: fadeIn 0.5s ease-out;
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

        button {
            margin-top: 10px;
            padding: 10px;
            background: green;
            color: white;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
        }

        /* chat */
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
    </style>
</head>

<body>
    <?php if (isset($_SESSION['message_sent'])): ?>
        <div class="notification success">
            <p><?php echo $_SESSION['message_sent']; ?></p>
        </div>
        <?php unset($_SESSION['message_sent']); ?>
    <?php endif; ?>



    <div class="container">
        <p id="success-message" style="color: green; display: none; background-color: red;"></p>
        <h2>Chat with Agent</h2>

        <!-- Property Details -->
        <div class="property-details">
            <h3>Property Details</h3>
            <p><strong>Property Name:</strong> <?= htmlspecialchars($property['title']); ?></p>
            <p><strong>Dealer Name:</strong> <?= htmlspecialchars($d_name['fullname']); ?></p>
            <p><strong>Location:</strong> <?= htmlspecialchars($property['location']); ?></p>
            <p><strong>Price:</strong> ₹<?= htmlspecialchars($property['price']); ?></p>
        </div>

        <div class="chat-box" id="chat-box">
            <?php while ($chat = mysqli_fetch_assoc($chat_result)): ?>
                <div class="message <?php echo ($chat['sender_id'] == $user_id) ? 'sent' : 'received'; ?>">
                    <p><?php echo htmlspecialchars($chat['message']); ?></p>
                    <small><?= date('h:i A', strtotime($chat['timestamp'])); ?></small>
                </div>
            <?php endwhile; ?>
        </div>

        <form action="send_chat.php" method="post">
            <textarea id="chat-message" placeholder="Type your message..." name="message"></textarea>
            <input type="hidden" name="property_id" value="<?php echo $property_id; ?>">
            <input type="hidden" name="receiver_id" value="<?php echo $dealer_id; ?>">
            <button name="submit" type="submit">Send</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let propertyId = <?php echo $property_id; ?>;
        let userId = <?php echo $user_id; ?>;
        let receiverId = <?php echo $dealer_id; ?>;

        function sendMessage() {
            let message = $("#chat-message").val().trim();
            if (message === "") {
                alert("Message cannot be empty.");
                return;
            }

            $.post("send_chat.php", {
                property_id: propertyId,
                sender_id: userId,
                receiver_id: receiverId,
                message: message
            }, function(response) {
                console.log("Server Response:", response);

                try {
                    let jsonResponse = JSON.parse(response);

                    if (jsonResponse.success) {
                        $("#chat-message").val(""); // Clear input
                        fetchMessages(); // Refresh chat

                        // Show success notification
                        showNotification(jsonResponse.success, "success");

                        // Reload page after short delay
                        setTimeout(function() {
                            console.log("Reloading page...");
                            location.reload();
                        }, 1000); // 1-second delay
                    } else {
                        showNotification(jsonResponse.error, "error");
                    }
                } catch (e) {
                    console.error("Invalid JSON response:", response);
                }
            }).fail(function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
            });
        }

        // Function to show notification
        function showNotification(message, type) {
            let notification = $("<div>").addClass("notification").text(message);

            if (type === "error") {
                notification.addClass("error");
            }

            $("body").append(notification);

            setTimeout(() => {
                notification.fadeOut(500, function() {
                    $(this).remove();
                });
            }, 500);
        }


        function fetchMessages() {
            $.get("fetch_messages.php", {
                property_id: propertyId
            }, function(response) {
                try {
                    let messages = JSON.parse(response);
                    let chatBox = $("#chat-box");
                    chatBox.html("");

                    messages.forEach(msg => {
                        let sender = msg.sender_name;
                        let messageText = msg.message;
                        let messageHtml = <p><strong>${sender}:</strong> ${messageText}</p>;
                        chatBox.append(messageHtml);
                    });
                } catch (error) {
                    console.error("Invalid JSON response:", response);
                }
            });
        }
        setTimeout(() => {
            let notification = document.querySelector('.notification');
            if (notification) {
                notification.style.animation = "fadeOut 0.5s ease-out forwards";
                setTimeout(() => notification.remove(), 500);
            }
        }, 500);
    </script>
    <footer>
        <p>&copy; 2025 Nestify | All rights reserved.</p>
    </footer>

</body>

</html>