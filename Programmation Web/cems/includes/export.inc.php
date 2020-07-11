<?php

if(isset($_POST["export"])){

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=table-export.csv');
    $output = fopen("php://output", "w");
    $myarray = array();
    fputcsv($output, $myarray);

    //Insert prepared statement there
    


    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result))
    {
        fputcsv($output, $row);
    }
    fclose($output);
}