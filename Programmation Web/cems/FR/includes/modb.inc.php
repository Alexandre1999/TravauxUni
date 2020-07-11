<?php
//This function already exist in the includes folder in the root but i found it easier to make a duplicate for the french site that would redirect to the french pages

require '../../db_config.php';

//Function to sanitize the inserted data (Removal of whitespaces
function protect($string){
    require '../../db_config.php';
    $string = mysqli_real_escape_string($conn,trim(strip_tags(addslashes($string))));
    return $string;
}

function containsNumbers($string) {
    return preg_match('/[0-9]+/', $string) > 0;
}

function isNumber($string){
    return !(ctype_digit($string));
}

/* User */
//Php script for Adding User & modifying password
if(isset($_POST['useradd']) || isset($_POST['usermodpwd'])){

    $userid = protect($_POST['userid']);
    $userlogin = protect($_POST['userlogin']);
    $userpwd = protect($_POST['userpwd']);
    $userrepwd = protect($_POST['userrepwd']);
    $userrole = protect($_POST['userrole']);
    $hashedpwd = password_hash($userpwd,PASSWORD_DEFAULT); //Use of B-crypt algorithm

    if($hashedpwd == false){
        header("Location:../ADMIN/manage.php?error=errorhashing&userid=".$userid."&userlogin=".$userlogin."&userrole=".$userrole);
        exit();
    }

    if(isNumber($userid)){
        header("Location:../ADMIN/manage.php?error=wrnginput");
        exit();
    }

    if(isset($_POST['useradd'])){

        if(empty($userid) || empty($userlogin) || empty($userpwd) ||empty($userrepwd) ||empty($userrole)){
            header("Location:../ADMIN/manage.php?error=emptyfield&userid=".$userid."&userlogin=".$userlogin."&userrole=".$userrole);
            exit();
        }

        else if ($userpwd != $userrepwd){
            header("Location:../ADMIN/manage.php?error=pwdmatch&userid=".$userid."&userlogin=".$userlogin."&userrole=".$userrole);
            exit();
        }

        else {
            $sql = "INSERT INTO users (uid, login, mdp, role) VALUES (?, ?, ?, ?);";


            if($stmt = mysqli_prepare($conn, $sql)){
                mysqli_stmt_bind_param($stmt, "isss", $userid, $userlogin, $hashedpwd, $userrole);

                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_close($stmt);
                    header("Location:../ADMIN/manage.php?error=success");
                    exit();
                }
                else {
                    header("Location:../ADMIN/manage.php?error=failed");
                    exit();
                }
            }
            else{
                header("Location:../ADMIN/manage.php?error=couldnotprepare");
                exit();
            }
        }
    }

    //Modifying User Password script
    else if(isset($_POST['usermodpwd'])){
        //Checks if entered passwords match
        if ($userpwd != $userrepwd){
            header("Location:../ADMIN/manage.php?error=pwdmatch&userid=".$userid."&userlogin=".$userlogin."&userrole=".$userrole);
            exit();
        }

        if(isNumber($userid)){
            header("Location:../ADMIN/manage.php?error=wrnginput");
            exit();
        }

        else {
            $sql = "UPDATE users SET mdp= ? WHERE uid = ? AND login = ?;";


            if($stmt = mysqli_prepare($conn, $sql)) {

                mysqli_stmt_bind_param($stmt, "sis", $hashedpwd, $userid, $userlogin);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    header("Location:../ADMIN/manage.php?error=success");
                    exit();
                }
                else {
                    header("Location:../ADMIN/manage.php?error=failed");
                    exit();
                }
            }
            else{
                header("Location:../ADMIN/manage.php?error=couldnotprepare");
                exit();
            }
        }
    }
}


/* Person */
//Add,modify or remove person
if(isset($_POST['personadd']) || isset($_POST['personremove']) || isset($_POST['personmod'])){

    $name = protect($_POST['personname']);
    $surname = protect($_POST['personsurname']);
    $pid = protect($_POST['personid']);

    if(containsNumbers($name) || containsNumbers($surname)){
        header("Location:../ADMIN/manage.php?error=wrnginput");
        exit();
    }

    if(isNumber($pid)){
        header("Location:../ADMIN/manage.php?error=wrnginput");
        exit();
    }

    if(isset($_POST['personadd'])){

        if(empty($name) || empty($surname) || empty($pid)){
            header("Location:../ADMIN/manage.php?error=emptyfield&personname=".$name."&personsurname=".$surname."&personid=".$pid);
            exit();
        }

        else {
            $sql = "INSERT INTO personnes (pid, nom, prenom) VALUES (?, ?, ?);";

            if($stmt = mysqli_prepare($conn, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "iss", $pid, $surname, $name);

                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_close($stmt);
                    header("Location:../ADMIN/manage.php?error=success");
                    exit();
                }
                else {
                    header("Location:../ADMIN/manage.php?error=failed");
                    exit();
                }
            }
            else{
                header("Location:../ADMIN/manage.php?error=couldnotprepare");
                exit();
            }
        }
    }

    //Php script to remove person
    else if(isset($_POST['personremove'])){

        if(empty($name) || empty($surname) || empty($pid)){
            header("Location:../ADMIN/manage.php?error=emptyfield&personname=".$name."&personsurname=".$surname."&personid=".$pid);
            exit();
        }

        else {
            $sql = "DELETE FROM personnes WHERE personnes.pid = ?";

            if($stmt = mysqli_prepare($conn, $sql)) {

                mysqli_stmt_bind_param($stmt, "i", $pid);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    header("Location:../ADMIN/manage.php?error=success");
                    exit();
                } else {
                    header("Location:../ADMIN/manage.php?error=failed");
                    exit();
                }
            }
            else{
                header("Location:../ADMIN/manage.php?error=couldnotprepare");
                exit();
            }
        }
    }

    //Php script to modify person fields
    else if(isset($_POST['personmod'])){

        if(empty($name) || empty($surname) || empty($pid)){
            header("Location:../ADMIN/manage.php?error=emptyfield&personname=".$name."&personsurname=".$surname."&personid=".$pid);
            exit();
        }

        else {

            $newpid = $_POST['personnewid'];

            if(isNumber($newpid)){
                header("Location:../ADMIN/manage.php?error=wrnginput");
                exit();
            }

            $sql = "UPDATE personnes SET pid = ?, nom = ?, prenom = ? WHERE personnes.pid = ?";

            if($stmt = mysqli_prepare($conn, $sql)) {

                mysqli_stmt_bind_param($stmt, "issi", $newpid, $surname, $name, $pid);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    header("Location:../ADMIN/manage.php?error=success");
                    exit();
                } else {
                    header("Location:../ADMIN/manage.php?error=failed");
                    exit();
                }
            }
            else{
                header("Location:../ADMIN/manage.php?error=couldnotprepare");
                exit();
            }
        }
    }
}





/* Person ID*/
//Php script to Add,modify or remove Person ID
if(isset($_POST['personidadd']) || isset($_POST['personidremove']) || isset($_POST['personidmod'])){

    $tid = $_POST['persontid'];
    $idvalue = $_POST['personidvalue'];
    $pid = $_POST['personid'];
    $idvalue = mysqli_real_escape_string($conn,$idvalue);

    if(isNumber($tid) || isNumber($pid)){
        header("Location:../ADMIN/manage.php?error=wrnginput");
        exit();
    }

    if(isset($_POST['personidadd'])){

        if(empty($idvalue) || empty($tid) || empty($pid)){
            header("Location:../ADMIN/manage.php?error=emptyfield&personid=".$pid."&persontid=".$tid."&personidvalue=".$idvalue);
            exit();
        }

        //Php script to Add Person ID
        else {
            $sql = "INSERT INTO identifications (pid, tid, valeur) VALUES (?, ?, ?);";

            if($stmt = mysqli_prepare($conn, $sql)){

                mysqli_stmt_bind_param($stmt, "iis", $pid, $tid, $idvalue);

                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_close($stmt);
                    header("Location:../ADMIN/manage.php?error=success");
                    exit();
                }
                else {
                    header("Location:../ADMIN/manage.php?error=failed");
                    exit();
                }
            }
            else{
                header("Location:../ADMIN/manage.php?error=couldnotprepare");
                exit();
            }
        }
    }

    //Php script to remove Person ID
    else if(isset($_POST['personidremove'])){

        if(empty($tid) || empty($pid)){
            header("Location:../ADMIN/manage.php?error=emptyfield&persontid=".$tid."&personid=".$pid);
            exit();
        }

        else {
            $sql = "DELETE FROM identifications WHERE pid = ? AND tid = ?";

            if($stmt = mysqli_prepare($conn, $sql)) {

                mysqli_stmt_bind_param($stmt, "ii", $pid, $tid);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    header("Location:../ADMIN/manage.php?error=success");
                    exit();
                } else {
                    header("Location:../ADMIN/manage.php?error=failed");
                    exit();
                }
            }
            else{
                header("Location:../ADMIN/manage.php?error=couldnotprepare");
                exit();
            }
        }
    }

    //Php script to modify Person ID, The pid is used to identify the tid and change the value of the id
    else if(isset($_POST['personidmod'])){

        if(empty($idvalue) || empty($tid) || empty($pid)){
            header("Location:../ADMIN/manage.php?error=emptyfield&personid=".$pid."&persontid=".$tid."&personidvalue=".$idvalue);
            exit();
        }

        else {

            $sql = "UPDATE identifications SET valeur = ? WHERE identifications.pid = ? AND tid = ?";

            if($stmt = mysqli_prepare($conn, $sql)) {

                mysqli_stmt_bind_param($stmt, "sii", $idvalue, $pid, $tid);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    header("Location:../ADMIN/manage.php?error=success");
                    exit();
                } else {
                    header("Location:../ADMIN/manage.php?error=failed");
                    exit();
                }
            }
            else{
                header("Location:../ADMIN/manage.php?error=couldnotprepare");
                exit();
            }
        }
    }
}






/*ID Type*/
//Php script to Add,modify or remove ID Type
if(isset($_POST['itypeadd']) || isset($_POST['itypedelete']) || isset($_POST['itypemodify'])) {

    $tid = $_POST['itypetid'];
    $idvalue = $_POST['itypevalue'];
    $idvalue = mysqli_real_escape_string($conn, $idvalue);

    if(isNumber($tid)){
        header("Location:../ADMIN/manage.php?error=wrnginput");
        exit();
    }

    if (isset($_POST['itypeadd'])) {

        if (empty($idvalue) || empty($tid)) {
            header("Location:../ADMIN/manage.php?error=emptyfield&itypetid=" . $tid ."&itypevalue=" . $idvalue);
            exit();
        }

        //Add ID Type
        else {
            $sql = "INSERT INTO itypes (tid, nom) VALUES (?, ?);";

            if ($stmt = mysqli_prepare($conn, $sql)) {

                mysqli_stmt_bind_param($stmt, "is", $tid, $idvalue);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    header("Location:../ADMIN/manage.php?error=success");
                    exit();
                } else {
                    header("Location:../ADMIN/manage.php?error=failed");
                    exit();
                }
            } else {
                header("Location:../ADMIN/manage.php?error=couldnotprepare");
                exit();
            }
        }
    }

    //Remove ID Type
    else if (isset($_POST['itypedelete'])) {

        if (empty($tid)) {
            header("Location:../ADMIN/manage.php?error=emptyfield");
            exit();
        } else {
            $sql = "DELETE FROM itypes WHERE tid = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {

                mysqli_stmt_bind_param($stmt, "i", $tid);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    header("Location:../ADMIN/manage.php?error=success");
                    exit();
                } else {
                    header("Location:../ADMIN/manage.php?error=failed");
                    exit();
                }
            } else {
                header("Location:../ADMIN/manage.php?error=couldnotprepare");
                exit();
            }
        }
    }


    //Modify ID Type
    else if (isset($_POST['itypemodify'])) {

        if (empty($tid) || empty($idvalue)) {
            header("Location:../ADMIN/manage.php?error=emptyfield&itypetid=" . $tid . "&itypevalue=" . $idvalue);
            exit();
        } else {

            $sql = "UPDATE itypes SET nom = ? WHERE tid = ?";


            if ($stmt = mysqli_prepare($conn, $sql)) {

                mysqli_stmt_bind_param($stmt, "si", $idvalue,  $tid);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    header("Location:../ADMIN/manage.php?error=success");
                    exit();
                } else {
                    header("Location:../ADMIN/manage.php?error=failed");
                    exit();
                }
            } else {
                header("Location:../ADMIN/manage.php?error=couldnotprepare");
                exit();
            }
        }
    }
}




/*Event*/
//Script to Add,modify or remove Event
if(isset($_POST['eventadd']) || isset($_POST['eventremove']) || isset($_POST['eventmodify'])) {

    $eventeid = $_POST['eventeid'];
    $eventremeid = $_POST['eventremeid'];
    $eventname = $_POST['eventname'];
    $eventdesc = $_POST['eventdescription'];
    $eventsdate = $_POST['eventsdate'];
    $eventedate = $_POST['eventedate'];
    $eventtype = $_POST['eventtype'];
    $cid = $_POST['eventcid'];

    if(isNumber($cid) || isNumber($eventeid)){
        header("Location:../ADMIN/manage.php?error=wrnginput");
        exit();
    }

    //Add Event
    if (isset($_POST['eventadd'])) {

        if (empty($eventeid) || empty($eventname) || empty($eventdesc) || empty($eventtype) || empty($cid) || empty($eventsdate) || empty($eventedate)) {
            header("Location:../ADMIN/manage.php?error=emptyfield&eid=" . $eventeid ."&eventname=" . $eventname."&eventdescription=" . $eventdesc."&eventsdate=" . $eventsdate."&eventedate=" . $eventedate."&eventtype=" . $eventtype."&cid=" . $cid);
            exit();
        }

        //Add ID Type
        else {
            $sql = "INSERT INTO evenements (eid, intitule, description, dateDebut, dateFin, `type`, cid) VALUES (?, ?, ?, ?, ?, ?, ?);";


            if ($stmt = mysqli_prepare($conn, $sql)) {

                mysqli_stmt_bind_param($stmt, "isssssi", $eventeid, $eventname, $eventdesc, $eventsdate, $eventedate, $eventtype, $cid);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    header("Location:../ADMIN/manage.php?error=success");
                    exit();
                } else {
                    header("Location:../ADMIN/manage.php?error=failed");
                    exit();
                }
            } else {
                header("Location:../ADMIN/manage.php?error=couldnotprepare");
                exit();
            }
        }
    }

    //Remove Event
    else if (isset($_POST['eventremove'])) {

        if (empty($eventremeid)) {
            header("Location:../ADMIN/manage.php?error=emptyfield");
            exit();
        }

        if(isNumber($eventremeid)){
            header("Location:../ADMIN/manage.php?error=wrnginput");
            exit();
        }

        else {
            $sql = "DELETE FROM evenements WHERE eid = ?";


            if ($stmt = mysqli_prepare($conn, $sql)) {

                mysqli_stmt_bind_param($stmt, "i", $eventremeid);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    header("Location:../ADMIN/manage.php?error=success");
                    exit();
                } else {
                    header("Location:../ADMIN/manage.php?error=failed");
                    exit();
                }
            } else {
                header("Location:../ADMIN/manage.php?error=couldnotprepare");
                exit();
            }
        }
    }

    //Modify Event
    else if (isset($_POST['eventmodify'])) {

        if (empty($eventeid) || empty($eventname) || empty($eventdesc) || empty($eventtype) || empty($cid) || empty($eventsdate) || empty($eventedate)) {
            header("Location:../ADMIN/manage.php?error=emptyfield");
            exit();
        } else {

            $sql = "UPDATE evenements SET intitule=?, description=?, dateDebut=?, dateFin=?, `type`=?, cid=? WHERE eid = ?";


            if ($stmt = mysqli_prepare($conn, $sql)) {

                mysqli_stmt_bind_param($stmt, "sssssii", $eventname,  $eventdesc, $eventsdate, $eventedate, $eventtype, $cid, $eventeid);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    header("Location:../ADMIN/manage.php?error=success");
                    exit();
                } else {
                    header("Location:../ADMIN/manage.php?error=failed");
                    exit();
                }
            } else {
                header("Location:../ADMIN/manage.php?error=couldnotprepare");
                exit();
            }
        }
    }
}

else{
    header("Location:../ADMIN/manage.php?error=illegalaccess");
    exit();
}

