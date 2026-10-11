<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properties - Nestify</title>
    <link rel="stylesheet" href="style.css">
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
<div class="search-container-prop">
    <form action="properties.php" method="GET" class="search-form">
        <input type="text" name="location" placeholder="Search by location, keyword..." >
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
    require_once CONFIG_PATH . '/database.php';

    $query = "SELECT * FROM properties WHERE 1";
        $types = ''; $params = [];
    
    if (isset($_GET['location']) && !empty($_GET['location'])) {
        $location = $_GET['location'];
        $query .= " AND location LIKE ?"; $types .= 's'; $params[] = '%' . $location . '%';
    }
    if (isset($_GET['bedrooms']) && !empty($_GET['bedrooms'])) {
        $bedrooms = $_GET['bedrooms'];
        $query .= " AND bedrooms = ?"; $types .= 'i'; $params[] = (int) $bedrooms;
    }
    if (isset($_GET['price']) && !empty($_GET['price'])) {
        $price = $_GET['price'];
        $query .= " AND price >= ?"; $types .= 'd'; $params[] = (float) $price;
    }

    $result = db_query($conn, $query, $types, ...$params);
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
<footer>
    <p>&copy; 2025 Nestify | All rights reserved.</p>
</footer>
</body>
</html>