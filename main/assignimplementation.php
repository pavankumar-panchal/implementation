<?php 
	$userid = imaxgetcookie('userslno');
	$query = "select implementertype,coordinator,branchid from inv_mas_implementer where slno = '".$userid."'";
	$resultfetch = runmysqlqueryfetch($query);
	$implementertype = $resultfetch['implementertype'];
	$coordinator = $resultfetch['coordinator'];
  $branch = $resultfetch['branchid'];

	if($coordinator == 'no' )
	{
		$grid = '<table width="952" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" height = "200">';
		$grid .= ' <tr><td height = "60">&nbsp;</td></tr>';
		$grid .= '<tr><td valign="top" style="font-size:14px"><strong><div align="center"><font color="#FF0000">You are not authorised to view this page.</font></div></strong></td></tr>';
		echo($grid);
	}
	else
	{
		include('../inc/eventloginsert.php');
?>
<link href="../style/style.css?dummy=<?php echo (rand());?>" rel=stylesheet>
<link media="screen" rel="stylesheet" href="../style/colorbox.css?dummy=<?php echo (rand());?>" />
<script language="javascript" src="../functions/assignimplementation.js?dummy=<?php echo (rand());?>"></script>
<script language="javascript" src="../functions/getdistrictfunction.php?dummy=<?php echo (rand());?>"></script>
<script language="javascript" src="../functions/javascript.js?dummy=<?php echo (rand());?>"></script>
<script language="javascript" src="../functions/datepickercontrol.js?dummy=<?php echo (rand());?>" type="text/javascript"></script>
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
                                    <option value="Awaiting Co-ordinator Approval">Awaiting Co-ordinator Approval</option>
                                    <option value="Fowarded back to Branch Head">Fowarded back to Branch Head</option>
                                    <option value="Implementation, Yet to be Assigned">Implementation, Yet to be Assigned</option>
                                    <option value="Assigned For Implementation">Assigned For Implementation</option>
                                    <option value="Implementation in progess">Implementation in progess</option>
                                    <option value="Implementation Completed">Implementation Completed</option>
                                  </select></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="28%" align="left" valign="top"><strong>HandHold Status:</strong><br /></td>
                                <td width="72%" align="left" valign="top"><select name="imp_hhstatus" class="swiftselect" id="imp_hhstatus" onchange="disablestatus()"  style="width:140px;">
                                    <option value="">All</option>
                                    <option value="Implementation, Yet to be Assigned">Implementation, Yet to be Assigned</option>
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
                                <td width="72%" align="left" valign="top"><select name="handhold" class="swiftselect" id="handhold" onchange="disablestatus()"  style="width:140px;">
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
                            <td width="27%" align="left" valign="middle" class="active-leftnav">Assign Implementation</td>
                            <td width="40%"><div align="right"></div></td>
                            <td width="33%"><div align="right">
                              <input name="search" type="submit" class="swiftchoicebuttonbig" id="search" value="Advanced Search"  onclick="displayDiv('filterdiv')"  />
                            </div></td>
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
                                                                                  <td width="39%" valign="top" style="border-left:1px solid #CCCCCC;padding-left:6px"><table width="96%" border="0" cellspacing="0" cellpadding="2" >
                                                                                    <tr>
                                                                                      <td colspan="3" valign="top" style="padding:0"></td>
                                                                                    </tr>
                                                                                    <tr >
                                                                                      <td colspan="3" valign="top" align="left"><strong>Implementation Status</strong></td>
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
                                                          </table></td>
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
                            <td width="81%" align="left" class="header-line" style="padding:0">&nbsp;&nbsp;Enter / Edit / View Details </td>
                            <td width="19%" align="right" class="header-line" style="padding-right:7px">&nbsp;</td>
                          </tr>
                          
                          <tr>
                            <td colspan="2" valign="top"><div id="maindiv">
                                <form action="" method="post" name="submitform" id="submitform" onSubmit="return false;">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                <tr>
                                                  <td colspan="12" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6"  bgcolor="#FFFFF0">
                                                      <tr style="height:35px;"  bgcolor="#D6D6D6" >
                                                        <td width="17%" style="padding-left:8px;" valign="middle"><strong>Company Name:</strong></td>
                                                        <td width="78%" bgcolor="#D6D6D6" id="displaycompanyname" style="padding-left:8px;"  valign="middle"><span style="padding-right:10px"> </span></td>
                                                        <td width="5%" style="padding-right:10px;"><div align="right"><img src="../images/plus.jpg" border="0" id="toggleimg1" name="toggleimg1"  align="absmiddle" onClick="divdisplay('displaycustomerdetails','toggleimg1');" style="cursor:pointer"/></div></td>
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
                                                  <td width="25%" onclick="tabopen2('2','tabg1')" class="producttabhead" id="tabg1h2" style="cursor:pointer;"><div align="center"><strong>Assign Implementation</strong></div></td>
                                                  <td width="2%" class="producttabheadnone"></td>
                                                  <td width="12%" onclick="tabopen2('3','tabg1')" class="producttabhead" id="tabg1h3" style="cursor:pointer;"><div align="center"><strong>Follow Ups</strong></div></td>
                                                  <td width="2%" class="producttabheadnone"></td>
                                                  <td width="11%" onclick="tabopen2('4','tabg1')" class="producttabhead" id="tabg1h4" style="cursor:pointer;"><div align="center"><strong>Hand Hold</strong></div></td>
                                                  <td width="2%" class="producttabheadnone">&nbsp;</td>
                                                  <td width="8%"  class="producttabhead" >&nbsp;</td>
                                                  <td width="2%" class="producttabheadnone">&nbsp;</td>
                                                  <td width="18%"  class="producttabhead">&nbsp;</td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                          <tr>
                                            <td><div style="display:block;"  align="justify" id="tabg1c1" >
                                                <table width="100%" border="0" cellspacing="0" cellpadding="2" class="productcontent" height="350px">
                                                  <tr>
                                                    <td width="50%" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td height="35px;"><div id="loadingdiv"><span  style="padding-left:25px"><strong><font color="#FF0000">Select A Customer</font></strong> </span></div></td>
                                                        </tr>
                                                      </table></td>
                                                    <td width="50%"><div id="displaybutton" style="display:block">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                          <tr align="right">
                                                            <td width="90%"  style="padding:5px"><input type="button" name="approve" id="approve" onclick="validaterequest('approve')" class="swiftchoicebutton" value="Approve"  /></td>
                                                            <td width="10%" style="padding:5px; padding-right:10px"><input type="button" name="reject" id="reject" onclick="validaterequest('reject')" class="swiftchoicebutton" value="Reject"  /></td>
                                                          </tr>
                                                        </table>
                                                      </div>
                                                      <div id="displaymessage" style="display:none">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                          <tr>
                                                            <td align="right" id="displaystatus" style="color:#FF0000; font-size:12px; font-weight:bold" >&nbsp;</td>
                                                          </tr>
                                                        </table>
                                                      </div></td>
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
                                                        <!-End -->
                                                        <tr>
                                                          <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6"   >
                                                              <tr style="height:25px;"  bgcolor="#D6D6D6" >
                                                                <td width="23%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>1.Invoice Information</strong></td>
                                                                <td width="72%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;"><span class="header-line" style="padding:0">
                                                                  <input type="hidden" name="lastslno" id="lastslno"/>
                                                                  <input type="hidden" name="implastslno" id="implastslno"/>
                                                                  <input type="text" name="impreflastslno" id="impreflastslno"/>
                                                                  <input type="text" name="impactivitylastslno" id="impactivitylastslno"/>
                                                                  <input type="hidden" name="customizationlastslno" id="customizationlastslno"/>
                                                                  <input type="hidden" name="filepath" id="filepath"/>
                                                                  <input type="text" id="implementationslno" name="implementationslno"/>
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
                                                                            <td width="22%" valign="top">Attachment's Of RAF:</td>
                                                                            <td valign="top" bgcolor="#edf4ff" >&nbsp;</td>
                                                                            <td valign="top" bgcolor="#edf4ff" >&nbsp;</td>
                                                                          </tr>
                                                                          <tr bgcolor="#edf4ff">
                                                                            <td colspan="3" id="attachement_raffilename"></td>
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
                                                                            <td align="left" valign="top" bgcolor="#EDF4FF">PO Uploads :</td>
                                                                            <td width="48%" align="left" valign="top" bgcolor="#EDF4FF" id="pouploadlink_filename">Not Available</td>
                                                                            <td width="16%"  valign="top" bgcolor="#EDF4FF" id="pouploadlink_errorfile" align="right">&nbsp;</td>
                                                                          </tr>
                                                                          <tr bgcolor="#EDF4FF">
                                                                            <td width="36%" align="left" valign="top" bgcolor="#f7faff">Number of Companies to be processed :</td>
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
                                                                      <td colspan="2" ><div id="displaycustomization" >
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
                                                                            <tr bgcolor="#edf4ff">
                                                                                    <td colspan="3" valign="top" bgcolor="#f7faff"><div id="tabgroupgridc3" style="overflow:auto;; padding:1px;" align="center">
                                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                          <tr>
                                                                                            <td><div id="tabgroupgridc1_3" align="center">
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
                                                                                          <tr >
                                                                                            <td><div id="tabgroupgridc3link" style="height:20px; padding:1px;" align="left"> </div></td>
                                                                                          </tr>
                                                                                        </table>
                                                                                        <div id="regresultgrid3" style="overflow:auto; display:none; padding:1px;" align="center"></div>
                                                                                      </div></td>
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
                                                                      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                          <tr>
                                                                            <td width="119" valign="top" bgcolor="#edf4ff">Current Status :</td>
                                                                            <td width="266" valign="top" bgcolor="#edf4ff" id="implementationid">Pending.</td>
                                                                            <td width="315" valign="top" bgcolor="#edf4ff" ><span id="assigndiv" style="display:none"><img src="../images/help-image.gif"  onmouseover="tooltip()" onmouseout="hidetooltip()" style="cursor:pointer" /></span>
                                                                              <input type="hidden" name="assignid" id="assignid" /></td>
                                                                          </tr>
                                                                          <tr>
                                                                            <td colspan="3" valign="top" bgcolor="#f7faff"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                                                <tr>
                                                                                  <td width="29%"  id="remarksname" align="left">&nbsp;</td>
                                                                                  <td width="71%" id="implementationremarks" align="left">&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                  <td width="29%"  id="processeddate" align="left">&nbsp;</td>
                                                                                  <td width="71%" id="approverejectdate" align="left">&nbsp;</td>
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
                                                                <td width="42%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>11. Hand Hold Implementation Status</strong></td>
                                                                <td width="53%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;">&nbsp;</td>
                                                                <td width="5%" style="padding-right:10px;">&nbsp;</td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="3" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="4" align="center" >
                                                                    <tr>
                                                                      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                          <tr>
                                                                            <td width="119" valign="top" bgcolor="#edf4ff">Current Status :</td>
                                                                            <td width="266" valign="top" bgcolor="#edf4ff" id="hhimplementationid">Pending.</td>
                                                                            <td width="315" valign="top" bgcolor="#edf4ff" ><span id="assigndiv" style="display:none"><img src="../images/help-image.gif"  onmouseover="tooltip()" onmouseout="hidetooltip()" style="cursor:pointer" /></span>
                                                                            </td>
                                                                          </tr>
                                                                          <!-- <tr>
                                                                            <td colspan="3" valign="top" bgcolor="#f7faff"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                                                <tr>
                                                                                  <td width="29%"  id="remarksname" align="left">&nbsp;</td>
                                                                                  <td width="71%" id="implementationremarks" align="left">&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                  <td width="29%"  id="processeddate" align="left">&nbsp;</td>
                                                                                  <td width="71%" id="approverejectdate" align="left">&nbsp;</td>
                                                                                </tr>
                                                                                <tr id="advdisplay" style="display:none">
                                                                                  <td width="29%" align="left">Advance Collected Remarks: </td>
                                                                                  <td width="71%" id="advremarksid" align="left">&nbsp;</td>
                                                                                </tr>
                                                                              </table></td>
                                                                          </tr> -->
                                                                        </table></td>
                                                                    </tr>
                                                                  </table></td>
                                                              </tr>
                                                              <tr>
                                                                <td  colspan="3"></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                      </table></td>
                                                  </tr>
                                                </table>
                                              </div>
                                              <div style="display:none" align="justify" id="tabg1c2">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td><div style="display:none" id="displaydiv1">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="2" >
                                                          <tr>
                                                            <td colspan="2">&nbsp;</td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" >
                                                                <tr>
                                                                  <td colspan="3" valign="top"  ><table width="100%" border="0" cellspacing="0" cellpadding="0" >
                                                                      <tr>
                                                                        <td width="12%">Currently With:
                                                                        <input type="hidden" name="hiddenimplementerid" id="hiddenimplementerid" /></td>
                                                                        <td width="27%"  height="35px;" id="displayimplementername">Not Available</td>
                                                                        <td width="9%">Assign To:</td>
                                                                        <td width="40%"><select name="assigndays_imp" class="swiftselect" id="assigndays_imp" style="width:175px;">
                                                                            <option value="" selected="selected">Select an Implementer</option>
                                                                            <?php include('../inc/implementer.php')?>
                                                                          </select>
                                                                          <!-- &nbsp;<span id="sendemail1"><a class="r-text" onclick="sendemailonupdate('assignedimplementer')">Send Email &#8250;&#8250; </a></span> -->
                                                                        </td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td colspan="4" ><div class="imp_title_bar">
                                                                            <div class="imp_rounder" ></div>
                                                                            <span>Assign Days </span></div></td></tr>
                                                                          <tr>
                                                                        <td colspan="4" ><div class="imp_dashboard_module" >
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                              <tr>
                                                                                <td width="14%" valign="top">No of Days:</td>
                                                                                <td width="86%" colspan="3" valign="top"><input name="assign_days" type="text" class="swifttext-mandatory" id="assign_days" size="30" autocomplete="off" maxlength="4"  />
                                                                                  &nbsp;<a class="r-text" onclick="addimplementation();" id="assign_link">Add &#8250;&#8250; </a>&nbsp;<span id="sendemail2"><a class="r-text" onclick="sendemailonupdate('assignednoofdays')">Send Email &#8250;&#8250; </a></span></td>
                                                                              </tr>
                                                                            </table>
                                                                          </div></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td colspan="4">&nbsp;</td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td colspan="4"><div class="imp_title_bar"  >
                                                                            <div class="imp_rounder" ></div>
                                                                            <span>Assigned Days </span></div></td></tr>
                                                                          <tr>
                                                                        <td colspan="4"><div class="imp_dashboard_module" >
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="4" > <tr>
                                                                                <td width="14%">Day:</td>
                                                                                <td id="visitnumberdisplay">Not Available</td>
                                                                                <td><label for="halfdayflag">Half Day:</label></td>
                                                                                <td><input type="checkbox" name="halfdayflag" id="halfdayflag" /></td>
                                                                              </tr>
                                                                              <tr>
                                                                                <td width="14%">Date:</td>
                                                                                <td width="37%"><input name="DPC_attachfromdate1" type="text" class="swifttext-mandatory" id="DPC_attachfromdate1" size="30" autocomplete="off" value="<?php echo(datetimelocal('d-m-Y')); ?>" readonly="readonly"/></td>
                                                                                <td width="12%" valign="top">Remarks:</td>
                                                                                <td width="37%" valign="top"><input name="assigndays_remarks" type="text" class="swifttext" id="assigndays_remarks" size="35" autocomplete="off" value="" /></td>
                                                                              </tr>
                                                                             
                                                                              <tr>
                                                                                <td colspan="4" style="padding-top:5px"><table width="100%" border="0" cellpadding="3" cellspacing="0">
                                                                                    <tr>
                                                                                      <td width="63%"><div id="form-error1" align="left">&nbsp;</div></td>
                                                                                      <td width="37%"><div align="center">&nbsp;
                                                                                          <input name="save"  value="Update" type="submit" class="swiftchoicebutton" id="save"  onclick="impassigndays('save');"/>
                                                                                          &nbsp;
                                                                                          <input name="delete"  value="Delete" type="submit" class="swiftchoicebutton" id="delete"  onclick="impassigndays('delete');"/>
                                                                                        </div></td>
                                                                                    </tr>
                                                                                  </table></td>
                                                                              </tr>
                                                                              <tr>
                                                                                <td colspan="4"><div id="tabgroupgridc1" style="overflow:auto; width:677px; padding:2px;" align="center">
                                                                                    <div id="resultgrid" style="overflow:auto;  width:677px; padding:2px; display:none;" align="center"></div>
                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                      <tr height="20px;">
                                                                                        <td width="14%"><strong>Total Visits:</strong></td>
                                                                                        <td width="86%" id="tabgroupcount" style="text-align:left" >Not Available</td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                        <td colspan="2"><div id="tabgroupgridc1_1"  align="center" style="overflow:auto; width:677px; padding:2px;" align="center">
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
                                                                                        <td colspan="2"><div id="getmorerecordslink" align="left"></div></td>
                                                                                      </tr>
                                                                                    </table>
                                                                                  </div></td>
                                                                              </tr>
                                                                            </table>
                                                                          </div></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td colspan="4"><div class="imp_title_bar"  >
                                                                            <div class="imp_rounder" ></div>
                                                                            <span>Assign Activities </span></div></td></tr>
                                                                         <tr>
                                                                        <td colspan="4"> <div class="imp_dashboard_module" >
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                              <tr>
                                                                                <td width="10%" valign="top">Activity:</td>
                                                                                <td width="37%" valign="top"><input name="assignactivity" type="text" class="swifttext-mandatory" id="assignactivity" size="35" autocomplete="off" value="" /></td>
                                                                                <!-- <td width="38%" valign="top"><select name="assignactivity" class="swiftselect" id="assignactivity" style="width:200px;">
                                                                                    <option value="" selected="selected">Select an Activity</option>
                                                                                    <?php //include('../inc/activity.php')?>
                                                                                  </select></td> -->
                                                                                <td width="12%" valign="top">Remarks:</td>
                                                                                <td width="37%" valign="top"><input name="assignactivity_remarks" type="text" class="swifttext-mandatory" id="assignactivity_remarks" size="35" autocomplete="off" value="" /></td>
                                                                              </tr>
                                                                              <tr>
                                                                                <td colspan="4"><table width="100%" border="0" cellpadding="3" cellspacing="0">
                                                                                    <tr>
                                                                                      <td width="55%"><div id="form-error2" align="center"></div></td>
                                                                                      <td width="45%"><div align="center">
                                                                                          <input name="new2"  value="New" type="submit" class="swiftchoicebutton" id="new2"  onClick="newentry();document.getElementById('form-error2').innerHTML = '';"/>
                                                                                          &nbsp;
                                                                                          <input name="save2"  value="Save" type="submit" class="swiftchoicebutton" id="save2"  onClick="impassignactivity('save');"/>
                                                                                          &nbsp;
                                                                                          <input name="delete2"  value="Delete" type="submit" class="swiftchoicebutton" id="delete2"  onClick="impassignactivity('delete');"/>&nbsp;
                                                                                        </div></td>
                                                                                    </tr>
                                                                                  </table></td>
                                                                              </tr>
                                                                              <tr>
                                                                                <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tr>
                                                                                      <td colspan="3" align="center" valign="top"><div id="tabgroupgridc2" style="overflow:auto;  width:677px; padding:2px;" align="center">
                                                                                          <div id="resultgrid2" style="overflow:auto;  width:677px; padding:2px; display:none;" align="center"></div>
                                                                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                            <tr height="20px;">
                                                                                              <td width="16%"><strong>Total Activities:</strong></td>
                                                                                              <td width="42%" id="tabgroupcount2" style="text-align:left">Not Available</td>
                                                                                              <td width="42%"><div align="right" id="sendemail3"><a class="r-text" onclick="sendemailonupdate('assignedactivities')">Send Email &#8250;&#8250; </a></div></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                              <td colspan="3"><div id="tabgroupgridc1_2"  align="center" style="overflow:auto;">
                                                                                                  <table width="100%" cellpadding="3" cellspacing="0" class="table-border-grid">
                                                                                                    <tr class="tr-grid-header" align ="left">
                                                                                                      <td nowrap = "nowrap" class="td-border-grid" >Sl No</td>
                                                                                                      <td nowrap = "nowrap" class="td-border-grid">Activity</td>
                                                                                                      <td nowrap = "nowrap" class="td-border-grid">Remarks</td>
                                                                                                    </tr>
                                                                                                    <tr align ="left">
                                                                                                      <td colspan="3" nowrap = "nowrap" class="td-border-grid" ><div align="center"><font color="#FF0000"><strong>No Records to Display</strong></font></div></td>
                                                                                                    </tr>
                                                                                                  </table>
                                                                                                </div></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                              <td colspan="3"><div id="getmorerecordslink2" align="left"></div></td>
                                                                                            </tr>
                                                                                          </table>
                                                                                        </div></td>
                                                                                    </tr>
                                                                                  </table></td>
                                                                              </tr>
                                                                            </table>
                                                                          </div></td>
                                                                      </tr>
                                                                    </table></td>
                                                                </tr>
                                                                <tr>
                                                                  <td colspan="3" valign="top"  >&nbsp;</td>
                                                                </tr>
                                                              </table></td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2">&nbsp;</td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2"><div id="customizationdiv" style="display:none">
                                                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  style="border:1px solid #D6D6D6"  >
                                                                  <tr style="height:25px;"  bgcolor="#D6D6D6" >
                                                                    <td width="26%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>Customization</strong></td>
                                                                    <td width="69%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;">&nbsp;</td>
                                                                    <td width="5%" style="padding-right:10px;">&nbsp;</td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td colspan="3" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                        <tr  bgcolor="#EDF4FF">
                                                                          <td width="13%">Assigned To:</td>
                                                                          <td width="37%"><select name="customizer" class="swiftselect" id="customizer" style="width:200px;">
                                                                              <option value="" selected="selected">Select a Customizer</option>
                                                                              <?php include('../inc/customizer.php')?>
                                                                            </select>
                                                                            &nbsp;<a class="r-text" onClick="assignimplementation('customization','displaycustomizername','customizer');">Go &#8250;&#8250;</a></td>
                                                                          <td width="14%">Currently With:</td>
                                                                          <td width="36%" id="displaycustomizername">Not Available</td>
                                                                        </tr>
                                                                        <tr  bgcolor="#f7faff">
                                                                          <td><strong>Assign Days</strong></td>
                                                                          <td>&nbsp;</td>
                                                                          <td>&nbsp;</td>
                                                                          <td>&nbsp;</td>
                                                                        </tr>
                                                                        <tr  bgcolor="#EDF4FF">
                                                                          <td valign="top">Date:</td>
                                                                          <td valign="top"><input name="DPC_attachfromdate2" type="text" class="swifttext-mandatory" id="DPC_attachfromdate2" size="30" autocomplete="off" value="<?php echo(datetimelocal('d-m-Y')); ?>" readonly="readonly"/></td>
                                                                          <td valign="top">Remarks:</td>
                                                                          <td valign="top"><input name="customizer_remarks" type="text" class="swifttext-mandatory" id="customizer_remarks" size="35" autocomplete="off" value="" /></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                                              <tr>
                                                                                <td width="55%"><div id="form-error3" align="left">&nbsp;</div></td>
                                                                                <td width="45%"><div align="center">
                                                                                    <input name="new3"  value="New" type="submit" class="swiftchoicebutton" id="new3" onClick="newentry();document.getElementById('form-error3').innerHTML = '';"/>
                                                                                    &nbsp;
                                                                                    <input name="save3"  value="Save" type="submit" class="swiftchoicebutton" id="save3"  onClick="assigncustomization('save');"/>
                                                                                    &nbsp;
                                                                                    <input name="delete3"  value="Delete" type="submit" class="swiftchoicebutton" id="delete3"  onClick="assigncustomization('delete');"/>
                                                                                  </div></td>
                                                                              </tr>
                                                                            </table></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
                                                                              <tr>
                                                                                <td colspan="3" align="center" valign="top"><div id="tabgroupgridc3" style="overflow:auto;  width:677px; padding:2px;" align="center">
                                                                                    <div id="resultgrid3" style="overflow:auto; width:677px; padding:2px; display:none;" align="center"></div>
                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                      <tr>
                                                                                        <td width="6%" height="20px;"><strong>Total:</strong></td>
                                                                                        <td width="94%"><div align="left" id="tabgroupcount4">Not Available</div></td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                        <td colspan="2"><div id="tabgroupgridc1_4"  align="center">
                                                                                            <table width="100%" cellpadding="3" cellspacing="0" class="table-border-grid">
                                                                                              <tr class="tr-grid-header" align ="left">
                                                                                                <td nowrap = "nowrap" class="td-border-grid" >Sl No</td>
                                                                                                <td nowrap = "nowrap" class="td-border-grid">Date</td>
                                                                                             
                                                                                                <td nowrap = "nowrap" class="td-border-grid">Remarks</td>
                                                                                              </tr>
                                                                                              <tr  align ="left">
                                                                                                <td colspan="3" nowrap = "nowrap" class="td-border-grid" ><div align="center"><font color="#FF0000"><strong>No Records to Display</strong></font></div></td>
                                                                                              </tr>
                                                                                            </table>
                                                                                          </div></td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                        <td colspan="2"><div id="getmorerecordslink4" align="left"></div></td>
                                                                                      </tr>
                                                                                    </table>
                                                                                  </div></td>
                                                                              </tr>
                                                                            </table></td>
                                                                        </tr>
                                                                      </table></td>
                                                                  </tr>
                                                                </table>
                                                              </div></td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2" valign="top">&nbsp;</td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2" valign="top"><div id="webimplementationdiv" style="display:none">
                                                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  style="border:1px solid #D6D6D6"  >
                                                                  <tr style="height:25px;"  bgcolor="#D6D6D6" >
                                                                    <td width="26%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>Web Implementation</strong></td>
                                                                    <td width="69%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;">&nbsp;</td>
                                                                    <td width="5%" style="padding-right:10px;">&nbsp;</td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td colspan="3" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                        <tr  bgcolor="#EDF4FF">
                                                                          <td width="13%">Assigned To:</td>
                                                                          <td width="37%"><select name="webimplementer" class="swiftselect" id="webimplementer" style="width:200px;">
                                                                              <option value="" selected="selected">Select a Webimplementer</option>
                                                                              <?php include('../inc/webimplementer.php')?>
                                                                            </select>
                                                                            &nbsp;<a class="r-text" onclick="assignimplementation('webimplementation','displaywebimplementername','webimplementer');">Go &#8250;&#8250;</a></td>
                                                                          <td width="14%">Currently With:</td>
                                                                          <td width="36%" id="displaywebimplementername">Not Available</td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td colspan="4">&nbsp;</td>
                                                                        </tr>
                                                                      </table></td>
                                                                  </tr>
                                                                </table>
                                                              </div></td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2" valign="top">&nbsp;</td>
                                                          </tr>
                                                        </table>
                                                      </div></td>
                                                  </tr>
                                                  <tr>
                                                    <td><div style="display:block" id="displaydiv2">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                          <tr>
                                                            <td>&nbsp;</td>
                                                          </tr>
                                                          <tr>
                                                            <td><div class="errorbox">This Implementation Request has not been Approved please approve it.</div></td>
                                                          </tr>
                                                          <tr>
                                                            <td>&nbsp;</td>
                                                          </tr>
                                                        </table>
                                                      </div></td>
                                                  </tr>
                                                </table>
                                              </div>
                                              <!-- added from here -->
                                            <div style="display:none" align="justify" id="tabg1c3">
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td>
                                                    <div style="display:none" id="displaydiv3">
                                                      <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                        <tr>
                                                          <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                          <td width="14%">Followup Date:</td>
                                                          <td width="37%"><input name="DPC_followdate" type="text" class="swifttext-mandatory" id="DPC_followdate" size="30" autocomplete="off" readonly="readonly"/></td>
                                                        </tr>
                                                        <tr>  
                                                          <td width="12%" valign="top">Remarks:</td>
                                                          <td width="37%" valign="top"><textarea name="followupremarks" cols="30" class="swifttextareanew" id="followupremarks" rows="5" style="resize: none;"></textarea></td>
                                                        </tr>
                                                        <tr>
                                                          <td width="14%">Next Followup Date:</td>
                                                          <td width="37%"><input name="DPC_nxtfollowdate" type="text" class="swifttext-mandatory" id="DPC_nxtfollowdate" size="30" autocomplete="off"  readonly="readonly"/></td>
                                                        </tr>
                                                        <tr>
                                                          <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                          <td colspan="4" style="padding-top:5px"><table width="100%" border="0" cellpadding="3" cellspacing="0">
                                                            <tr>
                                                                <td width="63%"><div id="form-error4" align="left">&nbsp;</div></td>
                                                                <td width="37%"><div align="center">&nbsp;
                                                                    <input name="new5"  value="New" type="submit" class="swiftchoicebutton" id="new5"  onClick="newfollowupentry();"/>
                                                                    &nbsp;
                                                                    <input name="savefollowup"  value="Save" type="submit" class="swiftchoicebutton" id="savefollowup"  onclick="impfollowups();"/>
                                                                    <!-- &nbsp;
                                                                    <input name="delete"  value="Delete" type="submit" class="swiftchoicebutton" id="delete"  onclick="impfollowups('delete');"/> -->
                                                                  </div></td>
                                                              </tr>
                                                          </table></td>
                                                        </tr>
                                                        <tr>
                                                          <td colspan="4"><div id="tabgroupgridc6" style="overflow:auto; width:677px; padding:2px;" align="center">
                                                              <div id="resultgrid1" style="overflow:auto;  width:677px; padding:2px; display:none;" align="center"></div>
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                  <tr>
                                                                    <td colspan="2"><div id="viewdisplayfollowup"  overflow:auto;">
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #308ebc; border-top:none;">
                                                                      <tr>
                                                                        <td width="93%" class="header-line" style="padding:0">Followup details</td>
                                                                        <!-- <td width="7%" class="header-line" style="padding:0"><div align="right"><a  style="cursor:pointer;" onclick="document.getElementById('viewinvoicedisplaydiv').style.display = 'none';"><img src="../images/cancel5.jpg" width="10" height="10" align="absmiddle" /></a>&nbsp;&nbsp;</div></td> -->
                                                                      </tr>
                                                                      <tr>
                                                                        <td colspan="2" style="padding:0;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                              <td><div id="displayfollowups" style="overflow:auto; height:120px; width:670px; padding:2px;" align="center"> No datas found to be displayed.</div></td>
                                                                            </tr>
                                                                    </table></td>
                                                                      </tr>
                                                                    </table>
                                                                    </div></td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td colspan="2"><div id="getmorerecordslink1" align="left"></div></td>
                                                                  </tr>
                                                                </table>
                                                              </div>
                                                            </td>
                                                        </tr></table></div></td>
                                                </tr>
                                                <tr>
                                                  <td><div style="display:block" id="displaydiv4">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                      <tr>
                                                        <td>&nbsp;</td>
                                                      </tr>
                                                      <tr>
                                                        <td><div class="errorbox">This Implementation Request has not been Approved please approve it.</div></td>
                                                      </tr>
                                                      <tr>
                                                        <td>&nbsp;</td>
                                                      </tr>
                                                    </table>
                                                  </div></td>
                                                </tr>
                                              </table>
                                            </div><!-- till here -->

                                            <!-- added from here hand hold -->
                                            <div style="display:none" align="justify" id="tabg1c4">
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td><div style="display:none" id="displaydiv5">
                                                  <table width="100%" border="0" cellspacing="0" cellpadding="2" >
                                                    <tr>
                                                      <td colspan="2">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                      <td colspan="2"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" >
                                                          <tr>
                                                            <td colspan="3" valign="top"  ><table width="100%" border="0" cellspacing="0" cellpadding="0" >
                                                                <tr>
                                                                  <td width="12%">Currently With:
                                                                  <input type="hidden" name="hiddenimpid" id="hiddenimpid" /></td>
                                                                  <td width="27%"  height="35px;" id="displayimpname">Not Available</td>
                                                                  <td width="9%">Assign To:</td>
                                                                  <td width="40%"><select name="hassigndays_imp" class="swiftselect" id="hassigndays_imp" style="width:175px;">
                                                                      <option value="" selected="selected">Select an Implementer</option>
                                                                      <?php include('../inc/implementer.php')?>
                                                                    </select>
                                                                    <!-- &nbsp;<a class="r-text" onclick="assignimplementation('implementation','displayimplementername','assigndays_imp');">Go &#8250;&#8250; </a>&nbsp;<span id="sendemail1"><a class="r-text" onclick="sendemailonupdate('assignedimplementer')">Send Email &#8250;&#8250; </a></span></td> -->
                                                                    <!-- &nbsp;<span id="sendemail4"><a class="r-text" onclick="sendhandholdemailonupdate('assignedimplementer')">Send Email &#8250;&#8250; </a></span> -->
                                                                    </td>
                                                                  </tr>
                                                                <tr>
                                                                  <td colspan="4" ><div class="imp_title_bar">
                                                                      <div class="imp_rounder" ></div>
                                                                      <span>Assign Days </span></div></td></tr>
                                                                    <tr>
                                                                  <td colspan="4" ><div class="imp_dashboard_module" >
                                                                      <table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                        <tr>
                                                                          <td width="14%" valign="top">No of Days:</td>
                                                                          <td width="86%" colspan="3" valign="top"><input name="hassign_days" type="text" class="swifttext-mandatory" id="hassign_days" size="30" autocomplete="off" maxlength="4"  />
                                                                            &nbsp;<a class="r-text" onclick="addimplementation('handhold');" id="hassign_link">Add &#8250;&#8250; </a>&nbsp;<span id="sendemail5"><a class="r-text" onclick="sendhandholdemailonupdate('assignednoofdays','handhold')">Send Email &#8250;&#8250; </a></span></td>
                                                                        </tr>
                                                                      </table>
                                                                    </div></td>
                                                                </tr>
                                                                <tr>
                                                                  <td colspan="4">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td colspan="4"><div class="imp_title_bar"  >
                                                                      <div class="imp_rounder" ></div>
                                                                      <span>Assigned Days </span></div></td></tr>
                                                                    <tr>
                                                                  <td colspan="4"><div class="imp_dashboard_module" >
                                                                      <table width="100%" border="0" cellspacing="0" cellpadding="4" > <tr>
                                                                          <td width="14%">Day:</td>
                                                                          <td id="hvisitnumberdisplay">Not Available</td>
                                                                          <td><label for="hhalfdayflag">Half Day:</label></td>
                                                                          <td><input type="checkbox" name="hhalfdayflag" id="hhalfdayflag" /></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="14%">Date:</td>
                                                                          <td width="37%"><input name="DPC_attachfromdate3" type="text" class="swifttext-mandatory" id="DPC_attachfromdate3" size="30" autocomplete="off" value="<?php echo(datetimelocal('d-m-Y')); ?>" readonly="readonly"/></td>
                                                                          <td width="12%" valign="top">Remarks:</td>
                                                                          <td width="37%" valign="top"><input name="hassigndays_remarks" type="text" class="swifttext" id="hassigndays_remarks" size="35" autocomplete="off" value="" /></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="10%">Hand Hold:</td>
                                                                            <td width="10%">
                                                                              <select name="imphandhold" id="imphandhold" style="width:130px;">
                                                                                <option value="">Select Handhold</option>
                                                                              <?php include("../inc/imp-handholdtype.php"); ?>
                                                                              </select>
                                                                        </td>
                                                                      </tr>
                                                                        
                                                                        <tr>
                                                                          <td colspan="4" style="padding-top:5px"><table width="100%" border="0" cellpadding="3" cellspacing="0">
                                                                              <tr>
                                                                                <td width="63%"><div id="form-error7" align="left">&nbsp;</div></td>
                                                                                <td width="37%"><div align="center">&nbsp;
                                                                                    <input name="hsave"  value="Update" type="submit" class="swiftchoicebutton" id="hsave"  onclick="hhimpassigndays('save');"/>
                                                                                    &nbsp;
                                                                                    <input name="hdelete"  value="Delete" type="submit" class="swiftchoicebutton" id="hdelete"  onclick="hhimpassigndays('delete');"/>
                                                                                  </div></td>
                                                                              </tr>
                                                                            </table></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td colspan="4"><div id="tabgroupgridc4" style="overflow:auto; width:677px; padding:2px;" align="center">
                                                                              <div id="resultgrid" style="overflow:auto;  width:677px; padding:2px; display:none;" align="center"></div>
                                                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr height="20px;">
                                                                                  <td width="14%"><strong>Total Visits:</strong></td>
                                                                                  <td width="86%" id="tabgroupcount1" style="text-align:left" >Not Available</td>
                                                                                </tr>
                                                                                <tr>
                                                                                  <td colspan="2"><div id="tabgroupgridc1_5"  align="center" style="overflow:auto; width:677px; padding:2px;" align="center">
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
                                                                                  <td colspan="2"><div id="getmorerecordslink" align="left"></div></td>
                                                                                </tr>
                                                                              </table>
                                                                            </div></td>
                                                                        </tr>
                                                                      </table>
                                                                    </div></td>
                                                                </tr>
                                                                <tr>
                                                                  <td colspan="4"><div class="imp_title_bar"  >
                                                                      <div class="imp_rounder" ></div>
                                                                      <span>Assign Activities </span></div></td></tr>
                                                                    <tr>
                                                                  <td colspan="4"> <div class="imp_dashboard_module" >
                                                                      <table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                        <tr>
                                                                          <td width="10%" valign="top">Activity:</td>
                                                                          <td width="37%" valign="top"><input name="hassignactivity" type="text" class="swifttext-mandatory" id="hassignactivity" size="35" autocomplete="off" value="" /></td>
                                                                          <!-- <td width="38%" valign="top"><select name="assignactivity" class="swiftselect" id="assignactivity" style="width:200px;">
                                                                              <option value="" selected="selected">Select an Activity</option>
                                                                              <?php //include('../inc/activity.php')?>
                                                                            </select></td> -->
                                                                          <td width="12%" valign="top">Remarks:</td>
                                                                          <td width="37%" valign="top"><input name="hassignactivity_remarks" type="text" class="swifttext-mandatory" id="hassignactivity_remarks" size="35" autocomplete="off" value="" /></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td colspan="4"><table width="100%" border="0" cellpadding="3" cellspacing="0">
                                                                              <tr>
                                                                                <td width="55%"><div id="form-error8" align="center"></div></td>
                                                                                <td width="45%"><div align="center">
                                                                                    <input name="new4"  value="New" type="submit" class="swiftchoicebutton" id="new4"  onClick="newentry();document.getElementById('form-error8').innerHTML = '';"/>
                                                                                    &nbsp;
                                                                                    <input name="save4"  value="Save" type="submit" class="swiftchoicebutton" id="save4"  onClick="hhimpassignactivity('save');"/>
                                                                                    &nbsp;
                                                                                    <input name="delete4"  value="Delete" type="submit" class="swiftchoicebutton" id="delete4"  onClick="hhimpassignactivity('delete');"/>&nbsp;
                                                                                  </div></td>
                                                                              </tr>
                                                                            </table></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                              <tr>
                                                                                <td colspan="3" align="center" valign="top"><div id="tabgroupgridc5" style="overflow:auto;  width:677px; padding:2px;" align="center">
                                                                                    <div id="resultgrid3" style="overflow:auto;  width:677px; padding:2px; display:none;" align="center"></div>
                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                      <tr height="20px;">
                                                                                        <td width="16%"><strong>Total Activities:</strong></td>
                                                                                        <td width="42%" id="tabgroupcount3" style="text-align:left">Not Available</td>
                                                                                        <td width="42%"><div align="right" id="sendemail6"><a class="r-text" onclick="sendhandholdemailonupdate('assignedactivities')">Send Email &#8250;&#8250; </a></div></td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                        <td colspan="3"><div id="tabgroupgridc1_6"  align="center" style="overflow:auto;">
                                                                                            <table width="100%" cellpadding="3" cellspacing="0" class="table-border-grid">
                                                                                              <tr class="tr-grid-header" align ="left">
                                                                                                <td nowrap = "nowrap" class="td-border-grid" >Sl No</td>
                                                                                                <td nowrap = "nowrap" class="td-border-grid">Activity</td>
                                                                                                <td nowrap = "nowrap" class="td-border-grid">Remarks</td>
                                                                                              </tr>
                                                                                              <tr align ="left">
                                                                                                <td colspan="3" nowrap = "nowrap" class="td-border-grid" ><div align="center"><font color="#FF0000"><strong>No Records to Display</strong></font></div></td>
                                                                                              </tr>
                                                                                            </table>
                                                                                          </div></td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                        <td colspan="3"><div id="getmorerecordslink2" align="left"></div></td>
                                                                                      </tr>
                                                                                    </table>
                                                                                  </div></td>
                                                                              </tr>
                                                                            </table></td>
                                                                        </tr>
                                                                      </table>
                                                                    </div></td>
                                                                </tr>
                                                              </table></td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="3" valign="top"  >&nbsp;</td>
                                                          </tr>
                                                        </table></td>
                                                    </tr>
                                                  </table>
                                                </div></td>
                                              </tr>
                                                <tr>
                                                  <td><div style="display:block" id="displaydiv6">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                      <tr>
                                                        <td>&nbsp;</td>
                                                      </tr>
                                                      <tr>
                                                        <td><div class="errorbox">This Implementation Request has not been Approved please approve it.</div></td>
                                                      </tr>
                                                      <tr>
                                                        <td>&nbsp;</td>
                                                  </tr>
                                                          </table>
                                                        </div></td>
                                                      </tr>
                                                </table>
                                            </div><!-- till here -->
                                            </td>
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
                      <td><div style="display:none">
                          <form action="" method="post" name="colorform1" id="colorform1" onsubmit="return false;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td><div  id='inline_example1' style='background:#fff; width:650px'>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="5" style="border:solid 1px #DDEEFF">
                                      <tr>
                                        <td colspan="2">&nbsp;</td>
                                      </tr>
                                      <tr bgcolor="#f7faff">
                                        <td>Approval Remarks </td>
                                        <td><textarea name="appremarks" cols="80" class="swifttextareanew" id="appremarks" rows="3" style="resize: none;"></textarea></td>
                                      </tr>
                                      <tr>
                                      <td ><div id="form-error5" style="height:35px"></div></td>
                                        <td  align="right"><input type="button" name="approveremarks" class="swiftchoicebutton" value="Update" id="approveremarks" onclick="updatestatus('approve')"/>
                                          &nbsp;&nbsp;
                                          <input type="button" value="Close" id="closepreviewbutton0"  onclick="$().colorbox.close();" class="swiftchoicebutton"/></td>
                                      </tr>
                                    </table>
                                  </div></td>
                              </tr>
                            </table>
                          </form>
                        </div></td>
                    </tr>
                    <tr>
                      <td><div style="display:none">
                          <form action="" method="post" name="colorform2" id="colorform2" onsubmit="return false;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td><div  id='inline_example2' style='background:#fff; width:650px'>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="5" style="border:solid 1px #DDEEFF">
                                      <tr>
                                        <td colspan="2">&nbsp;</td>
                                      </tr>
                                      <tr bgcolor="#f7faff">
                                        <td>Reject Remarks </td>
                                        <td><textarea name="rejremarks" cols="80" class="swifttextareanew" id="rejremarks" rows="3" style="resize: none;"></textarea></td>
                                      </tr>
                                      <tr>
                                      <td><div id="form-error6" style="height:35px"></div></td>
                                        <td align="right"><input type="button" name="rejectremarks" class="swiftchoicebutton" value="Update" id="rejectremarks" onclick="updatestatus('reject')"/>
                                          &nbsp;&nbsp;
                                          <input type="button" value="Close" id="closepreviewbutton1"  onclick="$().colorbox.close();" class="swiftchoicebutton"/></td>
                                      </tr>
                                    </table>
                                  </div></td>
                              </tr>
                            </table>
                          </form>
                        </div></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<script>gettotalcustomercount();</script>
<?php
}
?>

