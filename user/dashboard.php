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
        <section class="max-w-6xl mx-auto">
            <div class="mb-4">
                <form id="searchForm" class="flex justify-right">
                    <input type="text" id="searchInput" placeholder="Search books..." class="mr-2 p-2 border rounded">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search</button>
                </form>
            </div>
            <section class="my-4">
                <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] === 'book_id_failed') {
                        echo '<span class="text-red-500">Error: Book ID is missing.</span>';
                        echo '<script> alert("Book ID is missing.")</script>';
                    } elseif ($_GET['error'] === 'already_borrowed') {
                        echo '<span class="text-red-500">Error: Book is already borrowed by you. Kindly check your borrowed books.</span>';
                        echo '<script> alert("Book is already borrowed by you. Kindly check your borrowed books.")</script>';
                    } elseif ($_GET['error'] === 'max_borrowed_books') {
                        echo '<span class="text-red-500">Error: You have reached the maximum number of books that you can borrow. Kindly check your borrowed books.</span>';
                        echo '<script> alert("You have reached the maximum number of books that you can borrow. Kindly check your borrowed books.")</script>';
                    } elseif ($_GET['error'] === 'book_not_available') {
                        echo '<span class="text-red-500">Error: Book is not available for borrowing.</span>';
                        echo '<script> alert("Book is not available for borrowing.")</script>';
                    }
                }
                if (isset($_GET['success'])) {
                    if ($_GET['success'] === 'borrow_request_sent') {
                        echo '<span class="text-green-500">Success: Borrow request sent.</span>';
                        echo '<script> alert("Borrow request sent.")</script>';
                    } elseif ($_GET['success'] === 'book_returned') {
                        echo '<span class="text-green-500">Success: Book returned successfully.</span>';
                        echo '<script> alert("Book returned successfully.")</script>';
                    }
                }
                ?>
            </section>
            <table class="min-w-full bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr class="text-left">
                        <th class="py-2 px-4">Title</th>
                        <th class="py-2 px-4">Author</th>
                        <th class="py-2 px-4">Available</th>
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
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();
            fetchBooks();
        });

        function fetchBooks() {
            const search = document.getElementById('searchInput').value;

            fetch(`../backend_scripts/user/fetch_books.php?search=${encodeURIComponent(search)}`)
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
                                <td class="py-2 px-4">${book.copies_available}</td>
                                <td class="py-2 px-4">
                                    ${book.is_borrowed ? '<button type="button" class="bg-gray-300 hover:bg-gray-400 text-white font-bold py-2 px-4 rounded" disabled>Borrowed</button>' : `<a href="../backend_scripts/user/borrow.php?book_id=${book.id}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 inline-block rounded">Borrow</a>`}
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
        fetchBooks();
    </script>
</body>

</html>