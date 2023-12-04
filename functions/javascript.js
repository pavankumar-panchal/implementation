// JavaScript Document

function createajax()
{
   var objectname = false;	
	try { /*Internet Explorer Browsers*/ objectname = new ActiveXObject('Msxml2.XMLHTTP'); } 
	catch (e)
	{
		try { objectname = new ActiveXObject('Microsoft.XMLHTTP'); } 
		catch (e)  
		{
			try { /*// Opera 8.0+, Firefox, Safari*/ objectname = new XMLHttpRequest();	} 
			catch (e) { /*Something went wrong*/ alert('Your browser is not responding for Javascripts.'); return false; }
		}
	}
	return objectname;
}

function districtcodeFunction(selectid, comparevalue)
{
	var statecode = document.getElementById('state').value;
	var districtDisplay = document.getElementById('districtcodedisplay');
	passData = "statecode=" + statecode  + "&dummy=" + Math.floor(Math.random()*1100011000000);
	ajaxcalld = createajax();
	var queryString = "../ajax/selectdistrictonstate.php";
	ajaxcalld.open("POST", queryString, true);
	ajaxcalld.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxcalld.onreadystatechange = function()
	{
		if(ajaxcalld.readyState == 4)
		{
			districtDisplay.innerHTML = ajaxcalld.responseText;
			if(selectid && comparevalue)
			autoselect(selectid, comparevalue);
		}
	}
	ajaxcalld.send(passData);return true;
}

function autoselect(selectid,comparevalue)
{
	var selection = document.getElementById(selectid);
	for(var i = 0; i < selection.length; i++) 
	{
		if(selection[i].value == comparevalue)
		{
			selection[i].selected = "1";
			return;
		}
	}
}


//Function to check the particular option in <input type =check> Tag, with the compare value------------------------
function autocheck(selectid,comparevalue)
{
	var selection = selectid;
		if('yes' == comparevalue)
		{
			selection.checked = true;
			return;
		}
		else
		{
			selection.checked = false;
			return;
		}
}


function getprocessingimage()
{
	var imagehtml = '<img src="../images/imax-loading-image.gif" border="0"/>';
	return imagehtml;
}

function validatepincode(pincodenumber)
{
	var numericExpression = /^[^0]+[0-9]{5}$/i;
	if(pincodenumber.match(numericExpression)) return true;
	else return false;
}

function validatecell(cellnumber)
{
	var numericExpression = /^[7|8|9]\d{9}(?:(?:([,][\s]|[;][\s]|[,;])[7|8|9]\d{9}))*$/i;
	//var numericExpression = /^[7|8|9]+[0-9]{9,9}(?:(?:[,;][7|8|9]+[0-9]{9,9}))*$/i;
	if(cellnumber.match(numericExpression)) return true;
	else return false;
}

function validatephone(phonenumber)
{
	var numericExpression = /^[^9]\d{5,7}(?:(?:([,][\s]|[;][\s]|[,;])[^9]\d{5,7}))*$/i;
	if(phonenumber.match(numericExpression)) return true;
	else return false;
}

function emailvalidation(emailid)
{
	var emailExp = /^[A-Z0-9\._%-]+@[A-Z0-9\.-]+\.[A-Z]{2,4}(?:(?:[,;][A-Z0-9\._%-]+@[A-Z0-9\.-]+))*$/i;
	var emails = emailid.replace(/[,\s]*,[,\s]*/g, ",").replace(/^,/, "").replace(/,$/, "");
	if(emails.match(emailExp)) { return true; }
	else { return false; }
}

function validatestdcode(stdcodenumber)
{
	var numericExpression = /^[0]+[0-9]{2,4}$/i;
	if(stdcodenumber.match(numericExpression)) return true;
	else return false;
}

function cellvalidation(cellnumber)
{
 var numericExpression = /^[7|8|9]+[0-9]{9,9}$/i;
 if(cellnumber.match(numericExpression)) return true;
 else return false;
}

function contactpersonvalidate(contactname)
{
 var numericExpression = /^([A-Z\s\()]+[a-zA-Z\s()])$/i;
 if(contactname.match(numericExpression)) return true;
 else return false;
}
function validatenoofdays(value)
{
	var numericExpression = /^([0-9]{1,2}(\.[5]{1})?|31)$/i;
	if(value.match(numericExpression)) return true;
	else return false;
}


function validatetime(time)
{
	var numericExpression = /^([0-1][0-9]|[2][0-3])(:([0-5][0-9])){1,2}$/i;
	if(time.match(numericExpression)) return true;
	else return false;
}

function checkemail(mailid)
{
  var r1 = new RegExp("(@.*@)|(\\.\\.)|(@\\.)|(^\\.)");
  var r2 = new RegExp("^.+\\@(\\[?)[a-zA-Z0-9\\-\\.]+\\.([a-zA-Z]{2,3}|[0-9]{1,3})(\\]?)$");
  return (!r1.test(mailid) && r2.test(mailid));
}

function errormessage(message)
{
	var msg = '<div class="errorbox">' + message + '</div>';
	return msg;
}

function successmessage(message)
{
	var msg = '<div class="successbox">' + message + '</div>';
	return msg;
}
function successsearchmessage(message)
{
	var msg = '<div class="successsearchbox">' + message + '</div>';
	return msg;
}


function getradiovalue(radioname)
{
	if(radioname.value)
		return radioname.value;
	else
	{
		for(var i = 0; i < radioname.length; i++) 
		{
			if(radioname[i].checked) 
				return radioname[i].value;
		}
	}
}


function bodyonload(dealerid)
{	
	if(typeof getdealerdetails == 'function') { getdealerdetails(dealerid); }
	if(typeof getimpalldatadetails == 'function') { getimpalldatadetails('all')};
	/*if(typeof getcustomerlist1 == 'function') { getcustomerlist1(); }	
	if(typeof getcurrentcredit == 'function') { getcurrentcredit(dealerid); }
	if(typeof getdealerdetails == 'function') { getdealerdetails(dealerid); }	
	if(typeof getscheme == 'function') { getscheme('displayschemecode',dealerid); }	
	if(typeof getproduct == 'function') { getproduct('displayproductcode',document.getElementById('scheme').value); }	
	if(typeof getdealer == 'function') { getdealer('displayalldealer',dealerid); }	
	//if(typeof getinvoicedetails == 'function') { getinvoicedetails(''); }
//	if(typeof displayproductgrid == 'function') { displayproductgrid(); }*/	
}

function displaysuccessmessage(message)
{
	var msg = '<div class="displaysuccess">' + message + '</div>';
	return msg;
}

function tabopenimp2(activetab,tabgroupname)
{
	var totaltabs = 2;
	var activetabheadclass = "imptabheadactive";
	var tabheadclass = "imptabhead";
	
	for(var i=1; i<=totaltabs; i++)
	{
		var tabhead = tabgroupname + 'h' + i;
		var tabcontent = tabgroupname + 'c' + i;
		if(i == activetab)
		{
			$('#'+tabhead).removeClass(tabheadclass);
			$('#'+tabhead).addClass(activetabheadclass);
			$('#'+tabcontent).show();
		}
		else
		{
			$('#'+tabhead).removeClass(activetabheadclass);
			$('#'+tabhead).addClass(tabheadclass);
			$('#'+ tabcontent).hide();
		}
	}
}

function gridtabcus4(activetab,tabgroupname,tabdescription)
{
	var totaltabs = 4;
	var activetabheadclass = 'grid-active-tabclass';
	var tabheadclass = 'grid-tabclass';
	
	for(var i=1; i<=totaltabs; i++)
	{
		var tabhead = tabgroupname + 'h' + i;
		var tabcontent = tabgroupname + 'c' + i;
		var tabwaitbox = tabgroupname + 'wb' + i;
		if(i == activetab)
		{
			document.getElementById(tabhead).className = activetabheadclass;
			document.getElementById(tabcontent).style.display = 'block';
			if(document.getElementById(tabwaitbox)) { document.getElementById(tabwaitbox).style.display = 'block'; }
			document.getElementById('tabdescription').innerHTML = tabdescription;
		}
		else
		{
			document.getElementById(tabhead).className = tabheadclass;
			document.getElementById(tabcontent).style.display = 'none';
			if(document.getElementById(tabwaitbox)) { document.getElementById(tabwaitbox).style.display = 'none'; }
			//document.getElementById('tabdescription').innerHTML = '';
		}
	}
}

function tabopen6(activetab,tabgroupname)
{
	var totaltabs = 6;
	var activetabheadclass = "producttabheadactive";
	var tabheadclass = "producttabhead";
	
	for(var i=1; i<=totaltabs; i++)
	{

		var tabhead = tabgroupname + 'h' + i;
		var tabcontent = tabgroupname + 'c' + i;
		if(i == activetab)
		{

			//document.getElementById(tabhead).className = activetabheadclass;
			document.getElementById(tabcontent).style.display = 'block';
			//alert(tabcontent);
		}
		else
		{

		//	document.getElementById(tabhead).className = tabheadclass;
			document.getElementById(tabcontent).style.display = 'none';
			//alert(tabcontent);
		}
	}
}


//Function to enable the save button--------------------------------------------------------------------------------
function enablesave(id)
{
	document.getElementById(id).disabled = false;
	document.getElementById(id).className = 'swiftchoicebutton';
}

//Function to disable the save button--------------------------------------------------------------------------------
function disablesave(id){
	document.getElementById(id).disabled = true;
	document.getElementById(id).className = 'swiftchoicebuttondisabled';
}

//Function to enable the New button--------------------------------------------------------------------------------
function enablenew()
{
	document.getElementById('new').disabled = false;
	document.getElementById('new').className = 'swiftchoicebutton';
}

//Function to disable the New button--------------------------------------------------------------------------------
function disablenew(){
	document.getElementById('new').disabled = true;
	document.getElementById('new').className = 'swiftchoicebuttondisabled';
	document.getElementById('new').style.cursor = '';
}

function validateamount(amount)
{
	var numericExpression = /^[-+]?[0-9]\d{0,9}(\.\d{1,2})?%?$/;
	if(amount.match(numericExpression)) return true;
	else return false;
}

function enablenext()
{
	document.getElementById('next').disabled = false;
	document.getElementById('next').className = 'swiftchoicebutton';
	document.getElementById('next').style.cursor = 'pointer';
}


function disablenext()
{
	document.getElementById('next').disabled = true;
	document.getElementById('next').className = 'swiftchoicebuttondisabled';
	document.getElementById('next').style.cursor = '';
}

function disablesend()
{
	document.getElementById('send').disabled = true;
	document.getElementById('send').className = 'swiftchoicebuttondisabled';
	document.getElementById('send').style.cursor = '';
}


function displayelement(displayelementid,hideelementid)
{
	var delement = document.getElementById(displayelementid);
	var helement = document.getElementById(hideelementid);
	delement.style.display = 'block'; helement.style.display = 'none'; 
}


//Validation of website - common function  Rashmi -18/11/2009
function validatewebsite(website)
{
	var websiteExpression = /^(www\.)?[a-zA-Z0-9-\.,]+\.[a-zA-Z]{2,4}$/i;
	if(website.match(websiteExpression)) return true;
	else return false;
}

//Function to enable the delete button------------------------------------------------------------------------------
function enabledelete()
{
	document.getElementById('delete').disabled = false;
	document.getElementById('delete').className = 'swiftchoicebutton';
}
//Function to display a error message if the script failed-Meghana[11/12/2009]
function scripterror()
{
	var msghtml = '<div class="errorbox">Unable to Connect....</div>';
	return msghtml;
}


function in_array(checkvalue, arrayobject) 
{
	for(var i = 0, l = arrayobject.length; i < l; i++) 
	{
		if(arrayobject[i] == checkvalue) 
		{
			return true;
		}
	}
	return false;
}


function computeridvalidate(compid)
{
	var numericExpresion = /^[0-9]{3}0[0|9]-[0-9]{9}$/;
	if(compid.match(numericExpresion)) return true;
	return false;
}

function validatecontactperson(contactname)
{
	var numericExpression = /^([A-Z\s\()]+[a-zA-Z\s()])(?:(?:[,;]([A-Z\s()]+[a-zA-Z\s()])))*$/i;
	if(contactname.match(numericExpression)) return true;
	else return false;
}


function validatebusinessname(contactname)
{
	var numericExpression = /^([A-Z0-9\s\-()]+[a-zA-Z0-9\s-()])(?:(?:[,;]([A-Z0-9\s-()]+[a-zA-Z0-9\s-()])))*$/i;
	if(contactname.match(numericExpression)) return true;
	else return false;
}

//Function to change the css of active tab and select the tab in display grid part----------------------------------
function gridtab2(activetab,tabgroupname,tabdescription)
{
	var totaltabs = 2;
	var activetabheadclass = 'grid-active-tabclass';
	var tabheadclass = 'grid-tabclass';
	
	for(var i=1; i<=totaltabs; i++)
	{
		var tabhead = tabgroupname + 'h' + i;
		var tabcontent = tabgroupname + 'c' + i;
		var tabwaitbox = tabgroupname + 'wb' + i;
		var tabviewbox = tabgroupname + 'view' + i;

		
		if(i == activetab)
		{
			$('#'+tabhead).removeClass(tabheadclass);
			$('#'+tabhead).addClass(activetabheadclass);
			if($('#'+tabcontent)) { $('#'+tabcontent).show(); }
			$('#'+tabcontent).show();
			if($('#'+tabwaitbox)) { $('#'+tabwaitbox).show(); }
			if($('#'+tabviewbox)) { $('#'+tabviewbox).show(); }
			$('#tabdescription').html(tabdescription);
		}
		else
		{
			$('#'+tabhead).removeClass(activetabheadclass);
			$('#'+tabhead).addClass(tabheadclass);
			$('#'+ tabcontent).hide();
			if($('#'+tabwaitbox)) { $('#'+tabwaitbox).hide(); }
			if($('#'+tabviewbox)) { $('#'+tabviewbox).hide(); }
		}
	}
}


function tabopen2(activetab,tabgroupname)
{
	var totaltabs = 4;
	var activetabheadclass = "producttabheadactive";
	var tabheadclass = "producttabhead";
	
	for(var i=1; i<=totaltabs; i++)
	{
		var tabhead = tabgroupname + 'h' + i;
		var tabcontent = tabgroupname + 'c' + i;
		if(i == activetab)
		{
			document.getElementById(tabhead).className = activetabheadclass;
			document.getElementById(tabcontent).style.display = 'block';
		}
		else
		{
			document.getElementById(tabhead).className = tabheadclass;
			document.getElementById(tabcontent).style.display = 'none';
		}
	}
}


//Function to check the particular option in <input type =check> Tag, with the compare value------------------------
function autochecknew(selectid,comparevalue)
{
		var selection = selectid;
		if('yes' == comparevalue)
		{
			$(selection).attr('checked',true)
			return;
		}
		else
		{
			$(selection).attr('checked',false)
			return;
		}
}

function isanumber(onechar)
{
	if(onechar.charCodeAt(0) >= 48 && onechar.charCodeAt(0) <= 57)
	{
		return true;
	}
	else
		return false;
}

/*function validatetime(time)
{
	//if (time.length == 8)
	//{
		var splittime = time.split(':');
		if( isanumber((time.charAt(0))) && isanumber((time.charAt(1))) && isanumber((time.charAt(3))) && isanumber((time.charAt(4))) && isanumber((time.charAt(6))) && isanumber((time.charAt(7))) &&  splittime[0] <= '24' && splittime[1] <= '60' && splittime[2] <= '60' )
		{
			return true;		
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}*/

function displayfilterdiv()
{
	if($('#displayfilter').is(':visible'))
		$('#displayfilter').hide();
	else
		$('#displayfilter').show();
}
function tabopen51(activetab,tabgroupname)
{
	var totaltabs = 5;
	var activetabheadclass = "tabg1h";
	var tabheadclass = "tabg1c";
	
	for(var i=1; i<=totaltabs; i++)
	{

		var tabhead = tabgroupname + 'h' + i;
		var tabcontent = tabgroupname + 'c' + i;
		if(i == activetab)
		{

			//document.getElementById(tabhead).className = activetabheadclass;
			$('#'+tabcontent).show();
			//alert(tabcontent);
		}
		else
		{

		//	document.getElementById(tabhead).className = tabheadclass;
			$('#'+tabcontent).hide();
			//alert(tabcontent);
		}
	}
}

function displayDiv(elementid)
{
	if($('#'+ elementid).is(':visible'))
	{
		$('#'+ elementid).hide();
	}
	else
	{
		$('#'+ elementid).show();
	}
}

function trimdotspaces(text)
{
	var output = text.replace(/ /g,""); 
	var output2 = output.replace(/\./g,"");
	return output2;
}


function selectdeselectcommon(selectionid,checkboxname)
{
	var selectproduct = $('#' + selectionid);
	var chkvalues = $("input[name='"+ checkboxname +"']");
	for (var i=0; i < chkvalues.length; i++)
	{
		if($(chkvalues[i]).is(':checked'))
		{
			$(chkvalues[i]).attr('checked',false);
		}
		if(($('#'+selectionid).is(':checked')) == true) 
			$(chkvalues[i]).attr('checked',true);
		else if(($('#'+selectionid).is(':checked')) == false) 
			$(chkvalues[i]).attr('checked',false);
	}
}