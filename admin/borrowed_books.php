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
    <title>Borrowed Books</title>
    <script src="../css/tailwindcss.js"></script>
    <link rel="shortcut icon" href="../images/logo.png" type="image/*">
</head>

<body class="bg-slate-100">
    <?php include 'components/header.html'; ?>

    <main class="container max-w-6xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-4">
            <a href="manage_books.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Back
            </a>
        </div>
        <h1 class="text-2xl font-bold mb-4">Borrowed Books</h1>
        <?php
            if (isset($_GET['success'])) {
                echo '<p class="text-green-500">' . $_GET['success'] . '</p>';
            }
            if (isset($_GET['error'])) {
                echo '<p class="text-red-500">' . $_GET['error'] . '</p>';
            }
        ?>
        <table class="min-w-full bg-white">
            <thead>
                <tr class="text-left">
                    <th class="py-2 px-4">Book Title</th>
                    <th class="py-2 px-4">Borrowed By</th>
                    <th class="py-2 px-4">Borrowed Date</th>
                    <th class="py-2 px-4">Return Date</th>
                    <th class="py-2 px-4">Status</th>
                    <th class="py-2 px-4">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </main>

    <script>
        async function fetchBorrowedBooks() {
            const response = await fetch('../backend_scripts/fetch_borrowed_books.php');
            const data = await response.json();
            const tableRows = data.borrowed_books.map(borrowedBook => {
                return `
                    <tr>
                        <td class="py-2 px-4">${borrowedBook.title}</td>
                        <td class="py-2 px-4">${borrowedBook.fullname}</td>
                        <td class="py-2 px-4">${borrowedBook.borrowed_date}</td>
                        <td class="py-2 px-4">${borrowedBook.return_date || 'ND'}</td>
                        <td class="py-2 px-4 capitalize">
                            <span class="text-xs ${borrowedBook.status === 'returned' ? 'bg-green-200 text-green-800' : (borrowedBook.status === 'pending' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800')} px-2 py-1 rounded">
                                ${borrowedBook.status || 'unknown'}
                            </span>
                        </td>
                        <td class="py-2 px-4">
                            <button class="font-bold py-1 px-3 rounded text-xs ${borrowedBook.status === 'pending' ? 'bg-green-500 hover:bg-green-700 text-white' : (borrowedBook.status === 'borrowed' ? 'bg-blue-500 hover:bg-blue-700 text-white' : 'border border-slate-400 text-slate-400 hover:bg-slate-200')}"
                                onclick="${borrowedBook.status === 'pending' ? 'confirmStatus' : (borrowedBook.status === 'borrowed' ? 'returnBook' : 'deleteRecord')}(${borrowedBook.id}, '${borrowedBook.status}')">
                                ${borrowedBook.status === 'pending' ? 'Confirm' : (borrowedBook.status === 'borrowed' ? 'Return Book' : 'Delete Record')}
                            </button>
                        </td>
                    </tr>
                `;

                function updateStatus(id, status) {
                    const newStatus = status === 'pending' ? 'returned' : 'pending';
                    fetch(`../backend_scripts/update_borrow_status.php?id=${id}&status=${newStatus}`, {
                            method: 'POST'
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                fetchBorrowedBooks();
                            }
                        });
                }
            });
            document.querySelector('tbody').innerHTML = tableRows;
        }

        async function returnBook(id, status) {
            if (status !== 'borrowed') return; // Only return if the status is borrowed
            const response = await fetch(`../backend_scripts/return_book.php?id=${id}`, {
                method: 'POST'
            });
            if (response.ok) {
                fetchBorrowedBooks();
            }
        }

        async function confirmStatus(id, status) {
            if (status !== 'pending') return; // Only confirm if the status is pending
            const response = await fetch(`../backend_scripts/confirm_borrowed_book.php?id=${id}`, {
                method: 'POST'
            });
            if (response.ok) {
                fetchBorrowedBooks();
            }
        }

        async function deleteRecord(id) {
            const response = await fetch(`../backend_scripts/delete_borrowed_book.php?id=${id}`, {
                method: 'POST'
            });
            if (response.ok) {
                fetchBorrowedBooks();
            }
        }

        fetchBorrowedBooks();
    </script>
</body>

</html>