<?php

require_once "connect.php";

if (isset($_POST["submit"])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, role, password_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password_hash'])) {
        session_start();

        if ($user['role'] == 'admin') {
            $_SESSION['admin'] = $user;
            header("Location: ../admin/dashboard.php");
        } else {
            $_SESSION['user'] = $user;
            header("Location: ../user/dashboard.php");
        }
        exit;
    } else {
        header("Location: ../auth/login.php?error=invalid_credentials");
        exit;
    }
}

$stmt->close();
$conn->close();
