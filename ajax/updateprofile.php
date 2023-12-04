<?php
ob_start("ob_gzhandler");

include('../inc/ajax-referer-security.php');
include('../functions/phpfunctions.php'); 
$switchtype = $_POST['switchtype'];

if(imaxgetcookie('userslno') <> '') 
$userid = imaxgetcookie('userslno');
else
{ 
	echo('Thinking to redirect');
	exit;
}

switch($switchtype)
{
	case 'save':
	{
		//$userid = $_POST['userid'];
		$address = $_POST['address'];
		$place = $_POST['place'];
		$district = $_POST['district'];
		$state = $_POST['state'];
		$pincode = $_POST['pincode'];
		$stdcode = $_POST['stdcode'];
		//Added Space after comma is not avaliable in phone and cell fields
		$phone = $_POST['phone'];
		$phonespace = str_replace(", ", ",",$phone);
		$phonevalue = str_replace(',',', ',$phonespace);
		
		$cell = $_POST['cell'];
		$cellspace = str_replace(", ", ",",$cell);
		$cellvalue = str_replace(',',', ',$cellspace);
			
		$emailid = $_POST['emailid'];
		$personalemailid = $_POST['personalemailid'];
		$createddate = datetimelocal('d-m-Y').' '.datetimelocal('H:i:s');

		$query = "UPDATE inv_mas_implementer SET address = '".$address."',place = '".$place."',pincode = '".$pincode."',district = '".$district."',stdcode = '".$stdcode."',phone = '".$phonevalue."',cell = '".$cellvalue."',emailid  = '".$emailid."',personalemailid  = '".$personalemailid."',createddate = '".changedateformatwithtime($createddate)."' WHERE slno = '".$userid."'";
		$result = runmysqlquery($query);
		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userslno."','".$_SERVER['REMOTE_ADDR']."','169','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		echo('1^Your profile has been updated successfully.');
	}
	break;
	case 'undo':
	{

		$query = "SELECT inv_mas_implementer.slno AS dealerid,inv_mas_implementer.businessname AS businessname,inv_mas_implementer.contactperson AS contactperson,inv_mas_region.category AS region,inv_mas_implementer.address AS address,inv_mas_implementer.place AS place,inv_mas_implementer.district AS district,inv_mas_district.statecode as state,inv_mas_implementer.pincode AS pincode,inv_mas_implementer.stdcode AS stdcode ,inv_mas_implementer.phone AS phone,inv_mas_implementer.cell AS cell,inv_mas_implementer.emailid AS emailid ,inv_mas_implementer.website AS website,inv_mas_implementer.personalemailid AS personalemailid ,inv_mas_implementer.createddate AS createddate FROM inv_mas_implementer left join inv_mas_district on inv_mas_implementer.district = inv_mas_district.districtcode left join inv_mas_region on inv_mas_region.slno = inv_mas_implementer.region WHERE inv_mas_implementer.slno = '".$userid."';";
		$fetch = runmysqlqueryfetch($query);
		
	echo($fetch['contactperson'].'^'.$fetch['address'].'^'.$fetch['place'].'^'.$fetch['state'].'^'.$fetch['district'].'^'.$fetch['pincode'].'^'.$fetch['region'].'^'.$fetch['stdcode'].'^'.$fetch['phone'].'^'.$fetch['cell'].'^'.$fetch['emailid'].'^'.$fetch['website'].'^'.$fetch['createddate'].'^'.$fetch['businessname'].'^'.$fetch['personalemailid']);
		
		}
		break;
	case 'getdealerdetails':
	{
		$query = "SELECT inv_mas_implementer.slno AS dealerid,inv_mas_implementer.businessname AS businessname,inv_mas_implementer.contactperson AS contactperson,inv_mas_region.category AS region,inv_mas_implementer.address AS address,inv_mas_implementer.place AS place,inv_mas_implementer.district AS district,inv_mas_district.statecode as state,inv_mas_implementer.pincode AS pincode,inv_mas_implementer.stdcode AS stdcode ,inv_mas_implementer.phone AS phone,inv_mas_implementer.cell AS cell,inv_mas_implementer.emailid AS emailid ,inv_mas_implementer.website AS website,inv_mas_implementer.personalemailid AS personalemailid ,inv_mas_implementer.createddate AS createddate FROM inv_mas_implementer left join inv_mas_district on inv_mas_implementer.district = inv_mas_district.districtcode left join inv_mas_region on inv_mas_region.slno = inv_mas_implementer.region WHERE inv_mas_implementer.slno = '".$userid."';";
		$fetch = runmysqlqueryfetch($query);
		
		echo($fetch['contactperson'].'^'.$fetch['address'].'^'.$fetch['place'].'^'.$fetch['state'].'^'.$fetch['district'].'^'.$fetch['pincode'].'^'.$fetch['region'].'^'.$fetch['stdcode'].'^'.$fetch['phone'].'^'.$fetch['cell'].'^'.$fetch['emailid'].'^'.$fetch['website'].'^'.changedateformatwithtime($fetch['createddate']).'^'.$fetch['businessname'].'^'.''.'^'.$fetch['personalemailid']);
	
	}
	break;
}
?>
