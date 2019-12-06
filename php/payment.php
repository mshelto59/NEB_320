<?php
require('dbConnect.php');

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

$checkPayment = $checkPaymentQuery->get_result()->num_rows;
    
$paymentQuery = $connection->prepare("Insert into paymentCard (pfn,pln,pnumber,pcvv,month,year,CIID) values (?,?,?,?,?,?,?);");

$CIID= $checkPContactResult->fetch_row()[0];

$paymentQuery->bind_param('ssiissi', $fn, $ln, $cn, $cvv, $mon, $year, $CIID);


if($checkPContact != 0 || $checkPayment != 0){
    header("Location: ../htm/payment.htm");
    setcookie("BadPaymentInfo", "true", time()+3600, '/');
}
else{
    $PContactQuery->execute();
    
    $checkPContactQuery->execute();

    $checkPContactResult = $checkPContactQuery->get_result();
    
    $CIID= $checkPContactResult->fetch_row()[0];
    $paymentQuery->execute();
    
    $fn = $_POST['fnm'];
    $ln = $_POST['lnm'];
    $sa = $_POST['sam'];
    $city = $_POST['citym'];
    $state = $_POST['statem'];
    $zip = $_POST['Acm'];
    $hp = $_POST['hpm'];
    $wp = $_POST['wpm'];
    $email = $_POST['emailm'];
    
    $PContactQuery->execute();
    
    header("Location: ../index.htm");
}