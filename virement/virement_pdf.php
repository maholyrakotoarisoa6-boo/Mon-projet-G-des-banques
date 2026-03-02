<?php
require('../fpdf186/fpdf.php');
include('../includes/db.php');

// Vérifier l'id
if (!isset($_GET['id'])) {
    die("ID du virement manquant");
}

$id = $_GET['id'];

// Requête du sujet (simple et claire)
$sql = "
SELECT v.id, v.montant, v.dateTransfert,
       ce.numCompte AS compte_env, ce.nom AS nom_env, ce.prenom AS prenom_env,
       cb.numCompte AS compte_ben, cb.nom AS nom_ben, cb.prenom AS prenom_ben
FROM virement v
JOIN client ce ON v.numCompte_envoyeur = ce.numCompte
JOIN client cb ON v.numCompte_beneficiaire = cb.numCompte
WHERE v.id = ?
";

$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Virement introuvable");
}

// Création PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

// Titre
$pdf->Cell(0,10,'AVIS DE VIREMENT',0,1,'C');
$pdf->Ln(5);

// Contenu
$pdf->SetFont('Arial','',12);

$pdf->Cell(60,8,'Numero du virement :',0,0);
$pdf->Cell(0,8,$data['id'],0,1);

$pdf->Cell(60,8,'Date du virement :',0,0);
$pdf->Cell(0,8,$data['dateTransfert'],0,1);

$pdf->Cell(60,8,'Montant :',0,0);
$pdf->Cell(0,8,$data['montant'].' Ar',0,1);

$pdf->Ln(5);

// Emetteur
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,'Compte emetteur',0,1);

$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,$data['nom_env'].' '.$data['prenom_env'].' ('.$data['compte_env'].')',0,1);

$pdf->Ln(3);

// Beneficiaire
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,'Compte beneficiaire',0,1);

$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,$data['nom_ben'].' '.$data['prenom_ben'].' ('.$data['compte_ben'].')',0,1);

$pdf->Ln(10);

// Signature
$pdf->Cell(0,8,'Signature : _______________________',0,1,'R');

$pdf->Output();
