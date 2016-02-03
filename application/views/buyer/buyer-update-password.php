<!-- Lanz Editted -->
<?php echo $this->load->view('buyer/header') ?>
			<!-- LEFT SIDEBAR CONTAINER-->
			<div class="nav-bar floatL">
				<?php echo $this->load->view('buyer/sidebar');?>
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
						<div class='informative-format fl'>
							<div>
								<table>
									<tr>
										<td><p><span>Current Password</span></p></td>
										<td>&nbsp;&nbsp;:</td>
										<td><input type="password" name="curr_pass" id="curr_pass" class='normal-format-text'></td>
									</tr>
									<tr>
										<td><p><span>New Password</span></p></td>
										<td>&nbsp;&nbsp;:</td>
										<td><input type="password" name="new_pass" id="new_pass" class='normal-format-text'></td>
									</tr>
									<tr>
										<td><p><span>Confirm New Password</span></p></td>
										<td>&nbsp;&nbsp;:</td>
										<td><input type="password" name="new_pass1" id="new_pass1" class='normal-format-text'></td>
									</tr>
									<tr>
										<td><br/><input type="button" name="update-buyer-password" id='update-buyer-password' value='UPDATE PASSWORD' class='greenbutton' /></td>
									</tr>
								</table>
								<!-- <p><span>Current Password:</span></p><input type="password" name="curr_pass" id="curr_pass"> -->
							</div>
							<!-- <div>
								<p><span>New Password:</span></p><input type="password" name="new_pass" id="new_pass">
							</div>
							<div>
								<p><span>Confirm New Password:</span></p><input type="password" name="new_pass1" id="new_pass1">
							</div> -->
						</div>
						<div class='clear'></div>
						<div class='validate-result clearfix'>
						</div>
					</div>

				</div>

			</div>

	<script language="javascript">
	$("#update-buyer-password").click(
		function()
		{
			var curr_pass = $("#curr_pass").val();
			var new_pass = $("#new_pass").val();
			var new_pass1 = $("#new_pass1").val();

			$.post("<?php echo base_url() ?>buyer/update/password",
					{curr_pass:curr_pass, new_pass:new_pass, new_pass1:new_pass1, action:"update",'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},
					function(result)
					{

						var convert = JSON.parse(result);
						if (convert.status == 1)
						{
							$('.validate-result').hide();
							$('.validate-result').html(convert.message);
							$('.validate-result').show();
						}
						else if (convert.status == 2)
						{
							$('.validate-result').hide();
							$('.validate-result').html(convert.message);
							$('.validate-result').show();
						}
						else if (convert.status == 0)
						{
							$('.validate-result').hide();
							$('.validate-result').html(convert.message);
							$('.validate-result').show();
						}
						alert(convert.message);
					}
				);
		});
	</script>
<?php echo $this->load->view('buyer/footer') ?>