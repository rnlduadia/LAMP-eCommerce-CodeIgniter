<?php if($email_type == "Supplier Approval Email"){?>
    <table width="360" height="460">
        <tr>
            <td height="60" style="vertical-align:top;">
                <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>/images/mails/logo.png" alt="" style="width:92px; height:40px;"></a>
            </td>
        </tr>
        <tr>
            <td style="border-top: solid 1px #0e76bc; border-bottom: solid 1px #0e76bc; vertical-align:middle;" height="28">
                <h1 style="color:#333; font: 300 14px 'Open Sans', Arial, sans-serif; margin:0;">Welcome to OceanTailer,</h1>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <p style="margin:0; color:#333; font: 300 13px 'Open Sans', sans-serif;">Your account has been activated by Admin. Your account details are listed below.</p>
                <br>
                <p style="margin:0; color:#333; font: 300 13px 'Open Sans', sans-serif;">Ocean Tailer Account</p>
                <br>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>First Name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $supplier_info->u_fname; ?></p>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Last Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $supplier_info->u_lname; ?></p>
                <br>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Username: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $supplier_info->u_username; ?></p>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $supplier_info->u_email; ?></p>
                <br><br>
                <p style="margin:0; color:#333; font: 300 13px 'Open Sans', sans-serif;">Thank you for choosing Ocean Tailer as your partner in selling your products.
                    <br>By Admin</p>
                <br>
            </td>
        </tr>
        <tr>
            <td>
                <table width="460" style="vertical-align:middle; border-bottom: solid 1px #0e76bc;">
                    <tr >
                        <td style="">
                            <p style="margin:0; color:#4c4c4c; font: normal 12px 'Open Sans', sans-serif; text-align:right;">Find Us:</p>
                        </td>
                        <td style="width: 140px;">
                            <a href="https://www.facebook.com/pages/OceanTailer/1440325089552653/"><img src="<?php echo base_url();?>/images/mails/fb.png" alt="" style="width:24px; height:24px; "></a>
                            <a href="https://twitter.com/oceantailer/"><img src="<?php echo base_url();?>/images/mails/tw.png" alt="" style="width:24px; height:24px; "></a>
                            <a href="https://plus.google.com/u/1/108778239825863511607/"><img src="<?php echo base_url();?>/images/mails/gplus.png" alt="" style="width:24px; height:24px; "></a>
                            <a href="http://www.pinterest.com/oceantailer/"><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/';?>/images/mails/p.png" alt="" style="width:24px; height:24px; "></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <p style="margin:0; color:#4c4c4c; font: 300 11px 'Open Sans', sans-serif; text-align:center; padding-top:10px;">Copyright © 2014 OceanTailer</p>
            </td>
        </tr>
    </table>
<?php }?>
<?php if($email_type == "Buyer Activate Email"){?>
    <table width="360" height="460">
        <tr>
            <td height="60" style="vertical-align:top;">
                <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>/images/mails/logo.png" alt="" style="width:92px; height:40px;"></a>
            </td>
        </tr>
        <tr>
            <td style="border-top: solid 1px #0e76bc; border-bottom: solid 1px #0e76bc; vertical-align:middle;" height="28">
                <h1 style="color:#333; font: 300 14px 'Open Sans', Arial, sans-serif; margin:0;">Welcome to OceanTailer,</h1>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <p style="margin:0; color:#333; font: 300 13px 'Open Sans', sans-serif;">Your account has been activated by Admin. Your account details are listed below.</p>
                <br>
                <p style="margin:0; color:#333; font: 300 13px 'Open Sans', sans-serif;">Ocean Tailer Account</p>
                <br>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>First Name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $buyer_info->u_fname; ?></p>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Last Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $buyer_info->u_lname; ?></p>
                <br>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Username: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $buyer_info->u_username; ?></p>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $buyer_info->u_email; ?></p>
                <br>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;">Verification Link:</p>
                <p style="margin:0; color:#333; font: 300 13px 'Open Sans', sans-serif;">To Verify the Account Click the link <a href="<?php echo base_url()?>buyer/activate/<?php echo $buyer_info->u_verify_code; ?>" style="color:#2b87c4; text-decoration:none;">(here)</a></p>
                <br><br>
                <p style="margin:0; color:#333; font: 300 13px 'Open Sans', sans-serif;">Thank you for choosing Ocean Tailer as your online shopping store.
                    <br>By Admin</p>
                <br>
            </td>
        </tr>
        <tr>
            <td>
                <table width="460" style="vertical-align:middle; border-bottom: solid 1px #0e76bc;">
                    <tr >
                        <td style="">
                            <p style="margin:0; color:#4c4c4c; font: normal 12px 'Open Sans', sans-serif; text-align:right;">Find Us:</p>
                        </td>
                        <td style="width: 140px;">
                            <a href="https://www.facebook.com/pages/OceanTailer/1440325089552653/"><img src="<?php echo base_url();?>/images/mails/fb.png" alt="" style="width:24px; height:24px; "></a>
                            <a href="https://twitter.com/oceantailer/"><img src="<?php echo base_url();?>/images/mails/tw.png" alt="" style="width:24px; height:24px; "></a>
                            <a href="https://plus.google.com/u/1/108778239825863511607/"><img src="<?php echo base_url();?>/images/mails/gplus.png" alt="" style="width:24px; height:24px; "></a>
                            <a href="http://www.pinterest.com/oceantailer//"><img src="<?php echo base_url();?>/images/mails/p.png" alt="" style="width:24px; height:24px; "></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <p style="margin:0; color:#4c4c4c; font: 300 11px 'Open Sans', sans-serif; text-align:center; padding-top:10px;">Copyright © 2014 OceanTailer</p>
            </td>
        </tr>
    </table>
<?php }?>
<?php if($email_type == "Administrator Account Activate Email"){?>
    <table width="360" height="460">
        <tr>
            <td height="60" style="vertical-align:top;">
                <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>/images/mails/logo.png" alt="" style="width:92px; height:40px;"></a>
            </td>
        </tr>
        <tr>
            <td style="border-top: solid 1px #0e76bc; border-bottom: solid 1px #0e76bc; vertical-align:middle;" height="28">
                <h1 style="color:#333; font: 300 14px 'Open Sans', Arial, sans-serif; margin:0;">Welcome to OceanTailer,</h1>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <p style="margin:0; color:#333; font: 300 13px 'Open Sans', sans-serif;">New Administrator Account has been created. Your account details are listed below.</p>
                <br>
                <p style="margin:0; color:#333; font: 300 13px 'Open Sans', sans-serif;">Ocean Tailer Administrator Account</p>
                <br>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Username: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $username; ?></p>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $password; ?></p>
                <br>
                <p style="margin:0; color:#333; font: 300 13px 'Open Sans', sans-serif;">You can login to your account at <a href="<?php echo base_url()?>" style="color:#2b87c4; text-decoration:none;">(here)</a></p>
                <br>
                <br>By Admin</p>
                <br>
            </td>
        </tr>
        <tr>
            <td>
                <table width="460" style="vertical-align:middle; border-bottom: solid 1px #0e76bc;">
                    <tr >
                        <td style="">
                            <p style="margin:0; color:#4c4c4c; font: normal 12px 'Open Sans', sans-serif; text-align:right;">Find Us:</p>
                        </td>
                        <td style="width: 140px;">
                            <a href="https://www.facebook.com/pages/OceanTailer/1440325089552653/"><img src="<?php echo base_url();?>/images/mails/fb.png" alt="" style="width:24px; height:24px; "></a>
                            <a href="https://twitter.com/oceantailer/"><img src="<?php echo base_url();?>/images/mails/tw.png" alt="" style="width:24px; height:24px; "></a>
                            <a href="https://plus.google.com/u/1/108778239825863511607/"><img src="<?php echo base_url();?>/images/mails/gplus.png" alt="" style="width:24px; height:24px; "></a>
                            <a href="http://www.pinterest.com/oceantailer//"><img src="<?php echo base_url();?>/images/mails/p.png" alt="" style="width:24px; height:24px; "></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <p style="margin:0; color:#4c4c4c; font: 300 11px 'Open Sans', sans-serif; text-align:center; padding-top:10px;">Copyright © 2014 OceanTailer</p>
            </td>
        </tr>
    </table>
<?php }?>