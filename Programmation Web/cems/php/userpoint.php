<?php

require '../db_config.php';

function protect($string){
    require '../db_config.php';
    $string = mysqli_real_escape_string($conn,trim(strip_tags(addslashes($string))));
    return $string;
}

//Fetch data for attendance page, redirects to point or pointouvert depending on the type of event (open or close)
if(isset($_POST['usereventsearch'])) {

    if(!empty($_POST['usereid'])){

        $eid = $_POST['usereid'];

        $stmt = $conn->prepare("SELECT personnes.pid, personnes.nom, personnes.prenom, itypes.nom AS inom, identifications.valeur FROM personnes, itypes, identifications, inscriptions WHERE eid=? AND inscriptions.pid = personnes.pid AND personnes.pid = identifications.pid AND identifications.tid = itypes.tid");
        $stmt2 = $conn->prepare("SELECT intitule, `type` FROM evenements WHERE eid = ?");

        $stmt->bind_param("i", $eid);
        $stmt2->bind_param("i", $eid);

        $stmt->execute();
        $result = $stmt->get_result();

        $stmt2->execute();
        $inti = $stmt2->get_result();

        if (mysqli_num_rows($inti) > 0) {
            $row2 = mysqli_fetch_array($inti);

            if ($row2["type"] == "ferme") {
                require '../USER/point.php';
            }

            else {
                require '../USER/pointouvert.php';
            }
        }
        else{
            header("Location:../USER/index.php?error=wrongval");
            exit();
        }
    }
    else{
        header("Location:../USER/index.php?error=emptyfield");
        exit();
    }
}
else{
    header("Location:../USER/index.php?error=illegalaccess");
    exit();
}