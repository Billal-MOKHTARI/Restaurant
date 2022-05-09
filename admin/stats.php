<?php
include('dbconn.php');
include('fpdf.php');

if (isset($_POST['chart'])) {

    $pdf = new FPDF();
    $pdf->SetLeftMargin(20);
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $stat = $_POST['chart'];
    $date = date("d-m-Y H:i:s");

    if ($stat == 'chart1') {
        $title = "LISTE DES CONSOMMATIONS LES PLUS COMMANDEES";
        $sql = "SELECT consommations.nom,prix, type,sum(qte) as 'total' from contenir, consommations where 
        consommations.numCons = contenir.consommation
        group by consommation order by sum(qte) DESC";
        $columns = array("Consommation", "Prix unitaire", "Type", "Nombre total vendu");
    } else if ($stat == 'chart2') {
        $title = "LISTE DES CLIENTS FIDELES";
        $sql = "select nom,prenom,email, count(numCmd) 
    as num from commandes, clients where clients.idClient = commandes.client group by client ORDER BY count(numCmd) DESC limit 5";
        $columns = array("Nom", "Prénom", "Email", "Nombre de commandes");
    } else if ($stat == 'chart3') {
        $title = "CHIFFRE D'AFFAIRES";
        $sql = "SELECT CONCAT(MONTH(dateCmd),'-',YEAR(dateCmd)) as mois,sum(prix*qte) as total from contenir, consommations, commandes where contenir.consommation = consommations.numCons and commandes.numCmd = contenir.commande
        group by 
       CAST(MONTH(dateCmd) AS VARCHAR(2)) + '-' + CAST(YEAR(dateCmd) AS VARCHAR(4)) LIMIT 12";
        $columns = array("Mois-Année", "CA");
    }



    $pdf->setFont('Helvetica', 'I', 11);
    $pdf->Image("../client/src/assets/img/logo.png", null, null, 40, 20);
    $pdf->Cell(0, 15, $date, 0, 0, "R");
    $pdf->setFont('Helvetica', 'B', 20);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetTitle($title);

    $pdf->Cell(0, 15, $title, 0, 0, "C");
    $pdf->setFont('Helvetica', 'B', 11);
    $pdf->Ln();
    $pdf->Ln();
    if ($stat == 'chart2' || $stat == 'chart1') {
        foreach ($columns as $column)
            $pdf->Cell(45, 10, utf8_decode($column), 1);


        $pdf->setFont('Helvetica', '', 10);
        $result = mysqli_query($conn, $sql);
        $pdf->Ln();

        foreach ($result as $rows) {
            foreach ($rows as $row) {

                $pdf->Cell(45, 10, utf8_decode($row), 1);
            }
            $pdf->Ln();
        }
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();



        $pdf->Ln();
        $pdf->Ln();

        $pdf->Output("I", $title . ' ' . date('Y-m-d'));
    } else {
        foreach ($columns as $column)
            $pdf->Cell(80, 10, utf8_decode($column), 1);


        $pdf->setFont('Helvetica', '', 10);
        $result = mysqli_query($conn, $sql);
        $pdf->Ln();

        foreach ($result as $rows) {
	    $months = ["01" => "Janvier","02" => "Février","03" => "Mars","04" => "Avril","05" => "Mai","06" => "Juin"
,"07" => "Juillet","08" => "Août","09" => "Septembre"
,"10" => "Octobre","11" => "Novembre","12" => "Décembre" ];
            $date = $rows['mois'];
            if(strlen($rows['mois']) == 6)
                $date = '0'.$date;
                $pdf->Cell(80, 10, utf8_decode($months[mb_substr($date, 0, 2)]).'  '.mb_substr($date, 3, 4) , 1);
                $pdf->Cell(80, 10, utf8_decode($rows['total']).' DA', 1);
            $pdf->Ln();
        }
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();



        $pdf->Ln();
        $pdf->Ln();

        $pdf->Output("I", $title . ' ' . date('Y-m-d'));
    }
} else {
    echo '<script>alert("Une erreur s`est produite. Veuillez fermer l`onglet et cliquer de nouveau sur le bouton imprimer")</script>';
}



// SELECT consommations.prix*qte from consommations, contenir where consommations.numCons = contenir.consommation and 
//commande in (SELECT commandes.numCmd from commandes group by  MONTH(commandes.dateCmd));