<?php echo $this->load->view('buyer/header') ?>
			<!-- LEFT SIDEBAR CONTAINER-->
			<div class="nav-bar floatL">
				<?php echo $this->load->view('buyer/sidebar');?>
			</div>

			<!-- RIGHT CONTENT CONTAINER-->
			<div class='sliderLg floatR'>


				<div class='right-inner right-inner-half clearfix fl' style='min-height:215px'>
					<!-- First Row Container-->
					<div class="topBrands searching-for">
						<div class="topBrandsHeader">
							<div class'floatl'="">Upload Image</div>
						</div>
					</div>

					<div class='padded-cont'>
						<?php echo form_open_multipart('user/upload_profile');?>
						<div class='profile-cont fl' style='width:55%'>
							<div class="user-icon-small">
								<?php if($buyer_profile->u_pic != ""){?>
								<img src="<?php echo base_url().$buyer_profile->u_pic?>" width=100%>
								<?php }else{ ?>
								<img src="<?php echo base_url()?>images/avatar.png" width=100%>
								<?php }?>
							</div>	
							<input type="file" name="userfile" size="20" />
						</div>
						<div class='fr' style='width:36%'>
							<input type='hidden' value="upload" name='request' class='fr'/>
							<input type='submit' value="UPLOAD" class='greenbutton floatR'/>	
							<div class='clear'></div>
							
						</div>
						<?php echo form_close()?>

						<div class='clear'></div>
						<p><b>Note:</b> logo Images must be 120 pixel wide by 30 pixel tall, and they must have no animation. Imagee file should be in .jpg or .gif format</p>
						<div class='mrg-top red'>
							<?php echo $error?>
						</div>
					</div>

				</div>

			</div>


<?php echo $this->load->view('buyer/footer') ?>