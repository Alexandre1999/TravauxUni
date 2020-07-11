<?php

require '../db_config.php';

//Fill in USER/index.php page table
$sql = ("SELECT eid, intitule, dateDebut, `type` FROM evenements");

$myresult = mysqli_query($conn,$sql);


