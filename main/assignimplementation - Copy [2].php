<? 
	$userid = imaxgetcookie('userslno');
	$query = "select implementertype,coordinator from inv_mas_implementer where slno = '".$userid."'";
	$resultfetch = runmysqlqueryfetch($query);
	$implementertype = $resultfetch['implementertype'];
	$coordinator = $resultfetch['coordinator'];
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
<link href="../style/style.css?dummy=<? echo (rand());?>" rel=stylesheet>
<link media="screen" rel="stylesheet" href="../style/colorbox.css?dummy=<? echo (rand());?>" />
<script language="javascript" src="../functions/assignimplementation.js?dummy=<? echo (rand());?>"></script>
<script language="javascript" src="../functions/getdistrictjs.php?dummy=<? echo (rand());?>"></script>
<script language="javascript" src="../functions/javascript.js?dummy=<? echo (rand());?>"></script>
<script language="javascript" src="../functions/datepickercontrol.js?dummy=<? echo (rand());?>" type="text/javascript"></script>
<script language="javascript" src="../functions/jquery.colorbox.js?dummy=<? echo (rand());?>"></script>
<div style="left: -1000px; top: 597px;visibility: hidden; z-index:100" id="tooltip1">dummy</div>
<script language="javascript" src="../functions/tooltip.js?dummy=<? echo (rand());?>"></script>
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
                            <td width="33%"><div align="right"></div></td>
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
                            <td align="left" class="header-line" style="padding:0">&nbsp;&nbsp;Enter / Edit / View Details </td>
                            <td align="right" class="header-line" style="padding-right:7px"></td>
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
                                                  <td colspan="10" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6"  bgcolor="#FFFFF0">
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
                                                  <td width="23%" onclick="tabopen2('2','tabg1')" class="producttabhead" id="tabg1h2" style="cursor:pointer;"><div align="center"><strong>Assign Implementation</strong></div></td>
                                                  <td width="19%" class="producttabheadnone">&nbsp;</td>
                                                  <td width="7%" class="producttabhead" ></td>
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
                                                        <tr>
                                                          <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6"   >
                                                              <tr style="height:25px;"  bgcolor="#D6D6D6" >
                                                                <td width="23%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>1.Invoice Information</strong></td>
                                                                <td width="72%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;"><span class="header-line" style="padding:0">
                                                                  <input type="hidden" name="lastslno" id="lastslno"/>
                                                                  <input type="hidden" name="implastslno" id="implastslno"/>
                                                                  <input type="hidden" name="impreflastslno" id="impreflastslno"/>
                                                                  <input type="hidden" name="impactivitylastslno" id="impactivitylastslno"/>
                                                                  <input type="hidden" name="customizationlastslno" id="customizationlastslno"/>
                                                                  <input type="hidden" name="filepath" id="filepath"/>
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
                                                        <tr>
                                                          <td >&nbsp;</td>
                                                        </tr>
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
                                                                  <td colspan="3" valign="top"  ><table width="100%" border="0" cellspacing="0" cellpadding="4" >
                                                                      <tr>
                                                                        <td width="18%">Currently With:
                                                                        <input type="hidden" name="hiddenimplementerid" id="hiddenimplementerid" /></td>
                                                                        <td width="22%"  height="35px;" id="displayimplementername">Not Available</td>
                                                                        <td width="12%">Assign To:</td>
                                                                        <td width="48%"><select name="assigndays_imp" class="swiftselect" id="assigndays_imp" style="width:175px;">
                                                                            <option value="" selected="selected">Select an Implementer</option>
                                                                            <? include('../inc/implementer.php')?>
                                                                          </select>
                                                                          &nbsp;<a class="r-text" onclick="assignimplementation('implementation','displayimplementername','assigndays_imp');">Go &#8250;&#8250; </a>&nbsp;<span id="sendemail1"><a class="r-text" onclick="sendemailonupdate('assignedimplementer')">Send Email &#8250;&#8250; </a></span></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td colspan="4" ><div class="imp_title_bar">
                                                                            <div class="imp_rounder" ></div>
                                                                            <span>Assign Days </span></div>
                                                                          <div class="imp_dashboard_module" >
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
                                                                            <span>Assigned Days </span></div>
                                                                          <div class="imp_dashboard_module" >
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="4" >
                                                                              <tr>
                                                                                <td width="14%">Date:</td>
                                                                                <td width="37%"><input name="DPC_attachfromdate1" type="text" class="swifttext-mandatory" id="DPC_attachfromdate1" size="30" autocomplete="off" value="<? echo(datetimelocal('d-m-Y')); ?>" readonly="readonly"/></td>
                                                                                <td width="12%" valign="top">Remarks:</td>
                                                                                <td width="37%" valign="top"><input name="assigndays_remarks" type="text" class="swifttext-mandatory" id="assigndays_remarks" size="35" autocomplete="off" value="" /></td>
                                                                              </tr>
                                                                              <tr>
                                                                                <td width="14%">Visit Number:</td>
                                                                                <td colspan="3" id="visitnumberdisplay">Not Available</td>
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
                                                                                        <td width="19%"><strong>Total Visits:</strong></td>
                                                                                        <td width="81%"><div align="left" id="tabgroupcount">Not Available</div></td>
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
                                                                            <span>Assign Activities </span></div>
                                                                          <div class="imp_dashboard_module" >
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                                              <tr>
                                                                                <td width="13%" valign="top">Activity:</td>
                                                                                <td width="38%" valign="top"><select name="assignactivity" class="swiftselect" id="assignactivity" style="width:200px;">
                                                                                    <option value="" selected="selected">Select an Activity</option>
                                                                                    <? include('../inc/activity.php')?>
                                                                                  </select></td>
                                                                                <td width="12%" valign="top">Remarks:</td>
                                                                                <td width="37%" valign="top"><input name="assignactivity_remarks" type="text" class="swifttext-mandatory" id="assignactivity_remarks" size="35" autocomplete="off" value="" /></td>
                                                                              </tr>
                                                                              <tr>
                                                                                <td colspan="4"><table width="100%" border="0" cellpadding="3" cellspacing="0">
                                                                                    <tr>
                                                                                      <td width="55%"><div id="form-error2" align="left">&nbsp;</div></td>
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
                                                                                              <td width="42%"><div align="left" id="tabgroupcount2">Not Available</div></td>
                                                                                              <td width="42%"><div align="right" id="sendemail3"><a class="r-text" onclick="sendemailonupdate('assignedactivities')">Send Email &#8250;&#8250; </a></div></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                              <td colspan="3"><div id="tabgroupgridc1_2"  align="center">
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
                                                                              <? include('../inc/customizer.php')?>
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
                                                                          <td valign="top"><input name="DPC_attachfromdate2" type="text" class="swifttext-mandatory" id="DPC_attachfromdate2" size="30" autocomplete="off" value="<? echo(datetimelocal('d-m-Y')); ?>" readonly="readonly"/></td>
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
                                                                              <? include('../inc/webimplementer.php')?>
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
                                              </div></td>
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
<?
}
?>
