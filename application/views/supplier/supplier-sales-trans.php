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
							<div class'floatl'=""> My Sales </div>
						</div>
					</div>

					<div class='padded-cont'>
						<div class='informative-format'>

							<label>Your statement for:</label>
							<select id='status-payment' class='normal-format-text' style='width:120px;'>
										<option value=''>All</option>
										<option value='0'>Pending/Buyer Approved Shipping Fee</option>
										<option value='-2'>Pending buyer's consent for new shipping fees</option>
										<option value='-1'>Cancelled Order</option>
										<option value='-4'>Return Order</option>
										<option value='-3'>Refund Order</option>
										<option value='1'>Shipped</option>
										<option value='2'>Completed</option>
							</select>
							<div class='clear'></div>
							<label>Within:</label>
							<select class='range_sel_week normal-format-text' style='width:220px;'>
								<?php echo $this->suppliers->generate_range_option($range_week, "M d, Y"); ?>
							</select>

							<div class='sales-result-trans clearfix'>

							</div>

						</div>
					</div>

				</div>


			</div>

<script type="text/javascript">

	var sel_date = $('.range_sel_week').val();

	$('.range_sel_week').change(function(){
		sel_date = $('.range_sel_week').val();
		load_payment_list();
	});


	load_payment_list();

	function load_payment_list()
	{
		var stats_payment = $('#status-payment').val();

		$.post('<?php echo base_url()?>sale/report',{type:'byweek-transaction',date:sel_date,stats_payment:stats_payment,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
			$('.sales-result-trans').html(result);
		});
	}

</script>
<?php echo $this->load->view('supplier/footer') ?>