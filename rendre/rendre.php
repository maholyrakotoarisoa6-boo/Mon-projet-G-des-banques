<?php
include("../includes/db.php"); // connexion PDO

// =================== AJOUT ===================
if (isset($_POST['ajouter'])) {
    $numRendu   = $_POST['numRendu'] ?? '';
    $numPret    = $_POST['numPret'] ?? '';
    $situation  = $_POST['situation'] ?? '';
    $rest_paye  = $_POST['rest_paye'] ?? 0;
    $dateRendu  = $_POST['dateRendu'] ?? '';

    $stmt = $conn->prepare("INSERT INTO rendre (numRendu, numPret, situation, rest_paye, dateRendu)
                            VALUES (:numRendu, :numPret, :situation, :rest, :dateRendu)");
    $stmt->execute([
        ':numRendu'  => $numRendu,
        ':numPret'   => $numPret,
        ':situation' => $situation,
        ':rest'      => $rest_paye,
        ':dateRendu' => $dateRendu
    ]);
}

// =================== MODIFIER ===================
if (isset($_POST['modifier'])) {
    $numRendu   = $_POST['numRendu'] ?? '';
    $numPret    = $_POST['numPret'] ?? '';
    $situation  = $_POST['situation'] ?? '';
    $rest_paye  = $_POST['rest_paye'] ?? 0;
    $dateRendu  = $_POST['dateRendu'] ?? '';

    $stmt = $conn->prepare("UPDATE rendre 
                            SET numPret=:numPret, situation=:situation, rest_paye=:rest, dateRendu=:dateRendu
                            WHERE numRendu=:numRendu");
    $stmt->execute([
        ':numPret'   => $numPret,
        ':situation' => $situation,
        ':rest'      => $rest_paye,
        ':dateRendu' => $dateRendu,
        ':numRendu'  => $numRendu
    ]);
}

// =================== SUPPRIMER ===================
if (isset($_POST['supprimer'])) {
    $numRendu = $_POST['numRendu'] ?? '';
    $stmt = $conn->prepare("DELETE FROM rendre WHERE numRendu=:numRendu");
    $stmt->execute([':numRendu' => $numRendu]);
}

// =================== LISTE ===================
$stmt = $conn->prepare("SELECT * FROM rendre");
$stmt->execute();
$rendus = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion des remboursements</title>
<style>
body { font-family:Arial; background:#f4f6f8; padding:20px; }
h2 { text-align:center; color:#2e7d32; }

/* Formulaire */
form {
    background:#e8f5e9;
    padding:15px;
    border-radius:10px;
    width:95%;
    margin:auto;
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    justify-content:center;
}

input, button {
    padding:7px;
}

button {
    border:none;
    border-radius:5px;
    color:white;
    cursor:pointer;
}

.btn-add { background:#43a047; }   /* vert */
.btn-mod { background:#fb8c00; }   /* orange */
.btn-del { background:#e53935; }   /* rouge */

table {
    width:95%;
    margin:20px auto;
    border-collapse:collapse;
    background:white;
}

th, td {
    border:1px solid #ccc;
    padding:10px;
    text-align:center;
}

th { background:#2e7d32; color:white; }
tr:hover { background:#c8e6c9; cursor:pointer; }
</style>
</head>

<body>

<h2>GESTION DES REMBOURSEMENTS (RENDRE)</h2>

<form method="POST" id="rendreForm">
    <input type="text" name="numRendu" id="numRendu" placeholder="Numéro de rendu" required>
    <input type="text" name="numPret" id="numPret" placeholder="Numéro prêt" required>
    <input type="text" name="situation" id="situation" placeholder="Situation" required>
    <input type="number" name="rest_paye" id="rest_paye" placeholder="Reste à payer" required>
    <input type="date" name="dateRendu" id="dateRendu" required>

    <button class="btn-add" name="ajouter">Ajouter</button>
    <button class="btn-mod" name="modifier">Modifier</button>
    <button class="btn-del" name="supprimer" onclick="return confirm('Supprimer ce remboursement ?')">Supprimer</button>
</form>

<table>
<tr>
    <th>NumRendu</th>
    <th>NumPret</th>
    <th>Situation</th>
    <th>Reste à payer</th>
    <th>Date</th>
</tr>

<?php foreach ($rendus as $r) { ?>
<tr onclick="fillForm(this)">
    <td><?= $r['numRendu'] ?></td>
    <td><?= $r['numPret'] ?></td>
    <td><?= $r['situation'] ?></td>
    <td><?= $r['rest_paye'] ?></td>
    <td><?= $r['dateRendu'] ?></td>
</tr>
<?php } ?>
</table>

<script>
// Quand on clique sur une ligne du tableau, remplir le formulaire
function fillForm(row) {
    document.getElementById('numRendu').value = row.cells[0].innerText;
    document.getElementById('numPret').value = row.cells[1].innerText;
    document.getElementById('situation').value = row.cells[2].innerText;
    document.getElementById('rest_paye').value = row.cells[3].innerText;
    document.getElementById('dateRendu').value = row.cells[4].innerText;
}
</script>

</body>
</html>
