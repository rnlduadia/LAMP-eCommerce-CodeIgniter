<?php echo $this->load->view('buyer/header') ?>
<script src="<?php echo base_url()?>js/jquery-ui-1.10.0.custom.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/jquery-ui-1.10.0.custom.min.css"/>


			<!-- LEFT SIDEBAR CONTAINER-->
			<div class="nav-bar floatL">

				<?php echo $this->load->view('buyer/sidebar');?>

			</div>

			<!-- RIGHT CONTENT CONTAINER-->
			<div class='sliderLg floatR'>

				<div class='right-inner clearfix'>

					<!-- First Row Container-->
					<div class="topBrands searching-for">
						<div class="topBrandsHeader">
							<div class'floatl'=""> Order Detail </div>
						</div>
					</div>

					<div class='product-cont padded-cont clearfix'>
						<div class="fl half clearfix">
							<p class='p-infoformat fl'> <label class='label-infoformat fl'>Order Date: </label>&#160;&#160;<?php echo $bt->bt_time?></p>
						</div>
						<div class="fl half clearfix">
							<p class='p-infoformat fl'> <label class='label-infoformat fl'>Payment Method: </label>&#160;&#160;<?php echo $bt->bt_type; ?></p>
						</div>
						<div class="fl half clearfix">
							<p class='p-infoformat fl'> <label class='label-infoformat fl'>Invoice Number: </label>&#160;&#160;<?php echo $bt->bt_invoice; ?></p>
						</div>

						<div class="fl half clearfix">
							<p class='p-infoformat fl'> <label class='label-infoformat fl'>Order Status: </label>&#160;&#160;<?php echo $bt->bsd_reason ?>
							</p>
						</div>

					</div>

				</div>

				<div class='right-inner clearfix'>

					<!-- First Row Container-->
					<div class="topBrands searching-for">
						<div class="topBrandsHeader">
							<div class'floatl'=""> Item Order Detail </div>
						</div>
					</div>

					<div class='product-cont padded-cont clearfix'>
						<div class='violet-table'>
							<table>
								<tr>
									<td>Product</td>
									<td width=15>Qty</td>
									<td width=15>Amount</td>
<!-- 									<td width=15>Shipping Fee</td> -->
									<td>Sub Amount</td>
									<td>Net Total</td>
								</tr>
								<?php
								$net_total = 0;
								$deduction_total = 0;
								$shipping_total = 0;
								foreach($btd as $btd_det){
									$shipping = $btd_det->btd_shipamount * $btd_det->btd_quan; //shipping amount * the quantity
									?>
									<tr>
										<td>
											<div class='clearfix'>
												<div class='fl' style='margin-right:10px;'>
													<?php
													$image_list = $this->inventories->list_image($btd_det->i_id,1,true);
													//limit 1, select only the featured image
													if(count($image_list) == 0){?>
														<img width=90 src="<?php echo base_url()?>images/default-preview.jpg">

													<?php }else{?>
														<img width=90  src="<?php echo $image_list[0]->ii_link ?>">
													<?php }?>
												</div>
												<div class='fl'>
													<div><a target='_blank' href="<?php echo base_url()?>inventory/detail/<?php echo $btd_det->i_id?>/<?php echo $btd_det->supplier_id?>" ><?php echo $btd_det->tr_title?> </a></div>
													<div class='table-format-det clearfix'>
														<label class='fl'>Produt ID: </label><p class='fl'> <?php echo $btd_det->ic_id?></p>
													</div>
													<div class='table-format-det clearfix'>
														<label class='fl'>UPC/EAN: </label><p class='fl'> <?php echo $btd_det->upc_ean?></p>
													</div>
													<div class='table-format-det clearfix'>
														<label class='fl'>SKU: </label><p class='fl'> <?php echo $btd_det->SKU?></p>
													</div>
												</div>
											</div>
										</td>
										<td><center><?php echo $btd_det->btd_quan?></center></td>
										<td><center>$<?php echo $btd_det->btd_amount?></center></td>
										<td>$<?php echo $btd_det->btd_subamount?></td>
										<td>$<?php echo $net = $btd_det->btd_subamount;  ?></td>
										<?php
											$shipping_total += $shipping;
											$net_total += $net;

										?>
									</tr>
								<?php }?>
								<?php if($bt->bsd_status == -2 || $bt->ssi_status == 1){
									$shippin_old_price = $shipping_total;
									$shipping_total = $bt->ssi_shipExtra; }?>
								<tr>
									<td colspan=7><p class='fl' style='margin-top:10px;'>Shipping Fee: $</p>

											<p class='fl' style='margin-top:10px;'><?php echo $shipping_total ?></p>

									</td>
								</tr>
								<tr>
									<td colspan='3' class='big-font'><p>Total:</p></td>
									<td colspan='1' class='big-font'><b><label class='label-infoformat'>$<?php echo $bt->bsd_total_paymet ?></label>&#160;&#160;<label id='shipping-label' class='label-infoformat'>+&#160;$<?php echo $shipping_total?></label></b></td>
									<td colspan='1' class='big-font'><p class='totalnet-cont'>$<?php echo $net_total + $shipping_total?></p></td>
								</tr>
							</table>
						</div>

					</div>

				</div>

				<div class='right-inner clearfix'>

					<!-- First Row Container-->
					<div class="topBrands searching-for">
						<div class="topBrandsHeader">
							<div class'floatl'="">Return Order</div>
						</div>
					</div>


					<div class='padded-cont'>
						<?php if($bt->bsd_status != 0){?>
							<div class='fl'>
									<label for='seller-memo'>Reason:</label>
								<select class='normal-format-select' id='cancel-reason'>
									<?php foreach($returns as $ret){?>
									<option value="<?php echo $ret->o_ret_name?>"><?php echo $ret->o_ret_name?></option>
									<?php }?>
								</select>
							</div>
							<button class='normal-button fr' id='submit-cancel-shipping' onclick="returnOrder()" >RETURN ORDER</button>
							<?php }else{?>
							<center><p>-Cancel Reason: <?php echo $bt->bsd_reason?>-</p></center>
						<?php }?>

					</div>

				</div>


			</div>


<script type="text/javascript">
	function returnOrder(){
		if (confirm('are you sure to return the order? \n press [OK] to send return order or press [Cancel] to cancel return order?')){
	      	var reason = $('#cancel-reason').val();
	      	$.post('<?php echo base_url()?>buyer/orderUpdate',{action:'return',reason:reason,bsd_id:<?php echo $bt->bsd_id ?>,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(){
	      		window.location.reload();
	      	});
	    }
	}
</script>


<?php echo $this->load->view('buyer/footer') ?>