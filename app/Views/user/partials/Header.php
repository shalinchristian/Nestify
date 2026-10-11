<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nestify</title>
    <link rel="icon" href="images/Nestify-Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap');

        * {
            padding: 0;
            margin: 0;
            text-decoration: none;
            list-style: none;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
        }

        nav {
            background: #001f3d;
            height: 80px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logo a {
            color: white;
            font-size: 25px;
            font-weight: bold;
            text-decoration: none;
        }

        nav ul {
            display: flex;
            margin-left: auto; /* Pushes the menu to the right */
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #007BFF;
        }

        .checkbtn {
            font-size: 22px;
            color: white;
            cursor: pointer;
            display: none;
        }

        #check {
            display: none;
        }

        @media (max-width: 890px) {
            .checkbtn {
                display: block;
                font-size: 28px;
                padding: 10px;
                cursor: pointer;
                position: absolute;
                right: 20px; /* Ensures the menu button stays right-aligned */
                z-index: 11;
            }

            nav ul {
                position: fixed;
                width: 250px;
                height: 100vh;
                background: #001f3d;
                top: 0;
                right: 0;
                flex-direction: column;
                text-align: center;
                justify-content: center;
                transform: translateX(100%);
                transition: transform 0.5s ease-in-out;
                z-index: 10;
                padding-top: 80px;
                box-shadow: -5px 0 10px rgba(0, 0, 0, 0.2);
            }

            nav ul li {
                margin: 20px 0;
            }

            nav ul li a {
                font-size: 18px;
                display: block;
                padding: 10px;
                transition: color 0.3s ease;
            }

            #check:checked ~ ul {
                transform: translateX(0);
            }

            #check:checked ~ .overlay {
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
                z-index: 9;
            }
        }
    </style>
</head>

<body>
    <nav>
        <label class="logo"><a href="Home.php">Nestify</a></label>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <ul id="main-nav">
            <li><a href="Home.php">Home</a></li>
            <li><a href="Properties.php">Properties</a></li>
            <li><a href="Contact.php">Feedback</a></li>
            <?php if (isset($_SESSION['user_name'])): ?>
                <li><a href="Dashboard.php">Profile</a></li>
                <li><a href="Logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="AuthenticationPage.php" id="login-link">Login</a></li>
            <?php endif; ?>
        </ul>
        <div class="overlay"></div>
    </nav>
</body>

</html>
