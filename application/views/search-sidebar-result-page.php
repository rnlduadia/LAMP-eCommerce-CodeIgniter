<!-- SEARCH RESULTS -->
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

		<!-- MIDDLE PAGE CONTAINER-->


				<!-- LEFT SIDEBAR CONTAINER-->
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
						echo $this->load->view('sidebar');
					}
				}
				else
						echo $this->load->view('sidebar');
				?>

				</div>
				<!-- LEFT SIDEBAR CONTAINER-->

				<!-- RIGHT CONTENT CONTAINER-->
				<div class='sliderLg floatR'>
					<div class='topBrands searching-for'>
						<div class='topBrandsHeader'><div class'floatL'>Searching for: <?php echo $search_supplier_products ? $search_supplier_products : $search_name; ?></div>
						</div>
					</div>

					<div class='right-inner clearfix'>


						<div id='result-product-maincont'>

						</div>
					</div>

					<div class='right-inner clearfix'>
						<div class='topBrands searching-for'>
							<div class='topBrandsHeader'><div class'floatL'>Most Popular & Featured Products</div>
							</div>
						</div>

						<?
						if(count($random_products)>0) {
							$num = 1;
							foreach($random_products as $product) {
								if($num%3 == 1 && $num != 0) echo "<div style='width:1px;' class='clear'></div>";
								$num++;
							?>
							<div class="prod-list-cont fl">
								<div class="img-feat-prod-list-cont">
									<?  if(isset($product->ii_link) and $product->ii_link!="" and file_exists($_SERVER['DOCUMENT_ROOT'].'/'.str_replace('http://'.$_SERVER['HTTP_HOST'].'/', '', base_url().$product->ii_link))) { ?>
										<a href="<?php echo base_url()?>inventory/detail/<?=$product->i_id; ?>">
											<img src="<?php echo base_url().$product->ii_link;?>" width="100%" />
										</a>
									<? } else { ?>
										<a href="<?php echo base_url()?>inventory/detail/<?=$product->i_id; ?>">
											<img src="<?php echo base_url()?>images/default-preview.jpg" width="100%" />
										</a>
									<? }?>
								</div>
								<div class='quick-detail-prod-list'>
									<h5>
										<a href="<?php echo base_url()?>inventory/detail/<?=$product->i_id; ?>"><? echo $product->tr_title; ?></a>
									</h4>
									<div class="clear"> </div>
									<p>
										<?php if($this->session->userdata('is_login') == TRUE) { ?>
										<span>Price:</span> <? echo $product->ic_price; ?> /
										<?php } ?>
										<?php if($inv->ic_retail_price != 0) { ?>
										<span>RRP:</span> <? echo $product->ic_retail_price; ?>
										<?php } ?>
									</p>
										<?php if($inv->ic_retail_price != 0) { ?>
									<div class="hr-orange"> </div>
									<p>Estimated profit: <? echo round((($product->ic_retail_price - $product->ic_price)/$product->ic_price)*100) ?>%</p>
										<?php } ?>

								</div>
							</div>
							<? } ?>
						<? } ?>

						<div class="clear"></div>

						<!--<div class="navi-feat fr">
							<a class="left-navi" href='#'></a>
							<a class="right-navi" href='#'></a>
						</div>-->

					</div>



				</div>
				<!-- RIGHT CONTENT CONTAINER-->

		<!-- MIDDLE PAGE CONTAINER-->
<script type="text/javascript">


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