<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["property_id"])) {
    $property_id = intval($_POST["property_id"]);
    $title = htmlspecialchars($_POST["title"]);
    $description = htmlspecialchars($_POST["description"]);
    $category = $_POST["category"];
    $price = floatval($_POST["price"]);
    $location = htmlspecialchars($_POST["location"]);
    $bedrooms = intval($_POST["bedrooms"]);
    $bathrooms = intval($_POST["bathrooms"]);
    $area = intval($_POST["area"]);
    $furnished = $_POST["furnished"];
    $availability = $_POST["availability"];

    // Fetch the existing image path from the database
    $sql = "SELECT images FROM Properties WHERE property_id = $property_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $existing_images = json_decode($row['images'], true) ?? [];

    // Delete old images from the server
    foreach ($existing_images as $old_image) {
        if (file_exists($old_image)) {
            unlink($old_image); // Remove the old image file
        }
    }

    // Handle Image Uploads - Store Only New Images
    $image_paths = [];
    if (!empty($_FILES['property_images']['name'][0])) {
        $upload_dir = "uploads/"; // Ensure this folder exists

        foreach ($_FILES['property_images']['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($_FILES['property_images']['name'][$key]);
            $target_file = $upload_dir . $file_name;

            // Validate file type
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (in_array($file_type, ['jpg', 'jpeg', 'png'])) {
                if (move_uploaded_file($tmp_name, $target_file)) {
                    $image_paths[] = $target_file; // Add new image path to array
                }
            }
        }
    }

    // Convert new image paths to JSON for storage
    $image_paths_json = json_encode($image_paths);

    // Update database with new data, replacing old image paths
    $sql = "UPDATE Properties SET 
        title = '$title', 
        description = '$description', 
        category = '$category', 
        price = $price, 
        location = '$location', 
        bedrooms = $bedrooms, 
        bathrooms = $bathrooms, 
        area = $area, 
        furnished = '$furnished', 
        availability = '$availability', 
        images = '$image_paths_json' 
        WHERE property_id = $property_id";

    if (mysqli_query($conn, $sql)) {
        $_SESSION["message"] = "Property updated successfully!";
    } else {
        $_SESSION["message"] = "Error updating property: " . mysqli_error($conn);
    }

    mysqli_close($conn);

    header("Location: my_properties.php");
    exit();
}
?>
