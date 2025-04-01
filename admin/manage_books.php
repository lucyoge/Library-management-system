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
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
</head>

<body class="bg-slate-100">
    <?php include 'components/header.html'; ?>
    <main class="container max-w-6xl mx-auto px-4 py-8">
        <div class="mb-5 flex items-center justify-between">
            <span class="text-xl font-semibold mb-2">
                Manage Books
            </span>

            <section class="flex items-center space-x-4">
                <input type="text" placeholder="Search books..." class="p-2 border rounded">
                <a href="add_book.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add Book
                </a>
                <a href="borrowed_books.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    View Borrowed
                </a>
            </section>
        </div>
        <div class="grid grid-cols-4 gap-4">
            <div class="bg-white shadow-md rounded">
                <div class="w-full h-48">
                    <img src="../images/cover.jpg" alt="Book Cover" class="object-cover">
                </div>
                <div class="p-4 space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold">Book Title 1</span>
                    </div>
                    <p class="text-gray-700 text-sm">Author: John Doe</p>
                    <p class="text-gray-700 text-sm">Publisher: ABC Publisher</p>
                    <p class="text-gray-700 text-sm">Year: 2020</p>
                    <p class="text-gray-700 text-sm">Quantity: 5</p>
                    <div class="space-x-2 mt-4">
                        <a href="edit_book.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                            Edit
                        </a>
                        <a href="#" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                            Delete
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function fetchBooks() {
            fetch("../backend_scripts/fetch_books.php")
                .then(response => response.json())
                .then(data => {
                    let bookList = '';
                    showFirstBook(data.books[0]); // Show first book by default
                    data.books.forEach(book => {
                        bookList += `<li role="button" onclick="displaySelectedBook(${book.id}, '${book.title}', '${book.author}', '${book.publisher}', '${book.year}', '${book.quantity}')"
                            class="flex items-center justify-between border-b border-gray-200 px-4 py-2 cursor-pointer">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full border border-slate-400 bg-salte-300 overflow-hidden mr-4">
                                        <img src="${book.cover || '../images/books/default.png'}" alt="" class="w-full h-full">
                                    </div>
                                    <div>
                                        <span>${book.title}</span>
                                    </div>
                                </div>
                            </li>`;
                    });
                    document.querySelector('ul#books').innerHTML = bookList;
                });
        }

        fetchBooks();

        function showFirstBook(book) {
            document.getElementById('book_id').textContent = book.id;
            document.getElementById('title').textContent = book.title;
            document.getElementById('author').textContent = book.author;
            document.getElementById('publisher').textContent = book.publisher;
            document.getElementById('year').textContent = book.year;
            document.getElementById('quantity').textContent = book.quantity;
        }

        function displaySelectedBook(id, title, author, publisher, year, quantity) {
            document.getElementById('book_id').textContent = id;
            document.getElementById('title').textContent = title;
            document.getElementById('author').textContent = author;
            document.getElementById('publisher').textContent = publisher;
            document.getElementById('year').textContent = year;
            document.getElementById('quantity').textContent = quantity;
        }

        function editBook() {
            let book_id = document.getElementById('book_id').textContent;
            location.href = 'edit_book.php?book_id=' + book_id
        }

        function deleteBook() {
            if (confirm("Please, confirm you want to delete this record.")) {
                let book_id = document.getElementById('book_id').textContent;
                location.href = '../backend_scripts/delete_book.php?book_id=' + book_id
            }
        }
    </script>
</body>

</html>