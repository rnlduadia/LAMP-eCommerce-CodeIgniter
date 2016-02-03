<!-- Lanz Editted -->
<?php echo $this->load->view('buyer/header') ?>


	<div class="nav">
		<div class="nav-bar floatL">
		<?php echo $this->load->view('sidebar');?>

		</div>

		<div class="sliderLg floatR">
			<div id="slider" class="flexslider bigslider">
				  <ul class="slides">
				    <li><img src="<?php echo base_url()?>avatars/01.png"></li>
				    <li><img src="<?php echo base_url()?>avatars/01.png"></li>
				    <li><img src="<?php echo base_url()?>avatars/01.png"></li>				   
				  </ul>
			</div>			
		</div>
	</div>

	<div class="topBrands">
		<div class="topBrandsHeader">
			<span class="floatL">Top Brands</span>
			<span class="floatR">See All</span>
		</div>
		
		<div class="topBrandsContent flexslider carousel_1">
			<ul class="topBrandsSlider slides"  id="slider_1" >
				<?php if(count($top_brands) > 0): ?>
					<?php foreach($top_brands  as $tb):?>
						<li class="floatL"><a href="<?php echo base_url()."inventory/search/brand/".urlencode($tb->b_name); ?>" class="js-brand"> <img width="190" height="99" src="images/brands/<?php echo $tb->logo;?>" /></a> </li>
					<?php endforeach;?>
				<?php else:?>
				<li class="floatL"><a class='js-brand' href='<?php echo base_url()?>inventory/search/brand/Canon'><img src="<?php echo base_url()?>avatars/top1.png" /></a> </li>
				<li class="floatL"><a class='js-brand' href='<?php echo base_url()?>inventory/search/brand/Microsoft'><img src="<?php echo base_url()?>avatars/top2.png" /></a> </li>
				<li class="floatL"><a class='js-brand' href='<?php echo base_url()?>inventory/search/brand/Unilever'><img src="<?php echo base_url()?>avatars/top3.png" /></a> </li>
				<li class="floatL"><a class='js-brand' href='<?php echo base_url()?>inventory/search/brand/Sunsilk'><img src="<?php echo base_url()?>avatars/top4.png" /></a> </li>
				<li class="floatL"><a class='js-brand' href='<?php echo base_url()?>inventory/search/brand/Dove'><img src="<?php echo base_url()?>avatars/top5.png" /></a> </li>	
				<li class="floatL"><a class='js-brand' href='<?php echo base_url()?>inventory/search/brand/Canon'><img src="<?php echo base_url()?>avatars/top1.png" /></a> </li>
				<li class="floatL"><a class='js-brand' href='<?php echo base_url()?>inventory/search/brand/Microsoft'><img src="<?php echo base_url()?>avatars/top2.png" /></a> </li>
				<?php endif;?>
			</ul>
			
		</div>
	</div>
<?php if(empty($rotators)):?>
	<div class="topBrands">
		<div class="topBrandsHeader">
			<span class="floatL">Home Goods</span>
			<span class="floatR">See All</span>
		</div>
		<div class="topBrandsContent flexslider carousel_2">
			<ul class="topBrandsSlider slides" id="slider_2" >
				<li class="floatL"><img src="<?php echo base_url()?>avatars/home1.png" /> </li>
				<li class="floatL"><img src="<?php echo base_url()?>avatars/home2.png" /> </li>
				<li class="floatL"><img src="<?php echo base_url()?>avatars/home3.png" /> </li>
				<li class="floatL"><img src="<?php echo base_url()?>avatars/home4.png" /> </li>
				<li class="floatL"><img src="<?php echo base_url()?>avatars/home5.png" /> </li>
				<li class="floatL"><img src="<?php echo base_url()?>avatars/home1.png" /> </li>
				<li class="floatL"><img src="<?php echo base_url()?>avatars/home2.png" /> </li>			
			</ul>
			
		</div>
	</div>

	<div class="clear"></div>
	
	<div class="topBrands">
		<div class="topBrandsHeader">
			<span class="floatL">Sport Goods</span>
			<span class="floatR">See All</span>
		</div>
		<div class="topBrandsContent flexslider carousel_3">
			<ul class="topBrandsSlider slides"  id="slider_3" >
				<li class="floatL"><img src="<?php echo base_url()?>avatars/sport1.png" /> </li>
				<li class="floatL"><img src="<?php echo base_url()?>avatars/sport2.png" /> </li>
				<li class="floatL"><img src="<?php echo base_url()?>avatars/sport3.png" /> </li>
				<li class="floatL"><img src="<?php echo base_url()?>avatars/sport4.png" /> </li>
				<li class="floatL"><img src="<?php echo base_url()?>avatars/sport5.png" /> </li>
				<li class="floatL"><img src="<?php echo base_url()?>avatars/sport1.png" /> </li>
				<li class="floatL"><img src="<?php echo base_url()?>avatars/sport2.png" /> </li>
			</ul>
			
		</div>
	</div>
<?php else:?>
	<?php  foreach($rotators as $rotator):?>
		<div class="topBrands">
			<div class="topBrandsHeader">
				<span class="floatL"><?php echo $rotator['title']?></span>
				<span class="floatR">See All</span>
			</div>
			<div class="topBrandsContent flexslider carousel_4">
				<ul class="topBrandsSlider slides" id="slider_4" >
					<?php foreach($rotator['items'] as $rotatorItem):?>
						<?php
//										$image_list = $this->inventories->list_image($inv->i_id,1,true);
						$image_list = $this->inventories->list_image($rotatorItem->i_id);
						$img = reset($image_list);
						//limit 1, select only the featured image
						if (count($image_list) == 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . str_replace((strpos(base_url(),'https://')>-1 ? 'https://' : 'http://' ). $_SERVER['HTTP_HOST'] . '/', '', base_url() . $img->ii_link))) {?>
							<li style="cursor: pointer;" class="floatL" onclick="javascript: document.location='<?php echo base_url()?>inventory/detail/<?php echo
                            $rotatorItem->i_id?>'">
                                <img src="<?php echo base_url()?>images/default-preview.jpg" height="160" />
                            </li>
						<?php }else{?>
							<li style="cursor: pointer;" class="floatL" onclick="javascript: document.location=''">
                                <img src="<?php echo base_url().$img->ii_link ?>" height="160">
                            </li>
						<?php }?>

					<?php endforeach;?>
				</ul>
			</div>
		</div>
		<div class="clear"></div>
	<?php endforeach;?>
<?php endif;?>

<?php echo $this->load->view('buyer/footer') ?>