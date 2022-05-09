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
    <title>Liste des consommations - Restaurant L'Etoile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/3c8382cb1c.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="../client/src/assets/img/logo.png">
</head>

<body onload="showConsommations('')">



    <?php include("navbar.php"); ?>
    <?php
    include("dbconn.php");
    ?>
    <div class="container shadow-lg rounded" style="margin-top:100px">
        <br>
        <hr><br>
        <div class="row">
            <div class="col-md-auto">
                <button class="btn btn-warning" data-toggle="modal" data-target="#AddModalCenter">Ajouter une consommation..</button>
            </div>
            <div class="col-md-8">
                <form>
                    <input class="form-control" name="keyword" type="search" oninput="showConsommations(this.value)" placeholder="Recherche.." aria-label="Search">

                </form>
            </div>
        </div><br>
        <hr><br>
        <div class="modal fade" id="AddModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Ajouter une consommation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label for="name">Nom</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="mb-3">
                                    <label for="price">Prix</label>
                                    <div class="input-group mb-3">

                                        <input type="number" class="form-control" name="price" value="">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">D.A</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="type">Type</label>
                                    <select class="form-select" name="type">
                                        <option value="entrée">Entrée</option>
                                        <option value="plat">Plat</option>
                                        <option value="dessert">Dessert</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="customFile">Choisir une photo</label>
                                    <input name="image" type="file" class="form-control" />
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
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $_id = $_POST['idCons'];
    $ImageName = $_FILES["image"]["name"];
    if ($ImageName != '') {
        require("insertFile.php");
    }
    if (isset($NewImageName))
        $sql = "update `consommations` set nom = '$name', prix = '$price', type = '$type', photo = '$NewImageName' where numCons = '$_id'";
    else
        $sql = "update `consommations` set nom = '$name', prix = '$price', type = '$type' where numCons = '$_id'";
    if (mysqli_query($conn, $sql) === TRUE) {
        echo "<script>window.location.href = window.location.href</script>";
    } else {
        echo "<script>alert('Erreur ! ')</script>" . $conn->error;;
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    $_id = $_POST['cons'];
    $sql = "DELETE from `consommations` where numCons = '$_id'";
    if (mysqli_query($conn, $sql) === TRUE) {
        echo "<script>window.location.href = window.location.href</script>";
    } else {
        echo "<script>alert('Erreur ! ')</script>" . $conn->error;;
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add'])) {
    $name = str_replace("'", "\'", $_POST['name']);
    $price = $_POST['price'];
    $type = $_POST['type'];
    $ImageName = $_FILES["image"]["name"];
    if ($ImageName != '') {
        require("insertFile.php");
    }
    if (isset($NewImageName))
        $sql = "INSERT into consommations (nom,prix, type, photo)VALUES('$name','$price', '$type', '$NewImageName')";
    else
        $sql = "INSERT into consommations (nom,prix, type, photo)VALUES('$name','$price', '$type', '')";
    if (mysqli_query($conn, $sql) === TRUE) {
        echo "<script>window.location.href = window.location.href</script>";
    } else { ?>
        <script>let error = <?php echo '"'.$conn->error.'"' ?> ;alert(error)</script>;
   <?php }
}
?>

<script>
    function showConsommations(str) {

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "searchConsom.php?q=" + str, true);
        xmlhttp.send();

    }
</script>
<script>

    function deleteClasses()
    {
        cons = document.getElementsByClassName("col-md-auto");
        for (let i = 0; i < cons.length; i++) {
            cons[i].classList.remove("animate__animated");
            cons[i].classList.remove("animate__fadeIn");
        }

    }
    function addClasses()    {
        cons = document.getElementsByClassName("col-md-auto");
        for (let i = 0; i < cons.length; i++) {
            cons[i].classList.add("animate__animated");
            cons[i].classList.add("animate__fadeIn");
        }

    }
</script>