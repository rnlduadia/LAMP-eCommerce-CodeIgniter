<!-- Lanz Editted - June 8, 2013 -->
<?php $this->load->view("supplier/header"); ?>

			<!-- LEFT SIDEBAR CONTAINER-->
			<div class="nav-bar floatL">

				<?php echo $this->load->view('supplier/sidebar');?>

			</div>

			<!-- RIGHT CONTENT CONTAINER-->
			<div class='sliderLg floatR'>
				<div class='right-inner clearfix'>
					<!-- First Row Container-->
					<div class="topBrands searching-for">
						<div class="topBrandsHeader">
							<div class'floatl'="">Manage Bank Account</div>
						</div>
					</div>

					<div class='padded-cont'>
						<div class="disclaimer floatL"><label>Disclaimer: If you are interested in direct deposit, please maintain a valid bank account details</label></div>
						<button class="greenbutton floatR" id="add-creditcard-button" onclick="window.location.href='<?php echo base_url()?>supplier/addbankaccount';">ADD BANK ACCOUNT</button>
						<div class="clear"> </div>
						<div class='gray-table table-margin'>
							<table>
								<tr>
									<td>Bank Owner</td>
									<td>Bank Address</td>
									<td>Bank Name</td>
									<td>Bank Account</td>
									<td>Bank ID Code</td>
									<td>Action</td>
								</tr>
								<?php foreach($bank_details as $bank){?>
								<tr>
									<td><?php echo $bank->bnk_owner; ?></td>
									<td><?php echo $bank->bnk_address; ?></td>
									<td><?php echo $bank->bnk_name; ?></td>
									<td><?php echo $bank->bnk_account; ?></td>
									<td><?php echo $bank->bnk_id_code; ?></td>
									<td>
										<center>
										<a href="<?php echo base_url() ?>supplier/bankaction/update/<?php echo $bank->bnk_id; ?>">Update</a>
										<a href="javascript:ApproveDelBank('<?php echo base_url() ?>supplier/bankaction/delete/<?php echo $bank->bnk_id; ?>');">Delete</a>
										</center>
										<input type="hidden" value="<?php echo $bank->bnk_id ?>">
										<input type="hidden" value="<?php echo $bank->u_id ?>">
									</td>
								</tr>
								<?php }?>
							</table>
						</div>
					</div>
				</div>
			</div>

	<script>
		function ApproveDelBank(url) {

			if(confirm("Are you sure want to delete bank details?")) {
				window.location.href = url;
			}

		}
	</script>

<?php $this->load->view("supplier/footer"); ?>