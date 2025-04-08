<?php
require_once "connect.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("UPDATE borrowed_books SET status = 'borrowed' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../admin/borrowed_books.php?success=Book confirmation was successful.");
        exit;
    } else {
        header("Location: ../admin/borrowed_books.php?error=Book confirmation failed.");
        exit;
    }
} else {
    header("Location: ../admin/borrowed_books.php?error=No book ID provided.");
    exit;
}

$stmt->close();
$conn->close();