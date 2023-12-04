//Define customer Array
var customerarray = new Array();

//get the customer details to an array
function refreshcustomerarray()
{
	var passData = "switchtype=generatecustomerlist&dummy=" + Math.floor(Math.random()*10054300000);
	var ajaxcall2 = createajax();
	document.getElementById('customerselectionprocess').innerHTML = getprocessingimage();
	queryString = "../ajax/customization.php";
	ajaxcall2.open("POST", queryString, true);
	ajaxcall2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall2.onreadystatechange = function()
	{
		if(ajaxcall2.readyState == 4)
		{
			if(ajaxcall2.status == 200)
			{
				var response = ajaxcall2.responseText.split('^*^');
				if(response == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else
				{
					customerarray = new Array();
					for( var i=0; i<response.length; i++)
					{
						customerarray[i] = response[i];
					}
					getcustomerlist1();
					document.getElementById('customerselectionprocess').innerHTML = '';
					document.getElementById('totalcount').innerHTML = customerarray.length;
				}
			}
			else
				document.getElementById('customerselectionprocess').innerHTML = scripterror();
		}
	}
	ajaxcall2.send(passData);
}

function getcustomerlist1()
{	
	disableformelemnts();
	var form = document.submitform;
	//document.getElementById('customerselectionprocess').innerHTML = '';
	var selectbox = document.getElementById('customerlist');
	var numberofcustomers = customerarray.length;
	document.filterform.detailsearchtext.focus();
	var actuallimit = 500;
	var limitlist = (numberofcustomers > actuallimit)?actuallimit:numberofcustomers;

	selectbox.options.length = 0;

	for( var i=0; i<limitlist; i++)
	{
		var splits = customerarray[i].split("^");
		selectbox.options[selectbox.length] = new Option(splits[0], splits[1]);
	}
	
}
//New form entry
function newentry()
{
	var form = document.submitform;
	form.impreflastslno.value = '';
	form.impcustomizationlastslno.value = '';
	form.reset();

}

//Customer implementation details to form
function customerdetailstoform(slno)
{
	if(slno != '')
	{
		var form = $('#submitform');
		$('#lastslno').val(slno);
		var error = $('#loadingdiv');
		error.html('');
		var passData = "switchtype=gridtoform&lastslno=" + encodeURIComponent(slno)  + "&dummy=" + Math.floor(Math.random()*100032680100);
		error.html(getprocessingimage());
		ajaxcall3 = createajax();
		var queryString = "../ajax/customization.php";
		ajaxcall3.open("POST", queryString, true);
		ajaxcall3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxcall3.onreadystatechange = function()
		{
			if(ajaxcall3.readyState == 4)
			{
				if(ajaxcall3.status == 200)
				{
					error.html('');
					var ajaxresponse = ajaxcall3.responseText;
					if(ajaxresponse == 'Thinking to redirect')
					{
						window.location = "../logout.php";
						return false;
					}
					else
					var response = ajaxresponse.split('^');
					if(response[0] == '1')
					{
						implemenationstatus(response[1]);
						$('#implastslno').val(response[1]);
						$('#invoicedetails').html(response[3]);
						$('#collectedamt').html(response[4]);
						if(response[4] == 'NO')
						{
							$('#paymentamt').html('Not Available');
							$('#paymentremarks').html('Not Available');
							$('#balancerecovery').html('Not Available');
						}
						else
						{
							$('#paymentamt').html(response[5]);
							$('#paymentremarks').html(response[6]);
							$('#balancerecovery').html(response[7]);
						}
						$('#attachement_raffilename').html(response[8]);
						$('#podate').html(response[9]);
						if(response[44] != '')
						{
							var filename9 = response[44].split('/');
							$('#pouploadlink_filename').html(filename9[5]);
							$('#pouploadlink_errorfile').html('<a href=\''+ response[44] +'\' class = "r-text" style="text-decoration:none"> View &rsaquo;&rsaquo;</a>');
						}
						else
						{
							$('#pouploadlink_filename').html('Not Available');
							$('#pouploadlink_errorfile').html('');
						}
						$('#sales_company').html(response[10]);
						$('#sales_tomonths').html(response[11]);
						$('#sales_frommonth').html(response[12]);
						$('#sales_training').html(response[13]);
						$('#sales_commitdate').html(response[43]);
						$('#sales_deliver').html(response[14]);
						$('#sales_scheme').html(response[15]);
						
						if(response[21] == 'NO')
						{
							$('#sales_noofemployee').html('Not Available');
							$('#sales_remarks').html('Not Available');
						}
						else
						{
							$('#sales_noofemployee').html(response[22]);
							$('#sales_remarks').html(response[23]);
						}
						$('#sales_masterdata').html(response[21]);
						$('#attendance').html(response[24]);
						if(response[24] == 'NO')
						{
							$('#attendance_vendor').html('Not Available');
						}
						else
						{
							$('#attendance_vendor').html(response[25]);
						}
						if(response[26] == '')
						{
							$('#attendance_errorfilename').html('Not Available');
							$('#attendance_errorfile').html('');

						}
						else
						{
							var filename3 = response[26].split('/');
							$('#attendance_errorfilename').html(filename3[5]);
							$('#attendance_errorfile').html('<a href=\''+ response[26] +'\' class = "r-text" style="text-decoration:none"> View &rsaquo;&rsaquo;</a>');
						}
						if(response[27] == 'NO')
						{
							$('#shipment_remarks').html('Not Available');

						}
						else
						{
							$('#shipment_remarks').html(response[28]);
						}
						$('#shipment_invoice').html(response[27]);
						$('#shipment_manual').html(response[29]);
						if(response[29] == 'NO')
						{
							$('#manual_remarks').html('Not Available');
						}
						else
						{
							$('#manual_remarks').html(response[30]);
						}
						$('#customization').html(response[31]);
						if(response[31] == 'NO')
						{
							$('#customization_remarks').html('Not Available');
							$('#customizationdiv').hide();

						}
						else
						{
							$('#customization_remarks').html(response[32]);
							$('#customizationdiv').show();

						}
						if(response[33] == '')
						{
							$('#customization_referencesfilename').html('Not Available');
							$('#customization_references').html('');
						}
						else
						{
							var filename1 = response[33].split('/');
							$('#customization_referencesfilename').html(filename1[5]);
							$('#customization_references').html('<a href=\''+ response[33] +'\' class = "r-text" style="text-decoration:none"> View &rsaquo;&rsaquo; </a>');
						}
						if(response[34] == '')
						{
							$('#customization_sppdatafilename').html('Not Available');
							$('#customization_sppdata').html('');
						}
						else
						{
							var filename2 = response[34].split('/');
							$('#customization_sppdatafilename').html(filename2[5]);
							$('#customization_sppdata').html('<a href=\''+ response[34] +'\' class = "r-text" style="text-decoration:none"> View &rsaquo;&rsaquo; </a>');
						}
						$('#customizationstatus').html(response[35]);
						$('#implementationstatus').html(response[36]);
						$('#addondiv').html(response[37]);
						$('#web_implementation').html(response[38]);
						if(response[38] == 'NO')
						{
							$('#web_remarks').html('Not Available');
							$('#webimplementationdiv').hide();
						}
						else
						{
							$('#web_remarks').html(response[39]);
							$('#webimplementationdiv').show();
						}
						$('#assigndays_imp').html(response[40]);
						if($('#assigndays_imp').val() == '')
						{
							$("#displayimplementername").html('Not Available');
						}
						else
						{
							$("#displayimplementername").html($("#assigndays_imp option:selected").text());
						}
						
						$('#customizer').val(response[41]);
						if($('#customizer').val() == '')
						{
							$("#displaycustomizername").html('Not Available');
						}
						else
						{
							$("#displaycustomizername").html($("#customizer option:selected").text());
						}
						
						$('#webimplementer').val(response[42]);
						if($('#webimplementer').val() == '')
						{
							$("#displaywebimplementername").html('Not Available')
						}
						else
						{
							$("#displaywebimplementername").html($("#customizer option:selected").text());
						}
						
						assigndaysgrid();
						generatecustomizationfilegrid('');
						generatecustomization('');
						////generateactivitygrid('');
						//generatecustomizationgrid('');
						getinvoicedetails(response[3]);

					}
					else
					{
						error.innerHTML = scripterror();
					}
	
				}
				else
					error.innerHTML = scripterror();
			}
		}
		ajaxcall3.send(passData);
	}
}

//select customer from the list
function selectfromlist()
{
	var selectbox =document.getElementById('customerlist');
	var cusnamesearch = document.getElementById('detailsearchtext');
	cusnamesearch.value = selectbox.options[selectbox.selectedIndex].text;
	cusnamesearch.select();
	customerdetailstoform(selectbox.value);
	customercontactdetailstoform(selectbox.value);
	enableformelemnts();
	newentry();
	document.getElementById('form-error1').innerHTML = '';
	document.getElementById('form-error2').innerHTML = '';
	//document.getElementById('form-error3').innerHTML = '';
}

function selectacustomer(input)
{
	var selectbox = document.getElementById('customerlist');
	var pattern = new RegExp("^" + input.toLowerCase());
	
	if(input == "")
	{
		getcustomerlist1();
	}
	else
	{
		selectbox.options.length = 0;
		var addedcount = 0;
		for( var i=0; i < customerarray.length; i++)
		{
				if(input.charAt(0) == "%")
				{
					withoutspace = input.substring(1,input.length);
					pattern = new RegExp(withoutspace.toLowerCase());
					comparestringsplit = customerarray[i].split("^");
					comparestring = comparestringsplit[1];
				}
				else
				{
					pattern = new RegExp("^" + input.toLowerCase());
					comparestring = customerarray[i];
				}
			if(pattern.test(customerarray[i].toLowerCase()))
			{
				var splits = customerarray[i].split("^");
				selectbox.options[selectbox.length] = new Option(splits[0], splits[1]);
				addedcount++;
				if(addedcount == 100)
					break;
				//selectbox.options[0].selected= true;
				//customerdetailstoform(selectbox.options[0].value); //document.getElementById('delaerrep').disabled = true;
				//document.getElementById('hiddenregistrationtype').value = 'newlicence'; clearregistrationform(); validatemakearegistration(); 
			}
		}
	}
}


function customersearch(e)
{ 
	var KeyID = (window.event) ? event.keyCode : e.keyCode;
	if(KeyID == 38)
		scrollcustomer('up');
	else if(KeyID == 40)
		scrollcustomer('down');
	else
	{
		var form = document.submitform;
		var input = document.getElementById('detailsearchtext').value;
		selectacustomer(input);
	}
}

function scrollcustomer(type)
{
	var selectbox = document.getElementById('customerlist');
	var totalcus = selectbox.options.length;
	var selectedcus = selectbox.selectedIndex;
	if(type == 'up' && selectedcus != 0)
		selectbox.selectedIndex = selectedcus - 1;
	else if(type == 'down' && selectedcus != totalcus)
		selectbox.selectedIndex = selectedcus + 1;
	selectfromlist();
}

function disableformelemnts()
{
	var count = document.submitform.elements.length;
	for (i=0; i<count; i++) 
	{
		var element = document.submitform.elements[i]; 
		element.disabled=true; 
	}
}

function enableformelemnts()
{
	var count = document.submitform.elements.length;
	for (i=0; i<count; i++) 
	{
		var element = document.submitform.elements[i]; 
		element.disabled=false; 
	}
}

//Function to make the display as block as well as none-------------------------------------------------------------
function divdisplay(elementid,imgname)
{
	if($('#'+ elementid).is(':visible'))
	{
		$('#'+ elementid).hide();
		if($('#'+ imgname))
			$('#'+ imgname).attr('src',"../images/plus.jpg");
	}
	else
	{
		$('#'+ elementid).show();
		if($('#'+ imgname))
			$('#'+ imgname).attr('src',"../images/minus.jpg");
	}
}



//Customer contact details to form
function customercontactdetailstoform(cusid)
{
	if(cusid != '')
	{
		$('#customerselectionprocess').html('');
		var passData = "switchtype=customercontactdetailstoform&lastslno=" + encodeURIComponent(cusid) + "&dummy=" + Math.floor(Math.random()*100032680100);
		ajaxcall121 = createajax();
		//$('#form-error').html(getprocessingimage());
		var queryString = "../ajax/customization.php";
		ajaxcall121.open("POST", queryString, true);
		ajaxcall121.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxcall121.onreadystatechange = function()
		{
			if(ajaxcall121.readyState == 4)
			{
				if(ajaxcall121.status == 200)
				{
				//	$('#form-error').html('');
					var response = (ajaxcall121.responseText).split("^");
					if(response == 'Thinking to redirect')
					{
						window.location = "../logout.php";
						return false;
					}
					else if(response[0] == '1')
					{
						$('#customerid').val(response[1]);
						$('#displaycustomerid').html(response[2]);
						$('#displaycompanyname').html('<strong>'+response[3]+'</strong>');
						$('#displaycontactperson').html(response[4]);
						$('#displayaddress').html(response[5]);
						$('#displayphone').html(response[6]);
						$('#displaycell').html(response[7]);
						$('#displayemail').html(response[8]);
						$('#displayregion').html(response[9]);
						$('#displaybranch').html(response[10]);
						if(response[11] == '')
							$('#displaytypeofcategory').html('Not Available');
						else
							$('#displaytypeofcategory').html(response[11]);
						if(response[12] == '')
							$('#displaytypeofcustomer').html('Not Available');
						else
							$('#displaytypeofcustomer').html(response[12]);
						$('#displaydealer').html(response[13]);
						$("#displaycustomerdetails").hide();
						$('#toggleimg1').attr('src',"../images/plus.jpg");
					} 
			}
			else
				$('#form-error').html(scripterror());
		  }
		}
		ajaxcall121.send(passData);
	}
}

function getinvoicedetails(rslno)
{
	var form = $('#submitform');
	var passData = "switchtype=invoicedetailsgrid&rslno=" + encodeURIComponent(rslno) + "&dummy=" + Math.floor(Math.random()*100032680100);
	ajaxcall23 = createajax();
	//$('#form-error').html(getprocessingimage());
	var queryString = "../ajax/customization.php";
	ajaxcall23.open("POST", queryString, true);
	ajaxcall23.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall23.onreadystatechange = function()
	{
		if(ajaxcall23.readyState == 4)
		{
			if(ajaxcall23.status == 200)
			{
				var response = (ajaxcall23.responseText).split('^');
				if(response == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				if(response[0] == '1')
				{
					$("#invoicedetailsgrid tr").remove();
					var row = '<tr><td>'+ response[1]+'</td></tr>';
					$("#invoicedetailsgrid ").append(row);
				}
		}
		else
			$('#form-error').html(scripterror());
	  }
	}
	ajaxcall23.send(passData);
}


function assigndaysgrid()
{
	var form = $("#submitform");
	var passData = "switchtype=assigndaysgrid&implastslno=" + encodeURIComponent($("#implastslno").val()) + "&dummy=" + Math.floor(Math.random()*10054300000);
	var ajaxcall22 = createajax();
	queryString = "../ajax/customization.php";
	ajaxcall22.open("POST", queryString, true);
	ajaxcall22.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall22.onreadystatechange = function()
	{
		if(ajaxcall22.readyState == 4)
		{
			if(ajaxcall22.status == 200)
			{
			//	$("#form-error").html('');
				var ajaxresponse = ajaxcall22.responseText;//alert(ajaxresponse)
				if(ajaxresponse == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else
				{
					var response = ajaxresponse.split('^');
					if(response[0] == '1')
					{
						$("#griddetails").html(response[1]);
					}
				}
			}
			else
				$("#tabgroupgridc1_1").html(errormessage('Connection Failed.'));
		}
	}
	ajaxcall22.send(passData);
}





function assigneddaysgridtoform()
{
	var field = $('#custgrid');
	if(!field.val()) { alert("Select the Customization Details."); field.focus(); return false; }
	var passData = "switchtype=assigneddaysgridtoform&impreflastslno=" + encodeURIComponent($('#custgrid').val())+"&custtext=" + encodeURIComponent($("#custgrid option:selected").text()) + "&dummy=" + Math.floor(Math.random()*100032680100)	;
	$('#impreflastslno').val($('#custgrid').val());
	ajaxcall55 = createajax();
	var queryString = "../ajax/customization.php";
	ajaxcall55.open("POST", queryString, true);
	ajaxcall55.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall55.onreadystatechange = function()
	{
		if(ajaxcall55.readyState == 4)
		{
			if(ajaxcall55.status == 200)
			{
				$('#form-error1').html('');
				var response = (ajaxcall55.responseText).split("^");
				if(response == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else if(response[0] == '1')
				{
					$('#visitrowdisplay tr').remove();
					var row = '<tr><td width="28%" ><strong>Selected Date : </strong></td><td width="39%"><input type="text" name="custgrid"  class="swiftselect-mandatory" disabled="disabled" id="custgrid" size="40"  value="'+ response[4]+'"  /></td><td width="33%"><div style="text-align:left"><a  onclick="assigndetails(\''+response[5]+'\');"  class="r-text">Change &#8250;&#8250;</a></div></td></tr>';
					$("#visitrowdisplay").append(row);
					$('#assigneddate').html(response[1]);
					$('#DPC_attachfromdate1').val(response[2]);
					$('#dayremarks').val(response[3]);
				} 
		}
		else
			$('#form-error1').html(scripterror());
	  }
	}
	ajaxcall55.send(passData);
}

//save implementation assign days
function assigndaysupdate(command) 
{
	var form = $('#submitform');
	var error = $('#form-error1');
	if($('#impreflastslno').val() == '')
	{
		error.html(errormessage('Please select a record from the grid'));
	}
	else
	{
		var field = $('#DPC_attachfromdate1');
		if(!field.val()) { error.html(errormessage("Enter the Work Date. ")); field.focus(); return false; }
		var field =  $('#dayremarks');
		if(!field.val()) { error.html(errormessage("Enter the Remarks ")); field.focus(); return false; }
		else
		{
			var passData = "";
			if(command == 'save')
			{
				passData =  "switchtype=assigndayssave&implastslno=" + encodeURIComponent($('#implastslno').val()) + "&customizationworkdate=" + encodeURIComponent($('#DPC_attachfromdate1').val())+ "&dayremarks=" + encodeURIComponent($('#dayremarks').val()) +  "&lastslno=" + encodeURIComponent($('#lastslno').val())+  "&impreflastslno=" + encodeURIComponent($('#impreflastslno').val())+ "&dummy=" + Math.floor(Math.random()*100000000);
			}
			else
			{
				passData =  "switchtype=deleteactivity&impreflastslno=" + encodeURIComponent($('#impreflastslno').val()) + "&lastslno=" + encodeURIComponent($('#lastslno').val()) + "&dummy=" + Math.floor(Math.random()*10000000000);
			}
			queryString = '../ajax/customization.php';
			var ajaxcall0 = createajax();
			error.html(getprocessingimage());
			ajaxcall0.open('POST', queryString, true);
			ajaxcall0.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			ajaxcall0.onreadystatechange = function()
			{
				if(ajaxcall0.readyState == 4)
				{
					if(ajaxcall0.status == 200)
					{
						var ajaxresponse = ajaxcall0.responseText;
						if(ajaxresponse == 'Thinking to redirect')
						{
							window.location = "../logout.php";
							return false;
						}
						else
						var response = ajaxresponse.split('^');
						if(response[0] == '1')
						{
							error.html(successmessage(response[1]));
							//form.reset();
							newentry();
						}
						else
						{
							error.html(errormessage('Unable to connect....'));
						}
					}
					else
						error.html(scripterror());
				}
			}
			ajaxcall0.send(passData);
		}
	}
}



//save implementation assign days
function customizationfilesupdate(command) 
{
	var form = $('#submitform');
	var error = $('#form-error2');

	var field =  $('#customizationremarks');
	if(!field.val()) { error.html(errormessage("Enter the Remarks ")); field.focus(); return false; }
	else
	{
		var passData = "";
		if(command == 'save')
		{
			var field = $('#filelink');
			if(!field.val()) { error.html(errormessage("Select the file to upload. ")); field.focus(); return false; }
			passData =  "switchtype=customizationfilesave&implastslno=" + encodeURIComponent($('#implastslno').val()) + "&customizationremarks=" + encodeURIComponent($('#customizationremarks').val())+ "&filelink=" + encodeURIComponent($('#filelink').val())  +  "&lastslno=" + encodeURIComponent($('#lastslno').val())+  "&impcustomizationlastslno=" + encodeURIComponent($('#impcustomizationlastslno').val())+  "&implastslno=" + encodeURIComponent($('#implastslno').val())+ "&dummy=" + Math.floor(Math.random()*100000000);
			
		}
		else
		{
			passData =  "switchtype=customizationfiledelete&impcustomizationlastslno=" + encodeURIComponent($('#impcustomizationlastslno').val()) + "&lastslno=" + encodeURIComponent($('#lastslno').val()) + "&dummy=" + Math.floor(Math.random()*10000000000);
		}
		queryString = '../ajax/customization.php';
		var ajaxcall0 = createajax();
		error.html(getprocessingimage());
		ajaxcall0.open('POST', queryString, true);
		ajaxcall0.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		ajaxcall0.onreadystatechange = function()
		{
			if(ajaxcall0.readyState == 4)
			{
				if(ajaxcall0.status == 200)
				{
					var ajaxresponse = ajaxcall0.responseText;
					if(ajaxresponse == 'Thinking to redirect')
					{
						window.location = "../logout.php";
						return false;
					}
					else
					var response = ajaxresponse.split('^');
					if(response[0] == '1')
					{
						error.html(successmessage(response[1]));
						//form.reset();
						custnewentry();
						generatecustomizationfilegrid('');
					}
					else
					{
						error.html(errormessage('Unable to connect....'));
					}
				}
				else
					error.html(scripterror());
			}
		}
		ajaxcall0.send(passData);
	}
}


function generatecustomizationfilegrid(startlimit)
{
	var form = $("#submitform");
	var passData = "switchtype=customizationnfilegrid&implastslno=" + encodeURIComponent($("#implastslno").val()) + "&startlimit=" + encodeURIComponent(startlimit)+ "&dummy=" + Math.floor(Math.random()*10054300000);
	var ajaxcall22 = createajax();
	$("#tabgroupgridc1_1").html(getprocessingimage());	
	queryString = "../ajax/customization.php";
	ajaxcall22.open("POST", queryString, true);
	ajaxcall22.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall22.onreadystatechange = function()
	{
		if(ajaxcall22.readyState == 4)
		{
			if(ajaxcall22.status == 200)
			{
				var ajaxresponse = ajaxcall22.responseText;
				if(ajaxresponse == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else
				{
					var response = ajaxresponse.split('^');
					if(response[0] == '1')
					{
						$("#tabgroupgridc1_1").html(response[1]);
						$("#getmorerecordslink").html(response[2]);
						$("#tabgroupcount").html(response[3]);
					}
					else
					{
						$("#tabgroupgridc1_1").html(errormessage('Unable to Connect...' ));
					}
				}
			}
			else
				$("#tabgroupgridc1_1").html(errormessage('Connection Failed.'));
		}
	}
	ajaxcall22.send(passData);
}


function customizationgridtoform(id)
{
	if(id != '')
	{
		var passData = "switchtype=customizationgridtoform&impcustomizationlastslno=" + encodeURIComponent(id) + "&dummy=" + Math.floor(Math.random()*100032680100);
		$('#impcustomizationlastslno').val(id);
		ajaxcall55 = createajax();
		$('#form-error2').html(getprocessingimage());
		var queryString = "../ajax/customization.php";
		ajaxcall55.open("POST", queryString, true);
		ajaxcall55.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxcall55.onreadystatechange = function()
		{
			if(ajaxcall55.readyState == 4)
			{
				if(ajaxcall55.status == 200)
				{
					$('#form-error2').html('');
					var response = (ajaxcall55.responseText).split("^");
					if(response == 'Thinking to redirect')
					{
						window.location = "../logout.php";
						return false;
					}
					else if(response[0] == '1')
					{
						$('#solutionfile').val(response[1]);
						$('#customizationremarks').val(response[2]);
						$('#filelink').val(response[3]);
					} 
			}
			else
				$('#form-error1').html(scripterror());
		  }
		}
		ajaxcall55.send(passData);
	}
}
function custnewentry()
{
	var form = $('#submitform');
	$('#solutionfile').val('');
	$('#customizationremarks').val('');

}
function customizationfilepath(filepath)
{
	if(filepath != '')
		$('#filepath').val(filepath);
		
	var form = $('#submitform');	
	$('#submitform').attr("action", "../ajax/custdownloadfile.php") ;
	//$('#submitform').attr( 'target', '_blank' );
	$('#submitform').submit();
}

function implemenationstatus(lastslno)
{
	var form = $('#submitform');
	var passData =  "switchtype=implemenationstatus&lastslno=" + encodeURIComponent(lastslno) + "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
	
	queryString = '../ajax/implementationprocess.php';
	var ajaxcall191 = createajax();
	ajaxcall191.open('POST', queryString, true);
	ajaxcall191.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	ajaxcall191.onreadystatechange = function()
	{
		if(ajaxcall191.readyState == 4)
		{
			if(ajaxcall191.status == 200)
			{
				var ajaxresponse = ajaxcall191.responseText;
				if(ajaxresponse == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else
				var response = ajaxresponse.split('^');//alert(response)
				if(response[0] == '1')
				{
					if(response[1] == 'no' && response[2] == 'no' && response[3] == 'no' && response[4] == 'pending')
					{
						$("#implementationid").html('Awaiting Branch Head Approval.');
						$('#assigndiv').hide();
						$('#remarksname').html('');
						$('#implementationremarks').val('');
						
					}
					else if(response[11] == 'yes'  && response[1] == 'no' && response[4] == 'pending')
					{
						$("#implementationid").html('Fowarded back to Sales Person.');
						$('#assigndiv').hide();
						$('#advdisplay').hide();
						$('#remarksname').html('Branch Head Rejected Remarks:');
						$('#implementationremarks').html(response[12]);
						
					}
					
					else if(response[1] == 'yes'  && response[2] == 'no' && response[3] == 'no' && response[4] == 'pending')
					{
						$("#implementationid").html('Awaiting Co-ordinator Approval.');
						$('#assigndiv').hide();
						$('#remarksname').html('Branch Head Remarks:');
						$('#implementationremarks').html(response[5]);
					}
					else if(response[1] == 'no' && response[2] == 'yes' && response[3] == 'no' && response[4] == 'pending')
					{
						$("#implementationid").html('Fowarded back to Branch Head.');
						$('#assigndiv').hide();
						$('#remarksname').html('Co-ordinator Reject Remarks:');
						$('#implementationremarks').html(response[6]);
					}
					else if(response[1] == 'yes' && response[2] == 'no'  && response[3] == 'yes' && response[4] == 'pending' )
					{
						$("#implementationid").html('Implementation, Yet to be Assigned.');
						$('#assigndiv').hide();
						$('#remarksname').html('Co-ordinator Approval Remarks:');
						$('#implementationremarks').html(response[7]);
					}
				
					else if(response[1] == 'yes' && response[2] == 'no'  && response[3] == 'yes' && response[4] == 'assigned' )
					{
						$("#implementationid").html('Assigned For Implementation.');
						$('#assigndiv').show();
						$('#assignid').val(response[8])
						$('#remarksname').html('');
						$('#implementationremarks').html('');
					}
					else if(response[1] == 'yes' && response[2] == 'no'  && response[3] == 'yes' && response[4] == 'progess' )
					{
						$("#implementationid").html('Implementation in progess.');
						$('#assigndiv').hide();
						$('#remarksname').html('');
						$('#implementationremarks').html('');
					}
					else if(response[1] == 'yes' && response[2] == 'no'  && response[3] == 'yes' && response[4] == 'completed' )
					{
						$("#implementationid").html('Implementation Completed.');
						$('#assigndiv').hide();
						$('#remarksname').html('');
						$('#implementationremarks').html('');
					}
				}
			}
			else
				$('#form-error').html(errormessage(scripterror()));
	   }
	}
	ajaxcall191.send(passData);	
}

function tooltip()
{
	if (ns6||ie) 
	{
		tipobj.style.display="block";
		tipobj.innerHTML = document.getElementById('assignid').value; 
		enabletip=true;
		return false;
	}
	
}

function viewcustfilepath(filepath)
{
	if(filepath != '')
		$('#custfilepath').val(filepath);
		
	var form = $('#submitform');	
	$('#submitform').attr("action", "../ajax/downloadfile.php?id=3") ;
	//$('#submitform').attr( 'target', '_blank' );
	$('#submitform').submit();
}

function assigndetails(slno)
{
	if(slno != '')
	{
		var form = $('#submitform');
		var passData = "switchtype=assigndetails&impslno=" + encodeURIComponent(slno) + "&dummy=" + Math.floor(Math.random()*100032680100);//alert(passData)
		ajaxcall34 = createajax();
		var queryString = "../ajax/customization.php";
		ajaxcall34.open("POST", queryString, true);
		ajaxcall34.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxcall34.onreadystatechange = function()
		{
			if(ajaxcall34.readyState == 4)
			{
				if(ajaxcall34.status == 200)
				{
					$('#form-error').html('');
					var response = (ajaxcall34.responseText).split('^');//alert(response)
					if(response == 'Thinking to redirect')
					{
						window.location = "../logout.php";
						return false;
					} 
					if(response[0] == '1')
					{
						
						var rowcount = $('#visitrowdisplay tr').length;
						$('#visitrowdisplay tr').remove();
						var row = '<tr ><td width="32%"><strong>Select a Customization Details: </strong></td><td width="29%" id="griddetails">'+ response[1]+'</td><td width="39%" ><a class="r-text" onClick="assigneddaysgridtoform();">Go &#8250;&#8250;</a></td></tr>';
						$("#visitrowdisplay").append(row);
						$('#submitform')[0].reset();
						$('#assigneddate').html('');
						newentry();
							
					}
						
			}
			else
				$('#form-error').html(scripterror());
		  }
		}
		ajaxcall34.send(passData);
	}
}

function generatecustomization(startlimit)
{
	var form = $("#submitform");
	var passData = "switchtype=customizationgrid&imprslno="+ encodeURIComponent($('#implastslno').val())+ "&startlimit=" + encodeURIComponent(startlimit);//alert(passData)
	var queryString = "../ajax/customization.php";
	ajaxcall47 = createajax();
	$('#form-error').html(getprocessingimage());
	ajaxcall47.open("POST", queryString, true);
	ajaxcall47.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall47.onreadystatechange = function()
	{
		if(ajaxcall47.readyState == 4)
		{
			if(ajaxcall47.status == 200)
			{
				var ajaxresponse = ajaxcall47.responseText;//alert(ajaxresponse)
				if(ajaxresponse == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else
				{
					var response = ajaxresponse.split('^');
					if(response[0] == '1')
					{
						$('#tabgroupgridc1_2').html(response[1]);
						$('#tabgroupgridc2link').html(response[2]);
					}
					else if(response[0] == '2')
					{
						$('#tabgroupgridc1_2').html(scripterror());
					}
				}
				
			}
			else
				$('#form-error').html(scripterror());
		}
	}
	ajaxcall47.send(passData);
}


function getmorecustomerregistration(startlimit,slno,showtype)
{
	var form = $('#submitform');
	var passData = "switchtype=customizationgrid&imprslno="+ encodeURIComponent($('#implastslno').val()) + "&startlimit=" + startlimit+ "&slno=" + slno+ "&showtype=" + encodeURIComponent(showtype)  + "&dummy=" + Math.floor(Math.random()*1000782200000);
//alert(passData);
	var queryString = "../ajax/customization.php";
	ajaxcall166 = createajax();
	$('#form-error').html(getprocessingimage());
	ajaxcall166.open("POST", queryString, true);
	ajaxcall166.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall166.onreadystatechange = function()
	{
		if(ajaxcall166.readyState == 4)
		{
			if(ajaxcall166.status == 200)
			{
				var ajaxresponse = ajaxcall166.responseText;
				if(ajaxresponse == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else
				{
					var response = ajaxresponse.split('^');//alert(response)
					if(response[0] == '1')
					{
						$('#form-error').html('');
						$('#regresultgrid2').html($('#tabgroupgridc1_2').html());
						$('#tabgroupgridc1_2').html($('#regresultgrid2').html().replace(/\<\/table\>/gi,'')+ response[1]) ;
						$('#tabgroupgridc2link').html(response[2]);
					}
					else
					if(response[0] == '2')
					{
						$('#tabgroupgridc1_1').html(scripterror());
					}
				}
				
			}
			else
				$('#tabgroupgridc1_1').html(scripterror());
		}
	}
	ajaxcall166.send(passData);
}

function searchbystatus()
{
	var form = $("#filterform");
	var passData =  "switchtype=filtercustomerlist&impsearch=" + encodeURIComponent($('#imp_status').val())+ "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
	var ajaxcall1 = createajax();
	$('#customerselectionprocess').html(getprocessingimage());
	queryString = "../ajax/customization.php";
	ajaxcall1.open("POST", queryString, true);
	ajaxcall1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall1.onreadystatechange = function()
	{
		if(ajaxcall1.readyState == 4)
		{
			if(ajaxcall1.status == 200)
			{
				var response = ajaxcall1.responseText.split('^*^');//alert(response)
				if(response == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else
				{
					searcharray = new Array();
					for( var i=0; i<response.length; i++)
					{
						searcharray[i] = response[i];
					}
					filtercustomerlist2();
					$("#customerselectionprocess").html('');
					$('#displayfilter').hide();
					$("#totalcount").html(searcharray.length);
				}
			}
			else
				$("#dealerselectionprocess").html(scripterror());
		}
	}
	ajaxcall1.send(passData);
}

function filtercustomerlist2()
{	
	var form = $('#submitform');
	var selectbox = $('#customerlist');
	var numberofcustomers = searcharray.length;
	$('#detailsearchtext').focus();
	var actuallimit = 500;
	var limitlist = (numberofcustomers > actuallimit)?actuallimit:numberofcustomers;
	$('option', selectbox).remove();
	var options = selectbox.attr('options');
	
	for( var i=0; i<limitlist; i++)
	{
		var splits = searcharray[i].split("^");
		options[options.length] = new Option(splits[0], splits[1]);
	}
}


function advancesearch()
{
	var form = $('#searchfilterform');
	var error = $('#filter-form-error'); 
	var textfield = $('#searchcriteria').val();
	var subselection = $("input[name='databasefield']:checked").val();
	var values = validatestatuscheckboxes();
	if(values == false)	{$('#filter-form-error').html(errormessage("Select A Status")); return false;	}

	var c_value = '';
	var newvalue = new Array();
	var chks = $("input[name='summarize[]']");
	for (var i = 0; i < chks.length; i++)
	{
		if ($(chks[i]).is(':checked'))
		{
			c_value += $(chks[i]).val()+ ',';
		}
	}
	var statuslist = c_value.substring(0,(c_value.length-1));
	
	var passData = "switchtype=searchcustomerlist&databasefield=" + encodeURIComponent(subselection) + "&state2=" + encodeURIComponent($("#state2").val())  + "&region=" +encodeURIComponent($("#region2").val())+ "&district2=" +encodeURIComponent($("#district2").val()) + "&textfield=" +encodeURIComponent(textfield) +  "&dealer2=" +encodeURIComponent($("#currentdealer2").val()) + "&branch2=" + encodeURIComponent($("#branch2").val())+"&type2=" +encodeURIComponent($("#type2").val()) + "&category2=" + encodeURIComponent($("#category2").val())+ "&statuslist=" + encodeURIComponent(statuslist)  + "&implementer=" +encodeURIComponent($("#implementer").val()) + "&dummy=" + Math.floor(Math.random()*10054300000);
	//alert(passData)
	$('#customerselectionprocess').html(getprocessingimage());
	queryString = "../ajax/implementationprocess.php";
	ajaxcall6 = $.ajax(
	{
		type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
		success: function(ajaxresponse,status)
		{	
				var response = ajaxresponse;//alert(response)
				if(response == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else
				{
					if(response == '')
					{
						$('#filterdiv').show();
						customersearcharray = new Array();
						for( var i=0; i<response.length; i++)
						{
							customersearcharray[i] = response[i];
						}
						flag = false;
						searchcustomerlist1();
						$('#customerselectionprocess').html(errormessage("Search Result"  + '<span style="padding-left: 15px;"><img src="../images/close-button.jpg" width="15" height="15" align="absmiddle" style="cursor: pointer; padding-bottom:2px" onclick="displayalcustomer()"></span> '));
						$('#totalcount').html('0');
						error.html(errormessage('No datas found to be displayed.'));
					}
					else 
					{
						$('#filterdiv').hide();
						customersearcharray = new Array();
						for( var i=0; i<response.length; i++)
						{
							customersearcharray[i] = response[i];
						}
						flag = false;
						searchcustomerlist1();
						$('#customerselectionprocess').html(successmessage('<span style="padding-bottom:0px">Search Result </span>   ' + '<span style="padding-left: 15px;"><img src="../images/close-button.jpg" width="15" height="15" align="absmiddle" style="cursor: pointer; padding-bottom:2px" onclick="displayalcustomer()"></span>'));
						$('#totalcount').html(customersearcharray.length);
						$('#filter-form-error').html('');
						$('#displaydetails').hide();
						$('#displayimplementation').hide();
						$('#displaytext').show();
					}
				}
		}, 
		error: function(a,b)
		{
			$('#form-error').html(scripterror());
		}
	});
}


function searchcustomerlist1()
{	
	var form = $("#searchfilterform");
	//document.getElementById('customerselectionprocess').innerHTML = '';
	var selectbox = $('#customerlist');
	var numberofcustomers = customersearcharray.length;
	$("#detailsearchtext").focus();
	var actuallimit = 500;
	var limitlist = (numberofcustomers > actuallimit)?actuallimit:numberofcustomers;
	$('option', selectbox).remove();
	var options = selectbox.attr('options');
	
	for( var i=0; i<limitlist; i++)
	{
		var splits = customersearcharray[i].split("^");
		options[options.length] = new Option(splits[0], splits[1]);
	}
}


function resetDefaultValues(oForm)
{
    var elements = oForm.elements; 
 	oForm.reset();
	$("#filter-form-error").html('');
	for(var i=0; i<elements.length;i++) 
	{
		field_type = elements[i].type.toLowerCase();//alert(field_type)
	}
	
	switch(field_type)
	{
	
		case "text": 
			elements[i].value = ""; 
			break;
		case "radio":
			if(elements[i].checked == 'databasefield1')
			{
				elements[i].checked = true;
			}
			else
			{
				elements[i].checked = false; 
			}
			break;
		case "checkbox":
  			if (elements[i].checked) 
			{
   				elements[i].checked = true; 
			}
			break;
		case "select-one":
		{
  			 for (var k=0, l=oForm.elements[i].options.length; k<l; k++)
			 {
             	oForm.elements[i].options[k].selected = oForm.elements[i].options[k].defaultSelected;
			 }
		}
			break;

		default: $('#districtcodedisplaysearch').html('<select name="district2" class="swiftselect" id="district2" style="width:180px;"><option value="">ALL</option></select>');
			break;
	}
}

function displayalcustomer()
{	
	var form = $("#submitform");
	flag = true;
	var selectbox = $('#customerlist');
	$('#customerselectionprocess').html(successsearchmessage('All Customers...'));
	var numberofcustomers = customerarray.length;
	$("#detailsearchtext").focus();
	var actuallimit = 500;
	var limitlist = (numberofcustomers > actuallimit)?actuallimit:numberofcustomers;

	$('option', selectbox).remove();
	var options = selectbox.attr('options');

	for( var i=0; i<limitlist; i++)
	{
		var splits = customerarray[i].split("^");
		options[options.length] = new Option(splits[0], splits[1]);
	}
	$('#totalcount').html(customerarray.length);
	
}

function validatestatuscheckboxes()
{
	var chksvalue = $("input[name='summarize[]']");
	var hasChecked = false;
	for (var i = 0; i < chksvalue.length; i++)
	{
		if ($(chksvalue[i]).is(':checked'))
		{
			hasChecked = true;
			return true
		}
	}
	if (!hasChecked)
	{
		return false
	}
}

