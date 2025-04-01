<?php
$servername = "localhost";
$server_username = "root";
$server_password = "";
$dbname = "library_system";

// Create connection
$conn = new mysqli($servername, $server_username, $server_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

