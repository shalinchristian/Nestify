<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Rental System - Feedback</title>
    <link rel="stylesheet" href="Style.css">
    <link rel="icon" href="images/Nestify-Logo.png" type="image/x-icon">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch('Header.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('header').innerHTML = data;
                })
                .catch(error => console.error('Error loading header:', error));
        });
    </script>
</head>

<body>
    <div id="header"></div>

    <div class="contact-container">
        <h2>Feedback</h2>

        <div class="contact-form">
            <form action="Feedback.php" method="POST">
                <input type="email" value="<?php echo htmlspecialchars($_SESSION['email'] ?? 'Not Logged In'); ?>" readonly>
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>">

                <input type="text" id="subject" name="subject" placeholder="Subject" required>
                <textarea id="message" name="message" placeholder="Your Message" required></textarea>
                <!-- Display session messages-->
            <?php
            if (isset($_SESSION['message'])) {
                echo '<p style="color: red;">' . $_SESSION['message'] . '</p>';
                unset($_SESSION['message']);
            }
            ?>
                <button type="submit">Send Message</button>
            </form>
        </div>

        <div class="contact-info">
            <p>Have a question? <a href="https://mail.google.com/mail/?view=cm&fs=1&to=Nestifymail@gmail.com"
                    target="_blank">Send us an email</a>
            </p>
            <p>Or reach us at:</p>
            <p><strong>Phone:</strong> +91 1111111111</p>
            <p><strong>Address:</strong> 114-Prince Hostel, opp.charusat, changa, 388421</p>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 House Rental System | All rights reserved.</p>
    </footer>

</body>

</html>
