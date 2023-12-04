// JavaScript Document
function formsubmit(userid)
{
	var form = document.submitform; 
	var error = document.getElementById('form-error');
		var field = form.address;
	var field = form.state;
	if(!field.value){error.innerHTML = errormessage("Select the state");  return false; field.focus();}
	var field = form.district;
	if(!field.value){error.innerHTML =errormessage("Select the District"); return false; field.focus();}
	var field = form.pincode;
	if(!field.value){error.innerHTML =errormessage("Enter the Pincode"); return false; field.focus();}
	if(field.value) { if(!validatepincode(field.value)) { error.innerHTML = errormessage('Enter the valid PIN Code.'); field.focus(); return false; } }
	var field = form.emailid;
	if(!field.value){error.innerHTML ="Enter the Email Id"; }
	if(field.value)	{ if(!emailvalidation(field.value)) { error.innerHTML = errormessage('Enter the valid Email ID.'); field.focus(); return false; } }
	var field = form.personalemailid;
	if(field.value)	{ if(!emailvalidation(field.value)) { error.innerHTML = errormessage('Enter the valid Email ID.'); field.focus(); return false; } }
	var field = form.stdcode;
	//if(!field.value){error.innerHTML = errormessage("Enter the STD code"); return false; field.focus();}
	if(field.value) { if(!validatestdcode(field.value)) { error.innerHTML = 'Enter the valid STD Code.'; field.focus(); return false; } }
	var field = form.phone;
	if(!field.value){error.innerHTML = errormessage("Enter the Phone Number"); return false; field.focus();}
	if(field.value) { if(!validatephone(field.value)) { error.innerHTML = 'Enter the valid Phone Number.'; field.focus(); return false; } }
	var field = form.cell;
	if(!field.value){error.innerHTML = errormessage("Enter the Cell number"); return false; field.focus();}
	if(field.value) { if(!validatecell(field.value)) { error.innerHTML = errormessage('Enter the valid Cell Number.'); field.focus(); return false; } }
	var field = form.place;
	if(!field.value){error.innerHTML = errormessage("Enter the Place"); return false; field.focus();}
	var field = form.agreetoupdate;
	if(field.checked == true) var disablelogin = 'yes'; else disablelogin = 'no';
	if(disablelogin == 'yes')
	{
		var passData = '';
		passData = "switchtype=save&address=" + encodeURIComponent(form.address.value) + "&place=" + encodeURIComponent(form.place.value) + "&state=" + encodeURIComponent(form.state.value) + "&district=" + encodeURIComponent(form.district.value) + "&pincode=" + encodeURIComponent(form.pincode.value)  + "&stdcode=" + encodeURIComponent(form.stdcode.value) + "&phone=" + encodeURIComponent(form.phone.value) + "&cell=" + encodeURIComponent(form.cell.value) + "&emailid=" + encodeURIComponent(form.emailid.value) +"&personalemailid=" + encodeURIComponent(form.personalemailid.value) +"&userid=" + encodeURIComponent(userid);
		//alert(passData);
		ajaxcall0 = createajax();//alert(passData);
		error.innerHTML = getprocessingimage();
		var queryString = "../ajax/updateprofile.php";
		ajaxcall0.open("POST", queryString, true);
		ajaxcall0.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxcall0.onreadystatechange = function()
		{
			if(ajaxcall0.readyState == 4)
			{
				var response = ajaxcall0.responseText;
				if(response == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else
				{
					var ajaxresponse = response.split('^');
					if(ajaxresponse[0] == 1)
					{
						error.innerHTML = successmessage(ajaxresponse[1]);
					}
					else
					{
						error.innerHTML = errormessage('Unable to Connect');
					}
				}
			}
		}
		ajaxcall0.send(passData);
	}
	else
		error.innerHTML = errormessage('If you want to Update your profile, please confirm the checkbox.');
}



function getdealerdetails(dealerid)
{
	//alert('dealerid');
	var form = document.submitform; 
	var error = document.getElementById('form-error');
	var passData = '';
	passData = "switchtype=getdealerdetails&dealerid=" + encodeURIComponent(dealerid);
	ajaxcall1 = createajax();//alert(passData);
	var queryString = "../ajax/updateprofile.php";
	ajaxcall1.open("POST", queryString, true);
	ajaxcall1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall1.onreadystatechange = function()
	{
		if(ajaxcall1.readyState == 4)
		{
			var ajaxresponse = ajaxcall1.responseText; //alert(ajaxresponse)
			if(ajaxresponse == 'Thinking to redirect')
			{
				window.location = "../logout.php";
				return false;
			}
			var response = ajaxresponse.split('^');
			document.getElementById('contactperson').innerHTML = response[0];
			form.address.value = response[1];
			form.place.value = response[2];
			form.state.value = response[3];
			districtcodeFunction('district',response[4]);
			form.pincode.value = response[5];
			document.getElementById('region').innerHTML = response[6];
			form.stdcode.value = response[7];
			form.phone.value = response[8];
			form.cell.value = response[9];
			form.emailid.value = response[10];
			document.getElementById('website').innerHTML = response[11];
			document.getElementById('createddate').innerHTML = response[12];
			document.getElementById('businessname').innerHTML = response[13];
			form.personalemailid.value = response[15];
		}
	}
	ajaxcall1.send(passData);
	}
	
function validate(dealerid)
{ 
	var form = document.submitform; 
	var passData  = "switchtype=undo&dealerid=" + encodeURIComponent(dealerid) + "&dummy=" + Math.floor(Math.random()*100000000); 
	ajaxcall2 = createajax();
	var queryString = "../ajax/updateprofile.php";
	ajaxcall2.open("POST", queryString, true); 
	ajaxcall2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall2.onreadystatechange = function()
	{
		if(ajaxcall2.readyState == 4)
		{
			var ajaxresponse = ajaxcall2.responseText; 
			if(ajaxresponse == 'Thinking to redirect')
			{
				window.location = "../logout.php";
				return false;
			}
			else
			{
				var response = ajaxresponse.split('^');
				form.contactperson.value = response[0];
				form.address.value = response[1];
				form.place.value = response[2];
				form.state.value = response[3];
				districtcodeFunction('district',response[4]);
				form.pincode.value = response[5];
				form.region.value = response[6];
				form.stdcode.value = response[7];
				form.phone.value = response[8];
				form.cell.value = response[9];
				form.emailid.value = response[10];
				form.website.value = response[11];
				document.getElementById('createddate').innerHTML = response[12];
				form.businessname.value = response[13];
				form.personalemailid.value = response[14];
			}
		//	document.getElementById('cancelmeg').innerHTML = '';
		}
	}
	ajaxcall2.send(passData);
}



