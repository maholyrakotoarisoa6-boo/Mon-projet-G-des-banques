<?php
include("../includes/db.php"); // connexion PDO

// =================== AJOUT ===================
if (isset($_POST['ajouter'])) {
    $stmt = $conn->prepare(
        "INSERT INTO preter (numPret, numCompte, montant_pret, datePret)
         VALUES (:numPret, :numCompte, :montant, :datePret)"
    );
    $stmt->execute([
        ':numPret'  => $_POST['numPret'],
        ':numCompte'=> $_POST['numCompte'],
        ':montant'  => $_POST['montant_pret'],
        ':datePret' => $_POST['datePret']
    ]);
}

// =================== MODIFIER ===================
if (isset($_POST['modifier'])) {
    $stmt = $conn->prepare(
        "UPDATE preter
         SET numCompte=:numCompte, montant_pret=:montant, datePret=:datePret
         WHERE numPret=:numPret"
    );
    $stmt->execute([
        ':numCompte'=> $_POST['numCompte'],
        ':montant'  => $_POST['montant_pret'],
        ':datePret' => $_POST['datePret'],
        ':numPret'  => $_POST['numPret']
    ]);
}

// =================== SUPPRIMER ===================
if (isset($_POST['supprimer'])) {
    $stmt = $conn->prepare("DELETE FROM preter WHERE numPret=:numPret");
    $stmt->execute([
        ':numPret' => $_POST['numPret']
    ]);
}

// =================== LISTE ===================
$stmt = $conn->prepare("SELECT * FROM preter");
$stmt->execute();
$prets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion des prêts</title>

<style>
body { font-family: Arial; background:#f5f5f5; padding:20px; }
h2 { text-align:center; color:#2e7d32; }

/* FORMULAIRE */
form#pretForm {
    width:95%; margin:20px auto; background:#e8f5e9; padding:15px;
    border:2px solid #81c784; border-radius:10px;
    display:flex; flex-wrap:wrap; gap:10px; align-items:center;
}

form#pretForm input {
    padding:6px; width:170px;
}

form#pretForm button {
    padding:7px 15px; border:none; border-radius:5px; cursor:pointer;
}

#ajouter { background:#43a047; color:white; }
#modifier { background:#1e88e5; color:white; }
#supprimer { background:#e53935; color:white; }

/* TABLE */
table {
    border-collapse:collapse; width:95%; margin:20px auto;
    background:white; box-shadow:0 0 10px #ccc;
}
th, td {
    border:1px solid #ddd; padding:10px; text-align:center;
}
th { background:#2e7d32; color:white; }
tr:nth-child(even) { background:#f2f2f2; }
tr:hover { background:#c8e6c9; cursor:pointer; }
</style>
</head>

<body>

<h2>GESTION DES PRÊTS</h2>

<!-- FORMULAIRE -->
<form id="pretForm" method="POST">
    <input type="text" name="numPret" id="numPret" placeholder="Numéro du prêt" required>
    <input type="text" name="numCompte" id="numCompte" placeholder="Numéro de compte" required>
    <input type="number" name="montant_pret" id="montant_pret" placeholder="Montant du prêt" required>
    <input type="date" name="datePret" id="datePret" required>

    <button type="submit" name="ajouter" id="ajouter">Ajouter</button>
    <button type="submit" name="modifier" id="modifier">Modifier</button>
    <button type="submit" name="supprimer" id="supprimer"
        onclick="return confirm('Supprimer ce prêt ?')">Supprimer</button>
</form>

<!-- TABLE -->
<table id="pretTable">
    <tr>
        <th>NumPret</th>
        <th>NumCompte</th>
        <th>Montant</th>
        <th>Date</th>
    </tr>

    <?php foreach ($prets as $p) { ?>
    <tr onclick="fillForm(this)">
        <td><?= $p['numPret'] ?></td>
        <td><?= $p['numCompte'] ?></td>
        <td><?= $p['montant_pret'] ?></td>
        <td><?= $p['datePret'] ?></td>
    </tr>
    <?php } ?>
</table>

<script>
function fillForm(row) {
    document.getElementById('numPret').value       = row.cells[0].innerText;
    document.getElementById('numCompte').value    = row.cells[1].innerText;
    document.getElementById('montant_pret').value = row.cells[2].innerText;
    document.getElementById('datePret').value     = row.cells[3].innerText;
}
</script>

</body>
</html>
