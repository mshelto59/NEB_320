$(document).ready(function(){
    try{
        var payStatus = document.cookie.replace(/(?:(?:^|.*;\s*)BadPaymentInfo\s*\=\s*([^;]*).*$)|^.*$/, "$1");
         if(payStatus == "true"){
             alert("Bad Payment Info");
             document.cookie = "BadPaymentInfo=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
         }
    }
    catch{
    }
});