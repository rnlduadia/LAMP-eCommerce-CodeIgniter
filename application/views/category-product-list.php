<?php
if($this->session->userdata('is_login') == TRUE)
{
	$user_type = $this->session->userdata('type'); //get user type;
	if($user_type == 2) //2 is Supplier
	{
		echo $this->load->view('supplier/header');
	}
	elseif($user_type == 3) //3 is Buyer
	{
		echo $this->load->view('buyer/header');
	}
}
else
		echo $this->load->view('header');
?>

				<div class="nav-bar floatL">
						<?php
						if($this->session->userdata('is_login') == TRUE)
						{
							$user_type = $this->session->userdata('type'); //get user type;
							if($user_type == 2) //2 is Supplier
							{
								echo $this->load->view('supplier/sidebar');
							}
							elseif($user_type == 3) //3 is Buyer
							{
								echo $this->load->view('sidebar');
//								echo $this->load->view('buyer/sidebar');
							}
						}
						else
								echo $this->load->view('sidebar');						?>	

				</div>
			
				<div class="sliderLg floatR">

						<!-- <div class="heading-inner-right"> 
							<p class='breadcrumbs fl'> <a href="<?php //echo base_url()?>">Home</a>><?php echo $breadcrumbs;?> </p>
						</div>
 -->
						<div class="productNavigation mynav">
							<p> <a href="<?php echo base_url()?>">Home</a><span class='rarrow'><img src='<?=base_url()?>images/rarrow.png'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php echo $breadcrumbs;?></p>
						</div>

						<?php if(count($inventories ) == 0){?> 
							<center><p>NO PRODUCT RESULT</p></center>
						<?php }else{ 
							$counter = 0;
							foreach($inventories as $inv){
								$counter++;
								?>

							<div class='prod-list-cont fl'>
								<div class='img-feat-prod-list-cont'>
									<a href="<?php echo base_url()?>inventory/detail/<?php echo $inv->i_id?>">
										<?php 
//										$image_list = $this->inventories->list_image($inv->i_id,1,true); 
										$image_list = $this->inventories->list_image($inv->i_id); 
										$img = reset($image_list);
										//limit 1, select only the featured image
									
                                                                                if (count($image_list) == 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . str_replace((strpos(base_url(),'https://')>-1 ? 'https://' : 'http://' ). $_SERVER['HTTP_HOST'] . '/', '', base_url() . $img->ii_link))) {?>
											<img width=100% src="<?php echo base_url()?>images/default-preview.jpg">
										
										<?php }else{?>
											<img width=100%  src="<?php echo base_url().$img->ii_link ?>">
										<?php }?>
									</a>
								</div>

								<div class='quick-detail-prod-list'>
									<h5><a href="<?php echo base_url()?>inventory/detail/<?php echo $inv->i_id?>"><?php echo $inv->tr_title?></a></h5>
									<p>Available Stock: <?php echo $this->inventories->total_quantity($inv->i_id)?></p>
									<?php if($this->session->userdata('is_login') == TRUE) { ?>
									<p>Price: $<?php echo number_format($this->inventories->range_price($inv->i_id), 2, '.', ' ' ); ?></p>
									<?php } ?>
								</div>
							</div>

						<?php 
							if($counter==3){
								$counter=0;
								echo '<div style="clear:both"></div>';
							}
							}} ?>

				</div>
				<?php echo $pagination; ?>
				<!-- 	<div class='right-inner clearfix'> 
						<div class="heading-yellow-full"> 
							<p class='fl'>Most Popular & Feautured Products</p>
						</div>

						<center><p style='padding-top:20px;padding-bottom:20px;'>No Featured Product Listed</p></center>

					</div>	 -->

<?php if($user_type == 2): ?>
<script tyle="text/javascript">
    $(function() {
        $('.productNavigation a').click(function() {
            if($(this).html() == 'Home') {
                return true;
            } else {
                return false;
            }
        })
    });
</script>
<?php endif ?>
<?php if($this->session->userdata('is_login') == TRUE)
{
	$user_type = $this->session->userdata('type'); //get user type;
	if($user_type == 2) //1 is suplier
	{
		echo $this->load->view('supplier/footer');
	}
	elseif($user_type == 3) //3 is Buyer
	{
		echo $this->load->view('buyer/footer');
	}
}
else
		echo $this->load->view('footer');
?>
