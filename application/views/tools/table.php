<div class='violet-table'>
    <input type="hidden" name="sort_by" id="sort_by" value="<?php echo $sorter['by'];?>">
    <input type="hidden" name="sort_direction" id="sort_direction" value="<?php echo $sorter['dir'];?>">
	<?php if(isset($columns['cb']) && isset($columns['cb']['actions'])):?>
		<div class="bulk-actions" class="clearfix" style="margin-bottom: 10px;">
			<label>Bulk Actions:</label>
			<select id="bulk-action">
				<option value="">Select Action</option>
				<?php foreach($columns['cb']['actions'] as $key => $action):?>
					<option value="<?php echo $key;?>" data-link="<?php echo $action['link'];?>" <?php if(isset($action['confirm'])):?>data-confirm="<?php echo $action['confirm'];?>" <?php endif;?>><?php echo $action['text'];?></option>
				<?php endforeach;?>
			</select>
			<input type='button' value='APPLY' id='do-bulk-action' class='btn-action normal-button'/>
		</div>
	<?php endif;?>
    <table id='list-result' class='tablesorter'>
        <thead>
            <tr>
                <?php foreach($columns as $key => $column):?>
	                <?php if($key == 'cb'):?>
		                <td><input type="checkbox" id="cb-select-all"></td>
                    <?php elseif(isset($column['sortable']) && $column['sortable'] == true):?>
                        <td class="sortable sorter <?php echo ($key == $sorter['by'])?'tablesorter-header'.ucfirst($sorter['dir']):'';?>">
                            <a href="javascript:void();" rel="<?php echo $key;?>"><?php echo $column['title'];?></a>
                        </td>
                    <?php else:?>
                        <td><?php echo $column['title'];?></td>
                    <?php endif;?>
                <?php endforeach;?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($items as $item):?>
                <tr>
                <?php foreach($columns as $key => $column):?>
	                <?php if($key == 'cb'):?>
		                <td>
			                <input type="checkbox" value="<?php echo $item->$column['pk']?>" class="checkbox">
		                </td>
                    <?php elseif($key == 'actions'):?>
                        <td>
                            <?php foreach($column['items'] as $action):?>
                                    <a
                                        <?php if($action['confirm']):?>
                                        onclick="return confirm('<?php echo $action['confirm'];?>');"
                                        <?php endif;?>
                                        href="<?php echo $action['link'].$item->$action['pk'];?>"
                                        <?php if($action['options']):?>
                                            <?php foreach($action['options'] as $opt_key => $opt_val):?>
                                                <?php echo $opt_key.'="'.$opt_val.'"';?>
                                            <?php endforeach;?>
                                        <?php endif;?>
                                        ><?php echo $action['text']?></a>
                            <?php endforeach;?>
                        </td>
                    <?php else:?>
                        <?php if(isset($column['link'])):?>
                            <td><a href="<?php echo $column['link'].$item->$key;?>"><?php echo sprintf(isset($column['format'])?$column['format']:'%s',isset($column['opts'])?$column['opts'][$item->$key]:$item->$key);?></a></td>
                        <?php else:?>
                            <td><?php echo sprintf(isset($column['format'])?$column['format']:'%s',isset($column['opts'])?$column['opts'][$item->$key]:$item->$key);?></td>
                        <?php endif;?>
                    <?php endif;?>
                <?php endforeach;?>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <?php if(count($items) == 0)
            echo 'No Items Found';
    ?>
</div>
<?php if(isset($columns['cb'])):?>
<script type="text/javascript">
	$('#cb-select-all').click(function(){
		$.each($('#list-result tbody .checkbox'),function(idx,el){
			$(el).attr('checked',$('#cb-select-all').is(':checked'));
		});
	});

	$('#list-result tbody .checkbox').click(function(){
		$('#cb-select-all').attr('checked',false);
	});

	$('#bulk-action').change(function(){
		if($(this).val() === '')
			$('#do-bulk-action').addClass('btn-action');
		else
			$('#do-bulk-action').removeClass('btn-action');
	});

	$('#do-bulk-action').click(function(){
		var action = $('select#bulk-action option:selected');
		if(action.val() !== ''){
			var link = action.data('link'),
				cfm = action.data('confirm');
			if(cfm && !confirm(cfm))
				return false;
			var selected = [];
			$.each($('#list-result tbody .checkbox:checked'), function(){
				selected.push($(this).val());
			});
			if(selected.length > 0){
				$.ajax(link + encodeURIComponent(selected.join()),{
					'data': {is_ajax : 1},
					'dataType': 'json',
					'type': 'get',
					'error': function(jqXHR, textStatus, errorThrown){
						alert(textStatus);
					},
					'success' : function(d, textStatus, jqXHR){
						alert(d.msg);
						updateTable();
					}
				});
			}else
				alert('Please select one or more rows to apply bulk action');
		}
	});
</script>
<?php endif;?>