<?php

function runQuery($query){
    $host = "mshelto.com";
    $username = "mshelto_neb_db";
    $password = "123456@champ";

    $connection = new mysqli($host, $username, $password, 'mshelto_NEB_DB');

   if ($connection -> connect_error){
        die("Connection Failed: " . $connection -> connect_error);
    }

    if($connection->query($query) === true){

    }  
    else{
        echo("DB error: " . $connection->error);
    }

    $connection->close();
}

?>