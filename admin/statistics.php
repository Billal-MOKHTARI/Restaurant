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
    <title>Statistiques - Restaurant L'Etoile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../client/src/assets/img/logo.png">
    <script src="https://kit.fontawesome.com/3c8382cb1c.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
</head>

<body>



    <?php include("navbar.php"); ?>
    <div class="container shadow-lg rounded animate__animated animate__fadeInDown" style="margin-top:100px">
        <div class="row">
            <div class="col shadow-lg p-3 mb-5 bg-white rounded">
                <form method="post" action="stats.php" target="_blank">
                    <div class="card-header">
                        <span>Les consommations les plus commandées</span>
                        <input hidden value="chart1" name="chart"></input>
                        <button type="submit" class="float-end btn btn-light btn-sm" id="char1" style="color : black" title="Imprimer"><i class="fas fa-print"></i></button>

                    </div>
                </form><br><br>
                <canvas id="myChart1"></canvas>
            </div>
            <div class="col shadow-lg p-3 mb-5 bg-white rounded">
                <form method="post" action="stats.php" target="_blank">
                    <div class="card-header">
                        <span>Clients fidèles</span>
                        <input hidden value="chart2" name="chart"></input>
                        <button class="float-end btn btn-light btn-sm" id="char2" type="submit" style="color : black" title="Imprimer"><i class="fas fa-print"></i></button>
                    </div>
                </form><br><br>
                <canvas id="myChart2"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col shadow-lg p-3 mb-8 bg-white rounded">
                <form method="post" action="stats.php" target="_blank">
                    <div class="card-header">
                        <span>Chiffre d'affaires mensuel</span>
                        <input hidden value="chart3" name="chart"></input>
                        <button class="float-end btn btn-light btn-sm" id="chart3" type="submit" style="color : black" title="Imprimer"><i class="fas fa-print"></i></button>
                    </div>
                </form><br><br>
                <canvas id="myChart3"></canvas>
            </div>



        </div>
    </div>
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

    .pg_notify {
        display: none !important;
    }

    #__chart1>canvas:nth-child(1) {
        display: none !important;
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

    .col {
        margin: 40px 40px 40px 40px !important;
        border-radius: 30px !important;
        padding: 10px;
    }

    .card-header {
        background-color: white !important;
    }

    .btn-light {
        background-color: white !important;
        border-radius: 15px !important;
    }

    .btn-light:hover {
        background-color: #dbdbdb !important;
    }
</style>
<?php
include("dbconn.php");
$sql = "SELECT consommations.nom,sum(qte) as 'total' from contenir, consommations where 
        consommations.numCons = contenir.consommation
        group by consommation order by sum(qte) DESC LIMIT 10";
$res = mysqli_query($conn, $sql);
$rows1 = mysqli_fetch_all($res);


/////////////////////////////////////////////////////////////////
$sql = "select nom,prenom,email, count(numCmd) as num from commandes, clients where clients.idClient = commandes.client group by client order by count(numCmd) desc limit 5";
$res = mysqli_query($conn, $sql);
$persons = array();
$num_commands = array();
while ($row = mysqli_fetch_array($res)) {
    array_push($persons, $row['nom'] . ' ' . $row['prenom']);
    array_push($num_commands, $row['num']);
}




/////////////////////////////////////////////////////////////////
$sql = "SELECT DATE(dateCmd), sum(prix*qte) as total 
from contenir, consommations, commandes 
where etat=1 and contenir.consommation = consommations.numCons and commandes.numCmd = contenir.commande
group by MONTH(dateCmd), YEAR(dateCmd)
order by dateCmd asc limit 12";

$res = mysqli_query($conn, $sql);
$rows3 = mysqli_fetch_all($res);
/////////////////////////////////////////////////////////////////
;
?>

<script>
    let best_sells = <?php echo json_encode(array_column($rows1, 0), JSON_HEX_TAG); ?>;
    let best_clients = <?php echo json_encode($persons, JSON_HEX_TAG); ?>;
    let ca = <?php echo json_encode(array_column($rows3, 0), JSON_HEX_TAG); ?>;

    let values1 = <?php echo json_encode(array_column($rows1, 1), JSON_HEX_TAG); ?>;
    let values2 = <?php echo json_encode($num_commands, JSON_HEX_TAG); ?>;
    let values3 = <?php echo json_encode(array_column($rows3, 1), JSON_HEX_TAG); ?>;
    const randColor = (number) => {
        let array = [];
        for (let index = 0; index < number; index++) {
            array.push("#" + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0').toUpperCase());
        }
        return array;
    }

    // Chart 1 : Best 10 sold consumptions ever //

    var ctx = document.getElementById("myChart1").getContext("2d");
    var myChart = new Chart(ctx, {
        type: "pie",
        data: {
            labels: best_sells,
            datasets: [{
                    data: values1,
                    backgroundColor: randColor(values1.length),
                },

            ],
        },
    });

    // Chart 2 : Best clients //

    var ctx2 = document.getElementById("myChart2").getContext("2d");
    var myChart = new Chart(ctx2, {
        type: "polarArea",
        data: {
            labels: best_clients,
            datasets: [{

                backgroundColor: randColor(values2.length),
                barPercentage: 0.5,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 2,
                borderRadius: 20,
                data: values2,
            }, ],
            options: {
                scales: {
                    myScale: {
                        type: 'logarithmic',
                        position: 'right', // `axis` is determined by the position as `'y'`
                    }
                }
            }
        },
    });

    // Chart 3 :  //
   let months = {"01" : "Janvier", "02" : "Février", "03" : "Mars", "04" : "Avril", 
"05" : "Mai", "06" : "Juin", "07" : "Juillet", "08" : "Août", "09" : "Septembre", "10" : "Octobre", 
"11" : "Novembre", "12" : "Décembre"};
    // convert date format
    dates = [];
    for (let i = 0; i < ca.length; i++) {
        dates[i] = ca[i].split("-");
        dates[i] = months[dates[i][1]] + " " + dates[i][0];
        console.log(dates[i]);
    }

    // chart 3 (CA)
    var ctx3 = document.getElementById("myChart3").getContext("2d");
    var myChart = new Chart(ctx3, {
        type: "line",
        data: {
            labels: dates,
            datasets: [{
                    label : "CA",
                    data: values3,
                    borderColor: "#f02e2e",
                    backgroundColor: "rgba(255, 0, 0, 0.06)",

                },

            ],
        },
    });




</script>

<script>

</script>