<!-- Lanz Editted -->
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
							<div class'floatl'=""> Shipping Request </div>
						</div>
					</div><br/>

					<?php  //echo print_r($pending);?>
					<div class='violet-table'>
						<table>
							<tr>
								<td width=55>Date Order</td>
								<td>Invoice</td>

								<td>Buyer</td>

								<td width=15>Billing Country</td>
								<td width=15>Total Item</td>
								<td>Total Amount</td>
								<td>Action</td>
							</tr>
							<?php if(count($app) != 0){?>
								<?php foreach($app as $apprv){?>
									<tr>
										<td><center><?php echo $apprv->bt_time ?></center></td>
										<td>
											<div><?php echo $apprv->bt_invoice?></div>
										</td>
										<td><center><p><?php echo $apprv->u_fname.' '.$apprv->u_lname?></p></center></td>
										<td><center><?php echo $apprv->c_code?></center></td>
										<td><center><?php echo $apprv->total_quan?></center></td>
										<td>$<?php echo $apprv->total_amount?></td>
										<td>
											<center>
<!-- 												<a href="#" onclick='confirm_shipping(<?php echo $pend->btd_id?>)' >Confirm</a>,
												<a href="">Decline</a>, -->
												<a href="<?php echo base_url()?>supplier/order/<?php echo $apprv->bt_id ?>/1" >Order Detail</a>
											</center>
										</td>
									</tr>
								<?php }?>
							<?php }else{?>
								<tr>
									<td colspan='7'><center>No Shipping Request Yet</center></td>
								</tr>
							<?php }?>
						</table>
					</div>

				</div>
			</div>


<?php echo $this->load->view('supplier/footer') ?>