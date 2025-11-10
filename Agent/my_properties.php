<?php
ob_start(); // Start output buffering to prevent header issues
include 'db.php';
include 'Header.php';

if (!isset($_SESSION['dealer_id'])) {
    $_SESSION['message'] = 'Unauthorized access. Please log in.';
    header('Location: AgentLogin.php');
    exit();
}

$dealer_id = $_SESSION['dealer_id'];

// Fetch properties listed by the logged-in agent
$stmt = $conn->prepare("SELECT * FROM Properties WHERE dealer_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $dealer_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>
<!-- toast of update property -->
<?php if (isset($_SESSION['message'])): ?>
    <div id="toast" class="toast show"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <script>
        setTimeout(() => { document.getElementById("toast").classList.remove("show"); }, 3000);
    </script>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Properties</title>
    <link rel="stylesheet" href="Style.css">
    <style>
        .toast {
            visibility: hidden;
            min-width: 250px;
            background-color: #28a745;
            color: white;
            text-align: center;
            border-radius: 5px;
            padding: 16px;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        .show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }
        @keyframes fadein {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes fadeout {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        .properties-container {
            width: 90%;
            margin: auto;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }
        .property-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 300px;
            transition: 0.3s;
        }
        .property-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .property-details {
            padding: 15px;
            text-align: center;
        }
        .property-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .property-price {
            color: #007BFF;
            font-size: 16px;
            font-weight: bold;
        }
        .property-actions {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .btn {
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            border-radius: 5px;
            text-decoration: none;
        }
        .edit-btn {
    background: #28a745;
    color: white;
    transition: background 0.3s ease;
}
.edit-btn:hover {
    background: #218838;
}

.delete-link {
    background: #dc3545;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
    display: inline-block;
    text-align: center;
    transition: background 0.3s ease;
}
.delete-link:hover {
    background: #c82333;
}

    </style>
</head>
<body><br>
    <h2 style="text-align:center; margin-top:20px;">My Properties</h2>
    <div class="properties-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="property-card" id="property-<?php echo $row['property_id']; ?>">
                <?php $images = json_decode($row['images'], true); ?>
                <img src="../<?php echo htmlspecialchars($images[0] ?? 'default.jpg'); ?>" alt="Property Image">
                <div class="property-details">
                    <div class="property-title"><?php echo htmlspecialchars($row['title']); ?></div>
                    <div class="property-price">₹<?php echo number_format($row['price']); ?>/month</div>
                    <div class="property-actions">
                        <a href="edit_property.php?property_id=<?php echo $row['property_id']; ?>" class="btn edit-btn" style="text-decoration: none;">Edit</a>
                        <a href="#" class="delete-link" data-property-id="<?php echo $row['property_id']; ?>" style="text-decoration: none;">Delete</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-link').forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    let propertyId = this.getAttribute('data-property-id');

                    if (confirm('Are you sure you want to delete this property?')) {
                        fetch('delete_property.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: 'property_id=' + propertyId
                        })
                        .then(response => response.text())
                        .then(data => {
                            if (data.trim() === 'success') {
                                document.getElementById('property-' + propertyId).remove();
                            } else {
                                alert('Failed to delete property.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php $conn->close(); ?>
