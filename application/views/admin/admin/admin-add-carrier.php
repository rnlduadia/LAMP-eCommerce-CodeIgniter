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
			<?php $has_permission = $this->administrators->check_permission($this->session->userdata('id'),11);?>
			<!-- RIGHT CONTENT CONTAINER-->
			<div class='right-cont clearfix fr'>
				<?php if($has_permission){?>
				<h4 class="fl">Add Carrier</h4>
				<div class="clear"> </div>
				<div class='violet-table'>
					<table width="100%">
						<tr>
							<td colspan="3">Carrier Information</td>
						</tr>
						<tr>
							<td width="15%">Carrier Name</td>
							<td width="2%">:</td>
							<td><input type="text" id="carrier_name" name="carrier_name"></td>
						</tr>
						<tr>
							<td>Description</td>
							<td>:</td>
							<td><textarea rows="5" cols="30" id="carrier_desc" name="carrier_desc"></textarea></td>
						</tr>
						<tr>
							<td colspan="3"><button id="add-carrier-desc" class="">Add Carrier</button></td>
						</tr>
					</table>
					<div class='validate-result'>
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
	$("#add-carrier-desc").click(
		function()
		{
			var carrier_name = $("#carrier_name").val();
			var carrier_desc = $("#carrier_desc").val();

			$.post("<?php echo base_url() ?>carrier/addcarrier",
				{carrier_name:carrier_name, carrier_desc:carrier_desc, action:"add",'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},
				function(result)
				{
					var convert = JSON.parse(result);

					if (convert.status == 1)
					{
						$('.validate-result').hide();
						$('.validate-result').html(convert.message);
						$('.validate-result').show();
						$(window.location).attr('href', "<?php echo base_url() ?>carrier");
					}
					else
					{
						$('.validate-result').hide();
						$('.validate-result').html(convert.message);
						$('.validate-result').show();
					}
				});
		});
</script>

<?php echo $this->load->view('admin/footer') ?>