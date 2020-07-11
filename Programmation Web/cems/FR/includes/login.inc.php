<?php

//A trial to solve the problem of pressing the back button to go back to the login page
session_start();
if(isset($_SESSION['login'])){
    require '../../db_config.php';

    $uid = $_SESSION['uid'];
    $roleresult = mysqli_query($conn, "SELECT role FROM users WHERE uid = $uid");
    $rolearray = mysqli_fetch_array($roleresult);

    if($rolearray['role'] == 'admin'){
        header("Location:../ADMIN/index.php");
        exit();
    }

    if($rolearray['role'] == 'user'){
        header("Location:../USER/index.php");
        exit();
    }

}


//Main block of code that makes the php login page works
if(isset($_POST['login-submit'])) {

    require '../../db_config.php';

    $login = $_POST['login'];
    $password = $_POST['password'];

    if (empty($login) || empty($password)) {
        header("Location:../index.php?error=emptyfields&login=.$login");
        exit();
    } else {

        $sql = "SELECT * FROM users WHERE login=?;";

        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:../index.php?error=sqlerror");
            exit();
        } else {

            mysqli_stmt_bind_param($stmt, "s", $login);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            //Use of B-Crypt algorithm for password verification
            if ($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($password, $row['mdp']);

                if ($pwdCheck == false) {
                    header("Location:../index.php?error=wrongpwd");
                    exit();
                }

                else if ($pwdCheck == true) {
                    if ($row['role'] == "admin") {
                        session_start();
                        $_SESSION["uid"] = $row['uid'];
                        $_SESSION["login"] = $login;
                        $_SESSION["isAuth"] = true;
                        header("Location:../ADMIN/index.php?login=success");
                        exit();
                    }

                    else {
                        session_start();
                        $_SESSION["login"] = $login;
                        $_SESSION["uid"] = $row['uid'];
                        $_SESSION["isAuth"] = true;
                        header("Location:../USER/index.php?login=success");
                        exit();
                    }
                }

                else {
                    header("Location:../index.php?error=wrongpwd");
                }
            }

            else {
                header("Location:../index.php?error=nouser");
                exit();
            }
        }
    }
}
else {
    header ("Location:../index.php?error=illegalsignin");
    exit();
}