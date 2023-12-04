// JavaScript Document
function startUpload(formno)
{
	document.getElementById('f1_upload_process'+formno).innerHTML = 'Loading...<br/><img src="../images/loader.gif" />';
	document.getElementById('f1_upload_form'+formno).style.visibility = 'hidden';
	document.getElementById('f1_upload_process'+formno).style.visibility = 'visible';
	return true;
}

function stopUpload(success,formno,divid)
{
	var result = '';
	var spanid = document.getElementById('span_downloadlinkfile'+formno).value;
	var textfield = document.getElementById('text_filebox'+formno).value;
	var linkid = document.getElementById('link'+formno).value;
	switch(success)
	{
		case "2":
			result = '<span class="emsg">File Extension does not match.. It should be Zip!<\/span><br/><br/>';
			document.getElementById('f1_upload_process'+formno).innerHTML = result;
		break;
		case "3":
			result = '<span class="emsg">File Already Exists by this name!<\/span><br/><br/>';
			document.getElementById('f1_upload_process'+formno).innerHTML = result;
			break;
		case "4":
			result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
			document.getElementById('f1_upload_process'+formno).innerHTML = result;
			break;
		default:
			document.getElementById('f1_upload_process'+formno).innerHTML = '';
			var links = success.split('|^|');
			document.getElementById(textfield).value = links[1];
			document.getElementById(linkid).value = links[0];
			document.getElementById(divid).style.display='none';
			break;
			
	}
	document.getElementById('f1_upload_form'+formno).style.visibility = 'visible';      
    document.getElementById('f1_upload_process'+formno).style.visibility = 'visible';
	return true;   
}

function fileuploaddivid(spanid,textfield,divid,top,left,formslno,cusid,linkid)
{
	var dividstyle = document.getElementById(divid).style;
	dividstyle.display='block';
	dividstyle.position = 'absolute';
	dividstyle.left = left;
	dividstyle.top = top;
	dividstyle.width = '400px';
	dividstyle.background = '#5989d5';
	
	document.getElementById('span_downloadlinkfile'+formslno).value = spanid;
	document.getElementById('text_filebox'+formslno).value = textfield;
	document.getElementById('cusid'+formslno).value = cusid;
	document.getElementById('link'+formslno).value = linkid;
}



