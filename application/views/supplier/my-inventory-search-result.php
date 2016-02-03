<?php
if(count($items) != 0){?>
    <?php foreach($items as $inventory_item){ ?>
        <tr>
            <td><a href="/inventory/detail/<?php echo $inventory_item->i_id . '/' . $inventory_item->ic_id ?> " target="_blank" > <?php echo $inventory_item->i_id ?> </a></td>
            <td><?php echo $inventory_item->tr_title ?></td>
            <td><?php echo $inventory_item->SKU ?></td>
            <td><?php echo $inventory_item->ic_quan ?></td>
            <td><?php echo $inventory_item->ic_price ?></td>
            <td><?php echo $inventory_item->ic_retail_price ?></td>
            <td><?php echo $inventory_item->date ?></td>
            <td>
                <center>
                    <a href="/inventory/update/<?php echo $inventory_item->ic_id ?>" >Edit</a>
                    <!-- <a href="/inventory/delete/<?php // echo $inventory_item->i_id .'/'.$inventory_item->ic_id ?>" >Delete</a>  -->
                    <a onclick="javascript:DeleteInventory(<?php echo $inventory_item->i_id .','.$inventory_item->ic_id ?>);" >Delete</a>
                </center>
            </td>

        </tr>
    <?php }?>
<?php }else{?>
    <tr>
        <td colspan='7'><center>No Inventories</center></td>
    </tr>
<?php }?>