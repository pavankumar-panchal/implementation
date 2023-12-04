<?php 
	include('../functions/phpfunctions.php');
	$lastslno = '';
	//echo 'last'.$lastslno = $_POST['lastslno']; exit;
	
	if($_POST['implementationslno'] <> '')
	{
		$lastslno  = $_POST['implementationslno'];
	}
	if($_POST['implonlineslno'] <> '')
	{
		$lastslno  = $_POST['implonlineslno'];
	}
	
	if($lastslno == '')
	{
		$url = '../home/index.php?a_link=home_dashboard'; 
		header("location:".$url);
	}
	else
	{
		vieworgeneratepdfinvoice($lastslno,'view');
	}
?>