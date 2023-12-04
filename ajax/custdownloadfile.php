<?php 
	include('../functions/phpfunctions.php');
	if(imaxgetcookie('userslno') == false) { $url = '../index.php'; header("Location:".$url); }
	else
	$userid = imaxgetcookie('userslno');
	$filepath = $_POST['filepath'];
	
	if($filepath == '')
	{
		$url = '../home/index.php?a_link=dashboard'; 
		header("location:".$url);
	}
	else
	{
			viewfilepath($filepath);
	}
	
function viewfilepath($filepath)
{
	$filename = explode('/',$filepath);
				
	$fp = fopen($filename[5],"wa+");
	if($fp)
	{
		downloadfile($filepath);
		fclose($fp);
	}
}
?>