<?php
    require_once CONFIG_PATH . '/database.php';
    include VIEW_PATH . '/user/partials/Header.php';

    if (!isset($_SESSION['user_id'])) {
        header('Location: AuthenticationPage.php');
        exit();
    }

    $user_id = intval($_SESSION['user_id']); // Logged-in user ID

    if (!isset($_GET['property_id']) || empty($_GET['property_id'])) {
        echo "Invalid property selection.";
        exit();
    }

    $property_id = intval($_GET['property_id']);

    // Fetch property details
    $query = "SELECT * FROM properties WHERE property_id = ?";
    $result = db_query($conn, $query, "i", $property_id);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo "Property not found.";
        exit();
    }

    $property = mysqli_fetch_assoc($result);

    // Check if the property is already in the cart
    $cart_query = "SELECT * FROM cart WHERE user_id = ? AND property_id = ?";
    $cart_result = db_query($conn, $cart_query, "ii", $user_id, $property_id);
    $is_in_cart = mysqli_num_rows($cart_result) > 0;

    // Check if the property is already in favorites
    $fav_query = "SELECT * FROM favorites WHERE user_id = ? AND property_id = ?";
    $fav_result = db_query($conn, $fav_query, "ii", $user_id, $property_id);
    $is_favorited = mysqli_num_rows($fav_result) > 0;





    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($property['title']); ?> - Nestify</title>
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="images/Nestify-Logo.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">

        <style>
            /* General Styles */
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }

            .section-title {
                text-align: center;
                font-size: 32px;
                font-weight: bold;
                color: #333;
                margin-top: 8%;
            }

            .property-container {
                display: flex;
                max-width: 900px;
                margin: 40px auto;
                padding: 20px;
                background: #ffffff;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                position: relative;
            }

            /* Swiper Slider */
            .swiper-container {
                width: 100%;
                max-width: 500px;
                height: 350px;
                border-radius: 10px;
                overflow: hidden;
            }

            .swiper-slide img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 10px;
            }

            .swiper-button-next,
            .swiper-button-prev {
                color: #000;
            }

            .swiper-pagination {
                bottom: 65px;
                right: 150px;
            }

            .property-details {
                width: 50%;
                padding: 10px;
            }

            .property-details h2 {
                font-size: 24px;
                color: #333;
                margin-bottom: 10px;
            }

            .property-details-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            .property-details-table td {
                padding: 12px;
                border-bottom: 1px solid #ddd;
                font-size: 16px;
                color: #555;
            }

            .property-details-table td:first-child {
                font-weight: bold;
                color: #333;
                width: 35%;
            }

            /* Buttons */
            .cart-btn,
            .fav-btn {
                padding: 12px 20px;
                border: none;
                border-radius: 5px;
                font-size: 16px;
                cursor: pointer;
                transition: all 0.3s ease-in-out;
            }

            .cart-btn.added {
                background-color: #ffc107 !important;
                color: black !important;
                transform: scale(1.05);
                font-weight: bold;
            }

            .cart-btn.not-added {
                background-color: #28a745;
                color: white;
            }

            .cart-btn.not-added:hover {
                background-color: #218838;
            }

            .fav-btn {
                position: absolute;
                bottom: 25px;
                font-size: 28px;
                cursor: pointer;
                background: none;
                border: none;
                left: 78%;
            }

            .fav-btn .bi-heart {
                color: gray;
            }

            .fav-btn .bi-heart-fill {
                color: red;
                display: none;
            }

            .fav-btn.favorited .bi-heart {
                display: none;
            }

            .fav-btn.favorited .bi-heart-fill {
                display: inline;
            }

            /* Adjust Swiper Navigation Buttons */
            .swiper-button-next,
            .swiper-button-prev {
                color: white !important;
                padding: 28px;
                transition: all 0.3s ease-in-out;
            }

            /* Reduce distance by changing left & right values */
            .swiper-button-prev {
                left: 1%;
                bottom: 0px;
            }

            .swiper-button-next {
                right: 41%;
                bottom: 0px;
            }

            /* dealer css */
            .contact-dealer {
                max-width: 900px;
                margin: 20px auto;
                padding: 20px;
                background: white;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

            .contact-dealer h3 {
                font-size: 22px;
                color: #333;
                margin-bottom: 15px;
            }

            .contact-dealer textarea {
                width: 100%;
                height: 100px;
                padding: 10px;
                font-size: 16px;
                border: 1px solid #ccc;
                border-radius: 5px;
                resize: none;
            }

            .contact-dealer button {
                padding: 8px 19px;
                border: none;
                background-color: #007bff;
                color: white;
                margin-top: 5px;
                font-size: 16px;
                border-radius: 5px;
                cursor: pointer;
                transition: 0.3s;
            }

            .contact-dealer button:hover {
                background-color: #0056b3;
            }

            /* Notification Styling */
            .notification {
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: #28a745;
                color: white;
                padding: 12px 20px;
                border-radius: 5px;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
                font-size: 16px;
                font-weight: bold;
                display: flex;
                align-items: center;
                gap: 10px;
                z-index: 1000;
                animation: fadeIn 0.5s ease-out;
            }

            /* Error Message */
            .notification.error {
                background: #dc3545;
            }

            /* Close Button */
            .notification .close-btn {
                cursor: pointer;
                margin-left: 15px;
                font-size: 18px;
                font-weight: bold;
            }

            /* Fade In Animation */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    top: 0px;
                }

                to {
                    opacity: 1;
                    top: 20px;
                }
            }

            /* Auto Fade Out */
            @keyframes fadeOut {
                from {
                    opacity: 1;
                    top: 20px;
                }

                to {
                    opacity: 0;
                    top: 0px;
                }
            }

            /* payment method */
            .popup-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .popup-content {
                background: white;
                padding: 20px;
                border-radius: 10px;
                text-align: center;
                width: 300px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

            .popup-content h3 {
                margin-bottom: 15px;
            }

            .popup-content input {
                width: 100%;
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            .popup-content img {
                width: 200px;
                height: 200px;
                margin-bottom: 10px;
            }
        </style>
    </head>

    <body>

        <div class="section-title">Property Details</div>

        <!-- notification -->
        <?php if (isset($_SESSION['message_sent'])): ?>
            <div class="notification success">
                <p><?php echo $_SESSION['message_sent']; ?></p>
            </div>
            <?php unset($_SESSION['message_sent']); ?>
        <?php endif; ?>

        <div class="property-container">
            <div class="property-image-box">
                <!-- Swiper Slider -->
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php
                        $image_paths = json_decode($property['images'], true);
                        if (!empty($image_paths)) {
                            foreach ($image_paths as $img) {
                                echo "<div class='swiper-slide'><img src='../$img' alt='Property Image'></div>";
                            }
                        } else {
                            echo "<p>No image available</p>";
                        }
                        ?>
                    </div>
                    <!-- Swiper Navigation -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination" style=" bottom: 65px; left:-150px; "></div>
                </div>

                <!-- Favorite Button -->
                <button class="fav-btn <?php echo $is_favorited ? 'favorited' : ''; ?>"
                    id="fav-btn-<?php echo $property_id; ?>"
                    onclick="toggleFavorite(<?php echo $property_id; ?>)">
                    <i class="bi bi-heart"></i>
                    <i class="bi bi-heart-fill"></i>
                </button>
            </div>

            <div class="property-details">
                <h2><?php echo htmlspecialchars($property['title']); ?></h2>

                <table class="property-details-table">
                    <tr>
                        <td>Location:</td>
                        <td><?php echo htmlspecialchars($property['location']); ?></td>
                    </tr>
                    <tr>
                        <td>Price:</td>
                        <td>₹<?php echo htmlspecialchars($property['price']); ?></td>
                    </tr>
                    <tr>
                        <td>Bedrooms:</td>
                        <td><?php echo htmlspecialchars($property['bedrooms']); ?></td>
                    </tr>
                    <tr>
                        <td>Bathrooms:</td>
                        <td><?php echo htmlspecialchars($property['bathrooms']); ?></td>
                    </tr>
                    <tr>
                        <td>Area:</td>
                        <td><?php echo htmlspecialchars($property['area']); ?> sq ft</td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td><?php echo htmlspecialchars($property['description']); ?></td>
                    </tr>
                </table><br>

                <button class="cart-btn <?php echo $is_in_cart ? 'added' : 'not-added'; ?>"
                    id="cart-btn-<?php echo $property_id; ?>"
                    onclick="addToCart(<?php echo $property_id; ?>)">
                    <?php echo $is_in_cart ? '✔ Already in Cart' : 'Add to Cart'; ?>
                </button><br><br>
                <!-- Add this below the Add to Cart button -->

                <?php
                $payment_query = "SELECT p.category FROM payments pm 
                  JOIN properties p ON pm.property_id = p.property_id 
                  WHERE pm.property_id = ? AND pm.user_id = ? AND pm.status = 'Completed'";
                $payment_result = db_query($conn, $payment_query, "ii", $property_id, $user_id);
                $is_booked = mysqli_num_rows($payment_result) > 0;
                $category_name = $is_booked ? mysqli_fetch_assoc($payment_result)['category'] : '';
                ?>

                <!-- Book Now Button -->
                <button class="cart-btn <?php echo $is_booked ? 'added' : 'not-added'; ?>"
                    id="book-now-btn"
                    onclick="<?php echo $is_booked ? '' : 'openPaymentPopup()'; ?>"
                    <?php echo $is_booked ? 'disabled' : ''; ?>>
                    <?php echo $is_booked ? "✔ $category_name Booked" : "Book Now"; ?>
                </button>



                <!-- Payment Popup -->
                <div id="payment-popup" class="popup-overlay" style="display:none;">
                    <div class="popup-content">
                        <h3>Select Payment Method</h3>
                        <button class="cart-btn not-added" onclick="showUPIPayment()">Pay by UPI</button>
                        <button class="cart-btn not-added" onclick="generateQR(<?php echo $property['price']; ?>)">Pay by QR</button>
                        <br><br>

                        <!-- UPI Payment Section -->
                        <div id="upi-payment" style="display:none;">
                            <input type="text" id="upi-id" placeholder="Enter your UPI ID">
                            <button class="cart-btn not-added" onclick="payByUPI(<?php echo $property_id; ?>, '<?php echo $property['price']; ?>')">Pay Now</button>
                        </div>

                        <!-- QR Code Payment Section -->
                        <div id="qr-payment" style="display:none;">
                            <img id="qr-code" src="" alt="QR Code">
                            <p>Amount: ₹<?php echo $property['price']; ?></p>
                            <button class="cart-btn not-added" onclick="confirmPayment(<?php echo $property_id; ?>)">Mark as Paid</button>
                        </div><br>

                        <button class="cart-btn" onclick="closePaymentPopup()">Close</button>
                    </div>
                </div>

                <script>
                    function confirmPayment(propertyId) {
                        let amount = <?php echo json_encode($property['price']); ?>;

                        $.post("process_payment.php", {
                            property_id: propertyId,
                            amount: amount,
                            method: "QR"
                        }, function(response) {
                            let result = JSON.parse(response);
                            if (result.status === "success") {
                                let bookNowBtn = $("#book-now-btn");
                                bookNowBtn.text(`✔ ${result.category} Booked`).addClass("added").prop("disabled", true);
                            }
                            alert(result.status === "success" ? "Payment Successful!" : "Payment Failed!");
                            closePaymentPopup();
                        });
                    }

                    function openPaymentPopup() {
                        document.getElementById("payment-popup").style.display = "flex";
                    }

                    function closePaymentPopup() {
                        document.getElementById("payment-popup").style.display = "none";
                    }

                    function showUPIPayment() {
                        document.getElementById("upi-payment").style.display = "block";
                        document.getElementById("qr-payment").style.display = "none";
                    }

                    function generateQR(price) {
                        let upiID = "8849732148@fam"; // Replace with actual UPI ID
                        let qrData = `upi://pay?pa=${upiID}&pn=Nestify&am=${price}&cu=INR`;
                        let qrCodeURL = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(qrData)}`;

                        document.getElementById("qr-code").src = qrCodeURL;
                        document.getElementById("qr-payment").style.display = "block";
                        document.getElementById("upi-payment").style.display = "none";
                    }

                    function confirmPayment(propertyId) {
                        let amount = <?php echo json_encode($property['price']); ?>;

                        $.post("process_payment.php", {
                            property_id: propertyId,
                            amount: amount,
                            method: "QR"
                        }, function(response) {
                            let result = JSON.parse(response);
                            if (result.status === "success") {
                                let bookNowBtn = document.getElementById("book-now-btn");
                                bookNowBtn.innerHTML = `Booked (${result.category})`;
                                bookNowBtn.disabled = true;
                                bookNowBtn.classList.add("added");
                            }
                            alert(result.status === "success" ? "Payment Successful!" : "Payment Failed!");
                            closePaymentPopup();
                            location.reload(); // Reload page to reflect booking
                        });
                    }


                    function payByUPI(propertyId) {
                        let amount = <?php echo json_encode($property['price']); ?>; // Fetch price dynamically
                        let upiId = document.getElementById("upi-id").value;

                        if (upiId === "") {
                            alert("Please enter your UPI ID");
                            return;
                        }

                        $.post("process_payment.php", {
                            property_id: propertyId,
                            upi_id: upiId,
                            amount: amount, // Ensure amount is sent
                            method: "UPI"
                        }, function(response) {
                            let result = JSON.parse(response);
                            alert(result.status === "success" ? "Payment Successful!" : "Payment Failed!");
                            closePaymentPopup();
                        });
                    }

                    function confirmPayment(propertyId) {
                        $.post("process_payment.php", {
                            property_id: propertyId,
                            method: "QR",
                        }, function(response) {
                            alert(response);
                            closePaymentPopup();
                        });
                    }
                </script>

            </div>
        </div>
        <div class="contact-dealer">
            <h3>Contact Dealer</h3>
            <form action="send_message.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <input type="hidden" name="dealer_id" value="<?php echo $property['dealer_id']; ?>">
                <input type="hidden" name="property_id" value="<?php echo $property_id; ?>">
                <textarea name="message" placeholder="(Your Last Message send to the Dealer)Type your message here..." required></textarea>
                <button type="submit">Send Message</button>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
        <script>
            function addToCart(propertyId) {
                let cartButton = $("#cart-btn-" + propertyId);
                $.post("add_to_cart.php", {
                    property_id: propertyId
                }, function(response) {
                    if (response.trim() === "success") {
                        cartButton.text("✔ Already in Cart").addClass("added");
                    }
                });
            }

            function toggleFavorite(propertyId) {
                let favButton = $("#fav-btn-" + propertyId);
                $.post("add_to_favorites.php", {
                    property_id: propertyId
                }, function(response) {
                    favButton.toggleClass("favorited");
                });
            }
            var swiper = new Swiper('.swiper-container', {
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false
                }
            });
            setTimeout(() => {
                let notification = document.querySelector('.notification');
                if (notification) {
                    notification.style.animation = "fadeOut 0.5s ease-out forwards";
                    setTimeout(() => notification.remove(), 500);
                }
            }, 3000);
        </script>
        <footer>
            <p>&copy; 2025 Nestify | All rights reserved.</p>
        </footer>
    </body>

    </html>
    <?php mysqli_close($conn); ?>