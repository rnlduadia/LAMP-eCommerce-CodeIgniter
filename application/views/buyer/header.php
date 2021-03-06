<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Oceantailer</title>
	<link href='<?php echo HTTP_PROTOCOL;?>://fonts.googleapis.com/css?family=Open+Sans+Condensed:light&v1' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo base_url()?>css/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url()?>css/jquery.tablesorter.pager.css">
	<!-- <link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.min.css"> -->
	<script src="<?php echo base_url()?>css/bootstrap/js/jquery.js"></script>
	<script src="<?php echo base_url()?>css/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url()?>css/bootstrap/jquery.flexslider-min.js">

	</script>
	<script src="<?php echo base_url()?>js/scripts.js"></script>
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/bootstrap/flexslider.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/bootstrap/filter_style.css">
	<link href='<?php echo HTTP_PROTOCOL;?>://fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>

<link rel="css/common.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/reset.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/nav.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/bootstrap/main.css">
<script src="<?php echo HTTP_PROTOCOL;?>://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript">  
	 	// Resize body Image Dynamically
	<?php if($this->uri->segment(1) == 'buyer' && (!$this->uri->segment(2) || $this->uri->segment(2) == 'index') ) { ?> jQuery.noConflict();<?php } ?>
	$(window).load(function() {
		setSizes();
		if($('.carousel_1').length) $('.carousel_1').flexslider({
	            animation: "slide",
		    controlNav: false,
		    animationLoop: false,
		    slideshow: false,
		    itemWidth: 190,
		    itemMargin: 8,
		    asNavFor: '#slider_1'
      		});

		if($('.carousel_2').length) $('.carousel_2').flexslider({
	            animation: "slide",
		    controlNav: false,
		    animationLoop: false,
		    slideshow: false,
		    itemWidth: 190,
		    itemMargin: 8,
		    asNavFor: '#slider_2'
      		});

		if($('.carousel_3').length) $('.carousel_3').flexslider({
	            animation: "slide",
		    controlNav: false,
		    animationLoop: false,
		    slideshow: false,
		    itemWidth: 190,
		    itemMargin: 8,
		    asNavFor: '#slider_3'
      		});

		if($('.carousel_4').length) $('.carousel_4').flexslider({
	            animation: "slide",
		    controlNav: false,
		    animationLoop: false,
		    slideshow: false,
		    itemWidth: 190,
		    itemMargin: 8,
		    asNavFor: '#slider_4'
      		});

		if($('#slider').length) $('#slider').flexslider({
		    animation: "slide",
		    controlNav: false,
		    animationLoop: false,
		    slideshow: false,		    
		    sync: "#carousel",	   
		});
	});
		function setSizes() {
			var containerHeightleft = $("#left-sidebar").height();
			var containerHeightright = $(".right-cont").height();
		   if(containerHeightleft > containerHeightright)
		   		$(".bg-body-middle").height(containerHeightleft - 158);
		   else
		   		$(".bg-body-middle").height(containerHeightright - 158);
		}
		
		function setSizesDynamic(){

		   var containerHeight = $(".right-cont").height();
		   $(".bg-body-middle").height(containerHeight - 158);
		}


	</script>


	<!-- Below is the code to call Gallerie image viewer -->
	<!--  <script type="text/javascript" src="<?php echo base_url();?>js/jquery.gallerie.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/gallerie.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/gallerie-effects.css"/>

	<script type="text/javascript">
	$(document).ready(function(){
		$('div.inner-img-prod-list').gallerie();
	});
	</script>-->

		<!-- Below is the to code call Magnific Popup image viewer -->
	<link rel="stylesheet" href="<?php echo base_url();?>css/magnific-popup.css">
	<script src="<?php echo base_url();?>js/jquery.magnific-popup.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){

		function checkLocation(){
			var user_name_rpos = parseInt($("body").offset().left + $("body").width());
			var page_rpos = parseInt($("#page").offset().left + $("#page").width());
			if(user_name_rpos < page_rpos) {
				$("#header").css('position', 'relative');
				$("#header-user").css('position', 'absolute');
				$("#header-user").css('float', 'right');
				$("#header-user").css('right', '0');
				$("#header-user").css('width', '250px');
				$("#header-user").css('top', '-35px');
			}
			else {
				$("#header").css('position', '');
				$("#header-user").css('position', '');
				$("#header-user").css('clear', 'both');
				$("#header-user").css('width', '');
				$("#header-user").css('top', '0');
			}
		}
		$(window).resize(function() {
			checkLocation();
		});
		checkLocation();


		$('.gallery-item').magnificPopup({delegate:'a',
		  type: 'image',
		  gallery:{
		    enabled:true
		  }
		});

	});
	</script>

</head>
<body class="body-wrapper">
<div id="page">
	<div id="header">
	
		<div id="header-user" class="member-login header-user floatR">
			<ul class="top-header-menu clearfix">
				<li class="user">
					<div class='floatR'><?php echo $this->session->userdata('fname').' '.$this->session->userdata('lname')?> (<a href="<?php echo base_url()?>user/logout">sign out</a>)</div>
				</li>
				<li class='cart'>
					<div class='floatR'> 
						<p>Your cart: <a href='<?php echo base_url()?>cart'> <span id='num-total-item'> <?php echo $this->cart->total_items() ?> </span> items </a></p>
					</div>
				</li>
			</ul>
		</div>
	<div class="logo floatL"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>images/logo.png" /></a></div>
	<div class="input-group header-group">
		<div class="search floatL"><form action="/inventory/search/product/" method="get"><input type='hidden' name='cat' value=''>
			<div class="search-box">
			    <div class="input-group">
			      <div class="input-group-btn">
			        <button type="button" class="btn btn-default dropdown-toggle btn-action" data-toggle="dropdown"><span id="chosencat"><?= ($search_selected) ? $search_selected : 'Category'; ?></span> &nbsp;&nbsp;&nbsp;<span class="caret catDropIcon"></span></button>
			        <ul class="dropdown-menu">
				  <li class="hidden"><a data-id='' href="#">Category</a></li>
				<?php foreach($feat_categories as $feat_category){ if($feat_category->c_is_active){?>
				  <li><a data-id="<?=$feat_category->c_id?>" href="#<?php// echo base_url().'category/info/0/'.$feat_category->c_link;?>"><?=$feat_category->c_name?></a></li>
				<?php }} ?>
			        </ul>
			      </div>
			      <input type="text" class="form-control search-field">
			      <span class="input-group-addon search-icon"><span class="glyphicon glyphicon-search"></span></span>
			    </div>  
			</div></form>
		</div>
		
	</div>
	</div>
	<div id="content">
<!--	<div id='head' class="global-cont">

		<div class="fl clearfix">
			<a id='logo' href="<?php echo base_url()?>"></a>
		</div>-->

		<!-- -TOP RIGHT HEADER -->
<!--		<div class="fr clearfix">
			<ul class="top-header-menu clearfix">
				<li class="user">
					<p><?php echo $this->session->userdata('fname').' '.$this->session->userdata('lname')?> (<a href="<?php echo base_url()?>user/logout">sign out</a>)</p>
				</li>
				<li>
					<div class='fl cart-icon'>
						<p><img src='<?php echo base_url()?>images/cart-top.png'></p>
					</div>
					<div class='fl'> 
						<p>Your cart: <a href='<?php echo base_url()?>cart'> <span id='num-total-item'> <?php echo $this->cart->total_items() ?> </span> items </a></p>
					</div>
				</li>
			</ul>
		</div>-->
		<!-- END TOP RIGHT HEADER -->
<!--	</div>


	<div class="clear"> </div>

	<div class="global-cont">

		<div class="main-menu">
			<ul class="m-left fl">
				<li class="home"><a href="<?php echo base_url()?>">Home</a></li>
				<li><a href="<?php echo base_url()?>buyer/profile/buyer/view">My Account</a></li>
			</ul>

			<ul class="m-right fr">
				<li><a href="<?php echo base_url()?>buyer/inbox">Messages</a></li>
				<li><a href="buyer/contact_us.php">Support</a></li>
				<li><a href="#">ENG<div class="eng fr"></div></a></li>
				<li><a href="/about_us.php">About Us</a></li>
			</ul>
		</div>
	</div>-->