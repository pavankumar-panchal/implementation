<?
if($_SESSION['verificationid1'] <> '45634643643659876534568' || imaxgetcookie('userslno') =='')
{ 
	echo('Thinking to redirect');
	exit; 
}
else
$userid = imaxgetcookie('userslno');

?>