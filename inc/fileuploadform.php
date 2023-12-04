<form name="fileuploadform"  id="fileuploadform" action="../inc/fileupload.php?id=2&divid=fileuploaddiv" method="post" enctype="multipart/form-data" target="upload_target2" onsubmit="startUpload('2');" >
    <table width="100%" border="0" cellspacing="0" cellpadding="3" style="border:1px #333333 solid">
      <tr>
        <td id="f1_upload_process2" style="color:#FFFFFF;text-align:center" height="20px"></td>
      </tr>
      <tr>
        <td id="f1_upload_form2" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
              <td><label>File:
                <input name="myfile2" type="file" size="30" />
                <br />
                <br />
                </label>
              </td>
            </tr>
            <tr>
              <td align="center"><input type="hidden" id="span_downloadlinkfile2" name="span_downloadlinkfile2" value="" />
                <input type="hidden" id="text_filebox2" name="text_filebox2" value="" class="swiftchoicebutton" />
                 <input type="hidden" id="linkvalue2" name="linkvalue2" value=""  />
                  <input type="hidden2" id="cusid2" name="cusid2" value=""  />
                   <input type="hidden" id="link2" name="link2" value="" class="swiftchoicebutton"/>
                <input type="submit" name="submitBtn" class="dpButton" value="Upload" />
                &nbsp;
                <input name="cancel" type="button" class="dpButton" id="cancel" value="Cancel" onclick="document.getElementById('fileuploaddiv').style.display='none'" />
              </td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td><iframe id="upload_target" name="upload_target2" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>