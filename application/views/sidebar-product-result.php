<?php if(count($inventories ) == 0){?>
	<center><p>NO PRODUCT RESULT</p></center>
<?php }else{ $num=1; foreach($inventories as $inv){
				if($num%3 == 1 && $num != 0) echo "<div style='width:1px;' class='clear'></div>";
				$num++;
?>
	<div class='prod-list-cont fl'>
		<div class='img-feat-prod-list-cont'>
			<a href="<?php echo base_url()?>inventory/detail/<?php echo $inv->i_id?>">
				<?php
//				$image_list = $this->inventories->list_image($inv->i_id,1,true);
				$image_list = $this->inventories->list_image($inv->i_id);
				//limit 1, select only the featured image

				$img = null;
				foreach($image_list as $image) {
					if(file_exists(base_dir() . $image->ii_link)) {
						$img = $image;
						break;
					}
				}
//echo 'test'.$_SERVER['DOCUMENT_ROOT'].'/'.str_replace('http://'.$_SERVER['HTTP_HOST'].'/', '', base_url().$img->ii_link).'<div class=\'clear\'></div>';
				if($img == null){?>
					<img width=100% src="<?php echo base_url()?>images/default-preview.jpg">

				<?php }else{?>
					<img width=100%  src="<?php echo base_url().$img->ii_link ?>">
				<?php }?>
			</a>
		</div>

		<div class='quick-detail-prod-list'>

			<h5><a href="<?php echo base_url()?>inventory/detail/<?php echo $inv->i_id?>"><?php echo htmlentities($inv->tr_title,ENT_SUBSTITUTE,"cp1252",false)?></a></h5>
			<p>
				<?php if($this->session->userdata('is_login') == TRUE) { ?>
					<span>Price:</span> <? echo $inv->ic_price; ?> /
				<?php } ?>
				<?php if($inv->ic_retail_price != 0) { ?>
				<span>RRP:</span> <? echo $inv->ic_retail_price; ?>
				<?php } ?>
			</p>
				<?php if($inv->ic_retail_price != 0) { ?>
			<div class="hr-orange"> </div>
			<p>Estimated profit: <? echo floor((($inv->ic_retail_price - $inv->ic_price)/$inv->ic_price)*100) ?>%</p>
				<?php } ?>

		</div>
	</div>

<?php }}?>