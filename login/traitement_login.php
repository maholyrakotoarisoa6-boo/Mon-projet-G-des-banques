<?php
session_start();
require_once "../config.php";

if (isset($_POST['username'], $_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM utilisateur 
            WHERE username = :username 
            AND password = :password";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':password' => $password
    ]);

    if ($stmt->rowCount() == 1) {
        $_SESSION['user'] = $username;
        header("Location: ../menu/menu.php");
        exit;
    } else {
        echo "❌ Nom d'utilisateur ou mot de passe incorrect";
    }
}