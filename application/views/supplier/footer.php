	</div><!--#content-->
	<div class="clear"></div>


<div id="footer">
	<ul class="footerInfo floatL">
		<li class='block-caption'>Our mission</li>
		<li class='mission'>Connect between wholesale to retail and bring value to both sides.
                    To service them and excel their businesses like
                    no one else, no matter the size of the company</li>
	</ul>

	<ul class="footerInfo floatL">
		<li class='block-caption'>Menu</li>
		<li><a href='<?php echo base_url()?>about_us'>About Us</a></li>
		<li><a href='<?php echo base_url()?>supplier'>Catalog</a></li>
		<li><a href='<?php echo base_url()?>supplier/datafeeds'>Feeds</a></li>
		<li><a href='<?php echo base_url()?>shipping/lists'>Orders</a></li>
		<li><a href='<?php echo base_url()?>supplier/profile/supplier/view'>Manage My Account</a></li>
		<li><a href='<?php echo base_url()?>supplier/inbox'>Message Center</a></li>
		<li><a href='http://www.oceantailer.com/contact.php'>Help</a></li>
	</ul>

	<ul class="footerInfo floatL">
		<li class='block-caption'>Useful Links</li>
		<li><a href='http://www.oceantailer.com/privacy_policy.php' target='_blank'>Privacy Policy</a></li>
		<li><a href='http://www.oceantailer.com/terms_of_use.php' target='_blank'>Terms of use</a></li>
		<li><a href='http://www.oceantailer.com/faqs.php' target='_blank'>FAQ's</a></li>

	</ul>

	<ul class="footerInfo floatL">
		<li class='block-caption'>Contact Us</li>
		<li>    New Jersey Office: 862.203.8249<br><br>
                        <a href="mailto:accounts@oceantailer.com?subject=Hey, I want to...">accounts@oceantailer.com</a>
                    </li>
	</ul>

	<ul class="footerInfo floatL">
		<li>We Accept:</li>
		<li><img src="<?php echo base_url();?>images/cur.png"> </li>
		<li class="footHeading">Find Us:</li>
		<li>
			<ul class='soc'>
                            <li><a href="https://www.facebook.com/pages/OceanTailer/1440325089552653"><img src="<?php echo base_url();?>images/soc_fb.png"/></a> </li>
				<li><a href='https://twitter.com/oceantailer' target='_blank'><img src="<?php echo base_url();?>images/soc_tw.png"/></a> </li>
				<li><img src="<?php echo base_url();?>images/soc_go.png"/> </li>
                                <li> <a href='http://www.pinterest.com/oceantailer' target='_blank'> <img src="<?php echo base_url();?>images/soc_pi.png"/></a> </li>
				<li><img src="<?php echo base_url();?>images/soc_x.png"/> </li>
			</ul>
		</li>

	</ul>

	<div class="clear"></div>

	<div class="copyright">Copyright © 2014 OceanTailer</div>
</div><!--#footer-->
<!--	<div id='footer' class="global-cont">
		<center><p>Copyright &copy; 2003-<?php echo date("Y"); ?> OceanTailer</p></center>
	</div>-->
</div>	<!--#page-->
<input type="hidden" id="csrf" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51167909-1', 'oceantailer.com');
  ga('send', 'pageview');

</script>
        </body>
</html>