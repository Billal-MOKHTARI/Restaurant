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
    <title>Serveurs du restaurant - Restaurant L'Etoile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../client/src/assets/img/logo.png">
</head>

<body onload="showServeurs('')">



    <?php include("navbar.php"); ?>
    <?php
    include("dbconn.php");
    ?>
    <div class="container shadow-lg rounded" style="margin-top:100px">
        <br>
        <hr><br>
        <div class="row">
            <div class="col-md-4">
                <button class="btn btn-warning" data-toggle="modal" data-target="#AddModalCenter">Nouveau serveur..</button>
            </div>
            <div class="col-md-8">
                <form>
                    <input class="form-control" name="keyword" type="search" oninput="showServeurs(this.value)" placeholder="Recherche.." aria-label="Search">

                </form>
            </div>
        </div><br>
        <hr><br>
        <div class="modal fade" id="AddModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Nouveau serveur</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" name="nom">
                                </div>
                                <div class="mb-3">
                                    <label for="prenom">Prenom</label>
                                    <input type="text" class="form-control" name="prenom">
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button>
                                    <button type="submit" name="add" class="btn btn-warning">Valider</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <div id="content" class="row"></div>
    </div>
</body>

</html>

<style>
    .update,
    .delete {
        outline: none;
        background-color: transparent;
        border: none;
        margin-right: 10px;
        border-radius: 10px;
        padding: 10px;
        font-weight: 500;
    }

    .update {
        color: #A5923B;
    }

    .delete {
        color: #E04B3D;
    }

    .update:focus {
        outline: none;

    }

    .delete:focus {
        outline: none;
    }

    .update:hover {
        background-color: #E4D695;
        color: #A5923B;
    }

    .delete:hover {
        background-color: #F7B8B2;
        color: #E04B3D;
    }
</style>

<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $name = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $_id = $_POST['server'];
        $sql = "update `serveurs` set nom = '$name', prenom = '$prenom' where numServ = '$_id'";
    if (mysqli_query($conn, $sql) === TRUE) {
        echo "<script>window.location.href = window.location.href</script>";
    } else {
        echo "<script>alert('Erreur ! ')</script>" . $conn->error;;
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    $_id = $_POST['server'];
    $sql = "DELETE from `serveurs` where numServ = '$_id'";
    if (mysqli_query($conn, $sql) === TRUE) {
        echo "<script>window.location.href = window.location.href</script>";
    } else {
        echo "<script>alert('Erreur ! ')</script>" . $conn->error;;
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add'])) {
    $name = str_replace("'", "\'", $_POST['nom']);
    $prenom = $_POST['prenom'];

    $sql = "INSERT into serveurs (nom,prenom)VALUES('$name','$prenom')";
    if (mysqli_query($conn, $sql) === TRUE) {
        echo "<script>window.location.href = window.location.href</script>";
    } else {
        echo "<script>alert('Erreur ! ')</script>" . $conn->error;;
    }
}
?>

<script>
    function showServeurs(str) {

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "searchServ.php?q=" + str, true);
        xmlhttp.send();

    }
</script>

<script>

    function deleteClasses()
    {
        cons = document.getElementsByClassName("col-md");
        for (let i = 0; i < cons.length; i++) {
            cons[i].classList.remove("animate__animated");
            cons[i].classList.remove("animate__fadeIn");
        }

    }
    function addClasses()    {
        cons = document.getElementsByClassName("col-md");
        for (let i = 0; i < cons.length; i++) {
            cons[i].classList.add("animate__animated");
            cons[i].classList.add("animate__fadeIn");
        }

    }
</script>