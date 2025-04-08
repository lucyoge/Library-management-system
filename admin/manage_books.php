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
    <link rel="shortcut icon" href="../images/logo.png" type="image/*">
</head>

<body class="bg-slate-100">
    <?php include 'components/header.html'; ?>
    <main class="container max-w-6xl mx-auto px-4 py-8">
        <div class="mb-5 flex items-center justify-between">
            <span class="text-xl font-semibold mb-2">
                Manage Books
            </span>

            <section class="flex items-center space-x-4">
                <form method="POST" class="flex items-center" onsubmit="searchBooks(event)">
                    <input type="text" placeholder="Search books..." class="p-2 border rounded-l" id="search_input">
                    <button class="bg-slate-400 px-4 py-2 rounded-r">
                        Search
                    </button>
                </form>
                <a href="add_book.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add Book
                </a>
                <a href="borrowed_books.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    View Borrowed
                </a>
            </section>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="books">
            <!-- <div class="bg-white shadow-md rounded">
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
            </div> -->
        </div>
    </main>

    <script>
        function fetchBooks() {
            fetch("../backend_scripts/fetch_books.php")
                .then(response => response.json())
                .then(data => {
                    let bookList = '';
                    data.books.forEach(book => {
                        bookList += `<div class="bg-white shadow-md rounded">
                                        <div class="w-full h-52 flex justify-center align-center">
                                            <img src="${book.cover_photo}" alt="Book Cover" class="object-cover min-w-full min-h-full">
                                        </div>
                                        <div class="p-4 space-y-1">
                                            <div class="flex items-center justify-between">
                                                <span class="text-lg font-bold">${book.title}</span>
                                            </div>
                                            <p class="text-gray-700 text-sm"><strong>Author:</strong> ${book.author}</p>
                                            <p class="text-gray-700 text-sm"><strong>Publisher:</strong> ${book.publisher}</p>
                                            <p class="text-gray-700 text-sm"><strong>Published Date:</strong> ${book.published_date}</p>
                                            <p class="text-gray-700 text-sm"><strong>ISBN:</strong> ${book.isbn}</p>
                                            <p class="text-gray-700 text-sm"><strong>Available Copies:</strong> ${book.copies_available}</p>
                                            <p class="text-gray-700 text-sm"><strong>Borrowed Copies:</strong> ${book.borrowed_copies}</p>
                                            <div class="space-2 mt-4">
                                                <a href="edit_book.php?book_id=${book.id}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded inline-block">
                                                    Edit
                                                </a>
                                                <a href="../backend_scripts/delete_book.php?book_id=${book.id}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded inline-block">
                                                    Delete
                                                </a>
                                                <a href="lend_book.php?book_id=${book.id}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded inline-block">
                                                    Lend Book
                                                </a>
                                            </div>
                                        </div>
                                    </div>`;
                    });
                    document.querySelector('#books').innerHTML = bookList;
                });
        }

        fetchBooks();

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

        function searchBooks(event) {
            event.preventDefault();
            let searchQuery = document.getElementById('search_input').value;
            console.log(searchQuery);
            
            fetch(`../backend_scripts/search_books.php?search=${searchQuery}`)
                .then(response => response.json())
                .then(data => {
                    let bookList = '';
                    data.books.forEach(book => {
                        bookList += `<div class="bg-white shadow-md rounded">
                                        <div class="w-full h-52 flex justify-center align-center">
                                            <img src="${book.cover_photo}" alt="Book Cover" class="object-cover min-w-full min-h-full">
                                        </div>
                                        <div class="p-4 space-y-1">
                                            <div class="flex items-center justify-between">
                                                <span class="text-lg font-bold">${book.title}</span>
                                            </div>
                                            <p class="text-gray-700 text-sm"><strong>Author:</strong> ${book.author}</p>
                                            <p class="text-gray-700 text-sm"><strong>Publisher:</strong> ${book.publisher}</p>
                                            <p class="text-gray-700 text-sm"><strong>Published Date:</strong> ${book.published_date}</p>
                                            <p class="text-gray-700 text-sm"><strong>ISBN:</strong> ${book.isbn}</p>
                                            <p class="text-gray-700 text-sm"><strong>Available Copies:</strong> ${book.copies_available}</p>
                                            <p class="text-gray-700 text-sm"><strong>Books Available:</strong> ${book.borrowed_copies}</p>
                                            <div class="space-x-2 mt-4">
                                                <a href="edit_book.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                                                    Edit
                                                </a>
                                                <a href="#" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                                                    Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>`;
                    });
                    document.querySelector('#books').innerHTML = bookList;    
                });
        }
    </script>
</body>

</html>