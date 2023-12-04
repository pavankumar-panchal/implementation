<?php 
	include('../functions/phpfunctions.php');
	if(imaxgetcookie('userslno') == false) { $url = '../index.php'; header("Location:".$url); }
	else
	$userid = imaxgetcookie('userslno');
	$id = $_GET['id'];
	
	if($id == '1')
		$filepath = $_POST['filepath'];
	elseif($id == '2')
		$filepath = $_POST['impfilepath'];
	elseif($id == '3')
		$filepath = $_POST['custfilepath'];

	if($filepath == '')
	{
		$url = '../home/index.php?a_link=dashboard'; 
		header("location:".$url);
	}
	else
	{
		viewfilepathfunc($filepath);
	}
	
function viewfilepathfunc($filepath)
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