<?php
$host = "localhost";
$dbname = "banque_db";
$user = "root";
$pass = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connexion réussie !";
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
