<?php
session_start();
header('Content-Type: application/json');
include_once "../connect.php";

$user_id = $_SESSION['user']['id'];

// Fetch all books from the database
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%';
    $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); // Sanitize input by converting both double and single quotes. Reference https://php.net/manual/en/function.htmlspecialchars.php
    $stmt = $conn->prepare("SELECT b.*, COUNT(bb.book_id) AS borrowed_copies FROM books b LEFT JOIN borrowed_books bb ON b.id = bb.book_id WHERE b.title LIKE ? OR b.author LIKE ? GROUP BY b.id ORDER BY b.title ASC");
    $stmt->bind_param('ss', $search, $search);
    // Execute the statement
    $stmt->execute();
} else {
    $stmt = $conn->prepare("SELECT b.*, COUNT(bb.book_id) AS borrowed_copies FROM books b LEFT JOIN borrowed_books bb ON b.id = bb.book_id GROUP BY b.id ORDER BY b.title ASC");
    $stmt->execute();
}
$result = $stmt->get_result();
$books = [];
while ($book = $result->fetch_assoc()) {
    $books[] = [
        'id' => $book['id'],
        'title' => $book['title'],
        'author' => $book['author'],
        'publisher' => $book['publisher'],
        'published_date' => $book['published_date'],
        'copies_available' => $book['copies_available'] - $book['borrowed_copies'],
        'cover_photo' => $book['cover_photo'],
        'description' => $book['description'],
        'isbn' => $book['isbn'],
        'borrowed_copies' => $book['borrowed_copies'],
        'is_borrowed' => isBorrowed($conn, $book['id'], $user_id) ? true : false,
    ];
}

echo json_encode([
    'books' => $books
]);


function isBorrowed($conn, $book_id, $user_id) {
    $stmt = $conn->prepare("SELECT * FROM borrowed_books WHERE book_id = ? AND user_id = ? AND status != 'returned'");
    if (!$stmt) {
        return false; // Handle error
    }
    $stmt->bind_param("ii", $book_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}