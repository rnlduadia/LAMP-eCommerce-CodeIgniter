<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Oceantailer</title>
<link href='<?php echo HTTP_PROTOCOL;?>://fonts.googleapis.com/css?family=Open+Sans+Condensed:light&v1' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo base_url()?>css/bootstrap/css/bootstrap.min.css">
	<!-- <link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.min.css"> -->
<!--[if !IE]> -->
	<script src="<?php echo base_url()?>css/bootstrap/js/jquery.js"></script>
<!-- <![endif]-->

<!--[if IE]>
	<script src="<?php echo base_url()?>css/bootstrap/js/jquery-1.11.3.min.js"></script>
<![endif]-->
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
<!-- <script src="<?php echo HTTP_PROTOCOL;?>://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script> -->
<script type="text/javascript">

	$(window).load(function() {
		setSizes();
		if($('.carousel').length) $('.carousel').flexslider({
	        animation: "slide",
		    controlNav: false,
		    animationLoop: false,
		    slideshow: false,
		    itemWidth: 190,
		    itemMargin: 8,
		    //asNavFor: '#slider'
      	});
      	if($('#slider').length) $('#slider').flexslider({
		    animation: "slide",
		    controlNav: false,
		    animationLoop: false,
		    slideshow: false,
		    //sync: "#carousel",
		});

		$(".radio-style").click(function(){
			if(!$(this).hasClass('radio-style-active')) {
		        $(this).addClass('radio-style-active');
		    }
		    else{
		    	$(this).removeClass('radio-style-active');
		    }
		});

/*		$(".dropdown-menu>li>a").on("click", function(){
			text = $(this).text();
			$("#chosencat").text(text);
		});*/
	});

	var extra_url = '<?php echo ($this->uri->segment(1) == 'cart' || $this->uri->segment(1) == 'cart#') ? '/cart' : '' ?>';


$(document).ready(function(){

/*	$('#loginpopup').modal({show:false});

	$('#loginpopup').on('hidden.bs.modal', function () {
		$(".login_error").text("").fadeOut();
    	})

		$('#login-submit').click(function(){
			login();
		});*/

	function login()
	{
		console.log(123);
		var username = $('#name').val();
			var pass = $('#pass').val();


			$.post("<?php echo base_url()?>user/login",{name:username,pass:pass,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'}, function(result){
				var  convert = JSON.parse(result);
	            if(convert.result == 1)
	                $(window.location).attr('href', '<?php echo base_url()?>');//redirect to the user page
	            else
	            {
	                // $('.custom-message-box').fadeIn('slide');
	                // $('.custom-message-box').delay(1500).fadeOut();
			//$(".login_error").text(convert.message).fadeIn();
	                alert(convert.message);
	            }
			});
	}

	$('#name, #pass').keyup(function(e){
		if(e.keyCode  == 13)
		{
			$("#submitLogin").trigger('click');
		}
	});

});

	function setSizes() {
		var containerHeightleft = $("#left-sidebar").height();
		var containerHeightright = $(".right-cont").height();
	   if(containerHeightleft > containerHeightright)
	   		$(".bg-body-middle").height(containerHeightleft - 158);
	   else
	   		$(".bg-body-middle").height(containerHeightright - 158);

	   	var full = $(".full-cont").height();

	   	if ($(".full-cont")[0])
	   		$(".bg-body-middle").height(full - 158);
	}
</script>

	<!-- Below is the to code call Gallerie image viewer -->
<!-- <script type="text/javascript" src="<?php echo base_url();?>js/jquery.gallerie.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/gallerie.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/gallerie-effects.css"/>

<script type="text/javascript">
$(document).ready(function(){
	$('div.inner-img-prod-list').gallerie();
});
</script> -->

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
<script type="text/javascript">
</script>
</head>
<body class="body-wrapper">
<div id="page">
<div id="header">

	<div class="logo floatL"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>images/logo.png" /></a></div>
	<div class="input-group header-group">
		<div class="member-login floatR">
			<input type="button" id="memberClick" data-toggle="modal" data-target="#loginpopup" class="btn btn-success  btn-member" value="MEMBER LOGIN" />
			<ul class="top-header-menu cart-under-login clearfix">
				<li class='cart'>
					<div class='fl'>
						<p>Your cart: <a href='<?php echo base_url()?>cart'> <span id='num-total-item'> <?php echo $this->cart->total_items() ?> </span> items </a></p>
					</div>
				</li>
			</ul>

		</div>
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
<div id="cover" style="display: none;"></div>
<div id="memberLogin" class="memberLogin" style="display: none; left: 540px;">
    <h2>OceanTailer welcome you</h2>
    <p>Check out what's new and exciting on our platform</p>
    <form action="login.php" method="post" name="frmLogin" id="frmLogin">
        <div class="inputHolder">
            <input type="text" name="name" id="name" placeholder="Username or email">
            <input type="password" name="pass" id="pass" placeholder="Password">
            <input type="hidden" id="csrf" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>">
        </div>
        <a href="#" type="button" id="submitLogin" class="submitLogin">sign in</a>
    </form>
    <div class="memberFooter" id="memberFooter">
        <div class="firstest"><a href="#" id="forgotPasswordPop">forgot your password?</a></div>
        <div class="lastest">not registered yet? <a href="http://oceantailer.com/buyer_register.php">sign up!</a></div>
    </div>
</div>
<div id="forgotPass" class="memberLogin" style="display: none; left: 540px;">
    <h2 style="margin-top:40px;">Forgot your password?</h2>
    <p>Not a problem. We can help you with that.</p>

        <div class="inputHolder" style="height:50px;">
            <input type="text" name="forgotPassEmail" id="forgotPassEmail" placeholder="Enter your Email">
            <input type="hidden" id="csrf" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>">
        </div>
        <a href="#" type="sumit" id="submitForgotPass" class="submitLogin">send recovery email</a>
             <div style="font-weight: bold;margin-top: 6px">
                <p class="result-pass"></p>
             </div>
</div>
<script src="<?php echo base_url()?>js/main.js"></script>
<div id="content">
 	<!-- <div id='head' class="global-cont">
		<div class="fl clearfix">
			<a id='logo' href="<?php echo base_url()?>"></a>
		</div>



		<div class="fr clearfix">
			<ul class="top-header-menu clearfix">
				<li class="user">
					<div class='login-cont fl' >

						<input type='text' name="login-username" id="login-username" value="username" onblur="if(this.value=='') this.value='username';" onfocus="if(this.value=='username') this.value='';"  />
						<input type='password' name="login-pass" id="login-pass" value="password" onblur="if(this.value=='') this.value='password';" onfocus="if(this.value=='password') this.value='';"  />
						<input type='submit' value='Login' name="login-submit" id="login-submit">
						<div class="clear"> </div>
						<a class='' href='<?php echo base_url()?>buyer/register'>Be our Buyer</a> , <a class='' href='<?php echo base_url()?>supplier/register'>Be our Supplier</a>, <a class='' href='<?php echo base_url()?>user/forgotpassword'>forgot password?</a>
						<div class="clear"> </div>
					</div>
				</li>
				<li>
					<div class='fl cart-icon'>
						<p><img src='<?php echo base_url()?>images/cart-top.png'></p>
					</div>
					<div class='fl'>
						<p>Your cart: <a href='<?php echo base_url()?>cart'> <span id='num-total-item'> <?php echo $this->cart->total_items() ?> </span>  items </a></p>
					</div>
				</li>
			</ul>

		</div>

	</div>


	<div class="clear"> </div>

	<div class="global-cont">

		<div class="main-menu">
			<ul class="m-left fl">
				<li class="home"><a href="<?php echo base_url()?>">home</a></li>
				<li><a href="#">Catalog</a></li>
				<li><a href="#">Feeds</a></li>
				<li><a href="#">Orders</a></li>
				<li><a href="#">Account</a></li>
				<li><a href="#">Help</a></li>
			</ul>

			<ul class="m-right fr">
				<li><a href="#">ENG<div class="eng fr"></div></a></li>
				<li><a href="#">Support</a></li>
				<li><a href="/about_us.php">About Us</a></li>
			</ul>
		</div>

	</div> -->

