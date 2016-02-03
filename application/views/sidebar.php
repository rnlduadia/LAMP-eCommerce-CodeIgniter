
<?php if(count($left_categories) != 0) { ?>
<ul class="nav-items categories">
	<?php foreach($left_categories as $cat){ if(!$cat->c_is_active) continue;?>
		<li class='category-group'><input type="checkbox" class="radio-style categoryside" name='categoryside[]' value='<?php echo $cat->c_id ?>' id='cat<?php echo $cat->c_id ?>'/><label class='sidebar-category' for="cat<?php echo $cat->c_id ?>"><a href='<?php echo base_url().'category/info/0/'.$cat->c_link?>'><?php echo substr($cat->c_name,0,18) ?></a><div class='first_container'>
			<?php $subcat1 =  $this->categories->listings(1, $cat->c_id);?>
			<?php if(count($subcat1) != 0){?>
			<ul class="nav-items">
<!--			<li>Category</li>-->
			<?php foreach($subcat1 as $subhead){ if(!$subhead->c_is_active) continue;?>
					<li><input type="checkbox" class="radio-style categoryside" name='categoryside[]' value='<?php echo $subhead->c_id ?>' id='cat<?php echo $subhead->c_id ?>'/><label for="cat<?php echo $subhead->c_id ?>"><a href='<?php echo base_url().'category/info/1/'.$cat->c_link.'/'.$subhead->c_link?>'><?php echo $subhead->c_name ?></a></label><div>
					<?php $subcat2 =  $this->categories->listings(2, $subhead->c_id); ?>
					<?php if(count($subcat2) != 0){ ?>
						<ul class='nav-items2'>
						<?php foreach($subcat2 as $subhead2){ if(!$subhead2->c_is_active) continue;?>
							<li><input type="checkbox" class="radio-style categoryside" name='categoryside[]' value='<?php echo $subhead2->c_id ?>' id='cat<?php echo $subhead2->c_id ?>'/><label for="cat<?php echo $subhead2->c_id ?>"><a href='<?php echo base_url().'category/info/2/'.$cat->c_link.'/'.$subhead->c_link.'/'.$subhead2->c_link?>'><?php echo $subhead2->c_name ?></a></label>
						<?php } ?>
						</ul>
					<?php } ?>
					</div></li>
				<?php }?>
			</ul>
			<?php }?>	</div></label>
		</li>
	<?php }?>
</ul>
<?php }?>

<?php /*if(count($manus) != 0) { ?>
		<ul class="nav-items">
		<li>Brands</li>
			<?php foreach($manus as $manu){?>
				<li><input type="checkbox" class="radio-style manuside" name='manuside[]' id='brand<?php echo $manu->m_id?>' value='<?php echo $manu->m_id?>' /><label for="brand<?php echo $manu->m_id?>"><?php echo $manu->m_name?></label></li>
			<?php } ?>
		</ul><br/>
<?php }*/?>



<?php if($this->session->userdata('is_login') == TRUE){?>
<div class="filter-item">
	<label>Prices:</label>
	<div class="clear"></div>
	<input type='text' value="<?php if(isset($search_price_from)){echo $search_price_from;}else{ ?>From<?php }?>" onblur="if(this.value=='') this.value='From';" onfocus="if(this.value=='From') this.value='';" id='price-from' class='floatL filterInput filterPrices' />
	<input type='text' value="<?php if(isset($search_price_to)){echo $search_price_to;}else{ ?>To<?php }?>" onblur="if(this.value=='') this.value='To';" onfocus="if(this.value=='To') this.value='';" id='price-to' class='floatL filterInput filterPrices' />
	<button id='search-price-range' class="floatL btn btn-filter"> <span class="glyphicon glyphicon-search"></span></button>
</div>
<?php }?>

<?php if( !isset($only_price)) { ?>
<div class="filter-item">
	<label>Supplier:</label>
	<select id='supplier-sel' class="floatL filterInput filterProduct">
				<option value="">All</option>
				<?php foreach($suppliers as $sup){?>
					<option value="<?php echo $sup->u_id?>" <?php if(isset($search_name) && $this->uri->segment(3) == "supplier" && $this->uri->segment(4) == $sup->u_id) echo 'selected'?>><?php echo $sup->u_company/*substr($sup->u_company,0, 10)*/; ?></option>
				<?php }?>
	</select>
	<button class="floatL btn btn-filter" id='supplier-info'> <span class="glyphicon glyphicon-search"></span></button></button>
</div>


<?php }?>

<?php if( !isset($only_price)){?>

<?
	if(isset($product->b_name) and $product->b_name!="") {
		$search_name = $product->b_name;
	}
?>

<div class="filter-item">
	<label>Brand:</label>
	<input type='text' value="<?php if(isset($search_name) && $this->uri->segment(3) == "brand"){echo $search_name;}else{echo 'Search...';}?>" onblur="if(this.value=='') this.value='Search...';" onfocus="if(this.value=='Search...') this.value='';" id="search-brand" class='floatL filterInput filterProduct' />
	<button id='search-info-brand' class="floatL btn btn-filter"> <span class="glyphicon glyphicon-search"></span></button></button>
</div>



<?php }?>
<?php if( !isset($only_price)){?>

<?
	if(isset($product->m_name) and $product->m_name!="") {
		$search_name = $product->m_name;
	}
?>

<div class="filter-item">
	<label>Manufacturer:</label>
	<input type='text' value="<?php if(isset($search_name) && $this->uri->segment(3) == "mf"){echo $search_name;}else{echo 'Search...';}?>" onblur="if(this.value=='') this.value='Search...';" onfocus="if(this.value=='Search...') this.value='';" id="search-mf" class='floatL filterInput filterProduct' />
	<button id='search-info-mf' class="floatL btn btn-filter"> <span class="glyphicon glyphicon-search"></span></button></button>
</div>


<?php }?>

<?php
	if(isset($search_type) and $search_type!="") {
		$search_ajax_type = $search_type;
	} else {
		$search_ajax_type = "";
	}
?>


<script type="text/javascript">
	$(window).load(function() {

		var ary_cat = [];
		var ary_manu = [];

		var from = '';
		var to = '';
		var supplier = '';

		search_function('<? echo $search_ajax_type ?>');
		function search_function(search_ajax_type){
			if(search_ajax_type == "brand") {
				$.post('<?php if(isset($dym_link)){ echo $dym_link;} ?>',{action:'get',cat:ary_cat,manu:ary_manu,from:from,to:to,supplier:supplier,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
					if(result != '')
						$('#result-product-maincont').html(result);
					else
						$('#result-product-maincont').html('');
				});
			}
			else if(search_ajax_type == "mf") {
				$.post('<?php if(isset($dym_link)){ echo $dym_link;} ?>',{action:'get',cat:ary_cat,manu:ary_manu,from:from,to:to,supplier:supplier,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
					if(result != '')
						$('#result-product-maincont').html(result);
					else
						$('#result-product-maincont').html('');
				});
			}
			else {
				from = $('#price-from').val();
				to = $('#price-to').val();
				var supplier = $("#supplier-sel").val();
				var supplier_name = '';
				if(supplier) supplier_name = $("#supplier-sel option:selected").text();


				if(isNumber(from))
					from = $('#price-from').val();
				else
					from = "";

				if(isNumber(to))
					to = $('#price-to').val();
				else
					to = "";

				$.post('<?php if(isset($dym_link)){ echo $dym_link;} ?>',{action:'get',cat:ary_cat,manu:ary_manu,from:from,to:to,supplier:supplier,supplier_name:supplier_name,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
					if(result != '')
						$('#result-product-maincont').html(result);
					else
						$('#result-product-maincont').html('');
				});
			}
		}

		function isNumber(value) {
		    if ((undefined === value) || (null === value)) {
		        return false;
		    }
		    if (typeof value == 'number') {
		        return true;
		    }
		    return !isNaN(value - 0);
		}

		$('#search-prod').keyup(function(){
			var val = this.value;

			if(val == 'Search...' || val == '');
			else
				$.post('<?php echo base_url()?>inventory/search/quick',{val:val,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
					if(result != '')
						$('#search-prod-result').html(result);
					else
						$('#search-prod-result').html('');
				});
		});

		$('#search-input').click(function(){
			var val = $('#search-prod').val();
			if(val == 'Search...' || val == '');
			else
				$(window.location).attr('href', "<?php echo base_url()?>inventory/search/product/"+val);
		});

		$('#price-from, #price-to').keypress(function(event){
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
			    event.preventDefault();
			}

		});

		$('#search-price-range').click(function(){

			from = $('#price-from').val();
			to = $('#price-to').val();

			if(<?php if(isset($search_page)){ echo 1;}else{ echo 0;}?>)
				search_function();
			else
			{
				if(isNumber(to) && isNumber(from)) {
					var val = $('#search-prod').val();
					if(val == 'Search...' || val == '')
						val = '';
					else
						val = $('#search-prod').val();
					$(window.location).attr('href', "<?php echo base_url()?>inventory/search/price/"+from+'/'+to);
				}
			}

		});

		$('#supplier-info').click(function(){
			var id = $('#supplier-sel').val();
			var supplier = id;
/*			if(<?php if(isset($search_page)){ echo 1;}else{ echo 0;}?>)
				search_function();
			else {
				$(window.location).attr('href', "<?php echo base_url()?>supplier/detail/"+id);
			}*/

			if(id == '');
			else {
//				$(window.location).attr('href', "<?php echo base_url()?>supplier/detail/"+id);
				$(window.location).attr('href', "<?php echo base_url()?>inventory/search/supplier/"+id);
			}


		});

		$('.categoryside').click(function(){
			ary_cat = [];
	        $('.categoryside:checkbox:checked').each(function(i)
	        {
	        	ary_cat[i] = $(this).val();
	        });;
	        search_function();
		});

		$('.manuside').click(function(){
			ary_manu = [];
	        $('.manuside:checkbox:checked').each(function(i)
	        {
	        	ary_manu[i] = $(this).val();
	        });;
	        search_function();
		});

		$('#search-info-brand').click(function(){
			var val = $('#search-brand').val();
			if(val == 'Search...' || val == '');
			else {
				$(window.location).attr('href', "<?php echo base_url()?>inventory/search/brand/"+val);
			}
		});
		$('#search-info-mf').click(function(){
			var val = $('#search-mf').val();
			if(val == 'Search...' || val == '');
			else {
				$(window.location).attr('href', "<?php echo base_url()?>inventory/search/mf/"+val);
			}
		});

	});

	function redirect_product(id) {
		$(window.location).attr('href', "<?php echo base_url()?>inventory/detail/"+id);
	}
</script>