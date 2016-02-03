<?php
if($this->session->userdata('is_login') == TRUE)
{
	$user_type = $this->session->userdata('type'); //get user type;
	if($user_type == 2) //2 is Supplier
	{
		echo $this->load->view('supplier/header');
	}
	elseif($user_type == 3) //3 is Buyer
	{
		echo $this->load->view('buyer/header');
	}
	elseif($user_type == 1) //1 Admin
	{
		echo $this->load->view('admin/header');
	}
}
else
		echo $this->load->view('header');
?>
			<!-- LEFT SIDEBAR CONTAINER-->
			<div  class="nav-bar floatL">

				<?php
				if($this->session->userdata('is_login') == TRUE)
				{
					$user_type = $this->session->userdata('type'); //get user type;
					if($user_type == 2) //2 is Supplier
					{
						echo $this->load->view('supplier/sidebar');
					}
					elseif($user_type == 3) //3 is Buyer
					{
						echo $this->load->view('sidebar');
					}
					elseif($user_type == 1) //1 Admin
					{
						echo $this->load->view('admin/inventory/sidebar');
					}
				}
				else
						echo $this->load->view('sidebar');
				?>

			</div>

			<!-- RIGHT CONTENT CONTAINER-->
			<div class='floatR prodwrap'>
				<div class='right-inner clearfix'>

						<div class="titlebar">Your Cart</div>

						<div class='cart-container'>

							    <table class="gtable">
				                    <tr>
				                        <th width=100></th>
				                        <th>Item</th>
				                        <th width=20>Quantity</th>
				                        <th width=40>Price</th>
				                        <th width=80>Sub Total</th>
				                        <th width=30>Action</th>
						            </tr>
						            <?php
						            $total_shipping_fee = 0;
						            foreach($cart as $item){
						            	$item_ship_cost = (empty($item['options']['ship_cost_per_item'])) ? $item['options']['ship_cost']*$item['qty'] : $item['options']['shipping_cost']+$item['options']['ship_cost_per_item']*$item['qty'];
										$total_shipping_fee += $item_ship_cost
						            	?>
						            <tr>
						            	<td align='center'>
						            		<?php
											$image_list = $this->inventories->list_image($item['options']['i_id'],1,true);
											if(!$image_list){
												$image_list = $this->inventories->list_image($item['options']['i_id'],1);
											}
											//limit 1, select only the featured image
											if(count($image_list) == 0){?>
												<img width=95 src="<?php echo base_url()?>images/default-preview.jpg">

											<?php }else{?>
												<img width=95  src="<?php echo base_url().$image_list[0]->ii_link ?>">
											<?php }?>
						            	</td>
				                        <td><center><?php echo $item['name']?></center></td>
				                        <td><center><input class='small' type='text' id='qty<?php echo $item['rowid']?>' value='<?php echo $item['qty'] ?>' /></center></td>
				 				        <td><center><?php if ($this->session->userdata('is_login') == TRUE){ if($user->u_admin_approve==1) echo '$'.$item['price']; else echo "price is pending admin approval"; }else{ echo "log in to see price";} ?></center></td>
				                        <td><center><?php if ($this->session->userdata('is_login') == TRUE){ if($user->u_admin_approve==1) echo '$'.$item['subtotal'];  else echo "price is pending admin approval"; }else{ echo "log in to see price";} ?></center></td>                       <td><center><a href="#" onclick='update_cart("<?php echo $item['id']?>","<?php echo $item['rowid']?>","<?php echo $item['tot_qty']; ?>")'>Update</a> ,<a onclick='delete_cart("<?php echo $item['rowid']?>")' href="#">Delete</a></center></td>
				                    </tr>
								<?php }?>
									<tr>
										<td colspan=4></td>
										<td>Shipping Fee</td>
										<td><center><?php

										if ($this->session->userdata('is_login') == TRUE){ if($user->u_admin_approve==1) echo '$'.$total_shipping_fee;  else echo "price is pending admin approval"; }else{ echo "log in to see price";}							?></center></td>
									</tr>
									<tr>
										<td colspan=4></td>
										<td>Total</td>
										<td colspan=2><center><?php if($this->session->userdata('is_login') == TRUE){ if($user->u_admin_approve==1) echo '$'.($total+$total_shipping_fee); else echo "price is pending admin approval"; }else{ echo "log in to see price";}  ?></center></td>
									</tr>
						        </table>

						     <p><a href="<?php echo base_url();?>cart/empty_cart">Empty Cart</a></p>

						</div>
				</div>

				<?php if($login && ($user->u_admin_approve==1)){?>

				<div class='right-inner clearfix'>
						<div class="topBrands searching-for">
							<div class="topBrandsHeader">
								<div class'floatl'="">Checkout Now!</div>
							</div>
						</div>
						<div class='inner-cont-billing-checkout clearfix'>
							<?php if($this->cart->total_items() != 0){?>
							<div>
								<input type="hidden" id="amt" value="<?php echo $total+$total_shipping_fee ?>">
								<div id="paypalbutton"></div>
								<a style="width:80px; margin:5px; text-align:center" class="" href="<?php echo base_url()?>checkout/authorize">
									<button id='add-billing-button' class='greenbutton floatR'>Pay with Credit Card</button>
								</a>
								<a style="width:80px; margin:5px; text-align:center;" class="" href="<?php echo base_url()?>checkout/apruve">
									<button id='add-billing-button' class='greenbutton floatR' style=" margin-right: 10px;">Check out with Apruve</button>
								</a>
                                <a style="width:80px; margin:5px; text-align:center;" class="" href="<?php echo base_url()?>checkout/international">
                                    <button id='add-billing-button' class='greenbutton floatR' style=" margin-right: 10px;">International Checkout</button>
                                </a>
							</div>
							<?php }else{?>
								<p>Need at least 1 item in your cart</p>
							<?php }?>
						</div>
				</div>

				<?php }else{?>
				<div class='right-inner clearfix'>
						<div class="titlebar">Login as Buyer</div>
						<?php if (!$login) { ?>
						<p>You Must <a href='#' onclick='javascript:document.getElementById("memberClick").click()'>Login</a> to our Website or Subscribe as Buyer. Click <a href="http://oceantailer.com/buyer_register.php">here</a> to Register</p>
						<?php } else {?>
						<p>Pricing will be visible after OceanTailer's Admin approves the account</p>
						<?php }?>
				</div>
				<?php }?>

			</div>
			<!-- RIGHT CONTENT CONTAINER END-->

<script type="text/javascript">

	$('#country').change(function(){
		var country_sel = this.value;

		$.post("<?php echo base_url()?>country/load",{id:country_sel,type:'dropdown','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
			if(result != 0)
			{
				$('#state_dropdown').html(result);
				$('#drp-state').fadeIn();
				$('#state-textbox').hide();
				is_state = true;
			}
			else
			{
				is_state = false;
				$('#state-textbox').fadeIn();
				$('#drp-state').hide();
			}
		});
	});

	function update_cart(i_id,rid,totqty)
	{
		var qty = $('#qty'+rid).val();
		$.post("<?php echo base_url()?>cart/update/qty",{qty:qty,rid:rid,i_id:i_id,totqty:totqty,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(data){
			var crt = JSON.parse(data);
			if(crt.flag=='1') {
				$(window.location.reload());
			} else {
				alert("Available quantity of this product is "+crt.rem_qty+". Please update the quantity and then click on add to cart");
				return false;
			}
		});
	}

	function delete_cart(rid)
	{
		$.post("<?php echo base_url()?>cart/update/qty",{qty:0,rid:rid,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(data){
			$(window.location.reload());
		});
	}

	$(window).load(function(){
		$(".small").keydown(function (e) {
        	  	// Allow: backspace, delete, tab, escape, enter and .
        	  	if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
        	     	// Allow: Ctrl+A
	            	(e.keyCode == 65 && e.ctrlKey === true) ||
        	     	// Allow: home, end, left, right
	         		(e.keyCode >= 35 && e.keyCode <= 39)) {
                	 	// let it happen, don't do anything
                 		return;
        			}
	        	// Ensure that it is a number and stop the keypress
        		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
	        	    e.preventDefault();
        		}
		});
	});

	/*var amt = $('#amt').val();
	$(document).ready(function(){
		$.post("<?php echo base_url()?>payflow/paypalbutton",{amt:amt,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(data){
			$('#paypalbutton').html(data);
		})
	});*/
</script>

<?php
if($this->session->userdata('is_login') == TRUE)
{
	$user_type = $this->session->userdata('type'); //get user type;
	if($user_type == 2) //1 is suplier
	{
		echo $this->load->view('supplier/footer');
	}
	elseif($user_type == 3) //3 is Buyer
	{
		echo $this->load->view('buyer/footer');
	}
}
else
		echo $this->load->view('footer');
?>
