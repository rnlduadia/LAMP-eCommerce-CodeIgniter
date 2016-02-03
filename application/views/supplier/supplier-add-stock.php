<?php echo $this->load->view('supplier/header') ?>

			<!-- LEFT SIDEBAR CONTAINER-->
			<div class="nav-bar floatL">

				<?php echo $this->load->view('supplier/sidebar');?>

			</div>

			<!-- RIGHT CONTENT CONTAINER-->
			<div class='sliderLg floatR'>

				<div class='right-inner clearfix'>

					<!-- First Row Container-->
					<div class="topBrands searching-for">
						<div class="topBrandsHeader">
							<div class'floatl'="">Update Stock: <?php echo $this->categories->create_breadcrumb($inventory->cat_id,$inventory->c_level)?></div>
						</div>
					</div>

					<div class='padded-cont clearfix' id="add-stok-cont">

						<div class="clearfix">

							<div class='clearfix topBrands searching-for '>
								<div class="topBrandsHeader" style="margin-bottom: 20px;"><div>Product Summary</div></div>
								<div class='right-prod-det normal-style fl clearfix'>
									<div class='inner-img-prod-list'>
										<?php if(count($image_list) == 0){?>
											<img width=240 src="<?php echo base_url()?>images/default-preview.jpg">
										<?php }else{?>
											<div class="flexslider">
											  <ul class="slides">
											  	<?php foreach($image_list as $img){?>
											    <li>
											    	<a onclick='return false' href="<?php echo $img->ii_link?>">
											    		<img width=240 src="<?php echo $img->ii_link?>" id="slide0" />
											    	</a>
											    </li>
											    <?php }?>
											  </ul>
											</div>
										<?php }?>
									</div>
									<div class='clear'></div>
									<div class="navi-img-slide clearfix">
										<a class='left-navi' href="#"></a>
										<div class="fl number-slide clearfix">

										</div>
										<a class='right-navi' href="#"></a>
									</div>
								</div>
								<div class='width-400 normal-style fl'>
									<div><?php echo $inventory->tr_title?></div>
									<div>
										<p>Manufacturer: <span><?php echo $inventory->m_name?></span></p>
									</div>
									<div>
										<p>Brand: <span><?php echo $inventory->b_name?></span></p>
									</div>
									<div>
										<p>Weight: <span><?php echo $inventory->weight.' '.$inventory->weightScale?></span></p>
									</div>
								</div>
							</div>

							<div class="clear"> </div>

							<div class="fl clearfix">
								<label for='sku'>SKU*</label>
								<div class="clear"> </div>
								<input type="text" id='sku'/>
							</div>
							<div class="clear"> </div>
							
								<label for='quan'>Quantity*</label>
								<div class="clear"> </div>
								<input type="text" id='quan' value='1' />
							</div>
							
							<div class="fl clearfix">
								<label for='price'>Price*</label>
								<div class="clear"> </div>
								<input type="text" id='price' />
							</div>
							
							<div class="fl clearfix">
								<label for='ret_price'>Retail Price*</label>
								<div class="clear"> </div>
								<input type="text" id='ret_price' />
							</div>
							
							<div class="fl clearfix">
								<label for='map'>MAP(Minimum Advertized Price)</label>
								<div class="clear"> </div>
								<input type="text" id='map' value="" />
							</div>

							
							<div class="fl clearfix">
								<label for='ship_cost'>Shippng Cost</label>
								<div class="clear"> </div>
								<input type="text" id='ship_cost' value='' />
							</div>

							
							<div class="fl clearfix">
								<label for='ship_from'>Shippng From</label>
								<div class="clear"> </div>

								<select id='ship_from'>
								<?php
									$def_count = $this->countries->default_country();
									foreach($countries as $country){?>
									<option <?php if($def_count == $country->c_id){ echo 'selected="selected"'; }?> value='<?php echo $country->c_id?>'><?php echo  $country->c_name?></option>
								<?php }?>
								</select>
							</div>

							
							<div class="fl clearfix">
								<label for='lead_time'>Lead Time*</label>
								<div class="clear"> </div>
								<input type="text" id='lead_time' value='' />
							</div>

							<div class="clear"> </div>
							<div class="clearfix">
								<label for='prom_text'>Promotional Text</label>
								<div class="clear"> </div>
								<textarea id='prom_text' class='normal-format-text full-ta' ></textarea>
							</div>


							</div>
							<div class="clear"> </div>
							<button class='greenbutton' style="margin-top: 20px;" id='save-add-stock'>Save</button>
							<div class="clear"> </div>
							<div style='display:none' class='error-cont'>

							</div>

					</div>

				</div>

			</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#search-item').click(function(){
			var search_prod = $('#search-product').val();

			$.post('<?php echo base_url()?>inventory/search/supplier_search_add',
				{search_prod:search_prod,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
					$('#search-result-product').html(result);
			});

		});

		$('#save-add-stock').click(function(){
			var sku =  $('#sku').val();
			var quan =  $('#quan').val();
			var price =  $('#price').val();
			var ret_price =  $('#ret_price').val();
			var inv_id =  '<?php echo $inventory->i_id ?>';
			var lead_time =  $('#lead_time').val();

			var ship_cost =  $('#ship_cost').val();
			var ship_from =  $('#ship_from').val();
			var map =  $('#map').val();
			var prom_text =  $('#prom_text').val();

			var valid_map = true;
			if(map != "")
			{
				if(map < price)
				{
					valid_map = false;
				}
			}

			if(valid_map)
			{
				$.post('<?php echo base_url()?>inventory/add',{sku:sku,quan:quan,price:price,ret_price:ret_price,inv_id:inv_id,lead_time:lead_time,
					ship_cost:ship_cost,ship_from:ship_from,map:map,prom_text:prom_text,
					action:'stock','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){

					var  convert = JSON.parse(result);

					if(convert.status == '1')
						$(window.location).attr('href', "<?php echo base_url()?>inventory/detail/"+convert.url_ext);
					else
					{
						$(".error-cont").show();
						$(".error-cont").html(convert.message);
					}
				});
			}
			else
				alert('MAP must be greather than the Price');

		});
	});
</script>
<?php echo $this->load->view('supplier/footer') ?>