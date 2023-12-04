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
		$branch = $resultfetch['branchid'];

		if(($region == '1') || ($region == '3'))
		{
		
			$customerlistpiece = " AND (inv_mas_customer.region = '1' or inv_mas_customer.region = '3')";
		}
		else
		{
			$customerlistpiece = " AND (inv_mas_customer.branch = '".$branch."')";
		}
		$grid = '';
		$count = 1;
		if($coordinator == 'yes')
		{
			$query = "select distinct inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
			left join imp_implementation on inv_mas_customer.slno = imp_implementation.customerreference 
			left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno
			where imp_implementation.customerreference is not null and imp_implementation.assignhandholdimplementation is not null and (imp_handholdimplementationdays.assignimplemenation = '".$userid."' or (imp_implementation.assignhandholdimplementation = '".$userid."' and left(imp_implementation.createddatetime,10) < '2023-03-02'))".$customerlistpiece." order by businessname;";
		}
		else
		{
			$query = "select distinct inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
			left join imp_implementation on inv_mas_customer.slno = imp_implementation.customerreference
			left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno 
			where imp_implementation.customerreference is not null and (imp_handholdimplementationdays.assignimplemenation = '".$userid."' or (imp_implementation.assignhandholdimplementation = '".$userid."' and left(imp_implementation.createddatetime,10) < '2023-03-02'))".$customerlistpiece." order by businessname;";
		}
		
		$result = runmysqlquery($query);
		
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
		$responsearray = array();
		$query = "select slno,customerreference,invoicenumber,implementationtype,impremarks,advancecollected,advanceamount,advanceremarks,balancerecoveryremarks,podetails, numberofcompanies,numberofmonths,processingfrommonth,additionaltraining,freedeliverables,schemeapplicable,commissionapplicable,commissionname,commissionemail,commissionmobile,commissionvalue,masterdatabyrelyon,masternumberofemployees,salescommitments,attendanceapplicable,attendanceremarks,attendancefilepath,shipinvoiceapplicable,shipinvoiceremarks,shipmanualapplicable,shipmanualremarks,customizationapplicable,customizationremarks,customizationreffilepath,customizationbackupfilepath,customizationstatus,handholdimplementationstatus,webimplemenationapplicable,webimplemenationremarks,assignhandholdimplementation,assigncustomization,assignwebimplemenation,committedstartdate,podetailspath from imp_implementation where customerreference = '".$lastslno."' order by slno desc limit 1;";
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
				$griddisplay .= "<td nowrap='nowrap' class='td-border-grid'><div align = 'center'><img src='../images/download-arrow.gif'  onclick = viewimpfilepath('".$fetch1['attachfilepath']."') /></div></td>";
				$griddisplay .= "</tr>";
			}
			$griddisplay .= "</table>";
		}
		
		$responsearray["errorcode"] = "1";
		$responsearray["slno"] = $fetch['slno'];
		$responsearray["customerreference"] = $fetch['customerreference'];
		$responsearray["invoicenumber"] = $fetch['invoicenumber'];
		$responsearray['implementationtype'] = $implementationtype;
		$responsearray['impremarks'] = $fetch['impremarks'];
		$responsearray["advancecollected"] = strtoupper($fetch['advancecollected']);
		$responsearray["advanceamount"] = $fetch['advanceamount'];
		$responsearray["advanceremarks"] = $fetch['advanceremarks'];
		$responsearray["balancerecoveryremarks"] = $fetch['balancerecoveryremarks'];
		$responsearray["griddisplay"] = $griddisplay;
		$responsearray["podetails"] = $fetch['podetails'];
		$responsearray["numberofcompanies"] = $fetch['numberofcompanies'];
		$responsearray["numberofmonths"] = $fetch['numberofmonths'];
		$responsearray["processingfrommonth"] = $fetch['processingfrommonth'];
		$responsearray["additionaltraining"] = $fetch['additionaltraining'];
		$responsearray["freedeliverables"] = $fetch['freedeliverables'];
		$responsearray["schemeapplicable"] = $fetch['schemeapplicable'];
		$responsearray["commissionapplicable"] = strtoupper($fetch['commissionapplicable']);
		$responsearray["commissionname"] = $fetch['commissionname'];
		$responsearray["commissionemail"] = $fetch['commissionemail'];
		$responsearray["commissionmobile"] = $fetch['commissionmobile'];
		$responsearray["commissionvalue"] = $fetch['commissionvalue'];
		$responsearray["masterdatabyrelyon"] = strtoupper($fetch['masterdatabyrelyon']);
		$responsearray["salescommitments"] = $fetch['salescommitments'];
		$responsearray["attendanceapplicable"] = strtoupper($fetch['attendanceapplicable']);
		$responsearray["salescommitments"] = $fetch['salescommitments'];
		$responsearray["attendanceapplicable"] = strtoupper($fetch['attendanceapplicable']);
		$responsearray["attendanceremarks"] = $fetch['attendanceremarks'];
		$responsearray["attendancefilepath"] = $fetch['attendancefilepath'];
		$responsearray["shipinvoiceapplicable"] = strtoupper($fetch['shipinvoiceapplicable']);
		$responsearray["shipinvoiceremarks"] = $fetch['shipinvoiceremarks'];
		$responsearray["shipmanualapplicable"] = strtoupper($fetch['shipmanualapplicable']);
		$responsearray["shipmanualremarks"] = $fetch['shipmanualremarks'];
		$responsearray["customizationapplicable"] = strtoupper($fetch['customizationapplicable']);
		$responsearray["customizationremarks"] = $fetch['customizationremarks'];
		$responsearray["customizationreffilepath"] = $fetch['customizationreffilepath'];
		$responsearray["customizationbackupfilepath"] = $fetch['customizationbackupfilepath'];
		$responsearray["customizationstatus"] = $fetch['customizationstatus'];
		$responsearray["handholdimplementationstatus"] = $fetch['handholdimplementationstatus'];
		$responsearray["grid"] = $grid;
		$responsearray["webimplemenationapplicable"] = strtoupper($fetch['webimplemenationapplicable']);
		$responsearray["webimplemenationremarks"] = $fetch['webimplemenationremarks'];
		$responsearray["assignhandholdimplementation"] = $fetch['assignhandholdimplementation'];
		$responsearray["assigncustomization"] = $fetch['assigncustomization'];
		$responsearray["assignwebimplemenation"] = $fetch['assignwebimplemenation'];
		$responsearray["committedstartdate"] = changedateformat($fetch['committedstartdate']);
		$responsearray["podetailspath"] = $fetch['podetailspath'];
		
		echo(json_encode($responsearray));
		
		//echo('1^'.$fetch['slno'].'^'.$fetch['customerreference'].'^'.$fetch['invoicenumber'].'^'.strtoupper($fetch['advancecollected']).'^'.$fetch['advanceamount'].'^'.$fetch['advanceremarks'].'^'.$fetch['balancerecoveryremarks'].'^'.$griddisplay.'^'.$fetch['podetails'].'^'.$fetch['numberofcompanies'].'^'.$fetch['numberofmonths'].'^'.$fetch['processingfrommonth'].'^'.$fetch['additionaltraining'].'^'.$fetch['freedeliverables'].'^'.$fetch['schemeapplicable'].'^'.strtoupper($fetch['commissionapplicable']).'^'.$fetch['commissionname'].'^'.$fetch['commissionemail'].'^'.$fetch['commissionmobile'].'^'.$fetch['commissionvalue'].'^'.strtoupper($fetch['masterdatabyrelyon']).'^'.$fetch['masternumberofemployees'].'^'.$fetch['salescommitments'].'^'.strtoupper($fetch['attendanceapplicable']).'^'.$fetch['attendanceremarks'].'^'.$fetch['attendancefilepath'].'^'.strtoupper($fetch['shipinvoiceapplicable']).'^'.$fetch['shipinvoiceremarks'].'^'.strtoupper($fetch['shipmanualapplicable']).'^'.$fetch['shipmanualremarks'].'^'.strtoupper($fetch['customizationapplicable']).'^'.$fetch['customizationremarks'].'^'.$fetch['customizationreffilepath'].'^'.$fetch['customizationbackupfilepath'].'^'.$fetch['customizationstatus'].'^'.$fetch['handholdimplementationstatus'].'^'.$grid.'^'.strtoupper($fetch['webimplemenationapplicable']).'^'.$fetch['webimplemenationremarks'].'^'.$fetch['assignhandholdimplemenation'].'^'.$fetch['assigncustomization'].'^'.$fetch['assignwebimplemenation'].'^'.changedateformat($fetch['committedstartdate']).'^'.$fetch['podetailspath']);
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
	
	case 'savestartvisit':
	{
		$date = $_POST['date'];
		$starttimehr = $_POST['starttimehr'];
		$starttimemin = $_POST['starttimemin'];
		$starttimeampm = $_POST['starttimeampm'];
		$time = $starttimehr.':'.$starttimemin.$starttimeampm;
		$date = $_POST['date'];
		$starttime = date('H:i:s', strtotime($time));
		$implastslno = $_POST['implastslno'];
		$impreflastslno = $_POST['impreflastslno'];
		$query = "Update imp_handholdimplementationdays set visitedstartflag = 'yes',visitedendflag = 'no',visiteddate = '".changedateformat($date)."', starttime = '".$starttime."',serverstarttime = '".date('H:i:s')."'  where slno = '".$impreflastslno."';";
		$result = runmysqlquery($query);
		$query11 = "Update imp_implementation set handholdimplementationstatus = 'progess' where imp_implementation.slno = '".$implastslno."' ";
		$resultfetch = runmysqlquery($query11);
		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','296','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		//Visit Started mail
		$result = sendstartvisit($impreflastslno,'handhold');
		
		echo('1^Record saved successfully'.'^'.$result);
	}
	break;
	case 'saveendvisit':
	{
		$date = $_POST['date'];
		$starttimehr = $_POST['starttimehr'];
		$starttimemin = $_POST['starttimemin'];
		$starttimeampm = $_POST['starttimeampm'];
		$time1 = $starttimehr.':'.$starttimemin.$starttimeampm;
		$endtimehr = $_POST['endtimehr'];
		$endtimemin = $_POST['endtimemin'];
		$endtimeampm = $_POST['endtimeampm'];
		$time2 = $endtimehr.':'.$endtimemin.$endtimeampm;
		
		$implastslno = $_POST['implastslno'];
		$impreflastslno = $_POST['impreflastslno'];
		$iccfilepath = $_POST['iccfilepath'];
		$iccollected = $_POST['iccollected'];
		$dayremarks = $_POST['dayremarks'];
		
		$starttime = date('H:i:s', strtotime($time1));
		$endtime = date('H:i:s', strtotime($time2));
		
		$timestart = strtotime($starttime);
		$timeend = strtotime($endtime);
		
		$activityslno = $_POST['activityslno'];
		$activitydeleteslno = $_POST['activitydeleteslno'];
		$databackuppath = $_POST['databackuppath'];
		$impstatus = $_POST['impstatus'];
		
		if($activityslno != '')
		{
			$slnoactivity = explode(',',$activityslno);
			$countactivity = count($slnoactivity);
		}
		if($timestart > $timeend)
		{
			echo('3^'.'Entered End time should be greater than the Start time.');
			exit;
		}

		// $query = "SELECT IFNULL(max(handholdtype),0) as handholdtype FROM imp_handholdimplementationdays WHERE impref = '".$implastslno."'";
		// $result = runmysqlqueryfetch($query);
		// $handholdtype = $result['handholdtype'];
		
		// $query23 = "SELECT slno,visitnumber FROM imp_handholdimplementationdays WHERE impref = '".$implastslno."' AND visitnumber=(SELECT max(visitnumber) FROM imp_handholdimplementationdays WHERE impref = '".$implastslno."');";
		$query23 = "SELECT slno,handholdtype FROM imp_handholdimplementationdays WHERE impref = '".$implastslno."' order by slno desc limit 1;";
		$result23 = runmysqlqueryfetch($query23);

		if($result23['slno'] == $impreflastslno && $impstatus!='Completed')
		{
			echo('5^'.'Status must be completed as this is the last visit.');
			exit;
		}
		
		// if($result23['slno']!= $impreflastslno && $impstatus =='Completed')
		// {
		// 	echo('6^'.'Status cannot be completed as this is not the last visit.');
		// 	exit;
		// }

		if($result23['slno'] == $impreflastslno)
		{
			if($iccollected == 'no'  && empty($result2['impstatus']))
			{
				echo('4^'.'ICC attachment is Compulsary as this is the last visit.');
				exit;
			}
		}
		
		if($result23['slno']!= $impreflastslno)
		{
			if($iccollected == 'yes' && $impstatus =='Completed')
			{
				echo('7^'.'ICC attachment is Compulsary as your handhold status is completed.');
				exit;
			}

			if($iccollected == 'yes')
			{
				echo('7^'.'ICC attachment is Compulsary only for the Completed visit.');
				exit;
			}
		}

		if($iccfilepath != '')
		{
			if($iccollected == 'yes')
			{
				$query13 = "Update imp_handholdimplementationdays set iccattachment = 'yes' where impref = '".$implastslno."';";
				$result11 = runmysqlquery($query13);
				$query15 = "Update imp_implementation set handholdimplementationstatus = 'completed' where imp_implementation.slno = '".$implastslno."' ";
				$resultfetch = runmysqlquery($query15); 
			
			}
			
			$query11 = "Update imp_handholdimplementationdays set visitedstartflag = 'yes',visitedendflag = 'yes',iccattachmentpath = '".$iccfilepath."',iccattachmentdate ='".date('Y-m-d').' '.date('H:i:s')."', iccattachmentby = '".$userid."',databackuppath = '".$databackuppath."',databackupdate ='".date('Y-m-d').' '.date('H:i:s')."', databackupby = '".$userid."',impstatus='".$impstatus."' where slno = '".$impreflastslno."';"; //echo($query11);exit;
			$result11 = runmysqlquery($query11); 
			$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','297','".date('Y-m-d').' '.date('H:i:s')."')";
			$eventresult = runmysqlquery($eventquery);
			for($j=0;$j<$countactivity;$j++)
			{
				$queryres = "Update imp_handholdactivitycarried set activityref = '".$impreflastslno."' where slno = '".$slnoactivity[$j]."' ";
				$result11 = runmysqlquery($queryres);
				
			}
			if($activitydeleteslno != '')
			{
				$queryres ="Delete from imp_handholdactivitycarried where slno = '".$activitydeleteslno."';";
				$result11 = runmysqlquery($queryres);
			}
			if($iccollected == 'yes')
			{
				$result = sendicccollectedmail($impreflastslno,'handhold'); 
			}
		}
		else
		{
			$query = "Update imp_handholdimplementationdays set dayremarks = '".$dayremarks."', endtime = '".$endtime."', visitedstartflag = 'yes',visitedendflag = 'yes',serverendtime = '".date('H:i:s')."',databackuppath = '".$databackuppath."',databackupdate ='".date('Y-m-d').' '.date('H:i:s')."', databackupby = '".$userid."',impstatus='".$impstatus."'  where slno = '".$impreflastslno."';";
			$result = runmysqlquery($query);
			$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','297','".date('Y-m-d').' '.date('H:i:s')."')";
			$eventresult = runmysqlquery($eventquery);
		
			$query11 = "Update imp_implementation set handholdimplementationstatus = 'progess' where imp_implementation.slno = '".$implastslno."' ";
			$resultfetch = runmysqlquery($query11);
			for($j=0;$j<$countactivity;$j++)
			{
				$queryres = "Update imp_handholdactivitycarried set activityref = '".$impreflastslno."' where slno = '".$slnoactivity[$j]."' ";
				$result11 = runmysqlquery($queryres);
			}
			if($activitydeleteslno != '')
			{
				$queryres ="Delete from imp_handholdactivitycarried where slno = '".$activitydeleteslno."';";
				$result11 = runmysqlquery($queryres);
			}
			$result = sendendvisit($impreflastslno,'handhold');
		}
		
		echo('2^Record saved successfully'.'^'.$result);
	}
	break;

	case 'generatevisitgrid':
	{
		$implastslno = $_POST['implastslno'];
		$count = 0;	
		$query1 = "select distinct left(imp_implementation.createddatetime,10) as impcreated from imp_implementation
		left join imp_handholdimplementationdays on imp_implementation.slno = imp_handholdimplementationdays.impref where imp_implementation.slno = '".$implastslno."'";
		$fetch1 = runmysqlqueryfetch($query1);

		$query11 = "SELECT slno,assigneddate,remarks,dayremarks,visitnumber,assignimplemenation,left(createddatetime,10) as assignedcreated from imp_handholdimplementationdays  WHERE impref = '".$implastslno."' order by createddatetime asc; ";
		$result11 = runmysqlquery($query11);
		$grid .= '<select name="activitygrid" class="swiftselect" id="activitygrid" style="width:200px;" ><option value="" selected="selected">-- Select--</option>';
		while($fetch = mysqli_fetch_array($result11))
		{
			$count++;
			if($fetch['assigneddate'] != '')
				$assigndate = changedateformat($fetch['assigneddate']);
			else
				$assigndate = 'Not Assigned';
			if($fetch['remarks'] != '')
				$assignremarks = gridtrim($fetch['remarks']);
			else
				$assignremarks = 'Not Available';

			//echo $assigndate;
			
			
			if($fetch1['impcreated'] < '2023-03-02' && $fetch['assignedcreated'] < '2023-03-02')
				$grid .='<option value="'.$fetch['slno'].'">Visit'.$count.' '.'('.$assigndate.'/'.$assignremarks.')'.'</option>';
			elseif($fetch['assignimplemenation'] == $userid && $fetch1['impcreated'] >= '2023-03-02' && $fetch['assignedcreated'] >= '2023-03-02')		
				$grid .='<option value="'.$fetch['slno'].'">Visit'.$count.' '.'('.$assigndate.'/'.$assignremarks.')'.'</option>';

			//$implastslno = $fetch['impref'];
		}
		$grid .= '</select>';
		echo('1^'.$grid.'^'.$implastslno);
	}
	break;
	case 'visitsgridtoform':
	{
		$impreflastslno = $_POST['impreflastslno'];
		$activitytext = $_POST['activitytext'];
		
		$query = "select inv_mas_implementer.businessname,assigneddate,visitedstartflag,visitedendflag ,iccattachment,TIME_FORMAT(starttime,'%h:%i:%p') as starttime,TIME_FORMAT(endtime,'%h:%i:%p') as endtime,dayremarks,impref,visiteddate,iccattachmentpath,databackuppath,impstatus from imp_handholdimplementationdays left join imp_implementation on imp_handholdimplementationdays.impref = imp_implementation.slno  left join inv_mas_implementer on inv_mas_implementer.slno = imp_implementation.assignhandholdimplementation   where imp_handholdimplementationdays.slno = '".$impreflastslno."';";
		//echo($query);exit;
		$fetch = runmysqlqueryfetch($query);

		$query1 = "select count(*) as visitflagcount from imp_handholdimplementationdays where impref = '".$fetch['impref']."' and assignimplemenation='".$userid."' and slno < '".$impreflastslno."'  and visitedstartflag='no'";
		$fetch1 = runmysqlqueryfetch($query1);
		$count = $fetch1['visitflagcount'];
		if($count == 0)
		{
			/*$query1 = "select *, max(slno) from imp_handholdimplementationdays where impref = '".$fetch['impref']."' group by impref;";
			$fetchres = runmysqlqueryfetch($query1);*/
			if($fetch['visiteddate'] == '')
				$dateval = 'Not Assigned';
			else
				$dateval = changedateformat($fetch['visiteddate']);
			if($fetch['assigneddate'] == '')
				$assigndate = 'Not Avaliable';
			else
				$assigndate = changedateformat($fetch['assigneddate']);
				
			echo('1^'.$dateval.'^'.$fetch['visitedstartflag'].'^'.$fetch['iccattachment'].'^'.$fetch['starttime'].'^'.$fetch['endtime'].'^'.$fetch['dayremarks'].'^'.$fetch['visitedendflag'].'^'.$activitytext.'^'.$fetch['impref'].'^'.$assigndate.'^'.$fetch['iccattachmentpath'].'^'.$fetch['databackuppath'].'^'.$fetch['impstatus']);
		}
		else{
			echo('2^'.$count);
		}
	}
	break;

	case 'getactivitylist':
	{
		$implastslno = $_POST['implastslno'];
		$query = "select distinct imp_mas_activity.slno,imp_handholdimplementationactivity.activity,imp_mas_activity.activityname,impref from imp_handholdimplementationactivity left join imp_mas_activity on imp_handholdimplementationactivity.activity = imp_mas_activity.slno left join imp_implementation on imp_implementation.slno = imp_handholdimplementationactivity.impref where imp_implementation.customerreference =  '".$lastslno."' and imp_handholdimplementationactivity.impref = '".$implastslno."';";
		$result = runmysqlquery($query);
		$grid .= '<select name="activity" class="swiftselect" id="activity" style="width:200px;" onchange ="getactivityremarks();"><option value="" selected="selected">Select a Activity</option>';
		while($fetch = mysqli_fetch_array($result))
		{
			if($fetch['activity'] == 1 || $fetch['activity'] == 2 || $fetch['activity'] == 3 || $fetch['activity'] == 4)
				$activityname = $fetch['activityname'];
			else
				$activityname = $fetch['activity'];
			$grid .='<option value="'.$activityname.'">'.$activityname.'</option>';
			$implastslno = $fetch['impref'];
		}
		$grid .= '</select>';
		echo('1^'.$grid.'^'.$implastslno);
	}
	break;
	case 'saveactivity':
	{
		$activity = $_POST['activity'];
		$description = $_POST['description'];
		$impreflastslno = $_POST['impreflastslno'];
		$impactivitylastslno = $_POST['impactivitylastslno'];
		$implastslno = $_POST['implastslno'];
		if($impactivitylastslno == '')
		{
			$query = "insert imp_handholdactivitycarried ( activity, description, createddatetime,createdby, createdip, 
			lastupdateddatetime, lastupdatedip, lastupdatedby,impref) values('".$activity."','".$description."','".date('Y-m-d').' '.date('H:i:s')."','".$userid."','".$_SERVER['REMOTE_ADDR']."','".date('Y-m-d').' '.date('H:i:s')."','".$_SERVER['REMOTE_ADDR']."','".$userid."','".$implastslno."')";
			$result = runmysqlquery($query);
			//exit;
			$query12 = "SELECT slno AS slno FROM imp_handholdactivitycarried where impref = '".$implastslno."' and (imp_handholdactivitycarried.activityref is null or imp_handholdactivitycarried.activityref = '')";
			$result222 = runmysqlquery($query12);
			while($fetch = mysqli_fetch_array($result222))
			{
				$slnoarraylist .= $fetch['slno'].',';
			}
			$slnolist = trim($slnoarraylist,',');
			
		}
		else
		{
			$query = "Update imp_handholdactivitycarried set description = '".$description."', activity = '".$activity."' , lastupdateddatetime = '".date('Y-m-d').' '.date('H:i:s')."',lastupdatedip = '".$_SERVER['REMOTE_ADDR']."',lastupdatedby = '".$userid."' where slno = '".$impreflastslno."';";
			$result = runmysqlquery($query);
			$query12 = "SELECT slno AS slno FROM imp_handholdactivitycarried where impref = '".$implastslno."'  and (imp_handholdactivitycarried.activityref is null or imp_handholdactivitycarried.activityref = '')";
			$result222 = runmysqlquery($query12);
			while($fetch = mysqli_fetch_array($result222))
			{
				$slnoarraylist .= $fetch['slno'].',';
			}
			$slnolist = trim($slnoarraylist,',');
		}
		echo('1^Record as marked for Saved'.'^'.$slnolist);
	}
	break;
	case 'generateactivitygrid':
	{
		$impreflastslno = $_POST['impreflastslno'];
		$resultcount = "SELECT count(*) as count  from imp_handholdactivitycarried left join imp_mas_activity on imp_mas_activity.slno = imp_handholdactivitycarried.activity where imp_handholdactivitycarried.impref = '".$impreflastslno."' and (imp_handholdactivitycarried.activityref is null or imp_handholdactivitycarried.activityref = '');";
		$fetch10 = runmysqlqueryfetch($resultcount);
		$fetchresultcount = $fetch10['count'];
		
		$grid = '<table width="100%" cellpadding="3" cellspacing="0" class="table-border-grid">';
		$grid .= '<tr class="tr-grid-header" align ="left"><td nowrap = "nowrap" class="td-border-grid" >Sl No</td><td nowrap = "nowrap" class="td-border-grid">Date</td><td nowrap = "nowrap" class="td-border-grid">Activity</td><td nowrap = "nowrap" class="td-border-grid">Remarks</td></tr>';
		if($fetchresultcount > 0)
		{
			$query = "SELECT * from imp_handholdactivitycarried where imp_handholdactivitycarried.impref = '".$impreflastslno."' and (imp_handholdactivitycarried.activityref is null or imp_handholdactivitycarried.activityref = '') order by createddatetime DESC";
			$result = runmysqlquery($query);
			$i_n = 0;
			while($fetch = mysqli_fetch_array($result))
			{
				$i_n++;
				$slno++;
				$color;
				if($i_n%2 == 0)
					$color = "#edf4ff";
				else
					$color = "#f7faff";
				$grid .= '<tr class="gridrow" bgcolor='.$color.' onclick="activitygridtoform(\''.$fetch['slno'].'\'); " align ="left">';
				$grid .= "<td nowrap='nowrap' class='td-border-grid'>".$slno."</td>";
				$grid .= "<td nowrap='nowrap' class='td-border-grid'>".changedateformatwithtime(substr($fetch['createddatetime'],0,10))."</td>";
				$grid .= "<td nowrap='nowrap' class='td-border-grid'>".$fetch['activity']."</td>";
				$grid .= "<td nowrap='nowrap' class='td-border-grid'>".gridtrim($fetch['description'])."</td>";
				$grid .= "</tr>";
			}
			$fetchcount = mysqli_num_rows($result);
			if($fetchcount == '0')
				$grid .= "<tr><td colspan ='3' class='td-border-grid'><div align='center'><font color='#FF0000'><strong>No Records to Display</strong></font></div></td></tr>";
		}
		else
		{
			$grid .= "<tr><td colspan ='3' class='td-border-grid'><div align='center'><font color='#FF0000'><strong>No Records to Display</strong></font></div></td></tr>";
		}
		$grid .= "</table>";

		
		echo '1^'.$grid.'^'.''.'^'.$fetchresultcount.'^'.$fetchcount;
	}
	break;
	case 'activitygridtoform':
	{
		$impactivitylastslno = $_POST['impactivitylastslno'];
		$query = "SELECT imp_handholdactivitycarried.activity, imp_handholdactivitycarried.description, imp_handholdimplementationactivity.remarks from imp_handholdactivitycarried 
		left join imp_handholdimplementationactivity on imp_handholdimplementationactivity.activity = imp_handholdactivitycarried.activity  where  imp_handholdactivitycarried.slno = '".$impactivitylastslno."';";
		$fetch = runmysqlqueryfetch($query);
		echo('1^'.$fetch['activity'].'^'.$fetch['description'].'^'.$fetch['remarks']);
	}
	break;
	case 'activitygridvisit':
	{
		$activityref = $_POST['impreflastslno'];
		$query = "SELECT count(*) as count  from imp_handholdactivitycarried where (imp_handholdactivitycarried.activityref is null or imp_handholdactivitycarried.activityref = '')";
		$resfetch = runmysqlqueryfetch($query);
		$resultcountfetch = $resfetch['count'];
		if($resultcountfetch != 0)
		{
			$queryres ="Delete from imp_handholdactivitycarried where (imp_handholdactivitycarried.activityref is null or imp_handholdactivitycarried.activityref = '');";
			$result11 = runmysqlquery($queryres);
		}
		
		$resultcount = "SELECT count(*) as count  from imp_handholdactivitycarried left join imp_mas_activity on imp_mas_activity.slno = imp_handholdactivitycarried.activity where imp_handholdactivitycarried.activityref = '".$activityref."';";
		$fetch10 = runmysqlqueryfetch($resultcount);
		$fetchresultcount = $fetch10['count'];
		
		$grid = '<table width="100%" cellpadding="3" cellspacing="0" class="table-border-grid">';
		$grid .= '<tr class="tr-grid-header" align ="left"><td nowrap = "nowrap" class="td-border-grid" >Sl No</td><td nowrap = "nowrap" class="td-border-grid">Date</td><td nowrap = "nowrap" class="td-border-grid">Remarks</td></tr>';
		if($fetchresultcount > 0)
		{
			$query = "SELECT imp_handholdactivitycarried.slno,imp_mas_activity.activityname,imp_handholdactivitycarried.description from imp_handholdactivitycarried left join imp_mas_activity on imp_mas_activity.slno = imp_handholdactivitycarried.activity where imp_handholdactivitycarried.activityref = '".$activityref."' order by createddatetime DESC";
			$result = runmysqlquery($query);
			$i_n = 0;
			while($fetch = mysqli_fetch_array($result))
			{
				$i_n++;
				$slno++;
				$color;
				if($i_n%2 == 0)
					$color = "#edf4ff";
				else
					$color = "#f7faff";
				$grid .= '<tr class="gridrow" bgcolor='.$color.' onclick="activitygridtoform(\''.$fetch['slno'].'\'); " align ="left">';
				$grid .= "<td nowrap='nowrap' class='td-border-grid'>".$slno."</td>";
				$grid .= "<td nowrap='nowrap' class='td-border-grid'>".$fetch['activityname']."</td>";
				$grid .= "<td nowrap='nowrap' class='td-border-grid'>".gridtrim($fetch['description'])."</td>";
				$grid .= "</tr>";
			}
			$fetchcount = mysqli_num_rows($result);
			if($fetchcount == '0')
				$grid .= "<tr><td colspan ='3' class='td-border-grid'><div align='center'><font color='#FF0000'><strong>No Records to Display</strong></font></div></td></tr>";
		}
		else
		{
			$grid .= "<tr><td colspan ='3' class='td-border-grid'><div align='center'><font color='#FF0000'><strong>No Records to Display</strong></font></div></td></tr>";
		}
		$grid .= "</table>";

		
		echo '1^'.$grid.'^'.''.'^'.$fetchresultcount.'^'.$fetchcount;
	}
	break;
	case 'deleteactivity':
	{

		$impactivitylastslno = $_POST['impactivitylastslno'];
		$query = "Delete from imp_handholdactivitycarried where slno = '".$impactivitylastslno."';";
		$result = runmysqlquery($query);
		echo('2^Record has marked for Deletion'.'^'.$impactivitylastslno);
	}
	break;
	case 'getactivityremarks':
	{
		$activity = $_POST['activity'];
		$implastslno = $_POST['impreflastslno'];
		$query = "select * from imp_handholdimplementationactivity where activity = '".$activity."' and impref = '".$implastslno."';";
		$resultfetch = runmysqlqueryfetch($query);
		$remarks = $resultfetch['remarks'];
		echo('1^'.$remarks);
	}
	break;
	case 'invoicedetailsgrid':
	{
		$grid = "";
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
		echo('1'.'^'.$grid.'^'.$result['invoiceno']);
			
	}
	break;
	case 'deletepath':
	{
		$pathlink = $_POST['pathlink'];
		unlink($pathlink);
		echo('1^'.'Success');
	}
	break;
	case 'implemenationstatus':
	{
		$lastslno = $_POST['lastslno'];
		$query = "SELECT imp_implementation.branchapproval,imp_implementation.approvalremarks as branchremarks,imp_implementation.branchreject,imp_implementation.branchrejectremarks as branchrejectremarks,imp_implementation.branchreject,imp_implementation.branchrejectremarks as branchrejectremarks,
		imp_implementation.coordinatorreject, imp_implementation.coordinatorrejectremarks,
		imp_implementation.coordinatorapproval, imp_implementation.coordinatorapprovalremarks, 
		imp_implementation.handholdimplementationstatus, inv_mas_implementer.businessname, imp_implementation.advancecollected ,
		imp_implementation.advancesnotcollectedremarks ,imp_handholdimplementationdays.assignimplemenation as assignedimp
		from  imp_implementation 
		left join inv_mas_implementer on inv_mas_implementer.slno = imp_implementation.assignhandholdimplementation 
		left join imp_handholdimplementationdays on inv_mas_implementer.slno = imp_handholdimplementationdays.assignimplemenation
		where imp_implementation.slno = '".$lastslno."';";
		$fetch = runmysqlqueryfetch($query);
		
		$query1 = "Select assigneddate from imp_handholdimplementationdays where imp_handholdimplementationdays.impref = '".$lastslno."' and assignimplemenation = '".$fetch['assignedimp']."';";
		$result = runmysqlquery($query1);
		$fetchcount = mysqli_num_rows($result);
		$tablegrid = '<table width="100%" border="0" cellspacing="0" cellpadding="5">';
		$tablegrid .= '<tr><td width="30%"><strong>Assigned To:</strong></td><td width="70%">'.$fetch['businessname'].'</td></tr>';
		$tablegrid .= '<tr><td><strong>No of Days:</strong></td><td>'.$fetchcount.'</td></tr></table>';
		echo('1^'.$fetch['branchapproval'].'^'.$fetch['coordinatorreject'].'^'.$fetch['coordinatorapproval'].'^'.$fetch['handholdimplementationstatus'].'^'.$fetch['branchremarks'].'^'.$fetch['coordinatorrejectremarks'].'^'.$fetch['coordinatorapprovalremarks'].'^'.$tablegrid.'^'.$fetch['advancecollected'].'^'.$fetch['advancesnotcollectedremarks'].'^'.$fetch['branchreject'].'^'.$fetch['branchrejectremarks']);
		
	}
	break;
	
	case 'visitdetails':
	{
		$impslno = $_POST['impslno'];
		$count = 0;
		$query = "SELECT count(*) as count  from imp_handholdactivitycarried where (imp_handholdactivitycarried.activityref is null or imp_handholdactivitycarried.activityref = '')";
		$resfetch = runmysqlqueryfetch($query);
		$resultcountfetch = $resfetch['count'];
		if($resultcountfetch != 0)
		{
			$queryres ="Delete from imp_handholdactivitycarried where (imp_handholdactivitycarried.activityref is null or imp_handholdactivitycarried.activityref = '');";
			$result11 = runmysqlquery($queryres);
		}
		$query1 = "select distinct left(imp_implementation.createddatetime,10) as impcreated from imp_implementation
		left join imp_handholdimplementationdays on imp_implementation.slno = imp_handholdimplementationdays.impref where imp_implementation.slno = '".$impslno."'";
		$fetch1 = runmysqlqueryfetch($query1);

		$query11 = "SELECT slno,assigneddate,remarks,dayremarks,assignimplemenation from imp_handholdimplementationdays  WHERE impref = '".$impslno."' order by createddatetime asc ";
		$result11 = runmysqlquery($query11);
		$grid .= '<select name="activitygrid" class="swiftselect" id="activitygrid" style="width:200px;" ><option value="" selected="selected">-- Select--</option>';
		while($fetch = mysqli_fetch_array($result11))
		{
			$count++;
			if($fetch['assigneddate'] != '')
				$assigndate = changedateformat($fetch['assigneddate']);
			else
				$assigndate = 'Not Assigned';
			if($fetch['remarks'] != '')
				$assignremarks = gridtrim($fetch['remarks']);
			else
				$assignremarks = 'Not Available';
			if($fetch1['impcreated'] < '2023-03-02')
				$grid .='<option value="'.$fetch['slno'].'">Visit'.$count.' '.'('.$assigndate.'/'.$assignremarks.')'.'</option>';
			elseif($fetch['assignimplemenation'] == $userid && $fetch1['impcreated'] >= '2023-03-02')
				$grid .='<option value="'.$fetch['slno'].'">Visit'.$count.' '.'('.$assigndate.'/'.$assignremarks.')'.'</option>';
			$implastslno = $fetch['impref'];
		}
		$grid .= '</select>';
		echo('1^'.$grid);
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
		$responsearray21 = array();
		$status = $_POST['impsearch'];
		$imphandhold = $_POST['imphandhold'];
		$statuspiece = $handholdpiece = '';

		if($status == 'Assigned For Implementation')
		{
			$statuspiece = " AND imp_implementation.handholdimplementationstatus = 'assigned'";
		}
		else if($status == 'Implementation in progess')
		{
			$statuspiece = " AND imp_implementation.handholdimplementationstatus = 'progess'";
		}
		else if($status == 'Implementation Completed')
		{
			$statuspiece = " AND imp_implementation.handholdimplementationstatus = 'completed'";
		}

		if($imphandhold!= '')
		{
			$handholdpiece = " AND imp_implementation.handholdtype = '".$imphandhold."'";
		}

		$query1 = "select * from inv_mas_implementer where slno = '".$userid."';";
		$resultfetch = runmysqlqueryfetch($query1);
		$coordinator = $resultfetch['coordinator'];
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

		if($status == "" && $imphandhold == "")
		{
			$querycase = "select distinct inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
			left join imp_implementation on inv_mas_customer.slno = imp_implementation.customerreference
			left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno";
			if($coordinator == 'yes')
			{
				$query = $querycase." where imp_implementation.customerreference is not null and imp_implementation.assignhandholdimplementation is not null and (imp_handholdimplementationdays.assignimplemenation = '".$userid."' or (imp_implementation.assignhandholdimplementation = '".$userid."' and left(imp_implementation.createddatetime,10) < '2023-03-02'))".$customerlistpiece." order by businessname;";
			}
			else
			{
				$query = $querycase." where imp_implementation.customerreference is not null and (imp_handholdimplementationdays.assignimplemenation = '".$userid."' or (imp_implementation.assignhandholdimplementation = '".$userid."' and left(imp_implementation.createddatetime,10) < '2023-03-02'))".$customerlistpiece." order by businessname;";
			}
			$result = runmysqlquery($query);
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
			$count = 0;
			while($fetch0 = mysqli_fetch_array($result0))
			{
				if($coordinator == 'yes')
				{
					$query = "select distinct inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
					left join imp_implementation on inv_mas_customer.slno = imp_implementation.customerreference 
					left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno
					where inv_mas_customer.slno = '".$fetch0['customerreference']."' and imp_implementation.slno = '".$fetch0['impslno']."' ".$statuspiece.$handholdpiece." and  imp_implementation.assignhandholdimplementation is not null and (imp_handholdimplementationdays.assignimplemenation = '".$userid."' or (imp_implementation.assignhandholdimplementation = '".$userid."' and left(imp_implementation.createddatetime,10) < '2023-03-02')) order by businessname;";
				}
				else
				{
					$query = "select distinct inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
					left join imp_implementation on inv_mas_customer.slno = imp_implementation.customerreference
					left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno 
					where inv_mas_customer.slno = '".$fetch0['customerreference']."' and imp_implementation.slno = '".$fetch0['impslno']."' ".$statuspiece.$handholdpiece." and (imp_handholdimplementationdays.assignimplemenation = '".$userid."' or (imp_implementation.assignhandholdimplementation = '".$userid."' and left(imp_implementation.createddatetime,10) < '2023-03-02')) order by businessname;";
				}
				
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
	
	case 'customerizationsave':
	{
		$lastslno = $_POST['lastslno'];
		$customizationreffilepath = $_POST['customization_references'];
		$customizationbackupfilepath = $_POST['customization_sppdata'];	
		$customization_remarks = $_POST['customizationremarks'];
		$customizationstatus = $_POST['customizationstatus'];
		
		$query11 = "UPDATE imp_implementation SET customizationapplicable = 'yes',customizationremarks = '".$customization_remarks."',customizationreffilepath = '".$customizationreffilepath."',customizationreffiledate = '".date('Y-m-d').' '.date('H:i:s')."',customizationreffileattachedby ='".$userid."',customizationbackupfilepath ='".$customizationbackupfilepath."',customizationbackupfiledate ='".date('Y-m-d').' '.date('H:i:s')."',customizationbackupfileattachedby = '".$userid."' ,customizationstatus = '".$customizationstatus."' WHERE slno = '".$lastslno."'";
		$result = runmysqlquery($query11);
		$resultmail = sendcustomizationmail($lastslno,$userid);
		$responsearray1 = array();
		$responsearray1['errorcode'] = "1";
		$responsearray1['customizationapplicable'] = "YES";
		$responsearray1['customizationremarks'] = $customization_remarks;
		$responsearray1['customizationreffilepath'] = $customizationreffilepath;
		$responsearray1['customizationbackupfilepath'] = $customizationbackupfilepath;
		$responsearray1['customizationstatus'] = $customizationstatus;
		$responsearray1['res'] = $resultmail;
		$responsearray1['errormsg'] = "Customer Record Saved Successfully";
		
		echo(json_encode($responsearray1));
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
		// $statuslist = $_POST['statuslist'];
		// $statuslistsplit = explode(',',$statuslist);
		// $countsummarize = count($statuslistsplit);
		// for($i = 0; $i<$countsummarize; $i++)
		// {
		// 	if($i < ($countsummarize-1))
		// 			$appendor = 'or'.' ';
		// 		else
		// 			$appendor = '';
		// 	switch($statuslistsplit[$i])
		// 	{
								
		// 		case 'status3' :
		// 		{
		// 			$statuspiece = " imp_implementation.branchapproval = 'yes' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'no' AND imp_implementation.handholdimplementationstatus = 'pending' ";
		// 		}
		// 		break;
		// 		case 'status4' :
		// 		{
		// 			$statuspiece = " imp_implementation.branchapproval = 'no' AND imp_implementation.coordinatorreject = 'yes' AND imp_implementation.coordinatorapproval = 'no' AND imp_implementation.handholdimplementationstatus = 'pending' ";
		// 		}
		// 		break;
		// 		case 'status5' :
		// 		{
		// 			$statuspiece = " imp_implementation.branchapproval = 'yes' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'yes' AND imp_implementation.handholdimplementationstatus = 'pending' ";
		// 		}
		// 		break;
		// 		case 'status6' :
		// 		{
		// 			$statuspiece = " imp_implementation.branchapproval = 'yes' AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'yes' AND imp_implementation.handholdimplementationstatus = 'assigned' ";
		// 		}
		// 		break;
		// 		case 'status7' :
		// 		{
		// 			$statuspiece = " imp_implementation.branchapproval = 'yes'  AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'yes' AND imp_implementation.handholdimplementationstatus = 'progess' ";
		// 		}
		// 		break;
		// 		case 'status8' :
		// 		{
		// 			$statuspiece = " imp_implementation.branchapproval = 'yes'  AND imp_implementation.coordinatorreject = 'no' AND imp_implementation.coordinatorapproval = 'yes' AND imp_implementation.handholdimplementationstatus = 'completed' ";
		// 		}
		// 		break;
				
		// 	}
		// 	$finalstatuslist .= ''.'('.$statuspiece.')'.'  '.$appendor.'';
		// }
		// if($finalstatuslist != '')
		// {
		// 	$finalliststatus = ' AND'.'('.$finalstatuslist.')';
		// }
		// else
		// {
		// 	$finalliststatus = "";
		// }
		
		$regionpiece = ($region2 == "")?(""):(" AND inv_mas_customer.region = '".$region2."' ");
		$state_typepiece = ($state2 == "")?(""):(" AND inv_mas_district.statecode = '".$state2."' ");
		$district_typepiece = ($district2 == "")?(""):(" AND inv_mas_customer.district = '".$district2."' ");
		$dealer_typepiece = ($dealer2 == "")?(""):(" AND inv_mas_customer.currentdealer = '".$dealer2."' ");
		$branchpiece = ($branch2 == "")?(""):(" AND inv_mas_customer.branch = '".$branch2."' ");
		$imp_implementationpiece = ($implementer == "")?(""):(" AND imp_implementation.assignhandholdimplementation = '".$implementer."' ");
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
			$coordinatorpiece ="and imp_implementation.assignhandholdimplementation is not null";
		else
			$coordinatorpiece = "and imp_implementation.assignhandholdimplementation = '".$userid."'";
			
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
					left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno
					left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
					where (inv_mas_customer.slno LIKE '%".$lastcustomerid."%' OR inv_mas_customer.customerid LIKE '%".$lastcustomerid."%') ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece."   and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3')  order by inv_mas_customer.businessname;";
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
					left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
					left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
					left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno
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
					left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno
					left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
					where inv_contactdetails.contactperson LIKE '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece."  and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3') ORDER BY inv_mas_customer.businessname";
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
					left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
					left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
					left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno
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
					left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno
					left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
					where inv_mas_customer.place LIKE '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece."  and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3') ORDER BY inv_mas_customer.businessname";
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
					left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
					left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
					left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno
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
					left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno
					left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
					where (inv_contactdetails.phone LIKE '%".$textfield."%'  OR inv_contactdetails.cell LIKE '%".$textfield."%') ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece."  and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3') ORDER BY inv_mas_customer.businessname";
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
					left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
					left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
					left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
					left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno
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
					left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno
					left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
					where inv_contactdetails.emailid LIKE '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece." and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3')  ORDER BY inv_mas_customer.businessname";
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
					left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
					left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
					left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
					left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno
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
					left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno
					left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
					where inv_mas_customer.businessname LIKE  '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece." and (inv_mas_customer.region = '1' or inv_mas_customer.region = '3') ORDER BY inv_mas_customer.businessname"; //echo($query);exit;
				}
				else
				{
					$query = "select DISTINCT inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer 
					left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno  
					left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode
					left join imp_implementation on imp_implementation.customerreference = inv_mas_customer.slno
					left join imp_handholdimplementationdays on imp_handholdimplementationdays.impref = imp_implementation.slno
					left join imp_cfentries on right(imp_cfentries.customerid,5) = inv_mas_customer.slno
					where inv_mas_customer.businessname LIKE  '%".$textfield."%' ".$regionpiece.$district_typepiece.$state_typepiece.$dealer_typepiece.$typepiece.$categorypiece.$branchpiece.$finalliststatus.$imp_implementationpiece.$coordinatorpiece." and inv_mas_customer.region = ' ".$region."' ORDER BY inv_mas_customer.businessname";
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