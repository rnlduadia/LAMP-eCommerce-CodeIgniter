<div class="filters">
    <?php foreach($filters as $key => $filter):?>
        <?php $type = isset($filter['type'])?$filter['type']:'text';?>
        <div class="filter-item">
            <label for='search-<?php echo $key;?>'><?php echo $filter['title'];?></label>
            <div class='clear'></div>
                <?php if($type == 'text'): ?>
                    <input type="text" name="<?php echo $key;?>" id='search-<?php echo $key;?>' class='normal-format-text' value='<?php echo $filter['value'];?>'/>
                <?php endif;; ?>
                <?php if($type == 'datepicker'): ?>
                    <input type="text" name="<?php echo $key;?>" id='search-<?php echo $key;?>' class='normal-format-text for-datepicker' value='<?php echo $filter['value'];?>'/>
                <?php endif;?>
                <?php if($type == 'select'): ?>
                    <select name="<?php echo $key;?>" id='search-<?php echo $key;?>'>
                        <?php foreach($filter['opts'] as $v => $t):?>
                            <option value="<?php echo $v;?>" <?php if((string)$v === $filter['value']):?>selected<?php endif;?>><?php echo $t;?></option>
                        <?php endforeach;?>
                    </select>
                <?php endif;?>
        </div>
    <?php endforeach;?>
</div>
<div class="clearfix">
         <div class='clearfix'>
         	<input type='button' value='SEARCH' id='send-search' class='normal-button' style='margin-top:10px;' />
         </div>
</div>
<script type="text/javascript">
	$('#send-search').click(function(){
		updateTable();
	});
</script>