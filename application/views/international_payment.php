You will be redirected to International Checkout...
<form name="icForm" id="icForm" method="post" action="https://www.internationalcheckout.com/cart.php">
	<input type="hidden" id="csrf" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>">
    <?php
        $i = 1;
        $total_shipping_fee = 0;
    ?>
    <?php foreach($cart as $item):?>
        <?php $product_details = $this->suppliers->detail_main_inventory($item['options']['i_id']);?>
        <input type="hidden" name="ItemDescription<?php echo $i?>" value="<?php echo htmlspecialchars($product_details->tr_title.'. '.$product_details->tr_desc, ENT_QUOTES, 'ISO-8859-1', true);?>">
        <input type="hidden" name="ItemSKU<?php echo $i?>" value="<?php echo $product_details->manuf_num;?>">
        <input type="hidden" name="ItemQuantity<?php echo $i?>" value="<?php echo $item['qty'];?>">
        <input type="hidden" name="ItemPrice<?php echo $i?>" value="<?php echo $item['price'];?>">
        <input type="hidden" name="ItemWeight<?php echo $i?>" value="<?php echo $product_details->weight;?>">
        <?php
            $image_list = $this->inventories->list_image($item['options']['i_id'],1,true);
            if(!$image_list){
                $image_list = $this->inventories->list_image($item['options']['i_id'],1);
            }
            if(count($image_list) == 0){
        ?>
            <input type="hidden" name="ItemImage<?php echo $i?>" value="<?php echo base_url()?>images/default-preview.jpg">
        <?php }else{?>
            <input type="hidden" name="ItemImage<?php echo $i?>" value="<?php echo base_url().$image_list[0]->ii_link ?>">
        <?php }?>
    <?php
        $total_shipping_fee += $item['options']['ship_cost'];
        $total_shipping_fee = $total_shipping_fee * $item['qty'];
        $i++;
        ?>
    <?php endforeach;?>
    <input type="hidden" name="p" value="oceantailer">
    <input type="hidden" name="external_shipping_surcharge" value="<?php echo $total_shipping_fee;?>">
</form>
<script>document.getElementById('icForm').submit();</script>