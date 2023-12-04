function validation()
{ 
	var form = $('#submitform');
	var error =$('#form-error');
	var field = $("#dealerusername");
	if(!field.val())
	{error.html(errormessage("Dealer Username cannot be blank. Please enter a valid Dealer Username provided by Relyon.")); field.focus();  return false;}
	else
	{
		var passData  = "switchtype=dealerusername&dealerusername=" + encodeURIComponent($('#dealerusername').val()) + "&dummy=" + Math.floor(Math.random()*100000000);  
		queryString = "../ajax/retrivepwd.php";
		ajaxobjext1 = $.ajax(
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
					var responetext = ajaxresponse.split('^');//alert(responetext)
					if(responetext[0] == 1)
					{
						error.html('');
						$('#emailresult').html(responetext[1]);
						$('#dealerid').val(responetext[2]);
						$('#tabc1').hide();
						$('#tabc2').show();
						$('#displayselecteddealerid').html(field.val());
						disablenext();
					}
					else
					{
						error.html('');
						error.html(errormessage(responetext[1]));
						enablenext();
					}
				}
			}, 
			error: function(a,b)
			{
				error.html(scripterror());
			}
		});	
	}
}


function formsubmiting(dealerid)
{
	var form = $('#submitform'); 
	var error = $('#form-error1');
	var emailresult = $('#email');
	var dealerid = $("#dealerid");
	var field = $('#email');
	if(!field.val()){error.html(errormessage("Select the Email ID")); field.focus();  return false;}
	else
	{
		var passData  = "switchtype=sendemail&emailresult=" + encodeURIComponent($('#email').val())+ "&dealerid=" + encodeURIComponent($("#dealerid").val()) + "&dummy=" + Math.floor(Math.random()*100000000); //alert(passData)
		disablesend();
		error.html('');
		$('#dealerprocess').html(getprocessingimage());
		var queryString = "../ajax/retrivepwd.php";
		ajaxobjext12 = $.ajax(
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
					var response = ajaxresponse.split('^');//alert(ajaxresponse)
					if(response[0] == 1)
					{
						error.html('');
						$('#dealerprocess').html('');
						$('#tabc2').hide();
						$('#tabc3').show();
						$('#form-error2').html(displaysuccessmessage(response[1]));
					}
					else if(response[0] == 2)
						window.location = "http://imax.relyonsoft.com/implementation/index.php";
					else
						$('#form-error2').html(errormessage("Response unknown."));
					}
			}, 
			error: function(a,b)
			{
				$('#form-error2').html(scripterror());
			}
		});	
	}
}

function validateusername(username)
{
	for (var i = 0 ; i < username.length ; i++)
	{
		var searchThis = username.indexOf(" ", i);
		if (searchThis < 0)
		{
			return true;
			break;
		}
		else
		{
			return false;
		}
	}
}