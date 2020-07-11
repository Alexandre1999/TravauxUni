<?php 

session_start();

if ($_SESSION["isAuth"]==false){
    header("Location:../index.php?error=notAuth");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Pointage - CEMS</title>
    <meta name="description" content="CEMS Stands for common event management system and is devised so as to manage events as">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="../assets/css/Pretty-Search-Form.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-layer-group"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>CEMS</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="nav navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="index.php"><i class="fas fa-user-check"></i><span>Pointage</span></a></li>
                    <li class="nav-item" role="presentation"></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <form class="form-inline d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"></div>
                        </form>
                        <ul class="nav navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" role="menu" aria-labelledby="searchDropdown">
                                    <form class="form-inline mr-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1" role="presentation">
                                <div class="shadow dropdown-list dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown"></div>
                            </li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow" role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small"><?php echo $_SESSION["login"]?></span><img class="border rounded-circle img-profile" src="../assets/img/avatars/blank-profile.png"></a>
                                    <div
                                        class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu"><a class="dropdown-item" role="presentation" href="../../USER/index.php"><i class="fas fa-language fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;English</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" role="presentation" href="../includes/logout.inc.php" name="dropdown-logout"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Deconnexion</a></div>
                    </div>
                    </li>
                    </ul>
            </div>
            </nav>
            <div class="container-fluid">

                    <?php
                    if(isset($_GET['error'])) {
                        if ($_GET["error"] == "emptyfield") {
                            echo '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Attention!</strong> Completez tous les champs</div>';
                        }

                        if ($_GET['error'] == "success"){
                            echo '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Succès!</strong>     <i class="far fa-thumbs-up"></i></div>';
                        }

                        if ($_GET['error'] == "failed"){
                            echo '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Attention!</strong> Echec</div>';
                        }

                        if ($_GET['error'] == "wrongval"){
                            echo '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Attention!</strong> Entrez un EID valide</div>';
                        }

                        if ($_GET['error'] == "wrnginput"){
                            echo '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Attention!</strong> Entrez un nom et prenom valide</div>';
                        }
                    }
                    ?>


                <h3 class="text-dark mb-1">Pointage</h3>
                <p>Selectionner l'événement à pointer</p>
                <div class="row" style="margin-top: 20px;">
                    <div class="col">
                        <div>
                            <div class="table-responsive">



                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>EID</th>
                                            <th>Nom</th>
                                            <th>Date</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php

                                            require '../php/userindex.php';

                                            if(mysqli_num_rows($myresult) > 0) {
                                            while ($row = mysqli_fetch_array($myresult)) {
                                            ?>

                                        <tr>
                                            <td><?php echo $row["eid"]; ?></td>
                                            <td><?php echo $row["intitule"]; ?></td>
                                            <td><?php echo $row["dateDebut"]; ?></td>
                                            <td><?php echo $row["type"]; ?></td>
                                        </tr>

                                        <?php
                                        }
                                    }
                                    ?>
                                        </tr>
                                        <tr></tr>
                                    </tbody>
                                </table>



                            </div>



                            <form action="../php/userpoint.php" method="post">
                                <div class="form-row">
                                    <div class="col-auto" style="margin-right: 5px;"><input class="form-control" type="text" placeholder="EID" name="usereid" style="width: 171px;"></div>
                                    <div class="col-auto text-center"><button class="btn btn-primary" type="submit" name="usereventsearch">Pointer</button></div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-white sticky-footer">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>CEMS 2020</span></div>
            </div>
        </footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="../assets/js/theme.js"></script>
</body>

</html>