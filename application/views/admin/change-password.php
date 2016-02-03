<?php echo $this->load->view('admin/header') ?>
<div class="global-cont">

	<div class='bg-body'>
		<div class="bg-body-top"> </div>
		<div class="bg-body-middle clearfix">
		<!-- MIDDLE PAGE CONTAINER-->

			<!-- LEFT SIDEBAR CONTAINER-->
			<div id="left-sidebar" class="clearfix fl">
				<?php echo $this->load->view('admin/sidebar') ?>
			</div>

			<!-- RIGHT CONTENT CONTAINER-->
			<div class='right-cont clearfix fr'>

				<div class='right-inner clearfix'>
					<!-- First Row Container-->
					<div class="heading-inner-right">
						<p class='breadcrumbs fl'>Change Password</p>
					</div>

					<div class='padded-cont'>
						<div class='informative-format' style="padding-top:5px;">
							<div style="padding-top: 8px;">
								Old Password <br/> <input type="password" name="txt_old_password" id="txt_old_password" size="15" />
							</div>
							<div style="padding-top: 8px;">
								New Password <br/> <input type="password" name="txt_new_password" id="txt_new_password" size="15" />
							</div>
							<div style="padding-top: 8px;">
								Confirm Password <br/> <input type="password" name="txt_confirm_password" id="txt_confirm_password" size="15" />
							</div>
						</div>
						<div>
							<button class='normal-button' id='new-pass'>SUBMIT</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- MIDDLE PAGE CONTAINER-->
		</div>
		<div class="bg-body-bottom"> </div>
	</div>

</div>
<script type="text/javascript">

	$('#new-pass').click(function(){
		var oldpwd = $('#txt_old_password').val();
		var newpwd = $('#txt_new_password').val();
		var confirmpwd = $('#txt_confirm_password').val();

		if($.trim(oldpwd)=="") {
			alert("Old password can not be blank");
			return false;
		}
		if($.trim(newpwd)=="") {
			alert("New password can not be blank");
			return false;
		}
		if($.trim(confirmpwd)=="") {
			alert("Confirm password can not be blank");
			return false;
		}
		$.post('<?php echo base_url()?>user/change_password',{oldpwd:oldpwd,newpwd:newpwd,confirmpwd:confirmpwd,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
			var convert = JSON.parse(result);
			alert(convert.message);
		});
	});

</script>
<?php echo $this->load->view('admin/footer') ?>