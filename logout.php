<?php
$host = 'db'; // Replace with your MySQL server hostname or IP address
$dbname = 'shop_db'; // Replace with your database name
$username = 'Shaivi'; // Replace with your MySQL username
$password = 'root'; // Replace with your MySQL password
session_start();
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Your database operations here...
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    // Handle the error gracefully.
}
session_unset();
session_destroy();

header('location:index.php');

?>