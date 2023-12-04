<?php 
$userid = imaxgetcookie('userslno');
$query = "select implementertype,coordinator from inv_mas_implementer where slno = '".$userid."'";
$resultfetch = runmysqlqueryfetch($query);
$implementertype = $resultfetch['implementertype'];
$coordinator = $resultfetch['coordinator'];
if($implementertype == 'implementer' || $coordinator == 'yes')
{
include('../inc/eventloginsert.php');
?>
<link href="../style/style.css?dummy=<?php echo (rand());?>" rel=stylesheet>
<link media="screen" rel="stylesheet" href="../style/colorbox.css?dummy=<?php echo (rand());?>" />
<script language="javascript" src="../functions/handholdprocess.js?dummy=<?php echo (rand());?>"></script>
<script language="javascript" src="../functions/getdistrictfunction.php?dummy=<?php echo (rand());?>"></script>
<script language="javascript" src="../functions/javascript.js?dummy=<?php echo (rand());?>"></script>
<script language="javascript" src="../functions/datepickercontrol.js?dummy=<?php echo (rand());?>" type="text/javascript"></script>
<script language="javascript" src="../functions/fileupload.js?dummy=<?php echo (rand());?>" type="text/javascript"></script>
<script language="javascript" src="../functions/jquery.colorbox.js?dummy=<?php echo (rand());?>"></script>
<div style="left: -1000px; top: 597px;visibility: hidden; z-index:100" id="tooltip1">dummy</div>
<script language="javascript" src="../functions/tooltip.js?dummy=<?php echo (rand());?>"></script>
<table width="952" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="23%" valign="top" style="border-right:#1f4f66 1px solid;border-bottom:#1f4f66 1px solid; text-align:left" ><table width="100%" border="0" cellspacing="0" cellpadding="0" id="mainwrap">
        <tr>
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle" class="active-leftnav">Customer Selection</td>
              </tr>
              <tr>
                <td><form id="filterform" name="filterform" method="post" action="" onSubmit="return false;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="3">
                      <tr>
                        <td width="71%" height="34" id="customerselectionprocess" align="left" style="padding:1px">&nbsp;</td>
                        <td width="29%"  style="padding:0"><div class="resendtext"><a onclick="displayfilterdiv()" style="cursor:pointer">Filter>></a></div></td>
                      </tr>
                      <tr>
                        <td colspan="2"><div id="displayfilter" style="display:none">
                            <table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#f7faff" style=" border:1px solid #ADD8F1">
                              <tr>
                                <td width="28%" align="left" valign="top"><strong>Status:</strong><br /></td>
                                <td width="72%" align="left" valign="top"><select name="imp_status" class="swiftselect" id="imp_status"  style="width:140px;">
                                    <option value="">All</option>
                                    <option value="Assigned For Implementation">Assigned For Implementation</option>
                                    <option value="Implementation in progess">Implementation in progess</option>
                                    <option value="Implementation Completed">Implementation Completed</option>
                                  </select></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="28%" align="left" valign="top"><strong>Handhold:</strong><br /></td>
                                <td width="72%" align="left" valign="top"><select name="handhold" class="swiftselect" id="handhold"  style="width:140px;">
                                    <option value="">All</option>
                                    <?php include("../inc/imp-handholdtype.php"); ?>
                                </select></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td><div align="right" class="resendtext"><a onclick="searchbystatus();" style="cursor:pointer">Go&gt;&gt;</a></div></td>
                              </tr>
                            </table>
                          </div></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="left"><input name="detailsearchtext" type="text" class="swifttext" id="detailsearchtext"onKeyUp="customersearch(event);"  autocomplete="off" style="width:204px"/>
                          <div id="detailloadcustomerlist">
                            <select name="customerlist" size="5" class="swiftselect" id="customerlist" style="width:210px; height:400px" onclick ="selectfromlist();" onchange="selectfromlist();">
                            </select>
                          </div></td>
                      </tr>
                    </table>
                  </form></td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="45%" style="padding-left:10px;"><strong>Total Count:</strong></td>
                      <td width="55%" id="totalcount" align="left"></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    <td width="77%" valign="top" style="border-bottom:#1f4f66 1px solid;"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="mainwrap">
        <tr>
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
                          <tr>
                            <td width="27%" align="left" valign="middle" class="active-leftnav">Implementation</td>
                            <td width="40%"><div align="right"></div></td>
                            <!-- <td width="33%"><div align="right"><input name="search" type="submit" class="swiftchoicebuttonbig" id="search" value="Advanced Search"  onclick="displayDiv('filterdiv')"  /></div></td> -->
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td></td>
                    </tr>
                    <tr>
                      <td height="5"></td>
                    </tr>
                    <tr>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #308ebc; border-top:none;">
                      <tr>
                      <td colspan="2"><div id="filterdiv" style="display:none;">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #308ebc;">
                            <tr>
                              <td valign="top"><div>
                                  <form action="" method="post" name="searchfilterform" id="searchfilterform" onsubmit="return false;">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                      <tr>
                                        <td width="100%" align="left" class="header-line" style="padding:0">&nbsp;&nbsp;Search Option</td>
                                      </tr>
                                      <tr>
                                        <td valign="top" ><table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFD3A8" style="border:dashed 1px #545429">
                                            <tr>
                                              <td width="57%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="4" >
                                                  <tr>
                                                    <td colspan="4" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td width="9%" align="left" valign="middle">Text: </td>
                                                          <td width="91%" colspan="3" align="left" valign="top"><input name="searchcriteria" type="text" id="searchcriteria" size="35" maxlength="60" class="swifttext"  autocomplete="off" value=""/>
                                                            <span style="font-size:9px; color:#999999; padding:1px">(Leave Empty for all)</span></td>
                                                          <td>&nbsp;</td>
                                                        </tr>
                                                      </table></td>
                                                  </tr>
                                                  <tr>
                                                    <td colspan="2" style="padding:3px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td width="20%" style="padding-right:2px"><table width="100%" border="0" cellspacing="0" cellpadding="4" style="border:solid 1px #004000"  align="left">
                                                              <tr>
                                                                <td align="left"><strong>Look in:</strong></td>
                                                              </tr>
                                                              <tr>
                                                                <td align="left"><label>
                                                                    <input type="radio" name="databasefield" id="databasefield0" value="slno"/>
                                                                  </label>
                                                                  <label for="databasefield0">Customer ID</label></td>
                                                              </tr>
                                                              <tr>
                                                                <td align="left"><label>
                                                                    <input type="radio" name="databasefield" id="databasefield1" value="businessname" checked="checked"/>
                                                                  </label>
                                                                  <label for="databasefield1"> Business Name</label></td>
                                                              </tr>
                                                              <tr>
                                                                <td align="left"><label>
                                                                    <input type="radio" name="databasefield" value="contactperson" id="databasefield3" />
                                                                  </label>
                                                                  <label for="databasefield3">Contact Person</label></td>
                                                              </tr>
                                                              <tr>
                                                                <td align="left"><label>
                                                                    <input type="radio" name="databasefield" id="databasefield5" value="place" />
                                                                  </label>
                                                                  <label for="databasefield5"> Place</label></td>
                                                              </tr>
                                                              <tr>
                                                                <td align="left"><label>
                                                                    <input type="radio" name="databasefield" value="phone" id="databasefield4" />
                                                                  </label>
                                                                  <label for="databasefield4">Phone/ Cell</label></td>
                                                              </tr>
                                                              <tr>
                                                                <td align="left"><label>
                                                                    <input type="radio" name="databasefield" value="emailid" id="databasefield6" />
                                                                  </label>
                                                                  <label for="databasefield6">Email</label></td>
                                                              </tr>
                                                              <tr>
                                                                <td height="5"></td>
                                                              </tr>
                                                            </table></td>
                                                          <td width="39%" valign="top" style="border-left:1px solid #CCCCCC;"><table width="100%" border="0" cellspacing="0" cellpadding="6">
                                                              <tr>
                                                                <td width="35%">Region:</td>
                                                                <td width="65%"><select name="region2" class="swiftselect" id="region2" style="width:180px;">
                                                                    <option value="">ALL</option>
                                                                    <?php 
											include('../inc/region.php');
											?>
                                                                  </select></td>
                                                              </tr>
                                                              <tr>
                                                                <td>State:</td>
                                                                <td><select name="state2" class="swiftselect" id="state2" onchange="getdistrictfilter('districtcodedisplaysearch',this.value);" onkeyup="getdistrictfilter('districtcodedisplaysearch',this.value);" style="width:180px;">
                                                                    <option value="">ALL</option>
                                                                    <?php include('../inc/state.php'); ?>
                                                                  </select></td>
                                                              </tr>
                                                              <tr>
                                                                <td>District:</td>
                                                                <td align="left" valign="top"  id="districtcodedisplaysearch" height="10" ><select name="district2" class="swiftselect" id="district2" style="width:180px;">
                                                                    <option value="">ALL</option>
                                                                  </select></td>
                                                              </tr>
                                                              <tr>
                                                                <td>Dealer:</td>
                                                                <td align="left" valign="top"   height="10"><select name="currentdealer2" class="swiftselect" id="currentdealer2" style="width:180px;">
                                                                    <option value="">ALL</option>
                                                                    <?php include('../inc/firstdealer.php');?>
                                                                  </select></td>
                                                              </tr>
                                                              <tr>
                                                                <td>Branch:</td>
                                                                <td align="left" valign="top"   height="10" ><select name="branch2" class="swiftselect" id="branch2" style="width:180px;">
                                                                    <option value="">ALL</option>
                                                                    <?php include('../inc/branch.php');?>
                                                                  </select></td>
                                                              </tr>
                                                              <tr>
                                                                <td>Type:</td>
                                                                <td align="left" valign="top"   height="10" ><select name="type2" class="swiftselect" id="type2" style="width:180px;">
                                                                    <option value="">ALL</option>
                                                                    <option value="Not Selected">Not Selected</option>
                                                                    <?php include('../inc/custype.php');?>
                                                                  </select></td>
                                                              </tr>
                                                              <tr>
                                                                <td>Category:</td>
                                                                <td align="left" valign="top"   height="10" ><select name="category2" class="swiftselect" id="category2" style="width:180px;">
                                                                    <option value="">ALL</option>
                                                                    <option value="Not Selected">Not Selected</option>
                                                                    <?php include('../inc/category.php');?>
                                                                  </select></td>
                                                              </tr>
                                                                <tr>
                                                                                      <td>Implementer:</td>
                                                                                      <td align="left" valign="top"   height="10"><select name="implementer" class="swiftselect" id="implementer" style="width:180px;">
                                                                                          <option value="">ALL</option>
                                                                                          <?php include('../inc/implementer.php');?>
                                                                                        </select></td>
                                                                                    </tr>
                                                              
                                                                                  </table></td>
                                                                                  <!-- <td width="39%" valign="top" style="border-left:1px solid #CCCCCC;padding-left:6px"><table width="96%" border="0" cellspacing="0" cellpadding="2" >
                                                                                    <tr>
                                                                                      <td colspan="3" valign="top" style="padding:0"></td>
                                                                                    </tr>
                                                                                    <tr >
                                                                                      <td colspan="3" valign="top" align="left"><strong>Status</strong></td>
                                                                                    </tr >
                                                                                    <tr >
                                                                                      <td colspan="3" valign="top" align="left" bgcolor="#FFFFFF" style="border:solid 1px #A8A8A8"><div style="height:90px; overflow:auto">
                                                                                          <input checked="checked" type="checkbox" name="summarize[]" id="status3" value="status3"/>
                                                                                          <label for="status3">Awaiting Co-ordinator Approval</label>
                                                                                          <br />
                                                                                          <input checked="checked" type="checkbox" name="summarize[]" id="status4" value="status4"/>
                                                                                          <label for="status4">Fowarded back to Branch Head</label>
                                                                                          <br />
                                                                                          <input checked="checked" type="checkbox" name="summarize[]" id="status5" value="status5" />
                                                                                          <label for="status5">Implementation, Yet to be Assigned</label>
                                                                                          <br />
                                                                                          <input checked="checked" type="checkbox" name="summarize[]" id="status6" value="status6"/>
                                                                                          <label for="status6"> Assigned For Implementation</label>
                                                                                          <br />
                                                                                          <input checked="checked" type="checkbox" name="summarize[]" id="status7" value="status7"/>
                                                                                          <label for="status7">Implementation in progess</label>
                                                                                          <br />
                                                                                          <input checked="checked" type="checkbox" name="summarize[]" id="status8" value="status8"/>
                                                                                          <label for="status8"> Implementation Completed</label>
                                                                                      </div></td>
                                                                                    </tr>
                                                                                    <tr><td colspan="2" height="3px"></td></tr>
                                                                                    <tr >
                                                                                      <td width="9%"  valign="top"><input type="checkbox" name="selectstatus" id="selectstatus" checked="checked" onchange="selectdeselectcommon('selectstatus','summarize[]')" /></td>
                                                                                      <td width="91%" align="left" valign="top"><label for="selectstatus">Select All / None</label></td>
                                                                                    </tr>
                                                                                  </table></td> -->
                                                                                </tr>
                                                                              </table></td>
                                                                          </tr>
                                                  <tr>
                                                    <td width="55%" height="35" align="left" valign="middle"  ><div id="filter-form-error"></div></td>
                                                    <td width="45%" align="left" valign="middle"  ><input name="filter" type="button" class="swiftchoicebutton-red" id="filter" value="Search" onclick="advancesearch();" />
                                                      &nbsp;
                                                      <input type="button" name="reset_form" value="Reset" class="swiftchoicebutton" onclick="resetDefaultValues(this.form);">
                                                      &nbsp;
                                                      <input name="close" type="button" class="swiftchoicebutton" id="close" value="Close" onclick="document.getElementById('filterdiv').style.display='none';" /></td>
                                                  </tr>
                                                </table></td>
                                            </tr>
                                          </table></td>
                                      </tr>
                                      <tr>
                                        <td align="right" valign="middle" style="padding-right:15px; border-top:1px solid #d1dceb;"></td>
                                      </tr>
                                    </table>
                                  </form>
                                </div></td>
                            </tr>
                          </table>
                        </div></td>
                    </tr>
                          <tr>
                            <td align="left" class="header-line" style="padding:0">&nbsp;&nbsp;Enter / Edit / View Details </td>
                            <td align="right" class="header-line" style="padding-right:7px"></td>
                          </tr>
                          <tr>
                            <td colspan="2" valign="top"><div id="maindiv">
                                <form action="" method="post" name="submitform" id="submitform" onsubmit="return false;">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                <tr>
                                                  <td colspan="10" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6"  bgcolor="#FFFFF0">
                                                      <tr style="height:35px;"  bgcolor="#D6D6D6" >
                                                        <td width="17%" style="padding-left:8px;" valign="middle"><strong>Company Name:</strong></td>
                                                        <td width="78%" bgcolor="#D6D6D6" id="displaycompanyname" style="padding-left:8px;"  valign="middle"><span style="padding-right:10px"> </span></td>
                                                        <td width="5%" style="padding-right:10px;"><div align="right"><img src="../images/plus.jpg" border="0" id="toggleimg1" name="toggleimg1"  align="absmiddle" onclick="divdisplay('displaycustomerdetails','toggleimg1');" style="cursor:pointer"/></div></td>
                                                      </tr>
                                                      <tr>
                                                        <td colspan="3" valign="top" ><div id="displaycustomerdetails" style="display:none;">
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="4" align="center" >
                                                              <tr>
                                                                <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                    <tr>
                                                                      <td width="41%"><strong>Customer ID: </strong></td>
                                                                      <td id="displaycustomerid">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td><strong>Contact Person: </strong></td>
                                                                      <td id="displaycontactperson" >&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td valign="top"><strong>Address: </strong></td>
                                                                      <td  id="displayaddress" >&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td><strong>Email: </strong></td>
                                                                      <td  id="displayemail" >&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td ><strong>Phone: </strong></td>
                                                                      <td id="displayphone">&nbsp;</td>
                                                                    </tr>
                                                                  </table></td>
                                                                <td width="54%" colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                    <tr>
                                                                      <td ><strong>Cell: </strong></td>
                                                                      <td id="displaycell">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td width="49%"><strong>Relyon Representative: </strong></td>
                                                                      <td width="51%"  id="displaydealer">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td><strong>Region: </strong></td>
                                                                      <td id="displayregion">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td><strong>Branch: </strong></td>
                                                                      <td id="displaybranch">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td><strong>Type of Customer: </strong></td>
                                                                      <td  id="displaytypeofcustomer">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td><strong>Type of Category: </strong></td>
                                                                      <td  id="displaytypeofcategory">&nbsp;</td>
                                                                    </tr>
                                                                  </table></td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="4" valign="top"></td>
                                                                <td colspan="2"></td>
                                                              </tr>
                                                            </table>
                                                          </div></td>
                                                      </tr>
                                                    </table></td>
                                                </tr>
                                                <tr>
                                                  <td colspan="10" height="5px;"></td>
                                                </tr>
                                                <tr>
                                                  <td width="2%" height="25" class="producttabheadnone"></td>
                                                  <td width="18%" onclick="tabopen2('1','tabg1')" class="producttabheadactive" id="tabg1h1" style="cursor:pointer;"><div align="center"><strong>Implementation</strong></div></td>
                                                  <td width="1%" class="producttabheadnone"></td>
                                                  <td width="24%" onclick="tabopen2('2','tabg1')" class="producttabhead" id="tabg1h2" style="cursor:pointer;"><div align="center"><strong>HandHold Process</strong></div></td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                          <tr>
                                            <td><div style="display:block; "  align="justify" id="tabg1c1" >
                                                <table width="100%" border="0" cellspacing="0" cellpadding="2" class="productcontent" height="350px">
                                                  <tr>
                                                    <td width="40%"  height="35px;"><div id="loadingdiv"><span  style="padding-left:25px"><strong><font color="#FF0000">Select A Customer</font></strong> </span></div></td>
                                                    <td width="60%">&nbsp;</td>
                                                  </tr>
                                                  
                                                  <tr>
                                                    <td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <!-added from here -->
                                                  <tr>
                                                          <td ><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6" >
                                                              <tr style="height:25px;"  bgcolor="#D6D6D6" >
                                                                <td width="42%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>Type Of Implemantation</strong></td>
                                                                <td width="53%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;">&nbsp;</td>
                                                                <td width="5%" style="padding-right:10px;">&nbsp;</td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="3" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="4" align="center" >
                                                                    <tr>
                                                                      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                          <tr>
                                                                            <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                                <tr >
                                                                                  <td width="20%" bgcolor="#EDF4FF" style="padding-left:5px">Implemantation Type:</td>
                                                                                  <td width="80%" bgcolor="#EDF4FF" id="imp_statustype"style="color:#FF0000">Not Available</td>
                                                                                </tr>
                                                                                <tr>
                                                                                  <td colspan="2" ><div id="displayimpremarks">
                                                                                      <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                                        <tr bgcolor="#f7faff">
                                                                                          <td width="112"  align="left" valign="top" bgcolor="#f7faff">Remarks :</td>
                                                                                          <td width="594" align="left" valign="top" bgcolor="#f7faff" id="imptype_remarks">Not Available</td>
                                                                                        </tr>
                                                                                      </table>
                                                                                    </div></td>
                                                                                </tr>
                                                                              </table></td>
                                                                          </tr>
                                                                        </table></td>
                                                                    </tr>
                                                                  </table></td>
                                                              </tr>
                                                              <tr>
                                                                <td  colspan="3"></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                        <tr>
                                                          <td >&nbsp;</td>
                                                        </tr>
                                                  <!-end -->
                                                        <tr>
                                                          <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6">
                                                          
                                                              <tr style="height:25px;"  bgcolor="#D6D6D6" >
                                                                <td width="23%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>1.Invoice Information</strong></td>
                                                                <td width="72%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;"><span class="header-line" style="padding:0">
                                                                  <input type="hidden" name="lastslno" id="lastslno"/>
                                                                  <input type="hidden" name="implastslno" id="implastslno"/>
                                                                  <input type="hidden" name="impreflastslno" id="impreflastslno"/>
                                                                  <input type="hidden" name="impcustomizationlastslno" id="impcustomizationlastslno"/>
                                                                  <input type="hidden" name="impfilepath" id="impfilepath"/>
                                                                  <input type="hidden" id="implementationslno" name="implementationslno"/>
                                                                  </span></td>
                                                                <td width="5%" style="padding-right:10px;">&nbsp;</td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="3" valign="top" ><div id="displayinvoicedetails" style="display:block;">
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="4" align="center" >
                                                                      <tr>
                                                                        <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="4" >
                                                                            <tr >
                                                                              <td width="23%"><strong> Invoice Details: </strong></td>
                                                                              <td width="38%" id="invoicedetails">Not Available</td>
                                                                              <td width="39%" >&nbsp;</td>
                                                                            </tr>
                                                                            <tr >
                                                                              <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="4" id="invoicedetailsgrid">
                                                                                </table></td>
                                                                            </tr>
                                                                          </table></td>
                                                                      </tr>
                                                                    </table>
                                                                  </div></td>
                                                              </tr>
                                                              <tr>
                                                                <td  colspan="3"></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                        <tr>
                                                          <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                          <td ><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6"  >
                                                              <tr style="height:25px;"  bgcolor="#D6D6D6" >
                                                                <td width="26%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>2. Payment information</strong></td>
                                                                <td width="69%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;">&nbsp;</td>
                                                                <td width="5%" style="padding-right:10px;">&nbsp;</td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="3" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                      <td width="50%" valign="top" style="border-right:solid 1px #B7DBFF"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                          <tr >
                                                                            <td width="50%" bgcolor="#f7faff" style="padding-left:5px">Advance Collected:</td>
                                                                            <td width="50%" bgcolor="#f7faff" id="collectedamt" style=" color:#FF0000">Not Available</td>
                                                                          </tr>
                                                                          <tr>
                                                                            <td colspan="2" ><div id="displaypayment" >
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                                  <tr bgcolor="#EDF4FF">
                                                                                    <td width="21%" align="left" valign="top">Amount:</td>
                                                                                    <td width="79%" align="left" valign="top" bgcolor="#EDF4FF"  id="paymentamt">Not Available</td>
                                                                                  </tr>
                                                                                  <tr bgcolor="#f7faff">
                                                                                    <td align="left" valign="top" bgcolor="#f7faff">Remarks:</td>
                                                                                    <td align="left" valign="top" bgcolor="#f7faff" id="paymentremarks">Not Available</td>
                                                                                  </tr>
                                                                                </table>
                                                                              </div></td>
                                                                          </tr>
                                                                        </table></td>
                                                                      <td width="50%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                          <tr bgcolor="#EDF4FF">
                                                                            <td width="48%" align="left" valign="top" bgcolor="#EDF4FF">Balance Recovery Schedule:</td>
                                                                            <td width="52%" align="left" valign="top" bgcolor="#EDF4FF" id="balancerecovery">Not Available</td>
                                                                          </tr>
                                                                        </table></td>
                                                                    </tr>
                                                                  </table></td>
                                                              </tr>
                                                              <tr>
                                                                <td  colspan="3"></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                        <tr>
                                                          <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                          <td ><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6"   >
                                                              <tr style="height:25px;"  bgcolor="#D6D6D6" >
                                                                <td width="35%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>3.	Requirement Analysis Format</strong></td>
                                                                <td width="60%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;">&nbsp;</td>
                                                                <td width="5%" style="padding-right:10px;">&nbsp;</td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="3" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="4" align="center" >
                                                                    <tr>
                                                                      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                          <tr bgcolor="#edf4ff">
                                                                            <td width="22%" valign="top">Attachment 's Of RAF:</td>
                                                                            <td valign="top" bgcolor="#edf4ff">&nbsp;</td>
                                                                            <td valign="top" bgcolor="#edf4ff" >&nbsp;</td>
                                                                          </tr>
                                                                          <tr>
                                                                            <td colspan="3"  id="attachement_raffilename"></td>
                                                                          </tr>
                                                                        </table></td>
                                                                    </tr>
                                                                  </table></td>
                                                              </tr>
                                                              <tr>
                                                                <td  colspan="3"></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                        <tr>
                                                          <td >&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                          <td ><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6; text-align: right;" >
                                                              <tr style="height:25px;"  bgcolor="#D6D6D6" >
                                                                <td width="26%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>4.	Sales Person Inputs</strong></td>
                                                                <td width="69%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;">&nbsp;</td>
                                                                <td width="5%" style="padding-right:10px;">&nbsp;</td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="3" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="4" align="center" >
                                                                    <tr>
                                                                      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                          <tr bgcolor="#EDF4FF">
                                                                            <td align="left" valign="top" bgcolor="#f7faff">PO Number and Date :</td>
                                                                            <td colspan="2" align="left" valign="top" bgcolor="#f7faff" id="podate">Not Available</td>
                                                                          </tr>
                                                                          <tr bgcolor="#EDF4FF">
                                                                            <td width="36%" align="left" valign="top" bgcolor="#EDF4FF">PO Uploads :</td>
                                                                            <td width="50%" align="left" valign="top" bgcolor="#EDF4FF" id="pouploadlink_filename">Not Available</td>
                                                                            <td width="14%" align="right" valign="top" bgcolor="#EDF4FF" id="pouploadlink_errorfile">&nbsp;</td>
                                                                          </tr>
                                                                          <tr bgcolor="#EDF4FF">
                                                                            <td align="left" valign="top" bgcolor="#f7faff">Number of Companies to be processed :</td>
                                                                            <td colspan="2" align="left" valign="top" bgcolor="#f7faff" id="sales_company">Not Available</td>
                                                                          </tr>
                                                                          <tr bgcolor="#EDF4FF">
                                                                            <td align="left" valign="top" bgcolor="#EDF4FF">Number of Months to be processed  :</td>
                                                                            <td colspan="2" align="left" valign="top" bgcolor="#EDF4FF" id="sales_tomonths">Not Available</td>
                                                                          </tr>
                                                                          <tr bgcolor="#EDF4FF">
                                                                            <td align="left" valign="top" bgcolor="#f7faff">Processing from month  :</td>
                                                                            <td colspan="2" align="left" valign="top" bgcolor="#f7faff" id="sales_frommonth">Not Available</td>
                                                                          </tr>
                                                                          <tr bgcolor="#EDF4FF">
                                                                            <td align="left" valign="top" bgcolor="#EDF4FF">Additional Training Commitment:</td>
                                                                            <td colspan="2" align="left" valign="top" bgcolor="#EDF4FF"  id="sales_training">Not Available</td>
                                                                          </tr>
                                                                          <tr bgcolor="#EDF4FF">
                                                                            <td align="left" valign="top" bgcolor="#f7faff">Commitment of Start date:</td>
                                                                            <td colspan="2" align="left" valign="top" bgcolor="#f7faff"  id="sales_commitdate">Not Available</td>
                                                                          </tr>
                                                                          <tr bgcolor="#EDF4FF">
                                                                            <td align="left" valign="top" bgcolor="#EDF4FF">Any Free Deliverables:</td>
                                                                            <td colspan="2" align="left" valign="top" bgcolor="#EDF4FF"  id="sales_deliver">Not Available</td>
                                                                          </tr>
                                                                          <tr bgcolor="#EDF4FF">
                                                                            <td align="left" valign="top" bgcolor="#f7faff">Any Scheme Applicable:</td>
                                                                            <td colspan="2" align="left" valign="top" bgcolor="#f7faff" id="sales_scheme" >Not Available</td>
                                                                          </tr>
                                                                          <tr bgcolor="#EDF4FF">
                                                                            <td colspan="3" align="left" valign="top" bgcolor="#f7faff"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                                <tr >
                                                                                  <td width="29%" bgcolor="#EDF4FF" style="padding-left:5px">Master data in Excel by Relyon: </td>
                                                                                  <td width="71%" bgcolor="#EDF4FF" id="sales_masterdata"style="color:#FF0000">Not Available</td>
                                                                                </tr>
                                                                                <tr>
                                                                                  <td colspan="2"><div id="displaymasterdata" >
                                                                                      <table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                                        <tr bgcolor="#f7faff">
                                                                                          <td width="34%" align="left" valign="top">Number of Employees to be Entered:</td>
                                                                                          <td width="66%" align="left" valign="top" bgcolor="#f7faff" id="sales_noofemployee">&nbsp;</td>
                                                                                        </tr>
                                                                                      </table>
                                                                                    </div></td>
                                                                                </tr>
                                                                              </table></td>
                                                                          </tr>
                                                                          <tr bgcolor="#EDF4FF">
                                                                            <td align="left" valign="top" bgcolor="#f7faff">Commitments of Sales Person:</td>
                                                                            <td colspan="2" align="left" valign="top" bgcolor="#f7faff" id="sales_remarks">Not Available</td>
                                                                          </tr>
                                                                        </table></td>
                                                                    </tr>
                                                                  </table></td>
                                                              </tr>
                                                              <tr>
                                                                <td  colspan="3"></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                        <tr>
                                                          <td >&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                          <td ><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6" >
                                                              <tr style="height:25px;"  bgcolor="#D6D6D6" >
                                                                <td width="42%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>5. Attendance Integration Information</strong></td>
                                                                <td width="53%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;">&nbsp;</td>
                                                                <td width="5%" style="padding-right:10px;">&nbsp;</td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="3" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="4" align="center" >
                                                                    <tr>
                                                                      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                          <tr >
                                                                            <td width="32%" bgcolor="#f7faff" style="padding-left:5px">Attendance  Integration applicable:</td>
                                                                            <td width="68%" bgcolor="#f7faff" id="attendance" style="color:#FF0000">Not Available</td>
                                                                          </tr>
                                                                          <tr>
                                                                            <td colspan="2" ><div id="displayattendance" >
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                                  <tr bgcolor="#f7faff">
                                                                                    <td width="22%" align="left" valign="top" bgcolor="#f7faff">Vendor Details :</td>
                                                                                    <td colspan="3" align="left" valign="top" bgcolor="#f7faff"  id="attendance_vendor">Not Available</td>
                                                                                  </tr>
                                                                                  <tr bgcolor="#edf4ff">
                                                                                    <td colspan="4" ><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                                                        <tr>
                                                                                          <td width="22%" valign="top">Reference File :</td>
                                                                                          <td width="64%" valign="top" bgcolor="#edf4ff" id="attendance_errorfilename">Not Available</td>
                                                                                          <td width="14%"   align="right"  valign="top" bgcolor="#EDF4FF" id="attendance_errorfile" colspan="2" ></td>
                                                                                        </tr>
                                                                                      </table></td>
                                                                                  </tr>
                                                                                </table>
                                                                              </div></td>
                                                                          </tr>
                                                                        </table></td>
                                                                    </tr>
                                                                  </table></td>
                                                              </tr>
                                                              <tr>
                                                                <td  colspan="3"></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                        <tr>
                                                          <td >&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                          <td ><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6"  >
                                                              <tr style="height:25px;"  bgcolor="#D6D6D6" >
                                                                <td width="42%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>6. Add- On Modules</strong></td>
                                                                <td width="53%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;">&nbsp;</td>
                                                                <td width="5%" style="padding-right:10px;">&nbsp;</td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="3" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="4" align="center" >
                                                                    <tr>
                                                                      <td colspan="3"><div id="addondiv">
                                                                          <table width="100%" border="0" cellspacing="0"  cellpadding="3" id="seletedaddongrid" class="table-border-grid" >
                                                                            <tr class="tr-grid-header">
                                                                              <td width="11%" nowrap = "nowrap" class="td-border-grid" align="left">Slno</td>
                                                                              <td width="30%" nowrap = "nowrap" class="td-border-grid" align="left">Add - On</td>
                                                                              <td width="46%" nowrap = "nowrap" class="td-border-grid" align="left">Remarks</td>
                                                                            </tr>
                                                                            <tr>
                                                                              <td colspan="4" class="td-border-grid" id="messagerow"><div align="center"><font color="#FF0000"><strong>No Records Available</strong></font></div></td>
                                                                            </tr>
                                                                          </table>
                                                                        </div></td>
                                                                    </tr>
                                                                  </table></td>
                                                              </tr>
                                                              <tr>
                                                                <td  colspan="3"></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                        <tr>
                                                          <td >&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                          <td ><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6" >
                                                              <tr style="height:25px;"  bgcolor="#D6D6D6" >
                                                                <td width="42%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>7. Shipment Details</strong></td>
                                                                <td width="53%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;">&nbsp;</td>
                                                                <td width="5%" style="padding-right:10px;">&nbsp;</td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="3" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="4" align="center" >
                                                                    <tr>
                                                                      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                          <tr>
                                                                            <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                                <tr >
                                                                                  <td width="4%" bgcolor="#EDF4FF" style="padding-left:5px">Invoice:</td>
                                                                                  <td width="96%" bgcolor="#EDF4FF" id="shipment_invoice"style="color:#FF0000">Not Available</td>
                                                                                </tr>
                                                                                <tr>
                                                                                  <td colspan="2" ><div id="displayshipmentinvoice">
                                                                                      <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                                        <tr bgcolor="#f7faff">
                                                                                          <td width="112"  align="left" valign="top" bgcolor="#f7faff">Remarks :</td>
                                                                                          <td width="594" align="left" valign="top" bgcolor="#f7faff" id="shipment_remarks">Not Available</td>
                                                                                        </tr>
                                                                                      </table>
                                                                                    </div></td>
                                                                                </tr>
                                                                              </table></td>
                                                                          </tr>
                                                                        </table></td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                          <tr>
                                                                            <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                                <tr >
                                                                                  <td width="5%" bgcolor="#EDF4FF" style="padding-left:5px">Manual:</td>
                                                                                  <td width="100%" bgcolor="#EDF4FF" id="shipment_manual"style="color:#FF0000">Not Available</td>
                                                                                </tr>
                                                                                <tr>
                                                                                  <td colspan="2" ><div id="displayshipmentmanual"  >
                                                                                      <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                                        <tr bgcolor="#f7faff">
                                                                                          <td width="112" align="left" valign="top" bgcolor="#f7faff">Remarks :</td>
                                                                                          <td width="593" align="left" valign="top" bgcolor="#f7faff" id="manual_remarks">Not Available</td>
                                                                                        </tr>
                                                                                      </table>
                                                                                    </div></td>
                                                                                </tr>
                                                                              </table></td>
                                                                          </tr>
                                                                        </table></td>
                                                                    </tr>
                                                                  </table></td>
                                                              </tr>
                                                              <tr>
                                                                <td  colspan="3"></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                        <tr>
                                                          <td >&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                          <td ><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6">
                                                              <tr style="height:25px;"  bgcolor="#D6D6D6" >
                                                                <td width="42%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>8. Customization Details</strong></td>
                                                                <td width="53%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;">&nbsp;</td>
                                                                <td width="5%" style="padding-right:10px;">&nbsp;</td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="3" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                    <tr >
                                                                      <td width="41%" bgcolor="#f7faff" style="padding-left:5px">Customization  applicable along with purchase </td>
                                                                      <td width="59%" bgcolor="#f7faff" id="customization" style="color:#FF0000">Not Available</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td colspan="2" ><div id="displaycustomization" style="display:block" >
                                                                          <table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                            <tr bgcolor="#f7faff">
                                                                              <td width="22%" align="left" valign="top" bgcolor="#f7faff">Customization Remarks:</td>
                                                                              <td colspan="2" align="left" valign="top" bgcolor="#f7faff"  id="customization_remarks">Not Available</td>
                                                                            </tr>
                                                                            <tr bgcolor="#edf4ff">
                                                                              <td valign="top">References Files:</td>
                                                                              <td width="69%" valign="top" bgcolor="#edf4ff" id="customization_referencesfilename">Not Available</td>
                                                                              <td width="9%" valign="top" bgcolor="#edf4ff" id="customization_references">&nbsp;</td>
                                                                            </tr>
                                                                            <tr bgcolor="#edf4ff">
                                                                              <td valign="top" bgcolor="#f7faff">SPP Data Backup:</td>
                                                                              <td valign="top" bgcolor="#f7faff" id="customization_sppdatafilename">Not Available</td>
                                                                              <td valign="top" bgcolor="#f7faff" id="customization_sppdata">&nbsp;</td>
                                                                            </tr>
                                                                            <tr bgcolor="#edf4ff">
                                                                              <td valign="top" bgcolor="#edf4ff">Current Status:</td>
                                                                              <td colspan="2" valign="top" bgcolor="#edf4ff" id="customizationstatus">Pending</td>
                                                                            </tr>
                                                                            <tr bgcolor="#f7faff">
                                                                              <td colspan="3" valign="top" bgcolor="#edf4ff">Delivered Files:</td>
                                                                            </tr>
                                                                            <tr bgcolor="#f7faff">
                                                                              <td colspan="3" valign="top" bgcolor="#f7faff"><div id="tabgroupgridc1_2" align="center">
                                                                                  <table width="100%" cellpadding="5" cellspacing="0" class="table-border-grid">
                                                                                    <tr class="tr-grid-header" align ="left">
                                                                                      <td nowrap = "nowrap" class="td-border-grid" >Sl No</td>
                                                                                      <td nowrap = "nowrap" class="td-border-grid">Remarks</td>
                                                                                      <td nowrap = "nowrap" class="td-border-grid">Downloadlink</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                      <td align="center" class="td-border-grid" colspan="3"><font color="#FF4F4F"><strong>No Records Records</strong></font>
                                                                                        <div></div></td>
                                                                                    </tr>
                                                                                  </table>
                                                                                </div></td>
                                                                            </tr>
                                                                          </table>
                                                                        </div>
                                                                        <div id="displayadddetails" style="display:none">
                                                                          <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                                            <tr>
                                                                              <td width="29%" bgcolor="#EDF4FF">To add Customization </td>
                                                                              <td width="71%" bgcolor="#EDF4FF" ><a onclick="opencustcolorbox()" class = "r-text" style="text-decoration:none"> Click here &rsaquo;&rsaquo;</a></td>
                                                                            </tr>
                                                                          </table>
                                                                        </div></td>
                                                                    </tr>
                                                                  </table></td>
                                                              </tr>
                                                              <tr>
                                                                <td  colspan="3"></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                        <tr>
                                                          <td >&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                          <td ><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6">
                                                              <tr style="height:25px;"  bgcolor="#D6D6D6" >
                                                                <td width="42%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>9. Web Implementation Details</strong></td>
                                                                <td width="53%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;">&nbsp;</td>
                                                                <td width="5%" style="padding-right:10px;">&nbsp;</td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="3" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="4" align="center" >
                                                                    <tr>
                                                                      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                          <tr >
                                                                            <td width="29%" bgcolor="#EDF4FF" style="padding-left:5px">Web  Implementation applicable: </td>
                                                                            <td width="71%" bgcolor="#EDF4FF" id="web_implementation" style="color:#FF0000">Not Available</td>
                                                                          </tr>
                                                                          <tr>
                                                                            <td colspan="2" ><div id="displaywebimplementation"  >
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                                  <tr bgcolor="#f7faff">
                                                                                    <td width="112" align="left" valign="top" bgcolor="#f7faff">Remarks :</td>
                                                                                    <td width="593" align="left" valign="top" bgcolor="#f7faff"  id="web_remarks">Not Available</td>
                                                                                  </tr>
                                                                                </table>
                                                                              </div></td>
                                                                          </tr>
                                                                        </table></td>
                                                                    </tr>
                                                                  </table></td>
                                                              </tr>
                                                              <tr>
                                                                <td  colspan="3"></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                        <tr></tr>
                                                        <tr>
                                                          <td >&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                          <td ><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6" >
                                                              <tr style="height:25px;"  bgcolor="#D6D6D6" >
                                                                <td width="42%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>10. Implementation Status</strong></td>
                                                                <td width="53%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;">&nbsp;</td>
                                                                <td width="5%" style="padding-right:10px;">&nbsp;</td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="3" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="4" align="center" >
                                                                    <tr>
                                                                      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="4" align="center" >
                                                                          <tr>
                                                                            <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                                <tr>
                                                                                  <td width="119" valign="top" bgcolor="#edf4ff">Current Status :</td>
                                                                                  <td width="266" valign="top" bgcolor="#edf4ff" id="implementationid">Pending.</td>
                                                                                  <td width="315" valign="top" bgcolor="#edf4ff" ><span id="assigndiv" style="display:none"><img src="../images/help-image.gif" alt="" style="cursor:pointer"  onmouseover="tooltip()" onmouseout="hidetooltip()" /></span>
                                                                                    <input type="hidden" name="assignid" id="assignid" /></td>
                                                                                </tr>
                                                                                <tr>
                                                                                  <td colspan="3" valign="top" bgcolor="#f7faff"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                                                      <tr>
                                                                                        <td width="29%"  id="remarksname" align="left">&nbsp;</td>
                                                                                        <td width="71%" id="implementationremarks" align="left">&nbsp;</td>
                                                                                      </tr>
                                                                                      <tr id="advdisplay" style="display:none">
                                                                                        <td width="29%" align="left">Advance Collected Remarks: </td>
                                                                                        <td width="71%" id="advremarksid" align="left">&nbsp;</td>
                                                                                      </tr>
                                                                                    </table></td>
                                                                                </tr>
                                                                              </table></td>
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
                                              </div>
                                              <div style="display:none;" align="justify" id="tabg1c2">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                  <tr>
                                                    <td ><table width="100%" border="0" cellspacing="0" cellpadding="5" id="visitrowdisplay">
                                                        <tr>
                                                          <td width="28%"><strong>Select a Visit Details</strong>: </td>
                                                          <td width="29%" id="griddetails"><select name="activitygrid" class="swiftselect" id="activitygrid" style="width:200px;">
                                                              <option value="" selected="selected">-- Select --</option>
                                                            </select></td>
                                                          <td width="43%" ><a class="r-text" onClick="visitsgridtoform();">Go &#8250;&#8250;</a></td>
                                                        </tr>
                                                      </table></td>
                                                  </tr>
                                                  <tr>
                                                    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
                                                        <tr>
                                                          <td height="2px"></td>
                                                        </tr>
                                                        <tr>
                                                          <td><div class="imp_title_bar"  >
                                                              <div class="imp_rounder" ></div>
                                                              <span>Visit Start Information</span></div></td></tr>
                                                             <tr>
                                                          <td><div class="imp_dashboard_module" >
                                                              <table width="100%" border="0" cellspacing="0" cellpadding="4" >
                                                                <tr>
                                                                  <td width="49%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3" >
                                                                      <tr >
                                                                        <td width="32%">Assigned Date:</td>
                                                                        <td width="68%" height="15" id="assigneddate" >&nbsp;</td>
                                                                      </tr>
                                                                      <tr >
                                                                        <td >Visited Date:</td>
                                                                        <td ><input name="DPC_attachfromdate1" type="text" class="swifttext-mandatory" id="DPC_attachfromdate1" size="27" autocomplete="off" value="<?php echo(datetimelocal('d-m-Y')); ?>" readonly="readonly"/></td>
                                                                      </tr>
                                                                    </table></td>
                                                                  <td width="51%"><table width="100%" border="0" cellspacing="0" cellpadding="3" >
                                                                      <tr >
                                                                        <td width="27%">&nbsp;</td>
                                                                        <td colspan="3">&nbsp;</td>
                                                                      </tr>
                                                                      <tr >
                                                                        <td >Start Time:</td>
                                                                        <td width="18%"  ><SELECT id="starttimehr" style="width:50px;"  >
                                                                            <OPTION value="" SELECTED> HH </OPTION>
                                                                            <OPTION value="01">01</OPTION>
                                                                            <OPTION value="02">02</OPTION>
                                                                            <OPTION value="03">03</OPTION>
                                                                            <OPTION value="04">04</OPTION>
                                                                            <OPTION value="05">05</OPTION>
                                                                            <OPTION value="06">06</OPTION>
                                                                            <OPTION value="07">07</OPTION>
                                                                            <OPTION value="08">08</OPTION>
                                                                            <OPTION value="09">09</OPTION>
                                                                            <OPTION value="10">10</OPTION>
                                                                            <OPTION value="11">11</OPTION>
                                                                            <OPTION value="12">12</OPTION>
                                                                          </SELECT></td>
                                                                        <td width="18%" ><select  style="width:50px;" id="starttimemin" >
                                                                            <option value="" selected="selected"> MM </option>
                                                                            <?php include('../inc/seconds.php'); ?>
                                                                          </select></td>
                                                                        <td width="37%" ><select name="start_type" id="starttimeampm"  >
                                                                            <option value="" selected="selected">--</option>
                                                                            <option value="am">AM</option>
                                                                            <option value="pm">PM</option>
                                                                          </select></td>
                                                                      </tr>
                                                                    </table></td>
                                                                </tr>
                                                                <tr>
                                                                  <td colspan="2" ><table width="100%" border="0" cellpadding="4" cellspacing="0">
                                                                      <tr>
                                                                        <td width="58%"><div id="form-error1" align="left">&nbsp;</div></td>
                                                                        <td width="42%"><div align="center">&nbsp;
                                                                            <input name="save"  value="Update" type="submit" class="swiftchoicebutton" id="save"  onclick="visitupdate('save1');"/>
                                                                            &nbsp;</div></td>
                                                                      </tr>
                                                                    </table></td>
                                                                </tr>
                                                              </table>
                                                            </div></td>
                                                        </tr>
                                                        <tr>
                                                          <td height="2px"></td>
                                                        </tr>
                                                        <tr>
                                                          <td><div class="imp_title_bar"  >
                                                              <div class="imp_rounder" ></div>
                                                              <span>Visit Complete Information</span></div></td></tr>
                                                            <tr>
                                                          <td><div class="imp_dashboard_module" >
                                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                
                                                                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                      <tr>
                                                                        <td><div style="padding:5px"><strong>1. Activities Carried</strong></div>
                                                                          <table width="100%" border="0" cellspacing="0" cellpadding="4" >
                                                                            <tr >
                                                                              <td width="48%" ><div align="left" id="displayactivitylist">
                                                                                  <select name="activity" class="swiftselect" id="activity" style="width:200px;">
                                                                                    <option value="" selected="selected">Select a Activity</option>
                                                                                  </select>
                                                                                </div></td>
                                                                              <td width="14%" height="35px;">Description:</td>
                                                                              <td width="38%" id="activityremarks">&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                              <td colspan="3" >Implementator Remarks:
                                                                                <input type="hidden" name="impactivitylastslno" id="impactivitylastslno" />
                                                                                :
                                                                                <input type="hidden" name="activityflag" id="activityflag" />
                                                                                <input type="hidden" name="activityslno" id="activityslno" />
                                                                                <input type="hidden" name="activitydeleteslno" id="activitydeleteslno" /></td>
                                                                            </tr>
                                                                            <tr >
                                                                              <td colspan="3" ><input name="description" class="swifttext-mandatory" id="description" size="95" maxlength="500" autocomplete ="off"/></td>
                                                                            </tr>
                                                                            <tr >
                                                                              <td colspan="3" ><table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                                                  <tr>
                                                                                    <td width="55%"><div id="form-error3" align="left">&nbsp;</div></td>
                                                                                    <td width="45%"><div align="center">
                                                                                        <input name="new2"  value="New" type="submit" class="swiftchoicebutton" id="new2"  onclick="newentry();document.getElementById('form-error2').innerHTML = '';"/>
                                                                                        &nbsp;
                                                                                        <input name="save2"  value="Save" type="submit" class="swiftchoicebutton" id="save2"  onclick="activitesupdate('save2');"/>
                                                                                        &nbsp;
                                                                                        <input name="delete2"  value="Delete" type="submit" class="swiftchoicebutton" id="delete2"  onclick="activitesupdate('delete2');"/>
                                                                                      </div></td>
                                                                                  </tr>
                                                                                </table></td>
                                                                            </tr>
                                                                            <tr>
                                                                              <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                  <tr height="20px;">
                                                                                    <td width="12%"><strong>Total Visits:</strong></td>
                                                                                    <td width="88%"><div align="left" id="tabgroupcount">Not Available</div></td>
                                                                                  </tr>
                                                                                  <tr>
                                                                                    <td colspan="2"><div id="tabgroupgridc1_1"  align="center">
                                                                                        <table width="100%" cellpadding="3" cellspacing="0" class="table-border-grid">
                                                                                          <tr class="tr-grid-header" align ="left">
                                                                                            <td nowrap = "nowrap" class="td-border-grid" >Sl No</td>
                                                                                            <td nowrap = "nowrap" class="td-border-grid">Date</td>
                                                                                            <td nowrap = "nowrap" class="td-border-grid">Remarks</td>
                                                                                          </tr>
                                                                                          <tr align ="left">
                                                                                            <td colspan="3" nowrap = "nowrap" class="td-border-grid" ><div align="center"><font color="#FF0000"><strong>No Records to Display</strong></font></div></td>
                                                                                          </tr>
                                                                                        </table>
                                                                                      </div></td>
                                                                                  </tr>
                                                                                  <tr>
                                                                                    <td colspan="2"></td>
                                                                                  </tr>
                                                                                </table></td>
                                                                            </tr>
                                                                          </table></td>
                                                                      </tr>
                                                                    </table></td>
                                                                </tr>
                                                                <tr>
                                                                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                      <tr>
                                                                        <td><div style="padding:5px"><strong>2. Visit to be Closed</strong></div>
                                                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                              <td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                                  <tr >
                                                                                    <td width="28%">End Time:</td>
                                                                                    <td width="20%"  ><select name="endtimehr" id="endtimehr" style="width:50px;"  >
                                                                                        <option value="" selected="selected"> HH </option>
                                                                                        <option value="01">01</option>
                                                                                        <option value="02">02</option>
                                                                                        <option value="03">03</option>
                                                                                        <option value="04">04</option>
                                                                                        <option value="05">05</option>
                                                                                        <option value="06">06</option>
                                                                                        <option value="07">07</option>
                                                                                        <option value="08">08</option>
                                                                                        <option value="09">09</option>
                                                                                        <option value="10">10</option>
                                                                                        <option value="11">11</option>
                                                                                        <option value="12">12</option>
                                                                                      </select></td>
                                                                                    <td width="20%" ><select name="endtimemin" id="endtimemin" style="width:50px;"  >
                                                                                        <option value="" selected="selected"> MM </option>
                                                                                        <?php include('../inc/seconds.php'); ?>
                                                                                      </select></td>
                                                                                    <td width="32%" ><select name="endtimeampm" id="endtimeampm"  >
                                                                                        <option value="" selected="selected">--</option>
                                                                                        <option value="am">AM</option>
                                                                                        <option value="pm">PM</option>
                                                                                      </select></td>
                                                                                  </tr>
                                                                                  <tr>
                                                                                    <td colspan="4">Visit Summary:</td>
                                                                                  </tr>
                                                                                  <tr>
                                                                                    <td colspan="4"><textarea name="dayremarks" cols="42" rows="2" id="dayremarks" class="swiftselect-mandatory" ></textarea></td>
                                                                                  </tr>
                                                                                </table></td>
                                                          
                                                                              <td width="52%" valign="top">
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                                  <tr><td width="15%" valign="top">Data Back up:</td>
                                                                                  <td colspan="2" width="34%" valign="top"  style="border-right:1px solid  #C6E2FF"><input name="databackup" type="text" disabled="disabled" class="swifttext" id="databackup"  style="background:#FEFFE6;" size="30" maxlength="100" readonly="readonly"  autocomplete="off"/>
                                                                                              <img src="../images/fileattach.jpg" name="myfileuploadimage" border="0" align="absmiddle" id="myfileuploadimage" style="cursor:pointer" onclick=" fileuploaddivid('','databackup','databackupdiv','775px','850px','5',document.getElementById('customerlist').value,'file_link')"
                                                                                             /> <span class="textclass">(Upload zip file only)</span>&nbsp;&nbsp;<span id="downloadlinkfile2"></span> <input type="hidden" id="file_link" name="file_link" /><input type="hidden" id="file_path" name="file_path" /> </td></tr>
                                                                                  <tr >
                                                                                    <td width="29%"  style="padding-left:5px"><p>ICC Collected </p></td>
                                                                                    <td width="13%" style="padding:0px" ><input type="checkbox" name="iccollected" id="iccollected" onclick="checkboxvalidation()" /></td>
                                                                                    <td width="58%" style="padding:0px" id="displayviewicc" >&nbsp;</td>
                                                                                  </tr>
                                                                                  <tr >
                                                                                    <td colspan="3"  style="padding-left:5px"><div id="displayattach" style="display:none">
                                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                                          <tr>
                                                                                            <td width="22%" valign="top">Attach ICC :</td>
                                                                                            <td width="33%" valign="top" bgcolor="#edf4ff"><input name="attach_icc" type="text" disabled="disabled" class="swifttext" id="attach_icc"  style="background:#FEFFE6;" size="30" maxlength="100" readonly="readonly"  autocomplete="off"/>
                                                                                              <img src="../images/fileattach.jpg" name="myfileuploadimage" border="0" align="absmiddle" id="myfileuploadimage" style="cursor:pointer" onclick=" fileuploaddivid('','attach_icc','fileuploaddiv','775px','850px','1',document.getElementById('customerlist').value,'attach_link')"
                                                                                             /> <span class="textclass">(Upload zip file only)</span>
                                                                                              <input type="hidden" id="attach_link" name="attach_link" /></td>
                                                                                          </tr>
                                                                                          <tr>
                                                                                            <td width="45%"   align="right"  valign="top"  id="downloadlinkfile" colspan="5" >&nbsp;</td>
                                                                                          </tr>
                                                                                        </table>
                                                                                      </div></td>
                                                                                  </tr>
                                                                                </table></td>
                                                                            </tr>
                                                                          </table></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td >&nbsp;</td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td >&nbsp;</td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                  <td width="7%">Status:</td>
                                                                                    <td width="55%">
                                                                                      <select name="impstatus" id="impstatus">
                                                                                        <option value="">Select Status</option>
                                                                                        <option value="Completed">Completed</option>
                                                                                        <option value="Pending">Pending</option>
                                                                                        <option value="In-Process">In-Process</option>
                                                                                        <option value="On-Hold">On-Hold</option>
                                                                                        <option value="Appointment Not Confirmed">Appointment Not Confirmed</option>
                                                                                      </select>
                                                                                    </td></tr></table>
                                                                                </td>
                                                                      </tr>
                                                                    </table></td>
                                                                </tr>
                                                              </table>
                                                            </div></td>
                                                        </tr>
                                                        <tr>
                                                          <td height="2px"></td>
                                                        </tr>
                                                        <tr>
                                                          <td><table width="100%" border="0" cellpadding="4" cellspacing="0">
                                                              <tr>
                                                                <td colspan="2" height="5px" ></td>
                                                              </tr>
                                                              <tr >
                                                                <td width="58%"><div id="form-error2" align="left">&nbsp;</div></td>
                                                                <td width="42%"><div align="center">&nbsp;
                                                                    <input name="save1"  value="Update" type="submit" class="swiftchoicebutton" id="save1"  onclick="visitupdate('save2');"/>
                                                                    &nbsp;</div></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                        <tr>
                                                          <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                          <td><div id="getmorerecordslink" align="left"></div></td>
                                                        </tr>
                                                      </table></td>
                                                  </tr>
                                                </table>
                                              </div></td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                  </table>
                                </form>
                              </div></td>
                          </tr>
                          <tr>
                            <td colspan="2"><div style="display:none">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td><div  id='customizationcolorbox' style='background:#fff; width:700px; text-align: center;'>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                          <tr>
                                            <td width="100%"><strong>Customization Details</strong></td>
                                          </tr>
                                          <tr>
                                            <td ><div id="displaycustomizationgrid" >
                                                <table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                  <tr bgcolor="#f7faff">
                                                    <td width="22%" align="left" valign="top" bgcolor="#f7faff">Customization Remarks:</td>
                                                    <td colspan="2" align="left" valign="top" bgcolor="#f7faff" ><input name="customization_remarks1" type="text" class="swifttext-mandatory" id="customization_remarks1" style="width:520px" size="30" maxlength="500"  autocomplete="off"/>
                                                      </input></td>
                                                  </tr>
                                                  <tr bgcolor="#edf4ff">
                                                    <td align="left" valign="top">References Files:</td>
                                                    <td align="left" valign="top" bgcolor="#edf4ff"><input name="customization_references1" type="text" class="swifttext" id="customization_references1"  style="background:#FEFFE6;" size="30" maxlength="100" readonly="readonly"  autocomplete="off"/>
                                                      <img src="../images/fileattach.jpg" name="myfileuploadimage3" border="0" align="absmiddle" id="myfileuploadimage3" style="cursor:pointer" onclick="fileuploaddivid('','customization_references1','references_fileuploaddiv','700','25%','3',document.getElementById('customerlist').value,'cust_link')"/><span class="textclass"> (Upload zip/rar file only)</span></td>
                                                    <td valign="top" bgcolor="#edf4ff"><input type="hidden" id="cust_link" name="cust_link" /></td>
                                                  </tr>
                                                  <tr>
                                                    <td colspan="2"><div id="references_fileuploaddiv" style="display:none;">
                                                        <?php include('../inc/referenceuploadform.php'); ?>
                                                      </div></td>
                                                  </tr>
                                                  <tr bgcolor="#edf4ff">
                                                    <td align="left" valign="top" bgcolor="#f7faff">SPP Data Backup:</td>
                                                    <td align="left" valign="top" bgcolor="#f7faff"><input name="customization_sppdata1" type="text" class="swifttext" id="customization_sppdata1"  style="background:#FEFFE6;" size="30" maxlength="100" readonly="readonly"  autocomplete="off"/>
                                                      <img src="../images/fileattach.jpg" name="myfileuploadimage4" style="cursor:pointer" border="0" align="absmiddle" id="myfileuploadimage4" onclick="fileuploaddivid('','customization_sppdata1','sppdata_fileuploaddiv','700','25%','4',document.getElementById('customerlist').value,'spp_link')"/> <span class="textclass">(Upload zip/rar file only)</span></td>
                                                    <td valign="top" bgcolor="#f7faff"><input type="hidden" id="spp_link" name="spp_link" /></td>
                                                  </tr>
                                                  <tr>
                                                    <td colspan="2"><div id="sppdata_fileuploaddiv" style="display:none;">
                                                        <?php include('../inc/sppdatauploadform.php'); ?>
                                                      </div></td>
                                                  </tr>
                                                  <tr bgcolor="#edf4ff">
                                                    <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td width="5%" valign="top" bgcolor="#edf4ff"><span style="padding-left:5px">
                                                            <input type="checkbox" name="customizationcustomerview" id="customizationcustomerview"  />
                                                            </span></td>
                                                          <td width="95%" colspan="2" align="left" valign="top" bgcolor="#edf4ff" >Customization Customer View</td>
                                                        </tr>
                                                      </table></td>
                                                  </tr>
                                                  <tr>
                                                    <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                        <tr>
                                                          <td width="63%" id="cust-error-msg">&nbsp;</td>
                                                          <td width="37%" align="center"><input name="updatetype" type="button" id="updatetype" onclick="customerizationsave()" value="Update" />
                                                            &nbsp;&nbsp;
                                                            <input name="closetype" type="button" id="closetype" onclick="$().colorbox.close()" value="Close" /></td>
                                                        </tr>
                                                      </table></td>
                                                  </tr>
                                                </table>
                                              </div></td>
                                          </tr >
                                        </table>
                                      </div></td>
                                  </tr>
                                </table>
                              </div></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<div id="fileuploaddiv" style="display:none;">
  <?php include('../inc/iccuploadform.php'); ?>
</div>
<div id="databackupdiv" style="display:none;">
  <?php include('../inc/databackupform.php'); ?>
</div>
<script>
refreshcustomerarray();
</script>
<?php
}
else
{
		$grid = '<table width="952" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" height = "200">';
		$grid .= ' <tr><td height = "60">&nbsp;</td></tr>';
		$grid .= '<tr><td valign="top" style="font-size:14px"><strong><div align="center"><font color="#FF0000">You are not authorised to view this page.</font></div></strong></td></tr>';
		echo($grid);
}
?>
