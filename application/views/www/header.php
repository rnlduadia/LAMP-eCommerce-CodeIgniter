<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>res/style.css" />
        <title><?php echo $title; ?></title>
	<meta name='salehoo_verification' content='53f29356-9f28-42a7-9ea1-65d36cabb0c8' />
	<link rel="stylesheet" href="http://dev.oceantailer.com/css/bootstrap/css/bootstrap.min.css">
	<!-- <link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.min.css"> -->
	<script src="http://dev.oceantailer.com/css/bootstrap/js/jquery.js"></script>
	<script src="http://dev.oceantailer.com/css/bootstrap/js/bootstrap.min.js"></script>

    </head>

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-51167909-1', 'oceantailer.com');

ga('require', 'displayfeatures');
ga('send', 'pageview');
</script>

<body onload="load();">
    <div id="wrapper">
        <div id="topOne">
            <div id="topButtons">
                <a href="contact" class="left">contact us</a>
                <a href="#" class="right" id="memberClick">member login</a>
            </div>
            <div class="clear"></div>
        </div>
        <div id="topTwo">
            <div id="topTwoRight">
                <div id="menu">
                    <ul>
                        <li>
                            <span><a href="how_it_works" class="menuActive">HOW OCEANTAILER WORKS</a></span>
                        </li>
                        <li>
                            <p> | </p>
                        </li>
                        <li>
                            <span><a href="supplier_benefits" class="menuActive">SUPPLIERS BENEFITS</a></span>
                        </li>
                        <li>
                            <p> | </p>
                        </li>
                        <li>
                            <span><a href="buyer_benefits" class="menuActive">BUYERS BENEFITS</a></span>
                        </li>
                        <li>
                            <p> | </p>
                        </li>
                        <li>
                            <span><a href="about_us" class="menuActive">ABOUT US</a></span>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="topTwoLeft">
                <div id="logoHolder">
                    <a href="http://www.oceantailer.com"><img src="<?php echo base_url()?>images/www/logo.png" alt="logo"></a>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    <div id="cover">
    </div>
    <div id="memberLogin" class="memberLogin">
        <h2>OceanTailer welcome you</h2>
        <p>Check out what's new and exciting on our platform</p>
        <form action="login.php" method="post" name="frmLogin" id="frmLogin">
            <div class="inputHolder">
                <input type="text" name="name" id="name"
                       placeholder="Username or email"/>
                <input type="password" name="pass" id="pass"
                       placeholder="Password"/>
           <input type="hidden" id="csrf" name="csrf" value="">
            </div>
            <a href="#" type="button" id="submitLogin" class="submitLogin" >sign in</a>
        </form>
        <div class="memberFooter" id="memberFooter">
            <div class="firstest"><a href="#" id="forgotPasswordPop">forgot your password?</a></div>
            <div class="lastest">not registered yet? <a href="buyer_register">sign up!</a></div>
        </div>
    </div>
    <div id="forgotPass" class="memberLogin">
        <h2 style="margin-top:40px;">Forgot your password?</h2>
        <p>Not a problem. We can help you with that.</p>

            <div class="inputHolder" style="height:50px;">
                <input type="text" name="forgotPassEmail" id="forgotPassEmail"
                       placeholder="Enter your Email">
            </div>
            <a href="#" type="button" id="submitForgotPass" class="submitLogin">send recovery email</a>
                 <div style="font-weight: bold;margin-top: 6px">
                    <p class='result-pass'></p>
                 </div>
    </div>
