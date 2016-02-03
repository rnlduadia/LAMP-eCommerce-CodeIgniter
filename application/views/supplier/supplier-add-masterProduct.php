<?php echo $this->load->view('supplier/header') ?>
<script src="<?php echo base_url()?>js/organictabs.jquery.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/uploadify/uploadify.css" />
<script type="text/javascript" language="javascript" src="<?php echo HTTP_PROTOCOL;?>://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
<!--
<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
-->
<script type="text/javascript" src="<?php echo base_url();?>js/uploadify/jquery.uploadify.min.js"></script>
<script src="<?php echo base_url()?>js/imgpreview.full.jquery.js" type="text/javascript"></script>

			<!-- LEFT SIDEBAR CONTAINER-->
			<div class="nav-bar floatL">

				<?php echo $this->load->view('supplier/sidebar');?>

			</div>

			<!-- RIGHT CONTENT CONTAINER-->
			<div class='sliderLg floatR'>
				<div class="prodinfoblock prodininfo">

<!--PRODUCT PAGE CONTAINER-->
	<div id="supplier-product-tab">

		<ul class="nav">
	        <li class="nav-one">
	        	<a href="#featured" class="current">
					<div class="head-tab fl">
						<div class="tab-center fl">
							<p class="fl">Classification</p>
						</div>
					</div>
	        	</a>
	        </li>
	        <li class="nav-two">
	        	<a href="#basic">
	        		<div class="head-tab fl">
						<div class="tab-center fl">
							<p class="fl">Basic Information</p>
						</div>
					</div>
	        	</a>
	        </li>
	        <li class="nav-three">
	        	<a href="#stock">
	        		<div class="head-tab fl">
						<div class="tab-center fl">
							<p class="fl">Stock</p>
						</div>
					</div>
	        	</a>
	        </li>
	        <li class="nav-four">
	        	<a href="#description">
	        		<div class="head-tab fl">
						<div class="tab-center fl">
							<p class="fl">Description</p>
						</div>
					</div>
	        	</a>
	        </li>
	        <li class="nav-five">
	        	<a href="#extra">
	        		<div class="head-tab fl">
						<div class="tab-center fl">
							<p class="fl">Extra Information</p>
						</div>
					</div>
	        	</a>
	        </li>
	        <li class="nav-six">
	        	<a href="#images">
	        		<div class="head-tab fl">
						<div class="tab-center fl">
							<p class="fl">Images</p>
						</div>
					</div>
	        	</a>
	        </li>

	    </ul>

		<div class="list-wrap">

			<ul id="featured">
				<li>
					<div class='product-cont padded-cont clearfix'>
						<h3>Classification</h3>
						<div class="fl clearfix">
							<div class="clear"> </div>
							<div id="category-breadcrumbs">  </div>
							<div class="clear"> </div>
							<div id='category-main-cont' class='clearfix'>
								<div class="category-selectable-cont fl clearfix" id='category-level-0'>
									<?php if(count($categories) != 0)
										{ ?>
											<?php foreach($categories as $category){
												$number_sub = count($this->categories->listing_subcategory($category->c_id));
											?>
											<div id="cat-sel<?php echo $category->c_id?>" onclick=<?php echo "'return select_category(".$category->c_id.",\"".$category->c_name."\",".$category->c_level.")'"?> value="<?php echo $category->c_id?>"><?php echo $category->c_name?>(<?php echo $number_sub?>)</div>
											<?php }?>
									<?php }?>
								</div>
							</div>
						</div>
						<div class="clear"> </div>
						<div class='floatR'><br/>
							<button class='greenbutton' id='step_2'>NEXT</button>
						</div>
					</div>
				</li>
			</ul>

			<ul id="basic" class="hide1" style='display:none'>
	            <li>
					<div class='product-cont padded-cont clearfix'>
						<h3>Basic Information</h3>


						<div class="fl half clearfix">
							<label for='manu'>Manufacturer</label>
							<div class='clearfix'>
								<input type="hidden" name="search_manufacturer_flag" id="search_manufacturer_flag" value="" />
								<input type='text' value='' id='search-manufacturer' onblur="call_mf(this.value);" />
								<div class='float-dropdown' id='search-manu-result'> </div>
							</div>
							<div class="clear"> </div>
						</div>

						<div class="fl half clearfix">
							<label for='brand'>Brand</label>
							<div class='clearfix'>
								<input type="hidden" name="search_brand_flag" id="search_brand_flag" value="" />
								<input type='text' value='' id='search-brand' onblur="call_brand(this.value);" />
								<div class='float-dropdown' id='search-brand-result'></div>
							</div>
							<div class="clear"> </div>
						</div>

						<div class="fl half clearfix">
							<label for='upc_ean'>UPC/EAN</label>
							<div class="clear"> </div>
							<input type="text" id='upc_ean'/>
						</div>
						<div class="fl half clearfix">
							<label for='manu_num'>Manufacturer Part Number</label>
							<div class="clear"> </div>
							<input type="text" id='manu_num'/>
						</div>

						<div class="fl half clearfix">
							<label for='ship_alone'>Ship Alone?</label>
							<div class="clear"> </div>
							<select id='ship_alone'>
								<option value=1>Yes</option>
								<option value=0 selected="selected">No</option>
							</select>
						</div>
<!--						<div class="fl half clearfix">
							<label for='trans-title'>Title</label>
							<div class="clear"> </div>
								<input type="text" id='trans-title' value=""/>
						</div>-->
						<!--
						<div class="fl half clearfix">
							<label for='sup_fee'>Supplier Fee</label>
							<div class="clear"> </div>
							<input type="text" id='sup_fee' value=""/>
						</div>
						-->
						<div class="clear"> </div>
						<div class='floatR'><br/>
							<button class='greenbutton' id='step_3'>NEXT</button>
						</div>
					</div>
	            </li>
			</ul>

			<ul id="stock" class="hide1" style='display:none'>
			    <li>
					<div class='product-cont padded-cont clearfix'>
						<h3>Stock Offer</h3>


						<div class="fl half">
							<label for='sku'>Seller SKU*</label>
							<div class="clear"> </div>
							<input type="text" id='sku'/>
						</div>
						
						<div class="fl half">
							<label for='quan'>Quantity*</label>
							<div class="clear"> </div>
							<input type="text" id='quan' value='1' />
						</div>
						<div class="clear"> </div>
						<div class="fl half">
							<label for='price'>Price*</label>
							<div class="clear"> </div>
							<input type="text" id='price' />
						</div>
						
						<div class="fl half">
							<label for='ret_price'>Retail Price*</label>
							<div class="clear"> </div>
							<input type="text" id='ret_price' />
						</div>

						<div class="clear"> </div>
						<div class="fl half">
							<label for='map'>MAP(Minimum Advertized Price)</label>
							<div class="clear"> </div>
							<input type="text" id='map' />
						</div>

						
						<div class="fl half">
							<label for='ship_cost'>Shipping Cost</label>
							<div class="clear"> </div>
							<input type="text" id='ship_cost' value=0 />
						</div>

						<div class="clear"> </div>
						<div class="fl half">
							<label for='ship_from'>Shipping From</label>
							<div class="clear"> </div>

							<select id='ship_from'>
							<?php foreach($countries as $country){?>
								<option <?php if($default_country == $country->c_id){ ?> selected='selected'  <?php }?>value='<?php echo $country->c_id?>'><?php echo  $country->c_name?></option>
							<?php }?>
							</select>
						</div>

						<div class="fl half">
							<label for='lead_time'>Lead Time*</label>
							<div class="clear"> </div>
							<input type="text" id='lead_time' />
						</div>

						<div class="clear"></div>
						<div class="fl half">
							<label for='case_pack'>Case Pack</label>
							<div class="clear"> </div>
							<input type="text" id='case_pack' />
						</div>

						<div class="fl half">
							<label for='min_order'>Min Order Qty</label>
							<div class="clear"> </div>
							<input type="text" id='min_order' />
						</div>

						<div class="clear"> </div>
						<div class="clearfix">
							<label for='prom_text'>Promotional Text</label>
							<div class="clear"> </div>
							<textarea id='prom_text' class="normal-format-text full-ta"></textarea>
						</div>
						<div class="clear"></div>
						<div class='floatR'><br/>
							<button class='greenbutton' id='step_4'>NEXT</button>
						</div>
						<!---->
					</div>
			    </li>
			</ul>

			<ul id="description" class="hide1" style='display:none'>
	            <li>
	            	<div class='product-cont padded-cont clearfix'>
						<h3>Description</h3>
						<br/>
						<div class="fl full clearfix">
							<label for='trans-title'>Title</label>
							<div class="clear"> </div>
								<input type="text" id='trans-title' value=""/>
						</div>
						<div class='desc-cont-inner'>
							<!--
							<div class="fl full clearfix">
								<label for='trans-short-desc'>Short Description</label>
								<div class="clear"> </div>
								<textarea id='trans-short-desc'>

								</textarea>
							</div>
							-->
							<div class="fl full clearfix">
								<label for='trans-desc'>Main Decription</label>
								<div class="clear"> </div>
								<textarea id='trans-desc' rows='10'></textarea>
							</div>
							<div class="clear"></div>
							<div class="fl half clearfix">
								<?php foreach($countries as $country){?>
									<?php if($default_country == $country->c_id){ ?>
										<input type="text" readonly='readonly' value="<?php echo $country_sel_name = $country->c_name?>"/>
										<input type='hidden' id="trans-lang" value="<?php echo $country->c_id?>"/>
									<?php }?>
								<?php }?>
								<div class="clear"> </div>
							</div>
							<div class='note-p'><i>Note: Language is set by default to English United States. Additional language for the description can be set after saving the product</i></div>

						</div>
						<div class="clear"> </div>
						<div class='floatR'><br/>
							<button class='greenbutton' id='step_5'>NEXT</button>
						</div>
					</div>
	            </li>
	        </ul>

			 <ul id="extra" class="hide1" style='display:none'>
			    <li>
					<div class='product-cont padded-cont clearfix'>
						<h3>Weight Details</h3>

						<div class="fl half clearfix">
							<label for='weight'>Weight</label>
							<div class="clear"> </div>
							<input type="text" id='weight'/>
						</div>

						<div class="fl half clearfix">
							<label for='weight_scale'>Weight Scale</label>
							<div class="clear"> </div>
							<select id="weight_scale">
								<?php foreach($list_scale as $scale){?>
								<option <?php if($scale->scale_name == "Pounds"){echo 'selected="selected"';}?>  value="<?php echo $scale->scale_name?>"><?php echo $scale->scale_name?></option>
								<?php }?>
							</select>
						</div>
						<h3>Dimension Details</h3>
						<div class="fl half clearfix">
							<label for='height'>Height</label>
							<div class="clear"> </div>
							<input type="text" id='height'/>
						</div>

						<div class="fl half clearfix">
							<label for='width'>Width</label>
							<div class="clear"> </div>
							<input type="text" id='width'/>
						</div>

						<div class="fl half clearfix">
							<label for='depth'>Depth</label>
							<div class="clear"> </div>
							<input type="text" id='depth'/>
						</div>

						<div class="fl half clearfix">
							<label for='dimension_scale'>Dimension Scale</label>
							<div class="clear"> </div>
							<select id="dimension_scale">
								<?php foreach($scale_dimension as $dimension){?>
								<option value="<?php echo $dimension->sd_name?>"><?php echo $dimension->sd_name?></option>
								<?php }?>
							</select>
						</div>

						<div class="clear"> </div>
						<div class='floatR'><br/>
							<button class='greenbutton' id='step_6'>NEXT</button>
						</div>
					</div>
			    </li>
			 </ul>

			 <ul id="images" class="hide1" style="display: none;">
					<li>
						<div class='product-cont padded-cont clearfix'>

							<?php echo form_open_multipart('upload/index');?>
								<p>
									<label for="Filedata">Choose a File</label><br/>
									<?php echo form_upload(array('name' => 'Filedata', 'id' => 'upload'));?>
									<a href="javascript:$('#upload').uploadifyUpload();"></a>
								</p>
							<?php echo form_close();?>
							<div id="target-image-upload" class="images-cont clearfix">
								<?php //echo $this->load->view('admin/inventory/inventory-image-list',$data_link, true); ?>
							</div>

							<div class='floatR'><br/>
								<input type='button' class='greenbutton' id="submit-product" value="Save" />

							</div>
						</div>
					</li>
			</ul>
		 </div> <!-- END List Wrap -->

	 </div>
	<!-- PRODUCT PAGE CONTAINER END-->

			<!-- PRODUCT RESULT CONTAINER-->
			<div class="result-product-add fr">

			</div>
			<!-- PRODUCT RESULT CONTAINER END-->
				</div>
			</div>

<script type="text/javascript">

		var brand_sel = '';
		var manufacture_sel = '';
		var category_sel = '';
		var images = [];

		level = 0;

		$('#search-manufacturer').keyup(function(){
			var search_manu = $.trim(this.value);
			manufacture_sel = '';

			if(search_manu != '')
			{
				$.post('<?php echo base_url()?>manufacturer/search',{m_val:search_manu,type:'dropdown','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
					if(result == "NOT_FOUND") {
						$('#search_manufacturer_flag').val('1');
						$('#search-manu-result').html("");
					} else {
						$('#search-manu-result').html(result);
						$('#search_manufacturer_flag').val('0');
					}
				});
			}
			else {
				$('#search-manu-result').html('');
			}
		});

		function call_mf(mf) {

			if($('#search_manufacturer_flag').val()=="1") {
				if($.trim(mf)!="") {
					if(confirm($.trim(mf)+" manufacturer does not exist. Would you like to add and select?"))
					{
						add_manufacturer();
						$('#search_manufacturer_flag').val('0');
					} else {
						$('#search-manufacturer').val('');
					}
				}

			}
		}

		function call_brand(brand) {

			if($('#search_brand_flag').val()=="1") {
				if($.trim(brand)!="") {
					if(confirm($.trim(brand)+" brand does not exist. Would you like to add and select?"))
					{
						add_brand();
						$('#search_brand_flag').val('0');
					} else {
						$('#search-brand').val('');
					}
				}
			}
		}

		$('#search-brand').keyup(function(){
			var search_brand = $.trim(this.value);

			if(manufacture_sel == '')
			{
				alert('Select Manufacturer First');
				$('#search-brand').val('');
			}
			else
			if(search_brand != '')
			{
				$.post('<?php echo base_url()?>brand/search',{b_val:search_brand,m_val:manufacture_sel,type:'dropdown','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
					if(result == "NOT_FOUND") {
						$('#search_brand_flag').val('1');
						$('#search-brand-result').html("");
					} else {
						$('#search-brand-result').html(result);
						$('#search_brand_flag').val('0');
					}
				});
			}
			else
				$('#search-brand-result').html('');
		});

		function select_manufacture(id,name)
		{
			$('#search-manufacturer').val(name);
			manufacture_sel = id;
			$('#search-manu-result').html('');
		}

		function add_manufacturer()
		{
			var manufacture_name = $.trim($('#search-manufacturer').val());

			$.post('<?php echo base_url() ?>manufacturer/add',{manu_name:manufacture_name,action:'quickadd','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(id){
					manufacture_sel = id;
			});
			$('#search-manu-result').html('');
		}

		function select_brand(id,name)
		{
			$('#search-brand').val(name);
			brand_sel = id;
			$('#search-brand-result').html('');
		}

		function add_brand()
		{
			var name_brand = $.trim($('#search-brand').val());

			$.post('<?php echo base_url() ?>brand/add',{name:name_brand,manu_id:manufacture_sel,action:'quickadd','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(data){
					var  convert = JSON.parse(data);
					brand_sel = convert.b_id;
			});
			$('#search-brand-result').html('');
		}

		function select_category(id,name,lvl)
		{
			level = lvl+1;
			category_sel = id;
			for(var level_list = level+1; level_list < 20;level_list++)
			{
				$('#category-level-'+level_list).remove();
			}
			$.post('<?php echo base_url()?>category/detail',{id:id,level:level,view_type:'dropdown','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
				if ( $('#category-level-'+level).length){
					$('#category-level-'+level).remove();
				}
				$('#category-main-cont').append(result);
				setSizesDynamic();
			});

			$('.category-selectable-cont div').removeClass('active');
			$('#cat-sel'+category_sel).addClass('active');

			$.post('<?php echo base_url()?>category/detail',{id:id,level:level,view_type:'breadcrumbs','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
				$('#category-breadcrumbs').html(result);
				setSizesDynamic();
			});
			setSizesDynamic();
		}

		$('#submit-product').click(function(){
			var upc_ean = $('#upc_ean').val();
			var manu_num = $('#manu_num').val();

			var weight = $('#weight').val();
			var weight_scale = $('#weight_scale').val();
			//var sup_fee = $('#sup_fee').val();
			var ship_alone = $('#ship_alone').val();

			var height = $('#height').val();
			var width = $('#width').val();
			var depth = $('#depth').val();
			var d_scale = $('#dimension_scale').val();

			var manu = manufacture_sel;
			var brand = brand_sel;
			var category = category_sel;

			var lang_title =  $('#trans-title').val();
			var short_desc =  $('#trans-short-desc').val();
			var long_decs =  $('#trans-desc').val();
			var lang =  $('#trans-lang').val();

			//adding stock
			var sku =  $('#sku').val();
			var quan =  $('#quan').val();
			var price =  $('#price').val();
			var ret_price =  $('#ret_price').val();
			var lead_time =  $('#lead_time').val();
			var map =  $('#map').val();
			var ship_cost =  $('#ship_cost').val();
			var ship_from =  $('#ship_from').val();
			var prom_text =  $('#prom_text').val();
			var min_order = $("#min_order").val();
			var case_pack = $("#case_pack").val();

			$.post("<?php echo base_url()?>inventory/add",
				{upc_ean:upc_ean,manu_num:manu_num,manu:manu,brand:brand,
				weight:weight,weight_scale:weight_scale,ship_alone:ship_alone,
				height:height,width:width,depth:depth,d_scale:d_scale,category:category,
				lang_title:lang_title,short_desc:short_desc,long_decs:long_decs,lang:lang,
				sku:sku,quan:quan,price:price,ret_price:ret_price,lead_time:lead_time,map:map,ship_cost:ship_cost,ship_from:ship_from,prom_text:prom_text,
				action:'add',images:images, case_pack: case_pack, min_order:min_order,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'}, function(result){

				var  convert = JSON.parse(result);

				if(convert.status == 0) // has error input
				{
					$('.result-product-add').hide();
					$('.result-product-add').html(convert.message);
					$('.result-product-add').fadeIn();
					setSizesDynamic();
				}
				else
				{
					$(window.location).attr('href', ""+convert.message);
				}


			});

			setSizesDynamic();

		});

	$('#step_2').click(function(){
		if(category_sel !="")
		{
			$('.nav-two a').trigger('click');
		}
		else
			alert('Complete The Details');
		setSizesDynamic();
	});

	$('#step_3').click(function(){
		if(brand_sel != "" && manufacture_sel !="")
		{
			$('.nav-three a').trigger('click');
		}
		else
			alert('Fill Up Manufacturer and Brand');
		setSizesDynamic();
	});

	$('#step_4').click(function(){

		$('.nav-four a').trigger('click');
		setSizesDynamic();

	});

	$('#step_5').click(function(){

		$('.nav-five a').trigger('click');
		setSizesDynamic();
	});

	$('#step_6').click(function() {
		$('.nav-six a').trigger('click');
		setSizesDynamic();
	});

	$("#upload").uploadify({
		'swf'      : '<?php echo base_url();?>js/uploadify/uploadify.swf',
		'uploader' : '<?php echo base_url();?>js/uploadify/upload.php',
		'method'   : 'post',
		'buttonClass': '',
		'formData' : {'timestamp':<?php echo time(); ?>,'folder' : '<?php echo base_dir();?>product_image/'},
		'onUploadSuccess': function (file, data, response) {
			//Post response back to controller
			if(data=="FAILED" || data == 'Invalid file type.') { return false; }
			images.push({filename: data, featured: 0});
			$.post('<?php echo site_url('upload/new_product_attachment');?>',
			{fname: data,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},
			function(info){
				$("#target-image-upload").append(info);  //Add response returned by controller
				setSizesDynamic();
				$('#target-image-upload div a').imgPreview({
					containerID: 'imgPreviewWithStyles',
					imgCSS: {
						// Limit preview size:
						height: 200
					},
					// When container is shown:
					onShow: function(link){
					$('<span>' + $(link).text() + '</span>').appendTo(this);
					},
					// When container hides:
					onHide: function(link){
						$('span', this).remove();
					}
				});
			});
		}
	});



	function setSizesDynamic(){

	   var containerHeight = $(".right-cont").height();
	   $(".bg-body-middle").height(containerHeight - 158);
	}



    $(function() {

        $("#supplier-product-tab").organicTabs();

    });

    function set_featured(id){
		for(var index in images) {
			if(images[index].filename == id) {
				images[index].featured = 1;
				return false;
			}
		}
		return false;
	}

	function delete_image(id)
	{
		$.post('<?php echo base_url()?>upload/delete_product_attachment',{fname: id,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'}, function(data){
			for(var index in images) {
				if(images[index].filename == id) {
					delete images[index];
				}
			}
			$('div[rel="' + id + '"]').remove();
			$('#imgPreviewWithStyles').remove();
			return false;
		});
		return false;
	}

</script>

<?php echo $this->load->view('supplier/footer'); ?>