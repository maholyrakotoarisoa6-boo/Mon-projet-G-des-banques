<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Menu Principal - Banque</title>

<style>
body {
    margin:0;
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, #a5d6a7, #81c784); /* Fond général vert clair */
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

/* Carte blanche pour le menu */
.menu {
    background:white;
    padding:30px;
    width:400px;
    border-radius:12px;
    text-align:center;
    box-shadow:0 0 15px rgba(0,0,0,0.3);
}

/* Titre */
.menu h2 {
    color:#2e7d32; /* Titre vert foncé */
    margin-bottom:20px;
}

/* Boutons menu */
.menu a {
    display:block;
    text-decoration:none;
    background:#4caf50; /* Vert des boutons */
    color:white;
    padding:12px;
    margin:10px 0;
    border-radius:6px;
    font-size:16px;
    transition:0.3s;
}

.menu a:hover {
    background:#388e3c; /* Vert foncé au survol */
    transform: scale(1.05);
}
</style>
</head>

<body>

<div class="menu">
    <h2>MENU PRINCIPAL</h2>

    <a href="../client/list.php">👤 Gestion des clients</a>
    <a href="../virement/virement.php">💸 Gestion des virements</a>
    <a href="../pret/pret.php">🏦 Gestion des prêts</a>
    <a href="../rendre/rendre.php">💰 Remboursement</a>
    <a href="../menu/menu.php">🔄 Actualiser</a>
    <a href="../login/logout.php">🚪 Déconnexion</a>

</div>

</body>
</html>
