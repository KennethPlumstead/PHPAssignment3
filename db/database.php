<?php
// db/database.php

$dsn = 'mysql:host=localhost;dbname=tech_support';
$username = 'root';      // XAMPP default
$password = '';          // XAMPP default is empty

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $db = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    echo "<h1>Database Error</h1>";
    echo "<p>$error_message</p>";
    exit();
}