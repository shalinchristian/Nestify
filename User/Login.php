<?php
session_start(); // Start session at the top
include 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize user inputs
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($email) || empty($password)) {
        echo "<script>alert('Both email and password are required.'); window.location.href = 'AuthenticationPage.php';</script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.location.href = 'AuthenticationPage.php';</script>";
        exit();
    }

    // Prepare SQL statement to fetch user data
    $sql = "SELECT Id, Name, Password FROM Users WHERE Email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['Password'])) {
                // Set session variables
                $_SESSION['user_id'] = $row['Id'];
                $_SESSION['user_name'] = $row['Name'];
                $_SESSION['email'] = $email;

                // Redirect to Home
                echo "<script>alert('Login successful! Redirecting...'); window.location.href = 'Home.php';</script>";
                exit();
            } else {
                echo "<script>alert('Invalid password.'); window.location.href = 'AuthenticationPage.php';</script>";
            }
        } else {
            echo "<script>alert('No user found with this email.'); window.location.href = 'AuthenticationPage.php.';</script>";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "<script>alert('Database error: Unable to prepare statement.'); window.location.href = 'AuthenticationPage.php';</script>";
    }

    // Close connection
    $conn->close();
}
?>
