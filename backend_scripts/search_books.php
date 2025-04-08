<?php

header('Content-Type: application/json');
$search = $_GET['search'] ?? '';

require_once 'connect.php';

if (empty($search)) {
    $stmt = $conn->prepare("SELECT b.*, COUNT(bb.book_id) AS borrowed_copies FROM books b LEFT JOIN borrowed_books bb ON b.id = bb.book_id GROUP BY b.id ORDER BY b.title ASC");
} else {
    $search = '%' . $search . '%';
    $stmt = $conn->prepare("SELECT b.*, COUNT(bb.book_id) AS borrowed_copies FROM books b LEFT JOIN borrowed_books bb ON b.id = bb.book_id WHERE b.title LIKE ? OR b.author LIKE ? OR b.isbn LIKE ? GROUP BY b.id ORDER BY b.title ASC");
    $stmt->bind_param('sss', $search, $search, $search);
}

$stmt->execute();
$result = $stmt->get_result();

$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'author' => $row['author'],
        'publisher' => $row['publisher'],
        'published_date' => $row['published_date'],
        'copies_available' => $row['copies_available'] - $row['borrowed_copies'],
        'cover_photo' => $row['cover_photo'],
        'description' => $row['description'],
        'isbn' => $row['isbn'],
        'borrowed_copies' => $row['borrowed_copies']
    ];
}

echo json_encode([
    'books' => $books
]);

