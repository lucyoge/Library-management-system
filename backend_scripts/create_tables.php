<?php
// connect to server and create databas if not exists
$servername = "localhost";
$server_username = "root";
$server_password = "";
$dbname = "library_system";

// Create connection
$conn = new mysqli($servername, $server_username, $server_password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete database if not exists
$sql = "DROP DATABASE IF EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database deleted successfully";
} else {
    echo "Error deleting database: " . $conn->error;
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

// select the database
$conn->select_db($dbname);

// Create all tables
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(50) NOT NULL,
    phone VARCHAR(15),
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    photo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$sql_books = "CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    isbn VARCHAR(100) NOT NULL UNIQUE,
    publisher VARCHAR(255),
    published_date DATE,
    copies_available INT DEFAULT 0,
    cover_photo VARCHAR(255),
    description TEXT
)";

$sql_borrowed_books = "CREATE TABLE IF NOT EXISTS borrowed_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    borrowed_date DATE DEFAULT CURRENT_TIMESTAMP,
    return_date DATE,
    status ENUM('borrowed', 'returned', 'pending') DEFAULT 'borrowed',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
)";

$sql_categories = "CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
)";

$sql_books_categories = "CREATE TABLE IF NOT EXISTS books_categories (
    book_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (book_id, category_id),
    FOREIGN KEY (book_id) REFERENCES books(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
)";

$sql_default_categories = "INSERT INTO categories (name) VALUES ('Fiction'), ('Non-Fiction'), 
('Biography'), ('Self-Help'), ('History'), ('Science'), ('Technology'), ('Art'), ('Sports'), ('Travel'), 
('Food'), ('Finance'), ('Business'), ('Education'), ('Health'), ('Programming'), ('Photography'), 
('Music'), ('Drama'), ('Comedy'), ('Thriller'), ('Horror'), ('Mystery'), ('Romance'), ('Poetry'), 
('Philosophy'), ('Religion'), ('Spirituality'), ('Humor')";

$queries = [$sql_users, $sql_books, $sql_borrowed_books, $sql_categories, $sql_books_categories];

foreach ($queries as $query) {
    if ($conn->query($query) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }
}

$conn->close();

echo "Tables created successfully";

?>

