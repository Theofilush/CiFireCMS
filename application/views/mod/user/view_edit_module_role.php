<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="form-group">
	<label><?php echo lang_line('mod_lang_2');?></label>
	<input type="text" name="module" class="form-control" value="<?php echo humanize($res_mod['module']);?>" disabled/>
	<input type="hidden" name="module" value="<?php echo $res_mod['module'];?>"/>
</div>
<label><?php echo lang_line('mod_lang_1');?></label>
<div>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th class="text-center"><?php echo lang_line('table_access_read');?></th>
				<th class="text-center"><?php echo lang_line('table_access_write');?></th>
				<th class="text-center"><?php echo lang_line('table_access_modify');?></th>
				<th class="text-center"><?php echo lang_line('table_access_delete');?></th>
			</tr>
		</thead>
		<tr>
			<td class="text-center">
				<?php echo ( $res_mod['read_access'] == 'Y' ? '<input type="checkbox" name="read" checked>':'<input type="checkbox" name="read">' ); ?>
			</td>
			<td class="text-center">
				<?php echo ( $res_mod['write_access'] == 'Y' ? '<input type="checkbox" name="write" checked>':'<input type="checkbox" name="write">' ); ?>
			</td>
			<td class="text-center">
				<?php echo ( $res_mod['modify_access'] == 'Y' ? '<input type="checkbox" name="modify" checked>':'<input type="checkbox" name="modify">' ); ?>
			</td>
			<td class="text-center">
				<?php echo ( $res_mod['delete_access'] == 'Y' ? '<input type="checkbox" name="delete" checked>':'<input type="checkbox" name="delete">' );?>
			</td>
		</tr>
	</table>
</div>