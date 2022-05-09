<?php
include('dbconn.php');
include('fpdf.php');


$pdf = new FPDF();
$pdf->SetLeftMargin(30);
$pdf->SetRightMargin(30);
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->Image("../client/src/assets/img/logo.png", null, null, 40, 20);
$cmd = $_GET['cmd'];
$client = $_GET['client'];
$sql1 = "SELECT numCmd,nom, prenom, dateCmd from clients, commandes where idClient = '$client' and numCmd = '$cmd'";
$sql2 = "SELECT nom, prix, qte from consommations, contenir where contenir.commande = '$cmd' and contenir.consommation = consommations.numCons;";
$result1 = mysqli_query($conn, $sql1);
$pdf->setFont('Arial', 'B', 11);



foreach($result1 as $row){
    $i = 0;
    foreach($row as $column)
    {
        $c[$i] = $column; $i++;
        //$pdf->Cell(20,12,utf8_decode($column), 0,0,'C');
    }
}
$pdf->Cell(0,12, utf8_decode("Réf. ").$c[0], 0, 0, 'L');
$pdf->Cell(0,12, $c[1].' '.$c[2].'        '.$c[3], 0, 0, 'R');
$pdf->Ln();$pdf->Ln();$pdf->Line(20, 45, 210-20, 45);$pdf->Ln();
$result2 = mysqli_query($conn, $sql2);
$total = 0;
$pdf->setFont('Arial', 'B', 11);
$pdf->Cell(60,12,'Consommation', 'B');
$pdf->Cell(30,12,'Prix', 'B');
$pdf->Cell(30,12,utf8_decode('Quantité'), 'B');
$pdf->Cell(30,12,'Total', 'B');
$pdf->setFont('Arial', '', 10);
foreach($result2 as $row){
    $pdf->Ln();
    $total = $total ;
    $pdf->Cell(60,12,utf8_decode($row['nom']), 'B');
    $pdf->Cell(30,12,utf8_decode($row['prix']). ' DA', 'B');
    $pdf->Cell(30,12,utf8_decode($row['qte']), 'B');
    $price = $row['prix'] * $row['qte'];
    $pdf->Cell(30,12,$price. ' DA', 'B');
    $total = $total + $price;
}

$pdf->Ln();$pdf->Ln();
$pdf->setFont('Arial', 'B', 12);
$pdf->Cell(0,12,utf8_decode("Total à payer  ").$total.' DA',1, 0, 'C');
$pdf->Output();
