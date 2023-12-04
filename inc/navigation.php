<?
	$userid = imaxgetcookie('userslno');
	$query = "select implementertype,coordinator,handhold from inv_mas_implementer where slno = '".$userid."'";
	$resultfetch = runmysqlqueryfetch($query);
	$implementertype = $resultfetch['implementertype'];
	$coordinator = $resultfetch['coordinator'];
	$handhold = $resultfetch['handhold'];
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><DIV class=navigation>
        <DIV>
          <UL class=sf-menu>
            <LI class=current><A href="./index.php?a_link=dashboard">Home</A> </LI>
            <LI><a>Implementation Process</a>
              <ul>
              	<? if($coordinator == 'yes') {?>
                <li><a href="./index.php?a_link=assignimplementation">Assign Implementation</a></li>
                <?  } if(($implementertype == 'implementer') || ($coordinator == 'yes')) { ?>
                <li><a href="./index.php?a_link=implementation">Implementation</a></li>
               <? if(($handhold == 'yes')) { ?><li><a href="./index.php?a_link=handholdprocess">Hand Hold</a></li> <? } ?>
                <? } if(($implementertype == 'customizer') || ($coordinator == 'yes')){ ?>
                <li><a href="./index.php?a_link=customization">Customization</a></li>
                <? } if(($implementertype == 'webmodule') || ($coordinator == 'yes')){ ?>
<!--                <li><a href="./index.php?a_link=custpayment">Web Implementation</a></li>
-->                <? } ?>
              </ul>
            </LI>
            <LI class=current><a>Reports</a>
              <ul>
                <!-- <li ><A ><span class="sf-menupointer" >Implementation</span></A>
                  <ul class="sf-menu"> -->
                    <li><a href="./index.php?a_link=implementationsummary">Implementation Summary</a></li>
                    <li><a href="./index.php?a_link=implementationdetailed">Implementation Detailed Report </a></li>
                    <? if(($handhold == 'yes')) { ?><li><a href="./index.php?a_link=handholddetailed">Hand Hold Detailed Report</a></li> <? } ?>
                  <!-- </ul>
                </li> -->
              </ul>
            </LI>
            <LI class=current><a>Profile</a>
              <ul>
                <li><a href="./index.php?a_link=editprofile">Edit Profile</a> </li>
                <li><a href="./index.php?a_link=changepassword">Change Password</a></li> 
            </LI>
            <LI class=current><a>Video</a>
              <ul>
                <li><a href="http://imax.relyonsoft.com/implementation/demo/" target="_blank">Video Tutorials</a> </li>
              </ul>
            </LI>
            <LI class=current><A href="../logout.php">Logout</A></LI>
          </UL>
          <DIV class=clear></DIV>
        </DIV>
      </DIV></td>
  </tr>
</table>
