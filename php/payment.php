<?php
session_start();
require('dbConnect.php');

$username = $_SESSION['username'];

$cartLen = $_COOKIE['cartLen'];

//vars from payment section of form
$fn = valData(cleanData($_POST['fnp']), "text");
$ln = valData(cleanData($_POST['lnp']), "text");
$sa = valData(cleanData($_POST['sap']), "numText");
$city = valData(cleanData($_POST['cityp']), "text");
$state = valData(cleanData($_POST['statep']), "st");
$zip = valData(cleanData($_POST['Acp']), "zip");
$hp = valData(cleanData($_POST['hpp']), "phone");
$wp = valData(cleanData($_POST['wpp']), "phone");
$cn = valData(cleanData($_POST['cn']), "card");
$mon = valData(cleanData($_POST['espMon']), "month");
$year = valData(cleanData($_POST['espYear']), "year");
$cvv = valData(cleanData($_POST['cvv']), "cvv");

//prepare sql statements and gather data to see if info is already in database.    
$checkPContactQuery = $connection->prepare("Select CIID from ContactInfo where street=? and city= ? and st= ? and zip= ? and HomePhone= ? and WorkPhone=?;");
$checkPContactQuery->bind_param("sssiii", $sa, $city, $state, $zip, $hp, $wp);

$checkPContactQuery->execute();
$checkPContactResult = $checkPContactQuery->get_result();
$checkPContact = $checkPContactResult->num_rows;

$PContactQuery = $connection->prepare("Insert into ContactInfo (street,city,st,zip,HomePhone,WorkPhone) values(?,?,?,?,?,?);");
$PContactQuery->bind_param('ssssii', $sa, $city, $state, $zip, $hp, $wp);

$checkPaymentQuery = $connection->prepare("Select pid from paymentCard where pfn=? and pln=? and pnumber=? and pcvv=? and month=? and year=?;");
$checkPaymentQuery->bind_param('ssiiss', $fn, $ln, $cn, $cvv, $mon, $year);
$checkPaymentQuery->execute();

$checkPaymentResult = $checkPaymentQuery->get_result();
$checkPayment = $checkPaymentResult->num_rows;
    
$paymentQuery = $connection->prepare("Insert into paymentCard (pfn,pln,pnumber,pcvv,month,year,CIID) values (?,?,?,?,?,?,?);");
$paymentQuery->bind_param('ssiissi', $fn, $ln, $cn, $cvv, $mon, $year, $CIID);

//if data is already in database get IDs and continue
if($checkPContact > 0 && $checkPayment > 0){
    $CIID = $checkPContactResult->fetch_row()[0];
    $pid = $checkPaymentResult->fetch_row()[0];
}
//if data for ContactInfo is not in db (but payment might be) insert it and then get the CIID.
else if ($checkPContact ==0){
    $PContactQuery->execute();
    
    $checkPContactQuery->execute();

    $checkPContactResult = $checkPContactQuery->get_result();
    $checkPContact = $checkPContactResult->num_rows;
    
    $CIID= $checkPContactResult->fetch_row()[0];
}
// if payment is not in db (contact info might be) insert if and then get the Pid
if($checkPayment == 0){
    //insert payment info using CIID for payment address
    $paymentQuery->execute();
    $checkPaymentQuery->execute();
    $checkPaymentResult = $checkPaymentQuery->get_result();
    
    $pid = $checkPaymentResult->fetch_row()[0];
}
//data for mailing address from form
$fn = valData(cleanData($_POST['fnm']), "text");
$ln = valData(cleanData($_POST['lnm']), "text");
$sa = valData(cleanData($_POST['sam']), "numText");
$city = valData(cleanData($_POST['citym']), "text");
$state = valData(cleanData($_POST['statem']), "st");
$zip = valData(cleanData($_POST['Acm']), "zip");
$hp = valData(cleanData($_POST['hpm']), "phone");
$wp = valData(cleanData($_POST['wpm']), "phone");

$checkPContactQuery->execute();
$checkPContactResult = $checkPContactQuery->get_result();
$checkPContact = $checkPContactResult->num_rows;

//if contact info is alreay in DB get the CCID.
if($checkPContact > 0){    
    $CIID = $checkPContactResult->fetch_row()[0];

}
//if it is not in the DB, insert it
else{
    $PContactQuery->execute();
    $checkPContactQuery->execute();

    $checkPContactResult = $checkPContactQuery->get_result();
    $CIID = $checkPContactResult->fetch_row()[0];
}


//insert order using mailing CIID and payment pid
$OrderQuery = $connection->prepare("Insert into orders (cemail, date, count, pid, CIID) values (?,now(), ?, ?, $CIID);");
$OrderQuery->bind_param('sii', $username, $cartLen, $pid);

$OrderQuery->execute();

//insert into orderProducts
$OPQuery = $connection->prepare("Insert into orderProducts values (?,?,?);");
$OPQuery->bind_param('iii', $oid, $pid2, $qty);

//get cart cookies
$cart = json_decode($_COOKIE['cart']);

//get order id that we just created
$oid = runQuery("Select oid from orders where cemail='$username' and count='$cartLen' and pid='$pid' and CIID='$CIID' order by oid desc;")->fetch_row()[0];

//get info for table and insert info into orderProducts
for($i=0; $i< count($cart); $i++){
    $pname=$cart[$i][0];
    $pprice = $cart[$i][1];
    $pid2 = runQuery("Select pid from products where pname='$pname' and pprice='".substr($pprice,1) ."';")->fetch_row()[0];
    $qty = $cart[$i][2];        
    $OPQuery->execute();
    echo($OPQuery->error);
}

//redirect into completed page
header("Location: ../htm/completed.htm.php");

function cleanData($input){
    $output = htmlspecialchars(stripslashes($input));
    return $output;
}

function valData($input, $dataType){
    $output = "";
    
    $textREGEX = '/^[A-Za-z ]*$/';
    $numTextREGEX = '/^[A-Za-z0-9 ]*$/';
    $stREGEX = '/^(CT|ME|MA|NH|RI)$/';
    $phoneREGEX = '/^[0-9]{10}$/';
    $cardREGEX = '/^[0-9]{16}$/';
    $monthREGEX = '/^[1-9]|1[0-2]$/';
    $yearREGEX = '/^[1-2][0-9]$/';
    $cvvREGEX = '/^[0-9]*$/';
    $zipREGEX = '/^[0-9]{5}$/';
    
    switch($dataType){
        case "text":
             if (preg_match($textREGEX, $input)){
                return $input;
            }
            else{
                badData();                
            }
        break;
            
        case "numText":
            if (preg_match($numTextREGEX, $input)){
                return $input;
            }
            else{
                badData();                
            }
        break;
            
        case "st":
            if (preg_match($stREGEX, $input)){
                return $input;
            }
            else{
              badData();                
            }
        break;
            
        case "phone":
            if (preg_match($phoneREGEX, $input)){
                return $input;
            }
            else{
              badData();                
            }
        break;
            
        case "card":
            if (preg_match($cardREGEX, $input)){
                return $input;
            }
            else{
               badData();                
            }
        break;
            
        case "month":
            if (preg_match($monthREGEX, $input)){
                return $input;
            }
            else{
               badData();                
            }
        break;
        
        case "year":
            if (preg_match($yearREGEX, $input)){
                return $input;
            }
            else{
                echo($input);
                badData();                
            }
        break;
            
        case "cvv":
            if (preg_match($cvvREGEX, $input)){
                return $input;
            }
            else{
               badData();                
            }
        break;
            
        case "zip":
            if (preg_match($zipREGEX, $input)){
                return $input;
            }
            else{
              badData();                
            }
        break;
    }
    
    
}

function badData(){
    setcookie("BadPaymentInfo" , "true", time()+3600, '/');
    header("Location: ../htm/payment.htm.php");
}

?>