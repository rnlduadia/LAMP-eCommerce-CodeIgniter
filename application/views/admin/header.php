<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Oceantailer</title>
<link rel="css/common.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>admin/css/reset.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>admin/css/nav.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>admin/css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/jquery.tablesorter.pager.css"/>
<script src="<?php echo HTTP_PROTOCOL;?>://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/scripts.js"></script>

	<script type="text/javascript">
	 	// Resize body Image Dynamically

		$(window).load(function() {
			setSizes();
		});

		function setSizes() {
			   var containerHeight = $(".right-cont").height();
			   $(".bg-body-middle").height(containerHeight - 158);
		}

	</script>
	<!-- Below is the code to call Gallerie image viewer -->
	<!-- <script type="text/javascript" src="<?php echo base_url();?>js/jquery.gallerie.js"></script>
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
		$('.gallery-item').magnificPopup({delegate:'a',
		  type: 'image',
		  gallery:{
		    enabled:true
		  }
		});
	});
	</script>

</head>
<body>
	<div id='head' class="global-cont">

		<div class="fl clearfix">
			<a id='logo' href="<?php echo base_url()?>"></a>
		</div>

		<!-- -TOP RIGHT HEADER -->
		<div class="fr clearfix">
			<ul class="top-header-menu clearfix">
				<li class="user"><p><?php echo $this->session->userdata('fname').' '.$this->session->userdata('lname')?> <a href="<?php echo base_url()?>user/logout">sign out</a></p></li>
			</ul>
		</div>
		<!-- END TOP RIGHT HEADER -->
	</div>


	<div class="clear"> </div>

	<div class="global-cont">

		<div class="main-menu">
			<ul class="m-left fl">
				<!--li class="home"><a href="<?php echo base_url()?>">Home</a></li-->
				<li><a href="<?php echo base_url()?>user" <?php if ($this->uri->uri_string=="user") echo "class='active'";?>>User</a></li>
				<li><a href="<?php echo base_url()?>inventory" <?php if ($this->uri->uri_string=="inventory") echo "class='active'";?>>Inventory</a></li>
				<li><a href="<?php echo base_url()?>supplier" <?php if (strpos($this->uri->uri_string,"supplier")===0) echo "class='active'";?>>Supplier</a></li>
				<!-- Lanz Editted -->
				<li><a href="<?php echo base_url() ?>buyer" <?php if (strpos($this->uri->uri_string,"buyer")===0) echo "class='active'";?>>Buyer</a></li>
			</ul>

			<ul class="m-right fr">
				<!-- Lanz Editted - June 10, 2013 -->
				<li><a href="<?php echo base_url() ?>administrator">Admin</a></li>
				<li><a href="<?php echo base_url() ?>sale">Sales</a></li>
				<li><a href="#">ENG<div class="eng fr"></div></a></li>
			</ul>
		</div>

	</div>