<?php
	include('../inc/eventloginsert.php');
	$userid = imaxgetcookie('userslno');
	$query = "SELECT inv_mas_implementer.businessname AS businessname,inv_mas_implementer.contactperson AS contactperson,inv_mas_implementer.region AS region,inv_mas_implementer.address AS address,inv_mas_implementer.place AS place,inv_mas_district.districtname AS district,inv_mas_state.statename AS state,inv_mas_implementer.pincode AS pincode,inv_mas_implementer.stdcode AS stdcode,inv_mas_implementer.phone AS phone,inv_mas_implementer.cell AS cell,inv_mas_implementer.emailid AS emailid,inv_mas_implementer.website AS website FROM inv_mas_implementer LEFT JOIN inv_mas_district ON inv_mas_district.districtcode=inv_mas_implementer.district LEFT JOIN inv_mas_state on inv_mas_state.statecode = inv_mas_district.statecode WHERE inv_mas_implementer.slno  = '".$userid."';";
	$fetch = runmysqlqueryfetch($query);
	$businessname = $fetch['businessname'];
	$region = $fetch['region'];
	$contactperson = $fetch['contactperson'];
	$address = $fetch['address'];
	$place = $fetch['place'];
	$district = $fetch['district'];
	$state = $fetch['state'];
	$pincode = $fetch['pincode'];
	$stdcode = $fetch['stdcode'];
	$phone = $fetch['phone'];
	$cell = $fetch['cell'];
	$emailid = $fetch['emailid'];
	$website = $fetch['website'];
	$contactperson = $fetch['contactperson'];

 
?>
<!--[if lt IE 7]>
<script type="text/javascript" src="../functions/excanvas.compiled.js?dummy = <?php echo (rand());?>"></script>
<![endif]-->


<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td valign="top" style="border-right:#1f4f66 1px solid;border-bottom:#1f4f66 1px solid;" ><table width="100%" border="0" cellspacing="0" cellpadding="0" id="mainwrap">
        <tr>
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="2"></td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2"><div align="left"><strong style="font-size:16px; font-weight:bold" >Welcome <?php echo($businessname)?>....</strong></div></td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="padding-left:20px;padding-right:20px" ><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #308ebc; border-top:none;" align="center">
                          <tr>
                            <td class="header-line" style="padding:0">&nbsp;Your Profile:(<a href="./index.php?a_link=editprofile" class="editlink" ><font color="#000000">Edit</font></a>)</td>
                            <td align="right" class="header-line" style="padding-right:7px"></td>
                          </tr>
                          <tr>
                            <td colspan="2" valign="top"><div id="maindiv">
                                <form action="" method="post" name="submitform" id="submitform">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td class="content-box"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="35%" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="50%"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                                                            <tr>
                                                              <td width="27%" bgcolor="#EDF4FF"><div align="left">Business Name:</div></td>
                                                              <td width="73%" bgcolor="#f7faff"><div align="left"><?php echo($businessname);?></div></td>
                                                            </tr>
                                                            <tr>
                                                              <td bgcolor="#EDF4FF"><div align="left">Contact Person:</div></td>
                                                              <td bgcolor="#f7faff"><div align="left"><?php echo($contactperson);?></div></td>
                                                            </tr>
                                                            <tr>
                                                              <td bgcolor="#EDF4FF"><div align="left">Address:</div></td>
                                                              <td bgcolor="#f7faff"><div align="left"><?php echo($address);?></div></td>
                                                            </tr>
                                                            <tr>
                                                              <td bgcolor="#EDF4FF"><div align="left">Place:</div></td>
                                                              <td bgcolor="#f7faff"><div align="left"><?php echo($place);?></div></td>
                                                            </tr>
                                                            <tr>
                                                              <td bgcolor="#EDF4FF"><div align="left">Email:</div></td>
                                                              <td bgcolor="#f7faff"><div align="left"><?php echo($emailid);?></div></td>
                                                            </tr>
                                                          </table></td>
                                                        <td width="50%"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                                                            <tr>
                                                              <td width="18%" bgcolor="#EDF4FF"><div align="left">District:</div></td>
                                                              <td width="82%" bgcolor="#f7faff"><div align="left"><?php echo($district);?></div></td>
                                                            </tr>
                                                            <tr>
                                                              <td bgcolor="#EDF4FF"><div align="left">State:</div></td>
                                                              <td bgcolor="#f7faff"><div align="left"><?php echo($state);?></div></td>
                                                            </tr>
                                                            <tr>
                                                              <td bgcolor="#EDF4FF"><div align="left">Phone:</div></td>
                                                              <td bgcolor="#f7faff"><div align="left"><?php echo($phone);?></div></td>
                                                            </tr>
                                                            <tr>
                                                              <td bgcolor="#EDF4FF"><div align="left">Cell:</div></td>
                                                              <td bgcolor="#f7faff"><div align="left"><?php echo($cell);?></div></td>
                                                            </tr>
                                                            <tr>
                                                              <td bgcolor="#EDF4FF"><div align="left">Website:</div></td>
                                                              <td bgcolor="#f7faff"><div align="left"><?php echo($website);?></div></td>
                                                            </tr>
                                                          </table></td>
                                                      </tr>
                                                    </table></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                  </table>
                                </form>
                              </div></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2"></td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center"></td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
