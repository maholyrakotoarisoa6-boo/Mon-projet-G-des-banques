<?php
include("../includes/db.php"); // connexion PDO

// =================== AJOUT ===================
if (isset($_POST['ajouter'])) {
    $stmt = $conn->prepare("
        INSERT INTO client (numCompte, nom, prenom, tel, mail)
        VALUES (:numCompte, :nom, :prenom, :tel, :mail)
    ");
    $stmt->execute([
        ':numCompte' => $_POST['numCompte'],
        ':nom'       => $_POST['nom'],
        ':prenom'    => $_POST['prenom'],
        ':tel'       => $_POST['tel'],
        ':mail'      => $_POST['mail']
    ]);
}

// =================== MODIFIER ===================
if (isset($_POST['modifier'])) {
    $stmt = $conn->prepare("
        UPDATE client 
        SET nom=:nom, prenom=:prenom, tel=:tel, mail=:mail
        WHERE numCompte=:numCompte
    ");
    $stmt->execute([
        ':numCompte' => $_POST['numCompte'],
        ':nom'       => $_POST['nom'],
        ':prenom'    => $_POST['prenom'],
        ':tel'       => $_POST['tel'],
        ':mail'      => $_POST['mail']
    ]);
}

// =================== SUPPRIMER ===================
if (isset($_POST['supprimer'])) {
    $stmt = $conn->prepare("DELETE FROM client WHERE numCompte=:numCompte");
    $stmt->execute([
        ':numCompte' => $_POST['numCompte']
    ]);
}

// =================== RECHERCHE ===================
$search = $_GET['search'] ?? '';

if ($search != '') {
    $stmt = $conn->prepare("
        SELECT * FROM client
        WHERE numCompte LIKE :search
        OR nom LIKE :search
    ");
    $stmt->execute([
        ':search' => "%$search%"
    ]);
} else {
    $stmt = $conn->prepare("SELECT * FROM client");
    $stmt->execute();
}

$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion des clients</title>

<style>
body { font-family: Arial; background:#f5f5f5; padding:20px; }
h2 { text-align:center; color:#1976d2; }

form { width:95%; margin:15px auto; background:#e3f2fd; padding:15px;
       border-radius:10px; display:flex; gap:10px; flex-wrap:wrap; }

input { padding:7px; width:160px; }
button { padding:7px 15px; border:none; border-radius:5px; cursor:pointer; }

#ajouter { background:#42a5f5; color:white; }
#modifier { background:#4caf50; color:white; }
#supprimer { background:#e53935; color:white; }

table { width:95%; margin:auto; border-collapse:collapse; background:white; }
th, td { padding:10px; border:1px solid #ccc; text-align:center; }
th { background:#1976d2; color:white; }
tr:hover { background:#ffe0b2; cursor:pointer; }
</style>
</head>

<body>

<h2>GESTION DES CLIENTS</h2>

<!-- 🔍 RECHERCHE -->
<form method="GET">
    <input type="text" name="search" placeholder="NumCompte ou Nom"
           value="<?= htmlspecialchars($search) ?>">
    <button type="submit">🔍 Rechercher</button>
</form>

<!-- FORMULAIRE CRUD -->
<form method="POST" id="clientForm">
    <input type="text" name="numCompte" id="numCompte" placeholder="Num Compte" required>
    <input type="text" name="nom" id="nom" placeholder="Nom" required>
    <input type="text" name="prenom" id="prenom" placeholder="Prénom" required>
    <input type="text" name="tel" id="tel" placeholder="Téléphone" required>
    <input type="email" name="mail" id="mail" placeholder="Email" required>

    <button type="submit" name="ajouter" id="ajouter">Ajouter</button>
    <button type="submit" name="modifier" id="modifier">Modifier</button>
    <button type="submit" name="supprimer" id="supprimer"
            onclick="return confirm('Supprimer ce client ?')">
        Supprimer
    </button>
</form>

<!-- TABLE -->
<table>
<tr>
    <th>NumCompte</th>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Téléphone</th>
    <th>Email</th>
</tr>

<?php foreach ($clients as $c): ?>
<tr onclick="fillForm(this)">
    <td><?= $c['numCompte'] ?></td>
    <td><?= $c['nom'] ?></td>
    <td><?= $c['prenom'] ?></td>
    <td><?= $c['tel'] ?></td>
    <td><?= $c['mail'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<script>
function fillForm(row) {
    numCompte.value = row.cells[0].innerText;
    nom.value       = row.cells[1].innerText;
    prenom.value    = row.cells[2].innerText;
    tel.value       = row.cells[3].innerText;
    mail.value      = row.cells[4].innerText;
}
</script>

</body>
</html>
