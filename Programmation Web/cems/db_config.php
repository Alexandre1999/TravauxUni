<?php

//Connection variables
$dsn = "localhost";		//server name
$username = "";			//mysql username
$password = "";			//mysql password
//Database Name
$dbn = "2019_projet7_participations";				//mysql database name


$conn = new mysqli($dsn,$username,$password,$dbn);

if(mysqli_connect_error()){
    die("Connection failed".mysqli_connect_error()); //Error Checking to prevent wrong connection
}
