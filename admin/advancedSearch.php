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
    <title>Recherches avancées - Restaurant L'Etoile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/3c8382cb1c.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="../client/src/assets/img/logo.png">
</head>

<body onload="elements()">



    <?php include("navbar.php"); ?>
    <?php
    include("dbconn.php");
    ?>
    <div class="container shadow-lg rounded" style="margin-top:100px">
        <br>
        <div class="row">
            <div class="form-floating col-md-2">
                <label for=""></label>
                <select class="form-select" id="select-type" onchange="elements()">
                    <option value="clients">Clients</option>
                    <option value="commandes">Commandes</option>
                </select>
                <label for="select-type">&nbsp;&nbsp;Que recherchez-vous ?</label>
            </div>
            <div class="form-floating col-md-2 animate__animated animate__fadeInLeft" id="select-date-div">
                <input class="form-control" id="select-date" type="date" oninput="search()">
                <label for="select-date">&nbsp;&nbsp;Date</label>
            </div>
            <div class="form-floating col-md-4">
                <input id="keys" class="form-control" type="search" oninput="search()" placeholder="Mots clé..">
                <label for="keys">&nbsp;&nbsp;Mots clé</label>
            </div>

        </div><br>
        <hr>
        <div id="load">

            <img id="loader" src="./assets/photos/loading.svg"></img>
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

    .message {
        display: flex;
        justify-content: center;
    }
</style>



<script>
    date = document.getElementById("select-date");
    keys = document.getElementById("keys");
    type = document.getElementById("select-type");

    const loader = '<img id="loader" src="./assets/photos/loading.svg"></img>';

    function search() {
        if ((date.value == '' && keys.value == '' )|| (type.value == "clients" && keys.value == "")) {
            document.getElementById("load").innerHTML = '';
            document.getElementById("content").innerHTML = "<div class='message'><b>Aucun filtre n'est appliqué</b><div>";
        } else {
            document.getElementById("content").innerHTML = "";

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200 && (date.value != '' || keys.value != '')) {
                    document.getElementById("load").innerHTML = '';
                    document.getElementById("content").innerHTML = this.responseText;
                    if (this.responseText == '') {
                        document.getElementById("load").innerHTML = '';
                        document.getElementById("content").innerHTML = "<div class='message'><b>Aucun résultat.</b><div>";
                    }
                }
            };
            document.getElementById("load").innerHTML = loader;
            xmlhttp.open("GET", "search.php?q=" + keys.value + "&date=" + date.value + "&type=" + type.value, true);
            xmlhttp.send();
        }

    }


    function elements() {
        dateDiv = document.getElementById("select-date-div")
        if (type.value == "clients") {
            dateDiv.style.display = "none";
        } else {
            dateDiv.style.display = "inline";
        }
        search();
    }

    function updateProgress(evt) {
        if (evt.lengthComputable) {
            var percentComplete = (evt.loaded / evt.total) * 100;
            $('#progressbar').progressbar("option", "value", percentComplete);
        }
    }
</script>

<style>
    #load{
        display: flex;
justify-content: center;
    }
    .container{
        min-height : 700px;
    }
    div{
        transition: height;
    }
</style>