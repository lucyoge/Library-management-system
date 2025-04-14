<?php
require_once "../connect.php";

if (isset($_GET['action']) && isset($_GET['record_id'])) {
    $action = $_GET['action'];
    $record_id = $_GET['record_id'];

    if ($action === 'cancel') {
        $stmt = $conn->prepare("DELETE FROM borrowed_books WHERE id = ?");
        $stmt->bind_param('i', $record_id);
        if ($stmt->execute()) {
            header('Location: ../../user/borrowed.php?success=cancel_success');
        } else {
            header('Location: ../../user/borrowed.php?error=cancel_failed');
        }
    } elseif ($action === 'return') {
        $stmt = $conn->prepare("UPDATE borrowed_books SET status = 'returned', return_date = NOW() WHERE id = ?");
        $stmt->bind_param('i', $record_id);
        if ($stmt->execute()) {
            header('Location: ../../user/borrowed.php?success=return_success');
        } else {
            header('Location: ../../user/borrowed.php?error=return_error');
        }
    }
} else {
    header('Location: ../../user/borrowed.php?error=missing_parameters');
    exit;
}

$conn->close();
?>
