<?php
include("dbconn.php");
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $client = $_GET['client'];
    $sql = "UPDATE asseoir SET etat = 0 where client = '$client'";
    if(mysqli_query($conn, $sql) === TRUE)
    {
        echo "<script>alert('Enregistré ! '); window.location.href = history.back()</script>";
    }
}