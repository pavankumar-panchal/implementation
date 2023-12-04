<?php
	include('./functions/phpfunctions.php'); 
	$userid = imaxgetcookie('userslno');
	$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','167','".date('Y-m-d').' '.date('H:i:s')."')";
	$eventresult = runmysqlquery($eventquery);
	imaxlogout();
	header('Location:./index.php');
	
?>