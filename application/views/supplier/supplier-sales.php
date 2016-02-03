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
							<select class='range_sel_week normal-format-text' >
								<?php echo $this->suppliers->generate_range_option($range_week, "M d, Y"); ?>
							</select>

							<div class='sales-result clearfix'>

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

		$.post('<?php echo base_url()?>sale/report',{type:'byweek',date:sel_date,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
			$('.sales-result').html(result);
		});
	}

</script>
<?php echo $this->load->view('supplier/footer') ?>