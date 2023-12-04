<?
if(imaxgetcookie('userslno'); == false) { $url = '../index.php'; header("Location:".$url); }
echo(imaxgetcookie('userslno'););
?>
