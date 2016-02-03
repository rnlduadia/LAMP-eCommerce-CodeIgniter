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
				        <li class="nav-one">
				        	<a href="#billing" class="current">
								<div class="head-tab fl">
									<div class="tab-center fl">
										<p class="fl">Billing Address</p>
									</div>
								</div>
				        	</a>
				        </li>
				        <?php if($payment_type != 'apruve'): ?>
				        <li class="nav-two">
				        	<a href="#credit" >
								<div class="head-tab fl">
									<div class="tab-center fl">
										<p class="fl">Credit Card Information</p>
									</div>
								</div>
				        	</a>
				        </li>
				        <?php endif ?>
				        <li class="nav-three">
				        	<a href="#shipping">
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

						<ul id="billing">
							<li>
								<div class='product-cont padded-cont clearfix'>
									<h3>Billing Address</h3>

									<div class='clearfix inner-cont-billing-checkout'>
										<div class='fl'><input type='radio' class='billing_address'  name='billing_address' checked  value='usesame' /></div>
										<div class='fl'>
											<p>Use the saved information for the Billing Address</p>
										</div>
										<div class='clear'></div>

										<div class='fl'><input type='radio' class='billing_address'  name='billing_address'  value='userOther' /></div>
										<div class='fl'>
											<p>Create New Billing Address</p>
										</div>
									</div>
									<div class='clear'></div>

									<div class='inner-cont-billing-checkout clearfix' id='existing-billing'>
										<?php foreach($billing_address as $bil){
											if($bil->ba_isset == 1){ $billing_set = $bil->ba_id;  ?>
											<div class='fl selectable-div'>
												<div class='fl'><input type='radio' class='billing_group' name='billing' checked value='<?php echo $bil->ba_id?>' /></div>
												<div class='fl'>
													<input type='hidden' id='billing_add1_<?php echo $bil->ba_id;?>' value='<?=$bil->ba_add1?>'>
													<input type='hidden' id='billing_add2_<?php echo $bil->ba_id;?>' value='<?=$bil->ba_add2?>'>
													<input type='hidden' id='billing_city_<?php echo $bil->ba_id;?>' value='<?=$bil->ba_city?>'>
													<input type='hidden' id='billing_prov_<?php echo $bil->ba_id;?>' value='<?=$bil->ba_province?>'>
													<input type='hidden' id='billing_postal_<?php echo $bil->ba_id;?>' value='<?=$bil->ba_postal?>'>
													<input type='hidden' id='billing_phone_num_<?php echo $bil->ba_id;?>' value='<?=$bil->ba_phone_num?>'>
													<input type='hidden' id='billing_phone_ext_<?php echo $bil->ba_id;?>' value='<?=$bil->ba_phone_ext?>'>

													<p><a href='#' id='billing_edit' onClick='bill_filleditform(<?php echo $bil->ba_id;?>)';>Address: <?php echo $bil->ba_add1?>, <?php echo $bil->ba_postal?></a></p>
													<p>City: <?php echo $bil->ba_city?></p>
													<p>Province: <?php echo $bil->ba_province?></p>
													<p>Number: <?php echo $bil->ba_phone_num." ".$bil->ba_phone_ext	?></p>
												</div>
											</div>
										<?php }else{?>
											<div class='fl selectable-div'>
												<div class='fl'><input type='radio' class='billing_group' name='billing' value='<?php echo $bil->ba_id?>' /></div>
												<div class='fl'>

													<input type='hidden' id='billing_add1_<?php echo $bil->ba_id;?>' value='<?=$bil->ba_add1?>'>
													<input type='hidden' id='billing_add2_<?php echo $bil->ba_id;?>' value='<?=$bil->ba_add2?>'>
													<input type='hidden' id='billing_city_<?php echo $bil->ba_id;?>' value='<?=$bil->ba_city?>'>
													<input type='hidden' id='billing_prov_<?php echo $bil->ba_id;?>' value='<?=$bil->ba_province?>'>
													<input type='hidden' id='billing_postal_<?php echo $bil->ba_id;?>' value='<?=$bil->ba_postal?>'>
													<input type='hidden' id='billing_phone_num_<?php echo $bil->ba_id;?>' value='<?=$bil->ba_phone_num?>'>
													<input type='hidden' id='billing_phone_ext_<?php echo $bil->ba_id;?>' value='<?=$bil->ba_phone_ext?>'>

													<p><a href='#' id='billing_edit' onClick='bill_filleditform("<?php echo $bil->ba_id;?>")';>Address: <?php echo $bil->ba_add1?>, <?php echo $bil->ba_postal?></a></p>
													<p>City: <?php echo $bil->ba_city?></p>
													<p>Province/State: <?php echo $bil->ba_province?></p>
													<p>Number: <?php echo $bil->ba_phone_num." ".$bil->ba_phone_ext	?></p>
												</div>
											</div>
										<?php } }?>
									</div>

									<div class='inner-cont-billing-checkout clearfix' id='new-billing' style='display:none'>

										<div>
											<label for='billing-country'>Country*</label>
											<div class='clear'></div>
											<select id='billing-country'>
											<?php
											foreach($countries as $country){?>
												<option <?php  if( $countr_sel+"" == $country->c_id){ ?> selected="selected" <?php }?> value="<?php echo $country->c_id?>"><?php echo $country->c_name?></option>
											<?php }?>
											</select>
										</div>

										<div>
											<label for='billing-address1'>Address 1*</label>
											<div class='clear'></div>
											<input type='text' class='longer' id='billing-address1' />
										</div>

										<div>
											<label for='billing-address2'>Address 2</label>
											<div class='clear'></div>
											<input type='text' class='longer' id='billing-address2' />
										</div>

										<div>
											<label for='billing-city'>City/Town*</label>
											<div class='clear'></div>
											<input type='text' class='long' id='billing-city' />
										</div>

										<div id='billing-drp-state'>
											<label for='billing-state_dropdown'>State*</label>
											<div class='clear'></div>
											<select id='billing-state_dropdown'>
												<?php
												foreach($states as $state){?>
													<option value="<?php echo $state->st_name?>"><?php echo $state->st_name?></option>
												<?php }?>
											</select>
										</div>

										<div id='billing-state-textbox' style='display:none'>
											<label for='billing-province'>Province/Region/State*</label>
											<div class='clear'></div>
											<input type='text' class='long' id='billing-province' />
										</div>

										<div>
											<label for='billing-postal_code'>Postal Code/Zip Code*</label>
											<div class='clear'></div>
											<input type='text' id='billing-postal_code' />
										</div>

										<div>
											<label for='billing-phone_num'>Phone Number*</label>
											<div class='clear'></div>
											<input type='text' id='billing-phone_num' />+<input type='text' class='small no-margin' id='billing-phone_ext' />
										</div>

										<div class='billing-result-validation'>

										</div>

									</div>

									<div class='clear'></div>
									<button class='fr normal-button step-format' id='step_2_validate' style='display:none'>Validate</button>
										<button class='greenbutton floatR' id='step_2'>NEXT</button>
									<script type="text/javascript">
										var billing_info = 1;//used the existing for 1
										var isBilling_valid = 0;
										var billing = '<?php echo $billing_set?>';
										var billing_is_state = true;

						    			$('.billing_address').click(function(){
											var sel = $('input[name=billing_address]:radio:checked').val();
											if(sel == 'userOther')
											{
												$('#existing-billing').hide();
												$('#new-billing').fadeIn();
												billing_info = 0;
												$('#step_2').hide();
												$('#step_2_validate').fadeIn();
												$('#send-transaction').hide();
											}
											else
											{
												$('#new-billing').hide();
												$('#existing-billing').fadeIn();
												billing_info = 1;
												$('#step_2_validate').hide();
												$('#step_2').fadeIn();
												$('#send-transaction').fadeIn();
											}
											setSizesDynamic();
										});

										$('#step_2').click(function(){
											<?php if($payment_type != 'apruve'): ?>
										 	$('.nav-two a').trigger('click');
										 	<?php else: ?>
										 	$('.nav-three a').trigger('click');
										 	<?php endif ?>
											setSizesDynamic();

											if(billing_info == 0) //new billing info
												validate_billing_new(1);
										 });

										$('#step_2_validate').click(function(){
										 		validate_billing_new(0);
										 });

										 function validate_billing_new(type)
										 {
										 	var country = $('#billing-country').val();
											var add1 = $('#billing-address1').val();
											var add2 = $('#billing-address2').val();
											var city = $('#billing-city').val();

											var prov = '';
											if(billing_is_state)
												prov = $('#billing-state_dropdown').val();
											else
												prov = $('#billing-province').val();

											var postal = $('#billing-postal_code').val();
											var phone_num = $('#billing-phone_num').val();
											var phone_ext = $('#billing-phone_ext').val();

											if(type == 0)
											{
												$.post('<?php echo base_url()?>buyer/billingValidate',{country:country,add1:add1,add2:add2,city:city,prov:prov,postal:postal,phone_num:phone_num,phone_ext:phone_ext,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},
												function(result){
													var  data = JSON.parse(result);
													isBilling_valid = data.status;
													if(data.status == 1)
													{
														$('.billing-result-validation').html(data.message);
														$('#step_2_validate').hide();
														$('#step_2').fadeIn();
														$('#send-transaction').fadeIn();
													}
													else if(data.status == 0)
													{
														$('#step_2').hide();
														$('#send-transaction').hide();
														$('#step_2_validate').fadeIn();
														$('.billing-result-validation').html(data.message);
													}
												});
											}
											else if(type == 1)//adding it into the system
											{
												$.post('<?php echo base_url()?>buyer/billing',{country:country,add1:add1,add2:add2,city:city,prov:prov,postal:postal,phone_num:phone_num,phone_ext:phone_ext,
													action:'add','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
													var  data = JSON.parse(result);
													isBilling_valid = data.status;
													if(data.status == 1)
													{
														billing = data.id;
														$('.billing-result-validation').html(data.message);
														$('#step_2_validate').hide();
														$('#step_2').fadeIn();
														$('#send-transaction').fadeIn();
													}
													else if(data.status == 0)
													{
														$('#step_2').hide();
														$('#send-transaction').hide();
														$('#step_2_validate').fadeIn();
														$('.billing-result-validation').html(data.message);
													}
												});
											}

										 }

										 $('#billing-country').change(function(){
											var country_sel = this.value;

											$.post("<?php echo base_url()?>country/load",{id:country_sel,type:'dropdown','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){

												if(result != 0)
												{
													$('#billing-state_dropdown').html(result);
													$('#billing-drp-state').fadeIn();
													$('#billing-state-textbox').hide();
													billing_is_state = true;
												}
												else
												{
													billing_is_state = false;
													$('#billing-state-textbox').fadeIn();
													$('#billing-drp-state').hide();
												}
											});
										});
							    	</script>
								</div>
							</li>
						</ul>

						<?php if($payment_type != 'apruve'): ?>
						<ul id="credit" class='hide1' style='display:none'>
							<li>
								<div class='product-cont padded-cont clearfix'>
									<h3>Credit Card Information</h3>
									<div class='clearfix inner-cont-billing-checkout'>
										<div class='fl'><input type='radio' class='cc_info'  name='cc_info' checked  value='usesame' /></div>
										<div class='fl'>
											<p>Use the saved information for the Credit Card Information</p>
										</div>
										<div class='clear'></div>

										<div class='fl'><input type='radio' class='cc_info'  name='cc_info'  value='userOther' /></div>
										<div class='fl'>
											<p>Create New Credit Card Information</p>
										</div>
									</div>
									<div class='clear'></div>

									<div class='inner-cont-billing-checkout clearfix' id='existing-cc'>
										<?php $ccu_ccv= ''; foreach($credit_card as $cc){
											if($cc->ccu_isset == 1){ $ccu_id_set = $cc->ccu_id; $ccu_ccv = $ccu->ccu_ccv  ?>
											<div class='fl selectable-div'>
												<div class='fl'><input type='radio' class='cc_group' name='cc' checked='checked' value='<?php echo $cc->ccu_id?>' /></div>
												<div class='fl'>
													<input type='hidden' id='ccu_number_<?php echo $cc->ccu_id?>' value='<?=$cc->ccu_number?>'>
													<input type='hidden' id='ccu_name_<?php echo $cc->ccu_id?>' value='<?=$cc->ccu_name?>'>
													<input type='hidden' id='ccu_exp_year_<?php echo $cc->ccu_id?>' value='<?=$cc->ccu_exp_year?>'>
													<input type='hidden' id='ccu_exp_month_<?php echo $cc->ccu_id?>' value='<?=$cc->ccu_exp_month?>'>
													<p>Credit Card #: <?php echo '***********'.substr($cc->ccu_number, 11, 15)?></p>
													<p>Credit Card name: <?php echo $cc->ccu_name?></p>
													<p>Expiration: <?php  if(count($cc->ccu_exp_month) == 1){echo '0';}; echo $cc->ccu_exp_month."/".$cc->ccu_exp_year	?></p>
												</div>
											</div>
										<?php }else{?>
											<div class='fl selectable-div'>
												<div class='fl'><input type='radio' class='cc_group' name='cc' value='<?php echo $cc->ccu_id?>' /></div>
												<div class='fl'>
													<input type='hidden' id='ccu_number_<?php echo $cc->ccu_id?>' value='<?=$cc->ccu_number?>'>
													<input type='hidden' id='ccu_name_<?php echo $cc->ccu_id?>' value='<?=$cc->ccu_name?>'>
													<input type='hidden' id='ccu_exp_year_<?php echo $cc->ccu_id?>' value='<?=$cc->ccu_exp_year?>'>
													<input type='hidden' id='ccu_exp_month_<?php echo $cc->ccu_id?>' value='<?=$cc->ccu_exp_month?>'>
													<p>Credit Card #: <?php echo $cc->ccu_number?></p>
													<p>Credit Card name: <?php echo $cc->ccu_name?></p>
													<p>Expiration: <?php  if(count($cc->ccu_exp_month) == 1){echo '0';}; echo $cc->ccu_exp_month."/".$cc->ccu_exp_year	?></p>
												</div>
											</div>

										<?php } }?>
									</div>

									<div class='inner-cont-billing-checkout clearfix' id='new-cc' style='display:none'>
										<div class='clearfix'>
											<label for='cctype'>Credit Card Type*</label>
											<div class='clear'></div>
											<select id='cctype'  name="cctype">
												<?php
												foreach(/*$credit_cards*/$credit_card_types as $creditcard){?>
													<option value="<?php echo $creditcard->cc_id?>"><?php echo $creditcard->cc_type?></option>
												<?php }?>
											</select>
										</div>

										<div class='clearfix'>
											<label for='ccuname'>Cardholder's Name*</label>
											<div class='clear'></div>
											<input type='text' id='ccuname' name="ccuname" />
										</div>

										<div class='clearfix'>
											<label for='ccunum'>Credit Card Number*</label>
											<div class='clear'></div>
											<input type='text' id='ccunum' name="ccunum" />
										</div>

										<div class='clearfix'>
											<label for='ccuccv'>CCV*</label>
											<div class='clear'></div>
											<input type='text' class='small4' maxlength='4' id='ccuccv' name="ccuccv" />
										</div>

										<div class='clearfix'>
											<label for='exp_month'>Expiration Date*</label>
											<div class='clear'></div>
											<select id='exp_month' class='medium' name="exp_month">
												<?php echo $this->creditcards->generate_months('option'); ?>
											</select>
											<select id='exp_year' class='small' name="exp_year">
												<?php
												$year_set = date('Y', strtotime('+7 year'));
												echo $this->creditcards->generate_years($year_set,date('Y')); ?>
											</select>
										</div>
									</div>
									<button class='fr normal-button step-format' id='step_3_validate' style='display:none'>Validate</button>
									<button class='greenbutton floatR' id='step_3'>NEXT</button>
									<div class='credit-result-validation'>

									</div>
								</div>
									<script type="text/javascript">
										var cc_info = 1;//used the existing for 1
										var iscc_valid = 0;
										var cc = <?php echo $ccu_id_set ? $ccu_id_set : '\'\''?>;
										$('.cc_info').click(function(){
											var sel = $('input[name=cc_info]:radio:checked').val();
											if(sel == 'userOther')
											{
												$('#existing-cc').hide();
												$('#new-cc').fadeIn();
												cc_info = 0;
												$('#step_3').hide();
												$('#step_3_validate').fadeIn();
												$('#step_3').trigger("click");
											}
											else
											{

												$('#new-cc').hide();
												$('#existing-cc').fadeIn();
												cc_info = 1;
												$('#step_3_validate').hide();
												$('#step_3').fadeIn();
											}
											setSizesDynamic();

										});

										$('.cc_group').click(function(){
											cc = $(this).val();
										});

										 $('#step_3').click(function(){
											if(cc_info == 0) //new billing info
												validate_cc_new(1);
											if(cc == '' && cc_info != 0) {alert('Default Credit card is not specified');return;}
											$('.nav-three a').trigger('click');
											//setSizesDynamic();
										 });

										$('#step_3_validate').click(function(){
										 	validate_cc_new(0);
										 });

										function validate_cc_new(type)
										{
											var cctype = $('#cctype').val();
											var ccuname = $('#ccuname').val();
											var ccunum = $('#ccunum').val();
											var ccuccv = $('#ccuccv').val();
											var exp_month = $('#exp_month').val();
											var exp_year = $('#exp_year').val();

											if(type == 0) //validate cc
											{
												$.post("<?php echo base_url()?>buyer/validateCc",{cctype:cctype,ccuname:ccuname,ccunum:ccunum,ccuccv:ccuccv,exp_month:exp_month,exp_year:exp_year,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>',
												},function(result){
													var  data = JSON.parse(result);
													iscc_valid = data.status;
													if(data.status == 1)
													{
														$('.credit-result-validation').html(data.message);
														$('#step_3_validate').hide();
														$('#step_3').fadeIn();
														setTimeout(function(){$('#step_3').trigger("click");},500);
														return;
													}
													else if(data.status == 0)
													{
														$('.credit-result-validation').html(data.message);
													}
													alert(data.message);

												});
											}
											else if(type == 1) //add cc
											{
												$.post("<?php echo base_url()?>buyer/addnewcreditcard",{cctype:cctype,ccuname:ccuname,ccunum:ccunum,ccuccv:ccuccv,exp_month:exp_month,exp_year:exp_year,
												action:'add','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){

													var  data = JSON.parse(result);
													isBilling_valid = data.status;
													if(data.status == 1)
													{
														cc = data.ccid;
														$('.credit-result-validation').html(data.message);
														$('#step_3_validate').hide();
														$('#step_3').fadeIn();
													}
													else if(data.status == 0)
													{
														$('#step_3').hide();
														$('#step_3_validate').fadeIn();
														$('.credit-result-validation').html(data.message);
													}
												});
											}
										}
									</script>
							</li>
						</ul>
						<?php endif ?>

						<ul id="shipping" class='hide1' style='display:none'>
							<li>
								<div class='product-cont padded-cont clearfix'>
									<h3>Shipping Address</h3>

									<div class='inner-cont-billing-checkout clearfix'>

										<div class='fl'><input type='radio' class='shipp_address'  name='shipp_address' checked  value='usesame' /></div>
										<div class='fl'>
											<p>Use the same information from the Billing Address</p>
										</div>
										<div class='clear'></div>

										<?php if (count(array_filter($shipping_adress, function($a){ return (!$a->bt_is_sameBilling_to_ship);}))) : ?>
										<div class='fl'><input type='radio' class='shipp_address'  name='shipp_address'  value='userOther' /></div>
										<div class='fl'>
											<p>Send to other saved Shipping Address</p>
										</div>
										<div class='clear'></div>
										<?php endif; ?>

										<div class='other-shipping-info'>
										<div class='inner-cont-billing-checkout clearfix' id='existing-shipping'>
										<?php foreach($shipping_adress as $ship){
											if($ship->bt_is_sameBilling_to_ship == 0){  ?>
											<div class='fl selectable-div'>
												<div class='fl'><input type='radio' class='shipping_group' name='shipping' value='<?php echo $ship->bts_id;?>' /></div>
												<div class='fl'>
													<input type='hidden' id='ship_name_<?php echo $ship->bts_id;?>' value='<?=$ship->bts_name?>'>
													<input type='hidden' id='ship_add1_<?php echo $ship->bts_id;?>' value='<?=$ship->bts_add1?>'>
													<input type='hidden' id='ship_add2_<?php echo $ship->bts_id;?>' value='<?=$ship->bts_add2?>'>
													<input type='hidden' id='ship_city_<?php echo $ship->bts_id;?>' value='<?=$ship->bts_city?>'>
													<input type='hidden' id='ship_prov_<?php echo $ship->bts_id;?>' value='<?=$ship->bts_prov?>'>
													<input type='hidden' id='ship_postal_<?php echo $ship->bts_id;?>' value='<?=$ship->bts_postal?>'>
													<input type='hidden' id='ship_phone_num_<?php echo $ship->bts_id;?>' value='<?=$ship->bts_phone_num?>'>
													<input type='hidden' id='ship_phone_ext_<?php echo $ship->bts_id;?>' value='<?=$ship->bts_phone_ext?>'>

													<p><a href='#' id='ship_edit' onClick='ship_filleditform("<?php echo $ship->bts_id;?>")';>Receiver: <?php echo $ship->bts_name?></a></p>
													<p>Address: <?php echo $ship->bts_add1?>, <?php echo $ship->bts_postal;?></p>
													<p>City: <?php echo $ship->bts_city?></p>
													<p>Province: <?php echo $ship->bts_prov?></p>
													<p>Number: <?php echo $ship->bts_phone_num." ".$ship->bts_phone_ext?></p>
												</div>
											</div>

										<?php } }?>
										</div>
										</div>
										<div class='clear'></div>

										<div class='fl'><input type='radio' class='shipp_address'  name='shipp_address'  value='userNew' /></div>
										<div class='fl'>
											<p>Send to Other/New Address</p>
										</div>
										<div class='clear'></div>
										<div class='new-shipping-info'>

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
									<button class='fr normal-button step-format' id='step_4_validate' style='display:none'>VALIDATE</button>
									<button class='greenbutton floatR' id='step_4'>NEXT</button>
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

	function bill_filleditform(billing_id){
		var bill_country = $('#billing-country').val();
		var bill_add1 = $('#billing_add1_'+billing_id).val();
		var bill_add2 = $('#billing_add2_'+billing_id).val();
		var bill_city = $('#billing_city_'+billing_id).val();
		var bill_prov = $('#billing_prov_'+billing_id).val();
		var bill_postal = $('#billing_postal_'+billing_id).val();
		var bill_phone_num = $('#billing_phone_num_'+billing_id).val();
		var bill_phone_ext = $('#billing_phone_ext_'+billing_id).val();
		$('input[name=billing_address][value=userOther]').click();

			$('#existing-billing').hide();
			$('#new-billing').fadeIn();
			billing_info = 0;
			$('#step_2').hide();
			$('#step_2_validate').fadeIn();
			$('#send-transaction').hide();

                $('#billing-address1').val(bill_add1);
                $('#billing-address2').val(bill_add2);
                $('#billing-city').val(bill_city);
                if(billing_is_state)
                         $('#billing-state_dropdown').val(bill_prov);
                else
                         $('#billing-province').val(bill_prov);

                $('#billing-postal_code').val(bill_postal);
                $('#billing-phone_num').val(bill_phone_num);
                $('#billing-phone_ext').val(bill_phone_ext);

	}

	function ship_filleditform(ship_id){
		var ship_reciever = $('#ship_name_'+ship_id).val();
		var ship_country = $('#country').val();
		var ship_add1 = $('#ship_add1_'+ship_id).val();
		var ship_add2 = $('#ship_add2_'+ship_id).val();
		var ship_city = $('#ship_city_'+ship_id).val();
		var ship_prov = $('#ship_prov_'+ship_id).val();
		var ship_postal = $('#ship_postal_'+ship_id).val();
		var ship_phone_num = $('#ship_phone_num_'+ship_id).val();
		var ship_phone_ext = $('#ship_phone_ext_'+ship_id).val();
		$('input[name=shipp_address][value=userNew]').click();

			$('.new-shipping-info').fadeIn();
			shipping_info = 0;
			$('.other-shipping-info').hide();
			$('#step_4').hide();
			$('#step_4_validate').fadeIn();
			$('#send-transaction').hide();

				$('#receiver_name').val(ship_reciever);
                $('#address1').val(ship_add1);
                $('#address2').val(ship_add2);
                $('#city').val(ship_city);
                if(is_state)
                         $('#state_dropdown').val(ship_prov);
                else
                         $('#province').val(ship_prov);

                $('#postal_code').val(ship_postal);
                $('#phone_num').val(ship_phone_num);
                $('#phone_ext').val(ship_phone_ext);

	}

	$('#send-transaction').click(function(){

		var ccu_ccv = '<?=$cc->ccu_ccv?>'; // $ccu_ccv
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

	if($('input[name=shipp_address]:radio:checked').val() == "userOther"){
		var receiver_name = $('#ship_name_'+ship).val();
		var country = $('#country').val();
		var add1 = $('#ship_add1_'+ship).val();
		var add2 = $('#ship_add2_'+ship).val();
		var city = $('#ship_city_'+ship).val();
		prov = $('#ship_prov_'+ship).val();
		var postal = $('#ship_postal_'+ship).val();
		var phone_num = $('#ship_phone_num_'+ship).val();
		var phone_ext = $('#ship_phone_ext_'+ship).val();
		var email = $('#email').val();
	} else {
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
	}

	if($('input[name=billing_address]:radio:checked').val() == "usesame"){

		var bill_country = $('#billing-country').val();
		var bill_add1 = $('#billing_add1_'+billing).val();
		var bill_add2 = $('#billing_add2_'+billing).val();
		var bill_city = $('#billing_city_'+billing).val();
		var bill_prov = $('#billing_prov_'+billing).val();
		var bill_postal = $('#billing_postal_'+billing).val();
		var bill_phone_num = $('#billing_phone_num_'+billing).val();
		var bill_phone_ext = $('#billing_phone_ext_'+billing).val();

	} else {
                var bill_country = $('#billing-country').val();
                var bill_add1 = $('#billing-address1').val();
                var bill_add2 = $('#billing-address2').val();
                var bill_city = $('#billing-city').val();

                var bill_prov = '';
                if(billing_is_state)
                        bill_prov = $('#billing-state_dropdown').val();
                else
                        bill_prov = $('#billing-province').val();

                var bill_postal = $('#billing-postal_code').val();
                var bill_phone_num = $('#billing-phone_num').val();
                var bill_phone_ext = $('#billing-phone_ext').val();
	}
                /*determine type of payment, paypal or authorize*/
		var type = $('#payment_type').val();
		if (type =='paypal') {
			var processor = '<?php echo base_url()?>payflow/Process_transaction';
		}
		else if (type =='authorize') {
			var processor = '<?php echo base_url()?>authorized/send_payment';
		}

		if(type != 'apruve') {
			$.post(processor,{amt:amt,ccu_number:ccu_number, ccv:ccu_ccv, ccu_name:ccu_name,ccu_exp_month:ccu_exp_month,ccu_exp_year:ccu_exp_year,cc:cc,billing:billing,shipping_info:shipping_info,receiver_name:receiver_name,country:country,add1:bill_add1,add2:bill_add2,city:bill_city,prov:bill_prov,postal:bill_postal,phone_num:bill_phone_num,phone_ext:bill_phone_ext,email:email,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},
				function(result){
					var data = JSON.parse(result);
					alert(data.response_reason_text);
					if (data.approved) {
						requestType = 'payment';
						//<?php echo base_url()?>payments_pro/do_direct_payment
						$.post('<?php echo base_url()?>payment/buyer',{trans_id:data.transaction_id,cc:cc,billing:billing,shipping_info:shipping_info,receiver_name:receiver_name,country:country,add1:add1,add2:add2,city:city,prov:prov,postal:postal,phone_num:phone_num,phone_ext:phone_ext,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},
							function(result){
							var  data = JSON.parse(result);
							$('#payment-result').html(data.display);
							if(data.status == 1)
							{
								$('.final-payment-table').fadeOut();
								$('#send-transaction').hide();
							}
						});
					}
			});
		}

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


	$('.billing_group').click(function(){
		var sel = $('input[name=billing]:radio:checked').val();
		billing = sel;
	});

	$('.cc_group').click(function(){
		var sel = $('input[name=cc]:radio:checked').val();
		cc = sel;
	});

	$('.shipping_group').click(function(){
		var sel = $('input[name=shipping]:radio:checked').val();
		ship = sel;
	});
	//changing div if using existing information or not
	$('.shipp_address').click(function(){
		var sel = $('input[name=shipp_address]:radio:checked').val();
		if(sel == 'userNew')
		{
			$('.new-shipping-info').fadeIn();
			shipping_info = 0;
			$('.other-shipping-info').hide();
			$('#step_4').hide();
			$('#step_4_validate').fadeIn();
			$('#send-transaction').hide();
		}
		else
		{
			if (sel == 'userOther') {
				$('.other-shipping-info').fadeIn();
				shipping_info = 0;
			}
			else {
				$('.other-shipping-info').hide();
				shipping_info = 1;
			}
			$('.new-shipping-info').hide();
			$('#step_4_validate').hide();
			$('#step_4').fadeIn();
			$('#send-transaction').fadeIn();

		}
		setSizesDynamic();
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

	 function validate_shipping_new()
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
			action:'validate','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
			var  data = JSON.parse(result);
			if(data.status == 1)
			{
				$('.shipping-result-validation').html("Shipping Detail Valid");
				$('#step_4_validate').hide();
				$('#step_4').fadeIn();
				$('#send-transaction').fadeIn();
			}
			else if(data.status == 0)
			{
				$('#step_4').hide();
				$('#send-transaction').hide();
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

	<?php if($payment_type == 'apruve'): ?>
	$('.nav-four, .nav-four a').click(function() {
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

	if($('input[name=shipp_address]:radio:checked').val() == "userOther"){
		var receiver_name = $('#ship_name_'+ship).val();
		var country = $('#country').val();
		var add1 = $('#ship_add1_'+ship).val();
		var add2 = $('#ship_add2_'+ship).val();
		var city = $('#ship_city_'+ship).val();
		prov = $('#ship_prov_'+ship).val();
		var postal = $('#ship_postal_'+ship).val();
		var phone_num = $('#ship_phone_num_'+ship).val();
		var phone_ext = $('#ship_phone_ext_'+ship).val();
		var email = $('#email').val();
	} else {
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
	}
		/*determine type of payment, paypal or authorize*/
		var type = $('#payment_type').val();
		$.post('<?php echo base_url()?>payment/buyer?keep=1',{trans_id:type,cc:cc,billing:billing,shipping_info:shipping_info,receiver_name:receiver_name,country:country,add1:add1,add2:add2,city:city,prov:prov,postal:postal,phone_num:phone_num,phone_ext:phone_ext,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},
			function(result){
			var  data = JSON.parse(result);
			var display = data.display;
			if(data.status == 1)
			{
				var apruveRequestId = null;
				apruve.registerApruveCallback(apruve.APRUVE_COMPLETE_EVENT, function () {
					$.post('/apruve/confirm', {request_id: apruve.paymentRequestId, order_id: apruve.paymentRequest.merchant_order_id,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'}, function(data) {
						if(data.success) {
							$('.final-payment-table').fadeOut();
							$('#payment-result').html(display);
							$('#apruveDiv').hide();
						}
					}, 'json');
				});
				$('#send-transaction').hide();
				$('#apruveDiv').show();
				$.get('/apruve/hash', {bt_id: data.bt_id}, function(data) {
					if(data.success) {
						apruve.secureHash = data.hash;
						apruve.paymentRequest = data.request;
					}
				}, 'json');
			}
        });
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
