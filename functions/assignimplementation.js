var customerarray = new Array();

function gettotalcustomercount()
{
	var form = $('#customerselectionprocess');
	var passData = "switchtype=getcustomercount&dummy=" + Math.floor(Math.random()*10054300000);
	queryString = "../ajax/assignimplementation.php";
	ajaxcall1 = $.ajax(
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
				if(response == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				
				else
				{
					$("#totalcount").html(response['count']);
					refreshcustomerarray(response['count']);
				}
			}
		}, 
		error: function(a,b)
		{
			$("#customerselectionprocess").html(scripterror());
		}
	});	
}

function refreshcustomerarray(customercount)
{
	var form = $('#customerselectionprocess');
	var form = $('#cardsearchfilterform');
	var passData = "switchtype=generatecustomerlist&dummy=" + Math.floor(Math.random()*10054300000);
	queryString = "../ajax/assignimplementation.php";
	ajaxcall2 = $.ajax(
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
				for( var i=0; i<response.length; i++)
				{
					customerarray[i] = response[i];
				}
				getcustomerlist1()
			}
		}, 
		error: function(a,b)
		{
			$("#customerselectionprocess").html(scripterror());
		}
	});	
	
	

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



function getcustomerlist1()
{	
	disableformelemnts();
	var form = $("#submitform" );
	var selectbox = $('#customerlist');
	var numberofcustomers = customerarray.length;
	$('#detailsearchtext').focus();
	var actuallimit = 500;
	var limitlist = (numberofcustomers > actuallimit)?actuallimit:numberofcustomers;
	$('option', selectbox).remove();
	var options = selectbox.attr('options');
	
	for( var i=0; i<limitlist; i++)
	{
		var splits = customerarray[i].split("^");
		options[options.length] = new Option(splits[0], splits[1]);
	}
	
}

//New form entry
function newentry()
{
	var form = $('#submitform');
	$('impreflastslno').val('');
	$('impactivitylastslno').val('');
	$('customizationlastslno').val('');
	$('#submitform')[0].reset();
}

//New form entry
function newhandholdentry()
{
	var form = $('#submitform');
	$('himpreflastslno').val('');
	$('impactivitylastslno').val('');
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
		var queryString = "../ajax/assignimplementation.php";
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
					var response = ajaxresponse;
					if(response['errorcode'] == '1')
					{
						implemenationstatus(response['slno']);
						$('#implastslno').val(response['slno']);
						$('#imp_statustype').html(response['implementationtype']);
						$('#imptype_remarks').html(response['impremarks']);
						$('#invoicedetails').html(response['invoicenumber']);
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
							//var filename = response[8].split('/');
						$('#attachement_raffilename').html(response['griddisplay']);
							//$('#attachement_raf').html('<a href=\''+ response[8] +'\' class = "r-text" style="text-decoration:none"> View &rsaquo;&rsaquo; </a>');
						$('#podate').html(response['podetails']);
						if(response['podetailspath'] != null)
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
						if(response['attendancefilepath'] == null)
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
							$('#customization_remarks').html('Not Available');
							$('#customizationdiv').hide();

						}
						else
						{
							$('#customization_remarks').html(response['customizationremarks']);
							$('#customizationdiv').show();

						}
						if(response['customizationreffilepath'] == null)
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
						if(response['customizationbackupfilepath'] == '')
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
						
						if(response['assignimplemenation'] != null)
						{
							$('#assigndays_imp').val(response['assignimplemenation']);
							$("#displayimplementername").html($("#assigndays_imp option:selected").text());
							$('#hiddenimplementerid').val($("#assigndays_imp option:selected").val());
							
							//$("#displayimplementername").html('Not Available');
						}
						else
						{
							$("#displayimplementername").html('Not Available')
						}

						if(response['assignhandholdimplementation'] != null)
						{
							$('#hassigndays_imp').val(response['assignhandholdimplementation']);
							$("#displayimpname").html($("#hassigndays_imp option:selected").text());
							$('#hiddenimpid').val($("#hassigndays_imp option:selected").val());
						}
						else
						{
							$("#displayimpname").html('Not Available')
						}
						
						//$('#customizer').val(response[41]);
						if(response['assigncustomization'] != null)
						{
							$('#customizer').val(response['assigncustomization']);
							$("#displaycustomizername").html($("#customizer option:selected").text());

						}
						else
						{
							$("#displaycustomizername").html('Not Available');
						}
						
						
						if(response['assignwebimplemenation'] != null)
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
						generatecustomizationgrid('');
						approvefunc();
						getfollowupsdetails(response['slno']);

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



function displayapprove()
{
	var paymenttype = $("input[name='decisiontype']:checked").val();
	
	if(paymenttype == 'reject')
	{
		$("#remarksdiv").show();
		$("#buttondiv").hide();
	}
	else
	{
		$("#buttondiv").show();
		$("#remarksdiv").hide();
	}
	
	
}

//select customer from the list
function selectfromlist()
{
	var selectbox = $('#customerlist');
	$('#detailsearchtext').val($("#customerlist option:selected").text());
	$('#detailsearchtext').select();
	customerdetailstoform(selectbox.val());
	customercontactdetailstoform(selectbox.val());
	enableformelemnts();
	resetvalue();
	newentry();
	$('#form-error1').html('');
	$('#form-error2').html('');
	$('#form-error3').html('');
	$('#form-error4').html('');
	$('#form-error5').html('');
	$('#form-error6').html('');
	$('#form-error7').html('');
	$('#form-error8').html('');
}

function selectacustomer(input)
{
	var selectbox = $('#customerlist');
	if(input == "")
	{
		getcustomerlist1();
	}
	else
	{
		$('option', selectbox).remove();
		var options = selectbox.attr('options');
		
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
				var result1 = pattern.test(trimdotspaces(customerarray[i]).toLowerCase());
				var result2 = pattern.test(customerarray[i].toLowerCase());
				if(result1 || result2)
				{
					var splits = customerarray[i].split("^");
					options[options.length] = new Option(splits[0], splits[1]);
					addedcount++;
					if(addedcount == 100)
						break;
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
		var form = $('#submitform');
		var input = $('#detailsearchtext').val();
		selectacustomer(input);
	}
}

function scrollcustomer(type)
{
	var selectbox = $('#customerlist');
	var totalcus = $("#customerlist option").length;
	var selectedcus = $("select#customerlist").attr('selectedIndex');
	if(type == 'up' && selectedcus != 0)
		$("select#customerlist").attr('selectedIndex', selectedcus - 1);
	else if(type == 'down' && selectedcus != totalcus)
		$("select#customerlist").attr('selectedIndex', selectedcus + 1);
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
		var queryString = "../ajax/assignimplementation.php";
		ajaxcall6 = $.ajax(
		{
			type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
			success: function(ajaxresponse,status)
			{	
					var response = ajaxresponse;
					if(response == 'Thinking to redirect')
					{
						window.location = "../logout.php";
						return false;
					}
					else if(response['errorcode'] == '1')
					{
						$('#customerid').val(response['slno']);
						$('#displaycustomerid').html(response['customerid']);
						$('#displaycompanyname').html('<strong>'+response['companyname']+'</strong>');
						$('#displaycontactperson').html(response['contactperson']);
						$('#displayaddress').html(response['address']);
						$('#displayphone').html(response['phone']);
						$('#displaycell').html(response['cell']);
						$('#displayemail').html(response['emailidplit']);
						$('#displayregion').html(response['region']);
						$('#displaybranch').html(response['branch']);
						if(response['businesstype'] == null)
							$('#displaytypeofcategory').html('Not Available');
						else
							$('#displaytypeofcategory').html(response['businesstype']);
						if(response['customertype'] == null)
							$('#displaytypeofcustomer').html('Not Available');
						else
							$('#displaytypeofcustomer').html(response['customertype']);
						$('#displaydealer').html(response['dealername']);
						$("#displaycustomerdetails").hide();
						$('#toggleimg1').attr('src',"../images/plus.jpg");
					} 
			}, 
			error: function(a,b)
			{
				$("#form-error").html(scripterror());
			}
		});
	}
}

//followups
function impfollowups()
{
	var form = $('#submitform');
	var error = $('#form-error4');
	var field = $("#DPC_followdate");
	if(!field.val()) {alert("Enter the Follow Up Date. "); field.focus(); return false; }
	var field = $("#followupremarks");
	if(!field.val()) {alert("Enter the Remarks. "); field.focus(); return false; }
	var field = $("#DPC_nxtfollowdate");
	if(!field.val()) {alert("Enter the Next Follow Up Date. "); field.focus(); return false; }

	var passData = "";
	passData =  "switchtype=impfollowups&implastslno=" + encodeURIComponent($('#implastslno').val()) + "&remarks=" + encodeURIComponent($('#followupremarks').val()) + "&DPC_nxtfollowdate=" + encodeURIComponent($('#DPC_nxtfollowdate').val()) + "&DPC_followdate=" + encodeURIComponent($('#DPC_followdate').val())  +  "&lastslno=" + encodeURIComponent($('#lastslno').val()) +   "&dummy=" + Math.floor(Math.random()*100000000);
	//alert(passData)
	var queryString = '../ajax/assignimplementation.php';
	error.html('<img src="../images/imax-loading-image.gif" border="0" />');
	ajaxcall7 = $.ajax(
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
			var response = ajaxresponse;
			if(response['errorcode'] == '1')
			{
				error.html('');
				alert(response['errormsg']);
				getfollowupsdetails($('#implastslno').val());
				newfollowupentry();
			}
			else
			{
				error.html(errormessage(response['errormsg']));
			}
		},
		error: function(a,b)
		{
			$("#form-error").html(scripterror());
		}
	});
}

function newfollowupentry()
{
	$('#DPC_followdate').val('');
	$('#followupremarks').val('');
	$('#DPC_nxtfollowdate').val('');
}

function getfollowupsdetails(implastslno)
{
	//alert('hi');
	var form = $('#submitform');
	var error = $('#form-error4');
	var passData = "";
	passData =  "switchtype=getfollowupsdetails&implastslno=" + encodeURIComponent($('#implastslno').val()) +   "&dummy=" + Math.floor(Math.random()*100000000);
	//alert(passData)
	var queryString = '../ajax/assignimplementation.php';
	error.html('<img src="../images/imax-loading-image.gif" border="0" />');
	ajaxcall7 = $.ajax(
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
			var response = ajaxresponse;
			if(response['errorcode'] == '1')
			{
				error.html('');
				var followupgrid = response['grid'];
				//alert(followupgrid);
				if(!followupgrid)
				{
					$('#displayfollowups').html('No datas found to be displayed.');
				}
				else
				{
					$("#displayfollowups").html(response['grid']);
				}
				//newfollowupentry();
			}
			else
			{
				error.html(errormessage(response['errormsg']));
			}
		},
		error: function(a,b)
		{
			$("#form-error").html(scripterror());
		}
	});
}

//save implementation assign days
function impassigndays(command) 
{
	var form = $('#submitform');
	var error = $('#form-error1');
	var field = $('#assigndays_imp');
	var assignDate = $("#DPC_attachfromdate1").val();
	if(!field.val()  && assignDate!=""){ error.html(errormessage("Please select an Implementer")); field.focus(); return false; }
	var assignedto = field.val();
	//alert(assignedto);
	var field = $('#impreflastslno');
	if((!field.val() || field.val() == "") && assignDate!=""){ error.html(errormessage("Select the details from the Grid. ")); field.focus(); return false; }
	else
	{
		var passData = "";
		if(command == 'save')
		{
			var field =$('#DPC_attachfromdate1');
			if(!field.val()) { error.html(errormessage("Enter the Date. ")); field.focus(); return false; }
			//var field = $('#assigndays_remarks');
			//if(!field.val()) { error.html(errormessage("Enter the Remarks. ")); field.focus(); return false; }
			if($('#halfdayflag').is(':checked') == true)var halfdayflag = 'yes'; else var halfdayflag = 'no';
			passData =  "switchtype=assigndayssave&implastslno=" + encodeURIComponent($('#implastslno').val()) + "&remarks=" + encodeURIComponent($('#assigndays_remarks').val()) + "&date=" + encodeURIComponent($('#DPC_attachfromdate1').val())  +  "&lastslno=" + encodeURIComponent($('#lastslno').val())+  "&impreflastslno=" + encodeURIComponent($('#impreflastslno').val()) +  "&halfdayflag=" + encodeURIComponent(halfdayflag)+ "&assignedto=" + encodeURIComponent(assignedto)+ "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
			
		}
		else
		{
			passData =  "switchtype=assigndaysdelete&impreflastslno=" + encodeURIComponent($('#impreflastslno').val()) + "&implastslno=" + encodeURIComponent($('#implastslno').val()) + "&dummy=" + Math.floor(Math.random()*10000000000);//alert(passData)
		}
		queryString = '../ajax/assignimplementation.php';
		error.html(getprocessingimage());
		ajaxcall7 = $.ajax(
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
				var response = ajaxresponse;
				if(response['errorcode'] == '1')
				{
					error.html(successmessage(response['errormsg']));
					assignimplementation('implementation','displayimplementername','assigndays_imp')
					$('#visitnumberdisplay').html('Not Avaliable');
					implemenationstatus($('#implastslno').val());
					newentry();
					generateassigndaysgrid('');
				}
				else
				{
					error.html(errormessage(response['errormsg']));
				}
			}, 
			error: function(a,b)
			{
				$("#form-error").html(scripterror());
			}
		});
	}
}

//save handhold implementation assign days
function hhimpassigndays(command) 
{
	var form = $('#submitform');
	var error = $('#form-error7');
	var field = $('#hassigndays_imp');
	var assignDate = $("#DPC_attachfromdate3").val();
	if(!field.val()  && assignDate!=""){ error.html(errormessage("Please select an Implementer")); field.focus(); return false; }
	var assignedto = field.val();
	//alert(assignedto);
	var field = $('#impreflastslno');
	if((!field.val() || field.val() == "") && assignDate!=""){ error.html(errormessage("Select the details from the Grid. ")); field.focus(); return false; }
	else
	{
		var passData = "";
		if(command == 'save')
		{
			var field =$('#DPC_attachfromdate3');
			if(!field.val()) { error.html(errormessage("Enter the Date. ")); field.focus(); return false; }

			var field = $('#imphandhold');
			if(!field.val()) { error.html(errormessage("Please select the Hanh Hold. ")); field.focus(); return false; }
		

			if($('#hhalfdayflag').is(':checked') == true)var halfdayflag = 'yes'; else var halfdayflag = 'no';
			passData =  "switchtype=hhassigndayssave&implastslno=" + encodeURIComponent($('#implastslno').val()) + "&remarks=" + encodeURIComponent($('#hassigndays_remarks').val()) + "&date=" + encodeURIComponent($('#DPC_attachfromdate3').val())  +  "&lastslno=" + encodeURIComponent($('#lastslno').val())+  "&impreflastslno=" + encodeURIComponent($('#impreflastslno').val()) +  "&halfdayflag=" + encodeURIComponent(halfdayflag)+ "&assignedto=" + encodeURIComponent(assignedto) +  "&imphandhold=" + encodeURIComponent($('#imphandhold').val()) + "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
			
		}
		else
		{
			passData =  "switchtype=hhassigndaysdelete&impreflastslno=" + encodeURIComponent($('#impreflastslno').val()) + "&implastslno=" + encodeURIComponent($('#implastslno').val()) + "&dummy=" + Math.floor(Math.random()*10000000000);//alert(passData)
		}
		queryString = '../ajax/assignimplementation.php';
		error.html(getprocessingimage());
		ajaxcall7 = $.ajax(
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
				var response = ajaxresponse;
				if(response['errorcode'] == '1')
				{
					error.html(successmessage(response['errormsg']));
					$('#hvisitnumberdisplay').html('Not Avaliable');
					implemenationstatus($('#implastslno').val());
					newentry();
					generateassigndaysgrid('');
				}
				else
				{
					error.html(errormessage(response['errormsg']));
				}
			}, 
			error: function(a,b)
			{
				$("#form-error").html(scripterror());
			}
		});
	}
}

function impassigndaysgridtoform(id,assignid='')
{
	if(id != '')
	{
		$('#customerselectionprocess').html('');
		var passData = "switchtype=impassigndaysgridtoform&impreflastslno=" + encodeURIComponent(id) + "&assigndays=" + encodeURIComponent($('#assigndays'+assignid).val()) + "&dummy=" + Math.floor(Math.random()*100032680100);
		$('#impreflastslno').val(id);
		$('#form-error1').html(getprocessingimage());
		var queryString = "../ajax/assignimplementation.php";
		ajaxcall8 = $.ajax(
		{
			type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
			success: function(ajaxresponse,status)
			{	
				$('#form-error1').html('');
				var response = ajaxresponse;//alert(response)
				if(response == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else if(response['errorcode'] == '1')
				{
					if(response['disableassigndate'] == null)
					{
						$('#DPC_attachfromdate1').removeAttr('disabled');
					}
					else
					{
						$('#DPC_attachfromdate1').attr('disabled','disabled');
					}
					if(response['visitedstartflag'] == 'no' )
					{
						enablesave('save');
						$('#halfdayflag').removeAttr('disabled');
					}
					else
					{
						disablesave('save');
						$('#halfdayflag').attr('disabled','disabled');
					}
					$('#assigndays_remarks').val(response['remarks']);
					autochecknew($('#halfdayflag'),response['halfdayflag']);
					if(response['assigndate'] != null)
						$('#DPC_attachfromdate1').val(response['assigndate']);
					else
						$('#DPC_attachfromdate1').val('');
					
					//alert(response['assignimplemenation']);
					$('#assigndays_imp').val(response['assignimplemenation']);
					$('#visitnumberdisplay').html(response['visitnumber']);
				}
				else if(response['errorcode'] == '2')
				{
					disablesave('save');
					return false;
				}
			}, 
			error: function(a,b)
			{
				$("#form-error1").html(scripterror());
			}
		});
	}
}

function hhimpassigndaysgridtoform(id,assignid='')
{
	if(id != '')
	{
		$('#customerselectionprocess').html('');
		var passData = "switchtype=hhimpassigndaysgridtoform&impreflastslno=" + encodeURIComponent(id) + "&assigndays=" + encodeURIComponent($('#assigndays'+assignid).val()) + "&dummy=" + Math.floor(Math.random()*100032680100);
		$('#impreflastslno').val(id);
		$('#form-error1').html(getprocessingimage());
		var queryString = "../ajax/assignimplementation.php";
		ajaxcall8 = $.ajax(
		{
			type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
			success: function(ajaxresponse,status)
			{	
				$('#form-error1').html('');
				var response = ajaxresponse;//alert(response)
				if(response == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else if(response['errorcode'] == '1')
				{
					if(response['disableassigndate'] == null)
					{
						$('#DPC_attachfromdate3').removeAttr('disabled');
					}
					else
					{
						$('#DPC_attachfromdate3').attr('disabled','disabled');
					}
					if(response['visitedstartflag'] == 'no' )
					{
						//enablesave('hsave');
						$('#hhalfdayflag').removeAttr('disabled');
					}
					else
					{
						//disablesave('save');
						$('#hhalfdayflag').attr('disabled','disabled');
					}
					$('#hassigndays_remarks').val(response['remarks']);
					autochecknew($('#halfdayflag'),response['halfdayflag']);
					if(response['assigndate'] != null)
						$('#DPC_attachfromdate3').val(response['assigndate']);
					else
						$('#DPC_attachfromdate3').val('');
					
					//alert(response['assignimplemenation']);
					$('#hassigndays_imp').val(response['assignimplemenation']);
					$('#hvisitnumberdisplay').html(response['visitnumber']);
					$('#imphandhold').val(response['handholdtype']);
				}
				else if(response['errorcode'] == '2')
				{
					//disablesave('save');
					return false;
				}
			}, 
			error: function(a,b)
			{
				$("#form-error1").html(scripterror());
			}
		});
	}
}

function generateassigndaysgrid(startlimit)
{
	var form = $("#submitform");
	var passData = "switchtype=generateassigndaysgrid&implastslno=" + encodeURIComponent($("#implastslno").val()) + "&startlimit=" + encodeURIComponent(startlimit)+ "&dummy=" + Math.floor(Math.random()*10054300000);
	$("#tabgroupgridc1_1").html(getprocessingimage());
	$("#tabgroupgridc1_5").html(getprocessingimage());	
	queryString = "../ajax/assignimplementation.php";
	ajaxcall9 = $.ajax(
	{
		type: "POST",url: queryString, data: passData, cache: false,
		success: function(ajaxresponse,status)
		{
		//	$("#form-error").html('');
			if(ajaxresponse == 'Thinking to redirect')
			{
				window.location = "../logout.php";
				return false;
			}
			else
			{
				var response = ajaxresponse.split('^');//alert(response[4])
				if(response[0] == '1')
				{
					if(response[4] == 0)
					{
						$('#save').attr('disabled',true);
						$('#save').removeClass('swiftchoicebutton');
						$('#save').addClass('swiftchoicebuttondisabled');
						document.getElementById("assign_link").onclick = new Function("addimplementation()");
						$('#assign_link').addClass('r-text');
					}
					else
					{
						$('#save').attr('disabled',false);
						$('#save').removeClass('swiftchoicebuttondisabled');
						$('#save').addClass('swiftchoicebutton');
						//$("#assign_link").attr("disabled", "disabled");
						//$('#assign_link').removeAttr('onclick');
						//$('#assign_link').removeClass('r-text');
					}

					if(response[5] == 0)
					{
						$('#hsave').attr('disabled',true);
						$('#hsave').removeClass('swiftchoicebutton');
						$('#hsave').addClass('swiftchoicebuttondisabled');
						document.getElementById("hassign_link").onclick = new Function("addimplementation('handhold')");
						$('#hassign_link').addClass('r-text');
					}
					else
					{
						$('#hsave').attr('disabled',false);
						$('#hsave').removeClass('swiftchoicebuttondisabled');
						$('#hsave').addClass('swiftchoicebutton');
					}
					$("#tabgroupgridc1_1").html(response[1]);
					$("#getmorerecordslink").html(response[2]);
					$("#tabgroupcount").html(response[3]);
					$("#tabgroupcount1").html(response[5]);
					$("#tabgroupgridc1_5").html(response[6]);

				}
			}
		}, 
		error: function(a,b)
		{
			$("#tabgroupgridc1_1").html(scripterror());
			$("#tabgroupgridc1_5").html(scripterror());
		}
	});	
}



/*function getmoreassigndaysgrid(startlimit,slno,showtype)
{
	if($("#dealerlist").val())
	{
		var form = $("#submitform");
		var passData = "type=generategrid&dealerid=" + encodeURIComponent($("#dealerlist").val()) + "&startlimit=" + encodeURIComponent(startlimit)+ "&slno=" + encodeURIComponent(slno)+ "&showtype=" + encodeURIComponent(showtype)  + "&dummy=" + Math.floor(Math.random()*1000782200000);
		var ajaxcall3 = createajax();
		$("#getmorerecordslink").html(getprocessingimage());	
		queryString = "../ajax/credits.php";
		ajaxcall3.open("POST", queryString, true);
		ajaxcall3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxcall3.onreadystatechange = function()
		{
			if(ajaxcall3.readyState == 4)
			{
				if(ajaxcall3.status == 200)
				{
					$("#form-error").html('');	
					var ajaxresponse = ajaxcall3.responseText;
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
							$("#resultgrid").html($("#tabgroupgridc1_1").html());
							$("#tabgroupgridc1_1").html($("#resultgrid").html().replace(/\<\/table\>/gi,'')+ response[1]);
							$("#getmorerecordslink").html(response[2]);
							$("#tabgroupcount").html('Total Count: ' + response[3]);
						}
						else
						{
							$("#form-error").html(errormessage('Unable to Connect...'));
						}
					}
				}
				else
					$("#form-error").html(errormessage('Connection Failed.'));
			}
		}
		ajaxcall3.send(passData);
	}
}*/

function getselectedvalue(innerhtml,selectid)
{
	var value = $("#"+selectid+" option:selected").text();
	var selectvalue = $("#"+selectid).val();
	if(!selectvalue)
	{
		$('#'+innerhtml).html('Not Available');
		$("#form-error1").html(errormessage('Please select an implementer')); return false;
	}
	else
	{
		$('#'+innerhtml).html(value);
		$("#form-error1").html('');
	}
}

//Assign implemenation
function assignimplementation(imptype,innerhtml,selectid)
{
	
	var form = $('#submitform');
	if(imptype == 'implementation')
	{
		var error = $('#displayimplementername');
		var field = $('#assigndays_imp');
		var assignedto = field.val();
		if(!field.val()) { alert("Select a implementer "); field.focus(); return false; }
		$('#hiddenimplementerid').val(assignedto);
	}
	else if(imptype == 'customization')
	{
		var error = $('#displaycustomizername');
		var field = $('#customizer');
		var assignedto = field.val();
		if(!field.val()) { alert("Select a customizer "); field.focus(); return false; }
	}
	else
	{
		var error = $('#displaywebimplementername');
		var field = $('#webimplementer');
		var assignedto = field.val();
		if(!field.val()) { alert("Select a Web Implementer "); field.focus(); return false; }
	}
		passData =  "switchtype=assigntask&implastslno=" + encodeURIComponent($('#implastslno').val())  + "&assignedto=" + encodeURIComponent(assignedto)+ "&imptype=" + encodeURIComponent(imptype)  + "&dummy=" + Math.floor(Math.random()*100000000);
		queryString = '../ajax/assignimplementation.php';
		error.html(getprocessingimage());
		ajaxcall10 = $.ajax(
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
				var response = ajaxresponse;
				if(response['errorcode'] == '1')
				{
					$('#'+innerhtml).html($("#"+selectid+" option:selected").text());
				}
				else
				{
					error.html(errormessage('Unable to connect....'));
				}
			}, 
		error: function(a,b)
		{
			error.html(scripterror());
		}
	});	
}

//save/delete handhold implementation assign days
function hhimpassignactivity(command)
{
	var form = $('#submitform');
	var error = $('#form-error8');
	
	var field = $('#hassignactivity');
	if(!field.val()) { error.html(errormessage("Enter an Activity. ")); field.focus(); return false; }
	var field = $('#hassignactivity_remarks');
	if(!field.val()) { error.html(errormessage("Enter the Remarks. ")); field.focus(); return false; }
	else
	{
		var passData = "";
		if(command == 'save')
		{
			passData =  "switchtype=hhassignactivitysave&impactivitylastslno=" + encodeURIComponent($('#impactivitylastslno').val()) + "&activity=" + encodeURIComponent($('#hassignactivity').val()) + "&remarks=" + encodeURIComponent($('#hassignactivity_remarks').val())  +  "&lastslno=" + encodeURIComponent($('#lastslno').val())+  "&implastslno=" + encodeURIComponent($('#implastslno').val())+ "&dummy=" + Math.floor(Math.random()*100000000);
			
		}
		else
		{
			passData =  "switchtype=hhassignactivitydelete&impactivitylastslno=" + encodeURIComponent($('#impactivitylastslno').val()) + "&lastslno=" + encodeURIComponent($('#lastslno').val()) + "&dummy=" + Math.floor(Math.random()*10000000000);
		}
		queryString = '../ajax/assignimplementation.php';
		error.html(getprocessingimage());
		ajaxcall11 = $.ajax(
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
				var response = ajaxresponse;
				if(response["errorcode"] == '1')
				{
					if(command == 'delete')
					{
						$('#impactivitylastslno').val('');
					}
					error.html(successmessage(response["errormsg"]));
					//$('#assign_link').removeAttr('onclick');
					//$('#assign_link').removeClass('r-text');
					newhandholdentry();
					generatehandholdactivitygrid();
				}
				else
				{
					error.html(errormessage(response["errormsg"]));
				}
			}, 
			error: function(a,b)
			{
				error.html(scripterror());
			}
		});	
			
	}
}

//save/delete implementation assign days
function impassignactivity(command)
{
	var form = $('#submitform');
	var error = $('#form-error2');
	
	var field = $('#assignactivity');
	if(!field.val()) { error.html(errormessage("Enter an Activity. ")); field.focus(); return false; }
	var field = $('#assignactivity_remarks');
	if(!field.val()) { error.html(errormessage("Enter the Remarks. ")); field.focus(); return false; }
	else
	{
		var passData = "";
		if(command == 'save')
		{
			passData =  "switchtype=assignactivitysave&impactivitylastslno=" + encodeURIComponent($('#impactivitylastslno').val()) + "&activity=" + encodeURIComponent($('#assignactivity').val()) + "&remarks=" + encodeURIComponent($('#assignactivity_remarks').val())  +  "&lastslno=" + encodeURIComponent($('#lastslno').val())+  "&implastslno=" + encodeURIComponent($('#implastslno').val())+ "&dummy=" + Math.floor(Math.random()*100000000);
			
		}
		else
		{
			passData =  "switchtype=assignactivitydelete&impactivitylastslno=" + encodeURIComponent($('#impactivitylastslno').val()) + "&lastslno=" + encodeURIComponent($('#lastslno').val()) + "&dummy=" + Math.floor(Math.random()*10000000000);
		}
		queryString = '../ajax/assignimplementation.php';
		error.html(getprocessingimage());
		ajaxcall11 = $.ajax(
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
				var response = ajaxresponse;
				if(response["errorcode"] == '1')
				{
					if(command == 'delete')
					{
						$('#impactivitylastslno').val('');
					}
					error.html(successmessage(response["errormsg"]));
					//$('#assign_link').removeAttr('onclick');
					//$('#assign_link').removeClass('r-text');
					newentry();
					generateactivitygrid('');
				}
				else
				{
					error.html(errormessage(response["errormsg"]));
				}
			}, 
			error: function(a,b)
			{
				error.html(scripterror());
			}
		});	
			
	}
}


//Activity grid
function generateactivitygrid(startlimit)
{
	var form = $("#submitform");
	var passData = "switchtype=generateactivitygrid&implastslno=" + encodeURIComponent($("#implastslno").val()) + "&startlimit=" + encodeURIComponent(startlimit)+ "&dummy=" + Math.floor(Math.random()*10054300000);
	$("#tabgroupgridc1_2").html(getprocessingimage())//;	alert(passData)
	queryString = "../ajax/assignimplementation.php";
	ajaxcall12 = $.ajax(
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
				var response = ajaxresponse.split('^');
				if(response[0] == '1')
				{
					$("#tabgroupgridc1_2").html(response[1]);
					$("#getmorerecordslink2").html(response[2]);
					$("#tabgroupcount2").html(response[3]);
					$('#impactivitylastslno').val('');
				}
				else
				{
					$("#tabgroupgridc1_2").html(errormessage('Unable to Connect...' ));
				}
			}
		}, 
		error: function(a,b)
		{
			$("#tabgroupgridc1_2").html(scripterror());
		}
	});	;
}

function generatehandholdactivitygrid()
{
	var form = $("#submitform");
	var passData = "switchtype=generatehandholdactivitygrid&implastslno=" + encodeURIComponent($("#implastslno").val()) + "&dummy=" + Math.floor(Math.random()*10054300000);
	$("#tabgroupgridc1_6").html(getprocessingimage());	//alert(passData)
	queryString = "../ajax/assignimplementation.php";
	ajaxcall12 = $.ajax(
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
				var response = ajaxresponse.split('^');
				if(response[0] == '1')
				{
					$("#tabgroupgridc1_6").html(response[1]);
					$("#tabgroupcount3").html(response[2]);
					$('#impactivitylastslno').val('');
				}
				else
				{
					$("#tabgroupgridc1_6").html(errormessage('Unable to Connect...' ));
				}
			}
		}, 
		error: function(a,b)
		{
			$("#tabgroupgridc1_6").html(scripterror());
		}
	});	;
}


/*function getmoreactivitygrid(startlimit,slno,showtype)
{
	if($("#dealerlist").val())
	{
		var form = $("#submitform");
		var passData = "type=generategrid&dealerid=" + encodeURIComponent($("#dealerlist").val()) + "&startlimit=" + encodeURIComponent(startlimit)+ "&slno=" + encodeURIComponent(slno)+ "&showtype=" + encodeURIComponent(showtype)  + "&dummy=" + Math.floor(Math.random()*1000782200000);
		var ajaxcall3 = createajax();
		$("#getmorerecordslink").html(getprocessingimage());	
		queryString = "../ajax/credits.php";
		ajaxcall3.open("POST", queryString, true);
		ajaxcall3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxcall3.onreadystatechange = function()
		{
			if(ajaxcall3.readyState == 4)
			{
				if(ajaxcall3.status == 200)
				{
					$("#form-error").html('');	
					var ajaxresponse = ajaxcall3.responseText;
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
							$("#resultgrid").html($("#tabgroupgridc1_1").html());
							$("#tabgroupgridc1_1").html($("#resultgrid").html().replace(/\<\/table\>/gi,'')+ response[1]);
							$("#getmorerecordslink").html(response[2]);
							$("#tabgroupcount").html('Total Count: ' + response[3]);
						}
						else
						{
							$("#form-error").html(errormessage('Unable to Connect...'));
						}
					}
				}
				else
					$("#form-error").html(errormessage('Connection Failed.'));
			}
		}
		ajaxcall3.send(passData);
	}
}
*/

function impactivitygridtoform(id)
{
	if(id != '')
	{
		$('#customerselectionprocess').html('');
		var passData = "switchtype=impactivitygridtoform&impactivitylastslno=" + encodeURIComponent(id) + "&dummy=" + Math.floor(Math.random()*100032680100);
		$('#impactivitylastslno').val(id);
		$('#form-error2').html(getprocessingimage());
		var queryString = "../ajax/assignimplementation.php";
		ajaxcall13 = $.ajax(
		{
			type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
			success: function(ajaxresponse,status)
			{
					$('#form-error2').html('');
					var response = (ajaxresponse);
					if(response == 'Thinking to redirect')
					{
						window.location = "../logout.php";
						return false;
					}
					else if(response['errorcode'] == '1')
					{
						$('#assignactivity').val(response['activity']);
						$('#assignactivity_remarks').val(response['remarks']);
					} 
			}, 
		error: function(a,b)
		{
			$("#form-error2").html(scripterror());
		}
		});	
	}
}

function hhimpactivitygridtoform(id)
{
	if(id != '')
	{
		$('#customerselectionprocess').html('');
		var passData = "switchtype=hhimpactivitygridtoform&impactivitylastslno=" + encodeURIComponent(id) + "&dummy=" + Math.floor(Math.random()*100032680100);
		$('#impactivitylastslno').val(id);
		$('#form-error2').html(getprocessingimage());
		var queryString = "../ajax/assignimplementation.php";
		ajaxcall13 = $.ajax(
		{
			type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
			success: function(ajaxresponse,status)
			{
					$('#form-error2').html('');
					var response = (ajaxresponse);
					if(response == 'Thinking to redirect')
					{
						window.location = "../logout.php";
						return false;
					}
					else if(response['errorcode'] == '1')
					{
						$('#hassignactivity').val(response['activity']);
						$('#hassignactivity_remarks').val(response['remarks']);
					} 
			}, 
		error: function(a,b)
		{
			$("#form-error2").html(scripterror());
		}
		});	
	}
}

//save/delete customization
function assigncustomization(command)
{
	var form = $('#submitform');
	var error = $('#form-error3');
	var field = $('#DPC_attachfromdate2');
	if(!field.val()) { error.html(errormessage("Enter the Date. ")); field.focus(); return false; }
	var field = $('#customizer_remarks');
	if(!field.val()) { error.html(errormessage("Enter the Remarks. ")); field.focus(); return false; }
	else
	{
		var passData = "";
		if(command == 'save')
		{
			passData =  "switchtype=customizationsave&implastslno=" + encodeURIComponent($('#implastslno').val()) + "&remarks=" + encodeURIComponent($('#customizer_remarks').val()) + "&date=" + encodeURIComponent($('#DPC_attachfromdate2').val())  +  "&lastslno=" + encodeURIComponent($('#lastslno').val())+  "&customizationlastslno=" + encodeURIComponent($('#customizationlastslno').val())+ "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
			
		}
		else
		{
			passData =  "switchtype=customizationdelete&customizationlastslno=" + encodeURIComponent($('#customizationlastslno').val()) + "&lastslno=" + encodeURIComponent($('#lastslno').val()) + "&dummy=" + Math.floor(Math.random()*10000000000);
		}
		queryString = '../ajax/assignimplementation.php';
		error.html(getprocessingimage());
		ajaxcall14 = $.ajax(
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
				var response = ajaxresponse;
				if(response['errorcode'] == '1')
				{
					error.html(successmessage(response['errormsg']));
					newentry();
					//generatecustomization('');
					generatecustomizationgrid('');
				}
				else
				{
					error.html(errormessage('Unable to connect....'));
				}
			}, 
			error: function(a,b)
			{
				error.html(scripterror());
			}
		});	
				
	}
}

//customization grid to form
function customizationgridtoform(id)
{
	if(id != '')
	{
		$('#customerselectionprocess').html('');
		var passData = "switchtype=customizationgridtoform&customizationlastslno=" + encodeURIComponent(id) + "&dummy=" + Math.floor(Math.random()*100032680100);
		$('#customizationlastslno').val(id);
		$('#form-error3').html(getprocessingimage());
		var queryString = "../ajax/assignimplementation.php";
		ajaxcall15 = $.ajax(
		{
			type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
			success: function(ajaxresponse,status)
			{	
					$('#form-error3').html('');
					var response = ajaxresponse;
					if(response == 'Thinking to redirect')
					{
						window.location = "../logout.php";
						return false;
					}
					else if(response['errorcode'] == '1')
					{
						$('#customizer_remarks').val(response['remarks']);
						$('#DPC_attachfromdate2').val(response['assigneddate']);
					} 
			}, 
			error: function(a,b)
			{
				$('#form-error3').html(scripterror());
			}
		});	
	}
}

function getinvoicedetails(rslno)
{
	var form = $('#submitform');
	var passData = "switchtype=invoicedetailsgrid&rslno=" + encodeURIComponent(rslno) + "&dummy=" + Math.floor(Math.random()*100032680100);//alert(passData)
	var queryString = "../ajax/assignimplementation.php";
	ajaxcall16 = $.ajax(
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
			if(response['errorcode'] == '1')
			{
				$("#invoicedetailsgrid tr").remove();
				var row = '<tr><td>'+ response['grid']+'</td></tr>';
				$("#invoicedetailsgrid ").append(row);
			}
		},
		error: function(a,b)
		{
			$('#form-error').html(scripterror());
		}
	});		
}

function updatestatus(command)
{
	var form = $('#'+'submitform');
	if(command == 'approve')
	{
		var submitform = $('#colorform1');
		var field = $('#appremarks');
		if(!field.val()) {alert("Enter the Approval Remarks. "); field.focus(); return false; }
		var passData = "switchtype=updateapprove&lastslno=" + encodeURIComponent($('#customerlist').val(),form)+"&appremarks=" + encodeURIComponent($('#appremarks').val()) +"&implastslno=" + encodeURIComponent($('#implastslno').val(),form) + "&dummy=" + Math.floor(Math.random()*100032680100);//alert(passData)
		$('#form-error5').html(getprocessingimage());
		$('#approveremarks').attr('disabled',true);
		$('#approveremarks').removeClass('swiftchoicebutton');
		$('#approveremarks').addClass('swiftchoicebuttondisabled');
		
	}
	else if(command== 'reject')
	{
		var submitform = $('#colorform2');
		var field = $('#rejremarks');
		if(!field.val()) {alert("Enter the Reject Remarks. "); field.focus(); return false; }
		var confirmation = confirm("Are you sure you want to Reject the implementation requested?");
		if(confirmation)
		{
			var passData = "switchtype=updatereject&lastslno=" + encodeURIComponent($('#customerlist').val(),form) +"&rejremarks=" + encodeURIComponent($('#rejremarks').val()) +"&implastslno=" + encodeURIComponent($('#implastslno').val(),form) +  "&dummy=" + Math.floor(Math.random()*100032680100);//alert(passData)
			$('#form-error6').html(getprocessingimage());
			$('#rejectremarks').attr('disabled',true);
			$('#rejectremarks').removeClass('swiftchoicebutton');
			$('#rejectremarks').addClass('swiftchoicebuttondisabled');
			
		}
		else
		return false;
	}
	//$('#form-error').html(getprocessingimage());
	var queryString = "../ajax/assignimplementation.php";
	ajaxcall17 = $.ajax(
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
			if(response['errorcode'] == '1')
			{
				$('#form-error5').html('');
				$('#displaydiv1').show();
				$('#displaydiv3').show();
				$('#displaydiv5').show();
				generateactivitygrid('');
				generateassigndaysgrid('');
				resetvalue();
				$('#displaydiv2').hide();
				$('#displaydiv4').hide();
				$('#displaydiv6').hide();
				$('#displaybutton').hide();
				$('#displaymessage').show();
				$('#displaystatus').html('Approved');
				implemenationstatus($('#implastslno').val(),form);
				$().colorbox.close();
			}
			else if(response['errorcode'] == '2')
			{
				$('#form-error6').html('');
				$('#displaydiv2').hide();
				$('#displaydiv4').hide();
				$('#displaydiv6').hide();
				generateassigndaysgrid('');
				resetvalue();
				generateactivitygrid('');
				$('#displaydiv1').show();
				$('#displaydiv3').show();
				$('#displaydiv5').show();
				$('#displaybutton').hide();
				$('#displaymessage').show();
				$('#displaystatus').html('Rejected');
				implemenationstatus($('#implastslno').val(),form);
				$().colorbox.close();
			}
				
		}, 
		error: function(a,b)
		{
			$('#form-error').html(scripterror());
		}
	});	
}

function approvefunc()
{
	var form = $('#submitform');
	var passData = "switchtype=approvediv&lastslno=" + encodeURIComponent($('#customerlist').val()) + "&dummy=" + Math.floor(Math.random()*100032680100);//alert(passData)
	var queryString = "../ajax/assignimplementation.php";
	ajaxcall18 = $.ajax(
	{
		type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
		success: function(ajaxresponse,status)
		{	
			var response = ajaxresponse;
			if(response == 'Thinking to redirect')
			{
				window.location = "../logout.php";
				return false;
			}
			if(response['errorcode'] == '2')
			{
				$("#displaydiv2").hide();
				$("#displaydiv4").hide();
				$("#displaydiv6").hide();

				$("#displaydiv1").show();
				$("#displaydiv3").show();
				$("#displaydiv5").show();
				
			}
			else if(response['errorcode'] == '1')
			{
				$('#displaydiv1').show();
				$('#displaydiv3').show();
				$('#displaydiv5').show();

				$("#displaydiv2").hide();
				$("#displaydiv4").hide();
				$("#displaydiv6").hide();
				generateassigndaysgrid('');
				generateactivitygrid('');
				generatecustomization('');generatecustomizationgrid('');generatehandholdactivitygrid();
				
			}
		}, 
		error: function(a,b)
		{
			error.html(scripterror());
		}
	});	
				
		
}

//Assign implemenation
function addimplementation(imptype='')
{
	var form = $('#submitform');
	var error = $('#form-error1');
	
	
	if(imptype == 'handhold')
	{
		var field = $("#hassign_days");
	
		if(!field.val()) {alert("Enter the Number of Days. "); field.focus(); return false; }
		var field = $("#hassign_days");
		if(field.val()) { if(!validatenoofdays(field.val())) { alert('Enter the valid number of days.'); field.focus(); return false; }}
		var passData =  "switchtype=handholddaysassign&implastslno=" + encodeURIComponent($('#implastslno').val()) +  "&impreflastslno=" + encodeURIComponent($('#impreflastslno').val())+  "&hassign_days=" + encodeURIComponent($('#hassign_days').val()) + "&dummy=" + Math.floor(Math.random()*100000000);	//alert(passData)
	}
	else
	{
		var field = $("#assign_days");
	
		if(!field.val()) {alert("Enter the Number of Days. "); field.focus(); return false; }
		var field = $("#assign_days");
		if(field.val()) { if(!validatenoofdays(field.val())) { alert('Enter the valid number of days.'); field.focus(); return false; }}
		var passData =  "switchtype=daysassign&implastslno=" + encodeURIComponent($('#implastslno').val()) +  "&impreflastslno=" + encodeURIComponent($('#impreflastslno').val())+  "&assign_days=" + encodeURIComponent($('#assign_days').val()) + "&dummy=" + Math.floor(Math.random()*100000000);	//alert(passData)
	}
	queryString = '../ajax/assignimplementation.php';
	error.html(getprocessingimage());
	ajaxcall19 = $.ajax(
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
			var response = ajaxresponse;
			if(response['errorcode'] == '1')
			{
				error.html(successmessage(response['errormsg']));
				newentry();
				generateassigndaysgrid('');
			}
			else
			{
				alert("Hand Hold cannot be processed before implementation gets completed!");
			}
		}, 
		error: function(a,b)
		{
			error.html(scripterror());
		}
	});			
			
}

function validaterequest(command)
{
	
	if(command == 'approve')
	{
		$("").colorbox({ inline:true, href:"#inline_example1", onLoad: function() { $('#cboxClose').hide()}});
		$('#appremarks').val('');
		$('#approveremarks').attr('disabled',false);
		$('#approveremarks').addClass('swiftchoicebutton');
		$('#approveremarks').removeClass('swiftchoicebuttondisabled');
	}
	else if(command == 'reject')
	{
		$("").colorbox({ inline:true, href:"#inline_example2", onLoad: function() { $('#cboxClose').hide()}});
		$('#rejremarks').val('');
		$('#rejectremarks').attr('disabled',false);
		$('#rejectremarks').addClass('swiftchoicebutton');
		$('#rejectremarks').removeClass('swiftchoicebuttondisabled');
	}
}

function implemenationstatus(lastslno)
{
	var form = $('#submitform');
	var passData =  "switchtype=implemenationstatus&lastslno=" + encodeURIComponent(lastslno) + "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
	
	queryString = '../ajax/assignimplementation.php';
	ajaxcall20 = $.ajax(
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
			var response = ajaxresponse;//alert(response)
			if(response['errorcode'] == '1')
			{
				if(response['branchapproval'] == 'no' && response['coordinatorreject'] == 'no' && response['coordinatorapproval'] == 'no' && response['implementationstatus'] == 'pending')
				{
					$("#implementationid").html('Awaiting Branch Head Approval.');
					$('#assigndiv').hide();
					$('#advdisplay').hide();
					$('#remarksname').html('');
					$('#implementationremarks').val('');
					
				}
				else if(response['branchreject'] == 'yes'  && response['branchapproval'] == 'no' && response['implementationstatus'] == 'pending')
				{
					$("#implementationid").html('Fowarded back to Sales Person.');
					$('#assigndiv').hide();
					$('#advdisplay').hide();
					$('#remarksname').html('Branch Head Rejected Remarks:');
					$('#implementationremarks').html(response['branchrejectremarks']);
					// $('#processeddate').html('Date:');
					// $('#approverejectdate').html(response['branchrejectdatetime']);
					
				}
				else if(response['branchapproval'] == 'yes'  && response['coordinatorreject'] == 'no' && response['coordinatorapproval'] == 'no' && response['implementationstatus'] == 'pending')
				{
					$("#implementationid").html('Awaiting Co-ordinator Approval.');
					$('#assigndiv').hide();
					$('#remarksname').html('Branch Head Remarks:');
					$('#implementationremarks').html(response['branchremarks']);
					$('#processeddate').html('Date:');
					$('#approverejectdate').html(response['branchapprovaldatetime']);
					if(response['advancecollected'] == 'no')
					{
						$('#advdisplay').show();
						$('#advremarksid').html(response['advancesnotcollectedremarks']);
					}
					else
					{
						$('#advdisplay').hide();
					}
				}
				else if(response['branchapproval'] == 'no' && response['coordinatorreject'] == 'yes' && response['coordinatorapproval'] == 'no' && response['implementationstatus'] == 'pending')
				{
					$("#implementationid").html('Fowarded back to Branch Head.');
					$('#assigndiv').hide();
					$('#advdisplay').hide();
					$('#remarksname').html('Co-ordinator Reject Remarks:');
					$('#implementationremarks').html(response['coordinatorrejectremarks']);
					// $('#processeddate').html('Date:');
					// $('#approverejectdate').html(response['coordinatorrejectdatetime']);
				}
				else if(response['branchapproval'] == 'yes' && response['coordinatorreject'] == 'no'  && response['coordinatorapproval'] == 'yes' && response['implementationstatus'] == 'pending' )
				{
					$("#implementationid").html('Implementation, Yet to be Assigned.');
					$('#assigndiv').hide();
					$('#advdisplay').hide();
					$('#remarksname').html('Co-ordinator Approval Remarks:');
					$('#implementationremarks').html(response['coordinatorapprovalremarks']);
					$('#processeddate').html('Date:');
					$('#approverejectdate').html(response['coordinatorappdatetime']);
				}
				else if(response['branchapproval'] == 'yes' && response['coordinatorreject'] == 'no'  && response['coordinatorapproval'] == 'yes' && response['implementationstatus'] == 'assigned' )
				{
					$("#implementationid").html('Assigned For Implementation.');
					$('#assigndiv').show();
					$('#advdisplay').hide();
					$('#assignid').val(response['tablegrid']);
					$('#remarksname').html('');
					$('#implementationremarks').html('');
				}
				else if(response['branchapproval'] == 'yes' && response['coordinatorreject'] == 'no'  && response['coordinatorapproval'] == 'yes' && response['implementationstatus'] == 'progess' )
				{
					$("#implementationid").html('Implementation in progess.');
					$('#assigndiv').hide();
					$('#advdisplay').hide();
					$('#remarksname').html('');
					$('#implementationremarks').html('');
				}
				else if(response['branchapproval'] == 'yes' && response['coordinatorreject'] == 'no'  && response['coordinatorapproval'] == 'yes' && response['implementationstatus'] == 'completed' )
				{
					$("#implementationid").html('Implementation Completed.');
					$('#assigndiv').hide();
					$('#advdisplay').hide();
					$('#remarksname').html('');
					$('#implementationremarks').html('');
					disablesave('save');disablesave('delete');disablesave('new2');disablesave('save2');disablesave('delete2');
					disablesave('new3');disablesave('save3');disablesave('delete3');
				}

			}
		}, 
		error: function(a,b)
		{
			error.html(scripterror());
		}
	});	
}

function tooltip()
{
	if (ns6||ie) 
	{
		tipobj.style.display="block";
		tipobj.html($('#assignid').val()); 
		enabletip=true;
		return false;
	}
	
}

function resetvalue()
{
	$('#save').attr('disabled',false);
	$('#save').removeClass('swiftchoicebuttondisabled');
	$('#save').addClass('swiftchoicebutton');
	
	$('#delete').attr('disabled',false);
	$('#delete').removeClass('swiftchoicebuttondisabled');
	$('#delete').addClass('swiftchoicebutton');
	$('#new2').attr('disabled',false);
	$('#new2').removeClass('swiftchoicebuttondisabled');
	$('#new2').addClass('swiftchoicebutton');
	$('#save2').attr('disabled',false);
	$('#save2').removeClass('swiftchoicebuttondisabled');
	$('#save2').addClass('swiftchoicebutton');
	
	$('#delete2').attr('disabled',false);
	$('#delete2').removeClass('swiftchoicebuttondisabled');
	$('#delete2').addClass('swiftchoicebutton');


	$('#new4').attr('disabled',false);
	$('#new4').removeClass('swiftchoicebuttondisabled');
	$('#new4').addClass('swiftchoicebutton');
	$('#save4').attr('disabled',false);
	$('#save4').removeClass('swiftchoicebuttondisabled');
	$('#save4').addClass('swiftchoicebutton');
	
	$('#delete4').attr('disabled',false);
	$('#delete4').removeClass('swiftchoicebuttondisabled');
	$('#delete4').addClass('swiftchoicebutton');
}


function viewfilepath(filepath)
{
	if(filepath != '')
		$('#filepath').val(filepath);
		
	var form = $('#submitform');	
	$('#submitform').attr("action", "../ajax/downloadfile.php?id=1") ;
	//$('#submitform').attr( 'target', '_blank' );
	$('#submitform').submit();
}


function sendemailonupdate(type,impid="",handholdslno="")
{
	if(type == 'assignedimplementer')
	{
		// if($('#displayimplementername').html() == '' || $('#displayimplementername').html() == 'Not Available')
		// {
		// 	alert('Select an Implementer');
		// 	$('#assigndays_imp').focus();
		// }
		// else
		// {
			var msg = confirm('Are you sure to send email??');
			if(msg)
			{
				//alert(impid);
				var getimpslno = $('#getslno'+handholdslno).val();
				$('#impprocess'+handholdslno).show();
				$('#sendimpemail'+handholdslno).hide();
				$('#impprocess'+handholdslno).html(getprocessingimage());
				//$('#sendemail1').html(getprocessingimage());
				// var passData =  "switchtype=sendmailonupdate&type="+type+"&lastslno=" + encodeURIComponent($('#lastslno').val()) +"&implementerid="+encodeURIComponent($('#hiddenimplementerid').val()) + "&getimpslno=" + encodeURIComponent(getimpslno) + "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
				var passData =  "switchtype=sendmailonupdate&type="+type+"&lastslno=" + encodeURIComponent($('#lastslno').val()) + "&implastslno=" + encodeURIComponent($('#implastslno').val()) +"&implementerid="+encodeURIComponent(impid) + "&getimpslno=" + encodeURIComponent(getimpslno) + "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
				queryString = '../ajax/assignimplementation.php';
				ajaxcall21 = $.ajax(
				{
					type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
					success: function(ajaxresponse,status)
					{	
						$('#impprocess'+handholdslno).hide();
						$('#sendimpemail'+handholdslno).show();
						//$('#sendemail1').html('<a class="r-text" onclick="sendemailonupdate(\''+type+'\')">Send Email &#8250;&#8250; </a>');
						alert(ajaxresponse['errormsg']);						
					}, 
					error: function(a,b)
					{
						$('#impprocess').html(scripterror());
					}
				});		
			}
			else
				return false;
		//}
	}
	else if(type == 'assignednoofdays')
	{
		var msg = confirm('Are you sure to send email??');
		if(msg)
		{
			$('#sendemail2').html(getprocessingimage());
			var passData =  "switchtype=sendmailonupdate&type="+type+"&lastslno=" + encodeURIComponent($('#lastslno').val()) +"&noofdays="+encodeURIComponent($('#assign_days').val())+"&implementerid="+encodeURIComponent($('#hiddenimplementerid').val())+ "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
			queryString = '../ajax/assignimplementation.php'; 
			ajaxcall22 = $.ajax(
			{
				type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
				success: function(ajaxresponse,status)
				{	
						$('#sendemail2').html('<a class="r-text" onclick="sendemailonupdate(\''+type+'\')">Send Email &#8250;&#8250; </a>');
						alert(ajaxresponse['errormsg']);			
				}, 
				error: function(a,b)
				{
					$('#sendemail2').html(scripterror());
				}
			});				
		}
		else
		{
			return false;
		}
	}
	else if(type == 'assignedactivities')
	{
		var msg = confirm('Are you sure to send email??');
		if(msg)
		{
			$('#sendemail3').html(getprocessingimage());
			var passData =  "switchtype=sendmailonupdate&type="+type+"&lastslno=" + encodeURIComponent($('#lastslno').val()) +"&noofdays="+encodeURIComponent($('#assign_days').val())+"&implementerid="+encodeURIComponent($('#hiddenimplementerid').val())+ "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
			queryString = '../ajax/assignimplementation.php'; //alert(passData);
			ajaxcall23 = $.ajax(
			{
				type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
				success: function(ajaxresponse,status)
				{	
						$('#sendemail3').html('<a class="r-text" onclick="sendemailonupdate(\''+type+'\')">Send Email &#8250;&#8250; </a>');
						alert(ajaxresponse['errormsg']);			
					}, 
				error: function(a,b)
				{
					$('#sendemail3').html(scripterror());
				}
			});				
		}
		else
		{
			return false;
		}
	}
}

function sendhandholdemailonupdate(type,impid="",handholdslno="")
{
	if(type == 'assignednoofdays')
	{
		var msg = confirm('Are you sure to send email??');
		if(msg)
		{
			$('#sendemail5').html(getprocessingimage());
			var passData =  "switchtype=sendhandholdmailonupdate&type="+type+"&lastslno=" + encodeURIComponent($('#lastslno').val()) +"&noofdays="+encodeURIComponent($('#hassign_days').val())+"&implementerid="+encodeURIComponent($('#hiddenimpid').val()) + "&implastslno=" + encodeURIComponent($('#implastslno').val())+ "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
			queryString = '../ajax/assignimplementation.php'; 
			ajaxcall22 = $.ajax(
			{
				type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
				success: function(ajaxresponse,status)
				{	
						$('#sendemail5').html('<a class="r-text" onclick="sendhandholdemailonupdate(\''+type+'\')">Send Email &#8250;&#8250; </a>');
						alert(ajaxresponse['errormsg']);			
				}, 
				error: function(a,b)
				{
					$('#sendemail5').html(scripterror());
				}
			});				
		}
		else
		{
			return false;
		}
	}
	else if(type == 'assignedactivities')
	{
		var msg = confirm('Are you sure to send email??');
		if(msg)
		{
			$('#sendemail6').html(getprocessingimage());
			var passData =  "switchtype=sendhandholdmailonupdate&type="+type+"&lastslno=" + encodeURIComponent($('#lastslno').val()) +"&noofdays="+encodeURIComponent($('#hassign_days').val())+"&implementerid="+encodeURIComponent($('#hiddenimpid').val()) + "&implastslno=" + encodeURIComponent($('#implastslno').val()) + "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
			queryString = '../ajax/assignimplementation.php'; //alert(passData);
			ajaxcall23 = $.ajax(
			{
				type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
				success: function(ajaxresponse,status)
				{	
						$('#sendemail6').html('<a class="r-text" onclick="sendhandholdemailonupdate(\''+type+'\')">Send Email &#8250;&#8250; </a>');
						alert(ajaxresponse['errormsg']);			
					}, 
				error: function(a,b)
				{
					$('#sendemail6').html(scripterror());
				}
			});				
		}
		else
		{
			return false;
		}
	}
	else if(type == 'assignedhandholdimplementer')
	{
		//alert('#sendimpemail'+handholdslno);
		var msg = confirm('Are you sure to send email??');
		if(msg)
		{
			var getimpslno = $('#gethandholdslno'+handholdslno).val();
			$('#imphandholdprocess'+handholdslno).show();
			$('#sendhandholdimpemail'+handholdslno).hide();
			$('#imphandholdprocess'+handholdslno).html(getprocessingimage());	
			var passData =  "switchtype=sendhandholdmailonupdate&type="+type+"&lastslno=" + encodeURIComponent($('#lastslno').val()) +"&implementerid="+encodeURIComponent(impid) + "&implastslno=" + encodeURIComponent($('#implastslno').val()) + "&getimpslno=" + encodeURIComponent(getimpslno) + "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
			queryString = '../ajax/assignimplementation.php'; 
			ajaxcall22 = $.ajax(
			{
				type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
				success: function(ajaxresponse,status)
				{	
					$('#imphandholdprocess'+handholdslno).hide();
					$('#sendhandholdimpemail'+handholdslno).show();
					alert(ajaxresponse['errormsg']);			
				}, 
				error: function(a,b)
				{
					$('#imphandholdprocess').html(scripterror());
				}
			});				
		}
		else
		{
			return false;
		}
	}
}


function generatecustomization(startlimit)
{
	var form = $("#submitform");
	var passData = "switchtype=customizationgrid&imprslno="+ encodeURIComponent($('#implastslno').val())+ "&startlimit=" + encodeURIComponent(startlimit);//alert(passData)
	var queryString = "../ajax/assignimplementation.php";
	$('#form-error').html(getprocessingimage());
	ajaxcall24 = $.ajax(
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
				var response = ajaxresponse.split('^');
				if(response[0] == '1')
				{
					$('#tabgroupgridc1_3').html(response[1]);
					$('#tabgroupgridc3link').html(response[2]);
				}
				else if(response[0] == '2')
				{
					$('#tabgroupgridc1_3').html(scripterror());
				}
			}
				
		}, 
		error: function(a,b)
		{
			$('#form-error').html(scripterror());
		}
	});	
}


function getmorecustomerregistration(startlimit,slno,showtype)
{
	var form = $('#submitform');
	var passData = "switchtype=customizationgrid&imprslno="+ encodeURIComponent($('#implastslno').val()) + "&startlimit=" + startlimit+ "&slno=" + slno+ "&showtype=" + encodeURIComponent(showtype)  + "&dummy=" + Math.floor(Math.random()*1000782200000);
//alert(passData);
	var queryString = "../ajax/assignimplementation.php";
	$('#form-error').html(getprocessingimage());
	ajaxcall25 = $.ajax(
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
				var response = ajaxresponse.split('^');//alert(response)
				if(response[0] == '1')
				{
					$('#form-error').html('');
					$('#regresultgrid3').html($('#tabgroupgridc1_3').html());
					$('#tabgroupgridc1_3').html($('#regresultgrid3').html().replace(/\<\/table\>/gi,'')+ response[1]) ;
					$('#tabgroupgridc3link').html(response[2]);
				}
				else
				if(response[0] == '2')
				{
					$('#tabgroupgridc1_3').html(scripterror());
				}
			}
				
		}, 
		error: function(a,b)
		{
			$('#form-error').html(scripterror());
		}
	});	
}

function disablestatus()
{
	var hhstatus = $('#imp_hhstatus').val();
	var handhold = $('#handhold').val();
	if(hhstatus!= "" || handhold!="")
	{
		$('#imp_status').val('');
		$('#imp_status').attr('disabled',true).css('background-color', 'grey');
	}
	else
		$('#imp_status').attr('disabled',false).css('background-color', '');
}

function searchbystatus()
{
	var form = $("#filterform");
	var passData =  "switchtype=filtercustomerlist&impsearch=" + encodeURIComponent($('#imp_status').val())+ "&imphhsearch=" + encodeURIComponent($('#imp_hhstatus').val()) + "&imphandhold=" + encodeURIComponent($('#handhold').val())+ "&dummy=" + Math.floor(Math.random()*100000000);//alert(passData)
	$('#customerselectionprocess').html(getprocessingimage());
	queryString = "../ajax/assignimplementation.php";
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
			$('#customerselectionprocess').html(scripterror());
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

function generatecustomizationgrid(startlimit)
{
	var form = $("#submitform");
	var passData = "switchtype=customizationassigngrid&imprslno="+ encodeURIComponent($('#implastslno').val())+ "&startlimit=" + encodeURIComponent(startlimit);//alert(passData)
	var queryString = "../ajax/assignimplementation.php";
	$('#form-error').html(getprocessingimage());
	ajaxcall241 = $.ajax(
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
				var response = ajaxresponse.split('^');
				if(response[0] == '1')
				{
					$('#tabgroupgridc1_4').html(response[1]);
					$('#tabgroupcount4').html(response[2]);
				}
				else if(response[0] == '2')
				{
					$('#tabgroupgridc1_4').html(scripterror());
				}
			}
				
		}, 
		error: function(a,b)
		{
			$('#form-error').html(scripterror());
		}
	});	
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
	queryString = "../ajax/assignimplementation.php";
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