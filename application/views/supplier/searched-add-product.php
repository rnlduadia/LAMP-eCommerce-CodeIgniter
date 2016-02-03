<div class="violet-table">
	<table id="list-product-result">
	<tr>
		<td>Title</td>
		<td>Category</td>
		<td>Manufacturer</td>
		<td>Brand</td>
		<td>Weight</td>
		<td>Action</td>
	</tr>
	<tbody>
	<?php if(count($products) != 0){?>
<?php foreach($products as $inv){?>
<?php $remaining_quantity = $this->suppliers->get_child_remaining_quan($inv->ic_id, $inv->ic_quan);
?>
<tr>
	<td><?php echo $inv->tr_title?></td>
	<td><?php echo $this->categories->create_breadcrumb($inv->cat_id,$inv->c_level)?></td>
	<td><?php echo $inv->m_name?></td> 
	<td><?php echo $inv->b_name?></td>
	<td><?php echo $inv->weight.' '.$inv->weightScale?></td>
	<td><center>
		<a href="<?php echo base_url()?>inventory/add/stock/<?php echo $inv->i_id?>">Add Stock</a>
	</center>
</td>
</tr>
<?php }?>
<?php }else{?>
<tr>
	<td colspan='7'><center>No Product Added Yet</center></td>
</tr>
<?php }?>
</tbody>
</table>
</div>