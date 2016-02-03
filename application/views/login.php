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


</head>
<body class="body-wrapper">
<div id="page">
<div id="header">
	
	<div class="logo floatL"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>images/logo.png" /></a></div>
	<div class="input-group header-group">

		
	</div>
</div>
<div class="clear"> </div>
<div id='content'>


<div id="cover" style="display: block;"></div>
<div id="memberLogin" class="memberLogin" style="display: block; left: 540px;">
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
<script type="text/javascript">
	var extra_url = '/<?php echo $this->uri->uri_string()?>';


</script>

<script src="<?php echo base_url()?>js/main.js"></script>
<script type="text/javascript">

$("#cover").on("click", function(){
    document.getElementById("memberLogin").style.display = "block";
    document.getElementById("cover").style.display = "block";
    document.getElementById("forgotPass").style.display = "none";
});
</script>
	</div><!--#content-->
	<div class="clear"></div>



        </body>
</html>
