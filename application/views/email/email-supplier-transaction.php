<?php if($email_type == "message_to_supplier"){?>

<table width="360" height="460">
    <tr>
        <td height="60" style="vertical-align:top;">
            <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>/images/mails/logo.png" alt="" style="width:92px; height:40px;"></a>
        </td>
    </tr>
    <tr>
        <td style="border-top: solid 1px #0e76bc; border-bottom: solid 1px #0e76bc; vertical-align:middle;" height="28">
            <h1 style="color:#333; font: 300 14px 'Open Sans', Arial, sans-serif; margin:0;">Dear supplier,<br />
            you have just received an message from buyer on Oceantailer.</h1>
        </td>
    </tr>
    <tr>
        <td>
            
            <table width="80%" align="left">
                <tr>
                    <td>Message Details :</td>
                    <td> </td>
                </tr>
            </table>

            <table width="80%" align="left">
                <tr>
                    <td> </td>
                    <td> </td>
                </tr>
                
                <tr>
                    <td>Product: </td>
                    <td><?php echo $link ?></td>
                </tr>
                <tr>
                    <td>Message: </td>
                    <td><?php echo $mesage ?></td>
                </tr>
                <tr>
                    <td>Buyer Name: </td>
                    <td><?php echo $name ?></td>
                </tr>
                <tr>
                    <td>Buyer Email: </td>
                    <td><?php echo $email ?></td>
                </tr>
                <tr>
                    <td>Buyer Phone: </td>
                    <td><?php echo $phone ?></td>
                </tr>
            </table>



            <table width="60%" align="left">
                <tr>
                    <td>Please check <a href="<?=base_url()?>">your account</a> for details.<br/></td>
                    <td> </td>
                </tr>
            </table>
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
            <p style="margin:0; color:#4c4c4c; font: 300 11px 'Open Sans', sans-serif; text-align:center; padding-top:10px;">Copyright � 2014 OceanTailer</p>
        </td>
    </tr>
</table>

<?php }elseif(1){ ?>
<table width="360" height="460">
    <tr>
        <td height="60" style="vertical-align:top;">
            <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>/images/mails/logo.png" alt="" style="width:92px; height:40px;"></a>
        </td>
    </tr>
    <tr>
        <td style="border-top: solid 1px #0e76bc; border-bottom: solid 1px #0e76bc; vertical-align:middle;" height="28">
            <h1 style="color:#333; font: 300 14px 'Open Sans', Arial, sans-serif; margin:0;">Dear supplier,<br />
            you have just received an order on Oceantailer.</h1>
        </td>
    </tr>
    <tr>
        <td>
            <table width="80%" align="left">
                <tr>
                    <td>Invoice:<?php echo $transaction->bt_invoice?></td>
                    <td> </td>
                </tr>
                <tr>
                    <td> </td>
                    <td> </td>
                </tr>
            </table>

            <table width="100%"  border="1">
                <tr>
                    <td>Item</td>
                    <td width=20>Quantity</td>
                    <td width=40>Price</td>
                    <td width=40>Ship Price</td>
                    <td width=40>Sub Total</td>
                </tr>
                <?php
                    $total_shipping_fee = 0;
                    foreach($carts as $itemd)
                    {?>
                    <tr>
                        <td><?php echo $itemd['name']?></td>
                        <td><?php echo $itemd['qty']?></td>
                        <td><center>$<?php echo number_format($itemd['price'],2) ?></center></td>
                        <td><center>$<?php $item_ship_cost = (empty($itemd['options']['ship_cost_per_item'])) ? $itemd['options']['ship_cost']*$itemd['qty'] : $itemd['options']['shipping_cost']+$itemd['options']['ship_cost_per_item']*$itemd['qty'];
                        				   $total_shipping_fee += $item_ship_cost;
                        				   echo number_format($item_ship_cost,2); ?></center></td>
                        <td><center>$<?php echo number_format($itemd['subtotal'],2) ?></center></td>
                    </tr>
                <?php }  ?>
                <tr>
                    <td colspan=2></td>
                    <td>Total</td>
                    <td colspan=2><center>$<?php echo number_format($total + $total_shipping_fee,2) ?></center></td>
                </tr>
            </table>

            <table width="80%" align="left">
                <tr>
                    <td>Shipping To:</td>
                    <td> </td>
                </tr>
            </table>

            <table width="80%" align="left">
                <tr>
                    <td> </td>
                    <td> </td>
                </tr>
                <tr>
                    <td>Address1: <?php echo $ship->bts_add1?></td>
                    <td><?php if($ship->bts_add2 != ""){ ?>Address2: <?php echo $ship->bts_add2?><?php }?></td>
                </tr>
                <tr>
                    <td>City:<?php echo $ship->bts_city?></td>
                    <td>Province/Region/State:<?php echo $ship->bts_prov?></td>
                </tr>
                <tr>
                    <td>Postal Code/Zip Code:<?php echo $ship->bts_postal?></td>
                    <td>Number:<?php echo $ship->bts_phone_num." ".$ship->bts_phone_ext?></td>
                </tr>
            </table>



            <table width="60%" align="left">
                <tr>
                    <td>Please check <a href="<?=base_url()?>">your account</a> for details.<br/></td>
                    <td> </td>
                </tr>
            </table>
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
            <p style="margin:0; color:#4c4c4c; font: 300 11px 'Open Sans', sans-serif; text-align:center; padding-top:10px;">Copyright � 2014 OceanTailer</p>
        </td>
    </tr>
</table>
<?php }elseif(0){?>


<?php }?>