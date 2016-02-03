<?php
/* echo '<pre>';
  print_r($this->user_id);
  echo '<pre>'; */
/* echo date("m/d/Y H:i:s", strtotime("-".strval(0.001)." days")); */
echo $this->load->view('supplier/header');
?>
<script src="<?php echo base_url() ?>js/jquery-ui-1.10.0.custom.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/jquery-ui-1.10.0.custom.min.css"/>

<div id='popSendEmail' class="popout-cont">
    <div class="padded-cont">

        <input type='button' value='X' class='close-pop-out fr'>

        <div class='clear'> </div>
        <div class='product-cont padded-cont clearfix'>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Order ID: </label>&#160;&#160;<?php echo $bt->bt_invoice; ?></p>
            </div>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Order Date: </label>&#160;&#160;<?php echo $bt->bt_time ?></p>
            </div>
        </div>
        <div class='product-cont padded-cont'>
<?php echo form_open_multipart('user/personal_message'); ?>

            <div class='clearfix'>
                <label for='seller-memo'>Subject</label>
                <div class="clear"> </div>
                <input type='text' id='send-subject-val' name='subject'  class='normal-format-text longer' />
            </div>
            <div class='clearfix'>
                <label for='seller-memo'>Message</label>
                <div class="clear"> </div>
                <textarea id='send-message-val' name='message'  class='normal-format-text full-ta'></textarea>
            </div>
            <div class='clearfix'>
                <label for='seller-memo'>Attachment</label>
                <div class="clear"> </div>
                <input type="file" name="userfile" size="20" />
            </div>
            <!-- <button class='normal-button fr' id='send_message' >Send</button> -->
            <input type='hidden' name='buyer' value='<?php echo $buyer->u_id ?>'>
            <input type='hidden' name='invoice' value='<?php echo $bt->bt_invoice ?>'>
            <input type='hidden' name='id' value='<?php echo $bt->bsd_id ?>'>
            <input type='hidden' name='action' value='send'>
            <input class='greenbutton floatR' type='submit' name='submit-message' value="Send" />
<?php echo form_close() ?>
        </div>

    </div>

</div>


<!-- LEFT SIDEBAR CONTAINER-->
<div class="nav-bar floatL">

<?php echo $this->load->view('supplier/sidebar'); ?>

</div>

<!-- RIGHT CONTENT CONTAINER-->
<div class='sliderLg floatR'>
    <div class='right-inner clearfix'>

        <!-- First Row Container-->
        <div class="topBrands searching-for">
            <div class="topBrandsHeader">
                <div class'floatl'=""> Order Detail </div>
            </div>
        </div>

        <div class='product-cont padded-cont clearfix'>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Order Date: </label>&#160;&#160;<?php echo $bt->bt_time; ?></p>
            </div>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Payment Method: </label>&#160;&#160;<?php echo $bt->bt_type; ?></p>
            </div>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Invoice Number: </label>&#160;&#160;<?php echo $bt->bt_invoice; ?></p>
            </div>

            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Order Status: </label>&#160;&#160;
                    <?php echo apputils::orderStatus($bt->bsd_status); ?>
<?php if ($bt->bsd_status == -1 || $bt->bsd_status == -4) echo ": " . $bt->bsd_reason ?>
                <form action="/supplier/orderupdate" method="post" id="statusChangeForm" onsubmit="return false;">
                    <input type="hidden" name="bsd_id" value="<?php echo $bt->bsd_id; ?>">
                    <input type="hidden" name="reason" value="">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>">
                    <select name="action" id="status_action">
                        <option value="">Change status to:</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                    </select>
                    <button class="greenbutton disabled" disabled id="changeStatusBtn">Change</button>
                </form>
                </p>
            </div>

        </div>

    </div>
    <div class='right-inner clearfix'>

        <!-- First Row Container-->
        <div class="topBrands searching-for">
            <div class="topBrandsHeader">
                <div class'floatl'=""> Shipping To </div>
            </div>
        </div>

        <div class='product-cont padded-cont clearfix'>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Recipient’s Name: </label>&#160;&#160;<?php echo $bt->bts_name ?></p>
            </div>

            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Address 1: </label>&#160;&#160;<?php echo $bt->bts_add1 ?></p>
            </div>
<?php if ($bt->bts_add2 != "") { ?>
                <div class="fl half clearfix">
                    <p class='p-infoformat fl'> <label class='label-infoformat fl'>Address 2: </label>&#160;&#160;<?php echo $bt->bts_add2 ?></p>
                </div>
<?php } ?>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>City: </label>&#160;&#160;<?php echo $bt->bts_city ?></p>
            </div>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Postal Code: </label>&#160;&#160;<?php echo $bt->bts_postal ?></p>
            </div>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>State: </label>&#160;&#160;<?php echo $bt->bts_prov ?></p>
            </div>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Country: </label>&#160;&#160;<?php echo $bt->c_name ?></p>
            </div>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Contact Number: </label>&#160;&#160;<?php echo $bt->bts_phone_num . ' ' . $bt->bts_phone_ext ?></p>
            </div>
        </div>

    </div>
<?php if ($bt->bsd_status != 0 && $bt->bsd_status != -1 && $bt->bsd_status != -2 && $bt->bsd_status != -3) { ?>
        <div class='right-inner clearfix'>

            <!-- First Row Container-->
            <div class="topBrands searching-for">
                <div class="topBrandsHeader">
                    <div class'floatl'="">Shipping Details</div>
                </div>
            </div>

            <div class='product-cont padded-cont clearfix'>
                <div class="fl half clearfix">
                    <p class='p-infoformat fl'> <label class='label-infoformat fl'>Shipping Tracking #: </label>&#160;&#160;<?php echo $bt->ssi_track; ?></p>
                </div>
                <div class="fl half clearfix">
                    <p class='p-infoformat fl'> <label class='label-infoformat fl'>Shipping Start: </label>&#160;&#160;<?php echo date('M d, Y', $bt->ssi_start); ?></p>
                </div>
                <div class="fl half clearfix">
                    <p class='p-infoformat fl'> <label class='label-infoformat fl'>Carrier: </label>&#160;&#160;<?php $carrier = $this->countries->carrier_info($bt->ssi_carrier);
    echo $carrier->sc_name ?></p>
                </div>
                <div class="fl half clearfix">
                    <p class='p-infoformat fl'> <label class='label-infoformat fl'>Shipping Method: </label>&#160;&#160;<?php echo $bt->ssi_shipMethod; ?></p>
                </div>

            </div>

        </div>
<?php } ?>

    <div class='right-inner clearfix'>

        <!-- First Row Container-->
        <div class="topBrands searching-for">
            <div class="topBrandsHeader">
                <div class'floatl'="">Billing Detail</div>
            </div>
        </div>

        <div class='product-cont padded-cont clearfix'>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Receiver's Name: </label>&#160;&#160;<?php echo $buyer->u_fname . ' ' . $buyer->u_lname ?></p>
            </div>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Company: </label>&#160;&#160;<?php echo $buyer->u_company ?></p>
            </div>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Address 1: </label>&#160;&#160;<?php echo $buyer->ba_add1 ?></p>
            </div>
<?php if ($buyer->ba_add2 != '') { ?>
                <div class="fl half clearfix">
                    <p class='p-infoformat fl'> <label class='label-infoformat fl'>Address 2: </label>&#160;&#160;<?php echo $buyer->ba_add2 ?></p>
                </div>
<?php } ?>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>City: </label>&#160;&#160;<?php echo $buyer->ba_city ?></p>
            </div>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>State: </label>&#160;&#160;<?php echo $buyer->ba_province ?></p>
            </div>

            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Contact Number: </label>&#160;&#160;<?php echo $buyer->ba_phone_num . ' ' . $buyer->ba_phone_ext ?></p>
            </div>
            <div class='clear'></div>

        </div>
    </div>


    <div class='right-inner clearfix'>

        <!-- First Row Container-->
        <div class="topBrands searching-for">
            <div class="topBrandsHeader">
                <div class'floatl'=""> Item Order Detail </div>
            </div>
        </div>

        <div class='product-cont padded-cont clearfix'>
            <div class='violet-table'>
                <table>
                    <tr>
                        <td>Product</td>
                        <td width=15>Qty</td>
                        <td width=15>Amount</td>
<!-- 									<td width=15>Shipping Fee</td> -->
                        <td>Sub Amount</td>
                        <td width=15>Commision</td>
                        <td>Deduction</td>
                        <td>Net Total</td>
                    </tr>
                    <?php
                    $net_total = 0;
                    $deduction_total = 0;
                    $shipping_total = 0;
                    $shipping_deduction = 0;
                    $commission = 0;
                    foreach ($btd as $btd_det) {
                        $shipping = $btd_det->btd_shipamount; // * $btd_det->btd_quan; echo $shipping;
                        ?>
                        <tr>
                            <td>
                                <div class='clearfix'>
                                    <div class='fl' style='margin-right:10px;'>
                                        <?php
                                        $image_list = $this->inventories->list_image($btd_det->i_id, 1, true);
                                        //limit 1, select only the featured image
                                        if (count($image_list) == 0) {
                                            ?>
                                            <img width=90 src="<?php echo base_url() ?>images/default-preview.jpg">

    <?php } else { ?>
                                            <img width=90  src="/<?php echo $image_list[0]->ii_link ?>">
    <?php } ?>
                                    </div>
                                    <div class='fl'>
                                        <div><a href="<?php echo base_url() ?>inventory/detail/<?php echo $btd_det->i_id ?>/<?php echo $btd_det->supplier_id ?>" ><?php echo $btd_det->tr_title ?> </a></div>
                                        <div class='table-format-det clearfix'>
                                            <label class='fl'>Produt ID: </label><p class='fl'> <?php echo $btd_det->ic_id ?></p>
                                        </div>
                                        <div class='table-format-det clearfix'>
                                            <label class='fl'>UPC/EAN: </label><p class='fl'> <?php echo $btd_det->upc_ean ?></p>
                                        </div>
                                        <div class='table-format-det clearfix'>
                                            <label class='fl'>SKU: </label><p class='fl'> <?php echo $btd_det->SKU ?></p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><center><?php echo $btd_det->btd_quan ?></center></td>
                        <td><center>$<?php echo number_format($btd_det->btd_amount, 2) ?></center></td>
                        <td>$<?php echo number_format($btd_det->btd_subamount, 2) ?></td>
                        <td><?php echo number_format($btd_det->btd_productFee, 2) ?>%</td>
                        <td>-$<?php $deduction = ($btd_det->btd_subamount * ($btd_det->btd_productFee / 100));
                    echo number_format($deduction, 2); ?></td>
                        <td>$<?php $net = ($btd_det->btd_subamount - $deduction);
                    echo number_format($net, 2); ?></td>
                        <?php
                        $shipping_total += $shipping;
                        $net_total += $net;
                        $deduction_total +=( $deduction ); 
                        $shipping_deduction += ($shipping * ($btd_det->btd_productFee / 100));
                        $commission = $btd_det->btd_productFee;
                        ?>
                        </tr>
                            <?php } ?>

<?php if ($bt->bsd_status == -2 || $bt->ssi_status == 1) {
    $shipping_total = $bt->ssi_shipExtra;
    $shipping_deduction = ($shipping_total * ($commission / 100));
} ?>

                    <tr>
                        <td colspan=7>
<?php if ($bt->bt_status == 0) { ?>
                                <div>
                                    <label class="label-infoformat">If shipping cost is different, change it here and notify buyer:</label>
                                </div>
                                <div class="clear"></div>
                                <div>
                                    <p class='fl' style='margin-top:10px;'>Revision  Shipping Fee: $</p>
                                    <input type='text' id='extra-shipping-cost' class='small45 fl' value="<?php echo $shipping_total ?> " />
                                    <button id='submit-confirmation-buyer' class='greenbutton fl'>Notify Buyer</button>
                                </div>
<?php } else { ?>
                                <p class='fl' style='margin-top:10px;'><?php echo $shipping_total ?></p>
<?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='3' class='big-font'><p>Total:</p></td>
                        <td colspan='1' class='big-font'>
                            <table>
                                <tr>
                                    <td colspan=2></td>
                                </tr>
                                <tr>
                                    <td>Total Items: </td>
                                    <td><label class='label-infoformat'>$<?php echo $bt->bsd_total_paymet ?></label></td>
                                </tr>
                                <tr>
                                    <td>Total Shipping: </td>
                                    <td><label id='shipping-label' class='label-infoformat'>+&#160;$<?php echo number_format($shipping_total, 2) ?></label></td>
                                </tr>
                            </table>
                        </td>
                        <td colspan='1' class='big-font'></td>
                        <td colspan='1' class='big-font'><p id="deduction_total_label">-$<?php echo number_format( $deduction_total + $shipping_deduction, 2) ?></p></td>
                        <td colspan='1' class='big-font'><p class='totalnet-cont'>$<?php echo number_format($net_total + $shipping_total - $shipping_deduction, 2) ?></p></td>
                    </tr>
                </table>
            </div>

        </div>

    </div>


<?php if ($bt->bsd_status == 0 || $bt->bsd_status == -2 || $bt->bsd_status == 10) { ?>
        <div class='right-inner clearfix'>
            <!-- First Row Container-->
            <div class="topBrands searching-for">
                <div class="topBrandsHeader">
                    <div class'floatl'="">Shipping Detail Form</div>
                </div>
            </div>

            <div class='padded-cont clearfix'>

                <div class='fl'>
                    <div class='fl'>
                        <label for='track-number'>Tracking Number</label>
                        <div class="clear"> </div>
                        <input type='text' value='<?php echo $bt->ssi_track ?>' class='normal-format-text' id='track-number' />
                    </div>
                    <div class='clear'> </div>
                    <div class='fl'>
                        <label for='shipping-carrier'>Carrier</label>
                        <div class="clear"> </div>
                        <select class='normal-format-select' id='shipping-carrier'>
                            <option value=''>Select Carrier</option>
    <?php foreach ($delivery_carrier as $cer) { ?>
                                <option <?php if ($bt->ssi_carrier == $cer->sc_name) {
            echo 'selected="selected"';
        } ?> value="<?php echo $cer->sc_id ?>"><?php echo $cer->sc_name ?></option>
    <?php } ?>
                        </select>
                    </div>

                    <div class='clear'> </div>
                    <div class='fl' id='country-shipping-cont'>
                        <label for='shipping-country'>Country</label>
                        <div class="clear"> </div>
                        <select class='normal-format-select' id='shipping-country'>
                        </select>
                    </div>

                    <div class='clear'> </div>
                    <div class='fl'>
                        <label for='shipping-method'>Shipping Method</label>
                        <div class="clear"> </div>
                        <textarea type='text' id='shipping-method'  class='normal-format-text long'><?php echo $bt->ssi_shipMethod ?></textarea>
                    </div>


                </div>

                <div class='fr shipping-box'>
                    <label for='shipping-start'>Ship Date</label>
                    <div class="clear"> </div>
                    <div id='shipping-start'></div>
                </div>

                <div class='clear'> </div>

                <div class='clear'> </div>
                <!-- <button class='normal-button fr' id='submit-confirmation-buyer'>UPDATE ORDER</button> -->
                <div class='notify-to-check-change-shipfee hide' >
                    <center><p>--Need Confirmation From the Buyer for the New Shipping Fee Amount--</p></center>
                </div>

    <?php if ($bt->bsd_status == 0 || $bt->bsd_status == '' || $bt->bsd_status == 10) { ?>
                    <button class='greenbutton floatR' id='submit-confirmation-shipping'>SUBMIT</button>
    <?php } else { ?>
                    <br/><center><p>--Waiting for Cofirmation From the Buyer for the New Shipping Detail, Click <a  href='#'>Here</a> to resend the Email--</p></center>
    <?php } ?>

                <div class='fr circle-loading' id='loading-supplierpayment'></div>



                <div id='result-sending'></div>
            </div>
        </div>

        <script type="text/javascript">
            var total_net = <?php echo $net_total ?>;
            var shipping_deduction = <?php echo $shipping_deduction; ?>;
            var deduction_total = <?php echo $deduction_total; ?>;
            var shipping_total = <?php echo $shipping_total; ?>;
            var commission = <?php echo $commission; ?>;
            var has_shippingcountry = true;
            var requestType = '';

            $(document).ready(function() {
                $("#shipping-start").datepicker({
                    onSelect: function()
                    {
                        var start = $(this).datepicker('getDate');
                    },
    <?php
    $orderdate = strtotime($bt->bt_time) + 3600;
    $orderdate = (!empty($orderdate)) ? date('Y', $orderdate) . ", " . (date('m', $orderdate) - 1) . ", " . date('d', $orderdate) . ", " . date('h', $orderdate) . ", " . date('i', $orderdate) . ", " . date('s', $orderdate) : "";
    ?>
                    minDate: new Date(<?php echo $orderdate; ?>)
                });

                $("#shipping-start").datepicker("option", "dateFormat", 'mm/dd/yy');


    <?php
    if ($bt->ssi_start != '') {
        $formattedDateStr = date("m/d/y", $bt->ssi_start);
        ?>
                    //alert("test");
                    $('#shipping-start').datepicker('setDate', '<?php echo $formattedDateStr ?>');
    <?php } ?>

                $('#submit-confirmation-shipping').click(function() {
                    requestType = 'supplierpayment';
                    submit_payment('add');
                });

                $('#submit-confirmation-buyer').click(function() {
                    requestType = 'supplierpayment';
                    submit_payment('request');
                });

                function submit_payment(status_payment)
                {
                    var pStart = $("#shipping-start").val();
                    var pEnd = '0';
                    var pTrack = $('#track-number').val();
                    var pMethod = $('#shipping-method').val();
                    var pCarrier = $('#shipping-carrier').val();
                    var pExtra_cost = $('#extra-shipping-cost').val();
                    var pCountry = '<?php echo $bt->country_id; ?>';
                    var pBt_id = <?php echo $bt->bt_id; ?>;
                    var pBsd = <?php echo $bt->bsd_id; ?>;
                    var pUrl = '<?php echo base_url(); ?>shipping/confirm';

                    var $pData = {track: pTrack, start: pStart, end: pEnd, method: pMethod, carrier: pCarrier, extra_cost: pExtra_cost, shipping_cost: pExtra_cost, bt_id: pBt_id, bsd: pBsd, country: pCountry, action: status_payment, '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>'};
                    //alert(JSON.stringify($pData));
                    if (has_shippingcountry)
                    {
                        $('#loading-supplierpayment').show();
                        $.post(pUrl, $pData, function(data) {
                            //alert(JSON.stringify(data));
                            var convert = JSON.parse(data);
                            if (convert.status == 0) //have problem in paypal
                            {
                                //window.location.reload();
                                $('#result-sending').html(data);
                            }
                            else
                            {
                                //alert("Waiting for Cofirmation From the Buyer for the New Shipping Detail");
                                //$('#result-sending').html(convert.display);
                                window.location.reload();
                            }
                            $('#loading-supplierpayment').hide();
                        });
                        $('#submit-confirmation-shipping').fadeOut();
                    }
                    else
                        alert('Please Select A Country for the Carrier');
                }

                $("body").on({
                    ajaxStart: function() {
                        if (requestType == 'supplierpayment')
                            $('#loading-supplierpayment').show();

                    },
                    ajaxStop: function() {
                        if (requestType == 'supplierpayment')
                            $('#loading-supplierpayment').hide();


                        requestType = '';
                    }
                });

                $('#extra-shipping-cost').on('keyup', function() {
                    $('#extra-shipping-cost').val($('#extra-shipping-cost').val().replace(/[^\d.]/g, ""));
                    if ($('#extra-shipping-cost').val() == "")
                        $('#extra-shipping-cost').val(<?php echo $shipping_total ?>);

                    if ($('#extra-shipping-cost').val() != <?php echo $shipping_total ?>)
                    {
                        $('#submit-confirmation-shipping').hide();
                        $('#submit-confirmation-buyer').fadeIn();
                        $('.notify-to-check-change-shipfee').show();
                    }
                    else
                    {
                        $('#submit-confirmation-buyer').hide();
                        $('#submit-confirmation-shipping').fadeIn();
                        $('.notify-to-check-change-shipfee').hide();
                    }
                    var new_shipping_deduction = parseFloat($('#extra-shipping-cost').val()) * commission /100;    
                    var total = total_net + parseFloat($('#extra-shipping-cost').val()) - new_shipping_deduction;
                    $('.totalnet-cont').html('$' + total.toFixed(2));
                    $('#shipping-label').html('+$' + $('#extra-shipping-cost').val());
                    var new_deduction_total = deduction_total + new_shipping_deduction;
                    $('#deduction_total_label').html('-$' + new_deduction_total.toFixed(2));
                });
            });
            function change_country() {

                var sel = document.getElementById('shipping-country');
                var val = '<?php echo $bt->ssi_country ?>';

                for (var i = 0, j = sel.options.length; i < j; ++i) {
                    if (sel.options[i].value === val) {
                        sel.selectedIndex = i;
                        break;
                    }
                }
            }



        </script>

<?php } ?>

<?php  if ($bt->bsd_status == -3) {
    $orr_detail = $this->suppliers->orr_detail($bt->bsd_id); ?>
        <!--REFUND CONTAINER DETAILS -->
        <div class='right-inner clearfix'>
            <!-- First Row Container-->
            <div class="heading-inner-right">
                <p class='breadcrumbs fl'>Refund Details</p>
            </div>
            <div class='padded-cont clearfix'>
                <div class='fl padded-cont'>
                    <label for='ref-reason' class='fl'>Reason:</label>
                    <p class='fl'><b><?php echo $orr_detail->orr_reason ?></b></p>
                </div>
                <div class='clear'></div>
                <div class='violet-table'>
                    <table>
                        <tr>
                            <td></td>
                            <td>Order Amount</td>
                            <td>Prior Refund</td>
                            <td>Max Amount</td>
                        </tr>
                        <tr>
                            <td>Product</td>
                            <td>$<?php echo $bt->bsd_total_paymet; ?></td>
                            <td><span class='red'><center>($<?php echo $orr_detail->orr_prod_amnt ?>)</center></span></td>
                            <td>$<?php echo $bt->bsd_total_paymet; ?></td>
                        </tr>
                        <tr>
                            <td>Shipping</td>
                            <td>$<?php echo $shipping_total; ?></td>
                            <td><span class='red'><center>($<?php echo $orr_detail->orr_ship_amnt ?>)</center></span></td>
                            <td>$<?php echo $shipping_total; ?></td>
                        </tr>
                        <tr>
                            <td><b>Total Refund:</b></td>
                            <td></td>
                            <td><span class='total_refund'>$<?php echo $orr_detail->orr_total ?></span></td>
                            <td></td>
                        </tr>

                    </table>
                </div>
                <div class='fl padded-cont'>
                    <label for='ref-reason' class='fl'>Memo to buyer:</label>
                    <p class='fl'><b><?php echo $orr_detail->orr_memo ?></b></p>
                </div>

            </div>
            <a class='full-width-link full-yellow' href="<?php echo base_url() ?>supplier/refund/<?php echo $bt->bsd_id ?>">Update Refund Order</a>
        </div>
        <!--REFUND CONTAINER DETAILS -->
<?php } ?>

    <div class='right-inner clearfix'>
        <!-- First Row Container-->
        <div class="topBrands searching-for">
            <div class="topBrandsHeader">
                <div class'floatl'="">My Notes</div>
            </div>
        </div>

        <div class='padded-cont clearfix'>
            <div class='clearfix'>
                <div class="clear"> </div>
                <textarea type='text' id='seller-memo'  class='normal-format-text full-ta'><?php echo $bt->bsd_memo ?></textarea>
                <span style="font-size: 12px; color: #666; padding-top: 10px; display: block;">The notes are private and not visible to buyer</span>

            </div>
            <div class='clearfix'><br/>
                <button class='greenbutton floatR' id='clear-memo'>UNDO</button>
                <span class='floatR'>&nbsp;</span>
                <button class='greenbutton floatR' id='save-memo'>SAVE NOTE</button>
            </div>
            <script type="text/javascript">
                var memo_backup = $('#seller-memo').val();
                $("#save-memo").click(function() {
                    var memo = $('#seller-memo').val();

                    $.post('<?php echo base_url() ?>supplier/memo', {action: 'update', memo: memo, id:<?php echo $bt->bsd_id ?>, '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>'}, function(result) {
                        alert('Memo has been saved successfully.');
                    });

                });

                $('#clear-memo').click(function() {
                    $('#seller-memo').val(memo_backup);
                });
            </script>
        </div>
    </div>

<?php if ($bt->bsd_status != 2 && $bt->bsd_status != 1 && $bt->bsd_status != -3 && $bt->bsd_status != -4 && $bt->bsd_status != -1) { ?>
        <div class='right-inner clearfix'>
            <!-- First Row Container-->
            <div class="heading-inner-right">
                <p class='breadcrumbs fl'></p>
            </div>

            <a class='full-width-link' href="<?php echo base_url() ?>supplier/order_cancel/<?php echo $bt->bsd_id ?>">Cancel Order</a>

        </div>
<?php } elseif ($bt->bsd_status == 1 || $bt->bsd_status == -4) { ?>
        <div class='right-inner clearfix'>
            <!-- First Row Container-->
            <div class="heading-inner-right">
                <p class='breadcrumbs fl'></p>
            </div>

            <a class='full-width-link full-yellow' href="<?php echo base_url() ?>supplier/refund/<?php echo $bt->bsd_id ?>">Refund Order</a>

        </div>

<?php } ?>



    <?php if ($bt->bsd_status == -1) { ?>
        <!--IF THE ORDER IS BEEN CANCELLED-->
        <div class='right-inner clearfix'>
            <!-- First Row Container-->
            <div class="heading-inner-right">
                <p class='breadcrumbs fl'>Cancelled</p>
            </div>
            <div class='padded-cont clearfix'>
                <center><p>-Cancellation reason: <?php echo $bt->bsd_reason ?>-</p></center>
            </div>
        </div>
        <!--IF THE ORDER IS BEEN CANCELLED END-->
<?php } ?>

<?php if ($bt->bsd_status == 1) { ?>
        <div class='right-inner clearfix'>
            <!-- First Row Container-->
            <div class="heading-inner-right">
                <p class='breadcrumbs fl'>Feedback Us</p>
            </div>
            <div class='padded-cont clearfix'>
    <?php if ($bt->bsd_feedback_date == '') { ?>
                    <center><p>--No feedback was given yet from the buyer--</p></center>
    <?php } else { ?>
                    <p class='p-infoformat fl'> <label class='label-infoformat fl'>Your Rate: </label>
                        &#160;&#160;
                    <div id="buyer_ic_rate" class="fl sup_ic_rate-cont" style='margin-top:-5px !Important'></div>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#buyer_ic_rate').raty({
                                readOnly: true,
                                score: <?php echo $bt->bsd_buyer_rate ?>,
                                width: 150,
                                path: "<?php echo base_url() . 'images/' ?>",
                                precision: true
                            });
                        });
                    </script>
                    </p>
                    <div class='clear'></div>
                    <p class='p-infoformat fl'> <label class='label-infoformat fl'>Your Feedback: </label>
                        &#160;&#160; <?php echo $bt->bsd_buyer_feedback ?>
                    </p>
    <?php } ?>
            </div>
        </div>
<?php } ?>

</div>

<script type="text/javascript">
    $('#message_seller').click(function() {
        $('#popSendEmail').fadeIn();

    })


    $('.close-pop-out').click(function() {
        $('.popout-cont').fadeOut();
        window.location.reload();
    });


    load_inbox();
    function load_inbox()
    {
        $.post('<?php echo base_url() ?>user/personal_message', {id: '<?php echo $bt->bsd_id ?>', action: 'get', '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>'}, function(result) {
            $('#messages-main-cont').html(result);
        });

    }

    function check_reply(id)
    {

    }

    function add_reply(id)
    {
        var reply_content = $('#reply' + id).val();

        $.post('<?php echo base_url() ?>user/personal_message', {reply_content: reply_content, id: id, action: 'addReply', '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>'}, function(result) {
            $('#append-reply' + id).prepend(result);
        });
    }

    $('#status_action').on('change', function() {
        if ($(this).val() == '')
            $('#changeStatusBtn').addClass('disabled').attr('disabled', true);
        else
            $('#changeStatusBtn').removeClass('disabled').removeAttr('disabled');
    });

    $('#changeStatusBtn').on('click', function() {
        var form = $('#statusChangeForm'),
                url = $(form).attr('action'),
                data = $(form).serialize();
        if ($('#status_action').val() == '') {
            alert("Please select order status first!");
            return false;
        }
        $.ajax({
            url: url,
            method: 'POST',
            data: data
        }).done(function(result) {
            alert("Status Changed");
            window.location.reload();
        }).error(function(result) {
            alert("Error during changing");
        });
    });

</script>


<script type="text/javascript" charset="utf-8" src="<?php echo base_url() ?>js/jquery.raty.min.js"></script>
<?php echo $this->load->view('supplier/footer') ?>


