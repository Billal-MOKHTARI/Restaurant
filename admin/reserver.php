<?php
session_start();
/*if (!isset($_SESSION['AdminLoginId'])) {
    header("location: login.php");
}*/
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
}
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Réservation de tables - Restaurant L'Etoile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/3c8382cb1c.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="../client/src/assets/img/logo.png">
</head>

<body>



    <?php include("navbar.php") ?>
    <div class="container shadow-lg rounded" style="margin-top:100px">
        <br><br>
        <div class="row">
            <div class="col-md-auto">
                <button class="btn btn-warning" data-toggle="modal" data-target="#AddModalCenter">Nouvelle réservation ..</button>
            </div><br>
            <div class="col-md-8">
                <b> <small id="date" class="float-right" style="float : right"></small></b>
            </div>
        </div>

        <hr><br>

        <div class="table-responsive">
            <table class="table table-bordered border-dark">
                <thead>
                    <tr class="table-active">
                        <th class="align-middle" scope="col">Table</th>
                        <th class="align-middle" scope="col">Serveur</th>
                        <th class="align-middle" scope="col">Etat</th>
                        <th class="align-middle" scope="col">Retirer un client </th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    include("dbconn.php");
                    $sql1 = "SELECT numTable, Serveur, nom, prenom from tables, serveurs where tables.Serveur = serveurs.numServ ORDER BY numTable ASC";
                    $res1 = mysqli_query($conn, $sql1);
                    $FullTables = array();
                    $ActiveClients = array();
                    while ($row1 = mysqli_fetch_array($res1)) {
                        $table = $row1['numTable'];
                        $sql2 = "SELECT client FROM asseoir WHERE etat = 1 and numTable = '$table'";
                        $sql3 = "SELECT idClient,nom, prenom, dateNaiss,email,tel,client FROM asseoir, clients WHERE clients.idClient = asseoir.client and etat = 1 and numTable = '$table'";
                        $state = mysqli_num_rows(mysqli_query($conn, $sql2));
                        if ($state != 0) {
                            $res3 = (mysqli_query($conn, $sql3));
                        } else {
                            $res3 = NULL;
                        }
                        if ($state == 4) {
                            array_push($FullTables, $table);
                        }
                    ?>
                        <tr <?php if (in_array($row1['numTable'], $FullTables)) echo "class='table table-danger'" ?>>
                            <td class="align-middle"><?php echo $row1['numTable'] ?></td>
                            <td class="align-middle"><?php echo $row1['nom'] . ' ' . $row1['prenom'] ?></td>
                            <td class="align-middle"><?php echo $state . '/4' ?></td>
                            <td class="align-middle"><?php $i = 0;
                                                        while ($res3 != NULL && $client = mysqli_fetch_array($res3)) {

                                                            if ($i != 0) echo '<hr>';
                                                            $i += 1;
                                                            echo '<b><button class="clients-btn" data-toggle="modal" data-target="#AddModalCenter' .  $client["idClient"] . '">' . $client['nom'] . ' ' . $client['prenom'] . '</button></b>';
                                                            echo "<a class='delete-btn float-end' href='clientOut.php?client=" . $client['client'] . "'><i class='fas fa-eraser'></i></a>";
                                                        ?>
                                    <div class="modal fade" id="AddModalCenter<?php echo $client["idClient"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Informations du client</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-floating mb-3">
                                                        <input name="nom" class="form-control mr-sm-2" readonly value="<?php echo $client['nom'] ?>"></input>
                                                        <label for="nom">Nom</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input name="prenom" class="form-control mr-sm-2" readonly value="<?php echo $client['prenom'] ?>"></input>
                                                        <label for="prenom">Prénom</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input name="naiss" class="form-control mr-sm-2" readonly value="<?php echo $client['dateNaiss'] ?>"></input>
                                                        <label for="naiss">Date de Naissance</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input name="email" class="form-control mr-sm-2" readonly value="<?php echo $client['email'] ?>"></input>
                                                        <label for="email">Email</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input name="tel" class="form-control mr-sm-2" readonly value="<?php echo $client['tel'] ?>"></input>
                                                        <label for="tel">Numéro Tel.</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                                            array_push($ActiveClients, $client['client']);
                                                        }   ?>
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="AddModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Nouvelle réservation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="name">Nom du client</label>

                                <form class="form-inline my-2 my-lg-0" autocomplete="off">
                                    <input class="form-control mr-sm-2" autocomplete="off" name="keyword" type="search" oninput="showUsers(this.value)" placeholder="Recherche.." aria-label="Search">
                                    <script>
                                        function showUsers(str) {
                                            if (str == "") {
                                                document.getElementById("txtHint").innerHTML = "";
                                                return;
                                            } else {
                                                var xmlhttp = new XMLHttpRequest();
                                                xmlhttp.onreadystatechange = function() {
                                                    if (this.readyState == 4 && this.status == 200) {
                                                        document.getElementById("txtHint").innerHTML = this.responseText;
                                                    }
                                                };
                                                xmlhttp.open("GET", "searchClients.php?q=" + str, true);
                                                xmlhttp.send();
                                            }
                                        }
                                    </script>
                                </form>
                                <div id="txtHint" class=""><b></b></div>


                            </div>
                            <div class="form-group">
                                <label for="table">Table</label>
                                <select class="form-select" name="table">
                                    <?php
                                    $FullTablesString = implode(',', $FullTables);
                                    $sql = "SELECT numTable from tables where numTable not in ('$FullTablesString')";
                                    $res = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($res)) {
                                    ?>

                                        <option value="<?php echo $row['numTable'] ?>"><?php echo $row['numTable'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button>
                                <button type="submit" name="add" class="btn btn-warning">Ajouter</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>



    </div>
</body>

</html>

<?php
if (isset($_POST['add'])) {
    $table = $_POST['table'];
    $client = $_POST['client'];
    if (in_array($client, $ActiveClients)) {
        echo "<script>alert('Le client a déjà réservé une table.')</script>";
    } else {
        $date = date("Y-m-d");
        $sql1 = "SELECT * from asseoir where client = '$client' and numTable = '$table' and dateServ = '$date'";
        $res = mysqli_query($conn, $sql1);
        if(mysqli_num_rows($res) > 0)
        {
            $sql = "UPDATE asseoir set etat = 1 where client = '$client' and numTable = '$table' and dateServ = '$date'";
        }
        else
        $sql = "INSERT into asseoir (numTable, client,dateServ, etat)VALUES('$table', '$client','$date', 1)";
        if (mysqli_query($conn, $sql) === TRUE) {
            echo "<script>alert('Réservation effectuée ! '); window.location.href = window.location.href</script>";
        } else {
            echo "<script>alert('Erreur ! '); window.location.href = window.location.href</script>";
        }
    }
}

?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script>
    function showDate() {
        var today = new Date();
        var day = String(today.getDate()).padStart(2, '0') + '/' + String(today.getMonth() + 1).padStart(2, '0') + '/' + today.getFullYear();;

        var hour = (today.getHours() < 10 ? '0' : '') + today.getHours() + ':' + (today.getMinutes() < 10 ? '0' : '') + today.getMinutes() + ':' + (today.getSeconds() < 10 ? '0' : '') + today.getSeconds();

        date = day + '  ' + hour;
        document.getElementById("date").innerHTML = date;
    }
    $(document).ready(function() {
        setInterval(showDate, 1000);
    });
</script>


<style>
    .client-btn {
        color: #0f163d;
    }

    .client-btn:hover {
        color: #8f0e22
    }

    .clients-btn {
        margin: 0;
        background-color: transparent;
        border: 0;
        padding: 10px;
        border-radius: 10px;
    }

    .clients-btn:hover {
        background-color: #e6e6e6;
    }

    .delete-btn {
        color: red;
        background-color: #e6e6e6;
        padding: 5px 10px 5px 10px !important;
        border-radius: 10px;
    }

    .delete-btn:hover {
        background-color: red;
        color: white;
    }
</style>