<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once CONFIG_PATH . '/database.php'; // Include database connection

if (!isset($_SESSION['dealer_id'])) {
    $_SESSION['message'] = 'Unauthorized access. Please log in.';
    header('Location: Frontend_Login.php');
    exit();
}

$dealer_id = $_SESSION['dealer_id'];
$dealer_name = $_SESSION['dealer_name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars(trim($_POST["title"]));
    $description = htmlspecialchars(trim($_POST["description"]));
    $category = htmlspecialchars(trim($_POST["category"]));
    $price = floatval($_POST["price"]);
    $location = htmlspecialchars(trim($_POST["location"]));
    $bedrooms = intval($_POST["bedrooms"]);
    $bathrooms = intval($_POST["bathrooms"]);
    $area = intval($_POST["area"]);
    $furnished = htmlspecialchars(trim($_POST["furnished"]));
    $availability = htmlspecialchars(trim($_POST["availability"]));

    $uploaded_images = [];
    $upload_directory = UPLOAD_PATH . "/"; // public/uploads (served at /uploads/...)

    // Ensure the uploads directory exists
    if (!is_dir($upload_directory)) {
        mkdir($upload_directory, 0777, true);
    }

    // Image upload handling
    foreach ($_FILES["property_images"]["tmp_name"] as $key => $tmp_name) {
        if ($_FILES["property_images"]["error"][$key] === UPLOAD_ERR_OK) {
            $image_name = $_FILES["property_images"]["name"][$key];
            $image_tmp = $_FILES["property_images"]["tmp_name"][$key];
            $image_size = $_FILES["property_images"]["size"][$key];
            $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png'];

            if (!in_array($image_ext, $allowed_types)) {
                $_SESSION['message'] = '❌ Invalid image format (only JPG, JPEG, PNG allowed).';
                header('Location: AgentDashboard.php');
                exit();
            }

            if ($image_size > 2 * 1024 * 1024) {
                $_SESSION['message'] = '❌ File size exceeds 2MB limit.';
                header('Location: AgentDashboard.php');
                exit();
            }

            // Generate a unique filename
            $new_image_name = uniqid('property_') . '.' . $image_ext;
            $image_path = $upload_directory . $new_image_name;

            // Move uploaded file
            if (move_uploaded_file($image_tmp, $image_path)) {
                // Store only the relative path in the database
                $uploaded_images[] = "uploads/" . $new_image_name;
            } else {
                $_SESSION['message'] = '❌ Image upload failed. Check folder permissions.';
                header('Location: AgentDashboard.php');
                exit();
            }
        } else {
            $_SESSION['message'] = '❌ Error in uploading file. Code: ' . $_FILES["property_images"]["error"][$key];
            header('Location: AgentDashboard.php');
            exit();
        }
    }

    // Convert image paths array to JSON
    $images_json = json_encode($uploaded_images, JSON_UNESCAPED_SLASHES);

    // Insert property into database
    $stmt = $conn->prepare("INSERT INTO Properties (dealer_id, title, description, category, price, location, bedrooms, bathrooms, area, furnished, availability, images, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    if (!$stmt) {
        $_SESSION['message'] = '❌ Database error: ' . $conn->error;
        header('Location: AgentDashboard.php');
        exit();
    }

    $stmt->bind_param("isssdsiissss", $dealer_id, $title, $description, $category, $price, $location, $bedrooms, $bathrooms, $area, $furnished, $availability, $images_json);

    if ($stmt->execute()) {
        $_SESSION['message'] = '✅ Property added successfully!';
    } else {
        $_SESSION['message'] = '❌ Database error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header('Location: AgentDashboard.php');
    exit();
}
?>
