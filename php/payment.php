<?php
require('dbConnect.php');

$checkPContactQuery = "Select 'CIID' from ContactInfo where street='" . $_POST['sap']. "' and city='" . $_POST['cityp'] . "' and st= '" . $_POST['statep'] . "' and zip='" . $_POST['Acp'] . "' and HomePhone='" . $_POST['hpp'] . "' and WorkPhone='" . $_POST['wpp'] ."';";

$checkPContact = countRows($checkPContactQuery);

$PContactQuery = "Insert into ContactInfo (street,city,st,zip,HomePhone,WorkPhone) values('" . $_POST['sap'] ."','". $_POST['cityp'] . "','" . $_POST['statep'] . "','" . $_POST['Acp'] . "','" . $_POST['hpp'] . "','" . $_POST['wpp'] . "')";

$checkPaymentQuery = "Select 'pid' from paymentCard where pfn='" . $_POST['fnp'] . "' and pln = '" . $_POST['lnp'] . "' and pnumber = '" . $_POST['cn'] . "' and pcvv= '" . $_POST['cvv'] . "' and month = '" . $_POST['espMon'] . "' and year='" . $_POST['espYear'] . "';";

$checkPayment = countRows($checkPaymentQuery);
    
$paymentQuery = "Insert into paymentCard (pfn,pln,pnumber,pcvv,month,year,CIID) values ('" . $_POST['fnp'] . "','"  . $_POST['lnp'] . "'," . $_POST['cn'] . "," . $_POST['cvv'] . ",'" . $_POST['espMon'] . "','" . $_POST['espYear']. "','" . runQuery($checkPContactQuery)->fetch_assoc() . "')";

if($checkPContact > 0 || $checkPayment > 0){
    echo("bad payment info");
    setcookie("BadPaymentInfo", "true", time()+3600, '/');
}
else{
   // echo($paymentQuery);
    runQuery($PContactQuery);
    runQuery($paymentQuery);
}