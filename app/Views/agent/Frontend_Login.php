<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Login & Signup</title>
    <link rel="stylesheet" href="AP.css">
    <link rel="icon" href="images/Nestify-Logo.png" type="image/x-icon">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <!-- Agent Login Form -->
            <div class="form login-form">
                <h2>Agent Login</h2>
                <form action="Agent_Login.php" method="POST">
                    <input type="email" name="email" placeholder="Agent Email" required autocomplete="email">
                    <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
                    <!-- Display session messages -->
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo '<p style="color: White;">' . $_SESSION['message'] . '</p>';
                        unset($_SESSION['message']);
                    }
                    ?>
                    <button type="submit">Login</button>
                </form>
                <p>New agent? <a href="#" id="signup-link">Create an account</a></p>
                <p>Back to <a href="../User/Home.php">Home</a></p>
            </div>

            <!-- Agent Signup Form -->
            <div class="form signup-form">
                <h2>Agent Signup</h2>
                <form action="Agent_Signup.php" method="POST">
                    <input type="text" name="fullname" placeholder="Agent Name" required autocomplete="name">
                    <input type="text" name="certificate_no" placeholder="RERA Certificate Number" required>
                    <input type="email" name="email" placeholder="Agent Email" required autocomplete="email">
                    <input type="tel" name="mobile" placeholder="Mobile Number" required pattern="[0-9]{10}" title="Enter a valid 10-digit mobile number">
                    <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
                    
                    <!-- Display session messages -->
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo '<p style="color: White;">' . $_SESSION['message'] . '</p>';
                        unset($_SESSION['message']);
                    }
                    ?>

                    <button type="submit">Sign Up</button>
                </form>
                <p>Already an agent? <a href="#" id="login-link">Login</a></p>
            </div>
        </div>
    </div>
    <script src="AP.js"></script>
</body>
</html>