<?php
include("dbconn.php");

$q = $_GET['q'];

if (isset($_GET['date']))
    $date = $_GET['date'];
$type = $_GET['type'];
mysqli_select_db($conn, "ajax_demo");
if ($type == "clients") {

    if ($q === '*'){
        $sql = "SELECT nom, prenom, dateNaiss, email, tel FROM clients";
    }
       
    else
    $sql = "SELECT nom, prenom, dateNaiss, email, tel FROM clients where nom like '%$q%' or prenom like '%$q%'";
    $res = mysqli_query($conn, $sql);
    $numberResults = mysqli_num_rows($res);
    if ($numberResults > 1)
        echo "<div><b><i class='fas fa-search'></i>&nbsp;&nbsp;" . $numberResults . " résultats trouvés.</b></div><br><br>";
    else
        echo "<div><b><i class='fas fa-search'></i>&nbsp;&nbsp;" . $numberResults . " résultat trouvé.</b></div><br><br>";
    if ($numberResults == 0) {
        echo "<div class='message'><b>Aucun résultat.</b><div>";
    }
    while ($row = mysqli_fetch_array($res)) { ?>
        <div class="col-md-auto">
            <div class="card shadow-lg bg-white rounded" style="width: 18rem; margin : 20px; border-radius : 20px!important">
                <img class="card-img-top" style="border-top-left-radius : 20px;border-top-right-radius : 20px" src="./assets/photos/avatar.png" width="300" height="300" alt="<?php echo $row['nom'] ?>">
                <div class="card-body">
                    <b>
                        <h5 class="card-title"><?php echo "<div class='message'>" . $row['nom'] . ' ' . $row['prenom'] . "</div>" ?></h5>
                    </b>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Date de naissance : </b> <?php echo $row['dateNaiss'] ?></li>
                    <li class="list-group-item"><b>Tel : </b><a style="color : #212529" href="tel:<?php echo $row['tel'] ?>"> <?php echo $row['tel'] ?> </a></li>
                    <li class="list-group-item"><b>Email : </b><a style="color : #212529" href="mailto:<?php echo $row['email'] ?>"> <?php echo $row['email'] ?></a></li>
                </ul>
            </div>
        </div>
    <?php }

} else if ($type == "commandes") {
    if ($q == "*")
    $sql = "SELECT numCmd,commandes.client,dateCmd,tables.numTable, clients.nom as nomClient, 
    clients.prenom as preClient, serveurs.nom as nomServ, 
    serveurs.prenom as preServ from tables,commandes,asseoir,clients,serveurs
    WHERE clients.idClient = commandes.client 
    and asseoir.client = clients.idClient
    and asseoir.dateServ = DATE(commandes.dateCmd) and asseoir.numTable = tables.numTable
    and serveurs.numServ = tables.Serveur";
    else
    $sql = "SELECT numCmd,commandes.client,dateCmd,tables.numTable, clients.nom as nomClient, 
    clients.prenom as preClient, serveurs.nom as nomServ, 
    serveurs.prenom as preServ from tables,commandes,asseoir,clients,serveurs
    WHERE clients.idClient = commandes.client 
    and asseoir.client = clients.idClient
    and asseoir.dateServ = DATE(commandes.dateCmd) and asseoir.numTable = tables.numTable
    and serveurs.numServ = tables.Serveur 
    and (clients.nom LIKE '%$q%' 
        or clients.prenom LIKE '%$q%'
        or Serveurs.nom LIKE '%$q%'
        or Serveurs.prenom LIKE '%$q%')";
    if (isset($date) && $date != '') {
        $sql = $sql . " and DATE(dateCmd) LIKE '$date';";
    }
    $res = mysqli_query($conn, $sql);
    $numberResults = mysqli_num_rows($res);
    if ($numberResults > 1)
        echo "<div><b><i class='fas fa-search'></i>&nbsp;&nbsp;" . $numberResults . " résultats trouvés.</b></div><br><br>";
    else
        echo "<div><b><i class='fas fa-search'></i>&nbsp;&nbsp;" . $numberResults . " résultat trouvé.</b></div><br><br>";
    if ($numberResults == 0) {
        echo "<div class='message'><b>Aucun résultat.</b></div>";
    }
    while ($row = mysqli_fetch_array($res)) {
        $cmd = $row['numCmd'];
        $sql2 = "SELECT sum(prix*qte) as total from contenir, consommations 
        where contenir.commande = '$cmd' and contenir.consommation = consommations.numCons;";
        $res2 = mysqli_query($conn, $sql2);
        $total = mysqli_fetch_array($res2)[0];
    ?>
        <div class="col-md-auto">
            <div class="card shadow-lg bg-white rounded" style="width: 18rem; margin : 20px; border-radius : 20px!important">
                <div class="image">
                    <img class="card-img-top" style="border-top-left-radius : 20px;border-top-right-radius : 20px" src="./assets/photos/command.jpg" width="100%" height="100%">
                    <div class="text-cmd">Commande N°<?php echo $cmd ?></div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Client : </b> <?php echo $row['nomClient'] . ' ' . $row['preClient'] ?></li>
                    <li class="list-group-item"><b>Date de commande : </b> <?php echo $row['dateCmd'] ?></li>
                    <li class="list-group-item"><b>Serveur : </b> <?php echo $row['nomServ'] . ' ' . $row['preServ'] ?></li>
                    <li class="list-group-item"><b>Table réservée : </b> <?php echo $row['numTable'] ?></li>
                </ul>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Total : </b> <?php echo $total . ' DA' ?></li>
                </ul>
                <div class="card-body">
                    <a class="float-start" href="#" data-toggle="modal" data-target="#commande<?php echo $cmd ?>">Détails</a>
                    <a class="float-end" target="_blank" href="generatePdf.php?client=<?php echo $row['client'] ?>&cmd=<?php echo $cmd ?>">Imprimer le ticket</a>
                </div>

            </div>


        </div>
        <?php
        $sql3 = "SELECT nom,prix,qte, prix*qte as total from contenir, consommations where
contenir.commande = '$cmd' and contenir.consommation = consommations.numCons;";
        $res3 = mysqli_query($conn, $sql3);
        ?>
        <!-- Details -->
        <div class="modal fade" id="commande<?php echo $cmd ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo "Commande N°" . $cmd ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Consommation</th>
                                    <th scope="col">Prix unitaire</th>
                                    <th scope="col">Quantité</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_array($res3)) { ?>
                                    <tr>
                                        <td><?php echo $row['nom'] ?></td>
                                        <td><?php echo $row['prix'] . ' DA' ?></td>
                                        <td><?php echo $row['qte'] ?></td>
                                        <td><?php echo $row['total'] . ' DA' ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <br>
                        <h5 class="message"><b>Total : <?php echo $total . ' DA' ?></b></h5>
                    </div>
                </div>
            </div>
        </div>
<?php }
?>

 <?php
}

?>

<script>

</script>


<style>
    .image {
        position: relative;
        text-align: center;
        color: black !important;
    }

    .text-cmd {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, 400%);
        color: black !important;
        font-size: large;
        font-weight: 800;
        font-style: italic;
    }
    b{
        font-weight: 800!important;
    }
</style>



