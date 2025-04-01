<?php
// https://secure.php.net/manual/en/reserved.variables.php

require_once "connect.php";

if (isset($_POST["submit"])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn ->prepare("INSERT INTO users (fullname, phone, email, password_hash, role) VALUES (?, ?, ?, ?, ?)");
    $stmt ->bind_param("sssss", $fullname, $phone, $email, $password, $role);
    $stmt ->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../admin/manage_users.php");
        exit;
    }
    else {
        header("Location: ../admin/add_user.php?error=" . $stmt->error);
    }
}

$stmt -> close();
$conn -> close();

?>