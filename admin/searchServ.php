<?php
include("dbconn.php");

$q = $_GET['q'];
mysqli_select_db($conn, "ajax_demo");
$sql = "SELECT * FROM serveurs where nom like '%$q%' or prenom like '%$q%'";
$res = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($res)) {
    ?>
        <div class="col-md animate__animated animate__fadeIn">
            <div class="card shadow-lg bg-white rounded" style="width: 18rem; margin : 20px; border-radius : 20px!important">
                <img class="card-img-top" src="assets/photos/serveur.png" style="border-top-left-radius : 20px;border-top-right-radius : 20px" width="300" height="200" alt="<?php echo $row['nom'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['nom']. ' '.$row['prenom'] ?></h5>
                    <p class="card-text"></p>
                </div>

                <div class="card-body">
                    <a href="#" onclick="deleteClasses()" class="card-link update float-start" data-toggle="modal" data-target="#UpdateModalCenter<?php echo $row['numServ'] ?>"><i class="fas fa-edit"></i>&nbsp;Modifier</a>
                    <a href="#" onclick="deleteClasses()" class="card-link delete float-end" data-toggle="modal" data-target="#DeleteModalCenter<?php echo $row['numServ'] ?>"><i class="fas fa-trash"></i>&nbsp;Supprimer</a>
                </div>


                <!-- Update Modal -->
                <div class="modal fade" id="UpdateModalCenter<?php echo $row['numServ'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo "Modifier " . $row['nom'] ?></h5>
                                <button onclick="addClasses()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" enctype="multipart/form-data">
                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label for="name">Nom</label>
                                        <input type="text" class="form-control" name="nom" value="<?php echo $row['nom'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="prenom">Prénom</label>
                                        <input type="text" class="form-control" name="prenom" value="<?php echo $row['prenom'] ?>">
                                    </div>
                                    <input hidden name="server" value="<?php echo $row['numServ'] ?>">

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button>
                                        <button type="submit" name="update" class="btn btn-warning">Enregister</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="DeleteModalCenter<?php echo $row['numServ'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo "Supprimer " . $row['nom']. ' '. $row['prenom'] ?></h5>
                                <button type="button" onclick="addClasses()" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post">
                                <div class="modal-body">

                                    <p style="color : black">Voulez-vous vraiment supprimer '<?php echo $row['nom'].' '.$row['prenom']  ?>' ?</p>
                                    <input hidden name="server" value="<?php echo $row['numServ'] ?>">

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button>
                                        <button type="submit" name="delete" class="btn btn-danger">Supprimer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <?php }  ?>