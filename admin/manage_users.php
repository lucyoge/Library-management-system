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
                Manage Users
            </span>

            <a href="add_user.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add User
            </a>
        </div>
        <div class="flex items-start w-full bg-white min-h-96">
            <div class="flex-grow max-w-sm">
                <ul id="users" class="w-full"></ul>
            </div>
            <div class="min-h-96 border-l border border-slate-100 flex-grow py-4 px-4">
                <section class="mb-4">
                    <div class="flex items-center justify-center h-full w-full">
                        <div class="w-32 h-32 rounded-full border shadow bg-gray-300 overflow-hidden">
                            <img src="../images/profiles/default.png" alt="" class="w-full h-full">
                        </div>
                    </div>
                </section>
                <section>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <span class="hidden" id="user_id"></span>
                        <div class="">
                            <h3 class="font-semibold">Full Name:</h3>
                            <span id="fullname" class="text-slate-500 text-sm"></span>
                        </div>
                        <div class="">
                            <h3 class="font-semibold">Email:</h3>
                            <span id="email" class="text-slate-500 text-sm"></span>
                        </div>
                        <div class="">
                            <h3 class="font-semibold">Phone:</h3>
                            <span id="phone" class="text-slate-500 text-sm"></span>
                        </div>
                        <div class="">
                            <h3 class="font-semibold">Role:</h3>
                            <span id="role" class="text-slate-500 text-sm"></span>
                        </div>
                        <div class="">
                            <h3 class="font-semibold">Date Added:</h3>
                            <span id="created_at" class="text-slate-500 text-sm"></span>
                        </div>
                    </div>
                    <div class="flex items-center justify-end space-x-2 mt-6">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="editUser()">Edit</button>
                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="deleteUser()">Delete</button>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <script>
        function fetchUsers() {
            fetch("../backend_scripts/fetch_users.php")
                .then(response => response.json())
                .then(data => {
                    let userList = '';
                    showFirstUser(data.users[0]); // Show first user by default
                    data.users.forEach(user => {
                        userList += `<li role="button" onclick="displaySelectedUser(${user.id}, '${user.fullname}', '${user.email}', '${user.phone}', '${user.role}', '${user.created_at}')"
                            class="flex items-center justify-between border-b border-gray-200 px-4 py-2 cursor-pointer">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full border border-slate-400 bg-salte-300 overflow-hidden mr-4">
                                        <img src="${user.avatar || '../images/profiles/default.png'}" alt="" class="w-full h-full">
                                    </div>
                                    <div>
                                        <span>${user.fullname}</span>
                                    </div>
                                </div>
                            </li>`;
                    });
                    document.querySelector('ul#users').innerHTML = userList;
                });
        }

        fetchUsers();

        function showFirstUser(user) {
            document.getElementById('user_id').textContent = user.id;
            document.getElementById('fullname').textContent = user.fullname;
            document.getElementById('email').textContent = user.email;
            document.getElementById('phone').textContent = user.phone;
            document.getElementById('role').textContent = user.role;
            document.getElementById('created_at').textContent = user.created_at;
        }

        function displaySelectedUser(id, fullname, email, phone, role, created_at) {
            document.getElementById('user_id').textContent = id;
            document.getElementById('fullname').textContent = fullname;
            document.getElementById('email').textContent = email;
            document.getElementById('phone').textContent = phone;
            document.getElementById('role').textContent = role;
            document.getElementById('created_at').textContent = created_at;
        }

        function editUser() {
            let user_id = document.getElementById('user_id').textContent;
            location.href = 'edit_user.php?user_id=' + user_id
        }

        function deleteUser() {
            if (confirm("Please, confirm you want to delete this record.")) {
                let user_id = document.getElementById('user_id').textContent;
                location.href = '../backend_scripts/delete_user.php?user_id=' + user_id
            }
        }
    </script>
</body>

</html>