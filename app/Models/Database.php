<?php
/*
 * small helper for prepared statements, so sql isn't built by joining strings.
 * gives back a mysqli_result for SELECT and true/false for the rest, same as
 * mysqli_query($conn, $sql), so it can be used in the same places.
 *
 *   db_query($conn, "SELECT * FROM cart WHERE user_id = ?", "i", $userId);
 */
function db_query(mysqli $conn, string $sql, string $types = '', ...$params) {
    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;
    if ($types !== '') $stmt->bind_param($types, ...$params);
    if (!$stmt->execute()) return false;
    $res = $stmt->get_result();
    return $res === false ? true : $res;
}
