<?php

require('dbConnect.php');
    
$action = $_GET['action'];
switch($action){
    case('signup'):
        $fn = validateData(cleanData($_POST['fn']), 'text');
        $ln = validateData(cleanData($_POST['ln']), 'text');
        $cemail = validateData(cleanData($_POST['cemail']), 'email');
        $cpassword = password_hash(cleanData($_POST['cpassword']), PASSWORD_DEFAULT);
        
        $customerLoginQuery = "Insert into customerLogin values ('". $cemail . "','" . $cpassword . "');";
        $customersQuery = "Insert into customers values ('". $fn . "','" . $ln . "','" . $cemail . "');";

        runQuery($customerLoginQuery);
        runQuery($customersQuery);
        echo($cpassword);
        header("Location: ../htm/payment.htm");
        break;
        
    case('login'):
        $cemail = validateData(cleanData($_POST['cemail']));
        $cpassword = validateData(cleanData($_POST['cpassword']));
        
        $checkPasswordQuery = "Select cpassword from customerLogin where cemail = '" . $cemail . "';";
        $realPassword = runQuery($checkPasswordQuery)->fetch_assoc()['cpassword'];
        echo($realPassword);
        if(password_verify($cpassword, $realPassword) == true){            
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

function validateData($data, $dataType){
    $output = "";
    
    $emailREGEX = '/^[A-Za-z0-9]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    $textREGEX = '/^[A-Za-z]*$/';
    
    switch($dataType){
        case('email'):
            if (preg_match($emailREGEX, $data)){
                return $data;
            }
            else{
                badData();                
            }
            break;
        case('text'):
            if(preg_match($textREGEX, $data)){
                return $data;
            }
            else{
                badData();                
            }
            break;
    }
}

function badData(){
    setcookie("BadDataVal", "true", time()+3600, '/');
    header("Location: ../htm/login.htm");
}

?>