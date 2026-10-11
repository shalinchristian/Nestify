Agent_Login.php
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once CONFIG_PATH . '/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>alert('Both email and password are required.'); window.location.href = 'AuthenticationPage.php';</script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.location.href = 'AuthenticationPage.php';</script>";
        exit();
    }

    $sql = "SELECT dealer_id, fullname, password  FROM dealers WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['dealer_id'] = $row['dealer_id'];
                $_SESSION['dealer_name'] = htmlspecialchars($row['fullname'], ENT_QUOTES, 'UTF-8');
                echo "<script>alert('Login successful! Redirecting...';</script>";
                header('Location: ../Agent/AgentDashboard.php');
                exit();
            } else {
                $_SESSION['message'] = 'Invalid password.';
                header('Location: ../Agent/Frontend_Login.php');
                exit();
            }
        } else {
            $_SESSION['message'] = 'No user found with this email.';
            header('Location: ../Agent/Frontend_Login.php');
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = 'Database error: Unable to prepare statement.';
        header('Location: ../Agent/Frontend_Login.php');
        exit();
    }

    $conn->close();
}
?>