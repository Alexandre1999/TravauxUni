<?php


function protect($string){
    require '../../db_config.php';
    $string = mysqli_real_escape_string($conn,trim(strip_tags(addslashes($string))));
    return $string;
}

//Search the db for a name,surname or event name for people registered
if(isset($_POST['db-search'])){

    require '../../db_config.php';

    if(empty($_POST['select']) || empty($_POST['search'])){
        header("Location:../ADMIN/index.php?error=emptysearch");
        exit();
    }

    else if($_POST['select'] == "nom"){
        $select = $_POST['select'];
        $search = protect($_POST['search']);

        $stmt1 = $conn->prepare("SELECT DISTINCT `pid`,`intitule`,`dateDebut` FROM (SELECT `participations`.`pid`,`nom`,`prenom`,`intitule`,`dateDebut` FROM `personnes`,`participations`,`evenements` WHERE personnes.pid = participations.pid AND participations.eid = evenements.eid) AS T WHERE `nom` = ? ORDER BY dateDebut");
        $stmt2 = $conn->prepare("SELECT `pid`,`intitule`, `dateDebut` FROM (SELECT `personnes`.`pid`,`nom`,`prenom`,`intitule`,`dateDebut` FROM `personnes`,`evenements`,(SELECT `pid`,`eid` FROM `inscriptions` WHERE NOT EXISTS (SELECT `pid`,`eid` FROM `participations` WHERE participations.pid = inscriptions.pid AND participations.eid = inscriptions.eid)) AS I WHERE I.pid = personnes.pid AND I.eid = evenements.eid) AS TT WHERE `nom` = ? ORDER BY dateDebut");

        $stmt1->bind_param("s",$search);
        $stmt2->bind_param("s",$search);

        $stmt1->execute();
        $result1 = $stmt1->get_result();

        $stmt2->execute();
        $result2 = $stmt2->get_result();

        require '../ADMIN/table.php';

    }
    else if($_POST['select'] == "prenom"){
        $select = $_POST['select'];
        $search = protect($_POST['search']);

        $sql1 = "SELECT DISTINCT `pid`,`intitule`,`dateDebut` FROM (SELECT `participations`.`pid`,`nom`,`prenom`,`intitule`,`dateDebut` FROM `personnes`,`participations`,`evenements` WHERE personnes.pid = participations.pid AND participations.eid = evenements.eid) AS T WHERE `prenom` = ? ORDER BY dateDebut;";
        $sql2 = "SELECT `pid`,`intitule`, `dateDebut` FROM (SELECT `personnes`.`pid`,`nom`,`prenom`,`intitule`,`dateDebut` FROM `personnes`,`evenements`,(SELECT `pid`,`eid` FROM `inscriptions` WHERE NOT EXISTS (SELECT `pid`,`eid` FROM `participations` WHERE participations.pid = inscriptions.pid AND participations.eid = inscriptions.eid)) AS I WHERE I.pid = personnes.pid AND I.eid = evenements.eid) AS TT WHERE `prenom` = ? ORDER BY dateDebut;";


        $stmt1 = $conn->prepare($sql1);
        $stmt2 = $conn->prepare($sql2);

        $stmt1->bind_param("s",$search);
        $stmt2->bind_param("s",$search);

        $stmt1->execute();
        $result1 = $stmt1->get_result();

        $stmt2->execute();
        $result2 = $stmt2->get_result();

        require '../ADMIN/table.php';

    }
    else if($_POST['select']=="intitule"){
        $select = $_POST['select'];
        $search = $_POST['search'];

        $sql1 = "SELECT `nom`,`prenom` FROM (SELECT `nom`,`prenom`,`intitule`,`dateDebut` FROM `personnes`,`participations`,`evenements` WHERE personnes.pid = participations.pid AND participations.eid = evenements.eid) AS T WHERE `intitule` = ? ORDER BY dateDebut;";
        $sql2 = "SELECT `nom`,`prenom` FROM (SELECT `nom`,`prenom`,`intitule`,`dateDebut` FROM `personnes`,`evenements`,(SELECT `pid`,`eid` FROM `inscriptions` WHERE NOT EXISTS (SELECT `pid`,`eid` FROM `participations` WHERE participations.pid = inscriptions.pid AND participations.eid = inscriptions.eid)) AS I WHERE I.pid = personnes.pid AND I.eid = evenements.eid) AS TT WHERE `intitule` = ? ORDER BY dateDebut;";


        $stmt1 = $conn->prepare($sql1);
        $stmt2 = $conn->prepare($sql2);

        $stmt1->bind_param("s",$search);
        $stmt2->bind_param("s",$search);

        $stmt1->execute();
        $result1 = $stmt1->get_result();

        $stmt2->execute();
        $result2 = $stmt2->get_result();

        require '../ADMIN/table.php';

    }
}
else{
    header("Location: ../ADMIN/index.php?error=illegal access");
    exit();
}