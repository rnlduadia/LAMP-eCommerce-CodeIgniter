<!-- Lanz Editted -->
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
							<div class'floatl'="">Update Password</div>
						</div>
					</div>

					<div class='padded-cont'>
						<div class='validate-result' style="padding-bottom:10px;font-weight: bold;">

						</div>
						<div class='informative-format fl'>
							<div>
								<table>
									<tr>
										<td><p><span>Current Password</span></p></td>
										<td>&nbsp;&nbsp;:</td>
										<td><input type="password" name="curr_pass" id="curr_pass" class='normal-format-text'></td>
									</tr>
									<tr><td colspan="3">&nbsp;</td></tr>
									<tr>
										<td><p><span>New Password</span></p></td>
										<td>&nbsp;&nbsp;:</td>
										<td><input type="password" name="new_pass" id="new_pass" class='normal-format-text'></td>
									</tr>
									<tr><td colspan="3">&nbsp;</td></tr>
									<tr>
										<td><p><span>Confirm New Password</span></p></td>
										<td>&nbsp;&nbsp;:</td>
										<td><input type="password" name="new_pass1" id="new_pass1" class='normal-format-text'></td>
									</tr>
									<tr><td colspan="3">&nbsp;</td></tr>
									<tr>
										<td colspan="3"><input type="button" name="update-supplier-password" id='update-supplier-password' value='UPDATE' class='greenbutton' /></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

	<script language="javascript">
	$("#update-supplier-password").click(
		function()
		{
			var curr_pass = $("#curr_pass").val();
			var new_pass = $("#new_pass").val();
			var new_pass1 = $("#new_pass1").val();

			$.post("<?php echo base_url() ?>supplier/passwordupdate",
					{curr_pass:curr_pass, new_pass:new_pass, new_pass1:new_pass1, action:"update",'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},
					function(result)
					{
						var convert = JSON.parse(result);
						if (convert.status == 1)
						{
							//alert("Must provide new password");
							$('.validate-result').hide();
							$('.validate-result').html(convert.message);
							$('.validate-result').show();
						}
						else if(convert.status == 2)
						{
							//alert("Password Update Successfully");
							$('.validate-result').hide();
							$('.validate-result').html(convert.message);
							$('.validate-result').show();
						}
						else if(convert.status == 0)
						{
							//alert("Password does not match");
							$('.validate-result').hide();
							$('.validate-result').html(convert.message);
							$('.validate-result').show();
						}
					}
				);
		});
	</script>
<?php echo $this->load->view('supplier/footer') ?>