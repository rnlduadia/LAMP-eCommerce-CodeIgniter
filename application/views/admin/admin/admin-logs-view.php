<!-- Lanz Editted -->
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

				<?php $has_permission = $this->administrators->check_permission($this->session->userdata('id'),4);?>

				<?php $has_permupdate_status = $this->administrators->check_permission($this->session->userdata('id'),5);?>

				<?php if($has_permission){?>
				<div class='right-inner clearfix'>
					<div class="heading-inner-right">
						<p class='breadcrumbs fl'>Current Logs:</p>
					</div>

					<div class='padded-cont'>
						<div class='violet-table'>
							<table>
								<tr align="center">
									<td>User Name</td>
									<td>Event</td>
									<td>Module</td>
									<td>Timestamp</td>
									<td>Additional</td>
								</tr>
								<?php foreach ($logs as $log) {?>

								<tr align="center">
									<td><a href="<?php echo base_url() ?>administrator/logs/filterbyuser/<? echo $log->u_id;?>"><?php echo $log->u_username; ?></td>
									<td><?php echo $log->event; ?></td>
									<td><?php echo $log->module; ?></td>
									<td><?php echo $log->logtime;?></td>
									<td><?php echo $log->additional;?></td>
									</tr>
								</tr>
								<?php } ?>
							</table>

						</div>
					</div>
<?php if($pagination['num_pages'] > 1){
	$step = 5;
	$curent_page = $pagination['curent_page'];

	$first_page = $curent_page - $step;
	if($first_page < 1) $first_page = 1;

	$last_page = $curent_page + $step;
	if($last_page > $pagination['num_pages']) $last_page = $pagination['num_pages'];

	echo "<div class='pagination'>page : ";
	for($i = $first_page; $i <= $last_page; $i++){
		echo ($i==$curent_page ? $i : "<a href='?page=".$i."'>".$i."</a>")."&nbsp;&nbsp;";
	}
	echo "</div>";

} ?>

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

<?php echo $this->load->view('admin/footer') ?>