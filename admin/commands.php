<?php
   $total_cmds = 0;
   
?>

<?php
session_start();
$_SESSION['number_cmds'] = 0;
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
    <title>Dernières commandes - Restaurant L'Etoile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../client/src/assets/img/logo.png">
</head>

<body onload="showCommands()">



    <?php include("navbar.php") ?>
    <div class="container shadow-lg rounded" style="margin-top:100px">
        <div>
            <br>
            <div class="live">
                <img id="point" src="assets/photos/red-point.png" width="10" height="10">&nbsp;&nbsp;
                <h7 style="color : #d9333e">En temps réel</h7>
                <b> <small id="date" class="float-right" style="float : right"></small></b>
            </div>

        </div>
        <hr><br>
        <div id="container">
        </div>
    </div>
</body>

</html>

<script>
    function showCommands() {

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("container").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "searchCmds.php?", true);
        xmlhttp.send();

    }
    function validate(cmd) {
        if (confirm("Êtes-vous sûr de vouloir valider la commande ?")) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("container").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "validateCmd.php?cmd=" + cmd, true);
            xmlhttp.send();
        }

    }
    function showDate() {
        var today = new Date();
        var day = String(today.getDate()).padStart(2, '0') + '/' + String(today.getMonth() + 1).padStart(2, '0') + '/' + today.getFullYear();;

        var hour = (today.getHours() < 10 ? '0' : '') + today.getHours() + ':' + (today.getMinutes() < 10 ? '0' : '') + today.getMinutes() + ':' + (today.getSeconds() < 10 ? '0' : '') + today.getSeconds();

        date = day + '  ' + hour;
        document.getElementById("date").innerHTML = date;
    }
</script>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script>
    $(document).ready(function() {
        setInterval(showCommands, 1000);
        setInterval(showDate, 1000);
    });
</script>
