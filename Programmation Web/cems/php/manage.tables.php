<?php //Helper that fills the tables for the manage page

require '../db_config.php';
//Fetch data to fill tables for table page
$sql = "SELECT `uid`,`login`,`role` FROM `users` ORDER BY `uid`;";

$result1 = mysqli_query($conn,$sql);

$sql = "SELECT `pid`,`nom`,`prenom` FROM `personnes` ORDER BY `pid`;";

$result2 = mysqli_query($conn,$sql);

$sql = "SELECT personnes.pid,personnes.nom as pnom,personnes.prenom,identifications.tid,itypes.nom,identifications.valeur FROM identifications,personnes,itypes WHERE itypes.tid=identifications.tid AND identifications.pid=personnes.pid;";

$result5 = mysqli_query($conn,$sql);

$sql = "SELECT `tid`,`nom` FROM `itypes` ORDER BY `tid`;";

$result3 = mysqli_query($conn,$sql);

$sql = "SELECT `eid`,`intitule`,`description`,`dateDebut`,`dateFin`,`type`,`cid` FROM `evenements` ORDER BY `eid`;";

$result4 = mysqli_query($conn,$sql);