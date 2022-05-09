<!DOCTYPE html>
<html>

<head>
    <title>Liste des tables - Restaurant L'Etoile</title>
    <link rel="icon" type="image/x-icon" href="../client/src/assets/img/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container shadow-lg rounded" style="margin-top:100px">

        <div>
            <br><br> <button class="btn btn-warning" data-toggle="modal" data-target="#AddModalCenter">Ajouter une table..</button>
</div><br><br>
        <div class="modal fade" id="AddModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Ajouter une table</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post">
                        <div class="modal-body">
                            <label>Serveur : </label>
                            <select class="form-select" name="server">


                                <?php
                                include('dbconn.php');
                                $sql0 = "SELECT * from serveurs";
                                $res0 = mysqli_query($conn, $sql0);
                                while ($row0 = mysqli_fetch_array($res0)) {
                                ?>
                                    <option value="<?php echo $row0['numServ'] ?>"><?php echo $row0['nom'] . ' ' . $row0['prenom'] ?></option>
                                <?php } ?>
                            </select>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button>
                                <button type="submit" name="add" class="btn btn-success">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">

            <?php

            
            $sql = "SELECT * from tables ORDER BY numTable";
            $res = mysqli_query($conn, $sql);
            ?>

            <?php
            while ($row = mysqli_fetch_array($res)) { ?>
                <div class="col-md-auto">
                    <div class="card shadow-lg bg-white rounded" style="width: 18rem; margin : 20px; border-radius : 20px!important">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo 'Table N° ' . $row['numTable'] ?></h5>
                            <p class="card-text"></p>
                            <form method="post">
                                <select class="form-select" name="server">


                                    <?php
                                    $sql2 = "SELECT * from serveurs";
                                    $res2 = mysqli_query($conn, $sql2);
                                    while ($row2 = mysqli_fetch_array($res2)) {
                                    ?>
                                        <option <?php if ($row['Serveur'] == $row2['numServ']) echo 'selected' ?> value="<?php echo $row2['numServ'] ?>"><?php echo $row2['nom'] . ' ' . $row2['prenom'] ?></option>
                                    <?php } ?>
                                </select>

                                <input name="table" hidden value="<?php echo $row['numTable'] ?>">
                                <div class="card-body">
                                    <button type="submit" name="update" class="updateButton float-start"><i class="fas fa-edit"></i>&nbsp;Modifier</button>
                                    <button type="submit" name="delete" class="deleteButton float-end"><i class="fas fa-trash"></i>&nbsp;Supprimer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            <?php } ?>

        </div>
    </div>

</body>

</html>

<style>
    .updateButton,
    .deleteButton {
        outline: none;
        background-color: transparent;
        border: none;
        border-radius: 10px;
        padding: 10px;
        font-weight: 500;
    }

    .updateButton {
        color: #A5923B;
    }

    .deleteButton {
        color: #E04B3D;
    }

    .updateButton:focus {
        outline: none;

    }

    .deleteButton:focus {
        outline: none;
    }

    .updateButton:hover {
        background-color: #E4D695;
    }

    .deleteButton:hover {
        background-color: #F7B8B2;
    }
</style>

<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $table = $_POST['table'];
    $serv = $_POST['server'];
    $sql = "update `tables` set Serveur = '$serv' where numTable = '$table'";
    if (mysqli_query($conn, $sql) === TRUE) {
        echo "<script>alert('Enregistré ! '); window.location.href = window.location.href</script>";
    } else {
        echo "<script>alert('Erreur ! ')</script>" . $conn->error;;
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    $_id = $_POST['table'];
    $sql = "DELETE from `tables` where numTable = '$_id'";
    if (mysqli_query($conn, $sql) === TRUE) {
        echo "<script>alert('Supprimé ! '); window.location.href = window.location.href</script>";
    } else {
        echo "<script>alert('Erreur ! ')</script>" . $conn->error;;
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add'])) {
    $server = $_POST['server'];
    $sql2 = "SELECT max(numTable) from tables";
    $res0 = mysqli_query($conn, $sql2);
    $numTable = mysqli_fetch_array($res0)[0] + 1;
    $sql = "INSERT into tables (numTable,Serveur)VALUES('$numTable','$server')";
    if (mysqli_query($conn, $sql) === TRUE) {
        echo "<script>alert('Ajouté ! '); window.location.href = window.location.href</script>";
    } else {
        echo "<script>alert('Erreur ! ')</script>" . $conn->error;;
    }
}

?>