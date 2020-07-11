<?php

require '../db_config.php';

//Fetch data for dashboard table
$sql = "SELECT DISTINCT `nom`,`prenom`,`intitule`,`dateDebut` FROM `personnes`,`participations`,`evenements` WHERE personnes.pid = participations.pid AND participations.eid = evenements.eid ORDER BY dateDebut;";

$myresult = mysqli_query($conn,$sql);

