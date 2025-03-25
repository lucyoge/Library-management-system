<?php
require_once "connect.php";

if (isset($_POST["submit"])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    if ($_POST['password'] != $_POST['password_confirmation']) {
        header("Location: ../auth/create_account.php?error=passwords_do_not_match");
        exit;
    }
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn ->prepare("INSERT INTO users (fullname, phone, email, password_hash) VALUES (?, ?, ?, ?)");
    $stmt ->bind_param("ssss", $fullname, $phone, $email, $password);
    $stmt ->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../auth/login.php");
        exit;
    }
    else {
        echo "Error: " . $stmt->error;
    }
}

$stmt -> close();
$conn -> close();

?>