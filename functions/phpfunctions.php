<?php
//Include Database Configuration details
if(file_exists("../inc/dbconfig.php"))
	include('../inc/dbconfig.php');
elseif(file_exists("../../inc/dbconfig.php"))
	include('../../inc/dbconfig.php');
else
	include('./inc/dbconfig.php');


//Connect to host
$newconnection = mysqli_connect($dbhost, $dbuser, $dbpwd, $dbname) or die("Cannot connect to Mysql server host");

/* -------------------- Get local server time [by adding 5.30 hours] -------------------- */
function datetimelocal($format)
{
//	$diff_timestamp = date('U') + 19800;
	$date = date($format);
	return $date;
}

/* -------------------- Run a query to database -------------------- */
function runmysqlquery($query)
{
	global $newconnection;
	$dbname = 'test_live';

	//Connect to Database
	mysqli_select_db($newconnection,$dbname) or die("Cannot connect to database");
	set_time_limit(3600);
	//Run the query
	$result = mysqli_query($newconnection,$query) or die(" run Query Failed in Runquery function1.".$query); //;
	
	//Return the result
	return $result;
}

/* -------------------- Run a query to database with fetching from SELECT operation -------------------- */
function runmysqlqueryfetch($query)
{
	global $newconnection;
	$dbname = 'test_live';

	//Connect to Database
	mysqli_select_db($newconnection,$dbname) or die("Cannot connect to database");
	set_time_limit(3600);
	//Run the query
	$result = mysqli_query($newconnection,$query) or die(" run Query Failed in Runquery function1.".$query); //;
	
	//Fetch the Query to an array
	$fetchresult = mysqli_fetch_array($result) or die("Cannot fetch the query result.".$query);
	
	//Return the result
	return $fetchresult;
}

/* -------------------- Run a query for ICIC database -------------------- */
function runicicidbquery($query)
{
	global $newconnection;
	 $icicidbname = "relyon_icici";
 
	 //Connect to Database
	 mysqli_select_db($newconnection,$icicidbname) or die("Cannot connect to database");
	 set_time_limit(3600);
	 
	 //Run the query
	 $result = mysqli_query($query,$newconnection) or die(mysqli_error());
	 
	 //Return the result
	 return $result;
}


/* -------------------- To change the date format from DD-MM-YYYY to YYYY-MM-DD or reverse -------------------- */

function changedateformat($date)
{
	if($date <> "0000-00-00")
	{
		if(strpos($date, " "))
		$result = explode(" ",$date);
		else
		$result = preg_split("/[:.-]/",$date);
		$date = $result[2]."-".$result[1]."-".$result[0];
	}
	else
	{
		$date = "";
	}
	return $date;
}


function changetimeformat($time)
{
	if($time <> "00:00:00")
	{
		$result = explode(":",$time);
		$time = $result[0].":".$result[1];
	}
	else
	{
		$time = "";
	}
	return $time;
}


function changedateformatwithtime($date)
{
	if($date <> "0000-00-00 00:00:00")
	{
		if(strpos($date, " "))
		{
			$result = explode(" ",$date);
			if(strpos($result[0], "-"))
				$dateonly = explode("-",$result[0]);
			$timeonly =explode(":",$result[1]);
			$timeonlyhm = $timeonly[0].':'.$timeonly[1];
			$date = $dateonly[2]."-".$dateonly[1]."-".$dateonly[0]." ".'('.$timeonlyhm.')';
		}
			
	}
	else
	{
		$date = "";
	}
	return $date;
}

function cusidsplit($customerid)
{
    $strlen = strlen($customerid);

    if ($strlen != 17) {
        if (strpos($customerid, " ")) {
            $result = preg_split("/\s+/", $customerid);
        } else {
            $result = preg_split("/[:.\/-]/", $customerid);
        }

        // Concatenate the array elements to form the customer ID
        $customerid = implode("", $result);
    }

    return $customerid;
}


function cusidcombine($customerid)
{
	$result1 = substr($customerid,0,4);
	$result2 = substr($customerid,4,4);
	$result3 = substr($customerid,8,4);
	$result4 = substr($customerid,12,5);
	$result = $result1.'-'.$result2.'-'.$result3.'-'.$result4;
	return $result;
}

function generatepwd()
{
	$charecterset0 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	$charecterset1 = "1234567890";
	for ($i=0; $i<4; $i++)
	{
		$usrpassword .= $charecterset0[rand(0, strlen($charecterset0))];
	}
	for ($i=0; $i<4; $i++)
	{
		$usrpassword .= $charecterset1[rand(0, strlen($charecterset1))];
	}
	return $usrpassword;
}

function getpagelink($linkvalue)
{
	switch($linkvalue)
	{
		case 'editprofile': return '../profile/editprofile.php'; break;
		case 'changepassword': return '../profile/changepw.php'; break;
		case 'assignimplementation': return '../main/assignimplementation.php'; break;
		case 'implementation': return '../main/implementationprocess.php'; break;
		case 'customization': return '../main/customization.php'; break;
		case 'dashboard': return '../dashboard/index.php'; break;
		case 'implementationsummary': return '../reports/implementationreport.php'; break;
		case 'implementationdetailed': return '../reports/implementationstatusreport.php'; break;
		case 'handholdprocess': return '../main/handholdprocess.php'; break;
		case 'handholddetailed': return '../reports/handholdstatusreport.php'; break;
		default: return '../login.php'; break;
	}
}

function getpagetitle($linkvalue)
{
	switch($linkvalue)
	{
		case 'editprofile': return 'Implementer : Profile Screen'; break;
		case 'changepassword': return 'Implementer : Change Password'; break;
		case 'assignimplementation': return 'Coordinator : Assign Implementation'; break;
		case 'implementation': return 'Implementer : Implementation Process'; break;
		case 'customization': return 'Customiser : Customization Process'; break;
		case 'Dashboard': return 'Implementer : DashBoard'; break;
		case 'implementationsummary': return 'Report : Implementation Summary'; break;
		case 'implementationdetailed': return 'Report : Implementation Detailed Report'; break;
		case 'handholdprocess': return 'Hand Hold Implementation'; break;
		case 'handholddetailed': return 'Report : Hand Hold Detailed Report'; break;
		default: return 'Implementer : Dashboard'; break;
		
	}
}

function getpageheader($linkvalue)
{
	switch($linkvalue)
	{
		case 'editprofile': return 'Profile Screen'; break;
		case 'changepassword': return 'Change Password'; break;
		case 'assignimplementation': return 'Assign Implementation'; break;
		case 'implementation': return 'Implementation Process'; break;
		case 'customization': return 'Customization Process'; break;
		case 'Dashboard': return 'DashBoard'; break;
		case 'implementationsummary': return 'Implementation Summary'; break;
		case 'implementationdetailed': return 'Implementation Detailed Report'; break;
		case 'handholdprocess': return 'Hand Hold Implementation'; break;
		case 'handholddetailed': return 'Hand Hold Detailed Report'; break;
		default: return 'Dashboard'; break;
	}
}

 function downloadfile($filelink)
{
	$filename = basename($filelink);
	header('Content-type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$filename);
	readfile($filelink);
}

function checkemailaddress($email) 
{
	// First, we check that there's one @ symbol, and that the lengths are right
	if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) 
	{
		// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
		return false;
	}
	// Split it into sections to make life easier
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++) 
	{
		if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) 
		{
			return false;
		}
	}
	if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) 
	{ 
		// Check if domain is IP. If not, it should be valid domain name
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) 
		{
			return false; // Not enough parts to domain
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) 
		{
			if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) 
			{
				return false;
			}
		}
	}
	return true;
}

function replacemailvariable2($content,$array)
{
	$arraylength = count($array);
	for($i = 0; $i < $arraylength; $i++)
	{
		$splitvalue = explode('%^%',$array[$i]);
		$oldvalue = $splitvalue[0];
		$newvalue = $splitvalue[1];
		$content = str_replace($oldvalue,$newvalue,$content);
	}
	return $content;
}

function gridtrim($value)
{
	$desiredlength = 25;
	$length = strlen($value);
	if($length >= $desiredlength)
	{
		$value = substr($value, 0, $desiredlength);
		$value .= "...";
	}
	return $value;
}
function validateFormat($computerid)
{
	if(preg_match("/^\d{5}-\d{9}$/", $computerid))
	return true;
}

function replacemailvariable($content,$array)
{
	$arraylength = count($array);
	for($i = 0; $i < $arraylength; $i++)
	{
		$splitvalue = explode('%^%',$array[$i]);
		$oldvalue = $splitvalue[0];
		$newvalue = $splitvalue[1];
		$content = str_replace($oldvalue,$newvalue,$content);
	}
	return $content;
}


// function to delete cookie and encoded the cookie name and value
function imaxdeletecookie($cookiename)
{
	 //Name Suffix for MD5 value
	 $stringsuff = "55";

	//Convert Cookie Name to base64
	$Encodename = encodevalue($cookiename);
	
	 //Append the encoded cookie name with 55(suffix ) for MD5 value
	 $rescookiename = $Encodename.$stringsuff;

	//Set expiration to negative time, which will delete the cookie
	setcookie($Encodename, "", time()-3600,"/");
	setcookie($rescookiename, "", time()-3600,"/");
}

// function to create cookie and encoded the cookie name and value
function imaxcreatecookie($cookiename,$cookievalue)
{
	 //Define prefix and suffix 
	 $prefixstring="AxtIv23";
	 $suffixstring="StPxZ46";
	 $stringsuff = "55";
	 
	 //Append Value with the Prefix and Suffix
	 $Appendvalue = $prefixstring . $cookievalue . $suffixstring;
	 
	 // Convert the Appended Value to base64
	 $Encodevalue = encodevalue( $Appendvalue);
	 
	 //Convert Cookie Name to base64
	 $Encodename = encodevalue($cookiename);

	 //Create a cookie with the encoded name and value
	 setcookie($Encodename,$Encodevalue,time()+3600,"/");

 	 //Convert Appended encode value to MD5
	 $rescookievalue = md5($Encodevalue);

	 //Appended the encoded cookie name with 55(suffix )
	 $rescookiename = $Encodename.$stringsuff;

	 //Create a cookie
	 setcookie($rescookiename,$rescookievalue,time()+3600,"/");
	 return false;
	 	 
}

//Function to get cookie and encode it and validate
function imaxgetcookie($cookiename)
{
	$suff = "55";

	// Convert the Cookie Name to base64
	$Encodestr = encodevalue($cookiename);

	//Read cookie name
	$stringret = $_COOKIE[$Encodestr];
	$stringret = stripslashes($stringret);

	//Convert the read cookie name to md5 encode technique
	$Encodestring = md5($stringret);
	
	//Appended the encoded cookie name to 55(suffix)
	$resultstr = $Encodestr.$suff;
	$cookiemd5 = $_COOKIE[$resultstr];
	
	//Compare the encoded value wit the fetched cookie, if the condition is true decode the cookie value
	if($Encodestring == $cookiemd5)
	{
		$decodevalue = decodevalue($stringret);
		//Remove the Prefix/Suffix Characters
		$string1 = substr($decodevalue,7);
		$resultstring = substr($string1,0,-7);
		return $resultstring;
	}
	elseif(isset($Encodestring) == '')
	{
		return false;
	}
	else 
	{
		return false;
	}
}
//Function to logout (clear cookies)
function imaxlogout()
{
	session_start(); 
	session_destroy(); 
	imaxdeletecookie('userslno');
}

//Function to generate random string of four digits
function rand_str()
{
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    // Length of character list
    $chars_length = (strlen($chars) - 1);

    // Start our string
    $string = $chars[rand(0, $chars_length)];
   
    // Generate random string
    for ($i = 0; $i <4; $i = strlen($string))
    {
        // Grab a random character from our list
        $r = $chars[rand(0, $chars_length)];
       
        // Make sure the same two characters don't appear next to each other
        if ($r != $string[$i - 1]) $string .=  $r;
    }
   
    // Return the string
    return $string;

}

function modulegropname($shortname)
{
	switch($shortname)
	{
		case "user_module":
			return "User Module";
			break;
		case "dealer_module":
			return "Dealer Module";
			break;
		
	}
}


function inserttologs($userid,$id,$fromname,$emailfrom,$emailto,$ccmailids,$bccemailids,$subject)
{
	$module = 'dealer_module';
	$sentthroughip = $_SERVER['REMOTE_ADDR'];
	$query = "insert into inv_logs_mails(userid,id,fromname,emailfrom,emailto,ccmailids,bccmailids,subject,date,fromip,module) values('".$userid."','".$id."','".$fromname."','".$emailfrom."','".$emailto."','".$ccmailids."','".$bccemailids."','".$subject."','".date('Y-m-d').' '.date('H:i:s')."','".$sentthroughip."','".$module."');";
	$result = runmysqlquery($query);
}

function decodevalue($input)
{
	$input = str_replace('\\\\','\\',$input);
	$input = str_replace("\\'","'",$input);
	$length = strlen($input);
	$output = "";
	for($i = 0; $i < $length; $i++)
	{
		if($i % 2 == 0)
			$output .= chr(ord($input[$i]) - 7);
	}
	$output = str_replace("'","\'",$output);
	return $output;
}

function encodevalue($input)
{
	$length = strlen($input);
	$output1 = "";
	for($i = 0; $i < $length; $i++)
	{
		$output1 .= $input[$i];
		if($i < ($length - 1))
			$output1 .= "a";
	}
	$output = "";
	for($i = 0; $i < strlen($output1); $i++)
	{
		$output .= chr(ord($output1[$i]) + 7);
	}
	return $output;
}

function sendcoordinatorappmail($lastslno,$userid)
{
	$query = "select * from imp_implementation left join inv_mas_customer on inv_mas_customer.slno = imp_implementation.customerreference  where imp_implementation.slno = '".$lastslno."'";
	$result = runmysqlqueryfetch($query);
	
	$approvedreason = $result['coordinatorapprovalremarks'];
	$dealerid = $result['dealerid'];
	$businessname = $result['businessname'];
	
	// Get implementer name 
	
	$query01 = "select * from inv_mas_implementer where slno = '".$userid."' and coordinator = 'yes'";
	$result01 = runmysqlqueryfetch($query01);
	$coordinatorname = $result01['businessname'];
	// Fetch Sales person Emaild
	
	$query11 = "select * from inv_mas_dealer where slno = '".$dealerid."'";
	$result11 = runmysqlqueryfetch($query11);
	$salespersonemailid = $result11['emailid']; 
	$branchid = $result11['branch'];
	$dealername = $result11['businessname'];
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
	{
		$emailid = 'meghana.b@relyonsoft.com';
	}
	else
	{
		$emailid = $salespersonemailid;
	}
	$emailarray = explode(',',$emailid);
	$emailcount = count($emailarray);

	for($i = 0; $i < $emailcount; $i++)
	{
		if(checkemailaddress($emailarray[$i]))
		{
				$emailids[$emailarray[$i]] = $emailarray[$i];
		}
	}

	if($branchid == 6)
	{
		$enableimpmail = " and enableimpmail = 'yes'";
	}
	// Fetch branch head emailid 
	$query12 = "select TRIM(BOTH ',' FROM group_concat(emailid))as branchemailid from inv_mas_dealer where branch = '".$branchid."' and branchhead = 'yes' and disablelogin = 'no' and slno!='1580'";
	$result12 = runmysqlqueryfetch($query12);
	$branchheademailid = $result12['branchemailid'];
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
	{
		$branchemailid = 'rashmi.hk@relyonsoft.com';
	}
	else
	{
		$branchemailid = $branchheademailid;
	}
	//echo($emailid.'^'.$branchemailid);exit;
	$ccemailarray = explode(',',$branchemailid);
	$ccemailcount = count($ccemailarray);
	for($i = 0; $i < $ccemailcount; $i++)
	{
		if(checkemailaddress($ccemailarray[$i]))
		{
			if($i == 0)
				$ccemailids[$ccemailarray[$i]] = $ccemailarray[$i];
			else
				$ccemailids[$ccemailarray[$i]] = $ccemailarray[$i];
		}
	}
	$fromname = "Relyon";
	$fromemail = "imax@relyon.co.in";
	require_once("../inc/RSLMAIL_MAIL.php");
	$msg = file_get_contents("../mailcontents/approvedbycoordinator.htm");
	$textmsg = file_get_contents("../mailcontents/approvedbycoordinator.txt");

	//Create an array of replace parameters
	$array = array();
	$date = datetimelocal('d-m-Y');
	$array[] = "##DATE##%^%".$date;
	$array[] = "##INVOICENO##%^%".$result['invoicenumber'];
	$array[] = "##BUSINESSNAME##%^%".$businessname;
	$array[] = "##BRANCHEADNAME##%^%".$branchname;
	$array[] = "##SALESNAME##%^%".$dealername;
	$array[] = "##EMAILID##%^%".$emailid;
	$array[] = "##APPREMARKS##%^%".$approvedreason;
	$array[] = "##COORDINATORNAME##%^%".$coordinatorname;
	//Relyon Logo for email Content, as Inline [Not attachment]
	$filearray = array(
		array('../images/relyon-logo.jpg','inline','8888888888'),
	
	);
	
	$toarray = $emailids;
	$ccarray = $ccemailids;
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab"))
	{
		$bccemailids['archana'] ='archana.ab@relyonsoft.com';
	}
	else
	{
		$bccemailids['bigmail'] ='bigmail@relyonsoft.com';
		$bccemailids['Relyonimax'] ='relyonimax@gmail.com';
	}

	$bccarray = $bccemailids;
	$msg = replacemailvariable($msg,$array);
	$textmsg = replacemailvariable($textmsg,$array);
	$subject = 'Approval of Implementation Request by Co-ordinator(Beta)'; 
	$html = $msg;
	$text = $textmsg;
	rslmail($fromname, $fromemail, $toarray, $subject, $text, $html,$ccarray,$bccarray,$filearray);
	return 'sucess';
	//Insert the mail forwarded details to the logs table
	$bccmailid = 'bigmail@relyonsoft.com';
	inserttologs($userid,$customerslno,$fromname,$fromemail,$emailid,null,$bccmailid,$subject);
}

function sendrejectmail($lastslno,$userid)
{
	$query = "select * from imp_implementation left join inv_mas_customer on inv_mas_customer.slno = imp_implementation.customerreference  where imp_implementation.slno = '".$lastslno."'";
	$result = runmysqlqueryfetch($query);
	
	$rejectreason = $result['coordinatorrejectremarks'];	
	$dealerid = $result['dealerid'];
	$businessname = $result['businessname'];
	
	// Get implementer name 
	$query01 = "select * from inv_mas_implementer where slno = '".$userid."' and coordinator = 'yes'";
	$result01 = runmysqlqueryfetch($query01);
	$coordinatorname = $result01['businessname'];
	
	// Fetch Sales person Emaild
	
	$query11 = "select * from inv_mas_dealer where slno = '".$dealerid."'";
	$result11 = runmysqlqueryfetch($query11);
	$salespersonemailid = $result11['emailid'];
	$branchid = $result11['branch'];
	$dealername = $result11['businessname'];
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
	{
		$emailid = 'meghana.b@relyonsoft.com';
	}
	else
	{
		$emailid = $salespersonemailid;
	}
	$emailarray = explode(',',$emailid);
	$emailcount = count($emailarray);

	for($i = 0; $i < $emailcount; $i++)
	{
		if(checkemailaddress($emailarray[$i]))
		{
				$emailids[$emailarray[$i]] = $emailarray[$i];
		}
	}
	// Fetch branch head emailid 
	$query12 = "select TRIM(BOTH ',' FROM group_concat(emailid))as branchemailid from inv_mas_dealer where branch = '".$branchid."' and branchhead = 'yes' and disablelogin = 'no'";
	$result12 = runmysqlqueryfetch($query12);
	$branchheademailid = $result12['branchemailid'];
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
	{
		$branchemailid = 'rashmi.hk@relyonsoft.com';
	}
	else
	{
		$branchemailid = $branchheademailid;
	}
	
	$ccemailarray = explode(',',$branchemailid);
	$ccemailcount = count($ccemailarray);
	for($i = 0; $i < $ccemailcount; $i++)
	{
		if(checkemailaddress($ccemailarray[$i]))
		{
			if($i == 0)
				$ccemailids[$ccemailarray[$i]] = $ccemailarray[$i];
			else
				$ccemailids[$ccemailarray[$i]] = $ccemailarray[$i];
		}
	}
	$fromname = "Relyon";
	$fromemail = "imax@relyon.co.in";
	require_once("../inc/RSLMAIL_MAIL.php");
	$msg = file_get_contents("../mailcontents/rejectbycoordinator.htm");
	$textmsg = file_get_contents("../mailcontents/rejectbycoordinator.txt");

	//Create an array of replace parameters
	$array = array();
	$date = datetimelocal('d-m-Y');
	$array[] = "##DATE##%^%".$date;
	$array[] = "##INVOICENO##%^%".$result['invoicenumber'];
	$array[] = "##INVOICENO##%^%".$businessname;
	$array[] = "##BRANCHEADNAME##%^%".$branchname;
	$array[] = "##SALESNAME##%^%".$dealername;
	$array[] = "##EMAILID##%^%".$emailid;
	$array[] = "##REJREMARKS##%^%".$rejectreason;
	$array[] = "##COORDINATORNAME##%^%".$coordinatorname;
	//Relyon Logo for email Content, as Inline [Not attachment]
	$filearray = array(
		array('../images/relyon-logo.jpg','inline','8888888888'),
	
	);
	
	$toarray = $emailids;
	$ccarray = $ccemailids;
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab"))
	{
		$bccemailids['archana'] ='archana.ab@relyonsoft.com';
	}
	else
	{
		$bccemailids['bigmail'] ='bigmail@relyonsoft.com';
		$bccemailids['Relyonimax'] ='relyonimax@gmail.com';
	}
	$bccarray = $bccemailids;
	$msg = replacemailvariable($msg,$array);
	$textmsg = replacemailvariable($textmsg,$array);
	$subject = 'Rejected Implementation Request by Coordinator(Beta)'; 
	$html = $msg;
	$text = $textmsg;
	rslmail($fromname, $fromemail, $toarray, $subject, $text, $html,$ccarray,$bccarray,$filearray);
	return 'sucess';
	//Insert the mail forwarded details to the logs table
	$bccmailid = 'bigmail@relyonsoft.com';
	inserttologs($userid,$customerslno,$fromname,$fromemail,$emailid,null,$bccmailid,$subject);
}

function vieworgeneratepdfinvoice($slno,$type)
{
	ini_set('memory_limit', '2048M');
	require_once('../pdfbillgeneration/tcpdf.php');
	$query1 = "select * from inv_invoicenumbers where slno = '".$slno."';";
	$resultfetch1 = runmysqlqueryfetch($query1);
	$invoicestatus = $resultfetch1['status'];
	
	$checkInvoicedate = strtotime($resultfetch1['createddate']);
	$checkJuly = strtotime('2017-07-01 00:0:00');

	//for SAC code 2019-20 effective from 1st april
	$checkInvoicedate1 = strtotime($resultfetch1['createddate']);
	$checkMarch = strtotime('2019-04-01 00:0:00');
	
	$invoicenewformate= changedateformat(substr($resultfetch1['createddate'],0,10));
	$newyeardate = "31-03-2014";
	if($invoicestatus == 'CANCELLED')
	{
		// Extend the TCPDF class to create custom Header and Footer
		class MYPDF extends TCPDF {
		//Page header
		public function Header() {
			// full background image
			// store current auto-page-break status
			$bMargin = $this->getBreakMargin();
			$auto_page_break = $this->AutoPageBreak;
			$this->SetAutoPageBreak(false, 0);
			$img_file = K_PATH_IMAGES.'invoicing-cancelled-background.jpg';
			$this->Image($img_file, 0, 80, 820, 648, '', '', '', false, 75, '', false, false, 0);
			// restore auto-page-break status
			$this->SetAutoPageBreak($auto_page_break, $bMargin);
			}
		}
		
		// create new PDF document
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	}
	else
	{
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// remove default header
		$pdf->setPrintHeader(false);
	}

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	
	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
	//set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	

	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	//set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
	
	//set some language-dependent strings
	$pdf->setLanguageArray($l); 
	
	// remove default footer
	$pdf->setPrintFooter(false);
	
	// set font
	$pdf->SetFont('Helvetica', '', 10);
	
	// add a page
	//$pdf->AddPage();
	

	//Added 01.07.2017

	// set certificate file
    $certificate = 'file:///etc/digitalsign/relyon.crt';

    // set additional information
    $info = array(
        'Name' => 'Relyon Softech Ltd.',
        'Location' => 'Bangalore',
        'Reason' => 'Digitally Signed Invoice',
        'ContactInfo' => 'http://www.relyonsoft.com',
        );
	//Ends        
	
	// set font
	$pdf->SetFont('Helvetica', '', 10);
	
	// add a page
	$pdf->AddPage();
	
	//Added on 01.07.2017

     // set document signature
    $pdf->setSignature($certificate, $certificate, '123', '', 2, $info);
    
    
    
    // create content for signature (image and/or text)
    //$pdf->Image('../pdfbillgeneration/images/tcpdf_signature.png',5, 5, 15, 15, 'PNG');
    //$pdf->Image('../pdfbillgeneration/images/relyon-logo.png',130, 248, 65, 30, 'PNG');
    
    // define active area for signature appearance
    $pdf->setSignatureAppearance(130, 248, 65, 30);

	//Ends
	
	$final_amount = 0;
	$query = "select * from inv_invoicenumbers where inv_invoicenumbers.slno = '".$slno."';";
	$result = runmysqlquery($query);
	$fetchresult = runmysqlqueryfetch($query);
	
	$appendzero = '.00';
	if(strtotime($invoicenewformate) <= strtotime($newyeardate))
	{
		$grid .='<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" >';
		$grid .='<tr><td ><table width="100%" border="1" cellspacing="0" cellpadding="4" bordercolor="#CCCCCC" style="border:1px solid"><tr bgcolor="#CCCCCC"><td width="10%"><div align="center"><strong>Sl No</strong></div></td><td width="76%"><div align="center"><strong>Description</strong></div></td><td width="14%"><div align="center"><strong>Amount</strong></div></td></tr>';
	}
	else
	{
		$grid .='<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" >';
		$grid .='<tr><td ><table width="100%" border="1" cellspacing="0" cellpadding="2" bordercolor="#CCCCCC" style="border:1px solid"><tr bgcolor="#CCCCCC"><td width="10%"><div align="center"><strong>Sl No</strong></div></td><td width="76%"><div align="center"><strong>Description</strong></div></td><td width="14%"><div align="center"><strong>Amount</strong></div></td></tr>';
	}
        $countslno=1;
	while($fetch = mysqli_fetch_array($result))
	{
		$description = $fetch['description'];
		$productbriefdescription = $fetch['productbriefdescription'];
		$productbriefdescriptionsplit = explode('#',$productbriefdescription);
		$descriptionsplit = explode('*',$description);
		for($i=0;$i<count($descriptionsplit);$i++)
		{
			$productdesvalue = '';
			$descriptionline = explode('$',$descriptionsplit[$i]);
			if($productbriefdescription <> '')
				$productdesvalue = $productbriefdescriptionsplit[$i];
			else
				$productdesvalue = 'Not Available';
			/*if($fetch['purchasetype'] == 'SMS')
			{
				$grid .= '<tr>';
				$grid .= '<td width="10%" style="text-align:centre;">'.$countslno.'</td>';
				$grid .= '<td width="76%" style="text-align:left;">'.$descriptionline[1].'</td>';
				$grid .= '<td  width="14%" style="text-align:right;" >'.$descriptionline[2].'</td>';
				$grid .= "</tr>";
                                $countslno++;

			}
			else
			{*/
                             
			if($description <> '')
			{
				$grid .= '<tr>';
				$grid .= '<td width="10%" style="text-align:centre;">'.$countslno.'</td>';

				if($checkInvoicedate < $checkJuly) 
				{
					$grid .= '<td width="76%" style="text-align:left;">'.$descriptionline[1].'<br/>
					<span style="font-size:+7" ><strong>Purchase Type</strong> : '.$descriptionline[2].'&nbsp;/&nbsp;<strong>Usage Type</strong> :'.$descriptionline[3].'&nbsp;&nbsp;/ &nbsp;<strong>PIN Number : <font color="#000000">'.$descriptionline[4].'</font></strong> (<strong>Serial</strong> : '.$descriptionline[5].')</span><br/><span style="font-size:+6" ><strong>Product Description</strong> : '.$productdesvalue.' </span></td>';
				} 
			    else 
			    {
			    	if($checkInvoicedate1 < $checkMarch)
			    	{
						$grid .= '<td width="76%" style="text-align:left;">'.$descriptionline[1].'<br/>
						<span style="font-size:+7" ><strong>Purchase Type</strong> : '.$descriptionline[2].'&nbsp;/&nbsp;<strong>Usage Type</strong> :'.$descriptionline[3].'&nbsp;&nbsp;/ &nbsp;<strong>PIN Number : <font color="#000000">'.$descriptionline[4].'</font></strong> (<strong>Serial</strong> : '.$descriptionline[5].')</span><br/><span style="font-size:+6" ><strong>Product Description</strong> : '.$productdesvalue.' </span><span style="font-size:+6" > / <strong>SAC</strong> : 997331</span></td>';
					}
					else
					{
						$grid .= '<td width="76%" style="text-align:left;">'.$descriptionline[1].'<br/>
						<span style="font-size:+7" ><strong>Purchase Type</strong> : '.$descriptionline[2].'&nbsp;/&nbsp;<strong>Usage Type</strong> :'.$descriptionline[3].'&nbsp;&nbsp;/ &nbsp;<strong>PIN Number : <font color="#000000">'.$descriptionline[4].'</font></strong> (<strong>Serial</strong> : '.$descriptionline[5].')</span><br/><span style="font-size:+6" ><strong>Product Description</strong> : '.$productdesvalue.' </span><span style="font-size:+6" > / <strong>SAC</strong> : 998434</span></td>';
					}
				}					
			/*$grid .= '<td width="76%" style="text-align:left;">'.$descriptionline[1].'<br/>
		<span style="font-size:+7" ><strong>Purchase Type</strong> : '.$descriptionline[2].'&nbsp;/&nbsp;<strong>Usage Type</strong> :'.$descriptionline[3].'&nbsp;&nbsp;/ &nbsp;<strong>PIN Number : <font color="#000000">'.$descriptionline[4].'</font></strong> (<strong>Serial</strong> : '.$descriptionline[5].')</span><br/><span style="font-size:+6" ><strong>Product Description</strong> : '.$productdesvalue.' </span><span style="font-size:+6" > / <strong>SAC</strong> : 997331</span></td>';*/
				$grid .= '<td  width="14%" style="text-align:right;" >'.formatnumber($descriptionline[6]).$appendzero.'</td>';
				$grid .= "</tr>";
			
				$final_amount = $final_amount + $descriptionline[6];
                                $incno++;
                                $countslno++;
				}
			//}
		}
		$itembriefdescription = $fetch['itembriefdescription'];
		$itembriefdescriptionsplit = explode('#',$itembriefdescription);
		$servicedescriptionsplit = explode('*',$fetch['servicedescription']);
		$servicedescriptioncount = count($servicedescriptionsplit);

		// $code0 = array("Saral RDP","Web Hosting - New");
		// $code1 = array("SPP Customization","Employee Information Portal (EIP- SPP)","Time Attendance Solution (T&A-SPP)","Attendance Integration","SPP-Forms Manager",
		// "SPP-Advance Report Editor","Digital Signing","Deployment Charges","Saral Accounts Customization","Employee Information Portal Updation","SPP Customization Updation","Web Hosting Updation",
		// "Employee Information Portal Mobile","Saral Billing Customization","Saral GST Cloud - V1 - (2020-21)","AMC Charges - GSP","SPP Cloud Payroll With ESS - Diamond","SPP Cloud Payroll With ESS","SPP Cloud Payroll With ESS - Gold","SPP Cloud Payroll With ESS - Platinum","SPP Cloud Payroll With ESS - Silver","SPP Customization - New",
		// "Saral PayPack Cloud","Saral PayPack Cloud - Bronze","Saral PayPack Cloud - Gold","Saral PayPack Cloud - Silver","SPP Customization - New","SU to MU","Bronze to Gold","Gold SU to Gold MU","Gold SU to Gold subscription NEW MU",
		// "Gold SU to Gold subscription NEW MU","Bronze UP SU to Diamond UP MU","Bronze NEW SU to Bronze subscription NEW MU","Bronze SU UP to Gold MU UP","Upgradation charges -Taxation","Gold to Diamond");
		// $code2 = array("Implementation","Support Charges","Payroll Processing","AMC Charges","XBRL Outsourcing","AMC Charges-Matrix-Comprehensive","AMC Charges - TDS ","AMC Charges-Matrix-Non Comprehensive",
		// "Employee Information Portal - AMC","AMC Charges - Accounts","AMC Charges - Billing","AMC Charges - Add-on Module(ARE/AI/FM)","AMC Charges - GST","API CHARGES","GSP CHARGES/API CALLS","API Consumption",
		// "API Integration -GST E-Invoicing","Implementation - Taxation","API Integration -GST E-Invoicing","Implementation - Taxation","Support Charges - PayPack","Support Charges - Taxation","Support Charges - Accounts","AMC Charges - PayPack","SPP Implementation","AMC Charges -E-sign");

		if($fetch['servicedescription'] <> '')
		{
			for($i=0; $i<$servicedescriptioncount; $i++)
			{
				$itemdesvalue = '';
				$servicedescriptionline = explode('$',$servicedescriptionsplit[$i]);
				if($itembriefdescription <> '')
					$itemdesvalue = $itembriefdescriptionsplit[$i];
				else
					$itemdesvalue = 'Not Available';
					
				$grid .= '<tr>';
				$grid .= '<td width="10%" style="text-align:centre;">'.$countslno.'</td>';
				
				if($checkInvoicedate < $checkJuly) {
				$grid .= '<td width="76%" style="text-align:left;">'.$servicedescriptionline[1].'<br/><span style="font-size:+6" ><strong>Item Description</strong> : '.$itemdesvalue.' </span></td>';
				} 
			    else 
			    {
					$servicequery = "select servicecode from inv_mas_service where servicename = '".$servicedescriptionline[1]."'";
					$servicefetch = runmysqlqueryfetch($servicequery);
					$servicecode[] = $servicefetch['servicecode'];

			    	if($checkInvoicedate1 < $checkMarch ||  in_array('997331', $servicecode, true))
						$grid .= '<td width="76%" style="text-align:left;">'.$servicedescriptionline[1].'<br/><span style="font-size:+6" ><strong>Item Description</strong> : '.$itemdesvalue.' </span> / <span style="font-size:+6" ><strong>SAC:</strong> 997331</span></td>';
					else if(in_array('998434', $servicecode, true)) 
						$grid .= '<td width="76%" style="text-align:left;">'.$servicedescriptionline[1].'<br/><span style="font-size:+6" ><strong>Item Description</strong> : '.$itemdesvalue.' </span> / <span style="font-size:+6" ><strong>SAC:</strong> 998434</span></td>';
					else if(in_array('998313', $servicecode, true))
						$grid .= '<td width="76%" style="text-align:left;">'.$servicedescriptionline[1].'<br/><span style="font-size:+6" ><strong>Item Description</strong> : '.$itemdesvalue.' </span> / <span style="font-size:+6" ><strong>SAC:</strong> 998313</span></td>';
					else
						$grid .= '<td width="76%" style="text-align:left;">'.$servicedescriptionline[1].'<br/><span style="font-size:+6" ><strong>Item Description</strong> : '.$itemdesvalue.' </span> / <span style="font-size:+6" ><strong>SAC:</strong> 999293</span></td>';

				}	
				$grid .= '<td  width="14%" style="text-align:right;" >'.formatnumber($servicedescriptionline[2]).$appendzero.'</td>';
				$grid .= "</tr>";
				$final_amount = $final_amount + $servicedescriptionline[2];
                                $countslno++;
                            
			}
		}
		
		$offerdescriptionsplit = explode('*',$fetch['offerdescription']);
		$offerdescriptioncount = count($offerdescriptionsplit);
		if($fetch['offerdescription'] <> '')
		{
		    $grid .= '<tr><td width="10%" style="text-align:centre;">&nbsp;</td><td width="76%" style="text-align:left;">Gross Amount</td><td  width="14%" style="text-align:right;" >'.formatnumber($final_amount).$appendzero.'</td></tr>';
		    
			for($i=0; $i<$offerdescriptioncount; $i++)
			{
				$offerdescriptionline = explode('$',$offerdescriptionsplit[$i]);
				$grid .= '<tr>';
				$grid .= '<td width="10%" style="text-align:centre;">&nbsp;</td>';
				
				if($offerdescriptionline[0] == 'percentage' || $offerdescriptionline[0] == 'amount')
				{
				    $grid .= '<td width="76%" style="text-align:left;">'.$offerdescriptionline[1].'</td>';
				}
				else
				{
				    $grid .= '<td width="76%" style="text-align:left;">'.strtoupper($offerdescriptionline[0]).': '.$offerdescriptionline[1].'</td>';
				}
				
				$grid .= '<td  width="14%" style="text-align:right;" >'.formatnumber($offerdescriptionline[2]).'</td>';
				$grid .= "</tr>";
			}
		}

		if($fetch['offerremarks'] <> '')
			$grid .= '<tr><td width="10%"></td><td width="76%" style="text-align:left;">'.$fetch['offerremarks'].'</td><td width="14%">&nbsp;</td></tr>';
		$descriptionlinecount = 0;
		if($description <> '')
		{
			//Add description "Internet downloaded software"
			$grid .= '<tr><td width="10%"></td><td width="76%" style="text-align:center;"><font color="#666666">INTERNET DOWNLOADED SOFTWARE</font></td><td width="14%">&nbsp;</td></tr>';
			$descriptionlinecount = 1;
		}
		if($fetch['description'] == '')
			$offerdescriptioncount = 0;
		else
			$offerdescriptioncount = count($descriptionsplit);
		if($fetch['offerdescription'] == '')
			$descriptioncount = 0;
		else
			$descriptioncount = count($descriptionsplit);
		if($fetch['servicedescription'] == '')
			$servicedescriptioncount = 0;
		else
			$servicedescriptioncount = count($servicedescriptionsplit);
		$rowcount = $offerdescriptioncount + $descriptioncount + $servicedescriptioncount + $descriptionlinecount;
		if($rowcount < 6)
		{
			$grid .= addlinebreak($rowcount);

		}
		
		if($fetch['status'] == 'EDITED')
		{
			$query011 = "select * from inv_mas_users where slno = '".$fetch['editedby']."';";
			$resultfetch011 = runmysqlqueryfetch($query011);
			$changedby = $resultfetch011['fullname'];
			$statusremarks = 'Last updated by  '.$changedby.' on '.changedateformatwithtime($fetch['editeddate']).' <br/>Remarks: '.$fetch['editedremarks'];
		}
		elseif($fetch['status'] == 'CANCELLED')
		{
			$query011 = "select * from inv_mas_users where slno = '".$fetch['cancelledby']."';";
			$resultfetch011 = runmysqlqueryfetch($query011);
			$changedby = $resultfetch011['fullname'];
			$statusremarks = 'Cancelled by '.$changedby.' on '.changedateformatwithtime($fetch['cancelleddate']).'  <br/>Remarks: '.$fetch['cancelledremarks'];

		}
		else
			$statusremarks = '';
			//echo($statusremarks); exit;
			
		$invoicedatedisplay = substr($fetch['createddate'],0,10);
		$invoicedate =  strtotime($invoicedatedisplay);
		$expirydate = strtotime('2012-04-01');
		$expirydate1 = strtotime('2015-06-01');
		$expirydate2 = strtotime('2015-11-15');
		$KK_Cess_date = strtotime('2016-05-31');
		
		//$gst_date = '2017-06-08'; // used to get date from gst_rates
		$gst_date = date('Y-m-d');
		$gst_tax_date = strtotime('2017-07-01');
		
		
		//gst rate fetching
		
		$gst_tax_query= "select igst_rate,cgst_rate,sgst_rate from gst_rates where from_date <= '$gst_date' AND to_date >= '$gst_date'";
		$gst_tax_result = runmysqlqueryfetch($gst_tax_query);
		$igst_tax_rate = $gst_tax_result['igst_rate'];
		$cgst_tax_rate = $gst_tax_result['cgst_rate'];
		$sgst_tax_rate = $gst_tax_result['sgst_rate'];
		
		//gst rate fetching ends
		/*----------------------------*/
		$custpan = "";
        $search_customer =  str_replace("-","",$fetch['customerid']);
        $customer_details = "select inv_mas_customer.gst_no as gst_no,inv_mas_customer.sez_enabled as sez_enabled,
        inv_mas_district.statecode as state_code,inv_mas_state.statename as statename
        ,inv_mas_state.state_gst_code as state_gst_code,panno from inv_mas_customer 
        left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
        left join inv_mas_state on inv_mas_state.statecode = inv_mas_district.statecode 
        where inv_mas_customer.customerid like '%".$search_customer."%'";

        $fetch_customer_details = runmysqlqueryfetch($customer_details);
		$custpan = $fetch_customer_details['panno'];

        if(is_numeric($fetch_customer_details['gst_no']))
        {
        	if($resultfetch1['gst_no']!= "" && $resultfetch1['gst_no']!= '0')
        	{
	        	$query_gst_last_no = "select customer_gstin_logs.gst_no as new_gst_no from customer_gstin_logs
	        	left join inv_invoicenumbers on customer_gstin_logs.gstin_id = inv_invoicenumbers.gst_no
	        	where inv_invoicenumbers.gst_no=".$resultfetch1['gst_no']." order by gstin_id desc limit 1";
	        	$fetch_gst_last_no = runmysqlqueryfetch($query_gst_last_no);
	        	$new_gst_no = $fetch_gst_last_no['new_gst_no'];
	        	$customer_gst_code = substr($fetch_gst_last_no['new_gst_no'], 0, 2);
	        }
	        else if($resultfetch1['gst_no'] == '0')
	        {
				//echo "hi";
	        	$customer_gst_code = "";
	        }
	        else
	        {
	        	$querygstgetdetail = "select gst_no as new_gst_no from customer_gstin_logs where customer_slno = right($search_customer,5) and gstin_id = ".$fetch_customer_details['gst_no'];
				$fetchgstgetdetail = runmysqlqueryfetch($querygstgetdetail);
			
				$new_gst_no = $fetchgstgetdetail['new_gst_no'];
				$customer_gst_code = substr($fetchgstgetdetail['new_gst_no'], 0, 2);
	        }
        	
			
    	}
    	else
    	{
    		if($resultfetch1['gst_no']!= "" && $resultfetch1['gst_no']!= '0')
        	{
	        	$query_gst_last_no = "select customer_gstin_logs.gst_no as new_gst_no from customer_gstin_logs
	        	left join inv_invoicenumbers on customer_gstin_logs.gstin_id = inv_invoicenumbers.gst_no
	        	where inv_invoicenumbers.gst_no=".$resultfetch1['gst_no']." order by gstin_id desc limit 1";
	        	$fetch_gst_last_no = runmysqlqueryfetch($query_gst_last_no);
	        	$new_gst_no = $fetch_gst_last_no['new_gst_no'];
	        	$customer_gst_code = substr($fetch_gst_last_no['new_gst_no'], 0, 2);
	        }
	        else if($resultfetch1['gst_no'] == '0')
	        {
	        	$new_gst_no= "";
	        	$customer_gst_code = "";
	        }
	        else
	        {
    			$new_gst_no = $fetch_customer_details['gst_no'];
    			$customer_gst_code = substr($fetch_customer_details['state_gst_code'], 0, 2);
    		}

    	}
        
        //$customer_gstin = substr($fetch_customer_details['gst_no'],0,2);
        //$state_details = "select statename,state_gst_code from inv_mas_state where statecode = '".$customer_gstin."'";
        
        //echo $state_details;
        //exit();
        //$fetch_state_details = runmysqlqueryfetch($state_details);
       
       /*---------------------------*/

		//echo $invoicedate ;echo $sb_expirydate;
		//echo $invoicedate; echo $sb_expirydate; 
			
		/*-----------------SEZ and NON-SEZ Check---------------------------*/



		if($fetch['seztaxtype'] == 'yes' || $fetch_customer_details['sez_enabled'] == 'yes')
		{
			if($fetch['seztaxtype'] == 'yes')
			{
			    $sezremarks = 'TAX NOT APPLICABLE AS CUSTOMER IS UNDER SPECIAL ECONOMIC ZONE.<br/>';
			}			
			
			if($gst_tax_date <= $invoicedate)
		    {
		        /*$igst_tax_amount = roundnearestvalue($fetch['amount'] * ($igst_tax_rate/100));
            	$gst_tax_column ='<tr><td  width="56%" style="text-align:right"></td>*/
            	
            	//echo $fetch['cgst'];
            	//exit();
            	
            	//if($fetch['igst'] != 0 || $fetch['seztaxtype'] == 'yes')
            	if($fetch['cgst']!= '0' &&  $fetch['sgst']!= '0' && $customer_gst_code == 29)
            	{
					$gst_tax_column ='<tr><td  width="56%" style="text-align:right"></td><td  width="30%" style="text-align:right"><strong>CGST Tax @'.$cgst_tax_rate.'% </strong></td><td width="14%" style="text-align:right;font-size:+9">'.formatnumber($fetch['cgst']).'</td></tr><tr><td  width="56%" style="text-align:right"></td><td  width="30%" style="text-align:right"><strong>SGST Tax @'.$sgst_tax_rate.'% </strong></td><td width="14%" style="text-align:right;font-size:+9">'.formatnumber($fetch['sgst']).'</td></tr>';
            	}
            	else
            	{
					$gst_tax_column ='<tr><td  width="56%" style="text-align:right"></td><td  width="30%" style="text-align:right"><strong>IGST Tax @'.$igst_tax_rate.'% </strong></td><td width="14%" style="text-align:right;font-size:+9">'.formatnumber($fetch['igst']).'</td></tr>';
            	}
            	
            	
            	//echo $gst_tax_column;
            	//echo "mine";
		        //exit();
		    }
		    else
		    {
		        //echo "Good Here";
		        //exit();
            			if($expirydate >= $invoicedate || $expirydate1 > $invoicedate)
            			{
            				$servicetax1 = 0;
            				$servicetax2 = 0;
            				$servicetax3 = 0;
            			
            				$servicetaxname = '<br/>Cess @ 2%<br/>Sec Cess @ 1%';
            				$totalservicetax = formatnumber($servicetax1).$appendzero.'<br/>'.formatnumber($servicetax2).$appendzero.'<br/>'.
            				formatnumber($servicetax3).$appendzero;
            			}
            			else if($expirydate2 > $invoicedate)
            			{
            				$servicetax1 = 0;
            				$totalservicetax = formatnumber($servicetax1).$appendzero;
            			}
            			else
            			{
            				$servicetax1 = 0;
            				$totalservicetax = formatnumber($servicetax1).$appendzero;
            				$servicetaxname1 = 'SB Cess @ 0.5%';
            				$servicetax2 = 0;
            				$servicetaxname2 = 'KK Cess @ 0.5%';
            				$servicetax3 = 0;
            				$totalservicetax1 = $servicetax2.$appendzero;
            				
            				$sbcolumn = '<tr><td  width="56%" style="text-align:left">&nbsp;</td>
            				<td  width="30%" style="text-align:right"><strong>'.$servicetaxname1.'</strong></td>
            				<td  width="14%" style="text-align:right"><span style="font-size:+9" >'.$totalservicetax1.'</span>
            				</td></tr>';
                        	if($KK_Cess_date < $invoicedate)
                        		{
                        			$kkcolumn = '<tr><td  width="56%" style="text-align:left">&nbsp;</td>
                        			<td  width="30%" style="text-align:right"><strong>'.$servicetaxname2.'</strong></td>
                        			<td  width="14%" style="text-align:right"><span style="font-size:+9" >'.$totalservicetax1.'</span>
                        				</td></tr>';
                        		}
            			}
		    }
		    
		            $billdatedisplay = changedateformat(substr($fetch['createddate'],0,10));
				$grid .= '<tr>
				<td  width="56%" style="text-align:left"><span style="font-size:+6" >Accounting Code For Service</span></td>
				<td  width="30%" style="text-align:right"><strong>Net Amount</strong></td>
				<td  width="14%" style="text-align:right">'.formatnumber($fetch['amount']).$appendzero.'</td></tr>
				<tr>
				<td  width="56%" style="text-align:left"><span style="font-size:+6;color:#FF0000" >'.$sezremarks.'</span><span style="font-size:+6;color:#FF0000" >'.$statusremarks.'</span></td>
				<td  width="30%" style="text-align:right"><span style="font-size:+9" ><strong>'.$servicetaxname.'</strong></span></td><td width="14%" style="text-align:right"><span style="font-size:+9" >'.$totalservicetax.'</span></td></tr>'.$sbcolumn .$kkcolumn.$gst_tax_column;
		}
		else
		{
		    if($gst_tax_date <= $invoicedate)
		    {
		        //echo "mine";
		        //echo $gst_tax_date."<br>"; 
		        //echo $invoicedate;
		        //exit();
		        
		        //echo $fetch['cgst'];
            //exit();
		        
		        //if($fetch_customer_details['state_code'] == '29')//if Relyon and Customer are in same State
		        if(($fetch['cgst'] != '0' &&  $fetch['sgst'] != '0'))
		        {
		           // $cgst_tax_amount = roundnearestvalue($fetch['amount'] * ($cgst_tax_rate/100));
		           // $sgst_tax_amount = roundnearestvalue($fetch['amount'] * ($sgst_tax_rate/100));
		            
                	$gst_tax_column ='<tr><td  width="56%" style="text-align:right"></td>
                	<td  width="30%" style="text-align:right"><strong>CGST Tax @'.$cgst_tax_rate.'% </strong></td>
                	<td width="14%" style="text-align:right;font-size:+9">'.formatnumber($fetch['cgst']).'</td></tr>';
                	
                	$gst_tax_column .='<tr><td  width="56%" style="text-align:right"></td>
                	<td  width="30%" style="text-align:right"><strong>SGST Tax @'.$sgst_tax_rate.'% </strong></td>
                	<td width="14%" style="text-align:right;font-size:+9">'.formatnumber($fetch['sgst']).'</td></tr>';
		        }
		        else
		        {
		            //$igst_tax_amount = roundnearestvalue($fetch['amount'] * ($igst_tax_rate/100));
                    
                    $gst_tax_column ='<tr><td  width="56%" style="text-align:right"></td>
                    <td  width="30%" style="text-align:right"><strong>IGST Tax @'.$igst_tax_rate.'% </strong></td>
                    <td width="14%" style="text-align:right;font-size:+9">'.formatnumber($fetch['igst']).'</td></tr>';
		        }

            	
            	
        $billdatedisplay = changedateformat(substr($fetch['createddate'],0,10));
		//echo($servicetax1.'#'.$servicetax2.'#'.$servicetax3); exit; // To be added Here
		$grid .= '<tr>
		<td  width="56%" style="text-align:left"><span style="font-size:+6" ></span></td>
		<td  width="30%" style="text-align:right"><strong>Net Amount</strong></td>
		<td  width="14%" style="text-align:right">'.formatnumber($fetch['amount']).$appendzero.'</td></tr>
		<tr>
		<td  width="56%" style="text-align:left"><span style="font-size:+6;color:#FF0000" >'.$sezremarks.'</span><span style="font-size:+6;color:#FF0000" >'.$statusremarks.'</span></td>
		<td  width="30%" style="text-align:right"><span style="font-size:+9" ><strong>'.$servicetaxname.'</strong></span></td><td width="14%" style="text-align:right"><span style="font-size:+9" >'.$totalservicetax.'</span></td></tr>'.$sbcolumn .$kkcolumn.$gst_tax_column;
		    
		        
		    }
		    else
		    {
		        //echo "minetrtrt";
		        //echo $gst_tax_date."<br>"; 
		        //echo $invoicedate;
		        //exit();
            			if($expirydate >= $invoicedate)
            			{
            				$servicetax1 = roundnearestvalue($fetch['amount'] * 0.1);
            				$servicetax2 = roundnearestvalue($servicetax1 * 0.02);
            				$servicetaxname = 'Service Tax @ 10% <br/>Cess @ 2%<br/>Sec Cess @ 1%';
            				$servicetax3 = roundnearestvalue(($fetch['amount'] * 0.103) - (($servicetax1) + ($servicetax2)));
            				$totalservicetax = formatnumber($servicetax1).$appendzero.'<br/>'.formatnumber($servicetax2).$appendzero.'<br/>'.formatnumber($servicetax3).$appendzero;
            			}
            			else if($expirydate1 > $invoicedate)
            			{
            				$servicetax1 = roundnearestvalue($fetch['amount'] * 0.12);
            				$servicetax2 = roundnearestvalue($servicetax1 * 0.02);
            				$servicetaxname = 'Service Tax @ 12% <br/>Cess @ 2%<br/>Sec Cess @ 1%';
            				$servicetax3 = roundnearestvalue(($fetch['amount'] * 0.1236) - (($servicetax1) + ($servicetax2)));
            				$totalservicetax = formatnumber($servicetax1).$appendzero.'<br/>'.formatnumber($servicetax2).$appendzero.'<br/>'.formatnumber($servicetax3).$appendzero;
            			}
            			else if($expirydate2 > $invoicedate)
            			{
            				$servicetax1 = roundnearestvalue($fetch['amount'] * 0.14);
            				$servicetaxname = 'Service Tax @ 14%';
            				$totalservicetax = formatnumber($servicetax1).$appendzero;
            			}
            			else
            			{
            				$servicetax1 = roundnearestvalue($fetch['amount'] * 0.14);
            				$servicetax2 = roundnearestvalue($fetch['amount'] * 0.005);
            				$servicetaxname = 'Service Tax @ 14%';
            				$servicetaxname1 = 'SB Cess @ 0.5%';
            				$totalservicetax = formatnumber($servicetax1).$appendzero;
            				$totalservicetax1 = formatnumber($servicetax2).$appendzero;
            				
            				$sbcolumn = '<tr><td  width="56%" style="text-align:left">&nbsp;</td>
            				<td  width="30%" style="text-align:right"><strong>'.$servicetaxname1.'</strong></td>
            				<td  width="14%" style="text-align:right"><span style="font-size:+9" >'.$totalservicetax1.'</span>
            				</td></tr>';
            
            				if($KK_Cess_date < $invoicedate)
            				{
            	               $KK_Cess_tax = roundnearestvalue($fetch['amount'] * 0.005);
            				   $kkcolumn='<tr><td  width="56%" style="text-align:right"></td><td  width="30%" style="text-align:right"><strong>KK Cess @ 0.5% </strong></td><td width="14%" style="text-align:right;font-size:+9">'.formatnumber($KK_Cess_tax).$appendzero.'</td></tr>';
            				}
            			}
            			
            			
            			$billdatedisplay = changedateformat(substr($fetch['createddate'],0,10));
		//echo($servicetax1.'#'.$servicetax2.'#'.$servicetax3); exit; // To be added Here
		$grid .= '<tr>
		<td  width="56%" style="text-align:left"><span style="font-size:+6" >'.$fetch['servicetaxdesc'].' </span></td>
		<td  width="30%" style="text-align:right"><strong>Net Amount</strong></td>
		<td  width="14%" style="text-align:right">'.formatnumber($fetch['amount']).$appendzero.'</td></tr>
		<tr>
		<td  width="56%" style="text-align:left"><span style="font-size:+6;color:#FF0000" >'.$sezremarks.'</span><span style="font-size:+6;color:#FF0000" >'.$statusremarks.'</span></td>
		<td  width="30%" style="text-align:right"><span style="font-size:+9" ><strong>'.$servicetaxname.'</strong></span></td><td width="14%" style="text-align:right"><span style="font-size:+9" >'.$totalservicetax.'</span></td></tr>'.$sbcolumn .$kkcolumn.$gst_tax_column;
		    }//else condition ends		
			
			$sezremarks = '';
			
		}




	/*-----------------Round Off ----------------------*/
	$roundoff = 'false';
	$roundoff_value = '';
	$addition_amount = $fetch['amount']+$fetch['igst']+$fetch['cgst']+$fetch['sgst']+$fetch['kktax']+$fetch['sbtax']+$fetch['servicetax'];
	//echo $addition_amount;
	$roundoff_value = ($fetch['netamount'])- ($addition_amount);
	//echo $fetch['netamount'] . "amount ". $addition_amount;
	if($roundoff_value != 0 || $roundoff_value != 0.00)
	{
	$roundoff = 'true';
	}
	/* if($addition_amount > $fetch['netamount'])
	{
	$roundoff_value = ($addition_amount)- ($fetch['netamount']);
	$roundoff = 'true';
	}
	else if( $addition_amount < $fetch['netamount'])
	{
		$roundoff_value = ($fetch['netamount']) - ($addition_amount);
		$roundoff = 'true';
	}
	else
	{ 
		$roundoff_value = '';
		$roundoff = 'false';
	}*/

	/*----Round Off Done ---------------------------*/

	/*----Round Off Done ---------------------------*/


	/*------------------Check Ends --------------------------*/

	if($roundoff == 'true')
	{
		$roundoff_value = number_format($roundoff_value,2);
	$grid .= '<tr>
	<td  width="56%" style="text-align:right"><div align="left"></div></td>
	<td  width="30%" style="text-align:right"><strong>Round Off</strong></td>
	<td  width="14%" style="text-align:right">&nbsp;&nbsp;'.$roundoff_value.'</td> 
	</tr>';
	}

	$grid .= '<tr>
	<td  width="56%" style="text-align:right"><div align="left"><span style="font-size:+6" >E.&amp;O.E.</span></div></td>
	<td  width="30%" style="text-align:right"><strong>Total</strong></td>
	<td  width="14%" style="text-align:right"><img src="../images/relyon-rupee-small.jpg" width="8" height="8" border="0" alt="Relynsoft" align="absmiddle"  />&nbsp;&nbsp;'.formatnumber($fetch['netamount'] ).$appendzero.'</td> 
	</tr><tr><td colspan="3" style="text-align:left"><strong>Rupee In Words</strong>: '.convert_number($fetch['netamount']).' only</td></tr>';

	//echo($grid); exit;
	//	$grid .= '<tr><td colspan="2" style="text-align:right" width="86%"><strong>Total</strong></td><td  width="14%" style="text-align:right">'.$fetch['amount'].$appendzero.'</td></tr><tr><td  width="56%" style="text-align:left"><span style="font-size:+6" >'.$fetch['servicetaxdesc'].$appendzero.' </span></td><td  width="30%" style="text-align:right"><strong>Service Tax @ 10.3%</strong></td><td  width="14%" style="text-align:right">'.$fetch['servicetax'].$appendzero.'</td></tr><tr><td  width="56%" style="text-align:right"><div align="left"><span style="font-size:+6" >E.&amp;O.E.</span></div></td><td  width="30%" style="text-align:right"><strong>Net Amount</strong></td><td  width="14%" style="text-align:right"><img src="../images/relyon-rupee-small.jpg" width="8" height="8" border="0" alt="Relynsoft" align="absmiddle"  />&nbsp;&nbsp;'.$fetch['netamount'].$appendzero.'</td> </tr><tr><td colspan="3" style="text-align:left"><strong>Rupee In Words</strong>: '.$fetch['amountinwords'].' only</td></tr>';
	  }

	$grid .='</table></td></tr></table>';
	
	//to fetch dealer email id 
	$query0 = "select inv_mas_dealer.emailid as dealeremailid,cell as dealercell from inv_mas_dealer where inv_mas_dealer.slno = '".$fetchresult['dealerid']."';";
	$fetch0 = runmysqlqueryfetch($query0);
	$dealeremailid = $fetch0['dealeremailid'];
	$dealercell = $fetch0['dealercell'];


	if($fetchresult['status'] == 'CANCELLED')
	{
		$color = '#FF3300';
		$invoicestatus = '( '.$fetchresult['status'].' )';
	}
	else if($fetchresult['status'] == 'EDITED')
	{
		$color = '#006600';
		$invoicestatus = '( '.$fetchresult['status'].' )';
	}
	else
	{
		$invoicestatus = '';
	}
	
	$podatepiece = (($fetchresult['podate'] == "0000-00-00") || ($fetchresult['podate'] == ''))?("Not Available"):(changedateformat($fetchresult['podate']));
	$poreferencepiece = ($fetchresult['poreference'] == "")?("Not Available"):($fetchresult['poreference']);
	if(strtotime($invoicenewformate) <= strtotime($newyeardate))
	{
	  $msg = file_get_contents("../pdfbillgeneration/bill-format-old.php");
	}
	else
	{
		$msg = file_get_contents("../pdfbillgeneration/bill-format-new.php");
	}
	if($gst_tax_date <= $invoicedate)
	{
		if($fetchresult['irn']== "")
	   	 	$msg = file_get_contents("../pdfbillgeneration/bill-format-gst.php");
		else
			$msg = file_get_contents("../pdfbillgeneration/bill-format-gst-irn.php");
	}
	
	if($fetchresult['module'] == 'dealer_module')
		$image_path = '../../dealer/qrimages/'.$fetchresult['qrimagepath']; 
	else
		$image_path = '../../user/qrimages/'.$fetchresult['qrimagepath']; 
	$print = '<div><img src="'.$image_path .'"></div>';
	
	$array = array();
	$stdcode = $fetchresult['stdcode'];
	$array[] = "##BILLDATE##%^%".$billdatedisplay;
	$array[] = "##BILLNO##%^%".$fetchresult['invoiceno'];
	$array[] = "##STATUS##%^%".$invoicestatus;
	$array[] = "##color##%^%".$color;
	$array[] = "##DEALERDETAILS##%^%".'Email: '.$dealeremailid.' | Cell: '.$dealercell;
	$array[] = "##BUSINESSNAME##%^%".$fetchresult['businessname'];
	$array[] = "##CONTACTPERSON##%^%".$fetchresult['contactperson'];
	$array[] = "##ADDRESS##%^%".stripslashes ( stripslashes ( $fetchresult['address']));
	$array[] = "##CUSTOMERID##%^%".$fetchresult['customerid'];
	$array[] = "##EMAILID##%^%".$fetchresult['emailid'];
	$array[] = "##PHONE##%^%".$fetchresult['phone'];
	$array[] = "##CELL##%^%".$fetchresult['cell'];
	$array[] = "##STDCODE##%^%".$stdcode;
	$array[] = "##CUSTOMERTYPE##%^%".$fetchresult['customertype'];
	$array[] = "##CUSTOMERCATEGORY##%^%".$fetchresult['customercategory'];
	$array[] = "##RELYONREP##%^%".$fetchresult['dealername'];
	$array[] = "##REGION##%^%".$fetchresult['region'];
	$array[] = "##BRANCH##%^%".$fetchresult['branch'];
	$array[] = "##PAYREMARKS##%^%".$fetchresult['remarks'];
	$array[] = "##INVREMARKS##%^%".$fetchresult['invoiceremarks'];
	$array[] = "##GENERATEDBY##%^%".$fetchresult['createdby'];
	$array[] = "##INVOICEHEADING##%^%".$fetchresult['invoiceheading'];
	$array[] = "##PODATE##%^%".$podatepiece;
	$array[] = "##POREFERENCE##%^%".$poreferencepiece;
	
	$array[] = "##INVOICEDT##%^%".$resultfetch1['createddate'];
	$array[] = "##IRN##%^%".$fetchresult['irn'];
	$array[] = "##qrimage##%^%".$print;
	
	if($new_gst_no != '')
	{
		$array[] = "##CUSTOMERGSTIN##%^%".$new_gst_no;
		$custpan = substr($new_gst_no,2,10);
		$array[] = "##CUSTOMERPAN##%^%".$custpan;
		
	}
	else
	{
	    $novalus = 'Not Registered Under GST';
	    $array[] = "##CUSTOMERGSTIN##%^%".$novalus;
		$array[] = "##CUSTOMERPAN##%^%".$custpan;
	}
    $array[] = "##POP##%^%".$fetch_customer_details['statename'];
    $array[] = "##CODE##%^%".$fetch_customer_details['state_gst_code'];
    
	
	$array[] = "##TABLE##%^%".$grid;
	
	
	    if(($resultfetch1['deduction'] == '1') && ($resultfetch1['tanno'] != ''))
        {
          $array[] = "##NOTE##%^%".$note;
          $array[] = "##CONTENT##%^%".$content;
        }
        else 
        {
           $note = "";$content = ""; $array[] = "##NOTE##%^%".$note;$array[] = "##CONTENT##%^%".$content;
        }
        
	
	$html = replacemailvariable($msg,$array);
	$pdf->WriteHTML($html,true,0,true);
		
	$localtime = date('His');
	$filename = str_replace('/','-',$fetchresult['invoiceno']);
	$filebasename = $filename.".pdf";
	$addstring ="/imax/implementation";
	if($_SERVER['HTTP_HOST'] == "bhumika" || $_SERVER['HTTP_HOST'] == "192.168.2.79")
		$addstring = "/rwm/SaraliMax-User";
		$filepath = $_SERVER['DOCUMENT_ROOT'].$addstring.'/filecreated/'.$filebasename;
	
	if($type == 'view')
	{
		//ob_end_clean();
		$pdf->Output($filename ,'I');	
	}
	else
	{
		$pdf->Output($filepath ,'F');
		return $filebasename.'^'.$fetchresult['businessname'].'^'.$fetchresult['invoiceno'].'^'.$fetchresult['emailid'].'^'.$fetchresult['customerid'].'^'.$dealeremailid.'^'.$invoicestatus.'^'.$fetchresult['status'].'^'.$fetchresult['contactperson'].'^'.$fetchresult['netamount'];
	}
	$pdf->writeHTML($html, true, false, true, false, '');

}

function vieworgeneratematrixpdfinvoice($slno,$type)
{
	ini_set('memory_limit', '2048M');
	require_once('../pdfbillgeneration/tcpdf.php');
	$query1 = "select * from inv_matrixinvoicenumbers where slno = '".$slno."';";
	$resultfetch1 = runmysqlqueryfetch($query1);
	$invoicestatus = $resultfetch1['status'];
	
	$checkInvoicedate = strtotime($resultfetch1['createddate']);
	$checkJuly = strtotime('2017-07-01 00:0:00');

	//for SAC code 2019-20 effective from 1st april
	$checkInvoicedate1 = strtotime($resultfetch1['createddate']);
	$checkMarch = strtotime('2019-04-01 00:0:00');
	
	$invoicenewformate= changedateformat(substr($resultfetch1['createddate'],0,10));
	$newyeardate = "31-03-2014";
	if($invoicestatus == 'CANCELLED')
	{
		// Extend the TCPDF class to create custom Header and Footer
		class MYPDF extends TCPDF {
		//Page header
		public function Header() {
			// full background image
			// store current auto-page-break status
			$bMargin = $this->getBreakMargin();
			$auto_page_break = $this->AutoPageBreak;
			$this->SetAutoPageBreak(false, 0);
			$img_file = K_PATH_IMAGES.'invoicing-cancelled-background.jpg';
			$this->Image($img_file, 0, 80, 820, 648, '', '', '', false, 75, '', false, false, 0);
			// restore auto-page-break status
			$this->SetAutoPageBreak($auto_page_break, $bMargin);
			}
		}
		
		// create new PDF document
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	}
	else
	{
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// remove default header
		$pdf->setPrintHeader(false);
	}

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	
	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
	//set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	

	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	//set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
	
	//set some language-dependent strings
	$pdf->setLanguageArray($l); 
	
	// remove default footer
	$pdf->setPrintFooter(false);
	
	// set font
	$pdf->SetFont('Helvetica', '', 10);
	
	// add a page
	//$pdf->AddPage();
	

	//Added 01.07.2017

	// set certificate file
    $certificate = 'file:///etc/digitalsign/relyon.crt';

    // set additional information
    $info = array(
        'Name' => 'Relyon Softech Ltd.',
        'Location' => 'Bangalore',
        'Reason' => 'Digitally Signed Invoice',
        'ContactInfo' => 'http://www.relyonsoft.com',
        );
	//Ends        
	
	// set font
	$pdf->SetFont('Helvetica', '', 10);
	
	// add a page
	$pdf->AddPage();
	
	//Added on 01.07.2017

     // set document signature
    $pdf->setSignature($certificate, $certificate, '123', '', 2, $info);
    
    // create content for signature (image and/or text)
    //$pdf->Image('../pdfbillgeneration/images/tcpdf_signature.png',5, 5, 15, 15, 'PNG');
   // $pdf->Image('../pdfbillgeneration/images/relyon-logo.png',130, 248, 65, 30, 'PNG');
    
    // define active area for signature appearance
    $pdf->setSignatureAppearance(130, 248, 65, 30);

	//Ends
	
	$final_amount = 0;
	$query = "select * from inv_matrixinvoicenumbers where slno = '".$slno."';";
	$result = runmysqlquery($query);
	$fetchresult = runmysqlqueryfetch($query);
	
	$appendzero = '.00';
	if(strtotime($invoicenewformate) <= strtotime($newyeardate))
	{
		$grid .='<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" >';
		$grid .='<tr><td ><table width="100%" border="1" cellspacing="0" cellpadding="4" bordercolor="#CCCCCC" style="border:1px solid">
		<tr bgcolor="#CCCCCC">
		<td width="10%"><div align="center"><strong>Sl No</strong></div></td>
		<td width="76%"><div align="center"><strong>Description</strong></div></td>
		<td width="5%"><div align="center"><strong>Quantity</strong></div></td>
		<td width="7%"><div align="center"><strong>Amount</strong></div></td>
		</tr>';
	}
	else
	{
		$grid .='<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" >';
		$grid .='<tr><td >
		<table width="100%" border="1" cellspacing="0" cellpadding="2" bordercolor="#CCCCCC" style="border:1px solid">
		<tr bgcolor="#CCCCCC">
		<td width="7%"><div align="center" ><strong>Sl No</strong></div></td>
		<td width="64%"><div align="center"><strong>Description</strong></div></td>
		<td width="5%"><div align="center"><strong>Qty</strong></div></td>
		<td width="12%"><div align="center"><strong>Rate</strong></div></td>
		<td width="12%"><div align="center"><strong>Amount</strong></div></td>
		</tr>';
	}
    
	$countslno=1;
	$list = [];
	while($fetch = mysqli_fetch_array($result))
	{
		$description = $fetch['description'];
		$descriptionsplit = explode('*',$description);
		$proquantity = $fetch['productquantity'];
		$proquantitysplit = explode(',',$proquantity);
		
		
		for($i=0,$j=0;$i<count($descriptionsplit),$j<count($proquantitysplit);$i++,$j++)
		{
			$productdesvalue = '';
			$descriptionline = explode('$',$descriptionsplit[$i]);
            
			$actualproductpricearraysplit = explode('*',$fetch['actualproductpricearray']);
			$productarray = explode('#',$fetchresult['products']);
			$servicequery = "select hsncode,`group` from inv_mas_matrixproduct where id = '".$productarray[$i]."'";
			$servicefetch = runmysqlqueryfetch($servicequery);
			$servicecode = $servicefetch['hsncode'];
			$group = $servicefetch['group'];
			$progroup = ($group == 'Hardware') ? 'HSN' : 'SAC';
			$progroup1 = ($group == 'Hardware') ? 'Hardware' : 'Services';
			if(!in_array((array)$progroup1, $list, true)){
				array_push($list, $progroup1);
			}
			
			$progroup = ($group == 'Hardware') ? 'HSN' : 'SAC';
			$progroup1 = ($group == 'Hardware') ? 'Hardware' : 'Software';
			if(!in_array($progroup1, $list, true)){
				array_push($list, $progroup1);
			}
			if($description <> '')
			{
				$grid .= '<tr>';
				$grid .= '<td width="7%" style="text-align:centre;">'.$countslno.'</td>';

				// if($checkInvoicedate < $checkJuly) 
				// {
				// 	$grid .= '<td width="64%" style="text-align:left;">'.$descriptionline[1].'<br/>
				// 	<span style="font-size:+7" ><strong>Purchase Type</strong> : '.$descriptionline[2].'&nbsp;/&nbsp;<strong>Usage Type</strong> :'.$descriptionline[3].'&nbsp;&nbsp;/ &nbsp;<strong>PIN Number : <font color="#000000">'.$descriptionline[4].'</font></strong>&nbsp;/&nbsp;</span><br/><span style="font-size:+6" ><strong>Serial</strong> : '.$descriptionline[5].' </span></td>';
				// } 
			    // else 
			    // {
			    // 	if($checkInvoicedate1 < $checkMarch)
			    // 	{
				// 		$grid .= '<td width="64%" style="text-align:left;">'.$descriptionline[1].'<br/>
				// 		<span style="font-size:+7" ><strong>Purchase Type</strong> : '.$descriptionline[2].'&nbsp;/&nbsp;<strong>Usage Type</strong> :'.$descriptionline[3].'&nbsp;&nbsp; /&nbsp;</span><br/><span style="font-size:+6" ><strong>Serial</strong> : '.$descriptionline[4].' </span><span style="font-size:+6" > / <strong>SAC</strong> : 997331</span></td>';
				// 	}
				// 	else
				// 	{
				$grid .= '<td width="64%" style="text-align:left;">'.$descriptionline[1].'<br/>
				<span style="font-size:+7" ><strong>Purchase Type</strong> : '.$descriptionline[2].'&nbsp;</span><span style="font-size:+6" > / <strong>Serial</strong> : '.$descriptionline[3].' </span><span style="font-size:+6" > / <strong>'.$progroup.'</strong> : '.$servicecode.'</span></td>';
				// 	}
				// }
				$grid .= '<td width="5%"  style="text-align:right;" >'.$proquantitysplit[$j].'</td>';
				$grid .= '<td width="12%"  style="text-align:right;" >'.$actualproductpricearraysplit[$j].$appendzero.'</td>';				
				$grid .= '<td width="12%" style="text-align:right;" >'.formatnumber($descriptionline[4]).$appendzero.'</td>';
				$grid .= "</tr>";
			
				$final_amount = $final_amount + (int)$descriptionline[6];
                                $incno++;
                                $countslno++;
			}
		}
		$producttype = (in_array('Hardware',$list)) ? 'Goods' : 'Services';
		
		$descriptionlinecount = 0;
		if($description <> '')
		{
			//Add description "Internet downloaded software"
			// $grid .= '<tr>
			// <td ></td>
			// <td  style="text-align:center;"><font color="#666666">INTERNET DOWNLOADED SOFTWARE</font></td>
			// <td >&nbsp;</td>
			// <td >&nbsp;</td>
			// <td >&nbsp;</td>
			// </tr>';
			$descriptionlinecount = 1;
		}
		$rowcount = $descriptionlinecount + $servicedescriptioncount;
		if($rowcount < 6)
		{
			$grid .= addmatrixlinebreak($rowcount);

		}		
		
		if($fetch['status'] == 'EDITED')
		{
			$query011 = "select * from inv_mas_users where slno = '".$fetch['editedby']."';";
			$resultfetch011 = runmysqlqueryfetch($query011);
			$changedby = $resultfetch011['fullname'];
			$statusremarks = 'Last updated by  '.$changedby.' on '.changedateformatwithtime($fetch['editeddate']).' <br/>Remarks: '.$fetch['editedremarks'];
		}
		elseif($fetch['status'] == 'CANCELLED')
		{
			$query011 = "select * from inv_mas_users where slno = '".$fetch['cancelledby']."';";
			$resultfetch011 = runmysqlqueryfetch($query011);
			$changedby = $resultfetch011['fullname'];
			$statusremarks = 'Cancelled by '.$changedby.' on '.changedateformatwithtime($fetch['cancelleddate']).'  <br/>Remarks: '.$fetch['cancelledremarks'];

		}
		else
			$statusremarks = '';
			//echo($statusremarks); exit;
			
		$invoicedatedisplay = substr($fetch['createddate'],0,10);
		$invoicedate =  strtotime($invoicedatedisplay);
		$expirydate = strtotime('2012-04-01');
		$expirydate1 = strtotime('2015-06-01');
		$expirydate2 = strtotime('2015-11-15');
		$KK_Cess_date = strtotime('2016-05-31');
		
		//$gst_date = '2017-06-08'; // used to get date from gst_rates
		$gst_date = date('Y-m-d');
		$gst_tax_date = strtotime('2017-07-01');
		
		
		//gst rate fetching
		
		$gst_tax_query= "select igst_rate,cgst_rate,sgst_rate from gst_rates where from_date <= '$gst_date' AND to_date >= '$gst_date'";
		$gst_tax_result = runmysqlqueryfetch($gst_tax_query);
		$igst_tax_rate = $gst_tax_result['igst_rate'];
		$cgst_tax_rate = $gst_tax_result['cgst_rate'];
		$sgst_tax_rate = $gst_tax_result['sgst_rate'];
		
		//gst rate fetching ends
		/*----------------------------*/
		$new_gst_no = $fetch['gst_no'];
		$custpan = "";
        $search_customer =  str_replace("-","",$fetch['customerid']);
        $customer_details = "select inv_mas_customer.gst_no as gst_no,inv_mas_customer.sez_enabled as sez_enabled,
        inv_mas_district.statecode as state_code,inv_mas_state.statename as statename
        ,inv_mas_state.state_gst_code as state_gst_code,panno from inv_mas_customer 
        left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
        left join inv_mas_state on inv_mas_state.statecode = inv_mas_district.statecode 
        where inv_mas_customer.customerid like '%".$search_customer."%'";

        $fetch_customer_details = runmysqlqueryfetch($customer_details);
		$statename = $fetch_customer_details['statename'];
		$statecode = $fetch_customer_details['state_gst_code'];
		$custpan = $fetch_customer_details['panno'];
		
        
		if($gst_tax_date <= $invoicedate)
		{
			//echo "mine";
			//echo $gst_tax_date."<br>"; 
			//echo $invoicedate;
			//exit();
			
			//echo $fetch['cgst'];
			//exit();
			
			$sezremarks = '';
			if($fetch['seztaxtype'] == 'yes')
			{
			    $sezremarks = 'TAX NOT APPLICABLE AS CUSTOMER IS UNDER SPECIAL ECONOMIC ZONE.<br/>';
			}
			//if($fetch_customer_details['state_code'] == '29')//if Relyon and Customer are in same State
			if(($fetch['cgst'] != '0' &&  $fetch['sgst'] != '0'))
			{
			// $cgst_tax_amount = roundnearestvalue($fetch['amount'] * ($cgst_tax_rate/100));
			// $sgst_tax_amount = roundnearestvalue($fetch['amount'] * ($sgst_tax_rate/100));
				
				$gst_tax_column ='<tr><td  width="53%" style="text-align:right"></td>
				<td  width="35%" style="text-align:right"><strong>CGST Tax @'.$cgst_tax_rate.'% </strong></td>
				<td width="12%" style="text-align:right;font-size:+9">'.formatnumber($fetch['cgst']).'</td></tr>';
				
				$gst_tax_column .='<tr><td  width="53%" style="text-align:right"></td>
				<td  width="35%" style="text-align:right"><strong>SGST Tax @'.$sgst_tax_rate.'% </strong></td>
				<td width="12%" style="text-align:right;font-size:+9">'.formatnumber($fetch['sgst']).'</td></tr>';
			}
			else
			{
				//$igst_tax_amount = roundnearestvalue($fetch['amount'] * ($igst_tax_rate/100));
				
				$gst_tax_column ='<tr>
				<td  width="53%" style="text-align:right"></td>
				<td  width="35%" style="text-align:right"><strong>IGST Tax @'.$igst_tax_rate.'% </strong></td>
				<td width="12%" style="text-align:right;font-size:+9">'.formatnumber($fetch['igst']).'</td></tr>';
			}

			
			$billdatedisplay = changedateformat(substr($fetch['createddate'],0,10));
			//echo($servicetax1.'#'.$servicetax2.'#'.$servicetax3); exit; // To be added Here
			$grid .= '<tr>
			<td  width="53%" style="text-align:left"><span style="font-size:+6" ></span></td>
			<td  width="35%" style="text-align:right"><strong>Net Amount</strong></td>
			<td  width="12%" style="text-align:right">'.formatnumber($fetch['amount']).$appendzero.'</td></tr>'.$gst_tax_column.
			'<tr>
			<td  width="53%" style="text-align:left"><span style="font-size:+6;color:#FF0000" >'.$sezremarks.'</span><span style="font-size:+6;color:#FF0000" >'.$statusremarks.'</span></td>
			<td  width="35%" style="text-align:right"></td>
			<td width="12%" style="text-align:right"></td></tr>';
		}
		       			

		$podatepiece = (($fetchresult['podate'] == "0000-00-00") || ($fetchresult['podate'] == ''))?("Not Available"):(changedateformat($fetchresult['podate']));
		$poreferencepiece = ($fetchresult['poreference'] == "")?("Not Available"):($fetchresult['poreference']);
		/*-----------------Round Off ----------------------*/
		$roundoff = 'false';
		$roundoff_value = '';
		$addition_amount = $fetch['amount']+$fetch['igst']+$fetch['cgst']+$fetch['sgst'];
		
		$roundoff_value = ($fetch['netamount'])- ($addition_amount);
		//echo $fetch['netamount'] . "amount ". $addition_amount;
		if($roundoff_value != 0 || $roundoff_value != 0.00)
		{
			$roundoff = 'true';
		}
		/* if($addition_amount > $fetch['netamount'])
		{
		$roundoff_value = ($addition_amount)- ($fetch['netamount']);
		$roundoff = 'true';
		}
		else if( $addition_amount < $fetch['netamount'])
		{
			$roundoff_value = ($fetch['netamount']) - ($addition_amount);
			$roundoff = 'true';
		}
		else
		{ 
			$roundoff_value = '';
			$roundoff = 'false';
		}*/

		/*----Round Off Done ---------------------------*/

		/*----Round Off Done ---------------------------*/


		/*------------------Check Ends --------------------------*/

		if($roundoff == 'true')
		{
			$roundoff_value = number_format($roundoff_value,2);
			$grid .= '<tr>
			<td  width="53%" style="text-align:right"><div align="left"></div></td>
			<td  width="35%" style="text-align:right"><strong>Round Off</strong></td>
			<td  width="12%" style="text-align:right">&nbsp;&nbsp;'.$roundoff_value.'</td> 
			</tr>';
		}

		$grid .= '<tr>
		<td  width="53%" style="text-align:right"><div align="left"><span style="font-size:+6" >E.&amp;O.E.</span></div></td>
		<td  width="35%" style="text-align:right"><strong>Total</strong></td>
		<td  width="12%" style="text-align:right"><img src="../images/relyon-rupee-small.jpg" width="8" height="8" border="0" alt="Relynsoft" align="absmiddle"  />&nbsp;&nbsp;'.formatnumber($fetch['netamount'] ).$appendzero.'</td> 
		</tr><tr><td colspan="3" style="text-align:left"><strong>Rupee In Words</strong>: '.convert_number($fetch['netamount']).' only</td></tr>';

		if($fetchresult['tdsdeclaration'] == 'yes')
		{
			$grid .= '<tr><td colspan="3" style="text-align:left"><strong>TDS Declararton for software</strong>: <br/>In Terms Of Notification No.21/2012 Dt.13 June 2012, We Hereby Declare That Transaction With 
			Remarks “ref. TDS Declaration” Is Software Acquired in A Subsequent Transfer And Is Transferred 
			Without Any Modification And Is Subjected to Tax Deduction At Source Under Section 194J 
			And/or Under Section 195 On Payment For The Previous Transfer Of Such Software. You Are Not 
			Required To Deduct Tax At Source On This Account.</td></tr>';
		}
		
			//echo($grid); exit;
			//	$grid .= '<tr><td colspan="2" style="text-align:right" width="86%"><strong>Total</strong></td><td  width="14%" style="text-align:right">'.$fetch['amount'].$appendzero.'</td></tr><tr><td  width="56%" style="text-align:left"><span style="font-size:+6" >'.$fetch['servicetaxdesc'].$appendzero.' </span></td><td  width="30%" style="text-align:right"><strong>Service Tax @ 10.3%</strong></td><td  width="14%" style="text-align:right">'.$fetch['servicetax'].$appendzero.'</td></tr><tr><td  width="56%" style="text-align:right"><div align="left"><span style="font-size:+6" >E.&amp;O.E.</span></div></td><td  width="30%" style="text-align:right"><strong>Net Amount</strong></td><td  width="14%" style="text-align:right"><img src="../images/relyon-rupee-small.jpg" width="8" height="8" border="0" alt="Relynsoft" align="absmiddle"  />&nbsp;&nbsp;'.$fetch['netamount'].$appendzero.'</td> </tr><tr><td colspan="3" style="text-align:left"><strong>Rupee In Words</strong>: '.$fetch['amountinwords'].' only</td></tr>';
	}

			$grid .='</table></td></tr></table>';
			
			//to fetch dealer email id 
			$query0 = "select inv_mas_dealer.emailid as dealeremailid,cell as dealercell from inv_mas_dealer where inv_mas_dealer.slno = '".$fetchresult['dealerid']."';";
			$fetch0 = runmysqlqueryfetch($query0);
			$dealeremailid = $fetch0['dealeremailid'];
			$dealercell = $fetch0['dealercell'];


			if($fetchresult['status'] == 'CANCELLED')
			{
				$color = '#FF3300';
				$invoicestatus = '( '.$fetchresult['status'].' )';
			}
			else if($fetchresult['status'] == 'EDITED')
			{
				$color = '#006600';
				$invoicestatus = '( '.$fetchresult['status'].' )';
			}
			else
			{
				$invoicestatus = '';
			}
			
			//$podatepiece = (($fetchresult['podate'] == "0000-00-00") || ($fetchresult['podate'] == ''))?("Not Available"):(changedateformat($fetchresult['podate']));
			//$poreferencepiece = ($fetchresult['poreference'] == "")?("Not Available"):($fetchresult['poreference']);
			// if(strtotime($invoicenewformate) <= strtotime($newyeardate))
			// {
			// $msg = file_get_contents("../pdfbillgeneration/bill-format-old.php");
			// }
			// else
			// {
			// 	$msg = file_get_contents("../pdfbillgeneration/dealer-bill-format-new.php");
			// }
			// if($gst_tax_date <= $invoicedate)
			// {
				if($fetchresult['irn']== "")
	   	 			$msg = file_get_contents("../pdfbillgeneration/matrix-bill-format-gst.php");
				else
					$msg = file_get_contents("../pdfbillgeneration/matrix-bill-format-gst-irn.php");
			//}

			$image_path = '../../user/qrimages/'.$fetchresult['qrimagepath']; 
			$print = '<div><img src="'.$image_path .'"></div>';

			
			$branch_gst_code = $fetchresult['state_info'];

			$branchdetails = "select * from inv_mas_branch where branch_gst_code = '".$branch_gst_code."' and branchname = '".$fetchresult['branch']."'";
			$fetchdetails = runmysqlqueryfetch($branchdetails);
			$branch_gstin = $fetchdetails['branch_gstin'];
			$branch_add = $fetchdetails['branch_address'].', '.$fetchdetails['branch_place'].' - '.$fetchdetails['branch_pincode'];
			$branch_gst_code = $fetchdetails['branch_gst_code'];
			$branch_acc_no = $fetchdetails['branch_acc_no'];
			$branch_ifsc_code = $fetchdetails['branch_ifsc_code'];
			$branch_bank = $fetchdetails['branch_bank'];

			$array = array();
			$stdcode = $fetchresult['stdcode'];
			$array[] = "##BILLDATE##%^%".$billdatedisplay;
			$array[] = "##BILLNO##%^%".$fetchresult['invoiceno'];
			$array[] = "##STATUS##%^%".$invoicestatus;
			$array[] = "##color##%^%".$color;
			$array[] = "##DEALERDETAILS##%^%".'Email: '.$dealeremailid.' | Cell: '.$dealercell;
			$array[] = "##BUSINESSNAME##%^%".$fetchresult['businessname'];
			$array[] = "##CONTACTPERSON##%^%".$fetchresult['contactperson'];
			$array[] = "##ADDRESS##%^%".stripslashes ( stripslashes ( $fetchresult['address']));
			$array[] = "##CUSTOMERID##%^%".$fetchresult['customerid'];
			$array[] = "##EMAILID##%^%".$fetchresult['emailid'];
			$array[] = "##PHONE##%^%".$fetchresult['phone'];
			$array[] = "##CELL##%^%".$fetchresult['cell'];
			$array[] = "##STDCODE##%^%".$stdcode;
			$array[] = "##RELYONREP##%^%".$fetchresult['dealername'];
			$array[] = "##REGION##%^%".$fetchresult['region'];
			$array[] = "##BRANCH##%^%".$fetchresult['branch'];
			$array[] = "##PAYREMARKS##%^%".$fetchresult['remarks'];
			$array[] = "##INVREMARKS##%^%".$fetchresult['invoiceremarks'];
			$array[] = "##GENERATEDBY##%^%".$fetchresult['createdby'];
			$array[] = "##INVOICEHEADING##%^%".$fetchresult['invoiceheading'];
			$array[] = "##PODATE##%^%".$podatepiece;
			$array[] = "##POREFERENCE##%^%".$poreferencepiece;
			$array[] = "##CUSTOMERCATEGORY##%^%".$fetchresult['customercategory'];
			
			$array[] = "##INVOICEDT##%^%".$resultfetch1['createddate'];
			$array[] = "##IRN##%^%".$fetchresult['irn'];
			$array[] = "##qrimage##%^%".$print;
			$array[] = "##BRANCHGSTIN##%^%".$branch_gstin;
			$array[] = "##BRANCHADDRESS##%^%".$branch_add;
			$array[] = "##BRANCHGSTCODE##%^%".$branch_gst_code;
			$array[] = "##PRODUCTGROUP##%^%".$producttype;
			$array[] = "##BANKACCNO##%^%".$branch_acc_no;
			$array[] = "##IFSCCODE##%^%".$branch_ifsc_code;
			$array[] = "##BANKBRANCH##%^%".$branch_bank;
			
			if($new_gst_no != '')
			{
				$array[] = "##CUSTOMERGSTIN##%^%".$new_gst_no;
				$custpan = substr($new_gst_no,2,10);
				$array[] = "##CUSTOMERPAN##%^%".$custpan;
			}
			else
			{
				$novalus = 'Not Registered Under GST';
				$array[] = "##CUSTOMERGSTIN##%^%".$novalus;
				$array[] = "##CUSTOMERPAN##%^%".$custpan;
			}
			$array[] = "##POP##%^%".$statename;
			$array[] = "##CODE##%^%".$statecode;
			
			
			$array[] = "##TABLE##%^%".$grid;
			
			if(($resultfetch1['deduction'] == '1') && ($resultfetch1['tanno'] != ''))
			{
			$array[] = "##NOTE##%^%".$note;
			$array[] = "##CONTENT##%^%".$content;
			}
			else 
			{
			$note = "";$content = ""; $array[] = "##NOTE##%^%".$note;$array[] = "##CONTENT##%^%".$content;
			}
				
			
			$html = replacemailvariable($msg,$array);
			$pdf->WriteHTML($html,true,0,true);
				
			$localtime = date('His');
			$filename = str_replace('/','-',$fetchresult['invoiceno']);
			$filebasename = $filename.".pdf";
			$addstring ="/imax/user";
			if($_SERVER['HTTP_HOST'] == "bhumika" || $_SERVER['HTTP_HOST'] == "192.168.2.79")
				$addstring = "/rwm/SaraliMax-User";
			$filepath = $_SERVER['DOCUMENT_ROOT'].$addstring.'/filecreated/'.$filebasename;
			
			if($type == 'view')
			{
				//ob_end_clean();
				$pdf->Output($filename ,'I');	
			}
			else
			{
				$pdf->Output($filepath ,'F');
				return $filebasename.'^'.$fetchresult['businessname'].'^'.$fetchresult['invoiceno'].'^'.$fetchresult['emailid'].'^'.$dealeremailid.'^'.$invoicestatus.'^'.$fetchresult['status'].'^'.$fetchresult['contactperson'].'^'.$fetchresult['netamount'].'^'.$fetchresult['c'];
			}
			$pdf->writeHTML($html, true, false, true, false, '');

}

function addmatrixlinebreak($linecount)
{
	switch($linecount)
	{
		case '1':
		{
			$linebreak = '<tr>
			<td width="7%"><br/><br/><br/><br/><br/></td>
			<td width="64%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td width="12%">&nbsp;</td>
			<td width="12%">&nbsp;</td>
			</tr>';
		}
		break;
		case '2':
		{
			$linebreak = '<tr>
			<td width="7%"><br/><br/><br/><br/><br/><br/></td>
			<td width="64%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td width="12%">&nbsp;</td>
			<td width="12%">&nbsp;</td>
			</tr>';
		}
		break;
		case '3':
		{
			$linebreak = '<tr><td width="7%"><br/><br/></td>
			<td width="64%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td width="12%">&nbsp;</td>
			<td width="12%">&nbsp;</td>
			</tr>';
		}
		break;
		case '4':
		{
			$linebreak = '<tr><td width="7%"><br/><br/><br/></td>
			<td width="64%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td width="12%">&nbsp;</td>
			<td width="12%">&nbsp;</td>
			</tr>';
		}
		break;
		case '5':
		{
			$linebreak = '<tr><td width="7%"><br/></td>
			<td width="64%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td width="12%">&nbsp;</td>
			<td width="12%">&nbsp;</td>
			</tr>';
		}
		break;
		
	}
	return $linebreak;
}

// Function to display amount in Indian Format (Eg:123456 : 1,23,456)

function formatnumber($number)
{
	if(is_numeric($number))
	{
		$numbersign = "";
		$numberdecimals = "";
		
		//Retain the number sign, if present
		if(substr($number, 0, 1 ) == "-" || substr($number, 0, 1 ) == "+")
		{
			$numbersign = substr($number, 0, 1 );
			$number = substr($number, 1);
		}
		
		//Retain the decimal places, if present
		if(strpos($number, '.'))
		{
			$position = strpos($number, '.'); //echo($position.'<br/>');
			$numberdecimals = substr($number, $position); //echo($numberdecimals.'<br/>');
			$number = substr($number, 0, ($position)); //echo($number.'<br/>');
		}
		
		//Apply commas
		if(strlen($number) < 4)
		{
			$output =  $number;
		}
		else
		{
			$lastthreedigits = substr($number, -3);
			$remainingdigits = substr($number, 0, -3);
			$tempstring = "";
			for($i=strlen($remainingdigits),$j=1; $i>0; $i--,$j++)
			{
				if($j % 2 <> 0)
					$tempstring = ','.$tempstring;
				$tempstring = $remainingdigits[$i-1].$tempstring;
			}
			$output = $tempstring.$lastthreedigits;
		}
		$finaloutput = $numbersign.$output.$numberdecimals;
		return $finaloutput;	
	}
	else
	{
		$finaloutput = 0;
		return $finaloutput;
	}
}

//Function to convert the number to words
function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
    	throw new Exception("Number is out of range");
    } 
	 
	$cn = floor($number / 10000000); /* Crores */
	$number -= $cn * 10000000;   
	
	$ln = floor($number / 100000);  /* Lakhs */
	$number -= $ln * 100000;
	
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
	
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
	
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;             /* Ones */ 

    $res = ""; 


	if($cn)
	{
		 $res .= convert_number($cn) . " Crore"; 
	}
	
	if($ln)
	{
		$res .= (empty($res) ? "" : " ") . 
            convert_number($ln) . " Lakh";
	}
    if ($kn) 
    { 
		
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen",
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
} 

function addlinebreak($linecount)
{
	switch($linecount)
	{
		case '1':
		{
			$linebreak = '<tr><td width="10%"><br/><br/></td><td width="76%">&nbsp;</td><td width="14%">&nbsp;</td></tr>';
			// $linebreak = '<tr><td width="10%"><br/><br/><br/><br/><br/><br/><br/><br/>/td><td width="76%">&nbsp;</td><td width="14%">&nbsp;</td></tr>';
		}
		break;
		case '2':
		{
			$linebreak = '<tr><td width="10%"><br/><br/></td><td width="76%">&nbsp;</td><td width="14%">&nbsp;</td></tr>';
		}
		break;
		case '3':
		{
			$linebreak = '<tr><td width="10%"><br/><br/></td><td width="76%">&nbsp;</td><td width="14%">&nbsp;</td></tr>';
		}
		break;
		case '4':
		{
			$linebreak = '<tr><td width="10%"><br/><br/></td><td width="76%">&nbsp;</td><td width="14%">&nbsp;</td></tr>';
		}
		break;
		case '5':
		{
			$linebreak = '<tr><td width="10%"><br/></td><td width="76%">&nbsp;</td><td width="14%">&nbsp;</td></tr>';
		}
		break;
		
	}
	return $linebreak;
}

function roundnearestvalue($amount)
{
	$firstamount = round($amount,1);
	$amount1 = round($firstamount);
	return $amount1;
}


function sendstartvisit($impreflastslno,$imptype='')
{
	if($imptype == 'hndhold')
		$query12 = "select * from imp_handholdimplementationdays  where slno = '".$impreflastslno."'";
	else
		$query12 = "select * from imp_implementationdays  where imp_implementationdays.slno = '".$impreflastslno."'";

	$result16 = runmysqlqueryfetch($query12);
	
	//Visit Details Grid  
	$addongrid = '<table width="100%" cellpadding="5" cellspacing="0"><tr><td><table width="100%" cellpadding="2" cellspacing="0" border="1">';
	$addongrid .= '<tr align ="left"><td nowrap = "nowrap"  ><strong>Sl No</strong></td><td nowrap = "nowrap" ><strong>Date of Visit </strong></td><td nowrap = "nowrap" ><strong>Start Time</strong></td><td nowrap = "nowrap" ><strong>Server Start Time</strong></td></tr>';
	$slno3 =0;
	$slno3++;
	$addongrid .= '<tr align ="left">';
	$addongrid .= "<td nowrap='nowrap' >".$slno3."</td>";
	$addongrid .= "<td >".changedateformat($result16['visiteddate'])."</td>";
	$addongrid .= "<td >".$result16['starttime']."</td>";
	$addongrid .= "<td >".changetimeformat($result16['serverstarttime'])."</td>";
	$addongrid .= "</tr>";
	$addongrid .= "</table></td></tr></table>";
	
	$lastslno = $result16['impref'];
		
	$query = "select * from imp_implementation left join inv_mas_customer on inv_mas_customer.slno = imp_implementation.customerreference  where imp_implementation.slno = '".$lastslno."'";
	$result = runmysqlqueryfetch($query);
	
	$businessname = $result['businessname'];
	$place = $result['place'];
	$customerreference = $result['slno'];
	$assignimp = ($imptype == 'handhold') ? $result['assignhandholdimplemenation'] : $result['assignimplemenation'];
	
	$result14 = runmysqlqueryfetch("select * from inv_mas_implementer  where inv_mas_implementer.slno = '".$assignimp."'");
	
	$implementatorname = $result14['businessname'];
	$branchid = $result14['branchid'];
	$region = $result14['region'];
	
	// Fetch Coordinator head emailid 
	$query21 = "select TRIM(BOTH ',' FROM group_concat(emailid))as coemailid from inv_mas_implementer where (branchid ='".$branchid."' or branchid ='all') and coordinator = 'yes' and region = '".$region."' and disablelogin = 'no'";
	$result21 = runmysqlqueryfetch($query21);
	$branchheademailid = $result21['coemailid'];
	
	// Fetch Contact Details
	$query1 ="SELECT slno,customerid,contactperson,selectiontype,phone,cell,emailid,slno from inv_contactdetails where customerid = '".$customerreference."'; ";
	$resultfetch = runmysqlquery($query1);
	$valuecount = 0;
	while($fetchres = mysqli_fetch_array($resultfetch))
	{
		if(checkemailaddress($fetchres['emailid']))
		{
			if($fetchres['contactperson'] != '')
				$emailids[$fetchres['contactperson']] = $fetchres['emailid'];
			else
				$emailids[$fetchres['emailid']] = $fetchres['emailid'];
		}
		$contactvalue .= $fetchres['contactperson'].',';
		$emailidvalues .= $fetchres['emailid'].',';
		
	}
	$contactperson = trim(removedoublecomma($contactvalue),',');
	$emailid = trim(removedoublecomma($emailidvalues),',');
	
	

	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
	{
		unset($emailids);
		$emailids[] = 'meghana.b@relyonsoft.com';
	}
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
	{
		$branchemailid = 'rashmi.hk@relyonsoft.com';
	}
	else
	{
		$branchemailid = $branchheademailid;
	}
	$ccemailarray = explode(',',$branchemailid);
	$ccemailcount = count($ccemailarray);
	for($i = 0; $i < $ccemailcount; $i++)
	{
		if(checkemailaddress($ccemailarray[$i]))
		{
			if($i == 0)
				$ccemailids[$ccemailarray[$i]] = $ccemailarray[$i];
			else
				$ccemailids[$ccemailarray[$i]] = $ccemailarray[$i];
		}
	}
	$fromname = "Relyon";
	$fromemail = "imax@relyon.co.in";
	require_once("../inc/RSLMAIL_MAIL.php");
	$msg = file_get_contents("../mailcontents/visitstarted.htm");
	$textmsg = file_get_contents("../mailcontents/visitstarted.txt");

	//Create an array of replace parameters
	$array = array();
	$date = datetimelocal('d-m-Y');
	$array[] = "##DATE##%^%".$date;
	$array[] = "##NAME##%^%".$contactperson;
	$array[] = "##COMPANY##%^%".$businessname;
	$array[] = "##PLACE##%^%".$place;
	$array[] = "##INVOICENO##%^%".$result['invoicenumber'];
	$array[] = "##EMAILID##%^%".$emailid;
	$array[] = "##IMPLEMENTOR##%^%".$implementatorname;
	$array[] = "##TABLE##%^%".$addongrid;
	
	//Relyon Logo for email Content, as Inline [Not attachment]
	$filearray = array(
		array('../images/relyon-logo.jpg','inline','8888888888'),
	
	);
	
	$toarray = $emailids;
	$ccarray = $ccemailids;
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab"))
	{
		$bccemailids['archana'] ='archana.ab@relyonsoft.com';
	}
	else
	{
		$bccemailids['bigmail'] ='bigmail@relyonsoft.com';
		$bccemailids['Relyonimax'] ='relyonimax@gmail.com';
	}

	$bccarray = $bccemailids;
	$msg = replacemailvariable($msg,$array);
	$textmsg = replacemailvariable($textmsg,$array);
	if($imptype == 'hndhold')
		$subject = 'Hand Hold visit Start Information by '.$implementatorname.'(Beta)';
	else
		$subject = 'Visit Start Information by '.$implementatorname.'(Beta)'; 
	$html = $msg;
	$text = $textmsg;
	rslmail($fromname, $fromemail, $toarray, $subject, $text, $html,$ccarray,$bccarray,$filearray);
	//Insert the mail forwarded details to the logs table
	$bccmailid = 'bigmail@relyonsoft.com';
	inserttologs($userid,$customerslno,$fromname,$fromemail,$emailid,null,$bccmailid,$subject);
	return 'sucess';
}

function removedoublecomma($string)
{
	$finalstring = $string;
	$commas =explode(',',$string);
	$countcomma = count($commas);
	for($i=0;$i<$countcomma;$i++)
	{
		$outputstring = str_replace(',,',',',$finalstring);
		$finalstring =  $outputstring;
	}
	return $outputstring;
}

function sendendvisit($impreflastslno,$imptype='')
{
	if($imptype == 'handhold')
		$query12 = "select * from imp_handholdimplementationdays  where slno = '".$impreflastslno."'";
	else
		$query12 = "select * from imp_implementationdays  where imp_implementationdays.slno = '".$impreflastslno."'";
	$result16 = runmysqlqueryfetch($query12);
	$lastslno = $result16['impref'];
	
	
	$query11 = "SELECT imp_implementationactivity.slno,imp_mas_activity.activityname ,imp_implementationactivity.remarks from imp_implementationactivity left join imp_mas_activity on imp_mas_activity.slno = imp_implementationactivity.activity WHERE impref = '".$lastslno."' ";
	$grid = '<table width="100%" cellpadding="3" cellspacing="0" class="table-border-grid" border="1">';
	$grid .= '<tr  align ="left" bgcolor="#CCCCCC"><td nowrap = "nowrap"  >Sl No</td><td nowrap = "nowrap" >Activity</td><td nowrap = "nowrap" >Remarks</td></tr>';
	$i_n = 0;$slno1 = 0;
	$result11 = runmysqlquery($query11);
	while($fetch = mysqli_fetch_array($result11))
	{
		$slno1++;
		$grid .= '<tr   align ="left">';
		$grid .= "<td nowrap='nowrap' >".$slno1."</td>";
		$grid .= "<td nowrap='nowrap' >".$fetch['activityname']."</td>";
		$grid .= "<td nowrap='nowrap' >".gridtrim($fetch['remarks'])."</td>";
		$grid .= "</tr>";
	}
	$fetchcount = mysqli_num_rows($result11);
	
	if($fetchcount == '0')
		$grid .= "<tr><td colspan ='3'><div align='center'><font color='#FF0000'><strong>No Records to Display</strong></font></div></td></tr>";
	$grid .= "</table>";
	$resultgrid = '<table width="100%" border="0" cellspacing="0" cellpadding="5">';
	$resultgrid .= '<tr><td width="20%"><strong>Date of Visit :</strong></td> <td width="80%">'.changedateformat($result16['visiteddate']).'</td></tr>';
	$resultgrid .= '<tr><td width="20%"><strong>Start Time :</strong></td><td width="80%">'.$result16['starttime'].'</td></tr>';
	$resultgrid .= '<tr><td width="20%"><strong>Server Start Time :</strong></td><td width="80%">'.changetimeformat($result16['serverstarttime']).'</td></tr>';
	$resultgrid .= '<tr><td width="20%"><strong>End Time :</strong></td><td width="80%">'.$result16['endtime'].'</td></tr>';
	$resultgrid .= '<tr><td width="20%"><strong>Server End Time :</strong></td> <td width="80%">'.changetimeformat($result16['serverendtime']).'</td></tr>';

	$resultgrid .= '<tr><td width="20%"><strong>Visit Summary :</strong></td><td width="80%">'.$result16['remarks'].'</td> </tr>';
	$resultgrid .= '<tr><td colspan="2"><strong>Activities Carried :</strong></td></tr>';
	$resultgrid .= '<tr><td colspan="2">'.$grid.'</td></tr></table>';

	
		
	$query = "select * from imp_implementation left join inv_mas_customer on inv_mas_customer.slno = imp_implementation.customerreference  where imp_implementation.slno = '".$lastslno."'";
	$result = runmysqlqueryfetch($query);
	
	$businessname = $result['businessname'];
	$place = $result['place'];
	$customerreference = $result['slno'];
	$assignimp = ($imptype == 'handhold') ? $result['assignhandholdimplemenation'] : $result['assignimplemenation'];
	
	$result14 = runmysqlqueryfetch("select * from inv_mas_implementer  where inv_mas_implementer.slno = '".$assignimp."'");
	
	$implementatorname = $result14['businessname'];
	$branchid = $result14['branchid'];
	$region = $result14['region'];
	
	// Fetch Coordinator head emailid 
	$query21 = "select TRIM(BOTH ',' FROM group_concat(emailid))as coemailid from inv_mas_implementer where (branchid ='".$branchid."' or branchid ='all')  and region = '".$region."' and coordinator = 'yes' and disablelogin = 'no'";
	$result21 = runmysqlqueryfetch($query21);
	$branchheademailid = $result21['coemailid'];
	
	// Fetch Contact Details
	$query1 ="SELECT slno,customerid,contactperson,selectiontype,phone,cell,emailid,slno from inv_contactdetails where customerid = '".$customerreference."'; ";
	$resultfetch = runmysqlquery($query1);
	$valuecount = 0;
	while($fetchres = mysqli_fetch_array($resultfetch))
	{
		if(checkemailaddress($fetchres['emailid']))
		{
			if($fetchres['contactperson'] != '')
				$emailids[$fetchres['contactperson']] = $fetchres['emailid'];
			else
				$emailids[$fetchres['emailid']] = $fetchres['emailid'];
		}
		$contactvalue .= $fetchres['contactperson'].',';
		$emailidvalues .= $fetchres['emailid'].',';
		
	}
	$contactperson = trim(removedoublecomma($contactvalue),',');
	$emailid = trim(removedoublecomma($emailidvalues),','); 
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
	{
		unset($emailids);
		$emailids[] = 'meghana.b@relyonsoft.com';
	}
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
	{
		$branchemailid = 'rashmi.hk@relyonsoft.com';
	}
	else
	{
		$branchemailid = $branchheademailid;
	}
	$ccemailarray = explode(',',$branchemailid);
	$ccemailcount = count($ccemailarray);
	for($i = 0; $i < $ccemailcount; $i++)
	{
		if(checkemailaddress($ccemailarray[$i]))
		{
			if($i == 0)
				$ccemailids[$ccemailarray[$i]] = $ccemailarray[$i];
			else
				$ccemailids[$ccemailarray[$i]] = $ccemailarray[$i];
		}
	}
	$fromname = "Relyon";
	$fromemail = "imax@relyon.co.in";
	require_once("../inc/RSLMAIL_MAIL.php");
	$msg = file_get_contents("../mailcontents/visitended.htm");
	$textmsg = file_get_contents("../mailcontents/visitended.txt");
	if($imptype == 'handhold')
		$subject = 'Hand Hold visit End Information by '.$implementatorname.'(Beta)'; 
	else
		$subject = 'Visit End Information by '.$implementatorname.'(Beta)';
	//Create an array of replace parameters
	$array = array();
	$date = datetimelocal('d-m-Y');
	$array[] = "##DATE##%^%".$date;
	$array[] = "##NAME##%^%".$contactperson;
	$array[] = "##COMPANY##%^%".$businessname;
	$array[] = "##PLACE##%^%".$place;
	$array[] = "##INVOICENO##%^%".$result['invoicenumber'];
	$array[] = "##EMAILID##%^%".$emailid;
	$array[] = "##IMPLEMENTOR##%^%".$implementatorname;
	$array[] = "##TABLE##%^%".$resultgrid;
	$array[] = "##SUBJECT##%^%".$subject;
	//Relyon Logo for email Content, as Inline [Not attachment]
	$filearray = array(
		array('../images/relyon-logo.jpg','inline','8888888888'),
	
	);
	
	$toarray = $emailids;
	$ccarray = $ccemailids;
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab"))
	{
		$bccemailids['archana'] ='archana.ab@relyonsoft.com';
	}
	else
	{
		$bccemailids['bigmail'] ='bigmail@relyonsoft.com';
		$bccemailids['Relyonimax'] ='relyonimax@gmail.com';
	}

	$bccarray = $bccemailids;
	$msg = replacemailvariable($msg,$array);
	$textmsg = replacemailvariable($textmsg,$array);
	$html = $msg;
	$text = $textmsg;
	rslmail($fromname, $fromemail, $toarray, $subject, $text, $html,$ccarray,$bccarray,$filearray);
	return 'sucess';
	//Insert the mail forwarded details to the logs table
	$bccmailid = 'bigmail@relyonsoft.com';
	inserttologs($userid,$customerslno,$fromname,$fromemail,$emailid,null,$bccmailid,$subject);
}

function sendicccollectedmail($impreflastslno,$imptype='')
{
	if($imptype == 'handhold')
		$query12 = "select * from imp_handholdimplementationdays  where slno = '".$impreflastslno."'";
	else
		$query12 = "select * from imp_implementationdays  where imp_implementationdays.slno = '".$impreflastslno."'";

	$result16 = runmysqlqueryfetch($query12); //echo($query12);exit;
	$lastslno = $result16['impref'];
	$iccpath = $result16['iccattachmentpath']; // echo($lastslno.'$'.$result16['iccattachmentpath']); exit;
	$iccpathsplit = explode('/',$iccpath);
	$filebasename = $iccpathsplit[5];  //echo($filebasename);exit;
	
	//$query11 = "SELECT imp_implementationactivity.slno,imp_mas_activity.activityname ,imp_implementationactivity.remarks from imp_implementationactivity left join imp_mas_activity on imp_mas_activity.slno = imp_implementationactivity.activity WHERE impref = '".$lastslno."' ";
	if($imptype == 'handhold')
		$query11 = "SELECT slno,activity ,remarks from imp_handholdimplementationactivity  WHERE impref = '".$lastslno."' ";
	else
		$query11 = "SELECT slno,activity ,remarks from imp_implementationactivity  WHERE impref = '".$lastslno."' ";
	$grid = '<table width="100%" cellpadding="3" cellspacing="0" class="table-border-grid" border="1">';
	$grid .= '<tr  align ="left" bgcolor="#CCCCCC"><td nowrap = "nowrap"  >Sl No</td><td nowrap = "nowrap" >Activity</td><td nowrap = "nowrap" >Remarks</td></tr>';
	$i_n = 0;$slno1 = 0;
	$result11 = runmysqlquery($query11);
	while($fetch = mysqli_fetch_array($result11))
	{
		$slno1++;
		$grid .= '<tr   align ="left">';
		$grid .= "<td nowrap='nowrap' >".$slno1."</td>";
		$grid .= "<td nowrap='nowrap' >".$fetch['activity']."</td>";
		$grid .= "<td nowrap='nowrap' >".gridtrim($fetch['remarks'])."</td>";
		$grid .= "</tr>";
	}
	$fetchcount = mysqli_num_rows($result11);
	
	if($fetchcount == '0')
		$grid .= "<tr><td colspan ='3'><div align='center'><font color='#FF0000'><strong>No Records to Display</strong></font></div></td></tr>";
	$grid .= "</table>";
	$resultgrid = '<table width="100%" border="0" cellspacing="0" cellpadding="5">';
	$resultgrid .= '<tr><td width="20%"><strong>Date of Visit :</strong></td> <td width="80%">'.changedateformat($result16['visiteddate']).'</td></tr>';
	$resultgrid .= '<tr><td width="20%"><strong>Start Time :</strong></td><td width="80%">'.$result16['starttime'].'</td></tr>';
	$resultgrid .= '<tr><td width="20%"><strong>End Time :</strong></td> <td width="80%">'.$result16['endtime'].'</td></tr>';
	$resultgrid .= '<tr><td width="20%"><strong>Visit Summary :</strong></td><td width="80%">'.$result16['remarks'].'</td> </tr>';
	$resultgrid .= '<tr><td colspan="2"><strong>Activities Carried :</strong></td></tr>';
	$resultgrid .= '<tr><td colspan="2">'.$grid.'</td></tr></table>';

	
		
	$query = "select * from imp_implementation left join inv_mas_customer on inv_mas_customer.slno = imp_implementation.customerreference  where imp_implementation.slno = '".$lastslno."'";
	$result = runmysqlqueryfetch($query);
	
	$businessname = $result['businessname'];
	$place = $result['place'];
	$customerreference = $result['slno'];
	$assignimp = ($imptype == 'handhold') ? $result['assignhandholdimplemenation'] : $result['assignimplemenation'];
	
	$result14 = runmysqlqueryfetch("select * from inv_mas_implementer  where inv_mas_implementer.slno = '".$assignimp."'");
	
	$implementatorname = $result14['businessname'];
	$branchid = $result14['branchid'];
	$region = $result14['region'];
	
	// Fetch Coordinator emailid 
	$query21 = "select TRIM(BOTH ',' FROM group_concat(emailid))as coemailid from inv_mas_implementer where (branchid ='".$branchid."' or branchid ='all') and region = '".$region."' and coordinator = 'yes'";
	$result21 = runmysqlqueryfetch($query21);
	$branchheademailid = $result21['coemailid'];
	
	// Fetch Contact Details
	$query1 ="SELECT slno,customerid,contactperson,selectiontype,phone,cell,emailid,slno from inv_contactdetails where customerid = '".$customerreference."'; ";
	$resultfetch = runmysqlquery($query1);
	$valuecount = 0;
	while($fetchres = mysqli_fetch_array($resultfetch))
	{
		if(checkemailaddress($fetchres['emailid']))
		{
			if($fetchres['contactperson'] != '')
				$emailids[$fetchres['contactperson']] = $fetchres['emailid'];
			else
				$emailids[$fetchres['emailid']] = $fetchres['emailid'];
		}
		$contactvalue .= $fetchres['contactperson'].',';
		$emailidvalues .= $fetchres['emailid'].',';
		
	}
	$contactperson = trim(removedoublecomma($contactvalue),',');
	$emailid = trim(removedoublecomma($emailidvalues),','); 
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
	{
		unset($emailids);
		$emailids[] = 'archana.ab@relyonsoft.com';
	}
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
	{
		$branchemailid = 'rashmi.hk@relyonsoft.com';
	}
	else
	{
		$branchemailid = $branchheademailid;
	}
	$ccemailarray = explode(',',$branchemailid);
	$ccemailcount = count($ccemailarray);
	for($i = 0; $i < $ccemailcount; $i++)
	{
		if(checkemailaddress($ccemailarray[$i]))
		{
			if($i == 0)
				$ccemailids[$ccemailarray[$i]] = $ccemailarray[$i];
			else
				$ccemailids[$ccemailarray[$i]] = $ccemailarray[$i];
		}
	}
	$addstring = "/user";
	if($_SERVER['HTTP_HOST'] == "meghanab" || $_SERVER['HTTP_HOST'] == "rashmihk" || $_SERVER['HTTP_HOST'] == "archanaab")
	$addstring = "/saralimax-user";
	$filepath = $_SERVER['DOCUMENT_ROOT'].$addstring.'/implementationuploads/'.$filebasename;
	$downloadlink ='http://'.$_SERVER['HTTP_HOST'].$addstring.'/implementationuploads/'.$filebasename;

	$fromname = "Relyon";
	$fromemail = "imax@relyon.co.in";
	require_once("../inc/RSLMAIL_MAIL.php");
	$msg = file_get_contents("../mailcontents/visitended.htm");
	$textmsg = file_get_contents("../mailcontents/visitended.txt");
	if($imptype == 'handhold')
		$subject = 'Hand Hold visit End Information by '.$implementatorname.' with attached ICC(Beta)';
	else
		$subject = 'Visit End Information by '.$implementatorname.' with attached ICC(Beta)'; 
	//Create an array of replace parameters
	$array = array();
	$date = datetimelocal('d-m-Y');
	$array[] = "##DATE##%^%".$date;
	$array[] = "##NAME##%^%".$contactperson;
	$array[] = "##COMPANY##%^%".$businessname;
	$array[] = "##PLACE##%^%".$place;
	$array[] = "##INVOICENO##%^%".$result['invoicenumber'];
	$array[] = "##EMAILID##%^%".$emailid;
	$array[] = "##IMPLEMENTOR##%^%".$implementatorname;
	$array[] = "##TABLE##%^%".$resultgrid;
	$array[] = "##SUBJECT##%^%".$subject;
	
	//Relyon Logo for email Content, as Inline [Not attachment]
	$filearray = array(
		array('../images/relyon-logo.jpg','inline','8888888888'),
		array($filepath,'attachment','1234567891'),
	);
	
	$toarray = $emailids;
	$ccarray = $ccemailids;
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab"))
	{
		$bccemailids['archana'] ='meghana.b@relyonsoft.com';
	}
	else
	{
		$bccemailids['bigmail'] ='bigmail@relyonsoft.com';
		$bccemailids['Relyonimax'] ='relyonimax@gmail.com';
	}

	$bccarray = $bccemailids;
	$msg = replacemailvariable($msg,$array);
	$textmsg = replacemailvariable($textmsg,$array);
	
	$html = $msg;
	$text = $textmsg;
	rslmail($fromname, $fromemail, $toarray, $subject, $text, $html,$ccarray,$bccarray,$filearray);
	
	//Insert the mail forwarded details to the logs table
	$bccmailid = 'bigmail@relyonsoft.com';
	inserttologs($userid,$customerslno,$fromname,$fromemail,$emailid,null,$bccmailid,$subject);
	return 'sucess';
}

//send mail to assigned implementer
function sendimplementerassignedemail($customerid,$implementerid,$handholdslno="",$imptype='')
{
	// Get the customer details
	//alert($handholdslno); exit;
	$querygetcustomerdetails = 'select * from inv_mas_customer where slno = "'.$customerid.'"';	
	$fetchcustomerdetails = runmysqlqueryfetch($querygetcustomerdetails);
	$businessname = $fetchcustomerdetails['businessname'];
	
	// Fetch contact details 
	
	$querycontactdetails = "select  phone,cell,emailid,contactperson from inv_contactdetails where customerid = '".$customerid."'";
	$resultcontactdetails = runmysqlquery($querycontactdetails);
	// contact Details
	$contactvalues = '';
	$phoneres = '';
	$cellres = '';
	$emailidres = '';
			
	while($fetchcontactdetails = mysqli_fetch_array($resultcontactdetails))
	{
		$contactperson = $fetchcontactdetails['contactperson'];
		$phone = $fetchcontactdetails['phone'];
		$cell = $fetchcontactdetails['cell'];
		$emailid = $fetchcontactdetails['emailid'];
		
		$contactvalues .= $contactperson;
		$contactvalues .= appendcomma($contactperson);
		$phoneres .= $phone;
		$phoneres .= appendcomma($phone);
		$cellres .= $cell;
		$cellres .= appendcomma($cell);
		$emailidres .= $emailid;
		$emailidres .= appendcomma($emailid);
	}
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
		$emailid = 'archana.ab@relyonsoft.com';
	else
		$emailid = trim($emailidres,',');
	//Split multiple email IDs by Comma
	$emailarray = explode(',',$emailid);
	$emailcount = count($emailarray);
	
	//Convert email IDs to an array. First email ID will eb assigned with Contact person name. Others will be assigned with email IDs itself as Name.
	for($i = 0; $i < $emailcount; $i++)
	{
		if(checkemailaddress($emailarray[$i]))
		{
				//$emailids[$emailarray[$i]] = $emailarray[$i];
				$emailids[] = [
					'email' => $emailarray[$i]
				];
		}
	}
	// Get implementer name
	$querygetimplementer = 'select * from inv_mas_implementer where slno = "'.$implementerid.'"';
	$fetchimplementer = runmysqlqueryfetch($querygetimplementer); 
	
	$implementername = $fetchimplementer['businessname'];
	$implementeremailid = $fetchimplementer['emailid']; 
	$branchid = $fetchimplementer['branchid']; 
	$region = $fetchimplementer['region']; 
	
	if(($_SERVER['HTTP_HOST'] == "localhost") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab"))
	{
		$implementeremailid = 'bhumika.p@relyonsoft.com';
	}
	else
	{
		$implementeremailid = $implementeremailid ;
	}
	
	// Fetch  coordinator emailid
	$query13 = "select TRIM(BOTH ',' FROM group_concat(emailid))as coemailid from inv_mas_implementer where (branchid ='".$branchid."' or branchid ='all') and region = '".$region."' and coordinator = 'yes' and disablelogin = 'no'";
	$result13 = runmysqlqueryfetch($query13);
	if(($_SERVER['HTTP_HOST'] == "localhost") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
	{
		$branchemailid = 'bhumika.p@relyonsoft.com';
		$coordinatoremaild = 'bhumika@relyonsoft.com';
	}
	else
	{
		$branchemailid = $branchheademailid; 
		$coordinatoremaild = $result13['coemailid'];
	}
	// Fetch sales person emailid
	$query14 = "select * from imp_implementation where customerreference = '".$customerid."'";
	$result14 = runmysqlqueryfetch($query14); 
	$dealerid = $result14['dealerid'];
	
	$query15 = "select emailid,branch,region from inv_mas_dealer where slno = '".$dealerid."'";
	$result15 = runmysqlqueryfetch($query15); 
	$dealerbranchid = $result15['branch'];
	$dealerregionid = $result15['region'];

	if($imptype == "handhold")
		$query16 = "select assigneddate,imp_mas_handholdtype.handholdtype from imp_handholdimplementationdays left join imp_mas_handholdtype on imp_mas_handholdtype.slno = imp_handholdimplementationdays.handholdtype where imp_handholdimplementationdays.slno = '".$handholdslno."'";
	else
		$query16 = "select assigneddate from imp_implementationdays  where imp_implementationdays.slno = '".$handholdslno."'";
	$fetch16 = runmysqlqueryfetch($query16);
	$impdate = changedateformat($fetch16['assigneddate']);
	$handholdtype = (empty($fetch16['handholdtype'])) ? '' : 'for '.$fetch16['handholdtype']. 'process';
	
	// Fetch branchhead email id 
	$query12 = "select TRIM(BOTH ',' FROM group_concat(emailid))as branchemailid from inv_mas_dealer where branchhead = 'yes' and (branch = '".$dealerbranchid."') and region = '".$dealerregionid."';";
	$result12 = runmysqlqueryfetch($query12);
	$branchheademailid = $result12['branchemailid'];
	
	
	if(($_SERVER['HTTP_HOST'] == "localhost") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
	{
		$salespersonemailid = 'bhumika@relyonsoft.com';
	}
	else
	{
		$salespersonemailid = $result15['emailid'];
	}
	
	$ccids = $branchemailid.','.$coordinatoremaild.','.$implementeremailid.','.$salespersonemailid;
	$ccemailarray = explode(',',$ccids);
	$ccemailcount = count($ccemailarray);
	for($i = 0; $i < $ccemailcount; $i++)
	{
		if(checkemailaddress($ccemailarray[$i]))
		{
			// if($i == 0)
			// 	$ccemailids[$ccemailarray[$i]] = $ccemailarray[$i];
			// else
			// 	$ccemailids[$ccemailarray[$i]] = $ccemailarray[$i];
			
			if($i == 0)
			{
				$ccemailids[] = [
					'ccemail' => $ccemailarray[$i]
				];
			}
			else
			{
				$ccemailids[] = [
					'ccemail' => $ccemailarray[$i]
				];
			}
		}
	}
	$fromname = "Relyon";
	$fromemail = "imax@relyon.co.in";
	require_once("../inc/RSLMAIL_MAIL.php");
	$msg = file_get_contents("../mailcontents/assignedimplementer.htm");
	$textmsg = file_get_contents("../mailcontents/assignedimplementer.txt");

	//Create an array of replace parameters
	$array = array();
	$date = datetimelocal('d-m-Y');
	$array[] = "##DATE##%^%".$date;
	$array[] = "##NAME##%^%".trim($contactvalues,',');
	$array[] = "##COMPANYNAME##%^%".$businessname;
	$array[] = "##IMPLEMENTERNAME##%^%".$implementername;
	$array[] = "##EMAILID##%^%".$emailid;
	$array[] = "##HANDHOLD##%^%".$imptype;
	$array[] = "##HANDHOLDDATE##%^%".$impdate;
	$array[] = "##HANDHOLDTYPE##%^%".$handholdtype;
	
	//Relyon Logo for email Content, as Inline [Not attachment]
	// $filearray = array(
	// 	array('../images/relyon-logo.jpg','inline','8888888888'),
	
	// );
	$imagepath = '../images/relyon-logo.jpg';
		$cid = 8888888888;
		$altimgname= 'relyon-logo.jpg';
	
	$toarray = $emailids;
	$ccarray = $ccemailids;
	if(($_SERVER['HTTP_HOST'] == "localhost") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab"))
	{
		$bccemailids = [
			['bccemail' => 'bhumika.p@relyonsoft.com', 'name' => 'Bhumika']
		];
	}
	else
	{
		$bccemailids['bigmail'] ='bigmail@relyonsoft.com';
		$bccemailids['Relyonimax'] ='relyonimax@gmail.com';
	}

	$bccarray = $bccemailids;
	$msg = replacemailvariable($msg,$array);
	$textmsg = replacemailvariable($textmsg,$array);
	if($imptype == 'handhold')
		$subject = ''.$implementername.' Assigned for you(Hand Hold)(Beta)'; 
	else
		$subject = ''.$implementername.' Assigned for you(Beta)'; 
	$html = $msg;
	$text = $textmsg;
	include("../inc/PHPMAILER_MAIL.php");
	//rslmail($fromname, $fromemail, $toarray, $subject, $text, $html,$ccarray,$bccarray,$filearray);
	return 'sucess';
	//Insert the mail forwarded details to the logs table
	$bccmailid = 'bigmail@relyonsoft.com';
	inserttologs($userid,$customerslno,$fromname,$fromemail,$emailid,null,$bccmailid,$subject);
	return 'sent';
}

//send mail for total visits
function senddaysassignedemail($customerid,$implementerid,$noofdays,$userid,$imptype='')
{
	// Get the customer details
	$querygetcustomerdetails = 'select * from inv_mas_customer where slno = "'.$customerid.'"';	
	$fetchcustomerdetails = runmysqlqueryfetch($querygetcustomerdetails);
	$businessname = $fetchcustomerdetails['businessname'];
	
	// Fetch contact details 
	$querycontactdetails = "select  phone,cell,emailid,contactperson from inv_contactdetails where customerid = '".$customerid."'";
	$resultcontactdetails = runmysqlquery($querycontactdetails);
	// contact Details
	$contactvalues = '';
	$phoneres = '';
	$cellres = '';
	$emailidres = '';
			
	while($fetchcontactdetails = mysqli_fetch_array($resultcontactdetails))
	{
		$contactperson = $fetchcontactdetails['contactperson'];
		$phone = $fetchcontactdetails['phone'];
		$cell = $fetchcontactdetails['cell'];
		$emailid = $fetchcontactdetails['emailid'];
		
		$contactvalues .= $contactperson;
		$contactvalues .= appendcomma($contactperson);
		$phoneres .= $phone;
		$phoneres .= appendcomma($phone);
		$cellres .= $cell;
		$cellres .= appendcomma($cell);
		$emailidres .= $emailid;
		$emailidres .= appendcomma($emailid);
	}
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
		$emailid = 'archana.ab@relyonsoft.com';
	else
		$emailid = trim($emailidres,',');
	//Split multiple email IDs by Comma
	$emailarray = explode(',',$emailid);
	$emailcount = count($emailarray);
	
	//Convert email IDs to an array. First email ID will eb assigned with Contact person name. Others will be assigned with email IDs itself as Name.
	for($i = 0; $i < $emailcount; $i++)
	{
		if(checkemailaddress($emailarray[$i]))
		{
			$emailids[] = [
				'email' => $emailarray[$i]
			];
		}
	}

	$implementerid = (empty($implementerid)) ? $userid : $implementerid;
	// Get implementer name
	$querygetimplementer = 'select * from inv_mas_implementer where slno = "'.$implementerid.'"';
	$fetchimplementer = runmysqlqueryfetch($querygetimplementer); 
	
	$implementername = $fetchimplementer['businessname'];
	$implementeremailid = $fetchimplementer['emailid']; 
	
	// if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab"))
	// {
	// 	$implementeremailid = 'meghana.b@relyonsoft.com';
	// }
	// else
	// {
	// 	$implementeremailid = $implementeremailid ;
	// }
	$branchid = $fetchimplementer['branchid'];
	$region = $fetchimplementer['region'];
		
	
	// Fetch  coordinator emailid
	$query13 = "select TRIM(BOTH ',' FROM group_concat(emailid))as coemailid from inv_mas_implementer where (branchid ='".$branchid."' or branchid ='all') and coordinator = 'yes' and region = '".$region."'" ;
	$result13 = runmysqlqueryfetch($query13);
	if(($_SERVER['HTTP_HOST'] == "localhost") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
	{
		$coordinatoremaild = 'bhumika@relyonsoft.com';
	}
	else
	{
		//$branchemailid = $branchheademailid; 
		$coordinatoremaild = $result13['coemailid'];
	}
	// Fetch sales person emailid
	$query14 = "select * from imp_implementation where customerreference = '".$customerid."'";
	$result14 = runmysqlqueryfetch($query14); 
	$dealerid = $result14['dealerid'];
	$invoiceno = $result14['invoicenumber'];
	
	$query15 = "select emailid,branch,region from inv_mas_dealer where slno = '".$dealerid."'";
	$result15 = runmysqlqueryfetch($query15); 
	$dealerbranchid = $result15['branch'];
	$dealerregionid = $result15['region'];
	
	// Fetch branchhead email id 
	
	$query12 = "select TRIM(BOTH ',' FROM group_concat(emailid))as branchemailid from inv_mas_dealer where branchhead = 'yes' and (branch = '".$dealerbranchid."') and region = '".$dealerregionid."'";
	$result12 = runmysqlqueryfetch($query12);
	
	
	if(($_SERVER['HTTP_HOST'] == "localhost") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
	{
		$branchemailid = 'bhumika.p@relyonsoft.com';
		$salespersonemailid = 'sunil.l@relyonsoft.com';
	}
	else
	{
		$branchemailid = $result12['branchemailid'];
		$salespersonemailid = $result15['emailid'];
	}
	$ccids = $branchemailid.','.$coordinatoremaild.','.$salespersonemailid;//echo($ccids);exit;
	// $ccids = $branchemailid.','.$coordinatoremaild.','.$implementeremailid.','.$salespersonemailid;//echo($ccids);exit;
	///$ccids = $coordinatoremaild.','.$implementeremailid.','.$salespersonemailid; //
	$ccemailarray = explode(',',$ccids);
	$ccemailcount = count($ccemailarray);
	for($i = 0; $i < $ccemailcount; $i++)
	{
		if(checkemailaddress($ccemailarray[$i]))
		{
			if($i == 0)
			{
				$ccemailids[] = [
					'ccemail' => $ccemailarray[$i]
				];
			}
			else
			{
				$ccemailids[] = [
					'ccemail' => $ccemailarray[$i]
				];
			}
		}
	}
	$fromname = "Relyon";
	$fromemail = "imax@relyon.co.in";
	require_once("../inc/RSLMAIL_MAIL.php");
	$msg = file_get_contents("../mailcontents/assignedwithdays.htm");
	$textmsg = file_get_contents("../mailcontents/assignedwithdays.txt");

	//Create an array of replace parameters
	$array = array();
	$date = datetimelocal('d-m-Y');
	$array[] = "##DATE##%^%".$date;
	$array[] = "##NAME##%^%".trim($contactvalues,',');
	$array[] = "##COMPANYNAME##%^%".$businessname;
	$array[] = "##IMPLEMENTERNAME##%^%".$implementername;
	$array[] = "##TOTALDAYS##%^%".$noofdays;
	$array[] = "##EMAILID##%^%".$emailid; 
	$array[] = "##INVOICENO##%^%".$invoiceno;
	//Relyon Logo for email Content, as Inline [Not attachment]
	$imagepath = '../images/relyon-logo.jpg';
		$cid = 8888888888;
		$altimgname= 'relyon-logo.jpg';
	
	$toarray = $emailids;
	$ccarray = $ccemailids;
	if($_SERVER['HTTP_HOST'] == "localhost")
	{
		$bccemailids = [
			['bccemail' => 'bhumika.p@relyonsoft.com', 'name' => 'Bhumika']
		];
	}
	else
	{
		$bccemailids['bigmail'] ='bigmail@relyonsoft.com';
		$bccemailids['Relyonimax'] ='relyonimax@gmail.com';
	}

	$bccarray = $bccemailids;
	$msg = replacemailvariable($msg,$array);
	$textmsg = replacemailvariable($textmsg,$array);
	
	//$invoiceno = (!empty($invoiceno)) ? " $invoiceno " : '';

	if($imptype == 'handhold')
		$subject = 'Hand Hold implementation Assigned for '.$noofdays.' days(Beta)'; 
	else
		$subject = 'Implementation Assigned for '.$noofdays.' days(Beta)'; 
	$html = $msg;
	$text = $textmsg;
	include("../inc/PHPMAILER_MAIL.php");
	//rslmail($fromname, $fromemail, $toarray, $subject, $text, $html,$ccarray,$bccarray,$filearray);
	
	//Insert the mail forwarded details to the logs table
	$bccmailid = 'bigmail@relyonsoft.com';
	inserttologs($userid,$customerslno,$fromname,$fromemail,$emailid,null,$bccmailid,$subject);
	return 'sucess';
}

//send mail for activities
function sendactivitiesassignedemail($customerid,$implementerid,$imprefno,$imptype='')
{

	//  Get activities list 
	// $querycheckactivities = "select activityname from imp_implementationactivity left join imp_mas_activity on imp_mas_activity.slno = imp_implementationactivity.activity where impref = '".$imprefno."';";	
	if($imptype == 'handhold')
		$querycheckactivities = "select activity from imp_handholdimplementationactivity  where impref = '".$imprefno."';";	
	else
		$querycheckactivities = "select activity from imp_implementationactivity  where impref = '".$imprefno."';";	

	$resultcheckactivities = runmysqlquery($querycheckactivities); 
	$grid = '<table width="60%" cellpadding="3" cellspacing="0" class="table-border-grid" border="1">';
	$grid .= '<tr  align ="left" bgcolor="#CCCCCC"><td nowrap = "nowrap"  >Sl No</td><td nowrap = "nowrap" >Activity</td></tr>';
	$slno = 0;
	while($fetchcheckactivities = mysqli_fetch_array($resultcheckactivities))
	{
		$slno++;
		$grid .= '<tr align ="left">';
		$grid .= "<td nowrap='nowrap' >".$slno."</td>";
		$grid .= "<td nowrap='nowrap' >".$fetchcheckactivities['activity']."</td>";
		$grid .= "</tr>";
	}
	$grid .= '</table>';
	// Get the customer details
	$querygetcustomerdetails = 'select * from inv_mas_customer where slno = "'.$customerid.'"';	
	$fetchcustomerdetails = runmysqlqueryfetch($querygetcustomerdetails);
	$businessname = $fetchcustomerdetails['businessname'];
	
	// Fetch contact details 
	
	$querycontactdetails = "select  phone,cell,emailid,contactperson from inv_contactdetails where customerid = '".$customerid."'";
	$resultcontactdetails = runmysqlquery($querycontactdetails);
	// contact Details
	$contactvalues = '';
	$phoneres = '';
	$cellres = '';
	$emailidres = '';
			
	while($fetchcontactdetails = mysqli_fetch_array($resultcontactdetails))
	{
		$contactperson = $fetchcontactdetails['contactperson'];
		$phone = $fetchcontactdetails['phone'];
		$cell = $fetchcontactdetails['cell'];
		$emailid = $fetchcontactdetails['emailid'];
		
		$contactvalues .= $contactperson;
		$contactvalues .= appendcomma($contactperson);
		$phoneres .= $phone;
		$phoneres .= appendcomma($phone);
		$cellres .= $cell;
		$cellres .= appendcomma($cell);
		$emailidres .= $emailid;
		$emailidres .= appendcomma($emailid);
	}
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
		$emailid = 'archana.ab@relyonsoft.com';
	else
		$emailid = trim($emailidres,',');
	//Split multiple email IDs by Comma
	$emailarray = explode(',',$emailid);
	$emailcount = count($emailarray);
	
	//Convert email IDs to an array. First email ID will eb assigned with Contact person name. Others will be assigned with email IDs itself as Name.
	for($i = 0; $i < $emailcount; $i++)
	{
		if(checkemailaddress($emailarray[$i]))
		{
			$emailids[] = [
				'email' => $emailarray[$i]
			];
		}
	}
	// Get implementer name
	$querygetimplementer = 'select * from inv_mas_implementer where slno = "'.$implementerid.'"';
	$fetchimplementer = runmysqlqueryfetch($querygetimplementer); 
	
	$implementername = $fetchimplementer['businessname'];
	$implementeremailid = $fetchimplementer['emailid']; 
	$branchid = $fetchimplementer['branchid']; 
	$region = $fetchimplementer['region'];
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab"))
	{
		$implementeremailid = 'meghana.b@relyonsoft.com';
	}
	else
	{
		$implementeremailid = $implementeremailid ;
	}
	
	// Fetch  coordinator emailid
	$query13 = "select TRIM(BOTH ',' FROM group_concat(emailid))as coemailid from inv_mas_implementer where (branchid ='".$branchid."' or branchid ='all') and coordinator = 'yes' and region = '".$region."'";
	$result13 = runmysqlqueryfetch($query13);
	if(($_SERVER['HTTP_HOST'] == "localhost") )
	{
		$branchemailid = 'bhumika.p@relyonsoft.com';
		$coordinatoremaild = 'bhumika@relyonsoft.com';
	}
	else
	{
		$branchemailid = $branchheademailid; 
		$coordinatoremaild = $result13['coemailid'];
	}
	// Fetch sales person emailid
	$query14 = "select * from imp_implementation where customerreference = '".$customerid."'";
	$result14 = runmysqlqueryfetch($query14); 
	$dealerid = $result14['dealerid'];
	$invoiceno = $result14['invoicenumber'];
	
	$query15 = "select emailid from inv_mas_dealer where slno = '".$dealerid."'";
	$result15 = runmysqlqueryfetch($query15); 
	$dealerbranchid = $result15['branch'];
	$dealerregionid = $result15['region'];
	
		// Fetch branchhead email id 
	$query12 = "select TRIM(BOTH ',' FROM group_concat(emailid))as branchemailid from inv_mas_dealer where branchhead = 'yes' and branch = '".$dealerbranchid."' and region = '".$dealerregionid."'";
	$result12 = runmysqlqueryfetch($query12);
	$branchheademailid = $result12['branchemailid'];


	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
	{
		$salespersonemailid = 'bopanna.kn@relyonsoft.com';
	}
	else
	{
		$salespersonemailid = $result15['emailid'];
	}
	
	$ccids = $branchemailid.','.$coordinatoremaild.','.$implementeremailid.','.$salespersonemailid; 
	$ccemailarray = explode(',',$ccids);
	$ccemailcount = count($ccemailarray);
	for($i = 0; $i < $ccemailcount; $i++)
	{
		if(checkemailaddress($ccemailarray[$i]))
		{
			if($i == 0)
			{
				$ccemailids[] = [
					'ccemail' => $ccemailarray[$i]
				];
			}
			else
			{
				$ccemailids[] = [
					'ccemail' => $ccemailarray[$i]
				];
			}
		}
	}
	$fromname = "Relyon";
	$fromemail = "imax@relyon.co.in";
	require_once("../inc/RSLMAIL_MAIL.php");
	$msg = file_get_contents("../mailcontents/assignedactivities.htm");
	$textmsg = file_get_contents("../mailcontents/assignedactivities.txt");

	//Create an array of replace parameters
	$array = array();
	$date = datetimelocal('d-m-Y');
	$array[] = "##DATE##%^%".$date;
	$array[] = "##NAME##%^%".trim($contactvalues,',');
	$array[] = "##COMPANYNAME##%^%".$businessname;
	$array[] = "##IMPLEMENTERNAME##%^%".$implementername;
	$array[] = "##TABLE##%^%".$grid;
	$array[] = "##EMAILID##%^%".$emailid;
	
	//Relyon Logo for email Content, as Inline [Not attachment]
	$imagepath = '../images/relyon-logo.jpg';
		$cid = 8888888888;
		$altimgname= 'relyon-logo.jpg';
	
	$toarray = $emailids;
	$ccarray = $ccemailids;
	if(($_SERVER['HTTP_HOST'] == "localhost") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab"))
	{
		$bccemailids = [
			['bccemail' => 'bhumika.p@relyonsoft.com', 'name' => 'Bhumika']
		];
	}
	else
	{
		$bccemailids['bigmail'] ='bigmail@relyonsoft.com';
		$bccemailids['Relyonimax'] ='relyonimax@gmail.com';
	}

	$bccarray = $bccemailids;
	$msg = replacemailvariable($msg,$array);
	$textmsg = replacemailvariable($textmsg,$array);
	if($imptype == 'handhold')
		$subject = 'Hand Hold activities list to be implemented by '.$implementername.'(Beta)';
	else
		$subject = 'Activities list to be implemented by '.$implementername.'(Beta)'; 
	$html = $msg;
	$text = $textmsg;
	include("../inc/PHPMAILER_MAIL.php");
	//rslmail($fromname, $fromemail, $toarray, $subject, $text, $html,$ccarray,$bccarray,$filearray);
	
	//Insert the mail forwarded details to the logs table
	$bccmailid = 'bigmail@relyonsoft.com';
	inserttologs($userid,$customerslno,$fromname,$fromemail,$emailid,null,$bccmailid,$subject);
	return 'sucess';
}


function sendcustomizationmail($lastslno,$implementerid)
{
	//  Get activities list 
	$query1 = "select * from imp_implementation where slno = '".$lastslno."';";	
	$result1 = runmysqlqueryfetch($query1);
	$assignid = $result1['assignimplemenation'];
	$referfilename = $result1['customizationreffilepath'];
	$referfilearray = explode("/", $referfilename);
	$referfilename = $referfilearray[5];
	$sppbackupfilename = $result1['customizationbackupfilepath'];
	$sppbackuparray = explode("/", $sppbackupfilename);
	$sppbackupfilename = $sppbackuparray[5];
	$customizationremarks = $result1['customizationremarks'];
	
	if($implementerid <> $assignid)
	{
		//Respective implementer, whom implementation is assigned (if different)
		$querygetimplementer1 = 'select * from inv_mas_implementer where slno = "'.$assignid.'"';
		$fetchimplementer1 = runmysqlqueryfetch($querygetimplementer1); 
		if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
		{
			$assignidmail = "";
		}
		else
		{
			$assignidmail = $fetchimplementer1['emailid'];
		}
	}
	else
	{
		$assignidmail = "";
	}
	
	//To fetch Sales Person Emailid 
	$query11 = "select * from inv_mas_dealer where slno = '".$result1['dealerid']."'";
	$result11 = runmysqlqueryfetch($query11);
	$branchid = $result11['branch'];
	$region = $result11['region'];
	
	//To fetch Branch Head Emailid 
	$query12 = "select TRIM(BOTH ',' FROM group_concat(emailid))as branchemailid from inv_mas_dealer where branchhead = 'yes' and branch = '".$branchid."' and region = '".$region."';";
	$result12 = runmysqlqueryfetch($query12);
	
	// Get implementer name
	$querygetimplementer = 'select * from inv_mas_implementer where slno = "'.$implementerid.'"';
	$fetchimplementer = runmysqlqueryfetch($querygetimplementer); 
	
	$implementername = $fetchimplementer['businessname'];
	$implementeremailid = $fetchimplementer['emailid']; 
	$implementerbranchid = $fetchimplementer['branchid']; 
	$implementerregionid = $fetchimplementer['region']; 
	
	// Fetch coordination Emailid 
	$query13 = "select TRIM(BOTH ',' FROM group_concat(businessname))as coname, TRIM(BOTH ',' FROM group_concat(emailid))as coemailid from inv_mas_implementer where (branchid ='".$implementerbranchid."' or branchid ='all') and region = '".$implementerregionid."' and coordinator = 'yes' ";
	$result13 = runmysqlqueryfetch($query13);
	
	$coordinatorname = $result13['coname'];
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab") )
	{
		$dealeremailid = 'bopanna.kn@relyonsoft.com';
		$branchemailid = 'rashmi.hk@relyonsoft.com';
		$coordinatoremaild = 'meghana.b@relyonsoft.com';
	}
	else
	{
		$dealeremailid = $result11['emailid'];
		$branchemailid = $result12['branchemailid']; 
		$coordinatoremaild = $result13['coemailid'];
	}
	
	// Get the customer details
	$querygetcustomerdetails = 'select * from inv_mas_customer where slno = "'.$result1['customerreference'].'"';	
	$fetchcustomerdetails = runmysqlqueryfetch($querygetcustomerdetails);
	$businessname = $fetchcustomerdetails['businessname'];
	
	//Split multiple email IDs by Comma
	$emailarray = explode(',',$coordinatoremaild);
	$emailcount = count($emailarray);
	
	//Convert email IDs to an array. First email ID will eb assigned with Contact person name. Others will be assigned with email IDs itself as Name.
	for($i = 0; $i < $emailcount; $i++)
	{
		if(checkemailaddress($emailarray[$i]))
		{
				$emailids[$emailarray[$i]] = $emailarray[$i];
		}
	}

	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab"))
	{
		$implementeremailid = 'b@b.com';
	}
	else
	{
		$implementeremailid = $implementeremailid ;
	}

	
	$ccids = $dealeremailid.','.$branchemailid.','.$implementeremailid.','.$assignidmail; 
	$ccemailarray = explode(',',$ccids);
	$ccemailcount = count($ccemailarray);
	for($i = 0; $i < $ccemailcount; $i++)
	{
		if(checkemailaddress($ccemailarray[$i]))
		{
			if($i == 0)
				$ccemailids[$ccemailarray[$i]] = $ccemailarray[$i];
			else
				$ccemailids[$ccemailarray[$i]] = $ccemailarray[$i];
		}
	}
	
	$fromname = "Relyon";
	$fromemail = "imax@relyon.co.in";
	require_once("../inc/RSLMAIL_MAIL.php");
	$msg = file_get_contents("../mailcontents/customizationrequest.htm");
	$textmsg = file_get_contents("../mailcontents/customizationrequest.txt");

	//Create an array of replace parameters
	$array = array();
	$date = datetimelocal('d-m-Y H:i:s');
	$array[] = "##DATE##%^%".datetimelocal('d-m-Y');
	$array[] = "##DATETIME##%^%".$date;
	$array[] = "##COORDINATORNAME##%^%".$coordinatorname;
	$array[] = "##COMPANYNAME##%^%".$businessname;
	$array[] = "##REFERENCEFILENAME##%^%".$referfilename;
	$array[] = "##SPPDATAFILENAME##%^%".$sppbackupfilename;
	$array[] = "##REMARKS##%^%".$customizationremarks;
	$array[] = "##IMPLEMENTERNAME##%^%".$implementername;
	$array[] = "##EMAILID##%^%".$emailid;
	
	//Relyon Logo for email Content, as Inline [Not attachment]
	$filearray = array(
		array('../images/relyon-logo.jpg','inline','8888888888'),
	
	);
	
	$toarray = $emailids;
	$ccarray = $ccemailids;
	if(($_SERVER['HTTP_HOST'] == "meghanab") || ($_SERVER['HTTP_HOST'] == "rashmihk") ||  ($_SERVER['HTTP_HOST'] == "archanaab"))
	{
		$bccemailids['archana'] ='rashmi.hk@relyonsoft.com';
	}
	else
	{
		$bccemailids['bigmail'] ='bigmail@relyonsoft.com';
		$bccemailids['Relyonimax'] ='relyonimax@gmail.com';
	}

	$bccarray = $bccemailids;
	$msg = replacemailvariable($msg,$array);
	$textmsg = replacemailvariable($textmsg,$array);
	$subject = 'Customization have been added by '.$implementername.'(Beta)'; 
	$html = $msg;
	$text = $textmsg;
	rslmail($fromname, $fromemail, $toarray, $subject, $text, $html,$ccarray,$bccarray,$filearray);
	
	//Insert the mail forwarded details to the logs table
	$bccmailid = 'bigmail@relyonsoft.com';
	inserttologs($userid,$customerslno,$fromname,$fromemail,$emailid,null,$bccmailid,$subject);
	return 'sucess';
}



function appendcomma($value)
{
	if($value != '')
	{
		$append = ',';
	}
	else
	{
		$append = '';
	}
	return $append;
}
?>