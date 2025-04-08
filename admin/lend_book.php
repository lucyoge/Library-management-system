<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../backend_scripts/connect.php';

if (!isset($_GET['book_id'])) {
    header('Location: manage_books.php?error=book_id_failed');
    exit;
}

$book_id = $_GET['book_id'];

// Fetch users
$stmt_users = $conn->prepare("SELECT id, fullname FROM users");
$stmt_users->execute();
$result_users = $stmt_users->get_result();
$users = [];
while ($row = $result_users->fetch_assoc()) {
    $users[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO borrowed_books (user_id, book_id, status) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $book_id, $status);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: manage_books.php?message=book_assigned_successfully");
        exit;
    } else {
        $error = "Failed to assign book.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Book</title>
    <script src="../css/tailwindcss.js"></script>
    <link rel="shortcut icon" href="../images/logo.png" type="image/*">
</head>

<body class="bg-slate-100">
    <?php include 'components/header.html'; ?>
    <main class="container max-w-md mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Assign Book</h1>

        <?php if (isset($error)): ?>
            <p class="text-red-500"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="user_id">
                    Select User
                </label>
                <select name="user_id" id="user_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">-- Select a user --</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['fullname']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
                    Status
                </label>
                <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">-- Select a status --</option>
                    <option value="pending">Pending</option>
                    <option value="borrowed">Borrowed</option>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <a href="manage_books.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Assign Book
                </button>
            </div>
        </form>
    </main>
</body>

</html>