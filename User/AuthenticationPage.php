<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Login & Signup</title>
    <link rel="stylesheet" href="AP.css">
    <link rel="icon" href="images/Nestify-Logo.png" type="image/x-icon">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <!-- Login Form -->
            <div class="form login-form">
                <h2>Welcome Back!</h2>
                <form action="Login.php" method="POST">
                    <input type="email" name="email" placeholder="Email" required autocomplete="email">
                    <input type="password" name="password" placeholder="Password" required
                        autocomplete="current-password">
                    <button type="submit">Login</button>
                </form>
                <p>New here? <a href="#" id="signup-link">Create an account</a></p>
                <p>Want to add your property? <a href="../Agent/Frontend_Login.php">Sign in as a Dealer</a></p>
                </div>

            <!-- Signup Form -->
            <div class="form signup-form">
                <h2>Create Account</h2>
                <form id="signup-form" action="Signup.php" method="POST">
                    <input type="text" name="fullname" placeholder="Full Name" required autocomplete="name">
                    <input type="email" name="email" placeholder="Email" required autocomplete="email">
                    <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
                    <!-- Display session messages between OTP input and verify button -->
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo '<p style="color: White;" >' . $_SESSION['message'] . '</p>';
                        unset($_SESSION['message']); // Clear message after displaying it
                    }
                    ?>
                    <button type="submit">Sign Up</button>
                </form>
                <p>Already have an account? <a href="#" id="login-link">Login</a></p>
            </div>
        </div>
    </div>
    <script src="AP.js"></script>
</body>
</html>