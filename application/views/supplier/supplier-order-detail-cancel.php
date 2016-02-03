<?php echo $this->load->view('supplier/header') ?>
<script src="<?php echo base_url()?>js/jquery-ui-1.10.0.custom.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/jquery-ui-1.10.0.custom.min.css"/>



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
							<div class'floatl'=""> Order Detail </div>
						</div>
					</div>

					<div class='product-cont padded-cont clearfix'>
						<div class="fl half clearfix">
							<p class='p-infoformat fl'> <label class='label-infoformat fl'>Order Date: </label>&#160;&#160;<?php echo $bt->bt_time ?></p>
						</div>
						<div class="fl half clearfix">
							<p class='p-infoformat fl'> <label class='label-infoformat fl'>Payment Method: </label>&#160;&#160;<?php echo $bt->bt_type; ?></p>
						</div>
						<div class="fl half clearfix">
							<p class='p-infoformat fl'> <label class='label-infoformat fl'>Invoice Number: </label>&#160;&#160;<?php echo $bt->bt_invoice; ?></p>
						</div>
						<?php if($bt->bsd_status != 0 && $bt->bsd_status != -1 && $bt->bsd_status != -2){?>
						<div class="fl half clearfix">
							<p class='p-infoformat fl'> <label class='label-infoformat fl'>Correlation Id: </label>&#160;&#160;<?php echo $bt->bsd_correlation_id; ?></p>
						</div>
						<div class="fl half clearfix">
							<p class='p-infoformat fl'> <label class='label-infoformat fl'>Acknowledge Status: </label>&#160;&#160;<?php echo $bt->bsd_ack; ?></p>
						</div>
						<div class="fl half clearfix">
							<p class='p-infoformat fl'> <label class='label-infoformat fl'>Order Date: </label>&#160;&#160;<?php echo $bt->bsd_timestamp; ?></p>
						</div>
						<?php }?>

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
									<td width=15>Commision</td>
									<td>Deduction</td>
									<td>Net Total</td>
								</tr>
								<?php
								$net_total = 0;
								$deduction_total = 0;
								$shipping_total = 0;
								foreach($btd as $btd_det){
									$shipping = $btd_det->btd_shipamount * $btd_det->btd_quan;
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
														<img width=90  src="/<?php echo $image_list[0]->ii_link ?>">
													<?php }?>
												</div>
												<div class='fl'>
													<div><a href="<?php echo base_url()?>inventory/detail/<?php echo $btd_det->i_id?>/<?php echo $btd_det->supplier_id?>" ><?php echo $btd_det->tr_title?> </a></div>
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
										<td><center>$<?php echo number_format($btd_det->btd_amount,2)?></center></td>
										<td>$<?php echo number_format($btd_det->btd_subamount,2)?></td>
										<td><?php echo number_format($btd_det->btd_productFee,2) ?>%</td>
										<td>-$<?php echo $deduction = number_format($btd_det->btd_subamount * ($btd_det->btd_productFee/100),2); ?></td>
										<td>$<?php echo $net = number_format($btd_det->btd_subamount - $deduction,2);  ?></td>
										<?php
											$shipping_total += $shipping;
											$net_total += $net;
											$deduction_total +=$deduction;
										?>
									</tr>
								<?php }?>

								<?php if($bt->bsd_status == -2 || $bt->ssi_status == 1){ $shipping_total = $bt->ssi_shipExtra; }?>

								<tr>
									<td colspan=7><p class='fl' style='margin-top:10px;'>Revision  Shipping Fee: $</p>

										<p class='fl' style='margin-top:10px;'><?php echo $shipping_total ?></p>

									</td>
								</tr>
								<tr>
									<td colspan='3' class='big-font'><p>Total:</p></td>
									<td colspan='1' class='big-font'><b><label class='label-infoformat'>$<?php echo number_format($bt->bsd_total_paymet,2) ?></label>&#160;&#160;<label id='shipping-label' class='label-infoformat'>+&#160;$<?php echo number_format($shipping_total,2)?></label></b></td>
									<td colspan='1' class='big-font'></td>
									<td colspan='1' class='big-font'><p>-$<?php echo number_format($deduction_total,2)?></p></td>
									<td colspan='1' class='big-font'><p class='totalnet-cont'>$<?php echo number_format($net_total + $shipping_total,2)?></p></td>
								</tr>
							</table>
						</div>

					</div>

				</div>


				<?php if($bt->bsd_status != 1) {?>
				<div class='right-inner clearfix'>
					<!-- First Row Container-->
					<div class="topBrands searching-for">
						<div class="topBrandsHeader">
							<div class'floatl'="">Cancel Order</div>
						</div>
					</div>

					<script type="text/javascript">
						function cancelOrder(){
							if (confirm('are you sure to cancel the order? \n press [OK] to send cancel order or press [Cancel] to cancel order?')){
						      	var reason = $('#cancel-reason').val();
						      	$.post('<?php echo base_url()?>supplier/orderUpdate',{action:'cancel',reason:reason,bsd_id:<?php echo $bt->bsd_id ?>,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(){
						      		window.location.reload();
						      	});
						    }
						}
					</script>

					<div class='padded-cont clearfix'>
						<?php if($bt->bsd_status != -1){?>
							<div class='fl'>
									<label for='seller-memo'>Reason:</label>
								<select class='normal-format-select' id='cancel-reason'>
									<?php foreach($cancels as $can){?>
									<option value="<?php echo $can->ocl_name?>"><?php echo $can->ocl_name?></option>
									<?php }?>
								</select>
							</div>
							<button class='greenbutton floatR' id='submit-cancel-shipping' onclick="cancelOrder()" >CANCEL ORDER</button>
							<?php }else{?>
							<center><p>-Cancel Reason: <?php echo $bt->bsd_reason?>-</p></center>
							<?php }?>
					</div>

				</div>
				<?php }?>

				<div class='right-inner clearfix'>
					<!-- First Row Container-->
					<div class="topBrands searching-for">
						<div class="topBrandsHeader">
							<div class'floatl'="">My Notes</div>
						</div>
					</div>

					<div class='padded-cont clearfix'>
						<div class='clearfix'>
							<div class="clear"> </div>
							<textarea type='text' id='seller-memo'  class='normal-format-text full-ta'><?php echo $bt->bsd_memo ?></textarea>

						</div>
						<div class='clearfix'><br/>
							<button class='greenbutton floatR' id='clear-memo'>UNDO</button>
							<span class='floatR'>&nbsp;</span>
							<button class='greenbutton floatR' id='save-memo'>SAVE</button>
						</div>
						<script type="text/javascript">
							var memo_backup = $('#seller-memo').val();
							$("#save-memo").click(function(){
								var memo = $('#seller-memo').val();

								$.post('<?php echo base_url()?>supplier/memo',{action:'update',memo:memo,id:<?php echo $bt->bsd_id ?>,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
									alert('Memo has been saved successfully.');
								});

							});

							$('#clear-memo').click(function(){
								$('#seller-memo').val(memo_backup);
							});
						</script>
					</div>
				</div>



			</div>



<script type="text/javascript" charset="utf-8" src="<?php echo base_url()?>js/jquery.raty.min.js"></script>
<?php echo $this->load->view('supplier/footer') ?>


