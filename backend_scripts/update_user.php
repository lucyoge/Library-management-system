<?php
// https://secure.php.net/manual/en/reserved.variables.php

require_once "connect.php";

if (isset($_POST["submit"])) {
    $user_id = $_POST['user_id'];
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = $_POST['password'];

    if (empty($password)) {
        $stmt = $conn->prepare("SELECT password_hash FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($current_password);
        $stmt->fetch();
        $password = $current_password;
    } else {
        $password = password_hash($password, PASSWORD_BCRYPT);
    }

    $stmt = $conn ->prepare("UPDATE users SET fullname = ?, phone = ?, email = ?, password_hash = ?, role = ? WHERE id = ?");
    $stmt ->bind_param("sssssi", $fullname, $phone, $email, $password, $role, $user_id);
    $stmt ->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../admin/manage_users.php");
        exit;
    }
    else {
        header("Location: ../admin/edit_user.php?error=" . $stmt->error . "&user_id=" . $user_id);
    }
}

$stmt -> close();
$conn -> close();

?>
