<!-- Lanz Editted - June 10, 2013 -->
<?php echo $this->load->view('admin/header') ?>
<div class="global-cont">

	<div class='bg-body'>
		<div class="bg-body-top"> </div>
		<div class="bg-body-middle clearfix">
		<!-- MIDDLE PAGE CONTAINER-->

			<!-- LEFT SIDEBAR CONTAINER-->
			<div id="left-sidebar" class="clearfix fl">
				<?php echo $this->load->view('admin/admin/admin-sidebar') ?>
			</div>

			<!-- RIGHT CONTENT CONTAINER-->
			<div class='right-cont clearfix fr'>

				<?php $has_permission = $this->administrators->check_permission($this->session->userdata('id'),1);?>

				<?php if($has_permission){ ?>
				<div class='right-inner clearfix'>

					<div class="heading-inner-right">
						<p class='breadcrumbs fl'>Authorized.net Setting</p>
					</div>
					<div class='padded-cont'>

						<div class='clearfix'>
							<label>FIX IMAGES LINK</label>
							<div class='clear'></div>
							<button class='normal-button fr' id='fix-image'>FIX</button>
						</div>

						<div id='result-update'>

						</div>

					</div>
				</div>

				<?php }else{?>
					<?php echo $this->load->view('admin/permission-error') ?>
				<?php }?>

			</div>

		<!-- MIDDLE PAGE CONTAINER-->
		</div>
		<div class="bg-body-bottom"> </div>
	</div>
</div>

<script type="text/javascript">
	$('#fix-image').click(function(){

		$.post('<?php echo base_url()?>administrator/fix_image',{'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
			$('#result-update').html(result);
		});
	});

</script>

<?php echo $this->load->view('admin/footer') ?>