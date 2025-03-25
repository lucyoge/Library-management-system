<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="../css/tailwindcss.js"></script>
</head>

<body class="bg-sky-500">
    <div class="container mx-auto p-4 min-h-screen flex justify-center items-center">
        <div class="w-full max-w-md">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="../backend_scripts/signin.php" method="POST">
                <div>
                    <h1 class="text-2xl mb-4 font-semibold">Login</h1>
                </div>
                <div>
                    <?php if (isset($_GET['error'])): ?>
                        <p class="text-red-500 text-sm italic"><?= $_GET['error'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email Address
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" placeholder="Email Address" name="email">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************" name="password">
                    <p class="text-red-500 text-xs italic">Please choose a password.</p>
                </div>
                <div class="flex items-center justify-between">
                    <button name="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Sign In
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="forgot_password.php">
                        Forgot Password?
                    </a>
                </div>
                <p class="text-center text-sm text-gray-700 mt-4">
                    Don't have an account? <a class="text-blue-500 hover:text-blue-800" href="create_account.php">Create One</a>
                </p>
            </form>
        </div>
    </div>
</body>

</html>