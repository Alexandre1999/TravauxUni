<?php 

session_start();

if ($_SESSION["isAuth"]==false){
    header("Location:../index.php?error=notAuth");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Manage - CEMS</title>
    <meta name="description" content="CEMS Stands for common event management system and is devised so as to manage events as">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="../assets/css/Pretty-Search-Form.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/jquery.datetimepicker.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
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
                    <li class="nav-item" role="presentation"><a class="nav-link" href="index.php"><i class="fas fa-address-card"></i><span>Dashboard</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="../ADMIN/manage.php"><i class="fas fa-list-ul"></i><span>Manage</span></a></li>
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
                                        class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu"><a class="dropdown-item" role="presentation" href="../FR/ADMIN/manage.php"><i class="fas fa-language fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Français</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" role="presentation" href="../includes/logout.inc.php" name="dropdown-logout"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a></div>
                    </div>
                    </li>
                    </ul>
            </div>
            </nav>
            <div class="container-fluid">
                <h3 class="text-dark mb-4">Manage</h3>

                <?php
                //Error Message Handler
                if(isset($_GET['error'])){
                    if($_GET["error"] == "errorhashing"){
                        echo '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Warning!</strong> Password ERRR.</div>';
                    }
                    else if($_GET["error"] == "illegalaccess"){
                        echo '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Warning!</strong> Fill the correct form</div>';
                    }

                    else if($_GET["error"] == "emptyfield"){
                        echo '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Warning!</strong> Fill in all the fields</div>';
                    }

                    else if($_GET["error"] == "wrnginput"){
                        echo '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Warning!</strong> Insert valid information</div>';
                    }

                    else if($_GET["error"] == "pwdmatch"){
                        echo '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Warning!</strong> Passwords does not match</div>';
                    }

                    else if($_GET["error"] == "couldnotprepare"){
                        echo '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Warning!</strong> Incorrect data filled in</div>';
                    }

                    else if($_GET["error"] == "success"){
                        echo '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Success!</strong> DB Modified</div>';
                    }

                    else if($_GET["error"] == "failed"){
                        echo '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Warning!</strong> Cannot add</div>';
                    }
                }
                ?>

                <div role="tablist" id="accordion-1">
                    <div class="card">
                        <div class="card-header" role="tab">
                            <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="true" aria-controls="accordion-1 .item-1" href="#accordion-1 .item-1">Users</a></h5>
                        </div>
                        <div class="collapse item-1" role="tabpanel" data-parent="#accordion-1">
                            <div class="card-body">
                                <a href="#" data-toggle="popover" title="Manage Users" data-content="To add users fill in all the fields for the add section and press on add. To modify password fill in all the fields in modify password section and press modify password.">Help</a>


                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Login</th>
                                                <th>Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         <?php include'../php/manage.tables.php';?>

                                        <?php if(mysqli_num_rows($result1) > 0) {
                                            while ($row = mysqli_fetch_array($result1)) {
                                                ?>

                                                <tr>
                                                    <td><?php echo $row["uid"];?></td>
                                                    <td><?php echo $row["login"];?></td>
                                                    <td><?php echo $row["role"];?></td>
                                                </tr>

                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <form action="../includes/modb.inc.php" method="post">
                                        <div class="border rounded shadow" style="padding: 20px;">
                                            <input name="userid" type="text" style="margin-right: 20px;margin-bottom: 20px;" placeholder="Enter ID">
                                            <input name="userlogin" type="text" placeholder="Enter Login" style="margin-right: 20px;margin-top: 0px;margin-bottom: 17px;">
                                            <input name="userpwd" type="password" placeholder="Enter Password" style="margin-right: 20px;margin-bottom: 20px;">
                                            <input name="userrepwd" type="password" placeholder="Re-enter Password" style="margin-right: 20px;margin-bottom: 20px;">
                                            <select name="userrole" style="margin-right: 20px;"><optgroup label="Select role"><option value="admin" selected="">Admin</option><option value="user">User</option></optgroup></select>
                                            <button name="useradd" class="btn btn-primary btn-sm" type="submit" style="margin: 19px;margin-left: 0px;margin-bottom: 0px;margin-top: 0px;">Add</button></div>
                                    </form>
                                </div>

                                <div class="form-group">
                                    <form action="../includes/modb.inc.php" method="post">
                                        <div class="border rounded shadow" style="margin-top: 45px;padding: 10px;"><input name="userid" type="text" style="margin-right: 20px;margin-bottom: 20px;" placeholder="Enter ID"><input name="userlogin" type="text" style="margin-right: 20px;margin-bottom: 0px;" placeholder="Enter Login"><input name="userpwd" type="password" style="margin-right: 20px;margin-bottom: 0px;" placeholder="Enter New Password"><input name="userrepwd" type="password" style="margin-right: 20px;margin-bottom: 0px;"
                                                placeholder="Re-Enter New Password"><button name="usermodpwd" class="btn btn-primary btn-sm" type="submit" style="margin-top: 0px;">Modify Password</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" role="tab">
                            <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-1 .item-2" href="#accordion-1 .item-2">Person</a></h5>
                        </div>
                        <div class="collapse item-2" role="tabpanel" data-parent="#accordion-1">
                            <div class="card-body">
                                <a href="#" data-toggle="popover" title="Manage Person" data-content="To add a person Fill in his name, surname and a unique ID and press ADD. To remove a person fill in name, surname and ID and press on remove. To modify a user enter his ID and Fill in all the fields with the desired new values.">Help</a>
                                    <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Surname</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                        <?php if(mysqli_num_rows($result2) > 0) {
                                            while ($row = mysqli_fetch_array($result2)) {
                                                ?>

                                                <tr>
                                                    <td><?php echo $row["pid"];?></td>
                                                    <td><?php echo $row["prenom"];?></td>
                                                    <td><?php echo $row["nom"];?></td>
                                                </tr>

                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                </div>
                                <div class="form-group">
                                    <form action="../includes/modb.inc.php" method="post">
                                        <div class="border rounded shadow" style="margin-top: 10px;padding: 10px;margin-bottom: 20px;">
                                            <input name="personname" type="text" placeholder="Enter Name" pattern="[A-Za-z\s\'-ßàáâãäåæçèéêëìíîïðñòóôõöøùúûüý]" required style="margin-right: 20px;margin-top: 0px;margin-bottom: 20px;width: 190px;">
                                            <input name="personsurname" type="text" placeholder="Enter Surname" pattern="[A-Za-z\s\'-ßàáâãäåæçèéêëìíîïðñòóôõöøùúûüý]" required style="margin-right: 20px;margin-bottom: 0px;width: 190px;">
                                            <input name="personid" type="text" placeholder="Enter ID" style="margin-right: 20px;width: 190px;">
                                            <input name="personnewid" type="text" placeholder="Enter New ID" style="margin-right: 20px;width: 190px;">
                                            <button name="personadd" class="btn btn-primary btn-sm" type="submit" style="margin: 19px;margin-left: 0px;margin-bottom: 0px;margin-top: 0px;margin-right: 20px;">Add</button>
                                            <button name="personmod" class="btn btn-primary btn-sm" type="submit" style="margin-top: 0px;margin-right: 20px;">Modify</button>
                                            <button name="personremove" class="btn btn-primary btn-sm" type="submit" style="margin-top: 0px;margin-right: 20px;">Remove</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" role="tab">
                            <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="true" aria-controls="accordion-1 .item-3" href="#accordion-1 .item-3">Person ID</a></h5>
                        </div>
                        <div class="collapse item-3" role="tabpanel" data-parent="#accordion-1">
                            <div class="card-body">
                                <a href="#" data-toggle="popover" title="Manage Person ID" data-content="To add a new ID for a person fill in the pid of the desired person, the tid of the ID and it's value. To remove an ID fill in the pid, tid and press remove. To modify an ID fill in the pid, tid and fill in the new ID value.">Help</a>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Person ID</th>
                                            <th>Name</th>
                                            <th>Surname</th>
                                            <th>TID</th>
                                            <th>ID Type</th>
                                            <th>ID</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php if(mysqli_num_rows($result5) > 0) {
                                            while ($row = mysqli_fetch_array($result5)) {
                                                ?>

                                                <tr>
                                                    <td><?php echo $row["pid"];?></td>
                                                    <td><?php echo $row["prenom"];?></td>
                                                    <td><?php echo $row["pnom"];?></td>
                                                    <td><?php echo $row["tid"];?></td>
                                                    <td><?php echo $row["nom"];?></td>
                                                    <td><?php echo $row["valeur"];?></td>

                                                </tr>

                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                </div>
                                <div class="form-group">
                                    <div class="border rounded shadow" style="margin-top: 10px;padding: 10px;margin-bottom: 20px;">
                                        <form action="../includes/modb.inc.php" method="post">
                                            <input name="personid" type="text" placeholder="Enter Person ID" style="margin-right: 20px;width: 190px;">
                                            <input name="persontid" type="text" placeholder="Enter TID" style="margin-right: 20px;margin-top: 0px;margin-bottom: 20px;width: 190px;">
                                            <input name="personidvalue" type="text" placeholder="Enter new ID" style="margin-right: 20px;margin-bottom: 0px;width: 190px;">
                                            <button name="personidadd" class="btn btn-primary btn-sm" type="submit" style="margin: 19px;margin-left: 0px;margin-bottom: 0px;margin-top: 0px;margin-right: 20px;">Add</button>
                                            <button name="personidmod" class="btn btn-primary btn-sm" type="submit" style="margin-top: 0px;margin-right: 20px;">Modify</button>
                                            <button name="personidremove" class="btn btn-primary btn-sm" type="submit" style="margin-top: 0px;margin-right: 20px;">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header" role="tab">
                            <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-1 .item-4" href="#accordion-1 .item-4">ID Types</a></h5>
                        </div>
                        <div class="collapse item-4" role="tabpanel" data-parent="#accordion-1">
                            <div class="card-body">
                                <a href="#" data-toggle="popover" title="Manage ID Types" data-content="To add an ID Type choose a unique tid and Enter the new ID Type name. To remove an ID Type, enter its tid. To modify an ID Type enter its tid and the new ID value.">Help</a>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                        <?php if(mysqli_num_rows($result3) > 0) {
                                            while ($row = mysqli_fetch_array($result3)) {
                                                ?>

                                                <tr>
                                                    <td><?php echo $row["tid"];?></td>
                                                    <td><?php echo $row["nom"];?></td>
                                                </tr>

                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <div class="border rounded shadow" style="padding: 10px;">
                                        <form action="../includes/modb.inc.php" method="post">
                                            <input name="itypetid" type="text" placeholder="Enter ID" style="margin-right: 20px;margin-top: 0px;margin-bottom: 0px;">
                                            <input name="itypevalue" type="text" placeholder="Enter ID Name" pattern="[A-Za-z\s\'-ßàáâãäåæçèéêëìíîïðñòóôõöøùúûüý]" style="margin-right: 20px;">
                                            <button name="itypeadd" class="btn btn-primary btn-sm" type="submit" style="margin: 19px;margin-left: 0px;margin-bottom: 0px;margin-top: 0px;">Add</button>
                                            <button name="itypedelete" class="btn btn-primary btn-sm" type="submit" style="margin-top: 0px;margin-right: 20px;">Remove</button>
                                            <button name="itypemodify" class="btn btn-primary btn-sm" type="submit" style="margin-top: 0px;">Modify</button>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" role="tab">
                            <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-1 .item-5" href="#accordion-1 .item-5">Events</a></h5>
                        </div>
                        <div class="collapse item-5" role="tabpanel" data-parent="#accordion-1">
                            <div class="card-body">
                                <a href="#" data-toggle="popover" title="Manage Events" data-content="To add an event fill all the fields and select the type of event to add. To modify an event fill in the event's eid and fill all the fields with the new information. To remove an event enter it's eid on the remove section.">Help</a>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Event ID</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Start</th>
                                                <th>End</th>
                                                <th>Type</th>
                                                <th>CID</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php if(mysqli_num_rows($result4) > 0) {
                                            while ($row = mysqli_fetch_array($result4)) {
                                                ?>

                                                <tr>
                                                    <td><?php echo $row["eid"];?></td>
                                                    <td><?php echo $row["intitule"];?></td>
                                                    <td><?php echo $row["description"];?></td>
                                                    <td><?php echo $row["dateDebut"];?></td>
                                                    <td><?php echo $row["dateFin"];?></td>
                                                    <td><?php echo $row["type"];?></td>
                                                    <td><?php echo $row["cid"];?></td>
                                                </tr>

                                                <?php
                                            }
                                        }

                                        mysqli_close($conn);
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <form action="../includes/modb.inc.php" method="post">

                                        <div class="border rounded shadow" style="padding: 28px;">
                                            <p style="margin-bottom: 15px;margin-top: 0px;"></p>
                                            <div class="form-row">
                                                <div class="col-auto"><input name="eventeid" type="text" placeholder="EID" style="margin-right: 10px;margin-top: 0px;margin-bottom: 17px;padding: 0px; width: 40px"></div>
                                                <div class="col-auto"><input name="eventname" type="text" placeholder="Nom" style="margin-right: 10px;margin-bottom: 20px;"></div>
                                                <div class="col-auto"><input name="eventdescription" type="text" placeholder="Description" style="margin-right: 10px;margin-bottom: 20px;"></div>
                                                <div class="col-auto"><input class="form-control" id="picker" name="eventsdate" type="text" placeholder="Date début" style="margin-right: 10px;"></div>
                                                <div class="col-auto"><input class="form-control" id="picker2" name="eventedate" type="text" placeholder="Date fin" style="margin-right: 10px;"></div>
                                                <div class="col-auto"><select name="eventtype" style="margin-right: 20px;"><optgroup label="Selectionner le type d'événement"><option value="ouvert" selected="">Ouvert</option><option value="ferme">Fermé</option></optgroup></select></div>
                                                <div class="col-auto"><select name="eventcid" style="margin-right: 20px;"><optgroup label="Selectionner le type événement"><option value="1" selected="">Examen</option><option value="2">Cour</option><option value="3" selected="">TP</option></optgroup></select></div>
                                                <div class="col-auto"><button name="eventadd" class="btn btn-primary btn-sm" type="submit" style="margin: 19px;margin-left: 0px;margin-bottom: 0px;margin-top: 10px;">Add</button></div>
                                                <div class="col-auto"><button name="eventmodify" class="btn btn-primary btn-sm" type="submit" style="margin: 19px;margin-left: 0px;margin-bottom: 0px;margin-top: 10px;">Modify</button></div>
                                            </div>
                                        </div>

                                        <div class="border rounded shadow" style="margin-top: 30px;padding: 10px;">
                                            <input name="eventremeid" type="text" style="margin-right: 20px;margin-bottom: 0px;" placeholder="Enter EID">
                                            <button name="eventremove" class="btn btn-primary btn-sm" type="submit" style="margin-top: 0px;">Remove</button>
                                        </div>
                                </form>
                            </div>
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
    <script src="../assets/js/jquery.datetimepicker.full.min.js"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
        });
    </script>
    <script>
        $('#picker').datetimepicker({
            timepicker: true,
            datepicker: true,
            format: 'Y-m-d H:i:s',
            hours12: false,
            step:1,
            yearStart: 2015
        })
    </script>
    <script>
        $('#picker2').datetimepicker({
            timepicker: true,
            datepicker: true,
            format: 'Y-m-d H:i:s',
            hours12: false,
            step:1,
            yearStart: 2015
        })
    </script>
    </div>

</body>

</html>