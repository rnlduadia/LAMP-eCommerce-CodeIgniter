<?php

if($this->session->userdata('is_login') == TRUE)
{
	$user_type = $this->session->userdata('type'); //get user type;
	if($user_type == 2) //2 is Supplier
	{
		echo $this->load->view('supplier/header');
	}
	elseif($user_type == 3) //3 is Buyer
	{
		echo $this->load->view('buyer/header');
	}
}
else
	echo $this->load->view('header');
?>
<script src="<?php echo base_url()?>js/organictabs.jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery.validate.js" type="text/javascript"></script>
<?php if($payment_type == 'apruve'): ?>
	<script type="text/javascript">
		var orderId = "<?php echo $order_id ?>";
	</script>
	<script src="https://www.apruve.com/js/apruve.js" type="text/javascript"></script>
<?php endif ?>
			<!-- LEFT SIDEBAR CONTAINER-->
			<div class="nav-bar floatL">

				<?php
				if($this->session->userdata('is_login') == TRUE)
				{
					$user_type = $this->session->userdata('type'); //get user type;
					if($user_type == 2) //2 is Supplier
					{
						echo $this->load->view('supplier/sidebar');
					}
					elseif($user_type == 3) //3 is Buyer
					{
						echo $this->load->view('sidebar');
					}
				}
				else
						echo $this->load->view('sidebar');
				?>
			</div>

			<!-- RIGHT CONTENT CONTAINER-->
			<div class='sliderLg floatR'>

			<?php if(count($cart) == 0) {?>
			<center><p>--Need Atleast 1 Item in your Cart--</p></center>
			<?php }else{
				/*echo '';
				print_r($payment_type);*/

				?>

			<div class="prodinfoblock prodininfo">
			<div id="supplier-product-tab">


					<ul class="nav">
				        <li class="nav-three">
				        	<a href="#shipping" class="current">
				        		<div class="head-tab fl">
									<div class="tab-center fl">
										<p class="fl">Shipping Address</p>
									</div>
								</div>
				        	</a>
				        </li>
				        <li class="nav-four">
				        	<a href="#confirm">
				        		<div class="head-tab fl">
									<div class="tab-center fl">
										<p class="fl">Confirm Payment</p>
									</div>
								</div>
				        	</a>
				        </li>
				    </ul>

				    <div class="list-wrap clearfix">

						<ul id="shipping" class='hide1'>
							<li>
								<div class='product-cont padded-cont clearfix'>
									<h3>Shipping Address</h3>

									<div class='inner-cont-billing-checkout clearfix'>
										<div class='new-shipping-info' style="display: block !important;">

											<div>
												<label for='receiver_name'>Receiver's Name*</label>
												<div class='clear'></div>
												<input type='text' class='longer' id='receiver_name' />
											</div>

											<div>
												<label for='country'>Country*</label>
												<div class='clear'></div>
												<select id='country'>
												<?php
												foreach($countries as $country){?>
													<option <?php  if( $countr_sel+"" == $country->c_id){ ?> selected="selected" <?php }?> value="<?php echo $country->c_id?>"><?php echo $country->c_name?></option>
												<?php }?>
												</select>
											</div>

											<div>
												<label for='address1'>Address 1*</label>
												<div class='clear'></div>
												<input type='text' class='longer' id='address1' />
											</div>

											<div>
												<label for='address2'>Address 2</label>
												<div class='clear'></div>
												<input type='text' class='longer' id='address2' />
											</div>

											<div>
												<label for='city'>City/Town*</label>
												<div class='clear'></div>
												<input type='text' class='long' id='city' />
											</div>

											<div id='drp-state'>
												<label for='state_dropdown'>Province/Region/State*</label>
												<div class='clear'></div>
												<select id='state_dropdown'>
													<?php
													foreach($states as $state){?>
														<option value="<?php echo $state->st_name?>"><?php echo $state->st_name?></option>
													<?php }?>
												</select>
											</div>

											<div id='state-textbox'>
												<label for='province'>Province/Region/State*</label>
												<div class='clear'></div>
												<input type='text' class='long' id='province' />
											</div>

											<div>
												<label for='postal_code'>Postal Code/Zip Code*</label>
												<div class='clear'></div>
												<input type='text' id='postal_code' />
											</div>

											<div>
												<label for='phone_num'>Phone Number*</label>
												<div class='clear'></div>
												<input type='text' id='phone_num' />+<input type='text' class='small no-margin' id='phone_ext' />
												<input type='hidden' id='email' value='<?=$this->session->userdata['email'];?>'/>
											</div>
										</div>
									</div>
									<button class='fr normal-button step-format' id='step_4_validate'>VALIDATE</button>
									<button class='greenbutton floatR' id='step_4' style='display:none'>NEXT</button>
									<div class='shipping-result-validation'>

									</div>
								</div>
							</li>
						</ul>

						<ul id="confirm" class='hide1' style='display:none'>
							<li>
								<div class='product-cont padded-cont clearfix'>
									<h3>Confirm Payment</h3>
									<div class='gray-table final-payment-table'>
						                <table>
						                    <tr>
						                        <td width=100></td>
						                        <td>Item</td>
						                        <td width=20>Quantity</td>
						                        <td width=80>Price</td>
						                        <td width=40>Sub Total</td>
								            </tr>
								            <?php
								            $total_shipping_fee = 0;
								            foreach($cart as $item){
								            	$item_ship_cost = (empty($item['options']['ship_cost_per_item'])) ? $item['options']['ship_cost']*$item['qty'] : $item['options']['shipping_cost']+$item['options']['ship_cost_per_item']*$item['qty'];
								            	$total_shipping_fee += $item_ship_cost;
								            	?>
								            <tr>
								            	<td align='center'>
								            		<?php
													$image_list = $this->inventories->list_image($item['options']['i_id'],1);

													//limit 1, select only the featured image
													if(count($image_list) == 0){?>
														<img width=95 src="<?php echo base_url()?>images/default-preview.jpg">

													<?php }else{?>
														<img width=95  src="/<?php echo $image_list[0]->ii_link ?>">
													<?php }?>
								            	</td>
						                        <td><center><?php echo $item['name']?></center></td>
						                        <td><center><?php echo $item['qty'] ?></center></td>
						                        <td><center>$<?php echo $item['price'] ?></center></td>
						                        <td><center>$<?php echo $item['subtotal'] ?></center></td>
						                    </tr>
										<?php }?>
											<tr>
												<td colspan=3></td>
												<td>Shipping Fee</td>
												<td colspan=2><center>$<?php
											echo $total_shipping_fee;
										?></center></td>
											</tr>
											<tr>
												<td colspan=3></td>
												<td>Total</td>
												<td colspan=2><center>$<?php echo $total + $total_shipping_fee; ?></center></td>
											</tr>
								        </table>
								     </div>
								     <div class='clear'></div>
								     <input type='hidden' value='<?=$payment_type;?>' id='payment_type' />
								    <button class='greenbutton floatR' id='send-transaction'>SEND</button>
								    <div id="apruveDiv" style="display: none;" class='floatR'></div>
								     <div class='fr circle-loading' id='loading-payment'></div>

								     <div id='payment-result'>

								     </div>
								</div>
							</li>
						</ul>

					</div>

			</div>
			<?php }?>

			</div>
			</div>
			<!-- RIGHT CONTENT CONTAINER END-->

<script type="text/javascript">
	<?php if($payment_type == 'apruve'): ?>var cc = <?php echo $ccu_id_set ? $ccu_id_set : '\'\''?>;<?php endif ?>
	$('#state-textbox').hide();


	var shipping_info = 1; //used the existing for 1
	var is_state = true;
	var approved = 0;

	var requestType = '';

	$('#receiver_name, #address1, #address2, #city, #postal_code, #phone_num, #phone_ext').keyup(function() {
		if(valid) {
			valid = false;
			$('#step_4').hide();
			$('#step_4_validate').fadeIn();
		}
	});

	$('#state_dropdown, #country').change(function() {
		if(valid) {
			valid = false;
			$('#step_4').hide();
			$('#step_4_validate').fadeIn();
		}
	});

	$('#country').change(function(){
		var country_sel = this.value;

		$.post("<?php echo base_url()?>country/load",{id:country_sel,type:'dropdown','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
			if(result != 0)
			{
				$('#state_dropdown').html(result);
				$('#drp-state').fadeIn();
				$('#state-textbox').hide();
				is_state = true;
			}
			else
			{
				is_state = false;
				$('#state-textbox').fadeIn();
				$('#drp-state').hide();
			}
		});
	});

	$('#send-transaction').click(function(){
		var amt = '<?=$total + $total_shipping_fee;?>';
		var receiver_name = $('#receiver_name').val();
		var country = $('#country').val();
		var add1 = $('#address1').val();
		var add2 = $('#address2').val();
		var city = $('#city').val();
		if(is_state)
			prov = $('#state_dropdown').val();
		else
			prov = $('#province').val();

		var postal = $('#postal_code').val();
		var phone_num = $('#phone_num').val();
		var phone_ext = $('#phone_ext').val();
		var email = $('#email').val();
		/*determine type of payment, paypal or authorize*/

	});

	$("body").on({
	    ajaxStart: function() {
	    	if(requestType == 'payment')
	        	$('#loading-payment').show();

	    },
	    ajaxStop: function() {
	    	if(requestType == 'payment')
	        	$('#loading-payment').hide();


	        requestType = '';
	    }
	});

	//changing div if using existing information or not end

	 $(function() {

        $("#supplier-product-tab").organicTabs();

    });



	 $('#step_4').click(function(){

	 	$('.nav-four a').trigger('click');
		setSizesDynamic();

	 });
	 $('#step_4_validate').click(function(){
	 	validate_shipping_new();
	 });

	 var valid = false;
	 function validate_shipping_new(checkout)
	{
		var receiver_name = $('#receiver_name').val();
		var country = $('#country').val();
		var add1 = $('#address1').val();
		var add2 = $('#address2').val();
		var city = $('#city').val();
		if(is_state)
			prov = $('#state_dropdown').val();
		else
			prov = $('#province').val();

		var postal = $('#postal_code').val();
		var phone_num = $('#phone_num').val();
		var phone_ext = $('#phone_ext').val();

		$.post('<?php echo base_url()?>buyer/billing',{country:country,add1:add1,add2:add2,city:city,prov:prov,postal:postal,phone_num:phone_num,phone_ext:phone_ext,
			action:'add','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
			var  data = JSON.parse(result);
			if(data.status == 1)
			{
				$('.shipping-result-validation').html("Shipping Detail Valid");
				$('#step_4_validate').hide();
				$('#step_4').fadeIn();
				valid = true;
				if(checkout == true) {
					$('#step_4').trigger('click');
				}
			}
			else if(data.status == 0)
			{
				$('#step_4').hide();
				$('#step_4_validate').fadeIn();
				$('.shipping-result-validation').html(data.message);
			}
		});
	}

	function setSizesDynamic() {
		   var containerHeight = $(".right-cont").height();
		   $(".bg-body-middle").height(containerHeight - 258);
	}

	$('.nav li a').click(function(){
		setTimeout(setSizesDynamic,500);
	});

	var checking = false;

	<?php if($payment_type == 'apruve'): ?>
	$('.nav-four, .nav-four a').click(function() {
		if(!valid) {
			validate_shipping_new(true);
			return;
		}
		if(checking) {
			return;
		}
		checking = true;
		var ccu_number = '<?=$cc->ccu_number?>';
		var ccu_name = '<?=$cc->ccu_name?>';
		var ccu_exp_month = '<?=$cc->ccu_exp_month?>';
		var ccu_exp_year = '<?=$cc->ccu_exp_year?>';
		var ccu_id = '<?=$cc->ccu_id?>';
		if(cc != ccu_id){
			if($("input[name='cc_info']:radio:checked").val() == "userOther"){
				ccu_number = $("#ccunum").val();
				ccu_name = $("#ccuname").val();
				ccu_exp_month = $("#exp_month").val();
				ccu_exp_year = $("#exp_year").val();
			}
			else {
				ccu_number = $("#ccu_number_" + cc).val();
				ccu_name = $("#ccu_name_" + cc).val();
				ccu_exp_month = $("#ccu_exp_month_" + cc).val();
				ccu_exp_year = $("#ccu_exp_year_" + cc).val();
			}
		}
		var amt = '<?=$total + $total_shipping_fee;?>';
		var receiver_name = $('#receiver_name').val();
		var country = $('#country').val();
		var add1 = $('#address1').val();
		var add2 = $('#address2').val();
		var city = $('#city').val();
		if(is_state)
			prov = $('#state_dropdown').val();
		else
			prov = $('#province').val();

		var postal = $('#postal_code').val();
		var phone_num = $('#phone_num').val();
		var phone_ext = $('#phone_ext').val();
		var email = $('#email').val();
		/*determine type of payment, paypal or authorize*/
		var type = $('#payment_type').val();

		$.post('/apruve/hash', {'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'}, function(data) {
			if(data.success) {
				apruve.secureHash = data.hash;
				apruve.paymentRequest = data.request;
				$('#send-transaction').hide();
				$('#apruveDiv').show();

				apruve.registerApruveCallback(apruve.APRUVE_COMPLETE_EVENT, function () {
					$.post('/apruve/confirm', {request_id: apruve.paymentRequestId, order_id: apruve.paymentRequest.merchant_order_id,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'}, function(data) {
						if(data.success) {
							$.post('<?php echo base_url()?>payment/buyer',{cc:cc,billing:null,shipping_info:null,receiver_name:receiver_name,country:country,add1:add1,add2:add2,city:city,prov:prov,postal:postal,phone_num:phone_num,phone_ext:phone_ext,type:'apruve','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'}, function(data) {
								if(data.status == 1) {
									var display = data.display;
									$.post('/apruve/setTransactionOrder', {transaction_id: apruve.paymentRequest.merchant_order_id, order_id: data.bt_id,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'}, function(data){
										if(data.success) {
											$('.final-payment-table').fadeOut();
											$('#payment-result').html(display);
											$('#apruveDiv').hide();
										}
									}, 'json');
								}
							}, 'json');
						}
					}, 'json');
				});
			}
		}, 'json');
	});
	<?php endif ?>

</script>



<?php
if($this->session->userdata('is_login') == TRUE)
{
	$user_type = $this->session->userdata('type'); //get user type;
	if($user_type == 2) //1 is suplier
	{
		echo $this->load->view('supplier/footer');
	}
	elseif($user_type == 3) //3 is Buyer
	{
		echo $this->load->view('buyer/footer');
	}
}
else
		echo $this->load->view('footer');
?>
