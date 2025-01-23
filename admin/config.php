<?php
$host = '127.0.0.1:3306'; // IP to access the database
$db = 'mydatabase'; // Name of the database
$user = 'root'; // Username
$pass = 'toor'; // Password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Login failed : ' . $e->getMessage();
}
?>