<?php 

session_start();

if ($_SESSION["Access"]=="admin"){
    header("Location:ADMIN/index.php?error=Auth");
    exit();
}

if ($_SESSION["Access"]=="user"){
    header("Location:USER/index.php?error=Auth");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <META http-equiv="Content-Type" content="text/html; charset= ISO-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Connexion - CEMS</title>
    <meta name="description" content="CEMS Stands for common event management system and is devised so as to manage events as">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body style="background-color: rgb(238,238,238);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 col-xl-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image"><img src="assets/img/geometric.jpg" style="width: 466px;"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Bienvenue !</h4>

                                        <?php
                                        if(isset($_GET['error'])){
                                            if($_GET["error"] == "wrongpwd"){
                                                echo '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Attention!</strong> Mot de Passe incorrecte</div>';
                                            }
                                            else if($_GET["error"] == "illegalsignin"){
                                                echo '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Attention!</strong> Entrez vos informations d\'utilisateur correctement</div>';
                                            }

                                            else if($_GET["error"] == "emptyfields"){
                                                echo '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Attention!</strong> Remplissez tous les champs</div>';
                                            }

                                            else if($_GET["error"] == "sqlerror"){
                                                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Attention!</strong> Entrée non autorisée</div>';
                                            }

                                            else if($_GET["error"] == "notAuth"){
                                                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Attention!</strong> Entrée non autorisée</div>';
                                            }
                                        }
                                        ?>

                                    </div>
                                    <form class="user" action="includes/login.inc.php" method="post">
                                        <div class="form-group"><input class="form-control form-control-user" type="text" id="InputLogin" placeholder="Nom d'utlisateur" name="login" style="margin-top: 38px;"></div>
                                        <div class="form-group"><input class="form-control form-control-user" type="password" id="InputPassword" placeholder="Mot de passe" name="password" style="margin-top: 25px;"></div>
									<button class="btn btn-primary btn-block text-white btn-user" name="login-submit" type="submit" style="margin-top: 31px;">Connexion</button></form>
                                    <div align="center" style="margin-top: 20px"><a class="nav-link" href="../index.php"> English</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
        <script type="text/javascript">
        window.addEventListener( "pageshow", function ( event ) {
            var historyTraversal = event.persisted || 
                    ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
            if ( historyTraversal ) {
                // Handle page restore.
                window.location.reload();
            }   
        });
    </script>
</body>

</html>