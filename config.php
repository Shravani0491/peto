<?php

$db_name="mysql:host=localhost:8000;dbname=shop_db";
$username="Shaivi";
$password="root";
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Your database operations here...
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    // Handle the error gracefully.
}


 
?>
