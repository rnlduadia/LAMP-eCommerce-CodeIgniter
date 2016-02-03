<?php echo $this->load->view('supplier/header') ?>

			<!-- LEFT SIDEBAR CONTAINER-->
			<div class="nav-bar floatL">

				<?php echo $this->load->view('supplier/sidebar');?>

			</div>

			<!-- RIGHT CONTENT CONTAINER-->
			<div class='sliderLg floatR'>

				<div class='right-inner clearfix'>
					<div class="topBrands searching-for">
						<div class="topBrandsHeader">
							<div class'floatl'="">Search if product exists currently in OceanTailer’s catalog:</div>
						</div>
					</div>


					<div class="search-top-product clearfix">
						<label>upc/EAN/MANUFACTURER PART NUMBER</label>
						<input id="search-product" class='normal-format-text' value="" />
						<button id='search-item' class='normal-button'>SEARCH</button>
						<div class='clear'></div>
						<p class='fl link-addmaster'>If it is not in Oceantailer's Inventory:
							<a href="<?php echo base_url()?>inventory/add">Add Product</a>
						</p>
					</div>

				</div>

				<div class='right-inner clearfix'>
					<div class="topBrands searching-for">
						<div class="topBrandsHeader">
							<div class'floatl'="">Search result: </div>
						</div>
					</div>

					<div id='search-result-product' class='clearfix'>

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
				setSizes();
			});

			setSizes();

		});
	});
</script>
<?php echo $this->load->view('supplier/footer') ?>