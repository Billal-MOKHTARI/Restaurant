<?php
include("dbconn.php");
session_start();

mysqli_select_db($conn, "ajax_demo");
?>

<div class="table-responsive">
    <table class="table table-bordered border-dark">
        <thead>
            <tr class="table-dark">
                <th scope="col">Date</th>
                <th scope="col">Client</th>
                <th scope="col">Serveur concerné</th>
                <th scope="col">Commande</th>
                <th scope="col">Prix total</th>
                <th scope="col">Etat</th>
            </tr>
        </thead>

        <tbody>

            <?php
            include("dbconn.php");
            $date = date("Y-m-d");
            $sql1 = "SELECT commandes.dateCmd,commandes.numCmd,clients.idClient,commandes.etat, clients.nom as cn, clients.prenom as cp,
serveurs.nom as sn, serveurs.prenom as sp 
from `clients`, `commandes`, `serveurs`, `asseoir`, `tables` 
WHERE `clients`.idClient = `commandes`.client AND asseoir.client = commandes.client 
AND DATE(dateCmd) = asseoir.dateServ AND DATE(dateCmd )LIKE '" . $date . "' AND tables.numTable = asseoir.numTable 
AND serveurs.numServ = tables.Serveur ORDER BY commandes.etat ASC, dateCmd ASC";
            $res = mysqli_query($conn, $sql1);

            while ($row = mysqli_fetch_array($res)) {
                $sql2 = "SELECT consommations.nom, consommations.prix, consommations.type,
                 contenir.qte from consommations, contenir
                WHERE consommations.numCons = contenir.consommation 
                and contenir.commande = " . $row['numCmd'];
                $res2 = mysqli_query($conn, $sql2);

            ?>
                <tr>
                    <th class="align-middle" scope="row"><?php echo $row["dateCmd"] ?></th>
                    <td class="align-middle"><?php echo $row['cn'] . ' ' . $row['cp']  ?></td>
                    <td class="align-middle"><?php echo $row['sn'] . ' ' . $row['sp'] ?></td>

                    <td class="align-middle">
                        <table class="table table-borderless table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Consommation</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Prix unitaire</th>
                                    <th scope="col">Quantité</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $totalPrice = 0;
                                while ($row2 = mysqli_fetch_array($res2)) {
                                    $totalPrice = $totalPrice + ($row2['prix'] * $row2['qte']);
                                ?>
                                    <tr>

                                        <td><?php echo ucfirst($row2['nom']) ?></td>
                                        <td><?php echo ucfirst($row2['type']) ?></td>
                                        <td><?php echo $row2['prix'] ?></td>
                                        <td><?php echo $row2['qte'] ?></td>
                                        <td><?php echo $row2['prix'] * $row2['qte'] . ' DA' ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>


                        </table>
                    </td>
                    <td class="align-middle"><b style='font-size : large'><?php echo $totalPrice. ' DA' ?></b><br><br><a class="btn btn-outline-secondary btn-sm" href="generatePdf.php?client=<?php echo $row['idClient'] . '&cmd=' . $row['numCmd'] ?>" target="_blank">Imprimer le Ticket</a></td>
                    <td class="align-middle"><b style='font-size : large'><?php if ($row['etat'] == 0) { ?>
                                <div><span class="badge bg-warning text-dark">  <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </svg>En attente</span></div><br>
                                <button onclick="validate(<?php echo $row['numCmd'] ?>)" class="btn btn-success">Valider</button>

                            <?php } else { ?>
                                <div><span class="badge bg-success text-dark">Validée</span></div>
                            <?php } ?></td>
                </tr>

            <?php }
            ?>
        </tbody>
    </table>
</div>

<script>

</script>