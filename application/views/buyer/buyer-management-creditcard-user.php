<?php $this->load->view("buyer/header"); ?>
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
							<div class'floatl'="">Manage Credit Card</div>
						</div>
					</div>					
					<div class='padded-cont'>
						<a  class='fr' href="<?php echo base_url()?>buyer/addcreditcard">Add</a>
						<div class="clear"> </div>
						<div class='gray-table table-margin'>
							<table>
								<tr>
									<td>Card Holder Name</td>
									<td>Card Number</td>
									<td>Expiration Date</td>
									<td width=120>Options</td>
								</tr>
								<?php foreach($credit_cards as $cards){?>
								<tr>
									<td><?php echo $cards->ccu_name ?></td>
									<td><?php echo '***********'.substr($cards->ccu_number, 11, 15) ?></td>
									<td><?php  if(count($cards->ccu_exp_month) == 1){echo '0';}; echo $cards->ccu_exp_month.'/'.$cards->ccu_exp_year ?></td>
									<td>
										<center>
										<a href="<?php echo base_url() ?>buyer/cardaction/update/<?php echo $cards->ccu_id ?>">Update</a>,
										<a href="<?php echo base_url() ?>buyer/cardaction/delete/<?php echo $cards->ccu_id ?>">Delete</a>,
										<?php 
										if ($cards->ccu_isset == 1){
										}
										else
										{
											echo '<a href='.base_url().'buyer/cardaction/setactive/'.$cards->ccu_id.'/'.$cards->u_id.'>Set</a>';
										}
										?>
										</center>
										<input type="hidden" value="<?php echo $cards->ccu_id ?>">
										<input type="hidden" value="<?php echo $cards->u_id ?>">
									</td>
								</tr>
								<?php }?>
							</table>
						</div>
					</div>
				</div>
			</div>

<?php $this->load->view("buyer/footer"); ?>