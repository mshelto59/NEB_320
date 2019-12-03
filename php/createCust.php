<?php

require('dbConnect.php');

$fn = cleanData($_POST['fn']);
$ln = cleanData($_POST['ln']);
$cemail = cleanData($_POST['cemail']);
$cpassword = cleanData($_POST['cpassword']);

$customerLoginQuery = "Insert into customerLogin values ('". $cemail . "','" . $cpassword . "');";
$customersQuery = "Insert into customers values ('". $fn . "','" . $ln . "','" . $cemail . "');";

runQuery($customerLoginQuery);
runQuery($customersQuery);

function cleanData($data){
    return htmlspecialchars(stripslashes($data));
}

?>