<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>:: RightNext ::</title>
   </head>
   <body style="background:#f1f1f1; margin:0px; padding:0px; font-size:12px; font-family:Arial, Helvetica, sans-serif; line-height:21px; color:#666; text-align:justify;">
      <div style="max-width:630px;width:100%;margin:0 auto;">
         <div style="padding:0px 15px;">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                  <td>&nbsp;</td>
               </tr>
               <tr>
                  <td bgcolor="#FFFFFF" style="padding:15px; border:1px solid #e5e5e5;">
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                           <td>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                 <tr style="background:#fbfbfb;">
                    <td style="padding: 10px;"><a href="#"><img src="<?php echo url('/'); ?>/assets/front/images/logo_header.png"  alt="logo" style="max-width: 221px;width: 100%;"></a></td>
                                    <td align="right" style="font-size:13px; font-weight:bold;padding-right: 10px;color:#000000;"><?php echo date('d M Y') ?></td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td height="10"></td>
                        </tr>
                        <tr>
                           <td  height="1" bgcolor="#ddd"></td>
                        </tr>
                        <tr>
                           <td  height="10"></td>
                        </tr>
                        <tr>
                           <td>
                              <strong>Hello</strong> &nbsp;{{ $email }}
                              <br/>
                           </td>
                        </tr>
                        <tr>
                            <td>
                              <strong>Your password has been changed successfully.</strong> <br/>

                               Your new password is:<strong> &nbsp;&nbsp; {{ $new_password }} </strong><br />
                            
                              <br/>
                              <p>
                                 <strong>Thanks &amp; Regards</strong>
                              </p>
                              
                           </td>
                        </tr>
                        <tr>
                           <td height="2" bgcolor="#202020"></td>
                        </tr>
                        <tr>
                           <td height="10" style="background-color:#202020;"></td>
                        </tr>
                        <tr>
                           <td style="text-align:center; color:#aeaeae;background-color:#202020; padding-bottom:10px;"> Copyrights © <?php echo date("Y"); ?> by<span style="color:#fff;"> RightNext.com</span> All Rights Reserved. </td>
                        </tr>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td>&nbsp;</td>
               </tr>
            </table>
         </div>
      </div>
   </body>
</html>