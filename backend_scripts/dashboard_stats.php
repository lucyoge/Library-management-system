<?php
    header('Content-Type: application/json');
    include_once "connect.php";

    $stmt = $conn->prepare("SELECT COUNT(*) AS total_books FROM books");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_books = $row['total_books'];

    $stmt = $conn->prepare("SELECT COUNT(*) AS total_users FROM users");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_users = $row['total_users'];

    $stmt = $conn->prepare("SELECT COUNT(*) AS total_borrowed FROM borrowed_books");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_borrowed = $row['total_borrowed'];

    $stmt = $conn->prepare("SELECT b.title, u.fullname, b.isbn, bb.borrowed_date, bb.return_date 
                            FROM borrowed_books bb
                            INNER JOIN books b ON bb.book_id = b.id
                            INNER JOIN users u ON bb.user_id = u.id
                            ORDER BY bb.borrowed_date DESC
                            LIMIT 5");
    $stmt->execute();
    $result = $stmt->get_result();
    $recent_borrows = [];
    while ($row = $result->fetch_assoc()) {
        $recent_borrows[] = $row;
    }  
    
    $stmt = $conn->prepare("SELECT u.fullname, u.email, u.created_at
                            FROM users u
                            ORDER BY u.created_at DESC
                            LIMIT 5");
    $stmt->execute();
    $result = $stmt->get_result();
    $recently_added_users = [];
    while ($row = $result->fetch_assoc()) {
        $recently_added_users[] = $row;
    }  
    

    echo json_encode([
        'total_books' => $total_books, 
        'total_users' => $total_users, 
        'total_borrowed' => $total_borrowed,
        'recent_borrows' => $recent_borrows,
        'recent_users' => $recently_added_users
    ]);
?>