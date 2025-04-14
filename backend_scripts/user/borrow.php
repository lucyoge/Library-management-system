<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../../auth/login.php');
    exit;
}

if (!isset($_GET['book_id'])) {
    header('Location: ../../user/dashboard.php?error=book_id_failed');
}

$book_id = $_GET['book_id'];
$user_id = $_SESSION['user']['id'];

require_once "../connect.php";

// Check if the user have borrowed the maximum number of books allowed
$stmt = $conn->prepare("SELECT COUNT(*) AS borrowed_count FROM borrowed_books WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if ($row['borrowed_count'] >= 3) {
    header('Location: ../../user/dashboard.php?error=max_borrowed_books');
    exit;
}

// Check if the book is already borrowed by the user
$stmt = $conn->prepare("SELECT * FROM borrowed_books WHERE user_id = ? AND book_id = ? AND status != 'returned'");
$stmt->bind_param("ii", $user_id, $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header('Location: ../../user/dashboard.php?error=already_borrowed');
    exit;
}

// Check if the book is available for borrowing
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ? AND copies_available > 0");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header('Location: ../../user/dashboard.php?error=book_not_available');
    exit;
}

// Insert the borrow request into the database
$stmt = $conn->prepare("INSERT INTO borrowed_books (user_id, book_id, status) VALUES (?, ?, 'pending')");
$stmt->bind_param("ii", $user_id, $book_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header('Location: ../../user/dashboard.php?success=borrow_request_sent');
} else {
    header('Location: ../../user/dashboard.php?error=borrow_request_failed');
}
