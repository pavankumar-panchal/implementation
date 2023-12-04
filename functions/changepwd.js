function validating(userid)
{  
	var form = document.submitform; 
	var error = document.getElementById('form-error');
	var field = form.oldpassword;
	if(!field.value){error.innerHTML =errormessage("Enter the Password"); return false; field.focus(); }
	var field = form.newpassword;
	if(!field.value){error.innerHTML = errormessage("Enter the New Password");  return false; field.focus();}
	var field = form.confirmpassword;
	if(!field.value){error.innerHTML =errormessage("Re-Enter the New Password"); return false; field.focus();}
	else
	{
	//alert('test1')
	var passData  = "switchtype=change&oldpassword=" + encodeURIComponent(form.oldpassword.value)  + "&newpassword=" + encodeURIComponent(form.newpassword.value) + "&confirmpassword=" + encodeURIComponent(form.confirmpassword.value) + "&userid=" + encodeURIComponent(userid) + "&dummy=" + Math.floor(Math.random()*100000000);
	ajaxcall0 = createajax();
	error.innerHTML = getprocessingimage();
	var queryString = "../ajax/changepwd.php"; 
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
				var responetext=response.split('^');//alert(responetext)
				if(responetext[0] == 1)
				{
					document.getElementById('form-error').innerHTML = successmessage(responetext[1]);
				}
				else 
				{
					document.getElementById('form-error').innerHTML = errormessage(responetext[1]);
				}
			}
		}
	}
	ajaxcall0.send(passData);
	}
}

