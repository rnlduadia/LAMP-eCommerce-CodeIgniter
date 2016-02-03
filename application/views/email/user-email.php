<?php if($email_type == "User Activate Account"){?>
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
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Username: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $user; ?></p>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $pasword; ?></p>
                <br><br>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;">Verification Link:</p>
                <p style="margin:0; color:#333; font: 300 13px 'Open Sans', sans-serif;">To Verify the Account Click the link <a href="<?php echo base_url()?>supplier/activate/<?php echo $activate?>" style="color:#2b87c4; text-decoration:none;">(here)</a></p>
                <br><br>
                <p style="margin:0; color:#333; font: 300 13px 'Open Sans', sans-serif;">Pricing will be visible after OceanTailer's Admin approves the account.</p>
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
<?php }elseif($email_type == "New Password"){?>
    <table width="360" height="460">
        <tr>
            <td height="60" style="vertical-align:top;">
                <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>/images/mails/logo.png" alt="" style="width:92px; height:40px;"></a>
            </td>
        </tr>
        <tr>
            <td style="border-top: solid 1px #0e76bc; border-bottom: solid 1px #0e76bc; vertical-align:middle;" height="28">
                <h1 style="color:#333; font: 300 14px 'Open Sans', Arial, sans-serif; margin:0;">New Password Set</h1>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Username: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $user; ?></p>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $pass; ?></p>
                <br><br>
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
                            <a href="http://www.pinterest.com/oceantailer//"><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/';?>/images/mails/p.png" alt="" style="width:24px; height:24px; "></a>
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
<?php }elseif($email_type == "Notify Feedback"){?>
    <table width="360" height="460">
        <tr>
            <td height="60" style="vertical-align:top;">
                <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>/images/mails/logo.png" alt="" style="width:92px; height:40px;"></a>
            </td>
        </tr>
        <tr>
            <td style="border-top: solid 1px #0e76bc; border-bottom: solid 1px #0e76bc; vertical-align:middle;" height="28">
                <h1 style="color:#333; font: 300 14px 'Open Sans', Arial, sans-serif; margin:0;">Welcome To Oceantailer <?php echo $buyer_info->u_fname.' '.$buyer_info->u_lname?>,</h1>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;">Please give us some feedback from your Last Transaction (Invoice #<?php echo $order_detail->bt_invoice?>) from Company  <?php echo $buyer_info->u_company ?> </p>
                <br><br>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;">Just click this link <a href="<?php echo base_url()?>buyer/order/<?php echo $order_detail->bsd_id?>">(here)</a> to create a feedback</p>
                <br><br>
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
                            <a href="http://www.pinterest.com/oceantailer//"><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/';?>/images/mails/p.png" alt="" style="width:24px; height:24px; "></a>
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
<?php }elseif($email_type == "Personal Message"){?>
    <table width="360" height="460">
        <tr>
            <td height="60" style="vertical-align:top;">
                <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>/images/mails/logo.png" alt="" style="width:92px; height:40px;"></a>
            </td>
        </tr>
        <tr>
            <td style="border-top: solid 1px #0e76bc; border-bottom: solid 1px #0e76bc; vertical-align:middle;" height="28">
                <h1 style="color:#333; font: 300 14px 'Open Sans', Arial, sans-serif; margin:0;">New Personal Message</h1>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Invoice Number: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $invoice; ?></p>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Subject: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $subject; ?></p>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Message: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $message; ?></p>
                <br><br>
                <p style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;">You can view the message through this link when you login:<a href='<?php echo base_url()?>' style="color:#2b87c4; text-decoration:none;">Click Here</a></p>
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
                            <a href="http://www.pinterest.com/oceantailer//"><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/';?>/images/mails/p.png" alt="" style="width:24px; height:24px; "></a>
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
<?php } ?>