<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/uploadify/uploadify.css" />
<script type="text/javascript" language="javascript" src="<?php echo HTTP_PROTOCOL;?>://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/uploadify/jquery.uploadify.min.js"></script>
<div class='violet-table'>
	<table>
		<tr>
			<td>Brand Name</td>
			<td>Logo</td>
			<td>Is Top</td>
			<td>Action</td>
		</tr>
		<?php foreach($brands as $brand){ ?>
			<tr id="brand-list<?php echo $brand->b_id?>">
				<td><?php echo $brand->b_name?></td>
				<td>
					<?php if(!empty($brand->logo)):?>
						<img id="b-logo-<?php echo $brand->b_id?>" src="<?php echo base_url();?>/images/brands/<?php echo $brand->logo?>" width="190" height="99">
					<?php else:?>
						<img id="b-logo-<?php echo $brand->b_id?>" src="" width="190" height="99" hidden="true">
					<?php endif;?>
					<?php echo form_open_multipart('upload/index');?>
					<p>
						<label for="Filedata">Choose a File To Change</label><br/>
						<?php echo form_upload(array('name' => 'Filedata', 'id' => 'upload-'.$brand->b_id, 'data-bid'=>$brand->b_id, 'class'=>'uploader'));?>
					</p>
					<?php echo form_close();?>
				</td>
				<td>
					<a onclick="return toggleTop(<?php echo $brand->b_id?>,'<?php echo $this->security->get_csrf_token_name()?>','<?php echo $this->security->get_csrf_hash()?>')" id="toggle-top-<?php echo $brand->b_id?>" href="javascript:void(0);" title="<?php echo ($brand->is_top === '1')?'Make Not Top':'Make Top'?>" class="<?php echo ($brand->is_top === '1')?'approve':'deny'?>"><?php echo ($brand->is_top === '1')?'On':'Off'?></a>
				</td>
				<td>
					<a onclick="return deletebrand(<?php echo $brand->b_id?>)" href="#deletebrand">delete</a>
				</td>
			</tr>
		<?php }?>

	</table>
</div>

<script type="text/javascript">
	$(function(){
		$.each($('input.uploader'),function(idx,el){
			$(el).uploadify({
				'swf': '<?php echo base_url();?>js/uploadify/uploadify.swf',
				'uploader': '<?php echo base_url();?>js/uploadify/upload.php',
				'method': 'post',
				'buttonClass': '',
				'formData': {'timestamp':<?php echo time(); ?>, 'folder': '<?php echo base_dir();?>images/brands/'},
				'onUploadSuccess': function (file, data, response) {
					//console.log(el,file, data, response);
					//Post response back to controller

					if (data == "FAILED") {
						return false;
					}
					$.post('<?php echo site_url('brand/change_image');?>',
						{bid: $(el).attr('data-bid'), fname: data,'<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},
						function (info) {
							//$("#target-image-upload").append(info);
							if(info.res == 1)
								$('#b-logo-'+$(el).attr('data-bid')).attr('src','<?php echo base_url();?>images/brands/'+data).removeAttr('hidden');
							else
								alert('error');
						},'json');
				}
			});
		});
	});
</script>
