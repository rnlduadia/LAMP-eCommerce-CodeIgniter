<tr>
	<td width=55>Date Order</td>
	<td>Invoice</td>
	<td>Buyer</td>
	<td width=15>Billing Country</td>
	<td width=15>Total Item</td>
	<td>Total Amount</td>
	<td>Status</td>
	<td>Action</td>
</tr>
<?php 
if(count($pending) != 0){?>
	<?php foreach($pending as $pend){?>
		<tr>
			<td><center><?php echo date('M d, Y H:i:s',$pend->bt_time); ?></center></td>
			<td>
				<div><?php echo $pend->bt_invoice?></div>
			<td><center><p><?php echo $pend->u_fname.' '.$pend->u_lname?></p></center></td>
			<td><center><?php echo $pend->c_code?></center></td>
			<td><center><?php echo $pend->bsd_total_item?></center></td> 
			<td>$<?php echo $pend->bsd_total_paymet?></td>
			<td>
				<?php if($pend->bsd_status == -1){ //if cancelled order?>
					Cancelled: <br/>
				<?php }elseif($pend->bsd_status == -4){//if buyer need to return ?>
					Return: <br/>
				<?php }?>
					<?php echo $pend->bsd_reason;	?>
			</td>
			<td>
				<center>
					<a href="<?php echo base_url()?>supplier/order/<?php echo $pend->bsd_id ?>" >Order Detail</a>
				</center>
				<center><?php echo  count($this->users->new_email_count($pend->bsd_id, 3)); ?> Messages</center>
			</td>
		</tr>
	<?php }?>
<?php }else{?>
	<tr>
		<td colspan='7'><center>No Shipping Request Yet</center></td>
	</tr>
<?php }?>
<!-- <tr>
	<td colspan='7'><?php echo $this->db->last_query();?> </td>
</tr> -->