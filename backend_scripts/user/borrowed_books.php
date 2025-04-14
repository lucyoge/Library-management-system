<?php
session_start();
header('Content-Type: application/json');
include_once "../connect.php";

$user_id = $_SESSION['user']['id'];

// Fetch books borrowed by the logged in user

$stmt = $conn->prepare("SELECT b.*, bb.id AS record_id, bb.borrowed_date, bb.return_date, bb.status FROM books b INNER JOIN borrowed_books bb ON b.id = bb.book_id WHERE bb.user_id = ? ORDER BY b.title ASC");
$stmt->bind_param('i', $user_id);


$stmt->execute();
$result = $stmt->get_result();
$books = [];
while ($book = $result->fetch_assoc()) {
    $books[] = [
        'id' => $book['id'],
        'title' => $book['title'],
        'author' => $book['author'],
        'borrowed_date' => $book['borrowed_date'],
        'return_date' => $book['return_date'],
        'cover_photo' => $book['cover_photo'],
        'status' => $book['status'],
        'record_id' => $book['record_id'],
        'is_borrowed' => true,
    ];
}

echo json_encode([
    'books' => $books
]);
