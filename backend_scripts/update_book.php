<?php

require_once "connect.php";

if (isset($_POST["submit"])) {
    $book_id = $_POST['book_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $publisher = mysqli_real_escape_string($conn, $_POST['publisher']);
    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
    $published_date = mysqli_real_escape_string($conn, $_POST['published_date']);
    $cover_image = $_FILES['cover_image']['name'];

    if (empty($cover_image)) {
        $stmt = $conn->prepare("SELECT cover_photo FROM books WHERE id = ?");
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $stmt->bind_result($current_cover_image);
        $stmt->fetch();
        $cover_image = $current_cover_image;
        $stmt->close();
    } else {
        $target_dir = "../images/uploaded/books/";
        $target_file = $target_dir . basename($cover_image);
        if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $target_file)) {
            $cover_image = $target_file;
        }
    }

    $stmt = $conn->prepare("UPDATE books SET title = ?, author = ?, publisher = ?, isbn = ?, published_date = ?, cover_photo = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $title, $author, $publisher, $isbn, $published_date, $cover_image, $book_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../admin/manage_books.php");
        exit;
    } else {
        header("Location: ../admin/edit_book.php?error=" . urlencode($stmt->error) . "&book_id=" . $book_id);
    }

    $stmt->close();
}

$conn->close();

?>

