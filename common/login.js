/*$('.form').find('input, textarea').on('keyup blur focus', function (e) {
  
  var $this = $(this),
      label = $this.prev('label');

	  if (e.type === 'keyup') {
			if ($this.val() === '') {
          label.removeClass('active highlight');
        } else {
          label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
    	if( $this.val() === '' ) {
    		label.removeClass('active highlight'); 
			} else {
		    label.removeClass('highlight');   
			}   
    } else if (e.type === 'focus') {
      
      if( $this.val() === '' ) {
    		label.removeClass('highlight'); 
			} 
      else if( $this.val() !== '' ) {
		    label.addClass('highlight');
			}
    }

});

$('.tab a').on('click', function (e) {
  
  e.preventDefault();
  
  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');
  
  target = $(this).attr('href');

  $('.tab-content > div').not(target).hide();
  
  $(target).fadeIn(600);
  
});
*/
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