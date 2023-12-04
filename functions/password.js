function formsubmiting(keyvalue)
{  
	var form = $('#submitpwdform');
	var error = $('#form-error');
	var field = $('#password');
	if(!field.val()){error.html(errormessage("Enter the New Password")); return false; field.focus(); }
	var field = $('#confirmpwd');
	if(!field.val()){error.html(errormessage("Re-Enter the New Password"));  return false; field.focus();}
	if($('#password').val() != $('#confirmpwd').val())
	{
		error.html(errormessage("New and confirm passwords does not match.")); return false; field.focus();
	}
	else
	{
		var passData  = "switchtype=retrivepwd&password=" + encodeURIComponent($('#password').val())  + "&confirmpwd=" + encodeURIComponent($('#confirmpwd').val()) + "&key=" + encodeURIComponent(keyvalue) + "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
		var queryString = "../ajax/password.php"; 
		ajaxobjext11 = $.ajax(
		{
			type: "POST",url: queryString, data: passData, cache: false,
			success: function(ajaxresponse,status)
			{	
				if(ajaxresponse == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else
				{
					var responetext = ajaxresponse.split('^');//alert(response)
					if(responetext[0] == 1)
					{
						$('#form-error').html(successmessage(responetext[1]));
						$('#submitpwdform')[0].reset();
					}
					else if(responetext[0] == 2)
					{
						$('#form-error').html(errormessage(responetext[1]));
						$('#submitpwdform')[0].reset();
					}
					else
					{
						$('#form-error').html(errormessage("Response unknown."));
					}
				}
			}, 
			error: function(a,b)
			{
				$('#form-error').html(scripterror());
			}
		});	
	}
}

