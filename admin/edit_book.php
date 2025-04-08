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
    <title>Edit Book</title>
    <script src="../css/tailwindcss.js"></script>
    <link rel="shortcut icon" href="../images/logo.png" type="image/*">
    <?php
    include_once '../backend_scripts/connect.php';
    if (!isset($_GET['book_id'])) {
        header('Location: manage_books.php?error=book_id_failed');
    }

    $book_id = $_GET['book_id'];
    $stmt = $conn->prepare("SELECT * FROM books WHERE id='$book_id'");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        header('Location: manage_books.php?error=book_not_found');
    }
    $book = $result->fetch_assoc();

    ?>
</head>

<body class="bg-slate-100">
    <?php include 'components/header.html'; ?>
    <main class="container max-w-md mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Edit Book</h1>
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="../backend_scripts/update_book.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Title
                </label>
                <input value="<?php echo $book['title']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" placeholder="Book Title" name="title" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="author">
                    Author
                </label>
                <input value="<?php echo $book['author']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="author" type="text" placeholder="Author" name="author" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="isbn">
                    ISBN
                </label>
                <input value="<?php echo $book['isbn']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="isbn" type="text" placeholder="ISBN" name="isbn" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="publisher">
                    Publisher
                </label>
                <input value="<?php echo $book['publisher']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="publisher" type="text" placeholder="Publisher" name="publisher" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="published_date">
                    Date of Publication
                </label>
                <input value="<?php echo date('Y-m-d', strtotime($book['published_date'])); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="published_date" type="date" placeholder="Published Date" name="published_date" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="cover_image">
                    Image
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="cover_image" type="file" placeholder="Cover Image" name="cover_image">
            </div>
            <div class="flex items-center justify-between">
                <a href="manage_books.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cancel
                </a>
                <button name="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Update Book
                </button>
            </div>
        </form>
    </main>
</body>

</html>

