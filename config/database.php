<?php
/*
 * database connection used by every page. gives $conn (mysqli)
 */
mysqli_report(MYSQLI_REPORT_OFF);
$conn = new mysqli(
    env('DB_HOST', '127.0.0.1'),
    env('DB_USER', 'root'),
    env('DB_PASS', ''),
    env('DB_NAME', 'nestify'),
    (int) env('DB_PORT', 3306)
);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
