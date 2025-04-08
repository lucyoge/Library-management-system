<?php
    header('Content-Type: application/json');
    include_once "connect.php";

    // Fetch all borrowed books from the database
    $stmt = $conn->prepare("SELECT bb.*, b.title, u.fullname 
                            FROM borrowed_books bb
                            INNER JOIN books b ON bb.book_id = b.id
                            INNER JOIN users u ON bb.user_id = u.id
                            ORDER BY bb.borrowed_date DESC, bb.return_date DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $borrowed_books = [];
    while ($borrowed_book = $result->fetch_assoc()) {
        $borrowed_books[] = $borrowed_book;
    }

    echo json_encode([
        'borrowed_books' => $borrowed_books
    ]);

