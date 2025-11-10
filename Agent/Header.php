<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nestify | Home</title>
    <link rel="icon" href="images/Nestify-Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            /* text-decoration: none; */
            list-style: none;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: url('images/background.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        /* Navigation Bar */
        nav {
            background: rgba(0, 31, 61, 0.9);
            height: 80px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .logo a {
            color: white;
            font-size: 32px;
            /* Increased size */
            font-weight: bold;
            /* text-decoration: none; */
            transition: 0.3s;
        }

        .logo a:hover {
            color: #00a8ff;
        }

        nav ul {
            display: flex;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            font-size: 16px;
            font-weight: 500;
            /* text-decoration: none; */
            transition: color 0.3s ease;
            padding: 10px;
        }

        nav ul li a:hover {
            color: #00a8ff;
            border-bottom: 2px solid #00a8ff;
        }

        .checkbtn {
            font-size: 26px;
            color: white;
            cursor: pointer;
            display: none;
        }

        #check {
            display: none;
        }

        /* Mobile Navigation */
        @media (max-width: 890px) {
            .checkbtn {
                display: block;
                position: absolute;
                right: 30px;
            }

            nav ul {
                position: fixed;
                width: 270px;
                height: 100vh;
                background: rgba(0, 31, 61, 0.95);
                top: 0;
                right: -100%;
                flex-direction: column;
                text-align: center;
                justify-content: center;
                transition: right 0.4s ease-in-out;
                box-shadow: -5px 0 10px rgba(0, 0, 0, 0.2);
            }

            nav ul li {
                margin: 20px 0;
            }

            nav ul li a {
                font-size: 18px;
                padding: 12px;
            }

            #check:checked~ul {
                right: 0;
            }

            #check:checked~.overlay {
                display: block;
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: rgba(0, 0, 0, 0.5);
                display: none;
                z-index: 99;
            }
        }
    </style>
</head>

<body>
    <nav>
        <label class="logo"><a href="AgentDashboard.php" style="text-decoration: none;">Nestify</a></label>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <ul id="main-nav">
            <?php if (isset($_SESSION['dealer_name'])): ?>
                <li><a href="AgentDashBoard.php" style="text-decoration: none;">Add Properties</a></li>
                <li><a href="my_properties.php" style="text-decoration: none;">My Properties</a></li>
                <li><a href="Contact.php" style="text-decoration: none;">Rent Requests</a></li>
                <li><a href="Dashboard.php" style="text-decoration: none;">Profile</a></li>
                <li><a href="Logout.php" style="text-decoration: none;">Logout</a></li>
            <?php else: ?>
                <li><a href="Frontend_Login.php" id="login-link" style="text-decoration: none;">Login</a></li>
            <?php endif; ?>
        </ul>
        <div class="overlay"></div>
    </nav>
</body>

</html>