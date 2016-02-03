<?php echo $this->load->view('header')?>
	<div class="nav">
		<div class="nav-bar floatL">
		<?php echo $this->load->view('sidebar')?>
		</div>

		<div class="sliderLg floatR">
			<div id="slider" class="flexslider">
				  <ul class="slides">
				    <li><img src="avatars/banner1.png"></li>
				    <li><img src="avatars/banner2.png"></li>
				    <li><img src="avatars/banner3.png"></li>	
                                    <li><img src="avatars/banner4.png"></li>	
				  </ul>
			</div>			
		</div>
	</div>

	<div class="topBrands">
		<div class="topBrandsHeader">
			<span class="floatL">Top Brands</span>
			<span class="floatR">See All</span>
		</div>
		
		<div class="topBrandsContent flexslider carousel">	
			<ul class="topBrandsSlider slides">
				<?php if(count($top_brands) > 0): ?>
					<?php foreach($top_brands  as $tb):?>
						<li class="floatL"><a href="<?php echo base_url()."inventory/search/brand/".urlencode($tb->b_name); ?>" class="js-brand"> <img width="190" height="99" src="images/brands/<?php echo $tb->logo;?>" /></a> </li>
					<?php endforeach;?>
				<?php else:?>
                <li class="floatL"><a href="<?php echo base_url()."inventory/search/brand/Canon" ?>" > <img src="avatars/top1.png" /></a> </li>
				<li class="floatL"><a href="<?php echo base_url()."inventory/search/brand/Microsoft" ?>" class="js-brand"><img src="avatars/top2.png" /></a> </li>
				<li class="floatL"><a href="<?php echo base_url()."inventory/search/brand/Unilever" ?>" class="js-brand"><img src="avatars/top3.png" /></a> </li>
				<li class="floatL"><a href="<?php echo base_url()."inventory/search/brand/Sunsilk" ?>" class="js-brand"><img src="avatars/top4.png" /></a> </li>
				<li class="floatL"><a href="<?php echo base_url()."inventory/search/brand/Dove" ?>" class="js-brand"><img src="avatars/top5.png" /> </a></li>	
				<li class="floatL"><a href="<?php echo base_url()."inventory/search/brand/Canon" ?>" class="js-brand"><img src="avatars/top1.png" /></a> </li>
				<li class="floatL"><a href="<?php echo base_url()."inventory/search/brand/Microsoft" ?>" class="js-brand"><img src="avatars/top2.png" /> </a></li>
				<?php endif;?>
			</ul>
			
		</div>
	</div>
	<div class="clear"></div>

	<?php if(empty($rotators)):?>
	<div class="topBrands">
		<div class="topBrandsHeader">
			<span class="floatL">Home Goods</span>
			<span class="floatR">See All</span>
		</div>
		<div class="topBrandsContent flexslider carousel">	
			<ul class="topBrandsSlider slides">
				<li class="floatL"><img src="avatars/home1.png" /> </li>
				<li class="floatL"><img src="avatars/home2.png" /> </li>
				<li class="floatL"><img src="avatars/home3.png" /> </li>
				<li class="floatL"><img src="avatars/home4.png" /> </li>
				<li class="floatL"><img src="avatars/home5.png" /> </li>
				<li class="floatL"><img src="avatars/home1.png" /> </li>
				<li class="floatL"><img src="avatars/home2.png" /> </li>			
			</ul>
			
		</div>
	</div>

	<div class="clear"></div>
	
	<div class="topBrands">
		<div class="topBrandsHeader">
			<span class="floatL">Sport Goods</span>
			<span class="floatR">See All</span>
		</div>
		<div class="topBrandsContent flexslider carousel">	
			<ul class="topBrandsSlider slides">
				<li class="floatL"><img src="avatars/sport1.png" /> </li>
				<li class="floatL"><img src="avatars/sport2.png" /> </li>
				<li class="floatL"><img src="avatars/sport3.png" /> </li>
				<li class="floatL"><img src="avatars/sport4.png" /> </li>
				<li class="floatL"><img src="avatars/sport5.png" /> </li>
				<li class="floatL"><img src="avatars/sport1.png" /> </li>
				<li class="floatL"><img src="avatars/sport2.png" /> </li>
			</ul>
			
		</div>
	</div>
	<?php else:?>
		<?php foreach($rotators as $rotator):?>
			<div class="topBrands">
				<div class="topBrandsHeader">
					<span class="floatL"><?php echo $rotator['title']?></span>
					<span class="floatR">See All</span>
				</div>
				<div class="topBrandsContent flexslider carousel">
					<ul class="topBrandsSlider slides">
						<?php foreach($rotator['items'] as $rotatorItem):?>
							<?php
//										$image_list = $this->inventories->list_image($inv->i_id,1,true);
							$image_list = $this->inventories->list_image($rotatorItem->i_id);
							$img = reset($image_list);
							//limit 1, select only the featured image
//echo "test".base_url().$img->ii_link.$_SERVER['DOCUMENT_ROOT'].'/'.str_replace('http://'.$_SERVER['HTTP_HOST'].'/', '', base_url().$img->ii_link);
							if(count($image_list) == 0 || !file_exists($_SERVER['DOCUMENT_ROOT'].'/'.str_replace('http://'.$_SERVER['HTTP_HOST'].'/', '', base_url().$img->ii_link))){?>
								<li class="floatL"><a href="<?php echo base_url()?>inventory/detail/<?php echo $rotatorItem->i_id?>"><img src="<?php echo base_url()?>images/default-preview.jpg" height="160" /></a></li>
							<?php }else{?>
								<li class="floatL"><a href="<?php echo base_url()?>inventory/detail/<?php echo $rotatorItem->i_id?>"><img src="<?php echo base_url().$img->ii_link ?>" height="160"></a></li>
							<?php }?>

						<?php endforeach;?>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
		<?php endforeach;?>
	<?php endif;?>



<?php echo $this->load->view('footer')?>