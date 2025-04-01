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
    <main class="w-full max-w-6xl mx-auto pb-4 min-h-96 flex justify-center items-center">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-7 w-full ">
            <div class="col-span-2 space-y-4">
                <section class="space-y-2">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-slate-100 shadow">
                            <h3 class="text-sm font-semibold">Total Users</h3>
                            <p class="text-3xl font-bold" id="user_stat">0</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-slate-100 shadow">
                            <h3 class="text-sm font-semibold">Total Books</h3>
                            <p class="text-3xl font-bold" id="bokk_stat">0</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-slate-100 shadow">
                            <h3 class="text-sm font-semibold">Total Borrowed</h3>
                            <p class="text-3xl font-bold" id="borrow_stat">0</p>
                        </div>
                    </div>
                </section>
                <section class="mt-6">
                    <h2 class="text-xl font-semibold mb-2">Recent Borrowers</h2>
                    <table class="w-full text-left rounded-2xl shadow border border-slate-200 overflow-hidden">
                        <thead class="bg-blue-500 text-white">
                            <tr>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Book Title</th>
                                <th class="px-4 py-2">Borrow Date</th>
                                <th class="px-4 py-2">Return Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white" id="recent_borrowers"></tbody>
                    </table>
                </section>
            </div>
            <div>
                <h2 class="text-xl font-semibold mb-2">Recently Added Users</h2>
                <ul class="space-y-2 bg-white" id="recent_users">
                </ul>
            </div>
        </div>
    </main>

    <script>
        function fetchDashboardData() {
            fetch('../backend_scripts/dashboard_stats.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('user_stat').textContent = data.total_users;
                    document.getElementById('bokk_stat').textContent = data.total_books;
                    document.getElementById('borrow_stat').textContent = data.total_borrowed;
                    displayRecentBorrows(data.recent_borrows);
                    displayUsers(data.recent_users);   
                });
        }

        fetchDashboardData();

        function displayRecentBorrows(recentBorrows) {
            let tableRows = '';
            recentBorrows.forEach(borrow => {
                tableRows += `<tr>
                    <td>${borrow.title}</td>
                    <td>${borrow.fullname}</td>
                    <td>${borrow.isbn}</td>
                    <td>${borrow.borrowed_date}</td>
                    <td>${borrow.return_date}</td>
                </tr>`;
            });
            document.querySelector('tbody#recent_borrowers').innerHTML = tableRows;
        }

        function displayUsers(recentUsers) {
            let userList = '';
            recentUsers.forEach(user => {
                userList += `<li class="bg-white px-4 py-2 rounded shadow">
                    <p>${user.fullname}</p>
                    <p class="text-xs text-slate-500 italic">${user.email}</p>
                </li>`;
            });
            document.querySelector('ul#recent_users').innerHTML = userList;
        }
    </script>
</body>
</html>