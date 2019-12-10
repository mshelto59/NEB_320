function val_data(){

	var RegExpText = /^[A-Z a-z]+$/;
	var RegExpSt = /^[A-Z]{2}$/;
	var RegExpZip = /^[0-9]{5}$/;
	var RegExpStreet = /[<|>|=|$|&|#|\||\\]/;
	var RegExpEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
	var RegExpNumber = /^[2-9]\d{2}-\d{3}-\d{4}$/;
	var RegExpCardNum = /^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/;
	var RegExpCvv = /^[0-9]{3,4}$/;
	
	