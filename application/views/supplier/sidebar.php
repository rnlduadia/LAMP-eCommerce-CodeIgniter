<ul class='nav-items'>
	<li><label class='sup-caption'>Manage Products</label>
	</li>
	<li class='sup-menu'><a href="<?php echo base_url()?>inventory/">My Inventory</a></li>
	<li class='sup-menu'><a href="<?php echo base_url()?>supplier/add/product">Add Inventory</a></li>
        <li class='sup-menu'><a href="<?php echo base_url() ?>supplier/datafeeds">Import Datafeeds</a></li>
<!--<li class='sup-menu'><a href="<?php echo base_url().'inventory/search/supplier/'.$this->session->userdata('id')?>">My Products</a></li>-->

</ul>

<ul class='nav-items'>
	<li><label class='sup-caption'>Payments</label>
	</li>

	<li class='sup-menu'><a href="<?php echo base_url() ?>supplier/sales">Statement View</a></li>
	<li class='sup-menu'><a href="<?php echo base_url() ?>supplier/sales/transaction">Transaction View</a></li>
			<!-- Lanz Sync -->
	<li class='sup-menu'><a href="<?php echo base_url() ?>supplier/sales/all">All Statements</a></li>
</ul>

<ul class='nav-items'>
	<li><label class='sup-caption'>Order</label>
	</li>

	<li class='sup-menu'><a href="<?php echo base_url() ?>shipping/lists">Shipping Order List</a></li>
	<li class='sup-menu'><a href="<?php echo base_url() ?>supplier/feedback">Order Feedbacks</a></li>
        <li class='sup-menu'><a href="<?php echo base_url() ?>supplier/messages">Messages from Buyers</a></li>
</ul>

<ul class='nav-items'>
	<li><label class='sup-caption'>Manage Account</label>
	</li>

	<li class='sup-menu'><a href="<?php echo base_url() ?>supplier/profile/supplier/view">View Profile</a></li>
	<li class='sup-menu'><a href="<?php echo base_url() ?>supplier/profile/supplier/update">Update Profile</a></li>
	<li class='sup-menu'><a href="<?php echo base_url() ?>supplier/updatepassword">Update Password</a></li>
	<li class='sup-menu'><a href="<?php echo base_url() ?>supplier/billing">Manage Billing Address</a></li>
	<li class='sup-menu'><a href="<?php echo base_url() ?>supplier/creditcard">Manage Credit Card</a></li>
    <li class='sup-menu'><a href="<?php echo base_url() ?>supplier/bankaccount">Manage Bank Account</a></li>
    <li class='sup-menu'><a href="<?php echo base_url() ?>supplier/shippingtable">Manage Shipping Table</a></li>
</ul>
<script>
	$(window).load(function(){
		var ary_cat = [];
		var ary_manu = [];
		var from = '';
		var to = '';
		var supplier = '<?=($this->uri->segment(3) == 'supplier' ? $this->session->userdata('id') : "")?>';
		var supplier_name = '';
		if($('#result-product-maincont').length){
		$.post('<?php if(isset($dym_link)){ echo $dym_link;} ?>',{action:'get',cat:ary_cat,manu:ary_manu,from:from,to:to,supplier:supplier,supplier_name:supplier_name,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
			if(result != '')
				$('#result-product-maincont').html(result);
			else
				$('#result-product-maincont').html('');
		});
		}
	});

</script>
