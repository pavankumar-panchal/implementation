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
		$customerarray = array();
		$queryres = "select * from inv_mas_implementer where slno = '".$userid."'";
		$resultfetch = runmysqlqueryfetch($queryres);
		$region = $resultfetch['region'];
		$branch = $resultfetch['branchid'];

		if(($region == '1') || ($region == '3'))
		{
			$customerlistpiece = " AND (inv_mas_customer.region = '1' or inv_mas_customer.region = '3')";
		}
		else
		{
			$customerlistpiece = " AND (inv_mas_customer.branch = '".$branch."')";
		}

		$query0 = "select max(imp_implementation.slno) as impslno,inv_mas_customer.businessname,imp_implementation.customerreference from imp_implementation left join inv_mas_customer on imp_implementation.customerreference = inv_mas_customer.slno where imp_implementation.customerreference is not null and imp_implementation.branchapproval = 'yes' and imp_implementation.coordinatorreject = 'no' and inv_mas_customer.slno <> '99999999999'".$customerlistpiece." group by imp_implementation.customerreference ORDER BY businessname;";
		$result0 = runmysqlquery($query0);
		$responsearray21 = array();
		$count = 0;
		while($fetch0 = mysqli_fetch_array($result0))
		{
			$query = "select inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join imp_implementation on inv_mas_customer.slno = imp_implementation.customerreference where inv_mas_customer.slno = '".$fetch0['customerreference']."' and imp_implementation.slno = '".$fetch0['impslno']."'  order by inv_mas_customer.businessname;";
			$result = runmysqlquery($query);
			while($fetch = mysqli_fetch_array($result))
			{
				$customerarray[$count] = $fetch['businessname'].'^'.$fetch['slno'];
				$count++;
			}
		}
		
		//echo($grid);
		echo(json_encode($customerarray));
	}
	break;
	
	case 'getcustomercount':
	{
		$responsearray3 = array();
		$queryres = "select * from inv_mas_implementer where slno = '".$userid."'";
		$resultfetch = runmysqlqueryfetch($queryres);
		$region = $resultfetch['region'];
		$branch = $resultfetch['branchid'];

		if(($region == '1') || ($region == '3'))
		{
			$customerlistpiece = " AND (inv_mas_customer.region = '1' or inv_mas_customer.region = '3')";
		}
		else
		{
			$customerlistpiece = " AND (inv_mas_customer.branch = '".$branch."')";
		}

		$query = "select max(imp_implementation.slno) as impslno,inv_mas_customer.businessname,imp_implementation.customerreference from imp_implementation left join inv_mas_customer on imp_implementation.customerreference = inv_mas_customer.slno where imp_implementation.customerreference is not null and imp_implementation.branchapproval = 'yes' and imp_implementation.coordinatorreject = 'no' and inv_mas_customer.slno <> '99999999999'".$customerlistpiece." group by imp_implementation.customerreference ORDER BY businessname;";
		$result = runmysqlquery($query);
		$count = mysqli_num_rows($result);
		$responsearray3['count'] = $count;
		echo(json_encode($responsearray3));
	}
	break;
	
	case 'gridtoform':
	{
		$responsearray1 = array();
		$query = "select slno,customerreference,invoicenumber,implementationtype,impremarks,advancecollected,advanceamount,advanceremarks,balancerecoveryremarks,podetails, numberofcompanies,numberofmonths,processingfrommonth,additionaltraining,freedeliverables,schemeapplicable,commissionapplicable,commissionname,commissionemail,commissionmobile,commissionvalue,masterdatabyrelyon,masternumberofemployees,salescommitments,attendanceapplicable,attendanceremarks,attendancefilepath,shipinvoiceapplicable,shipinvoiceremarks,shipmanualapplicable,shipmanualremarks,customizationapplicable,customizationremarks,customizationreffilepath,customizationbackupfilepath,customizationstatus,implementationstatus,webimplemenationapplicable,webimplemenationremarks,assignimplemenation,assignhandholdimplementation,assigncustomization,assignwebimplemenation,branchapproval,coordinatorapproval,coordinatorreject,committedstartdate,podetailspath from imp_implementation where customerreference = '".$lastslno."' and branchapproval = 'yes' order by slno desc limit 1";
		$fetch = runmysqlqueryfetch($query);

		if($fetch['implementationtype']!= "")
		{
			$impquery = "select * from imp_mas_implementationtype where slno = '".$fetch['implementationtype']."'";
			$impfetch = runmysqlqueryfetch($impquery);
			$implementationtype = $impfetch['imptype'];
		}
		
		
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
		if(mysqli_num_rows($result11) == 0)
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
				$griddisplay .= "<td nowrap='nowrap' class='td-border-grid'><div align = 'center'><img src='../images/download-arrow.gif'  onclick = viewfilepath('".$fetch1['attachfilepath']."') /></div></td>";
				$griddisplay .= "</tr>";
			}
			$griddisplay .= "</table>";
		}
		
		$responsearray1['errorcode'] = "1";
		$responsearray1['slno'] = $fetch['slno'];
		$responsearray1['customerreference'] = $fetch['customerreference'];
		$responsearray1['invoicenumber'] = $fetch['invoicenumber'];
		$responsearray1['implementationtype'] = $implementationtype;
		$responsearray1['impremarks'] = $fetch['impremarks'];
		$responsearray1['advancecollected'] = strtoupper($fetch['advancecollected']);
		$responsearray1['advanceamount'] = $fetch['advanceamount'];
		$responsearray1['advanceremarks'] = $fetch['advanceremarks'];
		$responsearray1['balancerecoveryremarks'] = $fetch['balancerecoveryremarks'];
		$responsearray1['griddisplay'] = $griddisplay;
		$responsearray1['podetails'] = $fetch['podetails'];
		$responsearray1['numberofcompanies'] = $fetch['numberofcompanies'];
		$responsearray1['numberofmonths'] = $fetch['numberofmonths'];
		$responsearray1['processingfrommonth'] = $fetch['processingfrommonth'];
		$responsearray1['additionaltraining'] = $fetch['additionaltraining'];
		$responsearray1['freedeliverables'] = $fetch['freedeliverables'];
		$responsearray1['schemeapplicable'] = $fetch['schemeapplicable'];
		$responsearray1['commissionapplicable'] = strtoupper($fetch['commissionapplicable']);
		$responsearray1['commissionname'] = $fetch['commissionname'];
		$responsearray1['commissionemail'] = $fetch['commissionemail'];
		$responsearray1['commissionmobile'] = $fetch['commissionmobile'];
		$responsearray1['commissionvalue'] = $fetch['commissionvalue'];
		$responsearray1['masterdatabyrelyon'] = strtoupper($fetch['masterdatabyrelyon']);
		$responsearray1['masternumberofemployees'] = $fetch['masternumberofemployees'];
		$responsearray1['salescommitments'] = $fetch['salescommitments'];
		$responsearray1['attendanceapplicable'] = strtoupper($fetch['attendanceapplicable']);
		$responsearray1['attendanceremarks'] = $fetch['attendanceremarks'];
		$responsearray1['attendancefilepath'] = $fetch['attendancefilepath'];
		$responsearray1['shipinvoiceapplicable'] = strtoupper($fetch['shipinvoiceapplicable']);
		$responsearray1['shipinvoiceremarks'] = $fetch['shipinvoiceremarks'];
		$responsearray1['shipmanualapplicable'] = strtoupper($fetch['shipmanualapplicable']);
		$responsearray1['shipmanualremarks'] = $fetch['shipmanualremarks'];
		$responsearray1['customizationapplicable'] = strtoupper($fetch['customizationapplicable']);
		$responsearray1['customizationremarks'] = $fetch['customizationremarks'];
		$responsearray1['customizationreffilepath'] = $fetch['customizationreffilepath'];
		$responsearray1['customizationbackupfilepath'] = $fetch['customizationbackupfilepath'];
		$responsearray1['customizationstatus'] = $fetch['customizationstatus'];
		$responsearray1['implementationstatus'] = $fetch['implementationstatus'];
		$responsearray1['grid'] = $grid;
		$responsearray1['webimplemenationapplicable'] = strtoupper($fetch['webimplemenationapplicable']);
		$responsearray1['webimplemenationremarks'] = $fetch['webimplemenationremarks'];
		$responsearray1['assignimplemenation'] = $fetch['assignimplemenation'];
		$responsearray1['assignhandholdimplementation'] = $fetch['assignhandholdimplementation'];
		$responsearray1['assigncustomization'] = $fetch['assigncustomization'];
		$responsearray1['assignwebimplemenation'] = $fetch['assignwebimplemenation'];
		$responsearray1['branchapproval'] = $fetch['branchapproval'];
		$responsearray1['coordinatorapproval'] = $fetch['coordinatorapproval'];
		$responsearray1['podetailspath'] = $fetch['podetailspath'];
		$responsearray1['committedstartdate'] = changedateformat($fetch['committedstartdate']);
		echo(json_encode($responsearray1));
		
		//echo('1^'.$fetch['slno'].'^'.$fetch['customerreference'].'^'.$fetch['invoicenumber'].'^'.strtoupper($fetch['advancecollected']).'^'.$fetch['advanceamount'].'^'.$fetch['advanceremarks'].'^'.$fetch['balancerecoveryremarks'].'^'.$griddisplay.'^'.$fetch['podetails'].'^'.$fetch['numberofcompanies'].'^'.$fetch['numberofmonths'].'^'.$fetch['processingfrommonth'].'^'.$fetch['additionaltraining'].'^'.$fetch['freedeliverables'].'^'.$fetch['schemeapplicable'].'^'.strtoupper($fetch['commissionapplicable']).'^'.$fetch['commissionname'].'^'.$fetch['commissionemail'].'^'.$fetch['commissionmobile'].'^'.$fetch['commissionvalue'].'^'.strtoupper($fetch['masterdatabyrelyon']).'^'.$fetch['masternumberofemployees'].'^'.$fetch['salescommitments'].'^'.strtoupper($fetch['attendanceapplicable']).'^'.$fetch['attendanceremarks'].'^'.$fetch['attendancefilepath'].'^'.strtoupper($fetch['shipinvoiceapplicable']).'^'.$fetch['shipinvoiceremarks'].'^'.strtoupper($fetch['shipmanualapplicable']).'^'.$fetch['shipmanualremarks'].'^'.strtoupper($fetch['customizationapplicable']).'^'.$fetch['customizationremarks'].'^'.$fetch['customizationreffilepath'].'^'.$fetch['customizationbackupfilepath'].'^'.$fetch['customizationstatus'].'^'.$fetch['implementationstatus'].'^'.$grid.'^'.strtoupper($fetch['webimplemenationapplicable']).'^'.$fetch['webimplemenationremarks'].'^'.$fetch['assignimplemenation'].'^'.$fetch['assigncustomization'].'^'.$fetch['assignwebimplemenation'].'^'.$fetch['branchapproval'].'^'.$fetch['coordinatorapproval'].'^'.changedateformat($fetch['committedstartdate']));
	}
	break;
	case 'customercontactdetailstoform':
	{
		$responsearray2 = array();
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
			
			$responsearray2['errorcode'] = "1";
			$responsearray2['slno'] = $fetch['slno'];
			$responsearray2['customerid'] = $customerid;
			$responsearray2['companyname'] = $fetch['companyname'];
			$responsearray2['contactperson'] = $resultfetch2['contactperson'];
			$responsearray2['address'] = $address;
			$responsearray2['phone'] = $phone;
			$responsearray2['cell'] = $cell;
			$responsearray2['emailidplit'] = $emailidplit;
			$responsearray2['region'] = $fetch['region'];
			$responsearray2['branch'] = $fetch['branch'];
			$responsearray2['businesstype'] = $fetch['businesstype'];
			$responsearray2['customertype'] = $fetch['customertype'];
			$responsearray2['dealername'] = $fetch['dealername'];
			echo(json_encode($responsearray2));
			//echo('1^'.$fetch['slno'].'^'.$customerid.'^'.$fetch['companyname'].'^'.$resultfetch2['contactperson'].'^'.$address.'^'.$phone.'^'.$cell.'^'.$emailidplit.'^'.$fetch['region'].'^'.$fetch['branch'].'^'.$fetch['businesstype'].'^'.$fetch['customertype'].'^'.$fetch['dealername'].'^'.$query2);
		}
		else
		{
			$responsearray2['errorcode'] = " ";
			echo(json_encode($responsearray2));//echo(''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.'');
		}
	}
	break;
	case 'assigntask':
	{
		$responsearray7 =  array();
		$implastslno = $_POST['implastslno'];
		$assignedto = $_POST['assignedto'];
		
		$imptype = $_POST['imptype'];
		if($imptype == 'implementation')
		{
			$imppiece = 'assignimplemenation';
			$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','153','".date('Y-m-d').' '.date('H:i:s')."')";
			$eventresult = runmysqlquery($eventquery);
		}
		else if($imptype == 'customization')
		{
			$imppiece = 'assigncustomization';
			$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','159','".date('Y-m-d').' '.date('H:i:s')."')";
			$eventresult = runmysqlquery($eventquery);
		}
		else
			$imppiece = 'assignwebimplemenation';
		$query = "update imp_implementation set ".$imppiece." = '".$assignedto."', assignimpldatetime = '".date('Y-m-d').' '.date('H:i:s')."', assignimplip = '".$_SERVER['REMOTE_ADDR']."' , assignimplby = '".$userid."' where slno = '".$implastslno."';";
		$result = runmysqlquery($query);

		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','153','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		$responsearray7["errorcode"] = "1";
		$responsearray7["errormsg"] = "Implementation Assigned successfully";
		echo(json_encode($responsearray7));
		//echo('1^Implementation Assigned successfully');
	}
	break;
	case 'assigndayssave':
	{
		$responsearray4 = array();
		$date = $_POST['date'];
		$remarks = $_POST['remarks'];
		$implastslno = $_POST['implastslno'];
		$implementer = $_POST['implementer'];
		$impreflastslno = $_POST['impreflastslno'];
		$halfdayflag = $_POST['halfdayflag'];
		$assignedto = $_POST['assignedto'];
		
		$query12 = "SELECT * from imp_implementationdays where impref = '".$implastslno."' and assigneddate!='' order by slno desc limit 1";
		$result12 = runmysqlquery($query12);
		$count = mysqli_num_rows($result12);
		

		$query13 = "SELECT * from imp_implementationdays where impref = '".$implastslno."' and slno ='".$impreflastslno."'";
		$fetch13 = runmysqlqueryfetch($query13);
		$assigneddate = $fetch13['assigneddate'];
		if(!empty($assigneddate) )
		{
			$query = "Update imp_implementationdays set remarks = '".$remarks."', halfdayflag = '".$halfdayflag."',assignimplemenation='".$assignedto."' where slno = '".$impreflastslno."';";
			$result = runmysqlquery($query);
			$query11 = "Update imp_implementation set implementationstatus = 'assigned',assignimplemenation='".$assignedto."'  where imp_implementation.slno = '".$implastslno."' ";
			$resultfetch = runmysqlquery($query11);
		}
		else
		{
			if($count > 0)
			{
				$fetch12 = runmysqlqueryfetch($query12);
				$date1 = new DateTime($fetch12['assigneddate']);
				$date2 = new DateTime($date);
				//if(greaterDate($fetch12['assigneddate'],$date))
				if($date2 < $date1)
				{
					$responsearray4['errorcode'] = "2";
					$responsearray4['errormsg'] = "Date Should be greater than the entered dates in the grid";
					echo(json_encode($responsearray4));
					//echo('2^Date Should be greater than the entered dates in the grid');
					exit;
				}
				else
				{
					$query = "Update imp_implementationdays set assigneddate = '".changedateformat($date)."', remarks = '".$remarks."', halfdayflag = '".$halfdayflag."',assignimplemenation='".$assignedto."' where slno = '".$impreflastslno."';";
					$result = runmysqlquery($query);
					$query11 = "Update imp_implementation set implementationstatus = 'assigned',assignimplemenation='".$assignedto."' where imp_implementation.slno = '".$implastslno."' ";
					$resultfetch = runmysqlquery($query11);
				}
			}
			else
			{
				$query = "Update imp_implementationdays set assigneddate = '".changedateformat($date)."', remarks = '".$remarks."', halfdayflag = '".$halfdayflag."',assignimplemenation='".$assignedto."' where slno = '".$impreflastslno."';";
				$result = runmysqlquery($query);
				$query11 = "Update imp_implementation set implementationstatus = 'assigned',assignimplemenation='".$assignedto."' where imp_implementation.slno = '".$implastslno."' ";
				$resultfetch = runmysqlquery($query11);
			}
			
		}

		$query = "update imp_implementation set assignimpldatetime = '".date('Y-m-d').' '.date('H:i:s')."', assignimplip = '".$_SERVER['REMOTE_ADDR']."' , assignimplby = '".$userid."' where slno = '".$implastslno."';";
		$result = runmysqlquery($query);

		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','155','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		$responsearray4['errorcode'] = "1";
		$responsearray4['errormsg'] = "Record saved successfully";
		echo(json_encode($responsearray4));
	//	echo('1^Record saved successfully');
	}
	break;

	//handhold
	case 'hhassigndayssave':
	{
		$responsearray4 = array();
		$date = $_POST['date'];
		$remarks = $_POST['remarks'];
		$implastslno = $_POST['implastslno'];
		$implementer = $_POST['implementer'];
		$impreflastslno = $_POST['impreflastslno'];
		$halfdayflag = $_POST['halfdayflag'];
		$assignedto = $_POST['assignedto'];
		$imphandhold = $_POST['imphandhold'];

		$query1 = "SELECT impstatus  FROM imp_handholdimplementationdays WHERE impref = '".$implastslno."' and (handholdtype!='' or handholdtype IS NOT NULL) order by slno desc limit 1;";
		$count1 = mysqli_num_rows(runmysqlquery($query1));
		if($count1 > 0)
			$result1 = runmysqlqueryfetch($query1);

		$query2 = "SELECT impstatus  FROM imp_handholdimplementationdays WHERE impref = '".$implastslno."' and (handholdtype ='' or handholdtype IS NULL) order by slno desc limit 1;";
		$count2 = mysqli_num_rows(runmysqlquery($query2));
		if($count2 > 0)
			$result2 = runmysqlqueryfetch($query2);

		$query3 = "SELECT count(*) as impcount FROM imp_handholdimplementationdays WHERE impref = '".$implastslno."' and impstatus='Completed';";
		$result3 = runmysqlqueryfetch($query3);

		
		$query = "SELECT IFNULL(max(handholdtype),0) as handholdtype FROM imp_handholdimplementationdays WHERE impref = '".$implastslno."'";
		$result = runmysqlqueryfetch($query);
		$nexthandhold = $result['handholdtype'] + 1;
		
		if($imphandhold > 1 && $count1 == 0)
		{
			$responsearray4['errorcode'] = "2";
			$responsearray4['errormsg'] = "Hand Hold type must be Hand Hold1.";
			echo(json_encode($responsearray4));
			exit;
		}

		if($result['handholdtype'] < $imphandhold && $result1['impstatus'] == 'Completed' && empty($result2['impstatus']) && $nexthandhold < $imphandhold)
		{
			$responsearray4['errorcode'] = "2";
			$responsearray4['errormsg'] = "Hand Hold type should be Hand Hold$nexthandhold.";
			echo(json_encode($responsearray4));
			exit;
		}

		// if($result['handholdtype'] > $imphandhold && $result1['impstatus'] == 'Completed' && empty($result2['impstatus']) && $nexthandhold < $imphandhold)
		// {
		// 	echo('4^'."Hand Hold type should be Hand Hold$nexthandhold.");
		// 	exit;
		// }
		if($result['handholdtype']!=0)
		{
			if(( $imphandhold < $result['handholdtype'])  && empty($result2['impstatus']))
			{
				$responsearray4['errorcode'] = "2";
				$responsearray4['errormsg'] = "Selected Hand Hold type is already completed.";
				echo(json_encode($responsearray4));
				exit;
			}

			if($result['handholdtype'] == $imphandhold && $result1['impstatus'] =='Completed' && empty($result2['impstatus']))
			{
				$responsearray4['errorcode'] = "2";
				$responsearray4['errormsg'] = "Previous Hand Hold is already completed.";
				echo(json_encode($responsearray4));
				exit;
			}


			if($result['handholdtype'] < $imphandhold && $result1['impstatus']!='Completed')
			{
				$responsearray4['errorcode'] = "2";
				$responsearray4['errormsg'] = "Hand Hold type cannot be different for ongoing process.";
				echo(json_encode($responsearray4));
				exit;
			}
		}

		
		$query12 = "SELECT * from imp_handholdimplementationdays where impref = '".$implastslno."' and assigneddate!='' order by slno desc limit 1";
		$result12 = runmysqlquery($query12);
		$count = mysqli_num_rows($result12);
		

		$query13 = "SELECT * from imp_handholdimplementationdays where impref = '".$implastslno."' and slno ='".$impreflastslno."'";
		$fetch13 = runmysqlqueryfetch($query13);
		$assigneddate = $fetch13['assigneddate'];
		if(!empty($assigneddate) )
		{
			$query = "Update imp_handholdimplementationdays set remarks = '".$remarks."', halfdayflag = '".$halfdayflag."',assignimplemenation='".$assignedto."',handholdtype='".$imphandhold."' where slno = '".$impreflastslno."';";
			$result = runmysqlquery($query);
			$query11 = "Update imp_implementation set handholdimplementationstatus = 'assigned',assignhandholdimplementation='".$assignedto."',handholdtype='".$imphandhold."',assignhandholdimpldatetime = '".date('Y-m-d').' '.date('H:i:s')."', assignhandholdimplip = '".$_SERVER['REMOTE_ADDR']."' , assignhandholdimplby = '".$userid."'  where imp_implementation.slno = '".$implastslno."' ";
			$resultfetch = runmysqlquery($query11);
		}
		else
		{
			if($count > 0)
			{
				$fetch12 = runmysqlqueryfetch($query12);
				$date1 = new DateTime($fetch12['assigneddate']);
				$date2 = new DateTime($date);
				//if(greaterDate($fetch12['assigneddate'],$date))
				if($date2 < $date1)
				{
					$responsearray4['errorcode'] = "2";
					$responsearray4['errormsg'] = "Date Should be greater than the entered dates in the grid";
					echo(json_encode($responsearray4));
					//echo('2^Date Should be greater than the entered dates in the grid');
					exit;
				}
				else
				{
					$query = "Update imp_handholdimplementationdays set assigneddate = '".changedateformat($date)."', remarks = '".$remarks."', halfdayflag = '".$halfdayflag."',assignimplemenation='".$assignedto."',handholdtype='".$imphandhold."' where slno = '".$impreflastslno."';";
					$result = runmysqlquery($query);
					$query11 = "Update imp_implementation set handholdimplementationstatus = 'assigned',assignhandholdimplementation='".$assignedto."',handholdtype='".$imphandhold."',assignhandholdimpldatetime = '".date('Y-m-d').' '.date('H:i:s')."', assignhandholdimplip = '".$_SERVER['REMOTE_ADDR']."' , assignhandholdimplby = '".$userid."' where imp_implementation.slno = '".$implastslno."' ";
					$resultfetch = runmysqlquery($query11);
				}
			}
			else
			{
				$query = "Update imp_handholdimplementationdays set assigneddate = '".changedateformat($date)."', remarks = '".$remarks."', halfdayflag = '".$halfdayflag."',assignimplemenation='".$assignedto."',handholdtype='".$imphandhold."' where slno = '".$impreflastslno."';";
				$result = runmysqlquery($query);
				$query11 = "Update imp_implementation set handholdimplementationstatus = 'assigned',assignhandholdimplementation='".$assignedto."',handholdtype='".$imphandhold."',assignhandholdimpldatetime = '".date('Y-m-d').' '.date('H:i:s')."', assignhandholdimplip = '".$_SERVER['REMOTE_ADDR']."' , assignhandholdimplby = '".$userid."' where imp_implementation.slno = '".$implastslno."' ";
				$resultfetch = runmysqlquery($query11);
			}
			
		}
		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','289','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		$responsearray4['errorcode'] = "1";
		$responsearray4['errormsg'] = "Record saved successfully";
		echo(json_encode($responsearray4));
		//	echo('1^Record saved successfully');
	}
	break;

	case 'assigndaysdelete':
	{
		$responsearray5 = array();
		$impreflastslno = $_POST['impreflastslno'];
		$implastslno = $_POST['implastslno'];
		$query = "Delete from imp_implementationdays where slno = '".$impreflastslno."';";
		$result = runmysqlquery($query);
		$query1 = "Select * from imp_implementationdays where impref = '".$implastslno."';";
		$result1 = runmysqlquery($query1);
		//$resultvalue = mysqli_num_rows($result1);
		$count = 0;
		while($resultvalue = mysqli_fetch_array($result1))
		{
			$count++;
			$query2 = "UPDATE imp_implementationdays set visitnumber = '".$count."'  where visitnumber = '".$resultvalue['visitnumber']."' and impref = '".$implastslno."';";
			$result2 = runmysqlquery($query2);
		}
		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','156','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		$responsearray5['errorcode'] = "1";
		$responsearray5['errormsg'] = "Record saved successfully";
		echo(json_encode($responsearray5));
		//echo('1^Record Deleted successfully');
	}
	break;

	case 'hhassigndaysdelete':
	{
		$responsearray5 = array();
		$impreflastslno = $_POST['impreflastslno'];
		$implastslno = $_POST['implastslno'];
		$query = "Delete from imp_handholdimplementationdays where slno = '".$impreflastslno."';";
		$result = runmysqlquery($query);
		$query1 = "Select * from imp_handholdimplementationdays where impref = '".$implastslno."';";
		$result1 = runmysqlquery($query1);
		//$resultvalue = mysqli_num_rows($result1);
		$count = 0;
		while($resultvalue = mysqli_fetch_array($result1))
		{
			$count++;
			$query2 = "UPDATE imp_handholdimplementationdays set visitnumber = '".$count."'  where visitnumber = '".$resultvalue['visitnumber']."' and impref = '".$implastslno."';";
			$result2 = runmysqlquery($query2);
		}
		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','290','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		$responsearray5['errorcode'] = "1";
		$responsearray5['errormsg'] = "Record saved successfully";
		echo(json_encode($responsearray5));
		//echo('1^Record Deleted successfully');
	}
	break;

	case 'generateassigndaysgrid':
	{
		$implastslno = $_POST['implastslno'];
		$startlimit = $_POST['startlimit'];
		$slno = $_POST['slno'];	
		$showtype = $_POST['showtype'];
		$resultcount = "SELECT count(*) as count from imp_implementationdays where impref = '".$implastslno."';";
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
		
		$query = "SELECT imp_implementationdays.slno,assigneddate,imp_implementationdays.remarks,halfdayflag,businessname,assignimplemenation from imp_implementationdays 
		left join inv_mas_implementer on imp_implementationdays.assignimplemenation = inv_mas_implementer.slno  WHERE impref = '".$implastslno."' order by slno;";
		if($startlimit == 0)
		{
			$grid = '<table width="100%" cellpadding="3" cellspacing="0" class="table-border-grid">';
			$grid .= '<tr class="tr-grid-header" align ="left">
			<td nowrap = "nowrap" class="td-border-grid" >Day</td>
			<td nowrap = "nowrap" class="td-border-grid">Date</td>
			<td nowrap = "nowrap" class="td-border-grid">Remarks</td>
			<td nowrap = "nowrap" class="td-border-grid">Type</td>
			<td nowrap = "nowrap" class="td-border-grid">Assign To</td>
			<td nowrap = "nowrap" class="td-border-grid">Email</td>
			</tr>';
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
			
			$grid .= '<tr class="gridrow" bgcolor='.$color.' onclick="impassigndaysgridtoform(\''.$fetch['slno'].'\',\''.$slno.'\'); " align ="left">';
			$grid .= "<td nowrap='nowrap' class='td-border-grid'>Day ".$slno."<input type='hidden' id='assigndays".$slno."' name='assigndays".$slno."' value=".$slno."></td>";
			if($fetch['assigneddate'] == '')
				$grid .= "<td nowrap='nowrap' class='td-border-grid'>Not Assigned</td>";
			else
				$grid .= "<td nowrap='nowrap' class='td-border-grid'>".changedateformat($fetch['assigneddate'])."</td>";
			$grid .= "<td nowrap='nowrap' class='td-border-grid'>".gridtrim($fetch['remarks'])."</td>";

			if($fetch['halfdayflag'] == 'no')
				$grid .= "<td nowrap='nowrap' class='td-border-grid'>Full Day</td>";
			elseif($fetch['halfdayflag'] == 'yes')
				$grid .= "<td nowrap='nowrap' class='td-border-grid'>Half Day</td>";
			else
				$grid .= "<td nowrap='nowrap' class='td-border-grid'>Not Assigned</td>";
			$grid .= "<td nowrap='nowrap' class='td-border-grid'>".gridtrim($fetch['businessname'])."</td>";
			$grid .= "<td nowrap='nowrap' class='td-border-grid'><div id= 'sendimpemail".$slno."' style ='display:block;'><a class='r-text' onclick='sendemailonupdate(\"assignedimplementer\",\"".$fetch['assignimplemenation']."\",\"".$slno."\")'>Send Email &#8250;&#8250; </a></div><div id ='impprocess".$slno."' style ='display:none;'></div><input type='hidden' value='".$fetch['slno']."' name='getslno".$slno."' id='getslno".$slno."'></td>";
			$grid .= "</tr>";
		}
		$fetchcount = mysqli_num_rows($result);
		if($fetchcount == '0')
			$grid .= "<tr><td colspan ='3' class='td-border-grid'><div align='center'><font color='#FF0000'><strong>No Records to Display</strong></font></div></td></tr>";
		$grid .= "</table>";


		$query = "SELECT imp_handholdimplementationdays.slno,assigneddate,imp_handholdimplementationdays.remarks,halfdayflag,businessname,imp_mas_handholdtype.handholdtype,assignimplemenation from imp_handholdimplementationdays 
		left join inv_mas_implementer on imp_handholdimplementationdays.assignimplemenation = inv_mas_implementer.slno
		left join imp_mas_handholdtype on imp_handholdimplementationdays.handholdtype = imp_mas_handholdtype.slno  WHERE impref = '".$implastslno."' order by slno;";
		if($startlimit == 0)
		{
			$hgrid = '<table width="100%" cellpadding="3" cellspacing="0" class="table-border-grid">';
			$hgrid .= '<tr class="tr-grid-header" align ="left">
			<td nowrap = "nowrap" class="td-border-grid" >Day</td>
			<td nowrap = "nowrap" class="td-border-grid">Date</td>
			<td nowrap = "nowrap" class="td-border-grid">Remarks</td>
			<td nowrap = "nowrap" class="td-border-grid">Type</td>
			<td nowrap = "nowrap" class="td-border-grid">Assign To</td>
			<td nowrap = "nowrap" class="td-border-grid">Hand Hold</td>
			<td nowrap = "nowrap" class="td-border-grid">Email</td>
			</tr>';
		}
		$i_n = 0;
		$slno = 0;
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
			
			$hgrid .= '<tr class="gridrow" bgcolor='.$color.' onclick="hhimpassigndaysgridtoform(\''.$fetch['slno'].'\',\''.$slno.'\'); " align ="left">';
			$hgrid .= "<td nowrap='nowrap' class='td-border-grid'>Day ".$slno."<input type='hidden' id='assigndays".$slno."' name='assigndays".$slno."' value=".$slno."></td>";
			if($fetch['assigneddate'] == '')
				$hgrid .= "<td nowrap='nowrap' class='td-border-grid'>Not Assigned</td>";
			else
				$hgrid .= "<td nowrap='nowrap' class='td-border-grid'>".changedateformat($fetch['assigneddate'])."</td>";
			$hgrid .= "<td nowrap='nowrap' class='td-border-grid'>".gridtrim($fetch['remarks'])."</td>";

			if($fetch['halfdayflag'] == 'no')
				$hgrid .= "<td nowrap='nowrap' class='td-border-grid'>Full Day</td>";
			elseif($fetch['halfdayflag'] == 'yes')
				$hgrid .= "<td nowrap='nowrap' class='td-border-grid'>Half Day</td>";
			else
				$hgrid .= "<td nowrap='nowrap' class='td-border-grid'>Not Assigned</td>";
			$hgrid .= "<td nowrap='nowrap' class='td-border-grid'>".gridtrim($fetch['businessname'])."</td>";
			$hgrid .= "<td nowrap='nowrap' class='td-border-grid'>".gridtrim($fetch['handholdtype'])."</td>";
			$hgrid .= "<td nowrap='nowrap' class='td-border-grid'><div id= 'sendhandholdimpemail".$slno."' style ='display:block;'><a class='r-text' onclick='sendhandholdemailonupdate(\"assignedhandholdimplementer\",\"".$fetch['assignimplemenation']."\",\"".$slno."\")'>Send Email &#8250;&#8250; </a></div><div id ='imphandholdprocess".$slno."' style ='display:none;'></div><input type='hidden' value='".$fetch['slno']."' name='gethandholdslno".$slno."' id='gethandholdslno".$slno."'></td>";
			$hgrid .= "</tr>";
		}

		$fetchcount1 = mysqli_num_rows($result);
		if($fetchcount1 == '0')
			$hgrid .= "<tr><td colspan ='3' class='td-border-grid'><div align='center'><font color='#FF0000'><strong>No Records to Display</strong></font></div></td></tr>";
		$hgrid .= "</table>";

		if($slno >= $fetchresultcount)
		$linkgrid  = '';
		//$linkgrid .='<table width="100%" border="0" cellspacing="0" cellpadding="0" height ="20px"><tr><td bgcolor="#FFFFD2"><font color="#FF4F4F">No More Records</font><div></div></td></tr></table>';
		else
		$linkgrid  = '';
		//$linkgrid .= '<table><tr><td class="resendtext"><div align ="left" style="padding-right:10px"><a onclick ="getmoredatagrid(\''.$startlimit.'\',\''.$slno.'\',\'more\'); " style="cursor:pointer">Show More Records >></a>&nbsp;&nbsp;&nbsp;<a onclick ="getmoredatagrid(\''.$startlimit.'\',\''.$slno.'\',\'all\');" class="resendtext1" style="cursor:pointer"><font color = "#000000">(Show All Records)</font></a></div></td></tr></table>';
		
		echo '1^'.$grid.'^'.$linkgrid.'^'.$fetchresultcount.'^'.$fetchcount.'^'.$fetchcount1.'^'.$hgrid;
	}
	break;
	case 'impassigndaysgridtoform':
	{
		$responsearray6 = array();
		$impreflastslno = $_POST['impreflastslno'];
		$assigndays = $_POST['assigndays'];
		
		$query = "select * from imp_implementationdays where slno = '".$impreflastslno."';";
		$fetch = runmysqlqueryfetch($query);
		$query1 = "select assignimplemenation from imp_implementation where slno = '".$fetch['impref']."';";
		$fetch1 = runmysqlqueryfetch($query1);
		if($fetch['assigneddate'] != '')
			$assigndate = changedateformat($fetch['assigneddate']);
		else
			$assigndate = '';
		if($fetch['iccattachment'] == 'yes')
		{
			$responsearray6['errorcode'] = "2";
			$responsearray6['errormsg'] = "ICC Attached";
			echo(json_encode($responsearray6));
			exit;
			//echo('2^'.'ICC Attached');
		}
		else
		$responsearray6['errorcode'] = "1";
		$responsearray6['slno'] = $fetch['slno'];
		$responsearray6['remarks'] = $fetch['remarks'];
		$responsearray6['assignimplemenation'] = $fetch['assignimplemenation'];
		$responsearray6['assigndate'] = $assigndate;
		$responsearray6['disableassigndate'] = $fetch['assigneddate'];
		//$responsearray6['assignimplemenation'] = $fetch1['assignimplemenation'];
		$responsearray6['visitedstartflag'] = $fetch['visitedstartflag'];
		$responsearray6['visitnumber'] = 'Day'.' '.$assigndays;
		$responsearray6['halfdayflag'] = $fetch['halfdayflag'];
		echo(json_encode($responsearray6));
		//echo('1^'.$fetch['slno'].'^'.$fetch['remarks'].'^'.$assigndate.'^'.$fetch1['assignimplemenation'].'^'.$fetch['visitedstartflag'].'^'.'Visit'.$fetch['visitnumber']);
	}
	break;

	case 'hhimpassigndaysgridtoform':
	{
		$responsearray6 = array();
		$impreflastslno = $_POST['impreflastslno'];
		$assigndays = $_POST['assigndays'];
		
		$query = "select * from imp_handholdimplementationdays where slno = '".$impreflastslno."';";
		$fetch = runmysqlqueryfetch($query);
		$query1 = "select assignimplemenation from imp_implementation where slno = '".$fetch['impref']."';";
		$fetch1 = runmysqlqueryfetch($query1);
		if($fetch['assigneddate'] != '')
			$assigndate = changedateformat($fetch['assigneddate']);
		else
			$assigndate = '';
		if($fetch['iccattachment'] == 'yes')
		{
			$responsearray6['errorcode'] = "2";
			$responsearray6['errormsg'] = "ICC Attached";
			echo(json_encode($responsearray6));
			exit;
			//echo('2^'.'ICC Attached');
		}
		else
		$responsearray6['errorcode'] = "1";
		$responsearray6['slno'] = $fetch['slno'];
		$responsearray6['remarks'] = $fetch['remarks'];
		$responsearray6['assignimplemenation'] = $fetch['assignimplemenation'];
		$responsearray6['assigndate'] = $assigndate;
		$responsearray6['disableassigndate'] = $fetch['assigneddate'];
		//$responsearray6['assignimplemenation'] = $fetch1['assignimplemenation'];
		$responsearray6['visitedstartflag'] = $fetch['visitedstartflag'];
		$responsearray6['visitnumber'] = 'Day'.' '.$assigndays;
		$responsearray6['halfdayflag'] = $fetch['halfdayflag'];
		$responsearray6['handholdtype'] = $fetch['handholdtype'];
		echo(json_encode($responsearray6));
		//echo('1^'.$fetch['slno'].'^'.$fetch['remarks'].'^'.$assigndate.'^'.$fetch1['assignimplemenation'].'^'.$fetch['visitedstartflag'].'^'.'Visit'.$fetch['visitnumber']);
	}
	break;
	case 'assignactivitysave':
	{
		$responsearray8 = array();
		$remarks = $_POST['remarks'];
		$implastslno = $_POST['implastslno'];
		$activity = $_POST['activity'];
		$impactivitylastslno = $_POST['impactivitylastslno'];
		$query1 = "Select count(*) as count from imp_implementationactivity where activity = '".$activity."' and impref = '".$implastslno."';";
		$resultfecth = runmysqlqueryfetch($query1);
		if($resultfecth['count'] == 0)
		{
			if($impactivitylastslno == '')
			{
				$query = "Insert into imp_implementationactivity(activity, remarks,createddatetime,createdby,createdip,lastupdateddatetime,lastupdatedip,lastupdatedby,impref)values('".$activity."','".addslashes($remarks)."','".date('Y-m-d').' '.date('H:i:s')."','".$userid."','".$_SERVER['REMOTE_ADDR']."','".date('Y-m-d').' '.date('H:i:s')."','".$_SERVER['REMOTE_ADDR']."','".$userid."','".$implastslno."')";
				$result = runmysqlquery($query);
			}
			else
			{
				$query = "Update imp_implementationactivity set activity = '".$activity."', remarks = '".$remarks."' where slno = '".$impactivitylastslno."';";
				$result = runmysqlquery($query);
			}
			$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','157','".date('Y-m-d').' '.date('H:i:s')."')";
			$eventresult = runmysqlquery($eventquery);
			$responsearray8["errorcode"] = "1";
			$responsearray8["errormsg"] = "Record saved successfully";
			echo(json_encode($responsearray8));
			
			//echo('1^Record saved successfully');
		}
		else
		{
			$responsearray8["errorcode"] = "2";
			$responsearray8["errormsg"] = "Cannot assign Activity";
			echo(json_encode($responsearray8));
			//echo('2^Cannot assign Activity');
		}
	}
	break;

	case 'assignactivitydelete':
	{
		$responsearray9 = array();
		$impactivitylastslno = $_POST['impactivitylastslno'];
		$query = "Delete from imp_implementationactivity where slno = '".$impactivitylastslno."';";
		$result = runmysqlquery($query);
		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','158','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		$responsearray9["errorcode"] = "1";
		$responsearray9["errormsg"] = "Record Deleted successfully";
		echo(json_encode($responsearray9));
		//echo('1^Record Deleted successfully');
	}
	break;

	case 'hhassignactivitydelete':
	{
		$responsearray9 = array();
		$impactivitylastslno = $_POST['impactivitylastslno'];
		$query = "Delete from imp_handholdimplementationactivity where slno = '".$impactivitylastslno."';";
		$result = runmysqlquery($query);
		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','293','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		$responsearray9["errorcode"] = "1";
		$responsearray9["errormsg"] = "Record Deleted successfully";
		echo(json_encode($responsearray9));
		//echo('1^Record Deleted successfully');
	}
	break;

	case 'hhassignactivitysave':
	{
		$responsearray8 = array();
		$remarks = $_POST['remarks'];
		$implastslno = $_POST['implastslno'];
		$activity = $_POST['activity'];
		$impactivitylastslno = $_POST['impactivitylastslno'];
		$query1 = "Select count(*) as count from imp_handholdimplementationactivity where activity = '".$activity."' and impref = '".$implastslno."';";
		$resultfecth = runmysqlqueryfetch($query1);
		if($resultfecth['count'] == 0)
		{
			if($impactivitylastslno == '')
			{
				$query = "Insert into imp_handholdimplementationactivity(activity, remarks,createddatetime,createdby,createdip,lastupdateddatetime,lastupdatedip,lastupdatedby,impref)values('".$activity."','".addslashes($remarks)."','".date('Y-m-d').' '.date('H:i:s')."','".$userid."','".$_SERVER['REMOTE_ADDR']."','".date('Y-m-d').' '.date('H:i:s')."','".$_SERVER['REMOTE_ADDR']."','".$userid."','".$implastslno."')";
				$result = runmysqlquery($query);
			}
			else
			{
				$query = "Update imp_handholdimplementationactivity set activity = '".$activity."', remarks = '".$remarks."' where slno = '".$impactivitylastslno."';";
				$result = runmysqlquery($query);
			}
			$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','291','".date('Y-m-d').' '.date('H:i:s')."')";
			$eventresult = runmysqlquery($eventquery);
			$responsearray8["errorcode"] = "1";
			$responsearray8["errormsg"] = "Record saved successfully";
			echo(json_encode($responsearray8));
			
			//echo('1^Record saved successfully');
		}
		else
		{
			$responsearray8["errorcode"] = "2";
			$responsearray8["errormsg"] = "Cannot assign Activity";
			echo(json_encode($responsearray8));
			//echo('2^Cannot assign Activity');
		}
	}
	break;

	case 'generateactivitygrid':
	{
		$implastslno = $_POST['implastslno'];
		$startlimit = $_POST['startlimit'];
		$slno = $_POST['slno'];	
		$showtype = $_POST['showtype'];
		$resultcount = "SELECT count(*) as count from imp_implementationactivity where impref = '".$implastslno."';";
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
		
		$query = "SELECT imp_implementationactivity.slno,imp_mas_activity.activityname,imp_implementationactivity.activity ,imp_implementationactivity.remarks from imp_implementationactivity left join imp_mas_activity on imp_mas_activity.slno = imp_implementationactivity.activity WHERE impref = '".$implastslno."' order by slno LIMIT ".$startlimit.",".$limit.";";
		if($startlimit == 0)
		{
			$grid = '<table width="100%" cellpadding="3" cellspacing="0" class="table-border-grid">';
			$grid .= '<tr class="tr-grid-header" align ="left"><td nowrap = "nowrap" class="td-border-grid" >Sl No</td><td nowrap = "nowrap" class="td-border-grid">Activity</td><td nowrap = "nowrap" class="td-border-grid">Remarks</td></tr>';
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
			if($fetch['activity'] == 1 || $fetch['activity'] == 2 || $fetch['activity'] == 3 || $fetch['activity'] == 4)
				$activityname = $fetch['activityname'];
			else
				$activityname = $fetch['activity'];

			$grid .= '<tr class="gridrow" bgcolor='.$color.' onclick="impactivitygridtoform(\''.$fetch['slno'].'\'); " align ="left">';
			$grid .= "<td nowrap='nowrap' class='td-border-grid'>".$slno."</td>";
			$grid .= "<td nowrap='nowrap' class='td-border-grid'>".$activityname."</td>";
			$grid .= "<td nowrap='nowrap' class='td-border-grid'>".gridtrim($fetch['remarks'])."</td>";
			$grid .= "</tr>";
		}
		$fetchcount = mysqli_num_rows($result);
		if($fetchcount == '0')
			$grid .= "<tr><td colspan ='3' class='td-border-grid'><div align='center'><font color='#FF0000'><strong>No Records to Display</strong></font></div></td></tr>";
		$grid .= "</table>";
		//if($slno >= $fetchresultcount)
		$linkgrid  = '';
		//$linkgrid .='<table width="100%" border="0" cellspacing="0" cellpadding="0" height ="20px"><tr><td bgcolor="#FFFFD2"><font color="#FF4F4F">No More Records</font><div></div></td></tr></table>';
		// else
		// 	$linkgrid  = '';
		//$linkgrid .= '<table><tr><td class="resendtext"><div align ="left" style="padding-right:10px"><a onclick ="getmoredatagrid(\''.$startlimit.'\',\''.$slno.'\',\'more\'); " style="cursor:pointer">Show More Records >></a>&nbsp;&nbsp;&nbsp;<a onclick ="getmoredatagrid(\''.$startlimit.'\',\''.$slno.'\',\'all\');" class="resendtext1" style="cursor:pointer"><font color = "#000000">(Show All Records)</font></a></div></td></tr></table>';
		
		echo '1^'.$grid.'^'.$linkgrid.'^'.$fetchresultcount;
	}
	break;

	case 'generatehandholdactivitygrid':
	{
		$implastslno = $_POST['implastslno'];
		$resultcount = "SELECT count(*) as count from imp_handholdimplementationactivity where impref = '".$implastslno."';";
		$fetch10 = runmysqlqueryfetch($resultcount);
		$fetchresultcount = $fetch10['count'];
		
		$query = "SELECT slno,activity,remarks from imp_handholdimplementationactivity WHERE impref = '".$implastslno."';";
		$grid = '<table width="100%" cellpadding="3" cellspacing="0" class="table-border-grid">';
		$grid .= '<tr class="tr-grid-header" align ="left"><td nowrap = "nowrap" class="td-border-grid" >Sl No</td><td nowrap = "nowrap" class="td-border-grid">Activity</td><td nowrap = "nowrap" class="td-border-grid">Remarks</td></tr>';
		$i_n = 0;
		$slno = 0;
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
			if($fetch['activity'] == 1 || $fetch['activity'] == 2 || $fetch['activity'] == 3 || $fetch['activity'] == 4)
				$activityname = $fetch['activityname'];
			else
				$activityname = $fetch['activity'];

			$grid .= '<tr class="gridrow" bgcolor='.$color.' onclick="hhimpactivitygridtoform(\''.$fetch['slno'].'\'); " align ="left">';
			$grid .= "<td nowrap='nowrap' class='td-border-grid'>".$slno."</td>";
			$grid .= "<td nowrap='nowrap' class='td-border-grid'>".$activityname."</td>";
			$grid .= "<td nowrap='nowrap' class='td-border-grid'>".gridtrim($fetch['remarks'])."</td>";
			$grid .= "</tr>";
		}
		$fetchcount = mysqli_num_rows($result);
		if($fetchcount == '0')
			$grid .= "<tr><td colspan ='3' class='td-border-grid'><div align='center'><font color='#FF0000'><strong>No Records to Display</strong></font></div></td></tr>";
		$grid .= "</table>";
		
		echo '1^'.$grid.'^'.$fetchresultcount;
	}
	break;

	case 'impactivitygridtoform':
	{
		$responsearray10 = array();
		$impactivitylastslno = $_POST['impactivitylastslno'];
		$query = "select * from imp_implementationactivity where slno = '".$impactivitylastslno."';";
		$fetch = runmysqlqueryfetch($query);
		$responsearray10['errorcode'] = "1";
		$responsearray10['activity'] = $fetch['activity'];
		$responsearray10['remarks'] = $fetch['remarks'];
		echo(json_encode($responsearray10));
		//echo('1^'.$fetch['activity'].'^'.$fetch['remarks']);
	}
	break;

	case 'hhimpactivitygridtoform':
	{
		$responsearray10 = array();
		$impactivitylastslno = $_POST['impactivitylastslno'];
		$query = "select * from imp_handholdimplementationactivity where slno = '".$impactivitylastslno."';";
		$fetch = runmysqlqueryfetch($query);
		$responsearray10['errorcode'] = "1";
		$responsearray10['activity'] = $fetch['activity'];
		$responsearray10['remarks'] = $fetch['remarks'];
		echo(json_encode($responsearray10));
		//echo('1^'.$fetch['activity'].'^'.$fetch['remarks']);
	}
	break;

	case 'customizationsave':
	{
		$responsearray11 = array();
		$date = changedateformat($_POST['date']);
		$remarks = $_POST['remarks'];
		$implastslno = $_POST['implastslno'];
		$customizationlastslno = $_POST['customizationlastslno'];
		if($customizationlastslno == '')
		{
			$query = "Insert into imp_customizationdays(assigneddate, remarks,createddatetime,createdby,createdip,lastupdateddatetime,lastupdatedip,lastupdatedby,impref)values('".$date."','".addslashes($remarks)."','".date('Y-m-d').' '.date('H:i:s')."','".$userid."','".$_SERVER['REMOTE_ADDR']."','".date('Y-m-d').' '.date('H:i:s')."','".$_SERVER['REMOTE_ADDR']."','".$userid."','".$implastslno."')";
			$result = runmysqlquery($query);
			$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','160','".date('Y-m-d').' '.date('H:i:s')."')";
			$eventresult = runmysqlquery($eventquery);
		}
		else
		{
			$query = "Update imp_customizationdays set assigneddate = '".$date."', remarks = '".$remarks."' where slno = '".$customizationlastslno."';";
			$result = runmysqlquery($query);
			$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','161','".date('Y-m-d').' '.date('H:i:s')."')";
			$eventresult = runmysqlquery($eventquery);
		}
		$responsearray11['errorcode'] = "1";
		$responsearray11['errormsg'] = "Record saved successfully";
		echo(json_encode($responsearray11));
		//echo('1^Record saved successfully');
	}
	break;
	case 'customizationdelete':
	{
		$responsearray12 = array();
		$customizationlastslno = $_POST['customizationlastslno'];
		$query = "Delete from imp_customizationdays where slno = '".$customizationlastslno."';";
		$result = runmysqlquery($query);
		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','162','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		$responsearray12['errorcode'] = "1";
		$responsearray12['errrormsg'] = "Record Deleted successfully";
		echo(json_encode($responsearray12));
		//echo('1^Record Deleted successfully');
	}
	break;
	
	case 'customizationgridtoform':
	{
		$responsearray13 = array();
		$customizationlastslno = $_POST['customizationlastslno'];
		$query = "select * from imp_customizationdays where slno = '".$customizationlastslno."';";
		$fetch = runmysqlqueryfetch($query);
		$responsearray13['errorcode'] = "1";
		$responsearray13['slno'] = $fetch['slno'];
		$responsearray13['remarks'] = $fetch['remarks'];
		$responsearray13['assigneddate'] = changedateformat($fetch['assigneddate']);
		echo(json_encode($responsearray13));
		//echo('1^'.$fetch['slno'].'^'.$fetch['remarks'].'^'.changedateformat($fetch['assigneddate']));
	}
	break;
	case 'invoicedetailsgrid':
	{
		$grid = "";
		$responsearray14 = array();
		$rslno = $_POST['rslno'];
		if($rslno!= "")
		{
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
				,inv_invoicenumbers.invoiceno,inv_invoicenumbers.netamount,servicetype
				from inv_invoicenumbers left join inv_dealercard on inv_invoicenumbers.slno = inv_dealercard.invoiceid
				where  inv_invoicenumbers.invoiceno = '".$rslno."'";
				$result = runmysqlqueryfetch($query);
				$productsplit = explode('*',$result['description']);
				$grid = '<table width="100%" border="0" cellspacing="0" cellpadding="3" class="table-border-grid">';
				$grid .='<tr class="tr-grid-header"><td nowrap = "nowrap" class="td-border-grid" align="left">Slno</td><td nowrap = "nowrap" class="td-border-grid" align="left">Product Name</td><td nowrap = "nowrap" class="td-border-grid" align="left">Usage Type</td><td nowrap = "nowrap" class="td-border-grid" align="left">Purchase Type</td><td nowrap = "nowrap" class="td-border-grid" align="left">Pin Number</td><td nowrap = "nowrap" class="td-border-grid" align="left">Price</td><td nowrap = "nowrap" class="td-border-grid" align="left">&nbsp;</td></tr>';
				for($i=0;$i<count($productsplit);$i++)
				{
					$splitproduct[] = explode('$',$productsplit[$i]);
				}
				$slno = 0;
				if(!empty($result['description']))
				{
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
						$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left"><a onclick="viewinvoice(\''.$result['slno'].'\');" class="resendtext" style = "cursor:pointer"> View >></a> </td>';
						$grid .= '</tr>';
					}
				}

				if(!empty($result['servicetype']))
				{
					$servicetypesplit = explode('#',$result['servicetype']);
					for($k=0;$k<count($servicetypesplit);$k++)
					{
						$slno++;
						$i_n++;
						if($i_n%2 == 0)
						$color = "#edf4ff";
						else
						$color = "#f7faff";
						$grid .= '<tr  bgcolor='.$color.' align="left">';
						$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left">'.$slno.'</td>';
						$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left">'.$servicetypesplit[$k].'</td>';
						$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left"></td>';
						$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left"></td>';
						$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left"></td>';
						$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left">'.$result['netamount'].'</td>';
						$grid .= '<td nowrap = "nowrap" class="td-border-grid" align="left"><a onclick="viewinvoice(\''.$result['slno'].'\');" class="resendtext" style = "cursor:pointer"> View >></a> </td>';
						$grid .= '</tr>';
					}
				}
				$grid .= '</table>';
				
			}
		}
		$responsearray14['errorcode'] = "1";
		$responsearray14['grid'] = $grid;
		$responsearray14['invoiceno'] = $result['invoiceno'];
		echo(json_encode($responsearray14));
		//echo('1'.'^'.$grid.'^'.$result['invoiceno']);
			
	}
	break;
	case 'updateapprove':
	{
		$responsearray15 = array();
		$lastslno = $_POST['lastslno'];
		$implastslno = $_POST['implastslno'];
		$approveremarks = $_POST['appremarks'];
		$query = "update imp_implementation set coordinatorapproval = 'yes',coordinatorreject = 'no',coordinatorapprovalremarks = '".$approveremarks."', coordinatorappdatetime = '".date('Y-m-d').' '.date('H:i:s')."', coordinatorappip = '".$_SERVER['REMOTE_ADDR']."' , coordinatorappby = '".$userid."'  where imp_implementation.customerreference = '".$lastslno."' and imp_implementation.slno = '".$implastslno."' ";
		$result = runmysqlquery($query);
		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','151','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		$result11 = sendcoordinatorappmail($implastslno,$userid);
		$responsearray15['errorcode'] = "1";
		$responsearray15['errormsg'] = "Record Approved";
		$responsearray15['result'] = $result11;
		echo(json_encode($responsearray15));
		//echo('1^'.'Record Approved'.'^'.$result11);
		
	}
	break;
	case 'updatereject':
	{
		$responsearray16 = array();
		$lastslno = $_POST['lastslno'];
		$implastslno = $_POST['implastslno'];
		$rejectremarks = $_POST['rejremarks'];
		$query = "update imp_implementation set branchapproval = 'no',coordinatorapproval = 'no',coordinatorreject = 'yes',coordinatorrejectremarks = '".$rejectremarks."', coordinatorrejectdatetime = '".date('Y-m-d').' '.date('H:i:s')."', coordinatorrejectip = '".$_SERVER['REMOTE_ADDR']."' , coordinatorrejectby = '".$userid."' where imp_implementation.customerreference = '".$lastslno."' and imp_implementation.slno = '".$implastslno."'";
		$result = runmysqlquery($query);
		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','152','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		//$result11 = sendrejectmail($implastslno,$userid);
		$responsearray16['errorcode'] = "2";
		$responsearray16['errormsg'] = "Record Rejected";
		echo(json_encode($responsearray16));
		//echo('2^'.'Record Rejected');
      
	}
	break;
	case 'approvediv':
	{
		$responsearray17 = array();
		$lastslno = $_POST['lastslno'];
		$query = "SELECT count(*) as count from imp_implementation where imp_implementation.customerreference = '".$lastslno."' and imp_implementation.branchapproval = 'yes' and imp_implementation.coordinatorapproval = 'yes'";
		$result = runmysqlqueryfetch($query);
		if($result['count'] > 0)
		{
			$responsearray17['errorcode'] = "1";
			$responsearray17['errormsg'] = "Record has approved";
			echo(json_encode($responsearray17));
			//echo('1^'.'Record has approved');
		}
		else
		{
			$responsearray17['errorcode'] = "2";
			$responsearray17['errormsg'] = "Record has not approved";
			echo(json_encode($responsearray17));
			//echo('2^'.'Record has not approved');
		}
	}
	break;

	case 'impfollowups':
	{
		$responsearray = array();
		$implastslno = $_POST['implastslno'];
		$remarks = $_POST['remarks'];
		$DPC_nxtfollowdate = changedateformat($_POST['DPC_nxtfollowdate']);
		$DPC_followdate = changedateformat($_POST['DPC_followdate']);
		$lastslno = $_POST['lastslno'];
		$query = "insert into imp_followup (remarks,entereddate,enteredby,followupdate,nxtfollowupdate,impref) values ('".$remarks."','".date('Y-m-d').' '.date('H:i:s')."','".$userid."','".$DPC_followdate."','".$DPC_nxtfollowdate."','".$implastslno."');";
		$result = runmysqlquery($query);
		$responsearray['errorcode'] = "1";
		$responsearray['errormsg'] = "Record saved successfully";
		echo(json_encode($responsearray));
	}
	break;

	case 'getfollowupsdetails':
	{
		$responsearray = array();
		$implastslno = $_POST['implastslno'];
		$query = "select * from imp_followup where impref = '".$implastslno."'";
		$result = runmysqlquery($query);
		$count = mysqli_num_rows($result);
		if($count > 0)
		{
			$i_n1 = 0;$slno1 = 0;
			$grid = '<table width="100%" cellpadding="3" cellspacing="0" class="table-border-grid">';
			$grid .= '<tr class="tr-grid-header" align ="left">';
			$grid .= '<td nowrap = "nowrap" class="td-border-grid" >Sl No</td>';
			$grid .= '<td nowrap = "nowrap" class="td-border-grid" >Followup Date</td>';
			$grid .= '<td nowrap = "nowrap" class="td-border-grid" >Remarks</td>';
			$grid .= '<td nowrap = "nowrap" class="td-border-grid" >Next Followup Date</td></tr>';
			while($fetch = mysqli_fetch_array($result))
			{
				$i_n1++;$slno++;
				$color;
				if($i_n1%2 == 0)
					$color = "#edf4ff";
				else
					$color = "#f7faff";
				$grid .= '<tr class="gridrow1" bgcolor='.$color.'>';
				$grid .= "<td nowrap='nowrap' class='td-border-grid' align='left'>".$slno."</td> ";
				$grid .= "<td nowrap='nowrap' class='td-border-grid' align='left'>".changedateformat($fetch['followupdate'])."</td>";
				$grid .= "<td nowrap='nowrap' class='td-border-grid' align='left'>".$fetch['remarks']."</td>";
				$grid .= "<td nowrap='nowrap' class='td-border-grid' align='left'>".changedateformat($fetch['nxtfollowupdate'])."</td>";
				$grid .= "</tr>";
				
			}
			$grid .= '</table>';
		}
		$responsearray['errorcode'] = "1";
		$responsearray['grid'] = $grid;
		echo(json_encode($responsearray));

	}
	break;

	case 'daysassign':
	{
		$responsearray18 = array();
		$implastslno = $_POST['implastslno'];
		$assign_days = $_POST['assign_days'];
		$impreflastslno = $_POST['impreflastslno'];
		/*if(strpos($assign_days,".") != false)
			$flag = 'yes';
		else
			$flag = 'no';*/
		for($i=0;$i<round($assign_days);$i++)
		{
			$query = runmysqlqueryfetch("SELECT (MAX(slno) + 1) AS slno FROM imp_implementationdays");
			$slno = $query['slno'];
			
			$query = "Insert into imp_implementationdays(slno,createddatetime,createdby,createdip,lastupdateddatetime,lastupdatedip,lastupdatedby,impref,visitnumber)values('".$slno."','".date('Y-m-d').' '.date('H:i:s')."','".$userid."','".$_SERVER['REMOTE_ADDR']."','".date('Y-m-d').' '.date('H:i:s')."','".$_SERVER['REMOTE_ADDR']."','".$userid."','".$implastslno."','".($i+1)."')";
			$result = runmysqlquery($query);
			
		}
		/*if(strpos($assign_days,".") != false)
		{
			$query11 = runmysqlqueryfetch("SELECT (MAX(slno)) AS maxslno FROM imp_implementationdays where impref = '".$implastslno."'" );
			$query2 = "Update imp_implementationdays set halfdayflag = 'yes' where slno = '".$query11['maxslno']."'";
			$result2 = runmysqlquery($query2); 
		}*/
		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','154','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		$responsearray18['errorcode'] = "1";
		$responsearray18['errormsg'] = "Record saved successfully";
		echo(json_encode($responsearray18));
		//	echo('1^Record saved successfully');

	}
	break;

	case 'handholddaysassign':
	{
		$responsearray18 = array();
		$implastslno = $_POST['implastslno'];
		$assign_days = $_POST['hassign_days'];
		$impreflastslno = $_POST['impreflastslno'];
		
		$query = "select count(*) as countimp from imp_implementation where implementationstatus = 'completed' and slno = '".$implastslno."'";
		$fetch = runmysqlqueryfetch($query);
		$count = $fetch['countimp'];

		if($count > 0)
		{
			for($i=0;$i<round($assign_days);$i++)
			{
				$query = runmysqlqueryfetch("SELECT (MAX(slno) + 1) AS slno FROM imp_handholdimplementationdays");
				$slno = $query['slno'];
				
				$query = "Insert into imp_handholdimplementationdays(slno,createddatetime,createdby,createdip,lastupdateddatetime,lastupdatedip,lastupdatedby,impref,visitnumber)values('".$slno."','".date('Y-m-d').' '.date('H:i:s')."','".$userid."','".$_SERVER['REMOTE_ADDR']."','".date('Y-m-d').' '.date('H:i:s')."','".$_SERVER['REMOTE_ADDR']."','".$userid."','".$implastslno."','".($i+1)."')";
				$result = runmysqlquery($query);
				
				$query11 = "Update imp_implementation set handholdimplementationstatus = 'pending',handholdcreateddatetime='".date('Y-m-d').' '.date('H:i:s')."',handholdcreatedby='".$userid."',handholdcreatedip = '".$_SERVER['REMOTE_ADDR']."' where imp_implementation.slno = '".$implastslno."' ";
				$resultfetch = runmysqlquery($query11);

			}

			$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','285','".date('Y-m-d').' '.date('H:i:s')."')";
			$eventresult = runmysqlquery($eventquery);
			$responsearray18['errorcode'] = "1";
			$responsearray18['errormsg'] = "Record saved successfully";
		}
		else
		{
			$responsearray18['errorcode'] = "2";
			$responsearray18['errormsg'] = "Hand Hold process cannot be processed before implementation gets completed.";
		}
		
		echo(json_encode($responsearray18));
	}
	break;

	case 'implemenationstatus':
	{
		$responsearray19 = array();
		$lastslno = $_POST['lastslno'];
		$query = "SELECT imp_implementation.branchapproval,imp_implementation.branchapprovaldatetime,imp_implementation.branchrejectdatetime,imp_implementation.approvalremarks as branchremarks,imp_implementation.branchreject,imp_implementation.branchrejectremarks as branchrejectremarks,
		imp_implementation.coordinatorreject, imp_implementation.coordinatorrejectremarks,
		imp_implementation.coordinatorapproval,imp_implementation.coordinatorappdatetime,imp_implementation.coordinatorrejectdatetime, imp_implementation.coordinatorapprovalremarks, 
		imp_implementation.implementationstatus,imp_implementation.handholdimplementationstatus, inv_mas_implementer.businessname, imp_implementation.advancecollected ,imp_implementation.advancesnotcollectedremarks from  imp_implementation 
		left join inv_mas_implementer on inv_mas_implementer.slno = imp_implementation.assignimplemenation 
		where imp_implementation.slno = '".$lastslno."';";
		$fetch = runmysqlqueryfetch($query);
		
		$query1 = "Select assigneddate from imp_implementationdays where imp_implementationdays.impref = '".$lastslno."';";
		$result = runmysqlquery($query1);
		$fetchcount = mysqli_num_rows($result);
		$tablegrid = '<table width="100%" border="0" cellspacing="0" cellpadding="5">';
		$tablegrid .= '<tr><td width="30%"><strong>Assigned To:</strong></td><td width="70%">'.$fetch['businessname'].'</td></tr>';
		$tablegrid .= '<tr><td><strong>No of Days:</strong></td><td>'.$fetchcount.'</td></tr></table>';
		
		$responsearray19['errorcode'] = "1";
		$responsearray19['branchapproval'] = $fetch['branchapproval'];
		$responsearray19['coordinatorreject'] = $fetch['coordinatorreject'];
		$responsearray19['coordinatorapproval'] = $fetch['coordinatorapproval'];
		$responsearray19['implementationstatus'] = $fetch['implementationstatus'];
		$responsearray19['branchremarks'] = $fetch['branchremarks'];
		$responsearray19['coordinatorrejectremarks'] = $fetch['coordinatorrejectremarks'];
		$responsearray19['coordinatorapprovalremarks'] = $fetch['coordinatorapprovalremarks'];
		$responsearray19['tablegrid'] = $tablegrid;
		$responsearray19['advancecollected'] = $fetch['advancecollected'];
		$responsearray19['advancesnotcollectedremarks'] = $fetch['advancesnotcollectedremarks'];
		$responsearray19['branchreject'] = $fetch['branchreject'];
		$responsearray19['branchrejectremarks'] = $fetch['branchrejectremarks'];
		$responsearray19['branchapprovaldatetime'] = changedateformat(substr($fetch['branchapprovaldatetime'],0,10));
		$responsearray19['coordinatorappdatetime'] = changedateformat(substr($fetch['coordinatorappdatetime'],0,10));
		$responsearray19['coordinatorrejectdatetime'] = changedateformat(substr($fetch['coordinatorrejectdatetime'],0,10));
		$responsearray19['branchrejectdatetime'] = changedateformat(substr($fetch['branchrejectdatetime'],0,10));
		$responsearray19['handholdimplementationstatus'] = $fetch['handholdimplementationstatus'];
		echo(json_encode($responsearray19));
		//echo('1^'.$fetch['branchapproval'].'^'.$fetch['coordinatorreject'].'^'.$fetch['coordinatorapproval'].'^'.$fetch['implementationstatus'].'^'.$fetch['branchremarks'].'^'.$fetch['coordinatorrejectremarks'].'^'.$fetch['coordinatorapprovalremarks'].'^'.$tablegrid.'^'.$fetch['advancecollected'].'^'.$fetch['advancesnotcollectedremarks']);
		
	}
	break; 
	
	case 'sendmailonupdate':
	{
		$responsearray20 = array();
		$type = $_POST['type'];
		$lastslno = $_POST['lastslno'];
		$implementerid = $_POST['implementerid'];
		$getimpslno = $_POST['getimpslno'];
		// if($type == 'assignedimplementer')
		// {
		// 	$checkquery = 'select * from imp_implementation where assignimplemenation = "'.$implementerid.'"';
		// 	$resultcheck = runmysqlquery($checkquery); 
		// 	if(mysqli_num_rows($resultcheck) == 0)
		// 	{
		// 		$responsearray20['errorcode'] = "2";
		// 		$responsearray20['errormsg'] = "Assign Implementer and then proceed.";
		// 		//$message = '2^Assign Implementer and then proceed.';
		// 	}
		// 	else
		// 	{
		// 		sendimplementerassignedemail($lastslno,$implementerid);
		// 		$responsearray20['errorcode'] = "1";
		// 		$responsearray20['errormsg'] = "Email sent successfully.";
		// 		//$message = '1^Email sent successfully.';
		// 	}
		// }
		if($type == 'assignedimplementer')
		{	
			sendimplementerassignedemail($lastslno,$implementerid,$getimpslno);
			$responsearray20['errorcode'] = "1";
			$responsearray20['errormsg'] = "Email sent successfully.";
		}
		else if($type == 'assignednoofdays')
		{
			$checkquery = 'select * from imp_implementation where assignimplemenation = "'.$implementerid.'"';
			$resultcheck = runmysqlquery($checkquery); 
			if(mysqli_num_rows($resultcheck) == 0)
			{
				$responsearray20['errorcode'] = "2";
				$responsearray20['errormsg'] = "Assign Implementer and then proceed.";
				//$message = '2^Assign Implementer and then proceed.';
			}
			else
			{
				$fetchresult = runmysqlqueryfetch($checkquery); 
				$checkquery1 = 'select * from imp_implementationdays where impref = "'.$fetchresult['slno'].'"';
				$resultcheck1 = runmysqlquery($checkquery1); //echo($checkquery1); exit;
				if(mysqli_num_rows($resultcheck1) == 0)
				{
					$responsearray20['errorcode'] = "2";
					$responsearray20['errormsg'] = "Enter No of Days and Click Add.";
					//$message = '2^Enter No of Days and Click Add';
				}
				else
				{
					$noofdays = 0;
					while($fetchcresultcheck = mysqli_fetch_array($resultcheck1))
					{
						if($fetchcresultcheck['halfdayflag'] == 'yes')
						{
							$noofdays = $noofdays + 0.5;
						}
						else
						{
							$noofdays = $noofdays + 1;
						}
					}
					senddaysassignedemail($lastslno,$implementerid,$noofdays,$userid);
					$responsearray20['errorcode'] = "1";
					$responsearray20['errormsg'] = "Email sent successfully.";
					//$message = '1^Email sent successfully.';
				}
			}
		}
		else if($type == 'assignedactivities')
		{
			$checkquery = 'select * from imp_implementation where assignimplemenation = "'.$implementerid.'"';
			$resultcheck = runmysqlquery($checkquery); 
			if(mysqli_num_rows($resultcheck) == 0)
			{
				$responsearray20['errorcode'] = "2";
				$responsearray20['errormsg'] = "Assign Implementer and then proceed.";
				//$message = '2^Assign Implementer and then proceed.';
			}
			else
			{
				$fetchresult = runmysqlqueryfetch($checkquery); 
				$imprefno = $fetchresult['slno'] ; //echo($imprefno);exit;
				// Check if activities are assigned
				$querycheckactivities = "select activity from imp_implementationactivity where impref = '".$imprefno."';";	
				$resultcheckactivities = runmysqlquery($querycheckactivities); 
				if(mysqli_num_rows($resultcheckactivities) == 0)
				{
					$responsearray20['errorcode'] = "2";
					$responsearray20['errormsg'] = "Assign the activity before sending email.";
					//$message = '2^Assign the activity before sending email.';
				}
				else
				{
					sendactivitiesassignedemail($lastslno,$implementerid,$imprefno);
					$responsearray20['errorcode'] = "1";
					$responsearray20['errormsg'] = "Email sent successfully.";
					//$message = '1^Email sent successfully.';
				}			
			}
		}		
		echo(json_encode($responsearray20));
	}
	break;
	case 'sendhandholdmailonupdate':
	{
		$responsearray20 = array();
		$type = $_POST['type'];
		$lastslno = $_POST['lastslno'];
		$implastslno = $_POST['implastslno'];
		$implementerid = $_POST['implementerid'];
		$getimpslno = $_POST['getimpslno'];
		if($type == 'assignednoofdays')
		{
			   $checkquery = 'select * from imp_implementation where slno = "'.$implastslno.'"';
			// $checkquery = 'select * from imp_implementation where assignhandholdimplementation = "'.$implementerid.'" and slno = "'.$implastslno.'"';
			// $resultcheck = runmysqlquery($checkquery); 
			// if(mysqli_num_rows($resultcheck) == 0)
			// {
			// 	$responsearray20['errorcode'] = "2";
			// 	$responsearray20['errormsg'] = "Assign Implementer and then proceed.";
			// 	//$message = '2^Assign Implementer and then proceed.';
			// }
			// else
			// {
				$fetchresult = runmysqlqueryfetch($checkquery); 
				$checkquery1 = 'select * from imp_handholdimplementationdays where impref = "'.$fetchresult['slno'].'"';
				$resultcheck1 = runmysqlquery($checkquery1); //echo($checkquery1); exit;
				if(mysqli_num_rows($resultcheck1) == 0)
				{
					$responsearray20['errorcode'] = "2";
					$responsearray20['errormsg'] = "Enter No of Days and Click Add.";
					//$message = '2^Enter No of Days and Click Add';
				}
				else
				{
					$noofdays = 0;
					while($fetchcresultcheck = mysqli_fetch_array($resultcheck1))
					{
						if($fetchcresultcheck['halfdayflag'] == 'yes')
						{
							$noofdays = $noofdays + 0.5;
						}
						else
						{
							$noofdays = $noofdays + 1;
						}
					}
					senddaysassignedemail($lastslno,$implementerid,$noofdays,$userid,'handhold');
					$responsearray20['errorcode'] = "1";
					$responsearray20['errormsg'] = "Email sent successfully.";
					//$message = '1^Email sent successfully.';
				}
			//}
		}
		else if($type == 'assignedactivities')
		{
			$checkquery = 'select * from imp_implementation where assignhandholdimplementation = "'.$implementerid.'" and slno = "'.$implastslno.'"';
			$resultcheck = runmysqlquery($checkquery); 
			if(mysqli_num_rows($resultcheck) == 0)
			{
				$responsearray20['errorcode'] = "2";
				$responsearray20['errormsg'] = "Assign Implementer and then proceed.";
				//$message = '2^Assign Implementer and then proceed.';
			}
			else
			{
				$fetchresult = runmysqlqueryfetch($checkquery); 
				$imprefno = $fetchresult['slno'] ; //echo($imprefno);exit;
				// Check if activities are assigned
				$querycheckactivities = "select activity from imp_handholdimplementationactivity where impref = '".$imprefno."';";	
				$resultcheckactivities = runmysqlquery($querycheckactivities); 
				if(mysqli_num_rows($resultcheckactivities) == 0)
				{
					$responsearray20['errorcode'] = "2";
					$responsearray20['errormsg'] = "Assign the activity before sending email.";
					//$message = '2^Assign the activity before sending email.';
				}
				else
				{
					sendactivitiesassignedemail($lastslno,$implementerid,$imprefno,'handhold');
					$responsearray20['errorcode'] = "1";
					$responsearray20['errormsg'] = "Email sent successfully.";
					//$message = '1^Email sent successfully.';
				}			
			}
		}	
		else if($type == 'assignedhandholdimplementer')
		{	
			// $query = 'select slno from imp_handholdimplementationdays where impref = "'.$fetchresult['slno'].'"';
			// $fetch = runmysqlqueryfetch($query);
			// $handholdslno = $fetch['slno'];
			sendimplementerassignedemail($lastslno,$implementerid,$getimpslno,'handhold');
			$responsearray20['errorcode'] = "1";
			$responsearray20['errormsg'] = "Email sent successfully.";
		}	
		echo(json_encode($responsearray20));
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
		
		$query = "SELECT imp_customizationfiles.slno,imp_customizationfiles.remarks,imp_customizationfiles.attachfilepath 
		from imp_customizationdays left join  `imp_customizationfiles` on `imp_customizationfiles`.`impref` = imp_customizationdays.`impref` where imp_customizationfiles.impref = '".$implastslno."' order by assigneddate DESC LIMIT ".$startlimit.",".$limit.";";
		if($startlimit == 0)
		{
			$grid = '<table width="100%" cellpadding="2" cellspacing="0" class="table-border-grid">';
			$grid .= '<tr class="tr-grid-header" align ="left"><td nowrap = "nowrap" class="td-border-grid" >Sl No</td><td nowrap = "nowrap" class="td-border-grid">Remarks</td><td nowrap = "nowrap" class="td-border-grid">Assign Date</td></tr>';
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
	case 'customizationassigngrid':
	{
		$implastslno = $_POST['imprslno'];
		$startlimit = $_POST['startlimit'];
		$slno = $_POST['slno'];	
		$showtype = $_POST['showtype'];
		$resultcount = "SELECT count(*) as count from imp_customizationdays where imp_customizationdays.impref = '".$implastslno."';";
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
		
		$query = "SELECT imp_customizationdays.slno,imp_customizationdays.remarks,imp_customizationdays.assigneddate 
		from imp_customizationdays where imp_customizationdays.impref = '".$implastslno."' order by assigneddate DESC LIMIT ".$startlimit.",".$limit.";";
		if($startlimit == 0)
		{
			$grid = '<table width="100%" cellpadding="2" cellspacing="0" class="table-border-grid">';
			$grid .= '<tr class="tr-grid-header" align ="left"><td nowrap = "nowrap" class="td-border-grid" >Sl No</td><td nowrap = "nowrap" class="td-border-grid">Remarks</td><td nowrap = "nowrap" class="td-border-grid">Assign Date</td></tr>';
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
			$grid .= "<td nowrap='nowrap' class='td-border-grid'>".changedateformat($fetch['assigneddate'])."</td>";
			$grid .= "</tr>";
		}
		$grid .= "</table>";
		$fetchcount = mysqli_num_rows($result);
		if($fetchcount == 0)
			$grid .= '<tr class="tr-grid-header" align ="left" <td colspan="3" nowrap = "nowrap" class="td-border-grid" >No More Records</td></tr>';
		
		echo '1^'.$grid.'^'.$linkgrid.'^'.$fetchcount;
	}
	break;
	
	case 'filtercustomerlist':
	{
		$responsearray21 = array();
		$status = $_POST['impsearch'];
		$hhstatus = $_POST['imphhsearch'];
		$imphandhold = $_POST['imphandhold'];

		$queryres = "select * from inv_mas_implementer where slno = '".$userid."'";
		$resultfetch = runmysqlqueryfetch($queryres);
		$region = $resultfetch['region'];
		$branch = $resultfetch['branchid'];
		$statuspiece = $hhstatuspiece = $handholdpiece = '';
		if($status == 'Awaiting Branch Head Approval')
		{
			$statuspiece = "AND imp_implementation.branchapproval = 'no' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'no' AND imp_implementation.implementationstatus = 'pending'";
		}
		
		else if($status == 'Awaiting Co-ordinator Approval')
		{
			$statuspiece = "AND imp_implementation.branchapproval = 'yes' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'no' AND imp_implementation.implementationstatus = 'pending'";
		}
		else if($status == 'Fowarded back to Branch Head')
		{
			$statuspiece = "AND imp_implementation.branchapproval = 'no' AND imp_implementation.coordinatorreject = 'yes' AND imp_implementation.coordinatorapproval = 'no' AND imp_implementation.implementationstatus = 'pending'";
		}
		else if($status == 'Implementation, Yet to be Assigned')
		{
			$statuspiece = "AND imp_implementation.branchapproval = 'yes' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'yes' AND imp_implementation.implementationstatus = 'pending'";
		}
		else if($status == 'Assigned For Implementation')
		{
			$statuspiece = "AND imp_implementation.branchapproval = 'yes' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'yes' AND imp_implementation.implementationstatus = 'assigned'";
		}
		else if($status == 'Implementation in progess')
		{
			$statuspiece = "AND imp_implementation.branchapproval = 'yes' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'yes' AND imp_implementation.implementationstatus = 'progess'";
		}
		else if($status == 'Implementation Completed')
		{
			$statuspiece = " AND imp_implementation.branchapproval = 'yes' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'yes' AND imp_implementation.implementationstatus = 'completed'";
		}

		if($hhstatus == 'Implementation, Yet to be Assigned')
		{
			$hhstatuspiece = " AND imp_implementation.handholdimplementationstatus = 'pending'";
		}
		else if($hhstatus == 'Assigned For Implementation')
		{
			$hhstatuspiece = " AND imp_implementation.handholdimplementationstatus = 'assigned'";
		}
		else if($hhstatus == 'Implementation in progess')
		{
			$hhstatuspiece = " AND imp_implementation.handholdimplementationstatus = 'progess'";
		}
		else if($hhstatus == 'Implementation Completed')
		{
			$hhstatuspiece = " AND imp_implementation.handholdimplementationstatus = 'completed'";
		}

		if($imphandhold!= '')
		{
			$handholdpiece = " AND imp_implementation.handholdtype = '".$imphandhold."'";
		}

		if(($region == '1') || ($region == '3'))
		{
		
			$customerlistpiece = " AND (inv_mas_customer.region = '1' or inv_mas_customer.region = '3')";
		}
		else
		{
			$customerlistpiece = " AND (inv_mas_customer.branch = '".$branch."')";
		}
		
		if($status == "" && $hhstatus=="")
		{
			$query = "select distinct inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join imp_implementation on inv_mas_customer.slno = imp_implementation.customerreference where imp_implementation.customerreference is not null and imp_implementation.branchapproval = 'yes' and imp_implementation.coordinatorreject = 'no'  ".$customerlistpiece." order by inv_mas_customer.businessname;";
			$result = runmysqlquery($query);
			$responsearray21 = array();
			$count = 0;
			while($fetch = mysqli_fetch_array($result))
			{
				$responsearray21[$count] = $fetch['businessname'].'^'.$fetch['slno'];
				$count++;
				
			}
		}
		else
		{
			$query0 = "select max(imp_implementation.slno) as impslno,inv_mas_customer.businessname,imp_implementation.customerreference from imp_implementation left join inv_mas_customer on imp_implementation.customerreference = inv_mas_customer.slno where imp_implementation.customerreference is not null and inv_mas_customer.slno <> '99999999999'".$customerlistpiece." group by imp_implementation.customerreference ORDER BY businessname;";
			$result0 = runmysqlquery($query0);
			$responsearray21 = array();
			$count = 0;
			while($fetch0 = mysqli_fetch_array($result0))
			{
				$query = "select inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join imp_implementation on inv_mas_customer.slno = imp_implementation.customerreference where  inv_mas_customer.slno = '".$fetch0['customerreference']."' and imp_implementation.slno = '".$fetch0['impslno']."' ".$statuspiece.$hhstatuspiece.$handholdpiece.";";
				$result = runmysqlquery($query);
				while($fetch = mysqli_fetch_array($result))
				{
					$responsearray21[$count] = $fetch['businessname'].'^'.$fetch['slno'];
					$count++;
					
				}
			}
		}
		
		echo(json_encode($responsearray21));
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
 where (inv_mas_customer.slno LIKE '%".$lastcustomerid."%' OR inv_mas_customer.customerid LIKE '%".$lastcustomerid."%') ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece."   and imp_implementation.branchapproval = 'yes' and imp_implementation.coordinatorreject = 'no'    and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3')  order by inv_mas_customer.businessname;";
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
 where (inv_mas_customer.slno LIKE '%".$lastcustomerid."%' OR inv_mas_customer.customerid LIKE '%".$lastcustomerid."%') ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece."   and imp_implementation.branchapproval = 'yes' and imp_implementation.coordinatorreject = 'no'    and inv_mas_customer.region = ' ".$region."'  order by inv_mas_customer.businessname;";
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
where inv_contactdetails.contactperson LIKE '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece."  and imp_implementation.branchapproval = 'yes' and imp_implementation.coordinatorreject = 'no'    and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3') ORDER BY inv_mas_customer.businessname";
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
where inv_contactdetails.contactperson LIKE '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece."  and imp_implementation.branchapproval = 'yes' and imp_implementation.coordinatorreject = 'no'    and inv_mas_customer.region = ' ".$region."' ORDER BY inv_mas_customer.businessname";
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
where inv_mas_customer.place LIKE '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece."  and imp_implementation.branchapproval = 'yes' and imp_implementation.coordinatorreject = 'no'    and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3') ORDER BY inv_mas_customer.businessname";
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
where inv_mas_customer.place LIKE '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece."  and imp_implementation.branchapproval = 'yes' and imp_implementation.coordinatorreject = 'no'    and inv_mas_customer.region = ' ".$region."' ORDER BY inv_mas_customer.businessname";
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
where (inv_contactdetails.phone LIKE '%".$textfield."%'  OR inv_contactdetails.cell LIKE '%".$textfield."%') ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece."   and imp_implementation.branchapproval = 'yes' and imp_implementation.coordinatorreject = 'no'    and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3') ORDER BY inv_mas_customer.businessname";
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
where (inv_contactdetails.phone LIKE '%".$textfield."%'  OR inv_contactdetails.cell LIKE '%".$textfield."%') ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece."   and imp_implementation.branchapproval = 'yes' and imp_implementation.coordinatorreject = 'no'    and inv_mas_customer.region = ' ".$region."' ORDER BY inv_mas_customer.businessname";
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
where inv_contactdetails.emailid LIKE '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece."  and imp_implementation.branchapproval = 'yes' and imp_implementation.coordinatorreject = 'no' and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3')  ORDER BY inv_mas_customer.businessname";
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
where inv_contactdetails.emailid LIKE '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece."  and imp_implementation.branchapproval = 'yes' and imp_implementation.coordinatorreject = 'no' and inv_mas_customer.region = ' ".$region."'  ORDER BY inv_mas_customer.businessname";
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
where inv_mas_customer.businessname LIKE  '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece."  and imp_implementation.branchapproval = 'yes' and imp_implementation.coordinatorreject = 'no'    and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3') ORDER BY inv_mas_customer.businessname";
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
left join imp_implementationdays on imp_implementationdays.impref = imp_implementation.slno
left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
where inv_mas_customer.businessname LIKE  '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece."  and imp_implementation.branchapproval = 'yes' and imp_implementation.coordinatorreject = 'no'    and inv_mas_customer.region = ' ".$region."' ORDER BY inv_mas_customer.businessname"; 
				}//echo($query);exit;
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

function greaterDate($start_date,$end_date)
{
  $start = strtotime($start_date);
  $end = strtotime($end_date);
  if ($start-$end > 0)
    return 1;
  else
   return 0;
}
?>