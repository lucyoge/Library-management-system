<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../auth/login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="../css/tailwindcss.js"></script>
</head>

<body>
    <header class="bg-blue-500 text-white p-4">
        <h1 class="text-3xl">Library Management System</h1>
    </header>
    <nav class="bg-white p-4 shadow">
        <ul class="flex items-center justify-end gap-4">
            <li class="mr-4">
                <a href="dashboard.php" class="text-blue-500">Dashboard</a>
            </li>
            <li class="mr-4">
                <a href="manage_users.php" class="text-blue-500">Manage Users</a>
            </li>
            <li class="mr-4">
                <a href="manage_books.php" class="text-blue-500">Manage Books</a>
            </li>
            <li class="mr-4">
                <a href="logout.php" class="text-blue-500">Logout</a>
            </li>
        </ul>
    </nav>
    <main class="container mx-auto p-4 min-h-96 flex justify-center items-center">
        <div class="text-center">
            <h2 class="text-4xl font-bold">Welcome to the Admin Dashboard</h2>
            <p class="text-gray-600">You can manage users, books and other library operations from here.</p>
            <div class="mt-4">
                <a href="manage_users.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full inline-block">Manage Users</a>
                <a href="manage_books.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full inline-block ml-4">Manage Books</a>
            </div>
        </div>
    </main>
</body>

</html>
