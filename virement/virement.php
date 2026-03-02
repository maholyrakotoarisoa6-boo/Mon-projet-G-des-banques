<?php
include("../includes/db.php"); // Connexion PDO

// =================== AJOUT ===================
if (isset($_POST['ajouter'])) {
    $envoyeur     = $_POST['numCompte_envoyeur'] ?? '';
    $beneficiaire = $_POST['numCompte_beneficiaire'] ?? '';
    $montant      = $_POST['montant'] ?? 0;
    $dateTransfert= $_POST['dateTransfert'] ?? '';

    $stmt = $conn->prepare("INSERT INTO virement (numCompte_envoyeur, numCompte_beneficiaire, montant, dateTransfert)
                            VALUES (:envoyeur, :beneficiaire, :montant, :dateTransfert)");
    $stmt->execute([
        ':envoyeur' => $envoyeur,
        ':beneficiaire' => $beneficiaire,
        ':montant' => $montant,
        ':dateTransfert' => $dateTransfert
    ]);
}

// =================== MODIFIER ===================
if (isset($_POST['modifier'])) {
    $id           = $_POST['id'] ?? 0;
    $envoyeur     = $_POST['numCompte_envoyeur'] ?? '';
    $beneficiaire = $_POST['numCompte_beneficiaire'] ?? '';
    $montant      = $_POST['montant'] ?? 0;
    $dateTransfert= $_POST['dateTransfert'] ?? '';

    $stmt = $conn->prepare("UPDATE virement SET numCompte_envoyeur=:envoyeur, numCompte_beneficiaire=:beneficiaire, montant=:montant, dateTransfert=:dateTransfert
                            WHERE id=:id");
    $stmt->execute([
        ':envoyeur' => $envoyeur,
        ':beneficiaire' => $beneficiaire,
        ':montant' => $montant,
        ':dateTransfert' => $dateTransfert,
        ':id' => $id
    ]);
}

// =================== SUPPRIMER ===================
if (isset($_POST['supprimer'])) {
    $id = $_POST['id'] ?? 0;

    $stmt = $conn->prepare("DELETE FROM virement WHERE id=:id");
    $stmt->execute([':id' => $id]);
}

// =================== RÉCUPÉRER TOUS LES VIREMENTS ===================
$stmt = $conn->prepare("SELECT * FROM virement");
$stmt->execute();
$virements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion des virements</title>
<style>
body { font-family: Arial; background:#f5f5f5; padding:20px; }
h2 { text-align:center; color:#1976d2; }

form#virementForm {
    width:95%; margin:20px auto; background:#e3f2fd; padding:15px; border:2px solid #90caf9;
    border-radius:10px; display:flex; flex-wrap:wrap; align-items:center; gap:10px;
}

form#virementForm input[type=text], form#virementForm input[type=number], form#virementForm input[type=date] {
    padding:5px; width:160px;
}

form#virementForm button {
    padding:7px 15px; border:none; border-radius:5px; cursor:pointer;
}

button#ajouter { background:#42a5f5; color:white; }
button#modifier { background:#4caf50; color:white; }
button#supprimer { background:#e53935; color:white; }

table { border-collapse:collapse; width:95%; margin:20px auto; background:white; box-shadow:0 0 10px #ccc; }
th, td { border:1px solid #ddd; padding:10px; text-align:center; }
th { background-color:#1976d2; color:white; }
tr:nth-child(even) { background:#f2f2f2; }
tr:hover { background:#ffe0b2; cursor:pointer; }
a.pdfBtn {
    color:white; background:#1976d2; padding:5px 10px; border-radius:5px; text-decoration:none;
}
</style>
</head>
<body>

<h2>Gestion des virements</h2>

<!-- Formulaire Virement -->
<form id="virementForm" method="POST">
    <input type="hidden" name="id" id="virement_id">
    <input type="text" name="numCompte_envoyeur" placeholder="Compte envoyeur" required id="numCompte_envoyeur">
    <input type="text" name="numCompte_beneficiaire" placeholder="Compte bénéficiaire" required id="numCompte_beneficiaire">
    <input type="number" name="montant" placeholder="Montant" required id="montant">
    <input type="date" name="dateTransfert" required id="dateTransfert">
    <button type="submit" name="ajouter" id="ajouter">Ajouter</button>
    <button type="submit" name="modifier" id="modifier">Modifier</button>
    <button type="submit" name="supprimer" id="supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce virement ?')">Supprimer</button>
</form>

<!-- Tableau des virements -->
<table id="virementsTable">
    <tr>
        <th>Compte envoyeur</th>
        <th>Compte bénéficiaire</th>
        <th>Montant</th>
        <th>Date</th>
        <th>PDF</th>
    </tr>
    <?php foreach ($virements as $v) { ?>
    <tr data-id="<?= $v['id'] ?>" onclick="fillForm(this)">
        <td><?= $v['numCompte_envoyeur'] ?></td>
        <td><?= $v['numCompte_beneficiaire'] ?></td>
        <td><?= $v['montant'] ?></td>
        <td><?= $v['dateTransfert'] ?></td>
        <td>
            <a class="pdfBtn" href="virement_pdf.php?id=<?= $v['id'] ?>" target="_blank">PDF</a>
        </td>
    </tr>
    <?php } ?>
</table>

<script>
function fillForm(row) {
    document.getElementById('virement_id').value = row.dataset.id;
    document.getElementById('numCompte_envoyeur').value = row.cells[0].innerText;
    document.getElementById('numCompte_beneficiaire').value = row.cells[1].innerText;
    document.getElementById('montant').value = row.cells[2].innerText;
    document.getElementById('dateTransfert').value = row.cells[3].innerText;
}
</script>

</body>
</html>
