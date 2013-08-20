function getFormValue(element){
		document.getElementById('loading').style.display = 'none';
		var frameObj =(element.contentWindow || element.contentDocument);
		if (frameObj.document) frameObj=frameObj.document;
		var card_type = frameObj.getElementById("novalnetCc_cc_type");

		card_type.onchange = function ()
		{
			document.getElementById('cc_type').value = card_type.value;
		}
		var card_owner = frameObj.getElementById("novalnetCc_cc_owner");
		card_owner.onkeyup = function ()
		{
			document.getElementById('cc_owner').value = card_owner.value;
		}
		var card_exp_month = frameObj.getElementById("novalnetCc_expiration");
		card_exp_month.onchange = function ()
		{

			document.getElementById('cc_exp_month').value = card_exp_month.value;
		}
		var card_exp_year = frameObj.getElementById("novalnetCc_expiration_yr");
		card_exp_year.onchange = function ()
		{
			document.getElementById('cc_exp_year').value = card_exp_year.value;
		}
		var card_cid = frameObj.getElementById("novalnetCc_cc_cid");
		card_cid.onkeyup = function ()
		{
			document.getElementById('cc_cid').value = card_cid.value;
		}
}

window.onload = function(){

	if(document.getElementById('payment_process').value == '1'){
		var getEve = $('#checkout_xajax').parent().find('span').attr('onclick');
		var cmbine = 'checkNovalnet();'+getEve;
		$('#checkout_xajax').parent().find('span').attr('onclick', cmbine);
    } else {
		var btnSave1 = document.getElementById("checkout_payment");
		var btnPrtElement1 = btnSave1.parentNode;
		var btnPrtClick1 = btnPrtElement1.getAttribute('onsubmit');
		var addClick1 = 'checkNovalnet();';
		addClick1 = addClick1+btnPrtClick1;
		btnSave1.parentNode.setAttribute('onsubmit', addClick1);
	}
}

function checkNovalnet(){
	
	//if(document.getElementById("payment_form_novalnetCc")){
		var ifr = document.getElementById("payment_form_novalnetCc");
		var ccIframe = (ifr.contentWindow || ifr.contentDocument);
		if (ccIframe.document) ccIframe=ccIframe.document;
		if( ccIframe.getElementById("nncc_cardno_id").value != null ) {
			document.getElementById("cc_panhash").value = ccIframe.getElementById("nncc_cardno_id").value;
			document.getElementById("cc_uniqueid").value = ccIframe.getElementById("nncc_unique_id").value;
			 
			 $('#checkout_xajax').parent().append('<input type="hidden" name="cc_panhash" id="cc_panhash" value="'+document.getElementById("cc_panhash").value+'" />');
			$('#checkout_xajax').parent().append('<input type="hidden" name="cc_uniqueid" id="cc_uniqueid" value="'+document.getElementById("cc_uniqueid").value+'" />');
		}
		
		
	//}
} 
