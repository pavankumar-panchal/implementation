<?php 
include('functions/phpfunctions.php');
session_start();

if(imaxgetcookie('userslno') <> false)
{
	$url = './home/index.php?a_link=dashboard';
	header("location:".$url);
}
else
{
	imaxlogout();
}
$message ="";
$dealerusername = "";

if(isset($_POST['login']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	if($username == '' or $password == '')
	{
		$message = "<span class='error-message'>Enter the User Name or Password</span>";
		$deployerusername = $username ;
	}
	else
	{
		$query = "SELECT slno,AES_DECRYPT(loginpassword,'imaxpasswordkey') as loginpassword,disablelogin FROM inv_mas_implementer WHERE implementerusername = '".$username."'";
		$result = runmysqlquery($query);
		if(mysqli_num_rows($result) > 0)
		{
			$fetch = runmysqlqueryfetch($query);
			
			$userslno = $fetch['slno']; 
			$passwd = $fetch['loginpassword'];
			$disablelogin = $fetch['disablelogin'];
			if($disablelogin == 'no')
			{
				if($password <> $passwd)
				{
					$message = "<span class='error-message'>Password does not match with the user</span>";
					$implementerusername = $username ;
				}
				else
				{
					session_start();
					$_SESSION['verificationid1'] = '45634643643659876534568';  
					//setcookie('userid',$user);
					imaxcreatecookie('userslno',$userslno);
					$query1 ="INSERT INTO inv_logs_login(userid,`date`,`time`,`type`,system) VALUES('".$userslno."','".datetimelocal('Y-m-d')."','".datetimelocal('h:i:s')."','implementer_login','".$_SERVER['REMOTE_ADDR']."')";
					$result = runmysqlquery($query1);
					$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userslno."','".$_SERVER['REMOTE_ADDR']."','150','".date('Y-m-d').' '.date('H:i:s')."')";
					$eventresult = runmysqlquery($eventquery);
					
					$url = './home/index.php?a_link=dashboard'; 
					header("location:".$url);
				}
			}
			else
			{
				$message = "<span class='error-message'>Login is Disabled</span>";
			}
		}
		else
		{
			$message = "<span class='error-message'>Invalid UserName.</span>";
			$implementerusername = $username ;
		}
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Implementer Login</title>
<script language="javascript" src="./functions/cookies.js?dummy=<?php echo (rand());?>"></script>
<script language="javascript">
function checknavigatorproperties()
{
	if((navigator.cookieEnabled == false) && (!navigator.javaEnabled())){
	 document.getElementById('username').focus(); return false; }
	else
	{
		return true;
		form.submit();
	}
}
</script>
<?php include('./inc/scriptsandstyles.php'); ?>

</head>
<body onload="document.submitform.username.focus(); SetCookie('logincookiejs','logincookiejs'); if(!GetCookie('logincookiejs')) document.getElementById('form-error').innerHTML = '<span class=\'error-message\'>Enable cookies for this site </span>';">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="maincontainer">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="headercontainer">
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="wrapper">
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><div id=logo><span style="vertical-align:middle"></span></div>
                        <div id=relyonlogo><span style="vertical-align:middle"></span></div></td>
                    </tr>
                  </table></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="mainbg">
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="main">
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="wrapper">
      <tr>
        <td class="bannerbg" height="118">&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" id="youarehere">
  <tr>
    <td align="left"><img class="arrow" alt="arrow" 
src="./images/herearrow.gif" />
    <p>Welcome to Implementer Login</p></td>
  </tr>
</table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="23%" valign="top" style="border-bottom:#1f4f66 1px solid;" ><table width="100%" border="0" cellspacing="0" cellpadding="0" id="mainwrap">
        <tr><td><table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td align="center"><form id="submitform" name="submitform" method="post" action="">
                <table width="50%" border="0" cellspacing="0" cellpadding="5">
                  <tr>
                    <td colspan="2" ><div align="center" id="form-error" style="height:18px">
                      <noscript><div class="error-message"> Enable cookies/javscript/both in your browser,  then </div></noscript><?php if($message <> '') echo($message); ?>
                    </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">User Name:</td>
                    <td align="left" valign="top"><label>
                      <input name="username" type="text" class="swifttext" id="username" size="30" maxlength="40" value="<?php echo($dealerusername) ?>" />
                    </label></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">Password:</td>
                    <td align="left" valign="top"><input name="password" type="password" class="swifttext" id="password" size="30" maxlength="20" /></td>
                  </tr>
                  <tr>
                    <td colspan="2" valign="top"><div align="center">
  <input name="login" type="submit" class="swiftchoicebutton-red" id="login" value="Login"  onclick="checknavigatorproperties()" />
  &nbsp;&nbsp;&nbsp;
                      <input name="clear" type="reset" class="swiftchoicebutton-red" id="clear" value="Clear"  onClick="document.getElementById('form-error').innerHTML = ''; " />
                    </div></td>
                  </tr>
                  <tr>
                  <td colspan="2"><div align="center"><a href="update/retrivepwd.php" class="passwd-font">[Retrive Your Password]</a></div></td>
                  </tr>
                </table>
            </form></td>
          </tr>
        </table></td></tr></table></td></tr></table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" id="footer">
      <tr>
        <td align="left"><p>A product of Relyon Web Management | Copyright © 2012 Relyon Softech Ltd. All rights reserved.</p></td>
        <td align="left"><div align="right"><font color="#FFFFFF">Version 1.04</font></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</td>
</tr>
</table>
</td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
