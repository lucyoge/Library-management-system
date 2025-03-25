<?php
// session_start();

// if (!isset($_SESSION['user'])) {
//     header('Location: ../auth/login.php');
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="../css/tailwindcss.js"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-blue-500 text-white py-2 px-4 flex justify-between">
        <h1 class="text-3xl">Library User Dashboard</h1>
        <nav>
            <ul class="flex space-x-4">
                <li><a href="dashboard.php" class="hover:underline block py-2">Book List</a></li>
                <li><a href="borrowed.php" class="hover:underline block py-2">Borrowed Books</a></li>
                <li><a href="../auth/logout.php" class="hover:underline block py-2">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main class="container mx-auto p-4">
        <div class="mb-4">
            <form action="" method="GET" class="flex justify-right">
                <input type="text" name="search" placeholder="Search books..." class="mr-2 p-2 border rounded">
                <select name="filter" class="mr-2 p-2 border rounded">
                    <option value="">All</option>
                    <option value="available">Available</option>
                    <option value="borrowed">Borrowed</option>
                </select>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search</button>
            </form>
        </div>
        <table class="min-w-full bg-white">
            <thead>
                <tr class="text-left">
                    <th class="py-2 px-4">Title</th>
                    <th class="py-2 px-4">Author</th>
                    <th class="py-2 px-4">Available</th>
                    <th class="py-2 px-4">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example row, replace with dynamic data -->
                <tr>
                    <td class="py-2 px-4">Book Title</td>
                    <td class="py-2 px-4">Author Name</td>
                    <td class="py-2 px-4">Yes</td>
                    <td class="py-2 px-4">
                        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded">Borrow</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
</body>
</html>
s