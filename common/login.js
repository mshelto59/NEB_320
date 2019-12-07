try{
    var passStatus = document.cookie.replace(/(?:(?:^|.*;\s*)BadPass\s*\=\s*([^;]*).*$)|^.*$/, "$1");
     if(passStatus == "true"){
         alert("Wrong Password");
         document.cookie = "BadPass=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
     }
 }
catch{
}
    
try{
    var valStatus = document.cookie.replace(/(?:(?:^|.*;\s*)BadDataVal\s*\=\s*([^;]*).*$)|^.*$/, "$1");
    if (valStatus == "true"){
        alert("Data Validation Failed");
        document.cookie = "BadDataVal=; exipires= Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    }
}
catch{
}