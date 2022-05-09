<link rel="stylesheet" href="assets/css/navbar.css">
<link rel="icon" type="image/x-icon" href="../client/src/assets/img/logo.png">
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<nav class="navbar navbar-expand-sm fixed-top navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><a href="index.php" class="text-black"><span class="text-primary"><img src="../client/src/assets/img/logo.png" width="200" height="70"></a></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav  ms-auto mb-2 mb-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">

                <li class="nav-item">
                    <a class="nav-link" id="reserver" aria-current="page" href="./reserver.php">Réservations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="commands" href="./commands.php">Dernières commandes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="statistics" href="./statistics.php">Statistiques</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Mon Restaurant
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="navbarScrollingDropdown">
                        <li><a class="dropdown-item" id="consommations" href="./consommations.php">Consommations</a></li>
                        <li><a class="dropdown-item" id="tables" href="./tables.php">Tables</a></li>
                        <li><a class="dropdown-item" id="serveurs" href="./serveurs.php">Serveurs</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" id="advancedSearch" href="./advancedSearch.php">Recherches avancées</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="bg"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/3c8382cb1c.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha256-CjSoeELFOcH0/uxWu6mC/Vlrc1AARqbm/jiiImDGV3s=" crossorigin="anonymous"></script>
<style>


    .logout-button {
        background-color: transparent;
        border: none;
        padding: 15px;
    }

    .logout-button:focus {
        outline: none;
    }

    form:hover {
        background-color: #f8f9fa;
    }

    a.nav-link::before {
        display: none;
    }

    .close {
        background-color: transparent !important;
        border: none;
    }

    .table td,
    .table th {
        text-align: center;
    }


</style>

<script>
    var path = window.location.pathname;
    var page = path.split("/").pop().split('.')[0];
    console.log(page);
    document.getElementById(page).classList.add("active");
    //  if(location.href == '')
    function logout() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("POST", "logout.php", true);
        xmlhttp.send();
    }
</script>