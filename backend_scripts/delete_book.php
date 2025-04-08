<?php

require_once "connect.php";

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    // Get the book record to delete the cover image file
    $stmt = $conn->prepare("SELECT cover_photo FROM books WHERE id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();

    if ($book) {
        // Delete the cover image file
        $cover_photo_path = $book['cover_photo'];
        if (file_exists($cover_photo_path)) {
            unlink($cover_photo_path);
        }else{
            echo "Cover image file not found." . $cover_photo_path;
            exit;
        }

        // Delete the book record
        $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
        $stmt->bind_param("i", $book_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: ../admin/manage_books.php");
            exit;
        } else {
            header("Location: ../admin/manage_books.php?error=delete_failed&book_id=" . $book_id);
        }
    } else {
        header("Location: ../admin/manage_books.php?error=book_not_found&book_id=" . $book_id);
    }
}

$stmt->close();
$conn->close();

