<?php if($email_type == "Send Invoice"){?>
<table width="360" height="460">
    <tr>
        <td height="60" style="vertical-align:top;">
            <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>/images/mails/logo.png" alt="" style="width:92px; height:40px;"></a>
        </td>
    </tr>
    <tr>
        <td style="border-top: solid 1px #0e76bc; border-bottom: solid 1px #0e76bc; vertical-align:middle;" height="28">
            <h1 style="color:#333; font: 300 14px 'Open Sans', Arial, sans-serif; margin:0;">New Invoice</h1>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" align="left">
                <tr>
                    <td colspan="2" style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Invoice:</span>&nbsp;&nbsp;<?php echo $transaction->bt_invoice?></td>
                </tr>
                <tr>
                    <td style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Payment Type:</span>&nbsp;&nbsp;<?php echo  $transaction->bt_type?></td>
                    <td style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><?php if ($transaction->bt_type != 'credit card') { ?><span>Transaction ID:</span>&nbsp;&nbsp;<?php echo  $transaction->bt_trans_id?><?php } ?></td>
                </tr>
                <tr>
                    <td style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Timestamp:</span>&nbsp;&nbsp;<?php echo  $transaction->bt_timestamp?></td>
                    <td  style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><?php if ($transaction->bt_type != 'credit card') { ?>Correlation ID:<?php echo  $transaction->bt_correlation_id?><?php } ?></td>
                </tr>
            </table>
            <table width="100%"  border="1">
                <tr>
                    <td  style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;">Item</td>
                    <td  style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;" width=20>Quantity</td>
                    <td  style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;" width=40>Price</td>
                    <td  style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;" width=40>Ship Price</td>
                    <td  style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;" width=40>Sub Total</td>
                </tr>
                <?php 	foreach($products as $itemd){?>
                    <tr>
                        <td  style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><?php echo $itemd->tr_title?></td>
                        <td style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><?php echo $itemd->btd_quan?></td>
                        <td style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><center>$<?php echo number_format($itemd->btd_amount, 2, '.', ' ' )?></center></td>
                        <td style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><center>$<?php echo number_format($itemd->btd_shipamount, 2, '.', ' ' ) ?></center></td>
                        <td style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><center>$<?php echo number_format($itemd->btd_subamount, 2, '.', ' ' ) ?></center></td>
                    </tr>
                <?php }?>
                <tr>
                    <td colspan=2></td>
                    <td style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Total</span></td>
                    <td  style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;" colspan=2><center>$<?php echo number_format($total, 2, '.', ' ' )?></center></td>
                </tr>
            </table>
            <table width="100%" align="left">
                <tr>
                    <td colspan="2" style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Shipping To:</span></td>
                </tr>
            </table>
            <table width="100%" align="left">
                <tr>
                    <td  style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Address1:</span> <?php echo $ship->bts_add1?></td>
                    <td style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><?php if($ship->bts_add2 != ""){ ?><span>Address2:</span> <?php echo $ship->bts_add2?><?php }?></td>
                </tr>
                <tr>
                    <td style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>City:</span><?php echo $ship->bts_city?></td>
                    <td style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Province/Region/State:</span><?php echo $ship->bts_prov?></td>
                </tr>
                <tr>
                    <td style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Postal Code/Zip Code:</span><?php echo $ship->bts_postal?></td>
                    <td style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;"><span>Number:</span><?php echo $ship->bts_phone_num." ".$ship->bts_phone_ext?></td>
                </tr>
            </table>

            <table width="60%" align="left">
                <tr>
                    <td  style="margin:0; color:#333; font: 600 13px 'Open Sans', sans-serif;">For More Inquires email us at <a href="mailto:support@oceantailer.com">support@oceantailer.com</a></td>
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
            <p style="margin:0; color:#4c4c4c; font: 300 11px 'Open Sans', sans-serif; text-align:center; padding-top:10px;">Copyright © 2014 OceanTailer</p>
        </td>
    </tr>
</table>

<?php }elseif($email_type == "Send Pre Invoice"){?>
<table width="360" height="460">
    <tr>
        <td height="60" style="vertical-align:top;">
            <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>/images/mails/logo.png" alt="" style="width:92px; height:40px;"></a>
        </td>
    </tr>
    <tr>
        <td style="border-top: solid 1px #0e76bc; border-bottom: solid 1px #0e76bc; vertical-align:middle;" height="28">
            <h1 style="color:#333; font: 300 14px 'Open Sans', Arial, sans-serif; margin:0;">New Invoice</h1>
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
                <?php $carts = $this->cart->contents(); //James, cart content
                    $total_shipping_fee = 0;
                    foreach($carts as $itemd)
                    {?>
                    <tr>
                        <td><?php echo $itemd['name']?></td>
                        <td><?php echo $itemd['qty']?></td>
                        <td><center>$<?php echo number_format($itemd['price'], 2, '.', ' ' ) ?></center></td>
                        <td><center>$<?php $item_ship_cost = (empty($itemd['options']['ship_cost_per_item'])) ? $itemd['options']['ship_cost']*$itemd['qty'] : $itemd['options']['shipping_cost']+$itemd['options']['ship_cost_per_item']*$itemd['qty'];
                        				   $total_shipping_fee += $item_ship_cost;
                        				   echo number_format($total_shipping_fee, 2, '.', ' ' ); ?></center></td>
                        <td><center>$<?php echo number_format($itemd['subtotal'], 2, '.', ' ' ) ?></center></td>
                    </tr>
                <?php }?>
                <tr>
                    <td colspan=2></td>
                    <td>Total</td>
                    <td colspan=2><center>$<?php echo number_format($this->cart->total() + $total_shipping_fee, 2, '.', ' ' ); ?></center></td>
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
                    <td>Note:Please wait for an email or Call from the Supplier for the shipping Date and to Confirm of the Payment</td>
                    <td> </td>
                </tr>
            </table>

            <table width="60%" align="left">
                <tr>
                    <td>For More Inquires email us at <a href="mailto:support@oceantailer.com">support@oceantailer.com</a></td>
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
            <p style="margin:0; color:#4c4c4c; font: 300 11px 'Open Sans', sans-serif; text-align:center; padding-top:10px;">Copyright © 2014 OceanTailer</p>
        </td>
    </tr>
</table>
<?php }elseif($email_type == "Confirm Shipping Expense"){?>
<table width="360" height="460">
    <tr>
        <td height="60" style="vertical-align:top;">
            <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>/images/mails/logo.png" alt="" style="width:92px; height:40px;"></a>
        </td>
    </tr>
    <tr>
        <td style="border-top: solid 1px #0e76bc; border-bottom: solid 1px #0e76bc; vertical-align:middle;" height="28">
            <h1 style="color:#333; font: 300 14px 'Open Sans', Arial, sans-serif; margin:0;">Shipment Confirmation</h1>
        </td>
    </tr>
    <tr>
        <td>
            <table width="80%" align="left">
                        <tr>
                            <td>Tracking Number:</td>
                            <td><?php echo $transaction->ssi_track?></td>
                        </tr>
                        <tr>
                            <td>Shipping Method:</td>
                            <td><?php echo $transaction->ssi_shipMethod?></td>
                        </tr>
                        <tr>
                            <td>Carrier:</td>
                            <td><?php $carrier = $this->countries->carrier_info($transaction->ssi_carrier); echo $carrier->sc_name ?></td>
                        </tr>
                        <tr>
                            <td>Shipping Date:</td>
                            <td><?php echo date('M d, Y',$transaction->ssi_start); ?></td>
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
                        <?php 	foreach($products as $itemd){?>
                            <tr>
                                <td><?php echo $itemd->tr_title?></td>
                                <td><?php echo $itemd->btd_quan?></td>
                                <td><center>$<?php echo number_format($itemd->btd_amount, 2, '.', ' ' );?></center></td>
                                <td><center>$<?php echo number_format($itemd->btd_shipamount, 2, '.', ' ' ); ?></center></td>
                                <td><center>$<?php echo number_format($itemd->btd_subamount, 2, '.', ' ' ) ?></center></td>
                            </tr>
                        <?php }?>
                        <tr>
                            <td colspan=2></td>
                            <td>Total</td>
                            <td colspan=2><center>$<?php echo number_format($transaction->bt_total_payment+$transaction->ssi_shipExtra, 2, '.', ' ' ) ?></center></td>
                        </tr>
                    </table>

                    <table width="80%" align="left">
                        <tr>
                            <td>Ship To:</td>
                            <td> </td>
                        </tr>
                    </table>

                    <table width="80%" align="left">
                        <tr>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td>Address1: <?php echo $transaction->bts_add1?></td>
                            <td><?php if($transaction->bts_add2 != ""){ ?>Address2: <?php echo $transaction->bts_add2?><?php }?></td>
                        </tr>
                        <tr>
                            <td>City:<?php echo $transaction->bts_city?></td>
                            <td>Province/Region/State:<?php echo $transaction->bts_prov?></td>
                        </tr>
                        <tr>
                            <td>Postal Code/Zip Code:<?php echo $transaction->bts_postal?></td>
                        </tr>
                    </table>

                    <table width="60%" align="left">
                        <tr>
                            <td>See More Details about this order <a href="<?php echo base_url()?>buyer/order/<?php echo $transaction->bt_id?>">(Click Me)</a></td>
                            <td> </td>
                        </tr>
                    </table>
                    <table width="60%" align="left">
                        <tr>
                            <td>For More Inquires email us at <a href="mailto:support@oceantailer.com">support@oceantailer.com</a></td>
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
            <p style="margin:0; color:#4c4c4c; font: 300 11px 'Open Sans', sans-serif; text-align:center; padding-top:10px;">Copyright © 2014 OceanTailer</p>
        </td>
    </tr>
</table>
<?php }elseif($email_type == "Cancellation"){?>
<table width="360" height="460">
    <tr>
        <td height="60" style="vertical-align:top;">
            <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>/images/mails/logo.png" alt="" style="width:92px; height:40px;"></a>
        </td>
    </tr>
    <tr>
        <td style="border-top: solid 1px #0e76bc; border-bottom: solid 1px #0e76bc; vertical-align:middle;" height="28">
            <h1 style="color:#333; font: 300 14px 'Open Sans', Arial, sans-serif; margin:0;">Cancellation Detail</h1>
        </td>
    </tr>
    <tr>
        <td>
            <table width="80%" align="left">
                        <tr>
                            <td>Cancel Reason:</td>
                            <td><?php echo $transaction->bsd_reason?></td>
                        </tr>
                    </table>
		    <br/><br/>
                    <table width="100%"  border="1">
                        <tr>
                            <td>Item</td>
                            <td width=20>Quantity</td>
                            <td width=40>Price</td>
                            <td width=40>Ship Price</td>
                            <td width=40>Sub Total</td>
                        </tr>
                        <?php 	foreach($products as $itemd){?>
                            <tr>
                                <td><?php echo $itemd->tr_title?></td>
                                <td><?php echo $itemd->btd_quan?></td>
                                <td><center>$<?php echo number_format($itemd->btd_amount, 2, '.', ' ' );?></center></td>
                                <td><center>$<?php echo number_format($itemd->btd_shipamount, 2, '.', ' ' ); ?></center></td>
                                <td><center>$<?php echo number_format($itemd->btd_subamount, 2, '.', ' ' ) ?></center></td>
                            </tr>
                        <?php }?>
                        <tr>
                            <td colspan=2></td>
                            <td>Total</td>
                            <td colspan=2><center>$<?php echo number_format($transaction->bt_total_payment+$transaction->bt_total_shipping, 2, '.', ' ' )?></center></td>
                        </tr>
                    </table>

                    <table width="60%" align="left">
                        <tr>
                            <td>See More details Here <a href="<?php echo base_url()?>buyer/order/<?php echo $transaction->bt_id?>">(Click Me)</a></td>
                            <td> </td>
                        </tr>
                    </table>
                    <table width="60%" align="left">
                        <tr>
                            <td>For More Inquires email us at <a href="mailto:support@oceantailer.com">support@oceantailer.com</a></td>
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
            <p style="margin:0; color:#4c4c4c; font: 300 11px 'Open Sans', sans-serif; text-align:center; padding-top:10px;">Copyright © 2014 OceanTailer</p>
        </td>
    </tr>
</table>
<?php }?>

