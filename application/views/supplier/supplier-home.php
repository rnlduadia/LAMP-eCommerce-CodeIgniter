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

<script src="<?php echo base_url()?>js/organictabs.jquery.js" type="text/javascript"></script>

<script src="<?php echo base_url()?>js/jquery.flexslider.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>js/flexslider.css"/>

<script type="text/javascript">
	$(window).load(function() {
		$('.flexslider').flexslider({
			animation: "slide",
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

</head>


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
						echo $this->load->view('buyer/sidebar');
					}
				}
				else
						echo $this->load->view('sidebar');
				?>
		</div>


			<!-- RIGHT CONTENT CONTAINER-->
<div class="sliderLg floatR">
	<div class="prodinfoblock ">
	<div class="prodtitle"><?php echo $supplier->u_company ?></div>
		<div class="prodininfo">
			<div id="supplier-product-tab">
					<ul class="nav">
				        <li class="nav-one">
				        	<a href="#overview" class="current">

				        	<div class="head-tab fl">
								<div class="tab-center fl">
									<p class="fl">Overview</p>
								</div>
							</div>

							</a>
						</li>
				        <li class="nav-two">
				        	<a href="#feedback" class="">
					        	<div class="head-tab fl">
									<div class="tab-center fl">
										<p class="fl">Feedbacks</p>
									</div>
								</div>
				        	</a>
				        </li>
				        <li class="nav-three">
				        	<a href="#restriction" class="">
					        	<div class="head-tab fl">
									<div class="tab-center fl">
										<p class="fl">Restriction</p>
									</div>
								</div>
				        	</a>
				        </li>
				        <li class="nav-four" class="">
				        	<a href="#return_policy">
					        	<div class="head-tab fl">
									<div class="tab-center fl">
										<p class="fl">Return Policy</p>
									</div>
								</div>
				        	</a>
				        </li>
				    </ul>

					<div class="list-wrap">

						<ul id="overview">
							<li class='clearfix'>
								<div class="left-overview fl clearfix">
									<h3><?php echo $supplier->u_company?></h3>
									<div class='orange-line'> </div>
									<div class='overview-par clearfix'>
										<p>Average lead time : <span>4 Business Days</span></p>
										<p>Returns : <span>0</span></p>
										<p>Lined on Hand : <span>100%</span></p>
										<p>Country : <span><?php echo $supplier->c_name?></span></p>
										<p>Launched day : <span><?php echo date('M d, Y',strtotime($supplier->u_time)) ?></span></p>
									</div>
									<div class='clear'></div>
									<!--
									<div class="browse-products">
										<button class="greenbutton" onclick="return false">Browse Products</button>
									</div>-->
								</div>
								<div class='right-overview fl clearfix'>
									<div class='overview-par clearfix'>

										<?php
										$total_feedback = 0;
										if($general_feedback != false)
												$total_feedback = $general_feedback->avg_rate;
										else
												$total_feedback = 0;
										?>
										<p class='fl'>Feedback rating:</p>
										<div id="sup_ic_rate<?php echo $supplier->u_id?>" class="fl sup_ic_rate-cont"></div>
										<script type="text/javascript">
											$(document).ready(function(){
					                            $('#sup_ic_rate<?php echo $supplier->u_id?>').raty({
					                              readOnly : true,
					                              score    : <?php echo $total_feedback ?>,
					                              width    : 150,
					                              path     :"<?php echo base_url().'images/'?>"
					                            });
					                        });
				                        </script>
				                        <p class='fl'>(feedbacks: <span> <?php echo count($feedback_detail)?> </span>)</p>
			                        </div>
			                        <div class='list-supplier-cont-prod'>
						            	<div class='gray-table'>
							                <table>
							                    <tr>
							                        <td>Feedback</td>
							                        <td>1 Month</td>
							                        <td>6 Months</td>
							                        <td>1 Year</td>
							                        <td>Lifetime</td>
							                    </tr>
							                    <?php foreach($feedback_detail as $feedback){?>
							                    <tr>
							                        <td><p><span><?php echo count($feedback_detail)?></span></p></td>
							                        <td><p><?php echo count($feedback_detail)?></p></td>
							                        <td><p>0</p></td>
							                        <td><p>0</p></td>
							                        <td><p>0</p></td>
							                    </tr>
							                    <?php }?>
							                </table>
						            	</div>
					            	</div>

								</div>
								<div class='clearfix arrow-conthead'><?php echo ($feedback_detail) ? "<center>Latest Feedback</center>" : "Latest Feedback"; ?></div>
								<div class='clear'></div>
								<div class='feed-back-cont-main-bot clearfix'>
									<div class='list-supplier-cont-prod'>
						                <table class='gtable noodd'>
						                	<?php foreach($feedback_detail as $feedback){?>
						                	<tr>
						                		<td><?php echo date('d/M/Y',$feedback->bsd_timestamp) ?></td>
						                		<td><?php echo $feedback->bsd_buyer_feedback ?> </td>
						                		<td>was rate at <?php echo $feedback->bsd_buyer_rate ?> by <?php echo $feedback->u_company ?> </td>
						                	</tr>
						                	<?php }?>
						                </table>
					            	</div>
								</div>

							</li>
						</ul>

						<ul id="feedback" class="hide1" style='display:none'>
				           <li>
				            	<div class='padded-cont clearfix'>
									<div class='list-supplier-cont-prod'>
						                <table class='gtable noodd'>
						                	<?php if(count($feedback_detail) == 0){?>
						                	<tr>
						                		<td><center>No Feedback Yet</center></td>
						                	<tr>
						                	<?php }else{ foreach($feedback_detail as $feedback){?>
						                	<tr>
						                		<td><?php echo date('d/M/Y',strtotime($feedback->u_time)) ?></td>
						                		<td><?php echo $feedback->bsd_buyer_feedback ?> </td>
						                		<td>was rate at <?php echo $feedback->bsd_buyer_rate ?> by <?php echo $feedback->u_company ?> </td>
						                	</tr>
						                	<?php } }?>
						                </table>
					            	</div>

				            	</div>
				           </li>
						</ul>

						<ul id="restriction" class="hide1" style='display:none'>
				           <li>
				           		<div class='padded-cont clearfix'>
				           			<h2>RESTRICTION</h2>

				           			<div class='clear'></div>
				           			<textarea id='text-area-restrict' readonly='readonly' class='text-area-disable'><?php echo $supplier->u_restriction ?></textarea>
				           			<div class='clear'></div>
								<?php if($this->session->userdata('is_login') == TRUE && ($user_type == 2 || $user_type == 1)){ ?>
				           			<input type='button' id='edit-restriction' class='bt-link-format fr' value='edit' />
								<?php } ?>
				           		</div>

				           </li>
						</ul>

						<ul id="return_policy" class="hide1" style='display:none'>
				           <li>
				            	<div class='padded-cont'>
				            		<h2>RETURN POLICY</h2>

				            		<div class='clear'></div>
				           			<textarea id='text-area-return' readonly='readonly' class='text-area-disable'><?php echo $supplier->u_return ?></textarea>
				           			<div class='clear'></div>
								<?php if($this->session->userdata('is_login') == TRUE && ($user_type == 2 || $user_type == 1)){ ?>
				           			<input type='button' id='edit-return' class='bt-link-format fr' value='edit' />
								<?php } ?>
				           			<div class='clear'></div>
<!--  								<p>
										You may return most new, unopened items sold and fulfilled by Ocean Tailer
										within 30 days of delivery for a full refund. Refunds will be available
										usually in about 2-3 weeks. Most refunds are fully refunded in 3-5 days after
										e receive and process your return. If you received a damaged or defective item,
										we will ship you a replacement of the exact item. If you would like to exchange
										an item for another, you can exchange for a different size or color or for an
										item in your Cart.
									</p> -->
				            	</div>
				           </li>
						</ul>

					 </div>
			</div><!--#supplier-product-tab-->
		</div>

	</div><!--.prodinfoblock-->
	<div class='clear'></div><br/>

	<div class='right-inner clearfix'>
		<div class="topBrands searching-for">
			<div class="topBrandsHeader">
				<div class'floatl'="">Most Popular & Featured Products</div>
			</div>
		</div>

						<? $num = 0;
						if(count($random_products)>0) {
							foreach($random_products as $product) {
								$num++;
						?>

							<div style="<?php echo $num % 3 == 1 ? "clear:both" : "" ?>" class="prod-list-cont fl">
								<div class="img-feat-prod-list-cont">
									<? if(isset($product->ii_link) and $product->ii_link!="") { ?>
										<a href="<?php echo base_url()?>inventory/detail/<?=$product->i_id; ?>">
											<img src="<?php echo base_url().$product->ii_link;?>" width="100%" />
										</a>
									<? } else { ?>
										<a href="<?php echo base_url()?>inventory/detail/<?=$product->i_id; ?>">
											<img src="<?php echo base_url()?>images/default-preview.jpg" width=157 />
										</a>
									<? }?>
								</div>
								<div class='quick-detail-prod-list'>
									<h5 class="fl">
										<a href="<?php echo base_url()?>inventory/detail/<?=$product->i_id; ?>"><? echo $product->tr_title; ?></a>
									</h5>
									<div class="clear"> </div>
									<p><span>Price:</span> <? echo $product->ic_price; ?> / <span>RRP:</span> <? echo $product->ic_retail_price; ?></p>
									<div class="hr-orange"> </div>
									<p>Estimated profit: <? echo round((($product->ic_retail_price - $product->ic_price)/$product->ic_price)*100) ?>%</p>

								</div>
							</div>
							<? } ?>
						<? } ?>
						<div class="clear"></div>

						<div class="navi-feat fr">
							<a class="left-navi" href='#'></a>
							<a class="right-navi" href='#'></a>
						</div>

					</div>


	</div>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url()?>js/jquery.raty.min.js"></script>
<script type="text/javascript">
	var input_disable = true;
	var input_disable_return = true;

	$('#edit-restriction').click(function(){
		if(input_disable)
		{
			input_disable = false;
			$('#text-area-restrict').addClass('text-area-enable');
			$('#text-area-restrict').removeAttr('readonly');
			$('#edit-restriction').attr('value','save');
		}
		else
		{
			input_disable = true;
			$('#text-area-restrict').removeClass('text-area-enable');
			restriction_text = $('#text-area-restrict').val();
			$('#text-area-restrict').attr('readonly','readonly');
			$('#edit-restriction').attr('value','edit');
			$.post("<?php echo base_url()?>supplier/update_post",{res:restriction_text,action:'restriction','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){

			});
		}
	});
	$(function() {
        $("#supplier-product-tab").organicTabs();

    });

    $('#edit-return').click(function(){
		if(input_disable_return)
		{
			input_disable_return = false;
			$('#text-area-return').addClass('text-area-enable');
			$('#text-area-return').removeAttr('readonly');
			$('#edit-return').attr('value','save');
		}
		else
		{
			input_disable_return = true;
			$('#text-area-return').removeClass('text-area-enable');
			ret_text = $('#text-area-return').val();
			$('#text-area-return').attr('readonly','readonly');
			$('#edit-return').attr('value','edit');
			$.post("<?php echo base_url()?>supplier/update_post",{return_val:ret_text,action:'return','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){

			});
		}
	});
	$(function() {

 //       $("#supplier-product-tab").organicTabs();

    });

</script>
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
}
else
		echo $this->load->view('footer');
?>
