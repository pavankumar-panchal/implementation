<?
if(imaxgetcookie('userslno') <> '' || imaxgetcookie('userslno') <>  false) 
{
	$pagelinksplit = explode('/',$pagelink);
	$pagelinkvalue = substr($pagelinksplit[2],0,-4);
	$userid = imaxgetcookie('userslno');
	switch($pagelinkvalue)
	{
		case 'index':  $pagetextvalue = '244'; break;
		case 'assignimplementation':  $pagetextvalue = '245'; break;
		case 'implementationprocess':  $pagetextvalue = '246'; break;
		case 'customization':  $pagetextvalue = '247'; break;
		case 'editprofile':  $pagetextvalue = '248'; break;
		case 'changepw':  $pagetextvalue = '249'; break;
		case 'implementationsummary':  $pagetextvalue ='272'; break;
		case 'implementationdetailed':  $pagetextvalue ='273'; break;
		case 'handholdprocess':  $pagetextvalue ='274'; break;
		case 'handholddetailed':  $pagetextvalue ='275'; break;
	
	}
	$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','".$pagetextvalue."','".date('Y-m-d').' '.date('H:i:s')."')";
	$eventresult = runmysqlquery($eventquery);
}
	
?>
