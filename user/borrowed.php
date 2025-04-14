<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../auth/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Books</title>
    <script src="../css/tailwindcss.js"></script>
</head>

<body class="bg-gray-100">
    <header class="bg-blue-500 text-white py-2 px-4 flex justify-between">
        <h1 class="text-3xl">Library Borrowed Books</h1>
        <nav>
            <ul class="flex space-x-4">
                <li><a href="dashboard.php" class="hover:underline block py-2">Book List</a></li>
                <li><a href="borrowed.php" class="hover:underline block py-2">Borrowed Books</a></li>
                <li><a href="../auth/logout.php" class="hover:underline block py-2">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main class="container mx-auto p-4">
        <section class="max-w-6xl mx-auto">
            <div class="mb-4">
                <h1 class="text-2xl font-bold mb-4">Borrowed Books</h1>
            </div>
            <section class="my-4">
                <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] === 'return_error') {
                        echo '<span class="text-red-500">Error: Book return failed.</span>';
                        echo '<script> alert("Book return failed.")</script>';
                    } elseif ($_GET['error'] === 'missing_parameters') {
                        echo '<span class="text-red-500">Error: Missing parameters.</span>';
                        echo '<script> alert("Missing parameters.")</script>';
                    } else {
                        echo '<span class="text-red-500">Error: ' . htmlspecialchars($_GET['error']) . '</span>';
                        echo '<script> alert("' . htmlspecialchars($_GET['error']) . '")</script>';
                    }
                }
                if (isset($_GET['success'])) {
                    if ($_GET['success'] === 'return_success') {
                        echo '<span class="text-green-500">Success: Book returned successfully.</span>';
                        echo '<script> alert("Book returned successfully.")</script>';
                    } elseif ($_GET['success'] === 'cancel_success') {
                        echo '<span class="text-green-500">Success: Book borrow request cancelled successfully.</span>';
                        echo '<script> alert("Book borrow request cancelled successfully.")</script>';
                    }
                }
                ?>
            </section>
            <table class="min-w-full bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr class="text-left">
                        <th class="py-2 px-4">Title</th>
                        <th class="py-2 px-4">Author</th>
                        <th class="py-2 px-4">Borrowed Date</th>
                        <th class="py-2 px-4">Return Date</th>
                        <th class="py-2 px-4">Status</th>
                        <th class="py-2 px-4">Action</th>
                    </tr>
                </thead>
                <tbody id="booksTableBody">
                    <!-- Rows will be populated with JavaScript -->
                </tbody>
            </table>
        </section>
    </main>
    <script>

        function fetchBorrowedBooks() {
            fetch(`../backend_scripts/user/borrowed_books.php`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('booksTableBody');
                    let tableRows = '';
                    if (data.books.length > 0) {
                        data.books.forEach(book => {
                            tableRows += `<tr class="border-b border-gray-200 hover:bg-gray-100 odd:bg-white even:bg-gray-50">
                                <td class="py-2 px-4">
                                    <div class="flex items-center">
                                        <img src="${book.cover_photo}" alt="${book.title}" class="w-8 h-8 mr-2">
                                        <span class="font-bold">${book.title}</span>
                                    </div>
                                </td>
                                <td class="py-2 px-4">${book.author}</td>
                                <td class="py-2 px-4">${book.borrowed_date}</td>
                                <td class="py-2 px-4">${book.return_date || 'N/A'}</td>
                                <td class="py-2 px-4 text-${book.status === 'pending' ? 'orange-500' : book.status === 'borrowed' ? 'blue-500' : 'green-500'}">${book.status}</td>
                                <td class="py-2 px-4">
                                    ${book.status === 'pending' ? 
                                        `<a href="../backend_scripts/user/update_borrow.php?action=cancel&record_id=${book.record_id}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Cancel Request</a>` : 
                                        (book.status === 'returned' ? 
                                        `<a href="../backend_scripts/user/borrow.php?book_id=${book.id}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Borrow Again</a>` : 
                                        `<a href="../backend_scripts/user/update_borrow.php?action=return&record_id=${book.record_id}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Return Book</a>`)}
                                </td>
                            </tr>`
                        });
                        tableBody.innerHTML = tableRows;
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="4" class="text-center py-4">No books found</td></tr>';
                    }
                })
                .catch(error => console.error('Error fetching books:', error));
        }

        // Initial fetch to populate the table
        fetchBorrowedBooks();
    </script>
</body>

</html>
