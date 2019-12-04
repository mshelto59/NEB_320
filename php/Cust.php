<?php

require('dbConnect.php');
    
$action = $_GET['action'];
switch($action){
    case('signup'):
        $fn = cleanData($_POST['fn']);
        $ln = cleanData($_POST['ln']);
        $cemail = cleanData($_POST['cemail']);
        $cpassword = cleanData($_POST['cpassword']);

        $customerLoginQuery = "Insert into customerLogin values ('". $cemail . "','" . $cpassword . "');";
        $customersQuery = "Insert into customers values ('". $fn . "','" . $ln . "','" . $cemail . "');";

        runQuery($customerLoginQuery);
        runQuery($customersQuery);

        header("Location: ../htm/payment.htm");
        break;
        
    case('login'):
        $cemail = cleanData($_POST['cemail']);
        $cpassword = cleanData($_POST['cpassword']);
        
        $checkPasswordQuery = "Select cpassword from customerLogin where cemail = '" . $cemail . "';";
        $realPassword = runQuery($checkPasswordQuery)->fetch_assoc()['cpassword'];
        echo($cpassword . $realPassword);
        if($cpassword == $realPassword){
            header("Location: ../htm/payment.htm");
        }
        else{
            setcookie("BadPass", "true", time()+3600, '/');
           header("Location: ../htm/login.htm");
        }
        break;
}

function cleanData($data){
    return htmlspecialchars(stripslashes($data));
}
        

?>