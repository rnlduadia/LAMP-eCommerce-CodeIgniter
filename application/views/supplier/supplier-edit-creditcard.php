<!-- Lanz Editted - June 8, 2013 -->
<?php echo $this->load->view('supplier/header') ?>

			<!-- LEFT SIDEBAR CONTAINER-->
			<div class="nav-bar floatL">
				<?php echo $this->load->view('supplier/sidebar');?>
			</div>

			<!-- RIGHT CONTENT CONTAINER-->
			<div class='sliderLg floatR'>
				<div class='right-inner clearfix'>
				<!-- First Row Container-->
					<div class="topBrands searching-for">
						<div class="topBrandsHeader">
							<div class'floatl'="">Credit Card Information:</div>
						</div>
					</div>

					<div class='padded-cont clearfix'>
						<div class='clearfix'>
							<label for='cctype'>Credit Card Type*</label>
							<div class='clear'></div>
							<select id='cctype' class='medium normal-format-select' name="cctype">
								<?php foreach($creditcards as $creditcard){?>
									<option <?php if ($creditcard->cc_id == $credit_info->cc_id){ echo "selected = 'selected' "; } ?> value="<?php echo $creditcard->cc_id ?>"><?php echo $creditcard->cc_type?></option>
								<?php }?>
							</select>
						</div>

						<div class='clearfix'>
							<label for='ccuname'>Cardholder's Name*</label>
							<div class='clear'></div>
							<input type='text' id='ccuname' name="ccuname" value="<?php echo $credit_info->ccu_name ?>"  class='normal-format-text'/>
						</div>

						<div class='clearfix'>
							<label for='ccunum'>Credit Card Number*</label>
							<div class='clear'></div>
							<input type='text' id='ccunum' name="ccunum" value="<?php echo $credit_info->ccu_number ?>" class='normal-format-text' />
						</div>

						<div class='clearfix'>
							<label for='ccuccv'>CCV*</label>
							<div class='clear'></div>
							<input type='text' class='small45 normal-format-text' id='ccuccv' name="ccuccv" maxlength='4' value="<?php echo $credit_info->ccu_ccv ?>" />
						</div>

						<div class='clearfix'>
							<label for='exp_month'>Expiration Date*</label>
							<div class='clear'></div>
							<select id='exp_month' class='medium normal-format-select' name="exp_month">
								<?php echo $this->creditcards->generate_months('option',$credit_info->ccu_exp_month); ?>
							</select>
							<select id='exp_year' class='small normal-format-select' name="exp_year">
								<?php
								$year_set = date('Y', strtotime('+7 year'));
								echo $this->creditcards->generate_years($year_set,date('Y'),$credit_info->ccu_exp_year);
								?>
							</select>
							<input type="hidden" value="<?php echo $credit_info->ccu_id ?>" name="ccuid" id="ccuid" />
						</div>

						<div class='clear'></div>
						<button id='update-creditcard-button' class='greenbutton floatR'>UPDATE CREDIT CARD</button>
						<div class='clear'></div>
						<div class='validate-result'>
						</div>
					</div>
				</div>
			</div>

	<script type="text/javascript">

		$('#state-textbox').hide();

		$('#update-creditcard-button').click(function(){
				var cctype = $('#cctype').val();
				var ccuname = $('#ccuname').val();
				var ccunum = $('#ccunum').val();
				var ccuccv = $('#ccuccv').val();
				var exp_month = $('#exp_month').val();
				var exp_year = $('#exp_year').val();
				var ccuid = $('#ccuid').val();

				$.post("<?php echo base_url()?>supplier/updatecard",{cctype:cctype,ccuname:ccuname,ccunum:ccunum,ccuccv:ccuccv,exp_month:exp_month,exp_year:exp_year,ccuid:ccuid,
				action:'update','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){

					var  convert = JSON.parse(result);

					$('.validate-result').hide();
					$('.validate-result').html(convert.message);
					$('.validate-result').show();

					if(convert.status == 1)
					{
						$(window.location).attr('href', "<?php echo base_url() ?>supplier/creditcard");
					}

				});
		});
	</script>
<?php echo $this->load->view('supplier/footer') ?>