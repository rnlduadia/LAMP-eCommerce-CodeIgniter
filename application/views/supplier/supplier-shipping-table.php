<!-- Lanz Editted -->
<?php echo $this->load->view('supplier/header') ?>
<script src="<?php echo base_url() ?>js/organictabs.jquery.js" type="text/javascript"></script>
<style>
    .band_input{
        width: 50px;
    }
    .band_div{
        display: inline-block;
        width: 70px;
    }
    .add_more_band{
        height: 20px;
        font-size: 12px;
        padding: 0 7px;
        margin-top: 6px;
    }
    .band {
        height: 30px;
        vertical-align: top;
    }
    tr td:last-child{vertical-align: top;}
    .remove_band{
        cursor: pointer;
        color: #003399;
        display: none;
    }
    td .band:last-child .remove_band{display:inline-block;}
    td .band:first-child .remove_band{display:none;}
	
	#weight_tier, #price_tier {
    -webkit-transition: 0.4s ease;
    -moz-transition: 0.4s ease;
    -o-transition: 0.4s ease;
    transition: 0.4s ease;
}

</style>
<?php
$std = false;
$exp = false;
$one = false;
$two = false;
$tier = 'price';

foreach ($shippingtable as $level) {
    switch ($level->s_level) {
        case'standard':
            $std = true;
            $std_pw = $level->s_per_weight;
            $std_ps = $level->s_per_shipment;
            $std_pb = $level->s_price_bands;
            $std_wb = $level->s_weight_bands;
            $tier = $level->s_tier;
            break;
        case'expedited':
            $exp = true;
            $exp_pw = $level->s_per_weight;
            $exp_ps = $level->s_per_shipment;
            $exp_pb = $level->s_price_bands;
            $exp_wb = $level->s_weight_bands;
            $tier = $level->s_tier;
            break;
        case'two-day':
            $two = true;
            $two_pw = $level->s_per_weight;
            $two_ps = $level->s_per_shipment;
            $two_pb = $level->s_price_bands;
            $two_wb = $level->s_weight_bands;
            $tier = $level->s_tier;
            break;
        case'one-day':
            $one = true;
            $one_pw = $level->s_per_weight;
            $one_ps = $level->s_per_shipment;
            $one_pb = $level->s_price_bands;
            $one_wb = $level->s_weight_bands;
            $tier = $level->s_tier;
            break;
    }
}
?>
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
                <div class'floatl'="">Manage Shipping Table</div>
            </div>
        </div>

        <div class='padded-cont'>
            <div class="clear"> </div>
            <br/>
            <b>Shipping Tier : </b>
            <input type="radio" name="shipping_tier" value="price" <?php if($tier=='price')echo'checked';?>> Price Tier
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="shipping_tier" value="weight" <?php if($tier=='weight')echo'checked';?>> Weight Tier
            <br/><br/>

            <div id="supplier-product-tab">
                <ul class="nav hidden">
                    <li class="nav-one">
                        <a href="#price_tier" class="<?php if($tier=='price')echo'current';?>">
                            <div class="head-tab fl">
                                <div class="tab-center fl">
                                    <p class="fl">Price Tier</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-two">
                        <a href="#weight_tier" class="<?php if($tier=='weight')echo'current';?>">
                            <div class="head-tab fl">
                                <div class="tab-center fl">
                                    <p class="fl">Weight Tier</p>
                                </div>
                            </div>
                        </a>
                    </li>

                </ul>

                <div class="list-wrap">

                    <ul id="price_tier" style="<?php if($tier=='weight')echo'display: none;';?>">
                        <li>
                            <div class='product-cont padded-cont clearfix'>
                                <h3>Price Tier Shipping Bands</h3>
                                <div class='gray-table table-margin'>
                                    <table tier="price">
                                        <tr>
                                            <td rowspan width="70">Standard Shipping Rates</td>
                                            <td colspan>Service Level (ETA)</td>
                                            <td rowspan>Shipping Bands</td>
                                            <td rowspan>Shipping Rate</td>

                                        </tr>

                                        <tr class="std">
                                            <td rowspan=4><b>Continental US Street</b></td>
                                            <td>
                                                <input type="checkbox" name="std_cb" value="1" id="std_cb"  <?php if ($std && $std_pb!='') echo "checked"; ?>/>&nbsp;Standard
                                                <br/>3-5 business days</td>

                                            <td>

                                            </td>
                                            <td>

                                            </td>


                                        </tr>

                                        <tr class="exp">

                                            <td>
                                                <input type="checkbox" name="exp_cb" value="1" id="exp_cb"  <?php if ($exp && $exp_pb!='') echo "checked"; ?>/>&nbsp;Expedited
                                                <br/>1-3 business days</td>
                                            <td>

                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr class="two">

                                            <td>
                                                <input type="checkbox" name="2d_cb" value="1" id="2d_cb"  <?php if ($two && $two_pb!='') echo "checked"; ?>/>&nbsp;Two-Day
                                                <br/>2 business days</td>
                                            <td>

                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr class="one">

                                            <td>
                                                <input type="checkbox" name="1d_cb" value="1" id="1d_cb"  <?php if ($one && $one_pb!='') echo "checked"; ?>/>&nbsp;One-Day
                                                <br/>24 hours</td>
                                            <td>

                                            </td>
                                            <td>

                                            </td>

                                        </tr>
                                    </table>
                                </div>
                            </div>



                        </li>
                    </ul>

                    <ul id="weight_tier" style="<?php if($tier=='price')echo'display: none;';?>">
                        <li>
                            <div class='product-cont padded-cont clearfix'>
                                <h3>Weight Tier Shipping Bands</h3>
                                <div class='gray-table table-margin'>
                                    <table tier="weight">
                                        <tr>
                                            <td rowspan width="70">Standard Shipping Rates</td>
                                            <td colspan>Service Level (ETA)</td>
                                            <td rowspan>Shipping Bands</td>
                                            <td rowspan>Shipping Rate</td>

                                        </tr>

                                        <tr class="std">
                                            <td rowspan=4><b>Continental US Street</b></td>
                                            <td>
                                                <input type="checkbox" name="std_cb" value="1" id="std_cb"  <?php if ($std && $std_wb!='') echo "checked"; ?>/>&nbsp;Standard
                                                <br/>3-5 business days</td>

                                            <td>

                                            </td>
                                            <td>

                                            </td>


                                        </tr>

                                        <tr class="exp">

                                            <td>
                                                <input type="checkbox" name="exp_cb" value="1" id="exp_cb"  <?php if ($exp && $exp_wb!='') echo "checked"; ?>/>&nbsp;Expedited
                                                <br/>1-3 business days</td>
                                            <td>

                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr class="two">

                                            <td>
                                                <input type="checkbox" name="2d_cb" value="1" id="2d_cb"  <?php if ($two && $two_wb!='') echo "checked"; ?>/>&nbsp;Two-Day
                                                <br/>2 business days</td>
                                            <td>

                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr class="one">

                                            <td>
                                                <input type="checkbox" name="1d_cb" value="1" id="1d_cb"  <?php if ($one && $one_wb!='') echo "checked"; ?>/>&nbsp;One-Day
                                                <br/>24 hours</td>
                                            <td>

                                            </td>
                                            <td>

                                            </td>

                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </li>
                    </ul>


                </div> <!-- END List Wrap -->

            </div>



            <div class='gray-table table-margin hidden'>
                <table>
                    <tr>
                        <td width=120 rowspan=2>Standard Shipping Rates</td>
                        <td width=120 rowspan=2>Rate comonents</td>
                        <td colspan=4>Service Level</td>

                    </tr>

                    <tr>
                        <td>Standard</td>
                        <td>Expedited</td>
                        <td>Two-Day</td>
                        <td>One-Day</td>

                    </tr>

                    <tr>
                        <td rowspan=3><b>Continental US Street</b></td>
                        <td>ETA</td>
                        <td width=103 style="font-size:11px;"><input type="checkbox" name="std_cb" value="1" id="std_cb"  onChange="dop_price();" <?php if ($std) echo "checked"; ?>/>&nbsp;3-5 business days</td>
                        <td width=103 style="font-size:11px;"><input type="checkbox" name="exp_cb" value="1" id="exp_cb"  onChange="dop_price();" <?php if ($exp) echo "checked"; ?>/>&nbsp;1-3 business days</td>
                        <td width=103 style="font-size:11px;"><input type="checkbox" name="2d_cb" value="1" id="2d_cb"  onChange="dop_price();" <?php if ($two) echo "checked"; ?>/>&nbsp;2 business days</td>
                        <td width=103 style="font-size:11px;"><input type="checkbox" name="1d_cb" value="1" id="1d_cb"  onChange="dop_price();" <?php if ($one) echo "checked"; ?>/>&nbsp;24 hours</td>
                    </tr>
                    <tr>

                        <td>per Weight (lbs)</td>
                        <td><span class='std_empty' <?php if ($std) echo 'style="display:none;"'; ?>>---</span><span class='std_full'  <?php if (!$std) echo 'style="display:none;"'; ?>>$&nbsp;<input type='text' id='std_pw' name="std_pw" class='small-format-text'  <?php if (($std) && ($std_pw)) echo 'value="' . $std_pw . '"'; ?>/></span></td>
                        <td><span class='exp_empty' <?php if ($exp) echo 'style="display:none;"'; ?>>---</span><span class='exp_full' <?php if (!$exp) echo 'style="display:none;"'; ?>>$&nbsp;<input type='text' id='exp_pw' name="exp_pw" class='small-format-text' <?php if (($exp) && ($exp_pw)) echo 'value="' . $exp_pw . '"'; ?>/></span></td>
                        <td><span class='2d_empty' <?php if ($two) echo 'style="display:none;"'; ?>>---</span><span class='2d_full' <?php if (!$two) echo 'style="display:none;"'; ?>>$&nbsp;<input type='text' id='2d_pw' name="2d_pw" class='small-format-text' <?php if (($two) && ($two_pw)) echo 'value="' . $two_pw . '"'; ?>/></span></td>
                        <td><span class='1d_empty' <?php if ($one) echo 'style="display:none;"'; ?>>---</span><span class='1d_full' <?php if (!$one) echo 'style="display:none;"'; ?>>$&nbsp;<input type='text' id='1d_pw' name="1d_pw" class='small-format-text' <?php if (($one) && ($one_pw)) echo 'value="' . $one_pw . '"'; ?>/></span></td>
                    </tr>
                    <tr>

                        <td>per Shipment</td>
                        <td><span class='std_empty' <?php if ($std) echo 'style="display:none;"'; ?>>---</span><span class='std_full' <?php if (!$std) echo 'style="display:none;"'; ?>>$&nbsp;<input type='text' id='std_ps' name="std_ps" class='small-format-text' <?php if (($std) && ($std_ps)) echo 'value="' . $std_ps . '"'; ?>/></span></td>
                        <td><span class='exp_empty' <?php if ($exp) echo 'style="display:none;"'; ?>>---</span><span class='exp_full' <?php if (!$exp) echo 'style="display:none;"'; ?>>$&nbsp;<input type='text' id='exp_ps' name="exp_ps" class='small-format-text' <?php if (($exp) && ($exp_ps)) echo 'value="' . $exp_ps . '"'; ?>/></span></td>
                        <td><span class='2d_empty' <?php if ($two) echo 'style="display:none;"'; ?>>---</span><span class='2d_full' <?php if (!$two) echo 'style="display:none;"'; ?>>$&nbsp;<input type='text' id='2d_ps' name="2d_ps" class='small-format-text' <?php if (($two) && ($two_ps)) echo 'value="' . $two_ps . '"'; ?>/></span></td>
                        <td><span class='1d_empty' <?php if ($one) echo 'style="display:none;"'; ?>>---</span><span class='1d_full' <?php if (!$one) echo 'style="display:none;"'; ?>>$&nbsp;<input type='text' id='1d_ps' name="1d_ps" class='small-format-text' <?php if (($one) && ($one_ps)) echo 'value="' . $one_ps . '"'; ?>/></span></td>
                    </tr>
                </table>
            </div>
            <br/>
            <button id='update-shippingtable-button' class='greenbutton floatR'>UPDATE</button>

            <div class='validate-result'>
            </div>
            <div class='clear'></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    /* function dop_price() {
     
     if ($("#std_cb").prop("checked")) {
     $(".std_empty").hide();
     $(".std_full").show();
     
     } else {
     $(".std_full").hide();
     $("#std_pw").val('');
     $("#std_ps").val('');
     $(".std_empty").show();
     
     }
     if ($("#exp_cb").prop("checked")) {
     $(".exp_empty").hide();
     $(".exp_full").show();
     
     } else {
     $(".exp_full").hide();
     $("#exp_pw").val('');
     $("#exp_ps").val('');
     $(".exp_empty").show();
     
     }
     if ($("#2d_cb").prop("checked")) {
     $(".2d_empty").hide();
     $(".2d_full").show();
     
     } else {
     $(".2d_full").hide();
     $("#2d_pw").val('');
     $("#2d_ps").val('');
     $(".2d_empty").show();
     
     }
     if ($("#1d_cb").prop("checked")) {
     $(".1d_empty").hide();
     $(".1d_full").show();
     
     } else {
     $(".1d_full").hide();
     $("#1d_pw").val('');
     $("#1d_ps").val('');
     $(".1d_empty").show();
     
     }
     }*/
    /*
     $('#update-shippingtable-button').click(function() {
     var std_pw = $('#std_pw').val();
     var std_ps = $('#std_ps').val();
     var exp_pw = $('#exp_pw').val();
     var exp_ps = $('#exp_ps').val();
     var two_pw = $('#2d_pw').val();
     var two_ps = $('#2d_ps').val();
     var one_pw = $('#1d_pw').val();
     var one_ps = $('#1d_ps').val();
     
     $.post("<?php echo base_url() ?>supplier/update_shippingtable", {
     std_pw: std_pw, std_ps: std_ps, exp_pw: exp_pw, exp_ps: exp_ps, two_pw: two_pw, two_ps: two_ps, one_pw: one_pw, one_ps: one_ps,
     action: 'update', '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>'}, function(result) {
     var convert = JSON.parse(result);
     if (convert.status == 0) // has error input
     {
     alert(convert.message);
     } else {
     alert("Information updated sucessfully");
     $(window.location).attr('href', "<?php echo base_url() ?>supplier/shippingtable");
     }
     
     });
     });*/
    $(function() {

        $("#supplier-product-tab").organicTabs();


        // initialize table

<?php if ($std) { ?>
            var pb = JSON.parse('<?php echo $std_pb == '' ? '[]' : $std_pb; ?>');
            var wb = JSON.parse('<?php echo $std_wb == '' ? '[]' : $std_wb; ?>');
            set_bands_onload('std', pb, wb);
<?php } ?>
<?php if ($exp) { ?>
            var pb = JSON.parse('<?php echo $exp_pb == '' ? '[]' : $exp_pb; ?>');
            var wb = JSON.parse('<?php echo $exp_wb == '' ? '[]' : $exp_wb; ?>');
            set_bands_onload('exp', pb, wb);
<?php } ?>
<?php if ($two) { ?>
            var pb = JSON.parse('<?php echo $two_pb == '' ? '[]' : $two_pb; ?>');
            var wb = JSON.parse('<?php echo $two_wb == '' ? '[]' : $two_wb; ?>');
            set_bands_onload('two', pb, wb);
<?php } ?>
<?php if ($one) { ?>
            var pb = JSON.parse('<?php echo $one_pb == '' ? '[]' : $one_pb; ?>');
            var wb = JSON.parse('<?php echo $one_wb == '' ? '[]' : $one_wb; ?>');
            set_bands_onload('one', pb, wb);
<?php } ?>
    });
function remove_band(btn){
    console.log(parseInt($(btn).parent('.band').index()));
    $(btn).parents('td').prev('td').find('.band').eq(parseInt($(btn).parent('.band').index())).remove();
    $(btn).parent('.band').remove();
}
    function set_bands_onload(type, pb, wb) {
        var found =false;
        if(type=='std')tr_no = 3;
        else tr_no = 2;
        console.log(type);
        console.log(pb);
        console.log(wb);
        for (key in pb) {found = true;
            from = pb[key].from;
            to = pb[key].to;
            rate = pb[key].rate;
            
            var html = '<div class="band">'
                    + '<div class="band_div from">'
                    + '   $<input readonly class="band_input" name="band[price][' + type + '][' + key + '][from]" value="' + from + '"/>'
                    + '</div>'
                    + '<div class="band_div ">to</div> '
                    + '<div class="band_div to">'
                    + '    $<input class="band_input" name="band[price][' + type + '][' + key + '][to]" value="' + to + '"/>'
                    + '</div>'
                    + '</div>';
            $('#price_tier tr.' + type).find('td:nth-child('+tr_no+')').append(html);
    html = '<div class="band">'
                    + ' <div class="band_div ship_rate">'
                    + '     $<input class="band_input" name="band[price][' + type + '][' + key + '][rate]" value="' + rate + '"/>'
                    + ' </div>'
                    + '<span class="remove_band" onclick="remove_band(this)">remove</span></div>';
            $('#price_tier tr.' + type).find('td:nth-child('+(tr_no+1)+')').append(html);

        }
       if(found){ html = '<button onclick="add_more_band(this)" class="add_more_band greenbutton floatR">Add more bands</button>';
            $('#price_tier tr.' + type).find('td:nth-child('+tr_no+')').append(html);
       }
    found = false;
        for (key in wb) {found = true;
            from = wb[key].from;
            to = wb[key].to;
            rate = wb[key].rate;

            var html = '<div class="band">'
                    + '<div class="band_div from">'
                    + '   LB<input readonly class="band_input" name="band[weight][' + type + '][' + key + '][from]" value="' + from + '"/>'
                    + '</div>'
                    + '<div class="band_div ">to</div> '
                    + '<div class="band_div to">'
                    + '    LB<input class="band_input" name="band[weight][' + type + '][' + key + '][to]" value="' + to + '"/>'
                    + '</div>'
                    + '</div>';
            $('#weight_tier tr.' + type).find('td:nth-child('+tr_no+')').append(html);
    
    html = '<div class="band">'
                    + ' <div class="band_div ship_rate">'
                    + '     $<input class="band_input" name="band[weight][' + type + '][' + key + '][rate]" value="' + rate + '"/>'
                    + ' </div>'
                    + '<span class="remove_band" onclick="remove_band(this)">remove</span></div>';
            $('#weight_tier tr.' + type).find('td:nth-child('+(tr_no+1)+')').append(html);

        }
      if(found){  html = '<button onclick="add_more_band(this)" class="add_more_band greenbutton floatR">Add more bands</button>';
            $('#weight_tier tr.' + type).find('td:nth-child('+tr_no+')').append(html);
      }

    }
$(document).on( 'keyup', '.band_div.to input', function(){
if($(this).val() == 'up' || $(this).val() == ''){
     $(this).parents('.band').next('.band').find('.band_div.from input').val('');
}else{
    $(this).parents('.band').next('.band').find('.band_div.from input').val(parseFloat($(this).val())+0.01); 
}
   
});

    $('input[type=checkbox]').on('change', function(e) {
        if ($(this).prop('checked')) {
            var tier = $(this).parents('table').attr('tier');
			var unit = tier=='price' ? '$':'LB';
            var type = $(this).parents('tr').attr('class');
            var key = 0;
            var from = 0.00;
            var html = '<div class="band">'
                    + '<div class="band_div from">'
                    + unit+'<input readonly class="band_input" name="band[' + tier + '][' + type + '][' + key + '][from]" value="' + from + '"/>'
                    + '</div>'
                    + '<div class="band_div ">to</div> '
                    + '<div class="band_div to">'
                    + unit+'<input class="band_input" name="band[' + tier + '][' + type + '][' + key + '][to]" value="up"/>'
                    + '</div>'
                    + '</div>';
            $(this).parent('td').next('td').html(html);

            html = '<button onclick="add_more_band(this)" class="add_more_band greenbutton floatR">Add more bands</button>';
            $(this).parent('td').next('td').find('.band').last().after(html);

            html = '<div class="band">'
                    + ' <div class="band_div ship_rate">'
                    + '     $<input class="band_input" name="band[' + tier + '][' + type + '][' + key + '][rate]" value="0.00"/>'
                    + ' </div>'
                    + '<span class="remove_band" onclick="remove_band(this)">remove</span></div>';
            $(this).parent('td').next('td').next('td').html(html);

        } else {
            $(this).parent('td').next('td').html('');
            $(this).parent('td').next('td').next('td').html('');
        }
    });
	$('input[name="shipping_tier"]').on('change', function(e) {
		if($(this).val()=='price'){
			$('#weight_tier').css('visibility','hidden');
			setTimeout(function(){
				$('#weight_tier').css('display','none');
				$('#weight_tier').css('visibility','visible');
				$('#price_tier').css('display','block');
			}, 500);
			
		}else{
			$('#price_tier').css('visibility','hidden');
			setTimeout(function(){
				$('#price_tier').css('display','none');
				$('#price_tier').css('visibility','visible');
				$('#weight_tier').css('display','block');
			}, 500);
			
		}
	});

    function add_more_band(btn) {

        var tier = $(btn).parents('table').attr('tier');
		var unit = tier=='price' ? '$':'LB';
        var type = $(btn).parents('tr').attr('class');
        var key = $(btn).parents('td').find('.band').length;

        var from = ($(btn).prev('.band').find('.band_div.to input').val());
        from = (from == '' ? '' : (from == 'up' ? 0.00 : parseFloat(from) + 0.01));
        var html = '<div class="band">'
                + '<div class="band_div from">'
                + unit+'<input readonly class="band_input" name="band[' + tier + '][' + type + '][' + key + '][from]" value="' + from + '"/>'
                + '</div>'
                + '<div class="band_div ">to</div> '
                + '<div class="band_div to">'
                + unit+'<input class="band_input" name="band[' + tier + '][' + type + '][' + key + '][to]" value="up"/>'
                + '</div>'
                + '</div>';
        $(btn).prev('.band').after(html);
        html = '<div class="band">'
                + ' <div class="band_div ship_rate">'
                + '     $<input class="band_input" name="band[' + tier + '][' + type + '][' + key + '][rate]" value="0.00"/>'
                + ' </div>'
                + '<span class="remove_band" onclick="remove_band(this)">remove</span></div>';
        $(btn).parents('td').next('td').find('.band').last().after(html);
    }

    $('#update-shippingtable-button').click(function() {
        var std_cb = $('#price_tier #std_cb').prop('checked') ? $('#price_tier #std_cb').prop('checked') : $('#weight_tier #std_cb').prop('checked');
        var exp_cb = $('#price_tier #exp_cb').prop('checked') ? $('#price_tier #exp_cb').prop('checked'):$('#weight_tier #exp_cb').prop('checked');
        var two_cb = $('#price_tier #2d_cb').prop('checked')?$('#price_tier #2d_cb').prop('checked'):$('#weight_tier #2d_cb').prop('checked');
        var one_cb = $('#price_tier #1d_cb').prop('checked')?$('#price_tier #1d_cb').prop('checked'):$('#weight_tier #1d_cb').prop('checked');
        var tier = $('input[name=shipping_tier]:checked').val();

        var bands = {};
       bands['std_cb'] = std_cb;
       bands['exp_cb'] = exp_cb;
       bands['two_cb'] = two_cb;
       bands['one_cb'] = one_cb;
       bands['tier'] = tier;
       bands['action'] = 'update';
       bands['<?php echo $this->security->get_csrf_token_name() ?>'] = '<?php echo $this->security->get_csrf_hash() ?>';
    
    $("input[name^='band']").each(function(k, e) {
            bands[e.name] = e.value;
        });

        $.ajax({
            url: "<?php echo base_url() ?>supplier/update_shippingtable",
            type:'post',
            data: bands,
            success: function(result) {
                var convert = JSON.parse(result);
                if (convert.status == 0) // has error input
                {
                    alert(convert.message);
                } else {
                    alert("Information updated sucessfully");
                    $(window.location).attr('href', "<?php echo base_url() ?>supplier/shippingtable");
                }

            }});
    });
</script>
<?php echo $this->load->view('supplier/footer') ?>