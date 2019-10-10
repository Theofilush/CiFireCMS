<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<h2>Edit Menu</h2>
<?php 
	echo form_open(admin_url('menumanager/editsinglemenu'), 'id="formeditmenu" autocomplete="off"');
?>
<input type="hidden" name="acc" value="editsinglemenu">
<input type="hidden" name="menu_id" value="<?php echo $res_menu->id; ?>">
<input type="hidden" name="g_id" value="<?php echo $res_menu->group_id; ?>">
<p>
	<label for="edit-menu-title">Title</label>
	<input type="text" name="title" id="edit-menu-title" value="<?php echo $res_menu->title; ?>">
</p>
<p>
	<label for="edit-menu-url">URL</label>
	<input type="text" name="url" id="edit-menu-url" value="<?php echo $res_menu->url; ?>">
</p>
<p>
	<label for="edit-menu-class">Class</label>
	<input type="text" name="class" id="edit-menu-class" value="<?php echo $res_menu->class; ?>">
</p>
<p>
	<label for="edit-menu-class">Active</label>
	<select name="active" id="edit-menu-active">
		<option value="<?php echo $res_menu->active;?>" style="display: none;"><?php echo $res_menu->active; ?></option>
		<option value="Y">Y</option>
		<option value="N">N</option>
	</select>
</p>
<?php echo form_close();?>