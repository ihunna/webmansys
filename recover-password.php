<?php 
    require_once('functions.php');
    if(isset($_SESSION['loggedin'])){
       redirect('index.php');
    }
    require_once('mailer.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Recover password | BLABLA</title>
    <?php
         require_once('includes/tags.php');
    ?>
</head>
<body class="">
    <div class="form-div">
        <div class="left-display-div-background">
            <div class="left-display-div-overlay">
                <span>
                    <h2 class="">
                        Recover your forgotten password
                    </h2>
                    <p class="">Enter your email address to get your account</p>
                </span>
            </div>
        </div>
        <form action="recover-password.php" method="post">
            <div class="form-holder">
                <span class="header-sm">
                    <h4 class="">
                        Recover your forgotten password
                    </h4>
                    <p class="">Enter your email address to get your account</p>
                </span>
            <input type="hidden" id="g-token" name="g-token">
            <?php 
                 if(isset($_POST) && isset($_POST['email']) && isset($_POST['g-token'])){
                    $email = $_POST['email'];
                    $token = $_POST['g-token'];
                    
                    // check if captcha is valid
                    if(check_captcha($token)){
                        //check if user exists
                        $result = stmtselect("SELECT email,username FROM users WHERE email=? LIMIT 1",[$email]);
                            if($result){
                                if($result['email'] === $email){
                                    $v_code = md5(rand());
                                    $success = stmtupdate("UPDATE users set v_code=?,v_code_exp=NOW() + INTERVAL 1 HOUR WHERE email=?",[$v_code,$email]);
                                    if($success){
                                    $sendMail = sendMail($email,'Reset password',
                                            '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                                            <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
                                             <head>
                                              <meta charset="UTF-8">
                                              <meta content="width=device-width, initial-scale=1" name="viewport">
                                              <meta name="x-apple-disable-message-reformatting">
                                              <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                              <meta content="telephone=no" name="format-detection">
                                              <title>Password recovery</title>
                                               
                                              <style type="text/css">
                                                @media only screen and (min-width: 620px) {
                                                .u-row {
                                                width: 600px !important;
                                                }
                                                .u-row .u-col {
                                                vertical-align: top;
                                                }

                                                .u-row .u-col-50 {
                                                width: 300px !important;
                                                }

                                                .u-row .u-col-100 {
                                                width: 600px !important;
                                                }

                                                }

                                                @media (max-width: 620px) {
                                                .u-row-container {
                                                max-width: 100% !important;
                                                padding-left: 0px !important;
                                                padding-right: 0px !important;
                                                }
                                                .u-row .u-col {
                                                min-width: 320px !important;
                                                max-width: 100% !important;
                                                display: block !important;
                                                }
                                                .u-row {
                                                width: 100% !important;
                                                }
                                                .u-col {
                                                width: 100% !important;
                                                }
                                                .u-col > div {
                                                margin: 0 auto;
                                                }
                                                }
                                                body {
                                                margin: 0;
                                                padding: 0;
                                                }

                                                table,
                                                tr,
                                                td {
                                                vertical-align: top;
                                                border-collapse: collapse;
                                                }

                                                p {
                                                margin: 0;
                                                }

                                                .ie-container table,
                                                .mso-container table {
                                                table-layout: fixed;
                                                }

                                                * {
                                                line-height: inherit;
                                                }

                                                a[x-apple-data-detectors="true"] {
                                                color: inherit !important;
                                                text-decoration: none !important;
                                                }

                                                table, td { color: #000000; } #u_body a { color: #161a39; text-decoration: underline; }
                                              </style>
                                             </head>
                                             <body style="width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;padding:0;Margin:0">
                                              <div class="es-wrapper-color" style="background-color:#FAFAFA"><!--[if gte mso 9]>
                                                  <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                                                      <v:fill type="tile" color="#fafafa"></v:fill>
                                                  </v:background>
                                                <![endif]-->
                                               <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:#FAFAFA">
                                                 <tr style="border-collapse:collapse">
                                                  <td valign="top" style="padding:0;Margin:0">
                                                   <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                                                     <tr style="border-collapse:collapse">
                                                      <td class="es-adaptive" align="center" style="padding:0;Margin:0">
                                                       <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                                         <tr style="border-collapse:collapse">
                                                          <td align="left" style="padding:10px;Margin:0">
                                                           <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                             <tr style="border-collapse:collapse">
                                                              <td valign="top" align="center" style="padding:0;Margin:0;width:580px">
                                                               <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                 <tr style="border-collapse:collapse">
                                                                  <td align="center" class="es-infoblock" style="padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:14px;color:#CCCCCC;font-size:12px">Reset your password</p></td>
                                                                 </tr>
                                                               </table></td>
                                                             </tr>
                                                           </table></td>
                                                         </tr>
                                                       </table></td>
                                                     </tr>
                                                   </table>
                                                   <table cellpadding="0" cellspacing="0" class="es-header" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
                                                     <tr style="border-collapse:collapse">
                                                      <td class="es-adaptive" align="center" style="padding:0;Margin:0">
                                                       <table class="es-header-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#3d5ca3;width:600px" cellspacing="0" cellpadding="0" bgcolor="#3d5ca3" align="center">
                                                         <tr style="border-collapse:collapse">
                                                          <td style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px;background-color:#3d5ca3" bgcolor="#3d5ca3" align="left"><!--[if mso]><table style="width:560px" cellpadding="0" 
                                                                    cellspacing="0"><tr><td style="width:270px" valign="top"><![endif]-->
                                                           <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                                             <tr style="border-collapse:collapse">
                                                              <td class="es-m-p20b" align="left" style="padding:0;Margin:0;width:270px">
                                                               <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                 <tr style="border-collapse:collapse">
                                                                  <td align="left" style="padding:20px;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:42px;color:#efefef;font-size:28px"><strong style="color:#fff">'.site_name.' Support</strong></p></td>
                                                                 </tr>
                                                               </table></td>
                                                             </tr>
                                                           </table><!--[if mso]></td><td style="width:20px"></td><td style="width:270px" valign="top"><![endif]-->
                                                           <table class="es-right" cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
                                                             <tr style="border-collapse:collapse">
                                                              <td align="left" style="padding:0;Margin:0;width:270px">
                                                               <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                               </table>
                                                               </td>
                                                             </tr>
                                                           </table><!--[if mso]></td></tr></table><![endif]--></td>
                                                         </tr>
                                                       </table></td>
                                                     </tr>
                                                   </table>
                                                   <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                                                     <tr style="border-collapse:collapse">
                                                      <td style="padding:0;Margin:0;background-color:#fafafa" bgcolor="#fafafa" align="center">
                                                       <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#ffffff;width:600px" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                                         <tr style="border-collapse:collapse">
                                                          <td style="padding:0;Margin:0;padding-left:20px;padding-right:20px;padding-top:40px;background-color:transparent;background-position:left top" bgcolor="transparent" align="left">
                                                           <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                             <tr style="border-collapse:collapse">
                                                              <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                                                               <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-position:left top" width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                                 <tr style="border-collapse:collapse">
                                                                  <td align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px;font-size:0"><img src="'.HOST.'/images/site-images/23891556799905703.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="175"></td>
                                                                 </tr>
                                                                 <tr style="border-collapse:collapse">
                                                                  <td align="left" style="padding:0;Margin:0;padding-top:15px;padding-bottom:15px;padding-left:40px"><h1 style="Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#333333"><strong>FORGOT YOUR PASSWORD?</strong></h1></td>
                                                                 </tr>
                                                                 <tr style="border-collapse:collapse">
                                                                  <td align="left" style="padding:0;Margin:0;padding-left:40px;padding-right:40px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:24px;color:#666666;font-size:16px">HI,&nbsp;'.$result["username"].'</p></td>
                                                                 </tr>
                                                                 <tr style="border-collapse:collapse">
                                                                  <td align="left" style="padding:0;Margin:0;padding-right:35px;padding-left:40px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:24px;color:#666666;font-size:16px">There was a request to change your password!</p></td>
                                                                 </tr>
                                                                 <tr style="border-collapse:collapse">
                                                                  <td align="left" style="padding:0;Margin:0;padding-top:25px;padding-left:40px;padding-right:40px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:24px;color:#666666;font-size:16px">If did not make this request, just ignore this email. Otherwise, please click the button below to change your password:</p></td>
                                                                 </tr>
                                                                 <tr style="border-collapse:collapse">
                                                                  <td align="left" style="Margin:0;padding-right:10px;padding-top:40px;padding-bottom:40px;padding-left:40px"><!--[if mso]>
                                                                  <a href="'.HOST.'/recover-password.php?token='.$v_code.'&email='.$email.'" target="_blank" hidden>
                                                                    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" esdevVmlButton href="'.HOST.'/recover-password.php?token='.$v_code.'&email='.$email.'" 
                                                                    style="height:46px; v-text-anchor:middle; width:176px" arcsize="22%" strokecolor="#3d5ca3" strokeweight="2px" fillcolor="#ffffff">
                                                                    <w:anchorlock></w:anchorlock>
                                                                    <center style="color:#3d5ca3; font-family:arial, "helvetica neue", helvetica, sans-serif; font-size:14px; font-weight:700; line-height:14px;  mso-text-raise:1px">RESET PASSWORD</center>
                                                                    </v:roundrect>
                                                                  </a>
                                                                  <![endif]--><!--[if !mso]><!-- --><span class="msohide es-button-border" style="border-style:solid;color:#111;text-decoration:none;border-color:#3D5CA3;background:#FFFFFF;border-width:2px;display:inline-block;border-radius:10px;width:auto;mso-hide:all"><a href="'.HOST.'/recover-password.php?token='.$v_code.'&email='.$email.'"  class="es-button" target="_blank" style="mso-style-priority:100 !important;color:white;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#3D5CA3;font-size:14px;border-style:solid;border-color:#FFFFFF;border-width:15px 20px 15px 20px;display:inline-block;background:#FFFFFF;border-radius:10px;font-family:arial, "helvetica neue", helvetica, sans-serif;font-weight:bold;font-style:normal;line-height:17px;width:auto;text-align:center">RESET PASSWORD</a></span><!--<![endif]--></td>
                                                                 </tr>
                                                               </table></td>
                                                             </tr>
                                                           </table></td>
                                                         </tr>
                                                       </table></td>
                                                     </tr>
                                                   </table>
                                                   <table class="es-footer" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
                                                     <tr style="border-collapse:collapse">
                                                      <td style="padding:0;Margin:0;background-color:#fafafa" bgcolor="#fafafa" align="center">
                                                       <table class="es-footer-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px">
                                                         <tr style="border-collapse:collapse">
                                                          <td style="Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;padding-bottom:30px;background-color:#0b5394;background-position:left top" bgcolor="#0b5394" align="left">
                                                           <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                             <tr style="border-collapse:collapse">
                                                              <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                                                               <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                 <tr style="border-collapse:collapse">
                                                                  <td align="left" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px"><h2 style="Margin:0;line-height:19px;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:16px;font-style:normal;font-weight:normal;color:#ffffff"><strong>Have quastions?</strong></h2></td>
                                                                 </tr>
                                                                 <tr style="border-collapse:collapse">
                                                                  <td align="left" style="padding:0;Margin:0;padding-bottom:5px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:21px;color:#ffffff;font-size:14px">We are here to help, learn more about us <a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;color:#ffffff;font-size:14px" href="">here</a></p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:21px;color:#ffffff;font-size:14px">or <a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;color:#ffffff;font-size:14px" href="">contact us</a><br></p></td>
                                                                 </tr>
                                                                 <tr style="border-collapse:collapse">
                                                                  <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-bottom:5px;padding-top:10px;font-size:0px">
                                                                   <table class="es-table-not-adapt es-social" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                     <tr style="border-collapse:collapse">
                                                                      <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px"><img src="'.HOST.'/images/site-images/facebook-circle-black.png" alt="Fb" title="Facebook" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></td>
                                                                      <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px"><img src="'.HOST.'/images/site-images/twitter-circle-black.png" alt="Tw" title="Twitter" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></td>
                                                                      <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px"><a target="_blank" href="https://www.instagram.com/BLABLA/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;color:#333333;font-size:14px"><img src="'.HOST.'/images/site-images/instagram-circle-black.png" alt="Ig" title="Instagram" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>
                                                                      <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px"><img src="'.HOST.'/images/site-images/youtube-circle-black.png" alt="Yt" title="Youtube" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></td>
                                                                      <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px"><img src="'.HOST.'/images/site-images/linkedin-circle-black.png" alt="In" title="Linkedin" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></td>
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
                                                   <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                                                     <tr style="border-collapse:collapse">
                                                      <td style="padding:0;Margin:0;background-color:#fafafa" bgcolor="#fafafa" align="center">
                                                       <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" bgcolor="transparent" align="center">
                                                         <tr style="border-collapse:collapse">
                                                          <td style="padding:0;Margin:0;padding-top:15px;background-position:left top" align="left">
                                                           <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                             <tr style="border-collapse:collapse">
                                                              <td valign="top" align="center" style="padding:0;Margin:0;width:600px">
                                                               <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                 <tr style="border-collapse:collapse">
                                                                  <td style="padding:0;Margin:0">
                                                                   <table class="es-menu" width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                   </table></td>
                                                                 </tr>
                                                                 <tr style="border-collapse:collapse">
                                                                  <td align="center" style="padding:0;Margin:0;padding-bottom:20px;padding-left:20px;padding-right:20px;font-size:0">
                                                                   <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                     <tr style="border-collapse:collapse">
                                                                      <td style="padding:0;Margin:0;border-bottom:1px solid #fafafa;background:none;height:1px;width:100%;margin:0px"></td>
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
                                                   <table class="es-footer" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
                                                     <tr style="border-collapse:collapse">
                                                      <td style="padding:0;Margin:0;background-color:#fafafa" bgcolor="#fafafa" align="center">
                                                       <table class="es-footer-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" bgcolor="transparent" align="center">
                                                         <tr style="border-collapse:collapse">
                                                          <td align="left" style="Margin:0;padding-bottom:5px;padding-top:15px;padding-left:20px;padding-right:20px">
                                                           <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                             <tr style="border-collapse:collapse">
                                                              <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                                                               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                 <tr style="border-collapse:collapse">
                                                                  <td align="center" style="padding:0;Margin:0;display:none"></td>
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
                                             </body>
                                            </html>
                                            '
                                        );
                                        if($sendMail){
                                            echo '<div class="successful">
                                                    A verification link has been sent to your email.
                                                </div>';
                                        }else{
                                            echo '<div class="unsuccessful">
                                                Something went wrong, try again.
                                            </div>';
                                        }
                                    }else{
                                        echo '<div class="unsuccessful">
                                                Something went wrong, try again.
                                            </div>';
                                    }
                                }else{
                                    echo  '<div class="unsuccessful">';
                                    echo 'Account does not exist';
                                    echo '</div>';
                                }
                            }else{
                                echo  '<div class="unsuccessful">';
                                echo 'Account does not exist';
                                echo '</div>';
                            }
                    }else{
                        echo  '<div class="unsuccessful">';
                        echo 'Invalid captcha';
                        echo '</div>';
                    }
                }else if(isset($_POST) && isset($_POST['token']) && isset($_POST['checkEmail']) && isset($_POST['g-token'])){
                    $email = $_POST['checkEmail'];
                    $password = $_POST['password'];
                    $cpassword = $_POST['cpassword'];
                    $token = $_POST['g-token'];
                    $v_token = $_POST['token'];
                    // check if captcha is valid
                    if(check_captcha($token)){
                        //validating input
                        if(validate($email,$password,'','','login')[1]){
                            if($password != $cpassword){
                                $error = 1;
                               return(redirect("recover-password.php?token=$v_token&email=$email&error=$error"));
                            }
                            $v_code = stmtselectSingle("SELECT v_code FROM users WHERE email=? LIMIT 1",[$email]);
                            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                            if($v_code === $v_token){
                                try{
                                    $v_code_exp = count_rows("SELECT COUNT(v_code) FROM users 
                                    WHERE v_code=? AND v_code_exp >= NOW() LIMIT 1",[$v_code]);

                                    if($v_code < 1){
                                        echo '<div class="unsuccessful">
                                            Token has expired
                                        </div>';
                                    }else{
                                        $new_token = md5(rand());
                                        stmtupdate("UPDATE users SET password=?,v_code=?,v_code_exp =NOW() + INTERVAL 1 HOUR  
                                        WHERE email=?",[$hashed_password,$new_token,$email]);
                                        echo '<div class="successful">
                                            Password updated <a href="login.php">Login<a>
                                        </div>';
                                        redirect_delay(2,'login.php');
                                    }                  
                                }catch(Exception $e){
                                    echo '<div class="unsuccessful">
                                        Something went wrong
                                    </div>';
                                }
                            }else{
                                echo  '<div class="unsuccessful">';
                                echo 'Invalid token';
                                echo '</div>';
                            }
                        }else if(!validate($email,$password,'','','login')[1]){
                            $errors = validate($email,$password,'','','login')[0];
                            echo  '<div class="unsuccessful">';
                            foreach($errors as $e){
                                echo ' '.$e.'.  ';
                            }
                            echo '</div>';
                        }
                    }else{
                        echo  '<div class="unsuccessful">';
                        echo 'Invalid captcha';
                        echo '</div>';
                    }
                }else if(isset($_GET['token'])){
                    if(isset($_GET['error'])){
                        echo '<div class="unsuccessful">
                        Passwords does not match
                        </div>';
                    }
                    echo '
                        <input type="hidden" name="token" value="'.$_GET['token'].'" readonly>
                        <div class="input-control">
                            <label for="checkEmail">Email</label>
                            <input type="email" name="checkEmail" value="'.$_GET['email'].'" readonly>
                            <div class="error"></div>
                        </div>
                        <div class="input-control">
                            <label for="password">New password</label>
                            <input type="password" name="password" id="password">
                            <div class="error"></div>
                        </div>
                        <div class="input-control">
                            <label for="cpassword">New password</label>
                            <input type="password" name="cpassword" id="cpassword">
                            <div class="error"></div>
                        </div>
                        <div class="form-footer-flex">
                            <div>
                                Not registered? <a href="signup.php">Signup</a>
                            </div>
                            <div>
                                Already have an account? <a href="login.php">Login</a>
                            </div>
                        </div>
                        <input class="submit-btn" type="submit" value="Change password">
                        </form>
                        </div>
                        <script src="https://www.google.com/recaptcha/api.js?render='.site_key.'"></script>
                        <script>
                            window.addEventListener("load", ()=>{
                                //asigning captcha token
                                try{
                                grecaptcha.ready(function() {
                                    grecaptcha.execute("'.site_key.'", {action: "submit"}).then(function(token) {
                                        document.getElementById("g-token").value = token;
                                        });
                                    });
                                }catch(error){
                                    console.log(error);
                                }
                            })
                        </script>
                        </body>
                    </html>';
                    die();
                }
            ?>
                <div class="input-control">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                    <div class="error"></div>
                </div>
                <div class="form-footer-flex">
                    <div>
                        Not registered? <a href="signup.php">Signup</a>
                    </div>
                    <div>
                        Already have an account? <a href="login.php">Login</a>
                    </div>
                </div>
                <input class="submit-btn" type="submit" value="Change password">
            </div>
        </form>
    </div>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo site_key;?>"></script>
    <script>
        window.addEventListener('load', ()=>{
             //asigning captcha token
             try{
            grecaptcha.ready(function() {
                grecaptcha.execute('<?php echo site_key; ?>', {action: 'submit'}).then(function(token) {
                    document.getElementById('g-token').value = token;
                    });
                });
            }catch(error){
                console.log(error);
            }
        })
    </script>
</body>
</html>