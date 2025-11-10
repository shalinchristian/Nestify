<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer - Nestify</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .footer {
            background-color: #001f3d;
            color: #ffffff;
            padding: 50px 0;
            text-align: center;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 0 20px;
        }

        .footer-sections {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            text-align: left;
        }

        .footer-column {
            flex: 1;
            min-width: 220px;
            padding: 0 20px;
        }

        .footer-column h3 {
            color: #ffffff;
            font-size: 18px;
            margin-bottom: 15px;
            position: relative;
        }

        .footer-column h3::after {
            content: "";
            display: block;
            width: 50px;
            height: 2px;
            background: #ffcc00;
            margin-top: 5px;
        }

        .footer-column ul {
            list-style: none;
            padding: 0;
        }

        .footer-column ul li {
            margin: 8px 0;
        }

        .footer-column ul li a {
            text-decoration: none;
            color: #ffffff;
            opacity: 0.8;
            transition: 0.3s;
            display: block;
        }

        .footer-column ul li a:hover {
            opacity: 1;
            color: #ffcc00;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .social-links a {
            color: #ffffff;
            font-size: 20px;
            transition: 0.3s;
        }

        .social-links a:hover {
            color: #ffffff;
        }

        .footer-bottom {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            opacity: 0.7;
            padding-top: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .footer-sections {
                flex-direction: column;
                text-align: center;
            }

            .footer-column {
                padding: 10px 0;
            }

            .social-links {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <footer class="footer">
        <div class="container">
            <div class="footer-sections">
                <div class="footer-column">
                    <h3>Company</h3>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Our Services</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Get Help</h3>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Support</a></li>
                        <li><a href="#">Booking Guide</a></li>
                        <li><a href="#">Payment Options</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Property Types</h3>
                    <ul>
                        <li><a href="#">Houses</a></li>
                        <li><a href="#">Villas</a></li>
                        <li><a href="#">Apartments</a></li>
                        <li><a href="#">Studios</a></li>
                        <li><a href="#">Commercial Spaces</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Follow Us</h3>
                    <div class="social-links">
                        <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>© 2025 Nestify. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>