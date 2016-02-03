<?
if($pagination['num_pages'] > 1){
	$step = 5;
	$curent_page = $pagination['curent_page'];

	$first_page = $curent_page - $step;
	if($first_page < 1) $first_page = 1;

	$last_page = $curent_page + $step;
	if($last_page > $pagination['num_pages']) $last_page = $pagination['num_pages'];

	echo "<div class='pagination'>page /*(".$curent_page." from ".$pagination['num_pages'].")*/: ";
	for($i = $first_page; $i <= $last_page; $i++){
		echo ($i==$curent_page ? $i : "<a href='?page=".$i."'>".$i."</a>")."&nbsp;&nbsp;";
	}	
	echo "</div>";
	/*echo "<div class='pagination'><form method='get'>got to page: <input type='text' name='page' value='".$curent_page."' size='4'/><input type='submit' value='go' /></form></div>";*/
}


?>
<table>
	<tr>
		<td>Name</td>
		<td>Brand</td>
		<td>Manufacturer</td>
		<td>SKU</td>
		<td>Action</td>
	</tr>
	<?php foreach($inventory as $inv){?>
		<tr>
			<td><?php echo $inv->tr_title?></td>
			<td><?php echo $inv->b_name?></td>
			<td><?php echo $inv->m_name?></td>	
			<td><?php echo $inv->SKU;?></td>
			<td>
				<center>
					<a href="<?php echo base_url()?>inventory/update/<?php echo $inv->i_id?>">Update</a>,
					<a href="<?php echo base_url()?>inventory/detail/<?php echo $inv->i_id?>">View</a>
				</center>
			</td>
		</tr>
	<?php }?>
</table>