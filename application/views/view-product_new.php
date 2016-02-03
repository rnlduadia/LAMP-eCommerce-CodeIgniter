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
	elseif($user_type == 1) //1 Admin
	{
		echo $this->load->view('admin/header');
	}
}
else
		echo $this->load->view('header');
?>

<script src="<?php echo base_url()?>js/organictabs.jquery.js" type="text/javascript"></script>

<script src="<?php echo base_url()?>js/jquery.flexslider.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>js/flexslider.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/style.css"/>
<script type="text/javascript">
	$(window).load(function() {
		$('.flexslider').flexslider({
			animation: "fade",
			slideshowSpeed: 8000,
			controlsContainer: ".number-slide",
			directionNav: false,
			startAt: 0,
			slideshow: false,
		    start: function(slider) {
			    $('.right-navi').click(function(event){
			        event.preventDefault();
			        slider.flexAnimate(slider.getTarget("next"));
			    });
			    $('.left-navi').click(function(event){
			        event.preventDefault();
			        slider.flexAnimate(slider.getTarget("prev"));
			    });
			}
		});
	});
</script>

		<!-- MIDDLE PAGE CONTAINER-->


			<!-- LEFT SIDEBAR CONTAINER-->
			<div  class="nav-bar floatL">

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
					}
					elseif($user_type == 1) //1 Admin
					{
						echo $this->load->view('admin/inventory/sidebar');
					}
				}
				else
						echo $this->load->view('sidebar');
				?>

			</div>

			<!-- RIGHT CONTENT CONTAINER-->
			<div class='floatR'>

				<div class='right-inner clearfix'>

					<!-- First Row Container-->

				<div class="productNavigation">
					<p><?php $this->categories->create_breadcrumb($product->cat_id,$product->c_level) ?> </p>
				</div>
				<div class="detailsInfo">
					<div class="productHeader">
						<p><?php echo $product->tr_title?></p>
					</div>
					<div class="floatL">
						<div class='' style="width:360px">
							<?php if(count($image_list) == 0){?>
								<img width=330 src="<?php echo base_url()?>images/default-preview.jpg">
							<?php }else{?>
								<div class="flexslider gallery-item">
								  <ul class="slides">
								  	<?php foreach($image_list as $img){?>
								    <li>
								    	<a onclick='return false' href="<?php echo base_url().$img->ii_link?>">
								    		<div class="img-wrap">
								    		<img src="<?php echo base_url().$img->ii_link?>" id="slide0" />
								    		</div>
								    	</a>
								    </li>
								    <?php }?>
								  </ul>
								</div>
							<?php }?>
						</div>
						<div class='clear'></div>
							<?php if (count($image_list) > 1) {?> <div class="navi-img-slide clearfix">
								<a class='left-navi' href="#"></a>
								<div class="fl number-slide clearfix">

								</div>
								<a class='right-navi' href="#"></a>
							</div><?php;}?>
					</div>

					<div class='left-prod-det normal-style clearfix fl'>
						<div class='PriceHeading'>
								<?php if($has_child){ ?>
									<p><span> $<?php echo $product->ic_price?></span></p>
								<?php }else{ ?>
									<p><span> N/A</span></p>
								<?php }?>

						</div>
						<div class='clearfix'>
							<table class="detInfo">
								<tr>
									<td>EPID:</td>
									<td><?php echo $product->i_id; ?></td>
								</tr>
								<tr>
									<td>MSRP:</td>
									<td><?php if($has_child){ echo $product->ic_retail_price; } else { echo 'N/A'; } ?></td>
								</tr>
								<tr>
									<td>Brand:</td>
									<td><a href="/inventory/search/brand/<?php echo $product->b_name; ?>"><?php echo $product->b_name; ?></a></td>
								</tr>
								<tr>
									<td>MAP:</td>
									<td><?php if($has_child){ echo $product->ic_map; } else { echo 'N/A'; } ?></td>
								</tr>
								<tr>
									<td>Manufacturer:</td>
									<td><a href="/inventory/search/mf/<?php echo $product->m_name; ?>"><?php echo $product->m_name; ?></a></td>
								</tr>
								<tr>
									<td>EST margin:</td>
									<td>100%</td>
								</tr>
								<tr>
									<td>Qty in Stock:</td>
									<td><?php if($has_child){ echo $product->ic_quan; } else { echo 'N/A'; } ?></td>
								</tr>
								<tr>
									<td>Qty Remaining:</td>
									<td><?php if($has_child){ echo $product->remaining_quantity; } else { echo 'N/A'; } ?></td>
								</tr>
								<tr>
									<td>Condition:</td>
									<td>New</td>
								</tr>
								<tr>
									<td>Supplier:</td>
									<td><?php if($has_child){ echo $product->u_company; } else { echo 'No Supplier Yet'; } ?></td>
								</tr>

							</table>
							<div class='clear'></div>
						</div>
					</div>
					<?php if($has_child){ ?>
					<div class='floatR' style="margin-right:10px;">
						<p class='fl' style="margin-top: 5px; margin-right: 7px;">Quantity:</p> <input readonly='readonly' type='text' id='quantity-cart' class='floatL' style="width:30px; margin-bottom:5px;"  value='1' />
						<div class="clear"></div>
						<button class='btn btn-success  btn-member' onclick='return add_to_cart(<?php echo $product->ic_id ?>)'>Add to Cart</button>
					</div>
					<?php }else{?>

					<div class='floatR' style="margin-right:10px;">
						<p class='fl'>Quantity:</p> <input readonly='readonly' type='text' id='quantity-cart' class='floatL' style="width:30px; margin-bottom:5px;"  value='1' />
						<div class="clear"></div>
						<button class='btn btn-success  btn-member' onclick='return add_to_cart(<?php echo $product->ic_id ?>)'>Out of Stock</button>
					</div>

					<?php }?>
					<!-- First Row Container END-->
					<div class='clear'></div>
				</div>
			</div>
				<!-- SUPPLIER PRODUCT TAB CONTAINER-->
				<div id="supplier-product-tab">

					<ul class="nav">
				        <li class="nav-one">
				        	<a href="#featured" class="current">

				        	<div class="head-tab fl">
								<div class="tab-center fl">
									<p class="fl">Description</p>
								</div>
							</div>

							</a>
						</li>
				        <li class="nav-two">
				        	<a href="#basic">
					        	<div class="head-tab fl">
									<div class="tab-center fl">
										<p class="fl">Inventory and Promotion</p>
									</div>

								</div>
				        	</a>
				        </li>
				        <li style="float:right; margin-top:7px; margin-right:5px;">Showing 3 from 99 ofers</li>
				    </ul>

					<div class="list-wrap">

						<ul id="featured">
							<li>
								<div class='inner-list-wrap clearfix'>
									<div class='left-inner-desc-prod semi-gray fl'>

										<h4 class='arrow-bullet'><?php echo $product->tr_title?></h4>

										<p><?php echo $product->tr_short_desc ? $product->tr_short_desc : ($product->tr_desc ? $product->tr_desc : '');?></p>
									</div>
									<div class="clear"></div>
									<div class='detailsTable'>
							                <table class="table table-bordered table-striped b-t b-light">
							                    <tr>
							                    	<td width=165 align='center' class='semi-gray'>Manufacture part No.</td>
							                    	<td width=165 class='black'><?php echo $product->manuf_num?></td>
							                    </tr>
							                    <tr>
							                    	<td align='center' class='semi-gray'>GTIN (UPC/EAN)</td>
							                    	<td><?php echo $product->upc_ean;?></td>
							                    </tr>
							                    <tr>
							                    	<td align='center' class='semi-gray'>Shipping Weight</td>
							                    	<td><?php echo $product->weight.$product->weightScale?></td>
							                    </tr>
							                    <tr>
							                    	<td align='center' class='semi-gray'>Shipping Size</td>
							                    	<td>
							                    		<?php echo $product->d_height.$product->d_scale.' H x '.
							                    				   $product->d_width.$product->d_scale.' W x '.
							                    				   $product->d_dept.$product->d_scale.' D' ?>
							                    	</td>
							                    </tr>
							                    <tr>
							                    	<td align='center' class='semi-gray'>Lead Time</td>
							                    	<td><?php echo $product->ic_leadtime?></td>
							                    </tr>
							                </table>

									</div>
								</div>
							</li>
						</ul>

						 <ul id="basic" class="hide">
				            <li>
				            	<div class='status-selection-cont clearfix'>
					            	<div class='status-selection'>
					            		<input type="radio" class="radio-type-sel" id="type-new">
					            		<label for="type-new">New</label>
					            	</div>
					            	<div class='status-selection'>
					            		<input type="radio" class="radio-type-sel" id="type-refurb">
					            		<label for="type-refurb">Refurbished</label>
					            	</div>

					            	<div class='status-selection'>
					            		<input type="radio" class="radio-type-sel" id="type-used">
					            		<label for="type-used">Used</label>
					            	</div>

					            	<div class='status-result'>
					            		<p>Showing 1 out of 10 offers</p>
					            	</div>

				            	</div>

				            	<div class='clear'></div>
				            	<div class='list-supplier-cont-prod'>
					            	<div class='gray-table'>
						                <table class="table table-bordered table-striped b-t b-light">
						                    <tr>
						                        <td width=270>Supplier</td>
						                        <td>Condition</td>
						                        <td>Onhand</td>
						                        <td>Price</td>
						                        <td>Retail Price</td>
						                        <td>Ship Price</td>
						                        <td>Ship From</td>
						                        <td>Promotion</td>
						                        <td width=30>Add</td>
						                    </tr>
						                    <?php
						                    	if(isset($suppliers))
						                    	foreach($suppliers as $sup){
						                    	$remaining_quantity = $this->suppliers->get_child_remaining_quan($sup->ic_id, $sup->ic_quan);
						                    	if ($remaining_quantity > 0){
						                    	?>
							                    <tr>
							                    	<td>
								                    	<p class='fl'>
								                    		<a onclick='return show_sup_status(<?php echo $sup->ic_id ?>)' href="#"><?php echo $sup->u_company ?></a>
								                    		<div class='supplier-status-cont float-cont' id='supplierstat<?php echo $sup->ic_id ?>'>
								                    			<div class='inner-sup-stat'>

								                    				<div class='heading-violet-full'>
								                    					<p class='fl'><?php echo $sup->u_company ?></p>
								                    				</div>

								                    				<div class='fl inner-left-sup-stat'>
									                    				<div class='fl'>
									                    					<?php
																				$total_feedback = 0;
																				if($general_feedback != false)
																						$total_feedback = $general_feedback->avg_rate;
																				else
																						$total_feedback = 0;
																				?>
																				<p class='fl'>Feedback rating:</p>
																				<div id="sup_ic_rate<?php echo $sup->u_id?>" class="fl sup_ic_rate-cont"></div>
																				<script type="text/javascript">
																					$(document).ready(function(){
															                            $('#sup_ic_rate<?php echo $sup->u_id?>').raty({
															                              readOnly : true,
															                              score    : <?php echo $total_feedback ?>,
															                              width    : 150,
															                              path     :"<?php echo base_url().'images/'?>"
															                            });
															                        });
														                        </script>

									                    				</div>
									                    				<div class='clear'></div>
									                    				<div>
									                    					<p>Avarage lead time: <span><?php echo $this->suppliers->average_lead_time($sup->u_id); ?> business Days</span> </p>
									                    				</div>
									                    				<div class='clear'></div>
									                    				<div>
									                    					<p>Returns: <span>None</span></p>
									                    				</div>
									                    				<div class='clear'></div>
									                    				<div>
									                    					<p>Line in Hand: <span>100%</span></p>
									                    				</div>
									                    				<div class='clear'></div>
									                    				<div>
									                    					<p>Country:<span></span></p>
									                    				</div>
									                    				<div class='clear'></div>
									                    				<div>
									                    					<p>Launch Date:<span></span></p>
									                    				</div>
								                    				</div>

								                    				<div class='fr inner-right-sup-stat'>
								                    					<p class='feedback-top'>(Feedbacks: <span><?php echo count($feedback_detail)?></span>)</p>
								                    					<p class='date-feedback'>15/03/2011</p>
								                    					<p>Excellent dealer. I’m happy with his performance.</p>
								                    					<p class='bottom-feedback-auth'>by <a href="#">yuri_t</a></p>
								                    				</div>

								                    			</div>
								                    			<div class='clear'></div>
								                    			<div class='bottom-arrow-pop'></div>
								                    		</div>
								                    	</p>
							                    		<div class='star-cont fl'>
							                    			<p class='fl percent'>56%</p><button class='star-rate fr'></button>
							                    		</div>
							                    		<div class='action-icon-cont fl'>
							                    			<a class='overview-icon fl' href="#"></a>
							                    			<a class='restriction-icon fl' href="#"></a>
							                    			<a class='returnPolicy-icon fl' href="#"></a>
							                    		</div>
							                    	</td>
							                    	<td>New</td>
							                    	<td><?php echo $remaining_quantity ?></td>
							                    	<td><?php echo $sup->ic_price ?></td>
							                    	<td><?php echo $sup->ic_retail_price ?></td>
							                    	<td><?php echo $sup->ic_ship_cost ?></td>
							                    	<td><?php echo $sup->c_code ?></td>
							                    	<td><?php echo $sup->ic_prom_text ?></td>
							                    	<td><button onclick="return add_to_cart(<?php echo $sup->ic_id ?>)" class='add-quick-cart'></button></td>
							                    </tr>
							                <?php }}?>
						                </table>
					            	</div>
				            	</div>
				            </li>
						 </ul>

					 </div> <!-- END List Wrap -->

				 </div>
				<!-- SUPPLIER PRODUCT TAB CONTAINER END-->


				<!-- TRANSLATION CONTAINER-->
			<!-- 	<div class="right-inner clearfix">
					<div class="heading-yellow-full">
						<p class="fl">Available Translations</p>
					</div>
					<div class='left-inner-trans-prod semi-gray fl'>
						<div class='gray-no-top'>
			                <table>
			                	<?php foreach($translations as $trans){?>
				                    <tr>
				                    	<td align='center' class='semi-gray'><?php echo $trans->c_name?></td>
				                    	<td class='black'><?php echo $trans->c_code?></td>
				                    </tr>
			                    <?php }?>
			                </table>
		            	</div>
					</div>

				</div> -->
				<!-- TRANSLATION CONTAINER END-->

				<!-- FEEDBACK CONTAINER-->
			<!-- 	<div class="right-inner clearfix">
					<div class="heading-yellow-full">
						<p class="fl">Feedback</p>
					</div>
					<div class='inner-feedback-cont'>
						<ul class='arrow-bullet clearfix'>
							<li>If you need help or have a question for <a href="mailto:support@oceantailer.com?subject=I%20need%20help%20or%20I%20have%20a%20question&body=%0A%0A%0A<?=current_url();?>">Customer Service.</a></li>
							<li>Did you find an error or have a <a href="mailto:support@oceantailer.com?subject=I%20found%20an%20error%20or%20I%20have%20a%20suggestion&body=%0A%0A%0A<?=current_url();?>">suggestion</a> about the product?</li>
							<li>Did you see the <a href="mailto:support@oceantailer.com?subject=I%20found%20this%20product%20cheaper%20elsewhere&body=I%20found%20it%20at:%0AHere%20is%20the%20link:%0A%0A%0A<?=current_url();?>"><?php echo $product->tr_title?></a> cheaper somewhere else?</li>
						</ul>
						<div class='orange-line'> </div>
						<input type='button' class='normal-button corpi-font' value='Add this product to feed' />
					</div>
				</div> -->
				<!-- FEEDBACK CONTAINER END-->



<script type="text/javascript">
	$(function() {

        $("#supplier-product-tab").organicTabs();

    });
    $(window).load(function() {

		$(".radio-type-sel").click(function(){
			if(!$(this).hasClass('radio-type-sel-active')) {
		        $(this).addClass('radio-type-sel-active');
		    }
		    else{
		    	$(this).removeClass('radio-type-sel-active');
		    }

		});

		 <?php if(count($image_list) != 0){?>
		 $('.inner-img-prod-list div.flexslider div.flex-viewport ul.slides li a ').imgPreview({
		    containerID: 'preview-slides',
		    imgCSS: {
		        // Limit preview size:
		        height: 200
		    },
		    // When container is shown:
		    onShow: function(link){
		        $('<span>' + $(link).text() + '</span>').appendTo(this);
		    },
		    // When container hides:
		    onHide: function(link){
		        $('span', this).remove();
		    }
		});
		<?php }?>

	});

	function show_sup_status(id)
	{
		$('#supplierstat'+id).fadeIn();
		return false;
	}

	$(document).mouseup(function (e)
	{
	    var container = $(".supplier-status-cont");

	    if (container.has(e.target).length === 0)
	    {
	        container.hide();
	    }
	});
	var quan = 1;
	$('.stepper-up').click(function(){
		quan = $('#quantity-cart').val();
			$('#quantity-cart').val(parseInt(quan)+1);
		quan = $('#quantity-cart').val();
	});

	$('.stepper-down').click(function(){

		quan = $('#quantity-cart').val();
		if(parseInt(quan) != 1 )
		 	$('#quantity-cart').val(parseInt(quan)-1);
		 quan = $('#quantity-cart').val();
	});

	function add_to_cart(icid)
	{
		$.post("<?php echo base_url()?>cart/add",{icid:icid,quan:quan,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
			var crt = JSON.parse(result);

			if(crt.total_item<=crt.rem_qty) {
				$('#num-total-item').html(crt.total_item);
				$(window.location).attr('href', '<?php echo base_url()?>cart');//redirect to the user page
			} else {
				alert("Available quantity of this product is "+crt.rem_qty+". Please update the quantity and then click on add to cart");
				return false;
			}
		});
	}

</script>

<script src="<?php echo base_url()?>js/imgpreview.full.jquery.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url()?>js/jquery.raty.min.js"></script>

<?php
if($this->session->userdata('is_login') == TRUE)
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
	elseif($user_type == 1) //1 Admin
	{
		echo $this->load->view('admin/footer');
	}
}
else
		echo $this->load->view('footer');
?>
