<?php

require_once "connect.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM borrowed_books WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../admin/borrowed_books.php?success=delete_success");
        exit;
    } else {
        header("Location: ../admin/borrowed_books.php?error=delete_failed&id=" . $id);
    }
}

$stmt->close();
$conn->close();

?>
