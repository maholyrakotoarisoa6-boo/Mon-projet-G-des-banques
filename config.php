<?php
$host = "localhost";
$dbname = "banque_db";
$user = "root";   // XAMPP default
$pass = "";       // XAMPP default

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur connexion : " . $e->getMessage());
}