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
							<p class='breadcrumbs fl'>Homepage Settings</p>
						</div>
						<div class='padded-cont'>
							<form action="" method="post" onsubmit="return false;" id="settings-form">
							<div class='clearfix'>
								<label>Product Rotator #1</label>
								<div class='clear'></div>
								<label for="products-1">Title:</label>
								<input class='normal-format-text' type='text' value="<?php echo isset($settings['rotator']['1']['title'])?$settings['rotator']['1']['title']:"";?>"  name="rotator[1][title]"/>
								<div class='clear'></div>
								<label for="category-1">Category:</label>
								<select id="category-1" name="rotator[1][category]" class="normal-format-text">
									<option value="">Please select category</option>
									<?php foreach($categories as $category):?>
										<option <?php if(isset($settings['rotator']['1']['category']) && $settings['rotator']['1']['category'] == $category->c_id):?> selected <?php endif;?> value="<?php echo $category->c_id;?>"><?php echo $category->c_name;?></option>
									<?php endforeach;?>
								</select>
								<div class='clear'></div>
								<label for="products-1">Number of Products:</label>
								<input class='normal-format-text' type='text' value="<?php echo isset($settings['rotator']['1']['number'])?$settings['rotator']['1']['number']:10;?>"  name="rotator[1][number]"/>
							</div>
								<div class='clear' style="margin-bottom: 20px;"></div>
								<div class='clearfix'>
									<label>Product Rotator #2</label>
									<div class='clear'></div>
									<label for="products-2">Title:</label>
									<input class='normal-format-text' type='text' value="<?php echo isset($settings['rotator']['2']['title'])?$settings['rotator']['2']['title']:"";?>"  name="rotator[2][title]"/>
									<div class='clear'></div>
									<label for="category-1">Category:</label>
									<select id="category-1" name="rotator[2][category]" class="normal-format-text">
										<option value="">Please select category</option>
										<?php foreach($categories as $category):?>
											<option <?php if(isset($settings['rotator']['2']['category']) && $settings['rotator']['2']['category'] == $category->c_id):?> selected <?php endif;?> value="<?php echo $category->c_id;?>"><?php echo $category->c_name;?></option>
										<?php endforeach;?>
									</select>
									<div class='clear'></div>
									<label for="products-1">Number of Products:</label>
									<input class='normal-format-text' type='text' value="<?php echo isset($settings['rotator']['2']['number'])?$settings['rotator']['2']['number']:10;?>"  name="rotator[2][number]"/>
						</div>
							<button class='normal-button fr' id='update-api-sup'>UPDATE</button>
							</form>
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

	$('#update-api-sup').click(function(){
		var data =  $('#settings-form').serialize();

		$.post('<?php echo base_url()?>administrator/setting_update/',{action:'homepage', data:data,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
			alert('Saved');
		});

	});

</script>

<?php echo $this->load->view('admin/footer') ?>