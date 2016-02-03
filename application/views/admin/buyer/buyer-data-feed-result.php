<?php
if(count($items) != 0){?>
    <?php foreach($items as $item){?>
        <tr>
            <td><?php echo $item->tr_title ?></td>
            <td><?php echo $item->SKU ?></td>
            <td><?php echo $item->upc_ean ?></td>
            <td><?php echo $item->manuf_num ?></td>
            <td><?php echo $item->b_name ?></td>
            <td><?php echo $item->c_name ?></td>
            <td><a href="#" class="js-delete-datafeed" data-id="'<?php echo $inventory_item->ic_id ?>'" >Delete</a></td>

        </tr>
    <?php }?>
<?php }?>