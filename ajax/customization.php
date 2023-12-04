<?php

ob_start("ob_gzhandler");
include('../inc/ajax-referer-security.php');
include('../functions/phpfunctions.php');

if(imaxgetcookie('userslno')<> '') 
$userid = imaxgetcookie('userslno');
else
{ 
	echo('Thinking to redirect');
	exit;
}

$lastslno = $_POST['lastslno'];
$switchtype = $_POST['switchtype'];

switch($switchtype)
{
	case 'generatecustomerlist':
	{
		$query1 = "select * from inv_mas_implementer where slno = '".$userid."';";
		$resultfetch = runmysqlqueryfetch($query1);
		$coordinator = $resultfetch['coordinator'];
		$region = $resultfetch['region'];
		if($coordinator == 'yes')
			$coordinatorpiece =" and imp_implementation.assigncustomization is not null";
		else
			$coordinatorpiece = " and imp_implementation.assigncustomization = '".$userid."'";
		if(($region == '1') || ($region == '3'))
		{	
			$query = "select inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join imp_implementation on inv_mas_customer.slno = imp_implementation.customerreference where imp_implementation.customerreference is not null ".$coordinatorpiece."  and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3') order by inv_mas_customer.businessname;";
		}
		else
		{
			$query = "select inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join imp_implementation on inv_mas_customer.slno = imp_implementation.customerreference where imp_implementation.customerreference is not null ".$coordinatorpiece."  and inv_mas_customer.region = '".$region."' order by inv_mas_customer.businessname;";
		}
		$result = runmysqlquery($query);
		$grid = '';
		$count = 1;
		while($fetch = mysqli_fetch_array($result))
		{
			if($count > 1)
				$grid .='^*^';
			$grid .= $fetch['businessname'].'^'.$fetch['slno'];
			$count++;
		}
		echo($grid);
	}
	break;
	
	case 'gridtoform':
	{
		$query = "select slno,customerreference,invoicenumber,advancecollected,advanceamount,advanceremarks,balancerecoveryremarks,podetails, numberofcompanies,numberofmonths,processingfrommonth,additionaltraining,freedeliverables,schemeapplicable,commissionapplicable,commissionname,commissionemail,commissionmobile,commissionvalue,masterdatabyrelyon,masternumberofemployees,salescommitments,attendanceapplicable,attendanceremarks,attendancefilepath,shipinvoiceapplicable,shipinvoiceremarks,shipmanualapplicable,shipmanualremarks,customizationapplicable,customizationremarks,customizationreffilepath,customizationbackupfilepath,customizationstatus,implementationstatus,webimplemenationapplicable,webimplemenationremarks,assignimplemenation,assigncustomization,assignwebimplemenation,committedstartdate,podetailspath from imp_implementation where customerreference = '".$lastslno."';";
		$fetch = runmysqlqueryfetch($query);
		$query1 = "SELECT imp_addon.slno, imp_addon.customerid, imp_addon.refslno, imp_mas_addons.addonname as addon, imp_addon.remarks,imp_addon.addon as addonslno from imp_addon left join imp_mas_addons on imp_mas_addons.slno = imp_addon.addon where refslno  = '".$fetch['slno']."';";
		$result1 = runmysqlquery($query1);
		if(mysqli_num_rows($result1) == 0)
		{
			$grid .= '<table width="100%" border="0" cellspacing="0"  cellpadding="3" id="seletedaddongrid" class="table-border-grid" ><tr class="tr-grid-header"><td width="11%" nowrap = "nowrap" class="td-border-grid" align="left">Slno</td><td width="30%" nowrap = "nowrap" class="td-border-grid" align="left">Add - On</td><td width="46%" nowrap = "nowrap" class="td-border-grid" align="left">Remarks</td></tr><tr><td colspan="4" class="td-border-grid" id="messagerow"> <div align="center"><font color="#FF0000"><strong>No Records Available</strong></font></div></td></tr></table>';
		}
		else
		{
			$grid .= '<table width="100%" border="0" cellspacing="0"  cellpadding="3" id="seletedaddongrid" class="table-border-grid" >';
			$grid .= '<tr class="tr-grid-header"><td width="11%" nowrap = "nowrap" class="td-border-grid" align="left">Slno</td><td width="30%" nowrap = "nowrap" class="td-border-grid" align="left">Add - On</td><td width="46%" nowrap = "nowrap" class="td-border-grid" align="left">Remarks</td></tr>';
			$slno = 0;
			while($resultfetch = mysqli_fetch_array($result1))
			{
				$slno++;
				$grid .= "<tr>";
				$grid .= "<td class='td-border-grid'>".$slno."</td>";
				$grid .= "<td class='td-border-grid' >".$resultfetch['addon']."</td>";
				$grid .= "<td class='td-border-grid' >".$resultfetch['remarks']."</td>";
				$grid .= "</tr>";
			}
			$grid .= "</table>";
		}
		$query22 = "SELECT slno,attachfilepath,remarks from imp_rafiles  WHERE impref = '".$fetch['slno']."' order by createddatetime DESC ";
		$result11 = runmysqlquery($query22);
		if(mysqli_num_rows($result1) == 0)
		{
			$griddisplay .= '<table width="100%" cellpadding="3" cellspacing="0" class="table-border-grid"><tr class="tr-grid-header" align ="left"><td nowrap = "nowrap" class="td-border-grid" >Sl No</td><td nowrap = "nowrap" class="td-border-grid">File Name</td><td nowrap = "nowrap" class="td-border-grid">Remarks</td><td nowrap = "nowrap" class="td-border-grid">Download</td></tr><tr><td colspan ="4"><div align="center"><font color="#FF0000"><strong>No Records to Display</strong></font></div></td></tr></table>';
		}
		else
		{
			$griddisplay .= '<table width="100%" cellpadding="3" cellspacing="0" class="table-border-grid"><tr class="tr-grid-header" align ="left"><td nowrap = "nowrap" class="td-border-grid" >Sl No</td><td nowrap = "nowrap" class="td-border-grid">File Name</td><td nowrap = "nowrap" class="td-border-grid">Remarks</td><td nowrap = "nowrap" class="td-border-grid">Download</td></tr>';
			$countslno = 0;
			while($fetch1 = mysqli_fetch_array($result11))
			{
				$i_n++;
				$countslno++;
				$color;
				$filename = explode('/',$fetch1['attachfilepath']);
				if($i_n%2 == 0)
					$color = "#edf4ff";
				else
					$color = "#f7faff";
				$griddisplay .= '<tr class="gridrow" bgcolor='.$color.'  align ="left">';
				$griddisplay .= "<td nowrap='nowrap' class='td-border-grid'>".$countslno."</td>";
				$griddisplay .= "<td nowrap='nowrap' class='td-border-grid'>".$filename[5]."</td>";
				$griddisplay .= "<td nowrap='nowrap' class='td-border-grid'>".gridtrim($fetch1['remarks'])."</td>";
				$griddisplay .= "<td nowrap='nowrap' class='td-border-grid'><div align = 'center'><img src='../images/download-arrow.gif'  onclick = viewcustfilepath('".$fetch1['attachfilepath']."') /></div></td>";
				$griddisplay .= "</tr>";
			}
			$griddisplay .= "</table>";
		}
		echo('1^'.$fetch['slno'].'^'.$fetch['customerreference'].'^'.$fetch['invoicenumber'].'^'.strtoupper($fetch['advancecollected']).'^'.$fetch['advanceamount'].'^'.$fetch['advanceremarks'].'^'.$fetch['balancerecoveryremarks'].'^'.$griddisplay.'^'.$fetch['podetails'].'^'.$fetch['numberofcompanies'].'^'.$fetch['numberofmonths'].'^'.$fetch['processingfrommonth'].'^'.$fetch['additionaltraining'].'^'.$fetch['freedeliverables'].'^'.$fetch['schemeapplicable'].'^'.strtoupper($fetch['commissionapplicable']).'^'.$fetch['commissionname'].'^'.$fetch['commissionemail'].'^'.$fetch['commissionmobile'].'^'.$fetch['commissionvalue'].'^'.strtoupper($fetch['masterdatabyrelyon']).'^'.$fetch['masternumberofemployees'].'^'.$fetch['salescommitments'].'^'.strtoupper($fetch['attendanceapplicable']).'^'.$fetch['attendanceremarks'].'^'.$fetch['attendancefilepath'].'^'.strtoupper($fetch['shipinvoiceapplicable']).'^'.$fetch['shipinvoiceremarks'].'^'.strtoupper($fetch['shipmanualapplicable']).'^'.$fetch['shipmanualremarks'].'^'.strtoupper($fetch['customizationapplicable']).'^'.$fetch['customizationremarks'].'^'.$fetch['customizationreffilepath'].'^'.$fetch['customizationbackupfilepath'].'^'.$fetch['customizationstatus'].'^'.$fetch['implementationstatus'].'^'.$grid.'^'.strtoupper($fetch['webimplemenationapplicable']).'^'.$fetch['webimplemenationremarks'].'^'.$fetch['assignimplemenation'].'^'.$fetch['assigncustomization'].'^'.$fetch['assignwebimplemenation'].'^'.changedateformat($fetch['committedstartdate']).'^'.$fetch['podetailspath']);
	}
	break;
	case 'customercontactdetailstoform':
	{
		$query1 = "select count(*) as  count from inv_mas_customer where slno = '".$lastslno."';";
		$fetch1 = runmysqlqueryfetch($query1);
		if($fetch1['count'] > 0)
		{
			$query = "select inv_mas_customer.slno as slno, inv_mas_customer.businessname as companyname	,inv_mas_customer.place,inv_mas_customer.address,inv_mas_region.category as region,inv_mas_branch.branchname as branch	,inv_mas_customercategory.businesstype,inv_mas_customertype.customertype,inv_mas_dealer.businessname as dealername,inv_mas_customer.stdcode, inv_mas_customer.pincode,inv_mas_district.districtname, inv_mas_state.statename,inv_mas_customer.customerid  from inv_mas_customer left join inv_mas_dealer on inv_mas_dealer.slno = inv_mas_customer.currentdealer left join inv_mas_region on inv_mas_region.slno = inv_mas_customer.region left join inv_mas_branch on inv_mas_branch.slno = inv_mas_customer.branch left join inv_mas_district on inv_mas_district.districtcode = inv_mas_customer.district left join inv_mas_customertype on inv_mas_customertype.slno = inv_mas_customer.type left join inv_mas_customercategory on inv_mas_customercategory.slno = inv_mas_customer.category left join inv_mas_state on inv_mas_state.statecode = inv_mas_district.statecode where inv_mas_customer.slno = '".$lastslno."';";
			$fetch = runmysqlqueryfetch($query);
			
			$query2 = "select group_concat(phone) as phone,group_concat(cell) as cell,group_concat(emailid) as emailid,group_concat(contactperson) as contactperson from inv_contactdetails where customerid = '".$fetch['slno']."'; ";
			$resultfetch2 = runmysqlqueryfetch($query2);
			
			$customerid = ($fetch['customerid'] == '')?'':cusidcombine($fetch['customerid']);	
			$pincode = ($resultfetch['pincode'] == '')?'':'Pin - '.$fetch['pincode'];
			$address = $fetch['address'].', '.$fetch['districtname'].', '.$fetch['statename'].$pincode;
			$phonenumber = explode(',', $resultfetch2['phone']);
			$phone = $phonenumber[0];
			$cellnumber = explode(',', $resultfetch2['cell']);
			$cell = $cellnumber[0];
			$emailid = explode(',', $resultfetch2['emailid']);
			$emailidplit = $emailid[0];
			
			echo('1^'.$fetch['slno'].'^'.$customerid.'^'.$fetch['companyname'].'^'.$resultfetch2['contactperson'].'^'.$address.'^'.$phone.'^'.$cell.'^'.$emailidplit.'^'.$fetch['region'].'^'.$fetch['branch'].'^'.$fetch['businesstype'].'^'.$fetch['customertype'].'^'.$fetch['dealername'].'^'.$query2);
		}
		else
		{
			echo(''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.'');
		}
	}
	break;
		
	case 'assigndaysgrid':
	{
		$implastslno = $_POST['implastslno'];
		$count = 0;
		$query11 = "SELECT slno,assigneddate,remarks from imp_customizationdays  WHERE impref = '".$implastslno."' order by createddatetime DESC ";
		$result11 = runmysqlquery($query11);
		$grid .= '<select name="custgrid" class="swiftselect" id="custgrid" style="width:200px;" ><option value="" selected="selected">-- Select--</option>';
		while($fetch = mysqli_fetch_array($result11))
		{
			$slno++;
			$assigndate = changedateformat($fetch['assigneddate']);
			if($fetch['remarks'] != '')
				$assignremarks = gridtrim($fetch['remarks']);
			else
				$assignremarks = 'Not Available';
			$grid .='<option value="'.$fetch['slno'].'">Assigned'.$slno.' '.'('.$assigndate.'/'.$assignremarks.')'.'</option>';
			$implastslno = $fetch['slno'];
		}
		$grid .= '</select>';
		echo('1^'.$grid.'^'.$implastslno);
	}
	break;
	case 'assigneddaysgridtoform':
	{
		$impreflastslno = $_POST['impreflastslno'];
		$custtext = $_POST['custtext'];
		$query = "SELECT * from  imp_customizationdays where slno = '".$impreflastslno."';";
		$fetch = runmysqlqueryfetch($query);
		if($fetch['customizationworkdate'] == '')
			$customizationworkdate = '';
		else
			$customizationworkdate = changedateformat($fetch['customizationworkdate']);
		echo('1^'.changedateformat($fetch['assigneddate']).'^'.$customizationworkdate.'^'.$fetch['dayremarks'].'^'.$custtext.'^'.$fetch['impref']);
	}
	break;
	case 'assigndetails':
	{
		$impslno = $_POST['impslno'];
		$count = 0;
		$query11 = "SELECT slno,assigneddate,remarks from imp_customizationdays  WHERE impref = '".$impslno."' order by createddatetime asc ";
		$result11 = runmysqlquery($query11);
		$grid .= '<select name="custgrid" class="swiftselect" id="custgrid" style="width:200px;" ><option value="" selected="selected">-- Select--</option>';
		while($fetch = mysqli_fetch_array($result11))
		{
			$slno++;
			$assigndate = changedateformat($fetch['assigneddate']);
			if($fetch['remarks'] != '')
				$assignremarks = gridtrim($fetch['remarks']);
			else
				$assignremarks = 'Not Available';
			$grid .='<option value="'.$fetch['slno'].'">Assigned'.$slno.' '.'('.$assigndate.'/'.$assignremarks.')'.'</option>';
			$implastslno = $fetch['slno'];
		}
		$grid .= '</select>';
		echo('1^'.$grid);
	}
	break;
	case 'assigndayssave':
	{
		$impreflastslno = $_POST['impreflastslno'];
		$customizationworkdate = changedateformat($_POST['customizationworkdate']);
		$dayremarks = $_POST['dayremarks'];
		
		$query = "update imp_customizationdays set customizationworkdate = '".$customizationworkdate."', dayremarks = '".$dayremarks."' where slno ='".$impreflastslno."';";
		$result = runmysqlquery($query);
		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','165','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		echo('1^Record updated successfully');
	}
	break;
	case 'customizationfilesave':
	{
		$customizationremarks = $_POST['customizationremarks'];
		$filelink = $_POST['filelink'];
		$impcustomizationlastslno = $_POST['impcustomizationlastslno'];
		$implastslno = $_POST['implastslno'];
		if($impcustomizationlastslno == '')
		{
			$query = "Insert into imp_customizationfiles (attachfilepath, remarks, createddatetime,createdby, createdip, lastupdateddatetime, lastupdatedip, lastupdatedby, impref) values('".$filelink."','".$customizationremarks."','".date('Y-m-d').' '.date('H:i:s')."','".$userid."','".$_SERVER['REMOTE_ADDR']."','".date('Y-m-d').' '.date('H:i:s')."','".$_SERVER['REMOTE_ADDR']."','".$userid."','".$implastslno."');";
			$result = runmysqlquery($query);
			$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','166','".date('Y-m-d').' '.date('H:i:s')."')";
			$eventresult = runmysqlquery($eventquery);
		}
		else
		{
			$query = "Update imp_customizationfiles set attachfilepath =  '".$filelink."', remarks = '".$customizationremarks."', lastupdateddatetime = '".date('Y-m-d').' '.date('H:i:s')."',lastupdatedip = '".$_SERVER['REMOTE_ADDR']."',lastupdatedby = '".$userid."' where slno = '".$impcustomizationlastslno."' ; ";
			$result = runmysqlquery($query);
			$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','167','".date('Y-m-d').' '.date('H:i:s')."')";
			$eventresult = runmysqlquery($eventquery);
		}
		echo('1^Record saved successfully');
	}
	break;
	case 'customizationfiledelete':
	{
		$impcustomizationlastslno = $_POST['impcustomizationlastslno'];
		$query1 = "select * from imp_customizationfiles where slno = '".$impcustomizationlastslno."';";
		$resultfetch = runmysqlqueryfetch($query1);
		$filepath = $resultfetch['attachfilepath'];
		$query = "Delete from imp_customizationfiles where slno = '".$impcustomizationlastslno."';";
		$result = runmysqlquery($query);
		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','168','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		//unlink($filepath);
		echo('1^Record Deleted successfully');
	}
	break;
	case 'customizationnfilegrid':
	{
		$implastslno = $_POST['implastslno'];
		$startlimit = $_POST['startlimit'];
		$slno = $_POST['slno'];	
		$showtype = $_POST['showtype'];
		$resultcount = "SELECT count(*) as count from imp_customizationfiles where impref = '".$implastslno."';";
		$fetch10 = runmysqlqueryfetch($resultcount);
		$fetchresultcount = $fetch10['count'];;
		if($showtype == 'all')
		$limit = 100000;
		else
		$limit = 10;
		if($startlimit == '')
		{
			$startlimit = 0;
			$slno = 0;
		}
		else
		{
			$startlimit = $slno;
			$slno = $slno;
		}
		
		$query = "SELECT slno,attachfilepath,remarks from imp_customizationfiles  WHERE impref = '".$implastslno."' order by createddatetime DESC LIMIT ".$startlimit.",".$limit.";";
		if($startlimit == 0)
		{
			$grid = '<table width="100%" cellpadding="3" cellspacing="0" class="table-border-grid">';
			$grid .= '<tr class="tr-grid-header" align ="left"><td nowrap = "nowrap" class="td-border-grid" >Sl No</td><td nowrap = "nowrap" class="td-border-grid">File Name</td><td nowrap = "nowrap" class="td-border-grid">Remarks</td><td nowrap = "nowrap" class="td-border-grid">Download</td></tr>';
		}
		$i_n = 0;
		$result = runmysqlquery($query);
		while($fetch = mysqli_fetch_array($result))
		{
			$i_n++;
			$slno++;
			$color;
			$filename = explode('/',$fetch['attachfilepath']);
			if($i_n%2 == 0)
				$color = "#edf4ff";
			else
				$color = "#f7faff";
			$grid .= '<tr class="gridrow" bgcolor='.$color.' onclick="customizationgridtoform(\''.$fetch['slno'].'\'); " align ="left">';
			$grid .= "<td nowrap='nowrap' class='td-border-grid'>".$slno."</td>";
			$grid .= "<td nowrap='nowrap' class='td-border-grid'>".$filename[5]."</td>";
			$grid .= "<td nowrap='nowrap' class='td-border-grid'>".gridtrim($fetch['remarks'])."</td>";
			$grid .= "<td nowrap='nowrap' class='td-border-grid'><div align = 'center'><img src='../images/download-arrow.gif' onclick = customizationfilepath('".$fetch['attachfilepath']."') /></div></td>";
			$grid .= "</tr>";
		}
		$fetchcount = mysqli_num_rows($result);
		if($fetchcount == '0')
			$grid .= "<tr><td colspan ='4'><div align='center'><font color='#FF0000'><strong>No Records to Display</strong></font></div></td></tr>";
		$grid .= "</table>";

		if($slno >= $fetchresultcount)
			$linkgrid = '';
			//$linkgrid .='<table width="100%" border="0" cellspacing="0" cellpadding="0" height ="20px"><tr><td bgcolor="#FFFFD2"><font color="#FF4F4F">No More Records</font><div></div></td></tr></table>';
		else
			$linkgrid = '';
			//$linkgrid .= '<table><tr><td class="resendtext"><div align ="left" style="padding-right:10px"><a onclick ="getmoredatagrid(\''.$startlimit.'\',\''.$slno.'\',\'more\'); " style="cursor:pointer">Show More Records >></a>&nbsp;&nbsp;&nbsp;<a onclick ="getmoredatagrid(\''.$startlimit.'\',\''.$slno.'\',\'all\');" class="resendtext1" style="cursor:pointer"><font color = "#000000">(Show All Records)</font></a></div></td></tr></table>';
		
		echo '1^'.$grid.'^'.$linkgrid.'^'.$fetchresultcount.'^'.$query;
	}
	break;
	case 'customizationgridtoform':
	{
		$impcustomizationlastslno = $_POST['impcustomizationlastslno'];
		$query = "SELECT * from  imp_customizationfiles where slno = '".$impcustomizationlastslno."';";
		$fetch = runmysqlqueryfetch($query);
		$filename = explode('/',$fetch['attachfilepath']);
		echo('1^'.$filename[5].'^'.$fetch['remarks'].'^'.$fetch['attachfilepath']);
	}
	break;
	case 'invoicedetailsgrid':
	{
		$rslno = $_POST['rslno'];
		
		$query13 = "SELECT count(*) as count from imp_cfentries where  imp_cfentries.invoiceno = '".$rslno."'";
		$fetch13 = runmysqlqueryfetch($query13);
		if($fetch13['count'] != 0)
		{
			$query = "select distinct inv_mas_product.productname as product,imp_cfentries.usagetype,imp_cfentries.purchasetype,
inv_mas_scratchcard.scratchnumber,imp_cfentries.customerid from imp_cfentries left join inv_mas_product on inv_mas_product.productcode = imp_cfentries.productcode left join inv_mas_scratchcard on inv_mas_scratchcard.cardid = imp_cfentries.cardid where imp_cfentries.invoiceno = '".$rslno."'";
			$result = runmysqlquery($query);
			$grid = '<table width="100%" border="0" cellspacing="0" cellpadding="3" class="table-border-grid">';
			$grid .='<tr class="tr-grid-header"><td nowrap = "nowrap" class="td-border-grid" align="left">Slno</td><td nowrap = "nowrap" class="td-border-grid" align="left">Product Name</td><td nowrap = "nowrap" class="td-border-grid" align="left">Usage Type</td><td nowrap = "nowrap" class="td-border-grid" align="left">Purchase Type</td><td nowrap = "nowrap" class="td-border-grid" align="left">Pin Number</td><td nowrap = "nowrap" class="td-border-grid" align="left">Price</td></tr>';
			$slno = 0;
			while($fetchres = mysqli_fetch_array($result))
			{
					$slno++;
					$i_n++;
					if($i_n%2 == 0)
					$color = "#edf4ff";
					else
					$color = "#f7faff";
					$grid .= '<tr class="gridrow1"  bgcolor='.$color.' align="left">';
					$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left">'.$slno.'</td>';
					$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left">'.$fetchres['product'].'</td>';
					$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left">'.$fetchres['usagetype'].'</td>';
					$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left">'.$fetchres['purchasetype'].'</td>';
					$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left">'.$fetchres['scratchnumber'].'</td>';
					$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left">-</td>';
					$grid .= '</tr>';
					$customerid = substr($fetchres['customerid'],15);
			}
			$grid .= '</table>';
		}
		else
		{
			$query = "select distinct  inv_invoicenumbers.slno,inv_invoicenumbers.customerid,
	inv_invoicenumbers.businessname,inv_invoicenumbers.description
	,inv_invoicenumbers.invoiceno,inv_invoicenumbers.netamount
	from inv_invoicenumbers left join inv_dealercard on inv_invoicenumbers.slno = inv_dealercard.invoiceid
	where  inv_invoicenumbers.invoiceno = '".$rslno."'";
			$result = runmysqlqueryfetch($query);
			$productsplit = explode('*',$result['description']);
			$grid = '<table width="100%" border="0" cellspacing="0" cellpadding="3" class="table-border-grid">';
			$grid .='<tr class="tr-grid-header"><td nowrap = "nowrap" class="td-border-grid" align="left">Slno</td><td nowrap = "nowrap" class="td-border-grid" align="left">Product Name</td><td nowrap = "nowrap" class="td-border-grid" align="left">Usage Type</td><td nowrap = "nowrap" class="td-border-grid" align="left">Purchase Type</td><td nowrap = "nowrap" class="td-border-grid" align="left">Pin Number</td><td nowrap = "nowrap" class="td-border-grid" align="left">Price</td></tr>';
			for($i=0;$i<count($productsplit);$i++)
			{
				$splitproduct[] = explode('$',$productsplit[$i]);
			}
			$slno = 0;
			for($j=0;$j<count($splitproduct);$j++)
				{
					$slno++;
					$i_n++;
					if($i_n%2 == 0)
					$color = "#edf4ff";
					else
					$color = "#f7faff";
					$grid .= '<tr class="gridrow1"  bgcolor='.$color.' align="left">';
					$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left">'.$slno.'</td>';
					$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left">'.$splitproduct[$j][1].'</td>';
					$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left">'.$splitproduct[$j][2].'</td>';
					$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left">'.$splitproduct[$j][3].'</td>';
					$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left">'.$splitproduct[$j][4].'</td>';
					$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left">'.$splitproduct[$j][6].'</td>';
					$grid .= '</tr>';
				}
			$grid .= '</table>';
		}
		echo('1'.'^'.$grid.'^'.$result['invoiceno']);
			
	}
	break;
	case 'implemenationstatus':
	{
		$lastslno = $_POST['lastslno'];
		$query = "SELECT imp_implementation.branchapproval,imp_implementation.approvalremarks as branchremarks,imp_implementation.branchreject,imp_implementation.branchrejectremarks as branchrejectremarks,
imp_implementation.coordinatorreject, imp_implementation.coordinatorrejectremarks,
imp_implementation.coordinatorapproval, imp_implementation.coordinatorapprovalremarks, 
imp_implementation.implementationstatus, inv_mas_implementer.businessname, imp_implementation.advancecollected ,imp_implementation.advancesnotcollectedremarks from  imp_implementation 
left join inv_mas_implementer on inv_mas_implementer.slno = imp_implementation.assignimplemenation 
where imp_implementation.slno = '".$lastslno."';";
		$fetch = runmysqlqueryfetch($query);
		
		$query1 = "Select assigneddate from imp_implementationdays where imp_implementationdays.impref = '".$lastslno."';";
		$result = runmysqlquery($query1);
		$fetchcount = mysqli_num_rows($result);
		$tablegrid = '<table width="100%" border="0" cellspacing="0" cellpadding="5">';
		$tablegrid .= '<tr><td width="30%"><strong>Assigned To:</strong></td><td width="70%">'.$fetch['businessname'].'</td></tr>';
		$tablegrid .= '<tr><td><strong>No of Days:</strong></td><td>'.$fetchcount.'</td></tr></table>';
		echo('1^'.$fetch['branchapproval'].'^'.$fetch['coordinatorreject'].'^'.$fetch['coordinatorapproval'].'^'.$fetch['implementationstatus'].'^'.$fetch['branchremarks'].'^'.$fetch['coordinatorrejectremarks'].'^'.$fetch['coordinatorapprovalremarks'].'^'.$tablegrid.'^'.$fetch['advancecollected'].'^'.$fetch['advancesnotcollectedremarks'].'^'.$fetch['branchreject'].'^'.$fetch['branchrejectremarks']);
		
	}
	break;
		case 'customizationgrid':
	{
		$implastslno = $_POST['imprslno'];
		$startlimit = $_POST['startlimit'];
		$slno = $_POST['slno'];	
		$showtype = $_POST['showtype'];
		$resultcount = "SELECT count(*) as count from imp_customizationfiles where imp_customizationfiles.impref = '".$implastslno."';";
		$fetch10 = runmysqlqueryfetch($resultcount);
		$fetchresultcount = $fetch10['count'];;
		if($showtype == 'all')
		$limit = 100000;
		else
		$limit = 10;
		if($startlimit == '')
		{
			$startlimit = 0;
			$slno = 0;
		}
		else
		{
			$startlimit = $slno;
			$slno = $slno;
		}
		
		$query = "SELECT imp_customizationfiles.slno,imp_customizationfiles.remarks,imp_customizationfiles.attachfilepath from imp_customizationfiles  WHERE imp_customizationfiles.impref = '".$implastslno."' order by createddatetime DESC LIMIT ".$startlimit.",".$limit.";";
		if($startlimit == 0)
		{
			$grid = '<table width="100%" cellpadding="2" cellspacing="0" class="table-border-grid">';
			$grid .= '<tr class="tr-grid-header" align ="left"><td nowrap = "nowrap" class="td-border-grid" >Sl No</td><td nowrap = "nowrap" class="td-border-grid">Remarks</td><td nowrap = "nowrap" class="td-border-grid">Downloadlink</td></tr>';
		}
		$i_n = 0;
		$result = runmysqlquery($query);
		while($fetch = mysqli_fetch_array($result))
		{
			$i_n++;
			$slno++;
			$color;
			if($i_n%2 == 0)
				$color = "#edf4ff";
			else
				$color = "#f7faff";
			$grid .= '<tr class="gridrow" bgcolor='.$color.'  align ="left">';
			$grid .= "<td nowrap='nowrap' class='td-border-grid'>".$slno."</td>";
			$grid .= "<td nowrap='nowrap' class='td-border-grid'>".gridtrim($fetch['remarks'])."</td>";
			$grid .= "<td nowrap='nowrap' class='td-border-grid'><div align = 'center'><img src='../images/download-arrow.gif'  onclick = viewfilepath('".$fetch['attachfilepath']."','1') /></div></td>";
			$grid .= "</tr>";
		}
		$grid .= "</table>";
		$fetchcount = mysqli_num_rows($result);
		if($slno >= $fetchresultcount)
			$linkgrid .='<table width="100%" border="0" cellspacing="0" cellpadding="0" height ="20px"><tr><td bgcolor="#FFFFD2"><font color="#FF4F4F">No More Records</font><div></div></td></tr></table>';
		else
			$linkgrid .= '<table><tr><td class="resendtext"><div align ="left" style="padding-right:10px"><a onclick ="getmorecustomerregistration(\''.$startlimit.'\',\''.$slno.'\',\'more\'); " style="cursor:pointer">Show More Records >></a>&nbsp;&nbsp;&nbsp;<a onclick ="getmorecustomerregistration(\''.$startlimit.'\',\''.$slno.'\',\'all\');" class="resendtext1" style="cursor:pointer"><font color = "#000000">(Show All Records)</font></a></div></td></tr></table>';
		
		echo '1^'.$grid.'^'.$linkgrid.'^'.$fetchresultcount;
	}
	break;
	
	case 'filtercustomerlist':
	{
		$status = $_POST['impsearch'];
		$statuspiece = '';
		if($status == 'Awaiting Branch Head Approval')
		{
			$statuspiece = " AND imp_implementation.branchapproval = 'no' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'no' AND imp_implementation.implementationstatus = 'pending'";
		}
		else if($status == 'Awaiting Co-ordinator Approval')
		{
			$statuspiece = " AND imp_implementation.branchapproval = 'yes' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'no' AND imp_implementation.implementationstatus = 'pending'";
		}
		else if($status == 'Fowarded back to Branch Head')
		{
			$statuspiece = " AND imp_implementation.branchapproval = 'no' AND imp_implementation.coordinatorreject = 'yes' AND imp_implementation.coordinatorapproval = 'no' AND imp_implementation.implementationstatus = 'pending'";
		}
		else if($status == 'Implementation, Yet to be Assigned')
		{
			$statuspiece = " AND imp_implementation.branchapproval = 'yes' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'yes' AND imp_implementation.implementationstatus = 'pending'";
		}
		else if($status == 'Assigned For Implementation')
		{
			$statuspiece = " AND imp_implementation.branchapproval = 'yes' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'yes' AND imp_implementation.implementationstatus = 'assigned'";
		}
		else if($status == 'Implementation in progess')
		{
			$statuspiece = " AND imp_implementation.branchapproval = 'yes' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'yes' AND imp_implementation.implementationstatus = 'progess'";
		}
		else if($status == 'Implementation Completed')
		{
			$statuspiece = " AND imp_implementation.branchapproval = 'yes' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'yes' AND imp_implementation.implementationstatus = 'completed'";
		}
		$query1 = "select * from inv_mas_implementer where slno = '".$userid."';";
		$resultfetch = runmysqlqueryfetch($query1);
		$coordinator = $resultfetch['coordinator'];
		$region = $resultfetch['region'];
		if($coordinator == 'yes')
			$coordinatorpiece =" and imp_implementation.assigncustomization is not null";
		else
			$coordinatorpiece = "and imp_implementation.assigncustomization = '".$userid."'";
		if(($region == '1') || ($region == '3'))
		{	
			$query = "select inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join imp_implementation on inv_mas_customer.slno = imp_implementation.customerreference where imp_implementation.customerreference is not null ".$coordinatorpiece.$statuspiece." and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3') order by inv_mas_customer.businessname;";
		}
		else
		{
			$query = "select inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join imp_implementation on inv_mas_customer.slno = imp_implementation.customerreference where imp_implementation.customerreference is not null ".$coordinatorpiece.$statuspiece." and inv_mas_customer.region = '".$region."' order by inv_mas_customer.businessname;";
		}
	
		$result = runmysqlquery($query);
		$grid = '';
		$count = 1;
		while($fetch = mysqli_fetch_array($result))
		{
			if($count > 1)
				$grid .='^*^';
			$grid .= $fetch['businessname'].'^'.$fetch['slno'];
			$count++;
		}
		echo($grid);
	}
	break;
	case 'searchcustomerlist':
	{
		$databasefield = $_POST['databasefield'];
		$textfield = $_POST['textfield'];
		$state2 = $_POST['state2'];
		$district2 = $_POST['district2'];
		$region2 = $_POST['region'];
		$dealer2 = $_POST['dealer2'];
		$branch2 = $_POST['branch2'];
		$category2= $_POST['category2'];
		$type2= $_POST['type2'];
		$implementer= $_POST['implementer'];
		$statuslist = $_POST['statuslist'];
		$statuslistsplit = explode(',',$statuslist);
		$countsummarize = count($statuslistsplit);
		for($i = 0; $i<$countsummarize; $i++)
		{
			if($i < ($countsummarize-1))
					$appendor = 'or'.' ';
				else
					$appendor = '';
			switch($statuslistsplit[$i])
			{
								
				case 'status3' :
				{
					$statuspiece = " imp_implementation.branchapproval = 'yes' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'no' AND imp_implementation.implementationstatus = 'pending' ";
				}
				break;
				case 'status4' :
				{
					$statuspiece = " imp_implementation.branchapproval = 'no' AND imp_implementation.coordinatorreject = 'yes' AND imp_implementation.coordinatorapproval = 'no' AND imp_implementation.implementationstatus = 'pending' ";
				}
				break;
				case 'status5' :
				{
					$statuspiece = " imp_implementation.branchapproval = 'yes' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'yes' AND imp_implementation.implementationstatus = 'pending' ";
				}
				break;
				case 'status6' :
				{
					$statuspiece = " imp_implementation.branchapproval = 'yes' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'yes' AND imp_implementation.implementationstatus = 'assigned' ";
				}
				break;
				case 'status7' :
				{
					$statuspiece = " imp_implementation.branchapproval = 'yes'  AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'yes' AND imp_implementation.implementationstatus = 'progess' ";
				}
				break;
				case 'status8' :
				{
					$statuspiece = " imp_implementation.branchapproval = 'yes'  AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'yes' AND imp_implementation.implementationstatus = 'completed' ";
				}
				break;
				
			}
			$finalstatuslist .= ''.'('.$statuspiece.')'.'  '.$appendor.'';
		}
		if($finalstatuslist != '')
		{
			$finalliststatus = ' AND'.'('.$finalstatuslist.')';
		}
		else
		{
			$finalliststatus = "";
		}
		
		$regionpiece = ($region2 == "")?(""):(" AND inv_mas_customer.region = '".$region2."' ");
		$state_typepiece = ($state2 == "")?(""):(" AND inv_mas_district.statecode = '".$state2."' ");
		$district_typepiece = ($district2 == "")?(""):(" AND inv_mas_customer.district = '".$district2."' ");
		$dealer_typepiece = ($dealer2 == "")?(""):(" AND inv_mas_customer.currentdealer = '".$dealer2."' ");
		$branchpiece = ($branch2 == "")?(""):(" AND inv_mas_customer.branch = '".$branch2."' ");
		$imp_implementationpiece = ($implementer == "")?(""):(" AND imp_implementation.assignimplemenation = '".$implementer."' ");
		if($type2 == 'Not Selected')
		{
			$typepiece = ($type2 == "")?(""):(" AND inv_mas_customer.type = ''");
		}
		else
		{
			$typepiece = ($type2 == "")?(""):(" AND inv_mas_customer.type = '".$type2."' ");
		}
		if($category2 == 'Not Selected')
		{
			$categorypiece = ($category2 == "")?(""):(" AND inv_mas_customer.category = ''");
		}
		else
		{
			$categorypiece = ($category2 == "")?(""):(" AND inv_mas_customer.category = '".$category2."' ");
		}
		$queryres = "select * from inv_mas_implementer where slno = '".$userid."'";
		$resultfetch = runmysqlqueryfetch($queryres);
		$coordinator = $resultfetch['coordinator'];
		if($coordinator == 'yes')
			$coordinatorpiece ="and imp_implementation.assigncustomization is not null";
		else
			$coordinatorpiece = "and imp_implementation.assigncustomization = '".$userid."'";
			
		$region = $resultfetch['region'];
		switch($databasefield)

		{
			case 'slno':
			{
				$customeridlen = strlen($textfield);
				$lastcustomerid = cusidsplit($textfield);
				if(($region == '1') || ($region == '3'))
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
 where (inv_mas_customer.slno LIKE '%".$lastcustomerid."%' OR inv_mas_customer.customerid LIKE '%".$lastcustomerid."%') ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece."   and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3') order by inv_mas_customer.businessname;";
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
 where (inv_mas_customer.slno LIKE '%".$lastcustomerid."%' OR inv_mas_customer.customerid LIKE '%".$lastcustomerid."%') ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece."   and inv_mas_customer.region = ' ".$region."'  order by inv_mas_customer.businessname;";
				}
				$result = runmysqlquery($query);
			}
			break;
			
			case 'contactperson':
			{
				if(($region == '1') || ($region == '3'))
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
where inv_contactdetails.contactperson LIKE '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece."  and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3') ORDER BY inv_mas_customer.businessname";
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
where inv_contactdetails.contactperson LIKE '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece."  and inv_mas_customer.region = ' ".$region."' ORDER BY inv_mas_customer.businessname";
				}
				$result = runmysqlquery($query);
			}
			break;
			
			case 'place':
			{
				if(($region == '1') || ($region == '3'))
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
where inv_mas_customer.place LIKE '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece."  and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3') ORDER BY inv_mas_customer.businessname";
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
where inv_mas_customer.place LIKE '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece."  and inv_mas_customer.region = ' ".$region."' ORDER BY inv_mas_customer.businessname";
				}
				$result = runmysqlquery($query);
			}
			break;
			
			case 'phone':
			{
				if(($region == '1') || ($region == '3'))
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
where (inv_contactdetails.phone LIKE '%".$textfield."%'  OR inv_contactdetails.cell LIKE '%".$textfield."%') ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece."  and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3') ORDER BY inv_mas_customer.businessname";
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
where (inv_contactdetails.phone LIKE '%".$textfield."%'  OR inv_contactdetails.cell LIKE '%".$textfield."%') ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece."  and inv_mas_customer.region = ' ".$region."' ORDER BY inv_mas_customer.businessname";
				}
				$result = runmysqlquery($query);
			}
			break;
			
			case 'emailid':
			{
				if(($region == '1') || ($region == '3'))
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
where inv_contactdetails.emailid LIKE '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece." and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3')  ORDER BY inv_mas_customer.businessname";
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
where inv_contactdetails.emailid LIKE '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece." and inv_mas_customer.region = ' ".$region."'  ORDER BY inv_mas_customer.businessname";
				}
				$result = runmysqlquery($query);
			}
			break;
			
			default:
			{
				if(($region == '1') || ($region == '3'))
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
where inv_mas_customer.businessname LIKE  '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece." and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3') ORDER BY inv_mas_customer.businessname"; //echo($query);exit;
				}
				else
				{
						$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
where inv_mas_customer.businessname LIKE  '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece." and inv_mas_customer.region = ' ".$region."' ORDER BY inv_mas_customer.businessname"; //echo($query);exit;
				}
				$result = runmysqlquery($query);
			}
			break;
		}
		$searchcustomerlistarray = array();
		$count = 0;
		while($fetch = mysqli_fetch_array($result))
		{
			$searchcustomerlistarray[$count] = $fetch['businessname'].'^'.$fetch['slno'];
			$count++;
		}
		echo(json_encode($searchcustomerlistarray));
	}
	break;

}


?>