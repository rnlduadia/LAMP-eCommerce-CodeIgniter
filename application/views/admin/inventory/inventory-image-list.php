<div class="fl clearfix" rel="<?php echo $id ?>">
    <table style="border: 0px dotted;">
        <?php if ( !empty($ii_time) and $ii_time!= '0000-00-00 00:00:00' ) : ?>
        <tr>
            <td>
                <?php echo apputils::ShowFormattedDateTime( $ii_time, '' )?>
            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <td>
            	<a onclick="return false" href="<?php echo base_url().$link?>">
		            <button class='delete-image fl' onclick="return delete_image(<?php echo is_numeric($id) ? $id : "'{$id}'" ?>);"></button>
		            <button class='set-featured fr' onclick="return set_featured(<?php echo is_numeric($id) ? $id : "'{$id}'" ?>);"></button>
		            <img width=105 src="<?php echo base_url().$link?>">
	            </a>
            </td>
         </tr>
    </table>
</div> 