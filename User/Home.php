<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Rental System - Home</title>
    <link rel="stylesheet" href="Style.css">
    <link rel="icon" href="images/Nestify-Logo.png" type="image/x-icon">
    <!-- //bootstrap css link for installation -->

    <!-- google fonts link for installation -->
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <script>
        function navigateToPage(page) {
            document.body.classList.add("fade-out");
            setTimeout(function() {
                window.location.href = page;
            }, 500);
        }

        document.addEventListener("DOMContentLoaded", function() {
            fetch('Header.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('header').innerHTML = data;
                })
                .catch(error => console.error('Error loading header:', error));
        });

        function toggleDescription(id) {
            var desc = document.getElementById(id);
            desc.classList.toggle("show-description");
        }
    </script>
    <style>
        .property-description {
            display: none;
            overflow: hidden;
            /* transition: max-height 0.5s ease-out; */
            max-height: 0;
        }

        .show-description {
            display: block;
            max-height: 300px;
            /* Adjust based on content size */
        }

        .reach{
            text-align: center;

        }
        .reach-us {
            text-align: center;
            padding-top: 30px;
            padding-bottom: -1px;
            background: #f9f9f9;
        }

        .reach-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .map-container {
            flex: 1.5;
            min-width: 400px;
            padding-right: 20px;
        }

        .contact-info {
            flex: 1;
            min-width: 300px;
        }

        .contact-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: -20px;
            margin-bottom: 23px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .contact-box-1 {
            background: white;
            padding: 20px;
            border-radius: 10px;
            /* margin-top: -2px; */
            margin-bottom: 23px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .contact-box h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .contact-box p, .contact-box a {
            margin: 5px 0;
            font-size: 16px;
            color: #333;
            text-decoration: none;
        }

        .contact-box a:hover {
            color: #007bff;
        }

        .social-buttons a {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 8px 0;
            padding: 10px;
            background: #f1f1f1;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            color: #333;
        }

        .social-buttons a:hover {
            background: #ddd;
        }

        .map {
            width: 100%;
            height: 450px;
            border-radius: 10px;
        }
 /*       .reach-us {
            text-align: center;
            padding: 50px 20px;
            background: #f9f9f9;
        }

        .reach-us h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .reach-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .map-container {
            flex: 2;
            min-width: 300px;
        }

        .contact-info {
            flex: 1;
            min-width: 250px;
            padding: 20px;
        }

        .contact-info h3 {
            font-size: 20px;
            margin-bottom: 15px;
        }

        .contact-info p {
            margin: 5px 0;
            font-size: 16px;
        }

        .social-buttons a {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 8px 0;
            padding: 10px;
            background: #f1f1f1;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            color: #333;
        }

        .social-buttons a:hover {
            background: #ddd;
        }

        .footer {
            background-color: #001f3d;
            color: #ffffff;
            padding: 50px 0;
            text-align: center;
        }

        .container {
            display: flex ;
            max-width: 1200px;
            margin: auto;
            padding: 0 20px;
        }
*/
        .footer-bottom {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            opacity: 0.7;
            padding-top: 20px;
        }

        /* reach us css */
     /*   .contact-box {
            background: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .contact-box h5 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .contact-box p {
            margin: 20px 50px;
        }

        .contact-box a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .contact-box a:hover {
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td {
            padding: 10px;
            text-align: left;
        }

        table i {
            font-size: 18px;
            margin-right: 5px;
        }
        .container .row{
            display: flex;
        }
        .map{
            height: 400px;
            width: 800px;
        }
    */
    </style>
</head>

<body>
    <div id="header"></div>

    <div class="search-container">
        <h2>Find Your Perfect Home</h2>
        <form action="properties.php" method="GET" class="search-form">
            <input type="text" name="location" placeholder="Search by location, keyword...">
            <select name="bedrooms">
                <option value="">Bedrooms</option>
                <option value="1">1 Bedroom</option>
                <option value="2">2 Bedrooms</option>
                <option value="3">3 Bedrooms</option>
                <option value="4">4+ Bedrooms</option>
            </select>
            <select name="price">
                <option value="">Price</option>
                <option value="15000">₹15,000+</option>
                <option value="20000">₹20,000+</option>
                <option value="25000">₹25,000+</option>
                <option value="35000">₹35,000+</option>
            </select>
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="property-listings">
        <?php
        include 'db.php';

        $query = "SELECT * FROM properties WHERE 1";

        if (isset($_GET['location']) && !empty($_GET['location'])) {
            $location = $_GET['location'];
            $query .= " AND location LIKE '%$location%'";
        }
        if (isset($_GET['bedrooms']) && !empty($_GET['bedrooms'])) {
            $bedrooms = $_GET['bedrooms'];
            $query .= " AND bedrooms = $bedrooms";
        }
        if (isset($_GET['price']) && !empty($_GET['price'])) {
            $price = $_GET['price'];
            $query .= " AND price >= $price";
        }

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='property'>";
                $image_paths = json_decode($row['images'], true);
                // foreach ($image_paths as $img) {
                //     echo "<img src='../$img' alt='Property Image'>";
                // }
                if (!empty($image_paths)) {
                    echo "<img src='../$image_paths[0]' alt='Property Image'>";
                } else {
                    echo "<p>No image available</p>";
                }
                echo "<div class='property-content'>";
                echo "<h3>" . $row['title'] . "</h3>";
                echo "<p>" . $row['bedrooms'] . " Bed, " . $row['bathrooms'] . " Bath</p>";
                echo "<div class='property-price'>₹" . $row['price'] . "/month</div>";
                echo "<div class='property-description' id='desc" . $row['property_id'] . "'>";
                echo "<p>" . $row['description'] . "</p>";
                echo "</div>";
                echo "<button onclick=\"window.location.href='property_detail.php?property_id=" . $row['property_id'] . "'\">View Details</button>";
                echo "</div></div>";
            }
        } else {
            echo "<div class='no-results'>No properties found matching your criteria.</div>";
        }

        mysqli_close($conn);
        ?>
    </div>


    <h2 class="reach">REACH US</h2>
    <div class="reach-us">
        <div class="reach-container">
            <div class="map-container">
                <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3683.378063475556!2d72.81792397392896!3d22.602353131881696!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e50c43cdea6c7%3A0x5074fe9e0c1c8bd!2sCharotar%20University%20of%20Science%20and%20Technology%20(CHARUSAT)!5e0!3m2!1sen!2sin!4v1740319231776!5m2!1sen!2sin" loading="lazy"></iframe>
            </div>
            <div class="contact-info">
                <div class="contact-box">
                    <h3>Contact Us</h3>
                    <p><i class="bi bi-telephone-fill"></i> <a href="tel:+918849732148">+91 88497 32148</a></p>
                    <p><i class="bi bi-telephone-fill"></i> <a href="tel:+918849732148">+91 88497 32148</a></p>
                    <p><i class="bi bi-envelope-fill"></i><a href="mailto:Nestifymail@gmail.com"> Nestifymail@gmail.com</a></p>
                </div>
                <div class="contact-box-1">
                    <h3>Follow Us</h3>
                    <div class="social-buttons">
                        <a href="#"><i class="bi bi-twitter-x"></i> Twitter</a>
                        <a href="#"><i class="bi bi-instagram"></i> Instagram</a>
                        <a href="#"><i class="bi bi-facebook"></i> Facebook</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php include 'Footer.php'?>    
</body>

</html>