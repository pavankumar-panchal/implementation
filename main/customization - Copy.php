<? 
$userid = imaxgetcookie('userslno');
$query = "select implementertype,coordinator from inv_mas_implementer where slno = '".$userid."'";
$resultfetch = runmysqlqueryfetch($query);
$implementertype = $resultfetch['implementertype'];
$coordinator = $resultfetch['coordinator'];
if($implementertype == 'customizer' || $coordinator == 'yes')
{

?>
<link href="../style/style.css?dummy=<? echo (rand());?>" rel=stylesheet>
<script language="javascript" src="../functions/customization.js?dummy=<? echo (rand());?>"></script>
<script language="javascript" src="../functions/javascript.js?dummy=<? echo (rand());?>"></script>
<script language="javascript" src="../functions/datepickercontrol.js?dummy=<? echo (rand());?>" type="text/javascript"></script>
<script language="javascript" src="../functions/fileupload.js?dummy=<? echo (rand());?>"></script>
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
                            <td width="27%" align="left" valign="middle" class="active-leftnav">Customization</td>
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
                                                  <td width="23%" onclick="tabopen2('2','tabg1')" class="producttabhead" id="tabg1h2" style="cursor:pointer;"><div align="center"><strong>Customization</strong></div></td>
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
                                            <td><div style="display:block; "  align="justify" id="tabg1c1" >
                                                <table width="100%" border="0" cellspacing="0" cellpadding="2" class="productcontent" height="350px">
                                               <tr>
                                                  <td  height="35px;"><div id="loadingdiv"><span  style="padding-left:25px"><strong><font color="#FF0000">Select A Customer</font></strong> </span></div></td>
                                                </tr>
                                                  <tr>
                                                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactcontentdisplay" style="border:1px solid #D6D6D6"   >
                                                              <tr style="height:25px;"  bgcolor="#D6D6D6" >
                                                                <td width="23%" style="padding-left:8px; padding-top:5px;" valign="top"><strong>1.	Invoice Information</strong></td>
                                                                <td width="72%" bgcolor="#D6D6D6"  style="padding-left:8px; padding-top:5px;"><span class="header-line" style="padding:0">
                                                                  <input type="hidden" name="lastslno" id="lastslno"/>
                                                                  <input type="hidden" name="implastslno" id="implastslno"/>
                                                                  <input type="hidden" name="impreflastslno" id="impreflastslno"/>
                                                                  <input type="hidden" name="impcustomizationlastslno" id="impcustomizationlastslno"/>
                                                                  <span class="header-line" style="padding:0">
                                                                  <input type="hidden" name="custfilepath" id="custfilepath"/>
                                                                  </span></span></td>
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
                                                                            <td valign="top" bgcolor="#edf4ff">&nbsp;</td>
                                                                          </tr>
                                                                          <tr>
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
                                                                            <td width="36%" align="left" valign="top" bgcolor="#EDF4FF">PO Number and Date :</td>
                                                                            <td width="52%" align="left" valign="top" bgcolor="#EDF4FF"  id="pouploadlink_filename">Not Available</td>
                                                                            <td width="12%" align="right" valign="top" bgcolor="#EDF4FF" id="pouploadlink_errorfile">&nbsp;</td>
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
                                                              <tr>
                                                                <td  colspan="3"></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                      </table></td>
                                                  </tr>
                                                </table>
                                              </div>
                                              <div style="display:none; " align="justify" id="tabg1c2">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="8" id="visitrowdisplay">
                                                      <tr>
                                                        <td width="32%"><strong>Select a Customization Details</strong>: </td>
                                                        <td width="29%" id="griddetails"><select name="custgrid" class="swiftselect" id="custgrid" style="width:200px;">
                                                            <option value="" selected="selected">-- Select --</option>
                                                        </select></td>
                                                        <td width="39%" ><a class="r-text" onclick="assigneddaysgridtoform();">Go &#8250;&#8250;</a></td>
                                                      </tr>
                                                    </table></td>
                                                  </tr>
                                                  <tr>
                                                    <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                        <tr bgcolor="#EDF4FF">
                                                          <td width="14%">Assigned Date:</td>
                                                          <td width="34%" id="assigneddate" style="border-right:1px solid  #C6E2FF">&nbsp;</td>
                                                          <td width="13%">Work Date:</td>
                                                          <td width="39%"><input name="DPC_attachfromdate1" type="text" class="swifttext-mandatory" id="DPC_attachfromdate1" size="30" autocomplete="off" value="<? echo(datetimelocal('d-m-Y')); ?>" readonly="readonly"/></td>
                                                        </tr>
                                                        <tr bgcolor="#EDF4FF">
                                                          <td valign="top">Day Remarks:</td>
                                                          <td style="border-right:1px solid  #C6E2FF"><textarea name="dayremarks" cols="27" class="swifttextarea" id="dayremarks" ></textarea></td>
                                                          <td>&nbsp;</td>
                                                          <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                          <td colspan="4" style="border-top:1px solid  #C6E2FF"><table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                              <tr >
                                                                <td width="56%"><div id="form-error1" align="left">&nbsp;</div></td>
                                                                <td width="44%"><div align="center">&nbsp;
                                                                    <input name="update"  value="Update" type="submit" class="swiftchoicebutton" id="update"  onclick="assigndaysupdate('save');"/>
                                                                    &nbsp;</div></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                      </table></td>
                                                  </tr>
                                                  <tr>
                                                    <td height="2px;"></td>
                                                  </tr>
                                                  <tr>
                                                    <td bgcolor="#000000" height="2px;"></td>
                                                  </tr>
                                                  <tr>
                                                    <td  height="2px;"></td>
                                                  </tr>
                                                  <tr>
                                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                        <tr>
                                                          <td><strong>Customization Files:</strong></td>
                                                        </tr>
                                                        <tr bgcolor="#f7faff">
                                                          <td><table width="100%" border="0" cellspacing="0" cellpadding="4">
                                                              <tr bgcolor="#edf4ff">
                                                                <td width="15%" valign="top">Attachment File:</td>
                                                                <td width="34%" valign="top" bgcolor="#edf4ff" style="border-right:1px solid  #C6E2FF"><input name="solutionfile" type="text" class="swifttext" id="solutionfile" size="30"  autocomplete="off" readonly="readonly"  style="background:#FEFFE6;"/>
                                                                  <img src="../images/fileattach.jpg" name="myfileuploadimage1" border="0" align="absmiddle" id="myfileuploadimage1" onclick="fileuploaddivid('','solutionfile','fileuploaddiv','530px','30%','2',document.getElementById('customerlist').value,'filelink')"/> <span id="downloadlinkfile1"></span> <span class="header-line" style="padding:0">
                                                                  <input type="hidden" name="filelink" id="filelink"/>
                                                                  <input type="hidden" name="filepath" id="filepath"/>
                                                                 </span> <span class="textclass">(Upload zip file only)</span></td>
                                                                <td width="14%"   align="left"  valign="top" bgcolor="#EDF4FF" id="downloadlinkfile1" >Remarks:</td>
                                                                <td width="37%"   align="left"  valign="top" bgcolor="#EDF4FF" id="downloadlinkfile1" ><textarea name="customizationremarks" cols="27" class="swifttextarea" id="customizationremarks" ></textarea></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                        <tr>
                                                          <td style="border-top:1px solid  #C6E2FF"><table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                              <tr>
                                                                <td width="55%"><div id="form-error2" align="left">&nbsp;</div></td>
                                                                <td width="45%"><div align="center">
                                                                    <input name="new2"  value="New" type="submit" class="swiftchoicebutton" id="new2"  onclick="newentry();document.getElementById('form-error2').innerHTML = '';"/>
                                                                    &nbsp;
                                                                    <input name="save2"  value="Save" type="submit" class="swiftchoicebutton" id="save2"  onclick="customizationfilesupdate('save');"/>
                                                                    &nbsp;
                                                                    <input name="delete2"  value="Delete" type="submit" class="swiftchoicebutton" id="delete2"  onclick="customizationfilesupdate('delete');"/>
                                                                  </div></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                        <tr>
                                                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                                                                <td colspan="2"><div id="getmorerecordslink" align="left"></div></td>
                                                              </tr>
                                                            </table></td>
                                                        </tr>
                                                      </table></td>
                                                  </tr>
                                                  <tr>
                                                    <td>&nbsp;</td>
                                                  </tr>
                                                  <tr>
                                                    <td><!--<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #308ebc; border-top:none;">
                                        <tr class="header-line">
                                          <td width="42%" align="left"  style="padding:0"><div id="tabdescription" align="right">&nbsp; Days Assigned: </div></td>
                                          <td width="17%" style="padding:0; text-align:center;"><div align="left"><span id="tabgroupgridwb1"></span></div></td>
                                          <td width="28%" align="left"  style="padding:0">&nbsp;</td>
                                          <td width="13%" align="left"  style="padding:0">&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td colspan="4" align="left" valign="top"><div id="tabgroupgridc1" style="overflow:auto; height:200px; width:704px; padding:2px;" align="center">
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td><div id="tabgroupgridc1_2" align="center"></div></td>
                                                </tr>
                                                <tr>
                                                  <td><div id="tabgroupgridc1link"  align="left" style="height:20px; padding:2px;"> </div></td>
                                                </tr>
                                              </table>
                                          </div>
                                              <div id="resultgrid" style="overflow:auto; display:none; height:150px;padding:2px;width:704px;" align="center">&nbsp;</div></td>
                                        </tr>
                                      </table>--></td>
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
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<div id="fileuploaddiv" style="display:none;">
  <? include('../inc/fileuploadform.php'); ?>
</div>
<script>
refreshcustomerarray();
</script>
<?
}
else
{
		$grid = '<table width="952" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" height = "200">';
		$grid .= ' <tr><td height = "60">&nbsp;</td></tr>';
		$grid .= '<tr><td valign="top" style="font-size:14px"><strong><div align="center"><font color="#FF0000">You are not authorised to view this page.</font></div></strong></td></tr>';
		echo($grid);
}
?>