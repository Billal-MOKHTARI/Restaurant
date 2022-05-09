<?php
include("dbconn.php");

// $sql = "SELECT * from clients where nom = '%$keyword%' or prenom = '%$keyword%'";
// $res = mysqli_query($conn, $sql);
$q = $_GET['q'];
mysqli_select_db($conn, "ajax_demo");
$sql = "SELECT * FROM clients where nom like '%$q%' or prenom like '%$q%'";
$res = mysqli_query($conn, $sql);
?> <select multiple name="client" class="form-control animate__animated animate__fadeIn animate__delay-0.5s" id="exampleFormControlSelect2"> 
<?php while ($row = mysqli_fetch_array($res)) {
echo "<option value=". $row['idClient'] .">". $row['nom']. " ". $row['prenom'] ."</option>";
// <option><?php echo $row['nom'] . ' '. $q. $row['prenom']</option>

}  ?>
</select>