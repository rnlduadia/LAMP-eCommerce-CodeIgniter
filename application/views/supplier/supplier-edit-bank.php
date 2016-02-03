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
							<div class'floatl'="">Bank Information:</div>
						</div>
					</div>

					<div class='padded-cont'>
						<div class='validate-result'>
						</div>
						<div class='clearfix' style="padding-top:5px;">
							<label for='bnk_country'>Bank Location*</label>
							<div class='clear' style="padding-top:5px;"></div>

							<select id='bnk_country'>
								<?php
								foreach($countries as $country) { ?>
									<option  value="<?php echo $country->c_id?>" <?php  if( $country->c_id== $bank_detail->c_id) { echo "selected='selected'"; } ?>><?php echo $country->c_name;?></option>
								<?php } ?>
							</select>
						</div>
						<div class='clearfix' style="padding-top:5px;">
							<label for='cctype'>Bank Owner*</label>
							<div class='clear' style="padding-top:5px;"></div>
							<input type='text' id='bnk_owner' name="bnk_owner" class='normal-format-text' value="<?php echo $bank_detail->bnk_owner; ?>" />
						</div>

						<div class='clearfix' style="padding-top:5px;">
							<label for='cctype'>Bank Name*</label>
							<div class='clear' style="padding-top:5px;"></div>
							<input type='text' id='bnk_name' name="bnk_name" class='normal-format-text' value="<?php echo $bank_detail->bnk_name; ?>"  />
						</div>

						<div class='clearfix' style="padding-top:5px;">
							<label for='cctype'>Bank Address*</label>
							<div class='clear' style="padding-top:5px;"></div>
							<textarea name="bnk_address" id="bnk_address" cols="60" rows="6"><?php echo $bank_detail->bnk_address; ?></textarea>
						</div>

						<div class='clearfix' style="padding-top:5px;">
							<label for='cctype'>Account Number (Only Checking Account)*</label>
							<div class='clear' style="padding-top:5px;"></div>
							<input type='text' id='bnk_account' name="bnk_account" class='normal-format-text' value="<?php echo $bank_detail->bnk_account; ?>" />
						</div>

						<div class='clearfix' style="padding-top:5px;">
							<label for='cctype'>Routing #*</label>
							<div class='clear' style="padding-top:5px;"></div>
							<input type='text' id='bnk_id_code' name="bnk_id_code" class='normal-format-text' value="<?php echo $bank_detail->bnk_id_code; ?>" />
							<input type="hidden" name="bnk_id" value="<?php echo $bank_detail->bnk_id; ?>" id="bnk_id"/>
 						</div>

						<div class='clear' style="padding-top:20px;"></div>
						<button id='edit-bank-button' class='greenbutton floatL'>UPDATE BANK ACCOUNT</button>
						<div class='clear'></div>

					</div>
				</div>
			</div>

	<script type="text/javascript">
		var is_state = true;

		$('#edit-bank-button').click(function(){

				var bank_id = $('#bnk_id').val();
				var bank_country = $('#bnk_country').val();
				var bank_owner = $('#bnk_owner').val();
				var bank_name = $('#bnk_name').val();
				var bank_address = $('#bnk_address').val();
				var bank_account = $('#bnk_account').val();
				var bank_id_code = $('#bnk_id_code').val();


				$.post("<?php echo base_url()?>supplier/updatebank",{bnk_id:bank_id,bnk_owner:bank_owner,bnk_name:bank_name,bnk_address:bank_address,bnk_account:bank_account,bnk_id_code:bank_id_code,bnk_country:bank_country,action:'update','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
					var  convert = JSON.parse(result);

					if(convert.status == 1)
					{
						$('.validate-result').hide();
						$('.validate-result').html(convert.message);
						$('.validate-result').show();
						$(window.location).attr('href', "<?php echo base_url() ?>supplier/bankaccount");
					}
					// Lanz Editted - June 6, 2013
					else if (convert.status == 0)
					{
						$('.validate-result').hide();
						$('.validate-result').html(convert.message);
						$('.validate-result').show();
					}

				});
		});
	</script>

<?php echo $this->load->view('supplier/footer') ?>