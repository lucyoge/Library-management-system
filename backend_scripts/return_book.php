<?php

require_once "connect.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $stmt = $conn->prepare("UPDATE borrowed_books SET return_date = NOW(), status = 'returned' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Book returned successfully";
    } else {
        echo "Failed to return book";
    }
}

$stmt->close();
$conn->close();
