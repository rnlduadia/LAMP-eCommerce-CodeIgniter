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
						<p class='breadcrumbs fl'>Change Email Address</p>
					</div>

					<div class='padded-cont'>
						<div class='profile-cont'>
							<div style="font-weight: bold;">
								<strong> Current Email Address</strong>
							</div>
							<div style="padding-top: 10px;">
								<? echo $info->u_email; ?>
							</div>
						</div>
						<div class='informative-format' style="padding-top:15px;">
							<div style="font-weight: bold;">
								<strong> New Email Address</strong>
							</div>
							<div style="padding-top: 8px;">
								<input type="text" name="txt_email_address" id="txt_email_address" size="25" />
							</div>
						</div>
						<div>
							<button class='normal-button' id='new-email'>SUBMIT</button>
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

	$('#new-email').click(function(){
		var email = $('#txt_email_address').val();
		if($.trim(email)=="") { alert("Email address can not be blank"); return false;}
		$.post('<?php echo base_url()?>user/change_email_add',{email:email,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
			var convert = JSON.parse(result);
			alert(convert.message);
		});
	});

</script>
<?php echo $this->load->view('admin/footer') ?>