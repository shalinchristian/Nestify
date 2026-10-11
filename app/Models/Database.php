<?php
/**
 * Prepared-statement helper used wherever SQL used to be built by string
 * interpolation. Returns mysqli_result for SELECTs, bool otherwise, so it is a
 * drop-in replacement for mysqli_query($conn, $sql).
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
