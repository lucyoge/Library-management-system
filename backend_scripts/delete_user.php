<?php

require_once "connect.php";

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../admin/manage_users.php");
        exit;
    } else {
        header("Location: ../admin/manage_users.php?error=delete_failed&user_id=" . $user_id);
    }
}

$stmt->close();
$conn->close();

