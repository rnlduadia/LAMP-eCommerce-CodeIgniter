	<div id='footer' class="global-cont">
		<center><p>Copyright &copy; 2003-<?php echo date("Y"); ?> OceanTailer</p></center>
	</div>
<input type="hidden" id="csrf" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>">

</body>
</html>