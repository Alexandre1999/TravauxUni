<?php
//Logout php script to make the logout button work

session_start();
session_unset();
session_destroy();

header("Location: ../index.php");