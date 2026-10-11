<?php
include VIEW_PATH . '/user/partials/Header.php';
require_once CONFIG_PATH . '/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: AuthenticationPage.php');
    exit();
}

$user_id = intval($_SESSION['user_id']);

// Fetch user payment history
$query = "SELECT p.title AS property_name, p.location, py.amount, py.method, py.status, py.created_at 
          FROM payments py
          JOIN properties p ON py.property_id = p.property_id
          WHERE py.user_id = ?
          ORDER BY py.created_at DESC";

$result = db_query($conn, $query, "i", $user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History - Nestify</title>
    <link rel="icon" href="images/Nestify-Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="Style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 2%;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }

    </style>
</head>

<body>
    <div class="container">
        <h2>My Payment History</h2>
        <table>
            <thead>
                <tr>
                    <th>Property Name</th>
                    <th>Location</th>
                    <th>Amount (₹)</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['property_name']) . "</td>
                                <td>" . htmlspecialchars($row['location']) . "</td>
                                <td>₹" . number_format($row['amount'], 2) . "</td>
                                <td>" . htmlspecialchars($row['method']) . "</td>
                                <td>" . htmlspecialchars($row['status']) . "</td>
                                <td>" . date("d M Y, h:i A", strtotime($row['created_at'])) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No payment records found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2025 Nestify | All rights reserved.</p>
    </footer>
</body>

</html>

<?php mysqli_close($conn); ?>