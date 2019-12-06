<?php

function runQuery($query){
    $host = "mshelto.com";
    $username = "mshelto_neb_db";
    $password = "123456@champ";

    $connection = new mysqli($host, $username, $password, 'mshelto_NEB_DB');

   if ($connection -> connect_error){
        die("Connection Failed: " . $connection -> connect_error);
    }

    $result = $connection->query($query);
    if(!$result){
        echo($connection->error);
    }
    else{
        return $result;
    }
    $connection->close();


}

function countRows($query){
    $result = runQuery($query);
    $output = $result->num_rows;
    return $output;
}

?>