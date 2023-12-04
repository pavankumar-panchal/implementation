//Define customer Array
var customerarray = new Array();

//get the customer details to an array
function refreshcustomerarray()
{
	var passData = "switchtype=generatecustomerlist&dummy=" + Math.floor(Math.random()*10054300000);
	var ajaxcall2 = createajax();
	document.getElementById('customerselectionprocess').innerHTML = getprocessingimage();
	queryString = "../ajax/handholdprocess.php";
	ajaxcall2.open("POST", queryString, true);
	ajaxcall2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall2.onreadystatechange = function()
	{
		if(ajaxcall2.readyState == 4)
		{
			if(ajaxcall2.status == 200)
			{
				var response = ajaxcall2.responseText.split('^*^');//alert(response);
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
	var form = $('#submitform');
	//$('#impreflastslno').val('');
	$('#activityflag').val('');
	$('#impactivitylastslno').val('');
	$('#activityremarks').html('');
	$('#assigneddate').html('');
	$("#submitform" )[0].reset();
	$('#displayattach').hide();
}

//select customer from the list
function selectfromlist()
{
	var selectbox = document.getElementById('customerlist');
	var cusnamesearch = document.getElementById('detailsearchtext');
	cusnamesearch.value = selectbox.options[selectbox.selectedIndex].text;
	cusnamesearch.select();
	customercontactdetailstoform(selectbox.value);
	customerdetailstoform(selectbox.value);
	$('#databackupdiv').hide();
	enableformelemnts();
	newentry();
	document.getElementById('form-error1').innerHTML = '';
	document.getElementById('form-error2').innerHTML = '';
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

//Function to view the bill in pdf format----------------------------------------------------------------
function viewinvoice(slno)
{
	if(slno != '')
		$('#implementationslno').val(slno);
		
	var form = $('#submitform');	
	if($('#implementationslno').val() == '')
	{
		$('#form-error').html(errormessage('Please select a Customer.')); return false;
	}
	else
	{
		$('#submitform').attr("action", "../ajax/viewinvoicepdf.php") ;
		$('#submitform').attr( 'target', '_blank' );
		$('#submitform').submit();
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
		$('#lastslno').val(cusid);
		var queryString = "../ajax/handholdprocess.php";
		ajaxcall121.open("POST", queryString, true);
		ajaxcall121.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxcall121.onreadystatechange = function()
		{
			if(ajaxcall121.readyState == 4)
			{
				if(ajaxcall121.status == 200)
				{
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
						getactivitylist();
					} 
			}
			else
				$('#form-error').html(scripterror());
		  }
		}
		ajaxcall121.send(passData);
	}
}


function getactivitylist()
{
	var form = $('#submitform');
	var passData = "switchtype=getactivitylist&lastslno=" + encodeURIComponent($('#lastslno').val()) + "&implastslno=" + encodeURIComponent($('#implastslno').val()) + "&dummy=" + Math.floor(Math.random()*100032680100);
	ajaxcall21 = createajax();
	var queryString = "../ajax/handholdprocess.php";
	ajaxcall21.open("POST", queryString, true);
	ajaxcall21.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall21.onreadystatechange = function()
	{
		if(ajaxcall21.readyState == 4)
		{
			if(ajaxcall21.status == 200)
			{
				var response = (ajaxcall21.responseText).split('^');
				if(response == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				if(response[0] == '1')
				{
					$("#displayactivitylist").html(response[1]);
					generatevisitsgrid('')
				}
		}
		else
			$('#form-error').html(scripterror());
	  }
	}
	ajaxcall21.send(passData);
}

function generatevisitsgrid(startlimit)
{
	var form = $("#submitform");
	var passData = "switchtype=generatevisitgrid&implastslno=" + encodeURIComponent($("#implastslno").val()) +  "&dummy=" + Math.floor(Math.random()*10054300000);//alert(passData)
	var ajaxcall22 = createajax();
	queryString = "../ajax/handholdprocess.php";
	ajaxcall22.open("POST", queryString, true);
	ajaxcall22.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall22.onreadystatechange = function()
	{
		if(ajaxcall22.readyState == 4)
		{
			if(ajaxcall22.status == 200)
			{
			//	$("#form-error").html('');
				var ajaxresponse = ajaxcall22.responseText;// alert(ajaxresponse)
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
						$('#visitrowdisplay tr').remove();
						var row = '<tr ><td width="28%"><strong>Select a Visit Details: </strong></td><td width="29%" id="griddetails">'+ response[1]+'</td><td width="43%" ><a class="r-text" onClick="visitsgridtoform();">Go &#8250;&#8250;</a></td></tr>';
						$("#visitrowdisplay").append(row);
						//$("#griddetails").html(response[1]);
						enablesave('save');
						enablesave('save1');
					}
				}
			}
			else

				$("#form-error").html(errormessage('Connection Failed.'));
		}
	}
	ajaxcall22.send(passData);
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
		var passData = "switchtype=gridtoform&lastslno=" + encodeURIComponent(slno)  + "&dummy=" + Math.floor(Math.random()*100032680100);//alert(passData);
		error.html(getprocessingimage());
		var queryString = "../ajax/handholdprocess.php";
		ajaxcall5 = $.ajax(
		{
			type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
			success: function(ajaxresponse,status)
			{	
					error.html('');
					if(ajaxresponse == 'Thinking to redirect')
					{
						window.location = "../logout.php";
						return false;
					}
					else
					var response = ajaxresponse;//alert(ajaxresponse)
					if(response['errorcode'] == '1')
					{
						implemenationstatus(response['slno']);
						$('#implastslno').val(response['slno']);
						$('#invoicedetails').html(response['invoicenumber']);
						$('#imp_statustype').html(response['implementationtype']);
						$('#imptype_remarks').html(response['impremarks']);
						$('#collectedamt').html(response['advancecollected']);
						if(response['advancecollected'] == 'NO')
						{
							$('#paymentamt').html('Not Available');
							$('#paymentremarks').html('Not Available');
							$('#balancerecovery').html('Not Available');
						}
						else
						{
							$('#paymentamt').html(response['advanceamount']);
							$('#paymentremarks').html(response['advanceremarks']);
							$('#balancerecovery').html(response['balancerecoveryremarks']);
							
						}
						$('#attachement_raffilename').html(response['griddisplay']);
						$('#podate').html(response['podetails']);
						if(response['podetailspath'] != null || response['podetailspath'] != '')
						{
							var filename9 = response['podetailspath'].split('/');
							$('#pouploadlink_filename').html(filename9[5]);
							$('#pouploadlink_errorfile').html('<a href=\''+ response['podetailspath'] +'\' class = "r-text" style="text-decoration:none"> View &rsaquo;&rsaquo;</a>');
						}
						else
						{
							$('#pouploadlink_filename').html('Not Available');
							$('#pouploadlink_errorfile').html('');
						}
						$('#sales_company').html(response['numberofcompanies']);
						$('#sales_tomonths').html(response['numberofmonths']);
						$('#sales_frommonth').html(response['processingfrommonth']);
						$('#sales_training').html(response['additionaltraining']);
						$('#sales_commitdate').html(response['committedstartdate']);
						
						$('#sales_deliver').html(response['freedeliverables']);
						$('#sales_scheme').html(response['schemeapplicable']);
						$('#sales_checkbox').html(response['commissionapplicable']);
						if(response['commissionapplicable'] == 'NO')
						{
							$('#sales_name').html('Not Available');
							$('#sales_emailid').html('Not Available');
							$('#sales_mobile').html('Not Available');
							$('#sales_commission').html('Not Available');
						}
						else
						{
							$('#sales_name').html(response['commissionname']);
							$('#sales_emailid').html(response['commissionemail']);
							$('#sales_mobile').html(response['commissionmobile']);
							$('#sales_commission').html(response['commissionvalue']);
						}
						if(response['masterdatabyrelyon'] == 'NO')
						{
							$('#sales_noofemployee').html('Not Available');
							$('#sales_remarks').html('Not Available');
						}
						else
						{
							$('#sales_noofemployee').html(response['masternumberofemployees']);
							$('#sales_remarks').html(response['salescommitments']);
						}
						$('#sales_masterdata').html(response['masterdatabyrelyon']);
						$('#attendance').html(response['attendanceapplicable']);
						if(response['attendanceapplicable'] == 'NO')
						{
							$('#attendance_vendor').html('Not Available');
						}
						else
						{
							$('#attendance_vendor').html(response['attendanceremarks']);
						}
						if(response['attendancefilepath'] == null || response['attendancefilepath'] == '')
						{
							$('#attendance_errorfilename').html('Not Available');
							$('#attendance_errorfile').html('');

						}
						else
						{
							var filename3 = response['attendancefilepath'].split('/');
							$('#attendance_errorfilename').html(filename3[5]);
							$('#attendance_errorfile').html('<a href=\''+ response['attendancefilepath'] +'\' class = "r-text" style="text-decoration:none"> View &rsaquo;&rsaquo;</a>');
						}
						if(response['shipinvoiceapplicable'] == 'NO')
						{
							$('#shipment_remarks').html('Not Available');
						}
						else
						{
							$('#shipment_remarks').html(response['shipinvoiceremarks']);
						}
						$('#shipment_invoice').html(response['shipinvoiceapplicable']);
						$('#shipment_manual').html(response['shipmanualapplicable']);
						
						if(response['shipmanualapplicable'] == 'NO')
						{
							$('#manual_remarks').html('Not Available');
						}
						else
						{
							$('#manual_remarks').html(response['shipmanualremarks']);
						}
						$('#customization').html(response['customizationapplicable']);
						if(response['customizationapplicable'] == 'NO')
						{
							$('#displaycustomization').hide();
							$('#displayadddetails').show();
							$('#customization_remarks').html('Not Available');
							$('#customizationdiv').hide();

						}
						else
						{
							$('#displayadddetails').hide();
							$('#displaycustomization').show();
							$('#customization_remarks').html(response['customizationremarks']);
							$('#customizationdiv').show();

						}
						if(response['customizationreffilepath'] == null || response['customizationreffilepath'] == '')
						{
							$('#customization_referencesfilename').html('Not Available');
							$('#customization_references').html('');
						}
						else
						{
							var filename1 = response['customizationreffilepath'].split('/');
							$('#customization_referencesfilename').html(filename1[5]);
							$('#customization_references').html('<a href=\''+ response['customizationreffilepath'] +'\' class = "r-text" style="text-decoration:none"> View &rsaquo;&rsaquo; </a>');
						}
						if(response['customizationbackupfilepath'] == '' || response['customizationbackupfilepath'] == null)
						{
							$('#customization_sppdatafilename').html('Not Available');
							$('#customization_sppdata').html('');
						}
						else
						{
							var filename2 = response['customizationbackupfilepath'].split('/');
							$('#customization_sppdatafilename').html(filename2[5]);
							$('#customization_sppdata').html('<a href=\''+ response['customizationbackupfilepath'] +'\' class = "r-text" style="text-decoration:none"> View &rsaquo;&rsaquo; </a>');
						}
						$('#customizationstatus').html(response['customizationstatus']);
						$('#implementationstatus').html(response['implementationstatus']);
						$('#addondiv').html(response['grid']);
						$('#web_implementation').html(response['webimplemenationapplicable']);
						$('#fileuploaddiv').hide();
						if(response['webimplemenationapplicable'] == 'NO')
						{
							$('#web_remarks').html('Not Available');
							$('#webimplementationdiv').hide();
						}
						else
						{
							$('#web_remarks').html(response['webimplemenationremarks']);
							$('#webimplementationdiv').show();
						}
						
						if(response['assigncustomization'] != null || response['assigncustomization'] != '')
						{
							$('#customizer').val(response['assigncustomization']);
							$("#displaycustomizername").html($("#customizer option:selected").text());

						}
						else
						{
							$("#displaycustomizername").html('Not Available');
						}
						
						
						if(response['assignwebimplemenation'] != null || response['assignwebimplemenation'] != '')
						{
							$('#webimplementer').val(response['assignwebimplemenation']);
							$("#displaywebimplementername").html($("#customizer option:selected").text());
						}
						else
						{
							$("#displaywebimplementername").html('Not Available')
						}
						if(response['coordinatorapproval'] == 'no')
						{
							$('#displaybutton').show();
							$('#displaymessage').hide();
						}
						else
						{
							$('#displaybutton').hide();
							$('#displaymessage').show();
							$('#displaystatus').html('Approved');
						}
						getinvoicedetails(response['invoicenumber']);
						generatecustomization('');

					}
					else
					{
						error.hmtl(scripterror());
					}
	
			}, 
			error: function(a,b)
			{
				error.html(scripterror());
			}
		});	
	}
}

function getinvoicedetails(rslno)
{
	var form = $('#submitform');
	var passData = "switchtype=invoicedetailsgrid&rslno=" + encodeURIComponent(rslno) + "&dummy=" + Math.floor(Math.random()*100032680100);
	ajaxcall23 = createajax();
	//$('#form-error').html(getprocessingimage());
	var queryString = "../ajax/handholdprocess.php";
	ajaxcall23.open("POST", queryString, true);
	ajaxcall23.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall23.onreadystatechange = function()
	{
		if(ajaxcall23.readyState == 4)
		{
			if(ajaxcall23.status == 200)
			{
				var response = (ajaxcall23.responseText).split('^');//alert(response[1])
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

function implemenationstatus(lastslno)
{
	var form = $('#submitform');
	var passData =  "switchtype=implemenationstatus&lastslno=" + encodeURIComponent(lastslno) + "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
	
	queryString = '../ajax/handholdprocess.php';
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

function viewimpfilepath(filepath)
{
	if(filepath != '')
		$('#impfilepath').val(filepath);
		
	var form = $('#submitform');	
	var  res = $('#submitform').attr("action", "../ajax/downloadfile.php?id=2") ;
	$('#submitform').submit();
}

function visitdetails(slno)
{
	if(slno != '')
	{
		var form = $('#submitform');
		var passData = "switchtype=visitdetails&impslno=" + encodeURIComponent(slno) + "&dummy=" + Math.floor(Math.random()*100032680100);//alert(passData)
		ajaxcall34 = createajax();
		$('#form-error').html(getprocessingimage());
		var queryString = "../ajax/handholdprocess.php";
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
						$('#displayviewicc').html('');
						var rowcount = $('#visitrowdisplay tr').length;
						$('#visitrowdisplay tr').remove();
						var row = '<tr ><td width="28%"><strong>Select a Visit Details: </strong></td><td width="29%" id="griddetails">'+ response[1]+'</td><td width="43%" ><a class="r-text" onClick="visitsgridtoform();">Go &#8250;&#8250;</a></td></tr>';
						$("#visitrowdisplay").append(row);
						$('#submitform')[0].reset();
						enablesave('save1');
						enablesave('new2');
						enablesave('save2');
						enablesave('delete2');
						
						enablesave('save');
						$('#endtimehr').attr('disabled',false);
						$('#endtimemin').attr('disabled',false);
						$('#endtimeampm').attr('disabled',false);
						$('#starttimehr').attr('disabled',false);
						$('#starttimemin').attr('disabled',false);
						$('#starttimeampm').attr('disabled',false);
						generateactivitygrid();
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


function visitsgridtoform()
{
	var field = $('#activitygrid');
	$('#displayattach').hide();
	$('#form-error2').html('');
	$('#form-error3').html('');
	if(!field.val()) { alert("Select the Visit."); field.focus(); return false; }
	var field = $('#iccollected:checked').val();
	if(field != 'on') var iccollected = 'no'; else iccollected = 'yes';

	$('#customerselectionprocess').html('');
	var passData = "switchtype=visitsgridtoform&impreflastslno=" + encodeURIComponent($('#activitygrid').val())+"&activitytext=" + encodeURIComponent($("#activitygrid option:selected").text()) + "&dummy=" + Math.floor(Math.random()*100032680100);//alert(passData)
	$('#impreflastslno').val($('#activitygrid').val());
	ajaxcall55 = createajax();
	//$('#form-error1').html(getprocessingimage());
	var queryString = "../ajax/handholdprocess.php";
	ajaxcall55.open("POST", queryString, true);
	ajaxcall55.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall55.onreadystatechange = function()
	{
		if(ajaxcall55.readyState == 4)
		{
			if(ajaxcall55.status == 200)
			{
				$('#form-error1').html('');
				var response = (ajaxcall55.responseText).split("^");//alert(response)
				//alert(response[0]);
				if(response == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else if(response[0] == '1')
				{
					$('#visitrowdisplay tr').remove();
					var row = '<tr><td width="28%" ><strong>Selected Visit : </strong></td><td width="39%"><input type="text" name="activitygrid"  class="swiftselect-mandatory" disabled="disabled" id="activitygrid" size="40"  value="'+ response[8]+'"  /></td><td width="33%"><div style="text-align:left"><a  onclick="visitdetails(\''+response[9]+'\');"  class="r-text">Change &#8250;&#8250;</a></div></td></tr>';
					$("#visitrowdisplay").append(row);

					$('#assigneddate').html(response[10]);
					//alert(response[7]);
					//alert(response[13]);
					if(response[3] == 'yes' && response[11] == '')
					{
						$('#iccollected').attr('checked',false);
						$('#displayviewicc').html('');
					}
					if(response[4] != '')
					{
						var starttime = response[4].split(':');
						$('#starttimehr').val(starttime[0]);
						$('#starttimemin').val(starttime[1]);
						$('#starttimeampm').val(starttime[2].toLowerCase());
					}
					else
					{
						$('#starttimehr').val('');
						$('#starttimemin').val('');
						$('#starttimeampm').val('');
					}
					
					if(response[5] != '')
					{
						var endtime = response[5].split(':');
						$('#endtimehr').val(endtime[0]);
						$('#endtimemin').val(endtime[1]);
						$('#endtimeampm').val(endtime[2].toLowerCase());
					}
					else
					{
						$('#endtimehr').val('');
						$('#endtimemin').val('');
						$('#endtimeampm').val('');
					}
					
					$('#dayremarks').val(response[6]);
					$('#impstatus').val(response[13]);
					
					if(response[10] == 'Not Avaliable')
						$('#DPC_attachfromdate1').val('');
					else
						$('#DPC_attachfromdate1').val(response[10]);
					if(response[3] == 'yes' )
					{
						disablesave('save');
						disablesave('save1');
						
						disablesave('new2');
						disablesave('save2');
						disablesave('delete2');
						$('#starttimehr').attr('disabled',true);
						$('#starttimemin').attr('disabled',true);
						$('#starttimeampm').attr('disabled',true);
						
						$('#endtimehr').attr('disabled',true);
						$('#endtimemin').attr('disabled',true);
						$('#endtimeampm').attr('disabled',true);
						
						if( response[11] != '')
						{
							$('#iccollected').attr('checked',true);
							$('#displayviewicc').html('<a href=\''+ response[11] +'\' class = "r-text" style="text-decoration:none"> View &rsaquo;&rsaquo;</a>');
						}
						return false;
					}
					if(response[10] == 'Not Avaliable' )
					{
						disablesave('save');
						disablesave('save1');
						
						disablesave('new2');
						disablesave('save2');
						disablesave('delete2');
						$('#starttimehr').attr('disabled',true);
						$('#starttimemin').attr('disabled',true);
						$('#starttimeampm').attr('disabled',true);
						
						$('#endtimehr').attr('disabled',true);
						$('#endtimemin').attr('disabled',true);
						$('#endtimeampm').attr('disabled',true);
						return false;
					}
					//alert(response[2])
					if(response[2] == 'no' && response[7] == 'no' )
					{
						disablesave('save1');
						disablesave('new2');
						disablesave('save2');
						disablesave('delete2');
						
						enablesave('save');
						$('#endtimehr').attr('disabled',true);
						$('#endtimemin').attr('disabled',true);
						$('#endtimeampm').attr('disabled',true);
						$('#starttimehr').attr('disabled',false);
						$('#starttimemin').attr('disabled',false);
						$('#starttimeampm').attr('disabled',false);
						
					}
					else if(response[2] == 'yes' && response[7] == 'no' )
					{
						enablesave('save1');
						enablesave('new2');
						enablesave('save2');
						enablesave('delete2');
						
						disablesave('save');
						$('#starttimehr').attr('disabled',true);
						$('#starttimemin').attr('disabled',true);
						$('#starttimeampm').attr('disabled',true);
						
						$('#endtimehr').attr('disabled',false);
						$('#endtimemin').attr('disabled',false);
						$('#endtimeampm').attr('disabled',false);
					}
					else if(response[2] == 'yes' && response[7] == 'yes' && response[13] == 'Completed')
					{
						disablesave('save1');
						disablesave('save');
						
						disablesave('new2');
						disablesave('save2');
						disablesave('delete2');
						
						$('#starttimehr').attr('disabled',true);
						$('#starttimemin').attr('disabled',true);
						$('#starttimeampm').attr('disabled',true);
						
						$('#endtimehr').attr('disabled',true);
						$('#endtimemin').attr('disabled',true);
						$('#endtimeampm').attr('disabled',true);
					}
					if(response[12] != '')
					{
						var response2 = response[12].split('/');
						$("#downloadlinkfile2").html('<div id="linkdetailsdiv2" style="display:block"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="18%" id="viewdetailsdiv2"><a onclick = "viewfilepath(\'' + response[12] + '\')" class="r-text" style="text-decoration:none" >View &#8250;&#8250;</a></td></tr></table>');
						$("#databackup").val(response2[5]);
						$("#file_link").val(response[12]);
					}
					else
					{
						$("#downloadlinkfile2").html('');
						$("#databackup").val('');
						$("#file_link").val('');
					}
					$('#databackupdiv').hide();
					activitygridvisit();	
					//$('#DPC_attachfromdate1').val(response[2]);
				} 
				else if(response[0] == '2')
				{
					alert("Please add details for previous Visits.")
				}
		}
		else
			$('#form-error1').html(scripterror());
	  }
	}
	ajaxcall55.send(passData);
}

function viewfilepath(filepath)
{
	if(filepath != '')
		$('#file_path').val(filepath);
		
	var form = $('#submitform');	
	$('#submitform').attr("action", "../ajax/downloadfile.php?id=4") ;
	//$('#submitform').attr( 'target', '_blank' );
	$('#submitform').submit();
}

function generateactivitygrid()
{
	var form = $("#submitform");
	var passData = "switchtype=generateactivitygrid&impreflastslno=" + encodeURIComponent($("#implastslno").val()) + "&dummy=" + Math.floor(Math.random()*10054300000);//alert(passData)
	var ajaxcall22 = createajax();
	$("#tabgroupgridc1_1").html(getprocessingimage());	
	queryString = "../ajax/handholdprocess.php";
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
					var response = ajaxresponse.split('^');//alert(response)
					if(response[0] == '1')
					{
						$("#tabgroupgridc1_1").html(response[1]);
						$("#getmorerecordslink").html(response[2]);
						$("#tabgroupcount").html(response[3]);
						if(response[4] == 0)
							$('#activityflag').val('');
						else
							$('#activityflag').val('yes');
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


function getactivityremarks()
{
	var form = $('#submitform');
	if($('#activity').val() != '')
	{
		var passData = "switchtype=getactivityremarks&activity=" + encodeURIComponent($('#activity').val())+"&impreflastslno=" + encodeURIComponent($("#implastslno").val()) + "&dummy=" + Math.floor(Math.random()*100032680100);//alert(passData);
		ajaxcall05 = createajax();
		//$('#activityremarks').html(getprocessingimage());
		var queryString = "../ajax/handholdprocess.php";
		ajaxcall05.open("POST", queryString, true);
		ajaxcall05.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxcall05.onreadystatechange = function()
		{
			if(ajaxcall05.readyState == 4)
			{
				if(ajaxcall05.status == 200)
				{
					var response = (ajaxcall05.responseText).split("^");
					if(response == 'Thinking to redirect')
					{
						window.location = "../logout.php";
						return false;
					}
					else if(response[0] == '1')
					{
						$('#activityremarks').html(response[1]);
					} 
			   }
			   else
					$('#form-error2').html(scripterror());
		  }
	   }
		ajaxcall05.send(passData);
	}
	else
	{
		$('#activityremarks').html('');
		return false;
	}
}


function activitesupdate(command) 
{
	var form = $('#submitform');
	var error = $('#form-error3');
	var field = $('#activity');
	if(!field.val()) { error.html(errormessage("Select the Activity. ")); field.focus(); return false; }
	var field =  $('#description');
	if(!field.val()) { error.html(errormessage("Enter the Implementator Remarks. ")); field.focus(); return false; }
	else
	{
		var passData = "";
		if(command == 'save2')
		{
			passData =  "switchtype=saveactivity&implastslno=" + encodeURIComponent($('#implastslno').val()) + "&activity=" + encodeURIComponent($('#activity').val())+ "&description=" + encodeURIComponent($('#description').val())  +  "&lastslno=" + encodeURIComponent($('#lastslno').val())+  "&impactivitylastslno=" + encodeURIComponent($('#impactivitylastslno').val())+ "&dummy=" + Math.floor(Math.random()*100000000);
			//alert(passData);
		}
		else
		{
			passData =  "switchtype=deleteactivity&impactivitylastslno=" + encodeURIComponent($('#impactivitylastslno').val()) + "&lastslno=" + encodeURIComponent($('#lastslno').val()) + "&dummy=" + Math.floor(Math.random()*10000000000);
		}
		queryString = '../ajax/handholdprocess.php';
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
					var ajaxresponse = ajaxcall0.responseText;//alert(ajaxresponse)
					if(ajaxresponse == 'Thinking to redirect')
					{
						window.location = "../logout.php";
						return false;
					}
					else
					var response = ajaxresponse.split('^');//alert(response[2])
					if(response[0] == '1')
					{
						error.html(successmessage(response[1]));
						$('#activityslno').val(response[2]);
						generateactivitygrid();
					}
					else
					if(response[0] == '2')
					{
						error.html(successmessage(response[1]));
						$('#activitydeleteslno').val(response[2]);
						generateactivitygrid();
					}
					
				}
				else
					error.html(scripterror());
			}
		}
		ajaxcall0.send(passData);
	}
}


function visitupdate(command) 
{
	var form = $('#submitform');
	var error = $('#form-error1');
	var field = $('#visit_endtime');
		
	if(command == 'save1')
	{
		$('#form-error2').html('');
		if($('#impreflastslno').val() == '')
		{
			 error.html(errormessage("Please select a Visit Details")); return false;
		}
		var field = $('#DPC_attachfromdate1');
		if(!field.val()) { error.html(errormessage("Enter the Date. ")); field.focus(); return false; }
		var field = $('#starttimehr');
		if(!field.val()) { error.html(errormessage("Enter the hour. ")); field.focus(); return false; }
		var field = $('#starttimemin');
		if(!field.val()) { error.html(errormessage("Enter the Minute. ")); field.focus(); return false; }
		var field = $('#starttimeampm');
		if(!field.val()) { error.html(errormessage("Enter the Type (AM/PM). ")); field.focus(); return false; }
	
		passData =  "switchtype=savestartvisit&implastslno=" + encodeURIComponent($('#implastslno').val()) + "&starttimehr=" +encodeURIComponent($('#starttimehr').val()) + "&starttimemin=" +encodeURIComponent($('#starttimemin').val()) + "&starttimeampm=" +encodeURIComponent($('#starttimeampm').val()) + "&date=" + encodeURIComponent($('#DPC_attachfromdate1').val()) + "&dayremarks=" +encodeURIComponent($('#dayremarks').val()) +  "&lastslno=" + encodeURIComponent($('#lastslno').val())+  "&impreflastslno=" + encodeURIComponent($('#impreflastslno').val())+ "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
		error.html(getprocessingimage());
		disablesave('save');
		enablesave('save1');
		enablesave('new2');
		enablesave('save2');
		enablesave('delete2');
		
		$('#endtimehr').attr('disabled',false);
		$('#endtimemin').attr('disabled',false);
		$('#endtimeampm').attr('disabled',false);
		
	}
	else if(command == 'save2')
	{
		$('#form-error1').html('');
		if($('#impreflastslno').val() == '')
		{
			 $('#form-error2').html(errormessage("Please select a Visit Details")); return false;
		}
		if(($('#activityslno').val() != '') && ($('#activitydeleteslno').val() != ''))
		{
			var count = $('#activityslno').val().split(',');
			if((count.length) > 1)
				$('#activityflag').val('yes'); 
			else
				$('#activityflag').val('');
		}
		var field = $("#activityflag");
		if(!field.val()) { $('#form-error2').html(errormessage("Atleast one Activities Carried out is required.")); $('#activity').focus(); return false; }
		var field = $('#endtimehr');
		if(!field.val()) { $('#form-error2').html(errormessage("Enter the hour. ")); field.focus(); return false; }
		var field = $('#endtimemin');
		if(!field.val()) { $('#form-error2').html(errormessage("Enter the Minute. ")); field.focus(); return false; }
		var field = $('#endtimeampm');
		if(!field.val()) { $('#form-error2').html(errormessage("Enter the Type (AM/PM). ")); field.focus(); return false; }
		var field = $('#impstatus');
		if(!field.val()) { $('#form-error2').html(errormessage("Please select the status. ")); field.focus(); return false; }
		var field = $("#file_link" );
		// if(!field.val()) { $('#form-error2').html(errormessage("Enter the Data Back up.")); field.focus(); return false; }
		var field = $('#iccollected:checked').val();
		if(field != 'on') var iccollected = 'no'; else iccollected = 'yes';
		//alert(iccollected);
		if(iccollected == 'yes')
		{
			var field = $("#attach_icc" );
			if(!field.val()) { $('#form-error2').html(errormessage("Enter the ICC Attachment.")); field.focus(); return false; }
		}
		if(iccollected == 'no')
		{
			var field = $("#attach_link" );
			//alert(field.val());
			if(field.val()!= "") {field.val(''); }
		}
		
		var field = $('#dayremarks');
		if(!field.val()) { $('#form-error2').html(errormessage('Enter the Remarks.')); field.focus(); return false;  }
		var flag = $('#activityflag').val();
		if(flag == 'no')
		{$('#form-error2').html(errormessage('Atleast one Activities Carried is required..')); $('#activity').focus(); return false;}
		passData =  "switchtype=saveendvisit&implastslno=" + encodeURIComponent($('#implastslno').val())+ "&endtimehr=" + encodeURIComponent($('#endtimehr').val())+ "&endtimemin=" + encodeURIComponent($('#endtimemin').val())+ "&endtimeampm=" + encodeURIComponent($('#endtimeampm').val()) + "&starttimehr=" +encodeURIComponent($('#starttimehr').val()) + "&starttimemin=" +encodeURIComponent($('#starttimemin').val()) + "&starttimeampm=" +encodeURIComponent($('#starttimeampm').val())+ "&dayremarks=" + encodeURIComponent($('#dayremarks').val()) +  "&lastslno=" + encodeURIComponent($('#lastslno').val())+  "&impreflastslno=" + encodeURIComponent($('#impreflastslno').val())+  "&iccfilepath=" + encodeURIComponent($('#attach_link').val()) +  "&iccollected=" + encodeURIComponent(iccollected)+ "&activityslno=" + encodeURIComponent($('#activityslno').val())+ "&activitydeleteslno=" + encodeURIComponent($('#activitydeleteslno').val())+  "&databackuppath=" + encodeURIComponent($('#file_link').val())+  "&impstatus=" + encodeURIComponent($('#impstatus').val()) + "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
		$('#form-error2').html(getprocessingimage());
		disablesave('save1');
	}
	queryString = '../ajax/handholdprocess.php';
	var ajaxcall0 = createajax();
	ajaxcall0.open('POST', queryString, true);
	ajaxcall0.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	ajaxcall0.onreadystatechange = function()
	{
		if(ajaxcall0.readyState == 4)
		{
			if(ajaxcall0.status == 200)
			{
				var ajaxresponse = ajaxcall0.responseText;//alert(ajaxresponse)
				if(ajaxresponse == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else
				var response = ajaxresponse.split('^'); 
				if(iccollected == 'yes')
					$('#displayattach').show();
				else
					$('#displayattach').hide();

				if(response[0] == '1')
				{
					error.html(successmessage(response[1]));
				}
				if(response[0] == '2')
				{
					$('#form-error2').html(successmessage(response[1]));
				}
				if(response[0] == '3')
				{
					$('#form-error2').html(errormessage(response[1]));
					$('#endtimehr').focus();
					enablesave('save1');
				}
				if(response[0] == '4')
				{
					$('#form-error2').html(errormessage(response[1]));
					enablesave('save1');
				}
				if(response[0] == '5' || response[0] == '6' || response[0] == '7')
				{
					$('#form-error2').html(errormessage(response[1]));
					enablesave('save1');
				}
			}
			else
				error.html(scripterror());
		}
	}
	ajaxcall0.send(passData);
}

function activitygridtoform(id)
{
	if(id != '')
	{
		var passData = "switchtype=activitygridtoform&impactivitylastslno=" + encodeURIComponent(id) + "&dummy=" + Math.floor(Math.random()*100032680100);
		$('#impactivitylastslno').val(id);
		ajaxcall55 = createajax();
		$('#form-error3').html(getprocessingimage());
		var queryString = "../ajax/handholdprocess.php";
		ajaxcall55.open("POST", queryString, true);
		ajaxcall55.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxcall55.onreadystatechange = function()
		{
			if(ajaxcall55.readyState == 4)
			{
				if(ajaxcall55.status == 200)
				{
					$('#form-error3').html('');
					var response = (ajaxcall55.responseText).split("^");
					if(response == 'Thinking to redirect')
					{
						window.location = "../logout.php";
						return false;
					}
					else if(response[0] == '1')
					{
						$('#activity').val(response[1]);
						$('#description').val(response[2]);
						$('#activityremarks').html(response[3]);
					} 
			}
			else
				$('#form-error3').html(scripterror());
		  }
		}
		ajaxcall55.send(passData);
	}
}


function activitygridvisit()
{
	var form = $("#submitform");
	var passData = "switchtype=activitygridvisit&impreflastslno=" + encodeURIComponent($("#impreflastslno").val()) + "&dummy=" + Math.floor(Math.random()*10054300000);//alert(passData)
	var ajaxcall22 = createajax();
	$("#tabgroupgridc1_1").html(getprocessingimage());	
	queryString = "../ajax/handholdprocess.php";
	ajaxcall22.open("POST", queryString, true);
	ajaxcall22.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall22.onreadystatechange = function()
	{
		if(ajaxcall22.readyState == 4)
		{
			if(ajaxcall22.status == 200)
			{
				var ajaxresponse = ajaxcall22.responseText;//alert(ajaxresponse)
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


function checkboxvalidation(divid)
{
	if($('#iccollected').is(':checked') == true)
	{
		$('#displayattach').show();
		$('#downloadlinkfile').html('');
	}
	else
	{
		$('#displayattach').hide();
		$('#downloadlinkfile').html('');
	}
}

function deletefilepath(pathlink)
{
	var passData = "switchtype=deletepath&pathlink=" + encodeURIComponent(pathlink) + "&dummy=" + Math.floor(Math.random()*100032680100);//alert(passData)
	ajaxcall53 = createajax();
	var queryString = "../ajax/handholdprocess.php";
	ajaxcall53.open("POST", queryString, true);
	ajaxcall53.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcall53.onreadystatechange = function()
	{
		if(ajaxcall53.readyState == 4)
		{
			if(ajaxcall53.status == 200)
			{
				var response = (ajaxcall53.responseText).split('^');//alert(response)
				if(response == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				if(response[0] == '1')
				{
					$('#linkdetailsdiv').hide();
					$('#attach_icc').val('');
				}
					
		}
		else
			$('#form-error').html(scripterror());
	  }
	}
	ajaxcall53.send(passData);
}


function generatecustomization(startlimit)
{
	var form = $("#submitform");
	var passData = "switchtype=customizationgrid&imprslno="+ encodeURIComponent($('#implastslno').val())+ "&startlimit=" + encodeURIComponent(startlimit);//alert(passData)
	var queryString = "../ajax/handholdprocess.php";
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
	var queryString = "../ajax/handholdprocess.php";
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
	var passData =  "switchtype=filtercustomerlist&impsearch=" + encodeURIComponent($('#imp_status').val()) + "&imphandhold=" + encodeURIComponent($('#handhold').val())+ "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
	var ajaxcall1 = createajax();
	$('#customerselectionprocess').html(getprocessingimage());
	queryString = "../ajax/handholdprocess.php";
	ajaxcall26 = $.ajax(
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
		}, 
		error: function(a,b)
		{
			$('#dealerselectionprocess').html(scripterror());
		}
	});	
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

function opencustcolorbox()
{
	$('#customization_remarks1').val('');
	$('#customization_references1').val('');
	$('#cust_link').val('');
	$('#customization_sppdata1').val('');
	$('#spp_link').val('');
	$('#spp_link').val('');
	$("#customizationcustomerview").attr('checked',false);
	$("").colorbox({ iframe:true,inline:true, href:"#customizationcolorbox", onLoad: function() { $('#cboxClose').hide()}});
}

function customerizationsave()
{
	var error = $('#cust-error-msg');
	var field = $("#customization_remarks1" );
	if(!field.val()) { error.html(errormessage("Enter the Customization Remarks")); field.focus();field.scroll(); return false; }
	var field = $("#customization_references1" );
	if(!field.val()) { error.html(errormessage("Please Attach Customization References Files")); field.focus();field.scroll(); return false; }
	var field = $("#customization_sppdata1" );
	if(!field.val()) { error.html(errormessage("Please Attach SPP Data Backup:")); field.focus();field.scroll(); return false; }
	var field = $('#customizationcustomerview:checked').val();
	if(field != 'on') var customizationcustomerview = 'no'; else customizationcustomerview = 'yes';
	
	var passData = "switchtype=customerizationsave&lastslno=" + encodeURIComponent($('#implastslno').val())+"&customization_references=" + encodeURIComponent($('#cust_link').val()) + "&customization_sppdata=" + encodeURIComponent($('#spp_link').val()) +"&customizationremarks=" + encodeURIComponent($('#customization_remarks1').val())+ "&customizationstatus=" + encodeURIComponent(customizationcustomerview) + "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
	queryString = "../ajax/handholdprocess.php";
	error.html(getprocessingimage());
	ajaxcall2356 = $.ajax(
	{
		type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
		success: function(ajaxresponse,status)
		{	
			if(ajaxresponse == 'Thinking to redirect')
			{
				window.location = "../logout.php";
				return false;
			}
			else
			{
				var response = ajaxresponse;
				error.html('');
				if(response['errorcode'] == '1')
				{
					error.html(successmessage(response['errormsg']));
					
					if(response['customizationapplicable'] == 'NO')
					{
						$('#displaycustomization').hide();
						$('#displayadddetails').show();
						$('#customization_remarks').html('Not Available');
					}
					else
					{
						$('#displaycustomization').show();
						$('#displayadddetails').hide();
						$('#customization_remarks').html(response['customizationremarks']);
						$('#customization').html(response['customizationapplicable']);
					}
					if(response['customizationreffilepath'] == null || response['customizationreffilepath'] == '')
					{
						$('#customization_referencesfilename').html('Not Available');
						$('#customization_references').html('');
					}
					else
					{
						var filename1 = response['customizationreffilepath'].split('/');
						$('#customization_referencesfilename').html(filename1[5]);
						$('#customization_references').html('<a href=\''+ response['customizationreffilepath'] +'\' class = "r-text" style="text-decoration:none"> View &rsaquo;&rsaquo; </a>');
					}
					if(response['customizationbackupfilepath'] == '' || response['customizationbackupfilepath'] == null)
					{
						$('#customization_sppdatafilename').html('Not Available');
						$('#customization_sppdata').html('');
					}
					else
					{
						var filename2 = response['customizationbackupfilepath'].split('/');
						$('#customization_sppdatafilename').html(filename2[5]);
						$('#customization_sppdata').html('<a href=\''+ response['customizationbackupfilepath'] +'\' class = "r-text" style="text-decoration:none"> View &rsaquo;&rsaquo; </a>');
					}
					$('#customizationstatus').html(response['customizationstatus']);
					generatecustomization('');
					$().colorbox.close();
				}		
			}
		}, 
		error: function(a,b)
		{
			$("#customerselectionprocess").html(scripterror());
		}
	});	
	
	
}


function advancesearch()
{
	var form = $('#searchfilterform');
	var error = $('#filter-form-error'); 
	var textfield = $('#searchcriteria').val();
	var subselection = $("input[name='databasefield']:checked").val();
	// var values = validatestatuscheckboxes();
	// if(values == false)	{$('#filter-form-error').html(errormessage("Select A Status")); return false;	}

	// var c_value = '';
	// var newvalue = new Array();
	// var chks = $("input[name='summarize[]']");
	// for (var i = 0; i < chks.length; i++)
	// {
	// 	if ($(chks[i]).is(':checked'))
	// 	{
	// 		c_value += $(chks[i]).val()+ ',';
	// 	}
	// }
	// var statuslist = c_value.substring(0,(c_value.length-1));
	
	var passData = "switchtype=searchcustomerlist&databasefield=" + encodeURIComponent(subselection) + "&state2=" + encodeURIComponent($("#state2").val())  + "&region=" +encodeURIComponent($("#region2").val())+ "&district2=" +encodeURIComponent($("#district2").val()) + "&textfield=" +encodeURIComponent(textfield) +  "&dealer2=" +encodeURIComponent($("#currentdealer2").val()) + "&branch2=" + encodeURIComponent($("#branch2").val())+"&type2=" +encodeURIComponent($("#type2").val()) + "&category2=" + encodeURIComponent($("#category2").val())  + "&implementer=" +encodeURIComponent($("#implementer").val()) + "&dummy=" + Math.floor(Math.random()*10054300000);
	//alert(passData)
	$('#customerselectionprocess').html(getprocessingimage());
	queryString = "../ajax/handholdprocess.php";
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

