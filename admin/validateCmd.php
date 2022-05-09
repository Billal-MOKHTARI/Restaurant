<?php
include("dbconn.php");
session_start();

mysqli_select_db($conn, "ajax_demo");
$cmd = $_GET['cmd'];
$sql = "UPDATE commandes set etat = 1 where numCmd = '$cmd'";
if(mysqli_query($conn, $sql) === TRUE){
    echo "<script>alert('Commande validée !')</script>";
}

?>

