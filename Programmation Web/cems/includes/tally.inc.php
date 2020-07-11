<?php
session_start();

require '../db_config.php';



function protect($string){
    require '../db_config.php';
    $string = mysqli_real_escape_string($conn,trim(strip_tags(addslashes($string))));
    return $string;
}

function containsNumbers($string) {
    return preg_match('/[0-9]+/', $string) > 0;
}


//Add person to personnes and add the pid to the given event
if(isset($_POST['personadd'])) {

    $eid = $_POST['usereid'];
    $name = $_POST['username'];
    $surname = $_POST['usersurname'];
    $itype = $_POST['usertid'];
    $idval = $_POST['useridval'];
    $uid = $_SESSION["uid"];

    if(containsNumbers($name) || containsNumbers($surname)){
        header("Location:../USER/index.php?error=wrnginput");
        exit();
    }

    if (empty($name) || empty($surname) || empty($itype) || empty($idval))
    {
        header("Location:../USER/index.php?error=emptyfield");
        exit();
    }
    else{
        //Using the name and surname provided to create the new person as a User don't havve to know the id we let the DB assign an ID automatically
        $stmt = $conn->prepare("INSERT INTO `personnes` (`pid`, `nom`, `prenom`) VALUES (NULL, ?, ?)");
        $stmt->bind_param("ss", $name,$surname);
        $stmt->execute();

        //Fetch pid from the person just added to personnes, to take into account duplicates i'm taking the greatest pid taking into account the DB auto-increment on the pid
        $stmt = $conn->prepare("SELECT MAX(pid) AS pid FROM personnes WHERE nom = ? AND prenom = ?");
        $stmt->bind_param("ss", $name,$surname);
        $stmt->execute();
        $result = $stmt->get_result();

        if(mysqli_num_rows($result)>0)
        {
            $row = mysqli_fetch_array($result);
            $pid = $row['pid'];
        }

        $stmt = $conn->prepare("SELECT tid FROM itypes WHERE nom=?");
        $stmt->bind_param("s", $itype);
        $stmt->execute();
        $result = $stmt->get_result();

        if(mysqli_num_rows($result)>0)
        {
            $row = mysqli_fetch_array($result);
            $tid = $row['tid'];
        }

        //Checks if tid and pid was fetched correctly
        if (empty($idval) || empty($pid) || empty($tid) || empty($eid) || empty($uid))
        {
            header("Location:../USER/index.php?error=emptyfield");
            exit();
        }

        else {
            //Adding id to identifications
            $stmt = $conn->prepare("INSERT INTO `identifications` (`pid`, `tid`, `valeur`) VALUES (?,?,?)");
            $stmt->bind_param("iis", $pid,$tid, $idval);
            $stmt->execute();

            //Add person to inscriptions, logical imo if a user is adding a person he must be wanting it in the event he is making the attendance for
            $stmt = $conn->prepare("INSERT INTO `inscriptions` (`pid`, `eid`, `uid`) VALUES (?,?,?)");
            $stmt->bind_param("iii", $pid,$eid, $uid);
            $stmt->execute();
            $result = $stmt->get_result();

            if(!$result){
                header("Location:../USER/index.php?error=success");
                exit();
            }
            else{
                header("Location:../USER/index.php?error=failed");
                exit();
            }
        }
    }
}



//Php script to make the Attendance(Pointage)
if(isset($_POST['present'])) {

    $eid = $_POST['usereid'];
    $date = $_POST['userdate'];
    $uid = $_SESSION["uid"];

    if (empty($eid) || empty($date) || empty($uid))
    {
        header("Location:../USER/index.php?error=emptyfield");
        exit();
    }

    else if(empty($_POST['pid'])){
        header("Location:../USER/index.php?error=emptyfield");
        exit();
    }

    else{

        $stmt = $conn->prepare("INSERT INTO `participations` (`ptid`, `eid`, `pid`, `date`, `uid`) VALUES (NULL,?,?,?,?)");

        //Using checkboxes that stores the pid of each selected persons in an array that is then accessed and queried one by one into the DB
        foreach($_POST['pid'] as $pid) {
            $stmt->bind_param("iisi", $eid, $pid, $date, $uid);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        if(!$result) {
            header("Location:../USER/index.php?error=success");
            exit();
        }
        else{
            header("Location:../USER/index.php?error=failed");
            exit();
        }
    }
}