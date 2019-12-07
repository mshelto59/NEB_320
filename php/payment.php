<?php
session_start();
require('dbConnect.php');

$username = $_SESSION['username'];

$cartLen = $_COOKIE['cartLen'];

//vars from payment section of form
$fn = $_POST['fnp'];
$ln = $_POST['lnp'];
$sa = $_POST['sap'];
$city = $_POST['cityp'];
$state = $_POST['statep'];
$zip = $_POST['Acp'];
$hp = $_POST['hpp'];
$wp = $_POST['wpp'];
$email = $_POST['emailp'];
$cn = $_POST['cn'];
$mon = $_POST['espMon'];
$year = $_POST['espYear'];
$cvv = $_POST['cvv'];

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
$fn = $_POST['fnm'];
$ln = $_POST['lnm'];
$sa = $_POST['sam'];
$city = $_POST['citym'];
$state = $_POST['statem'];
$zip = $_POST['Acm'];
$hp = $_POST['hpm'];
$wp = $_POST['wpm'];
$email = $_POST['emailm'];

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
$OrderQuery->bind_param('sii', $email, $cartLen, $pid);

$OrderQuery->execute();

//insert into orderProducts
$OPQuery = $connection->prepare("Insert into orderProducts values (?,?,?);");
$OPQuery->bind_param('iii', $oid, $pid2, $qty);

//get cart cookies
$cart = json_decode($_COOKIE['cart']);

//get order id that we just created
$oid = runQuery("Select oid from orders where cemail='$email' and count='$cartLen' and pid='$pid' and CIID='$CIID' order by oid desc;")->fetch_row()[0];

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

