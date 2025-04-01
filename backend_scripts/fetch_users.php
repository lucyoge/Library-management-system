<?php
    header('Content-Type: application/json');
    include_once "connect.php";

    // Fetch all users from the database
    $stmt = $conn->prepare("SELECT * FROM users ORDER BY fullname ASC");
    $stmt->execute();
    $result = $stmt->get_result();
    $users = [];
    while ($user = $result->fetch_assoc()) {
        $users[] = $user;
    }

    echo json_encode([
        'users' => $users
    ]);