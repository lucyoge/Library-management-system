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
    <title>Add Book</title>
    <script src="../css/tailwindcss.js"></script>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
</head>

<body class="bg-slate-100">
    <?php include 'components/header.html'; ?>
    <main class="container max-w-md mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Add Book</h1>
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="../backend_scripts/add_book.php" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Title
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" placeholder="Book Title" name="title" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="author">
                    Author
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="author" type="text" placeholder="Author" name="author" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="isbn">
                    ISBN
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="isbn" type="text" placeholder="ISBN" name="isbn" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="publisher">
                    Publisher
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="publisher" type="text" placeholder="Publisher" name="publisher" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="published_date">
                    Published Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="published_date" type="date" placeholder="Published Date" name="published_date" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="copies_available">
                    No. of Copies
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="copies_available" type="number" placeholder="Copies Available" name="copies_available" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="cover">
                    Cover
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="cover" type="file" placeholder="Cover" name="cover" required>
            </div>
            <div class="flex items-center justify-between">
                <button name="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Add Book
                </button>
            </div>
        </form>
    </main>
</body>

</html>