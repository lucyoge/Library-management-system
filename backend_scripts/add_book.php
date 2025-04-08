<?php
// https://secure.php.net/manual/en/reserved.variables.php

require_once "connect.php";

if (isset($_POST["submit"])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $publisher = mysqli_real_escape_string($conn, $_POST['publisher']);
    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
    $published_date = mysqli_real_escape_string($conn, $_POST['published_date']);
    $copies_available = mysqli_real_escape_string($conn, $_POST['copies_available']);
    $cover = mysqli_real_escape_string($conn, $_FILES['cover']['name']);

    // File upload
    $target_dir = "../images/uploaded/books/";
    $cover_image = null;
    if (isset($_FILES['cover'])) {
        // If directory doesn't exist, create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . $cover;
        if (move_uploaded_file($_FILES['cover']['tmp_name'], $target_file)) {
            $cover_image = $target_file;
        }
    }

    $stmt = $conn->prepare("INSERT INTO books (title, author, publisher, isbn, published_date, copies_available, cover_photo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssis", $title, $author, $publisher, $isbn, $published_date, $copies_available, $cover_image);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../admin/manage_books.php");
        exit;
    } else {
        header("Location: ../admin/add_book.php?error=" . $stmt->error);
    }
}

$stmt->close();
$conn->close();
