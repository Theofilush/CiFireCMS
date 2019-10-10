<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-inline">
		<div class="page-title">
			<h3>
				<span class="font-weight-semibold"><?php echo lang_line('mod_title');?></span>
			</h3>
		</div>
	</div>
	<div class="breadcrumb-line breadcrumb-line-light">
		<div class="breadcrumb">
			<a href="<?php echo admin_url('home');?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> <?php echo lang_line('admin_link_home');?></a>
			<span class="breadcrumb-item"><?php echo lang_line('mod_title');?></span>
			<span class="breadcrumb-item"><?php echo lang_line('mod_title_level');?></span>
			<span class="breadcrumb-item"><?php echo lang_line('mod_title_role');?></span>
		</div>
	</div>
</div>

<div class="content">

	<?php echo $this->alert->show($this->mod); ?>

	<div class="block">
		<div class="block-header">
			<h3><?php echo lang_line('mod_title_role');?></h3>
			<div class="pull-right">
				<button type="button" class="add_module_role button btn-sm btn-primary"><i class="icon-add mr-1"></i><?php echo lang_line('button_add_role');?></button>
				<a href="<?php echo admin_url($this->mod.'/level');?>" class="button btn-sm btn-default ml-2"><i class="icon-medal2  mr-1"></i><?php echo lang_line('button_level_user');?></a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h4>Level : <span class="text-strong text-primary"><?php echo $res_level['title'];?></span></h4>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover table-vcenter no-footer">
						<thead>
							<tr>
								<th class="text-center"><?php echo lang_line('mod_lang_2');?></th>
								<th class="text-center"><?php echo lang_line('table_access_read');?></th>
								<th class="text-center"><?php echo lang_line('table_access_write');?></th>
								<th class="text-center"><?php echo lang_line('table_access_modify');?></th>
								<th class="text-center"><?php echo lang_line('table_access_delete');?></th>
								<th class="text-center"><?php echo lang_line('table_action');?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($all_module as $res_mod): ?>
							<tr>
								<td><?php echo humanize($res_mod['module']);?></td>
								<td class="text-center">
									<?php if ($res_mod['read_access'] === 'Y') echo '<span><i class="fa fa-check text-success"></i></span>'; ?>
								</td>
								<td class="text-center">
									<?php if ($res_mod['write_access'] === 'Y') echo '<span><i class="fa fa-check text-success"></i></span>'; ?>
								</td>
								<td class="text-center">
									<?php if ($res_mod['modify_access'] === 'Y') echo '<span><i class="fa fa-check text-success"></i></span>'; ?>
								</td>
								<td class="text-center">
									<?php if ($res_mod['delete_access'] === 'Y') echo '<span><i class="fa fa-check text-success"></i></span>'; ?>
								</td>
								<td class="text-center">
									<div class="btn-group">
										<button class="button btn-xs btn-default edit_module_role" data-toggle="tooltip" data-placement="top" data-title="<?php echo lang_line('button_edit');?>" id-module="<?php echo $res_mod['role_id'];?>"><i class="fa fa-pencil"></i></button>
										<button class="moda_delete_module button btn-xs btn-default" data-toggle="tooltip" data-placement="top" data-title="<?php echo lang_line('button_delete');?>" idMod="<?php echo $res_mod['role_id'];?>" ><i class="icon-bin"></i></button>
									</div>
								</td>
							</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="modal_add_module_role" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php 
				echo form_open('','autocomplete="off"');
				echo form_hidden('act','add-module');
			?>
			<div class="modal-header">
				<h5><i class="icon-clipboard2 mr-2"></i><?php echo lang_line('mod_add_role');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label><?php echo lang_line('mod_lang_2');?> <span class="text-danger">*</span></label>
					<select name="module" class="select-2" data-placeholder="<?php echo lang_line('mod_lang_3');?>" required>
						<option value=""></option>
						<?php
							$mod_dir    = FCPATH.'application/controllers/'.FADMIN.'/';
							$modules = array_diff(scandir($mod_dir), array('..', '.','index.html','Login.php'));
							foreach ($modules as $keys) {
								$modname = trim($keys,'.php');
								$modkey = strtolower($modname);
								$modcek = $this->CI->user_model->module_list($res_level['id'],$modkey);
								$dis = ( $modkey==$modcek ? 'disabled':'' );
								echo  '<option value="'.$modkey.'" '.$dis.'>'.$modname.'</option>';
							}
						?>
					</select>
				</div>
				<label><?php echo lang_line('mod_lang_1');?></label>
				<div>
					<table class="table table-condensed table-bordered" style="font-size: 13px;">
						<thead>
							<tr>
								<th class="text-center"><?php echo lang_line('table_access_read');?></th>
								<th class="text-center"><?php echo lang_line('table_access_write');?></th>
								<th class="text-center"><?php echo lang_line('table_access_modify');?></th>
								<th class="text-center"><?php echo lang_line('table_access_delete');?></th>
							</tr>
						</thead>
						<tr>
							<td class="text-center"><input type="checkbox" name="read" value="Y"></td>
							<td class="text-center"><input type="checkbox" name="write" value="Y"></td>
							<td class="text-center"><input type="checkbox" name="modify" value="Y"></td>
							<td class="text-center"><input type="checkbox" name="delete" value="Y"></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="button btn-primary"><i class="fa fa-check mr-2"></i><?php echo lang_line('button_submit');?></button>
				<button type="reset" class="button btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times mr-2"></i><?php echo lang_line('button_cancel');?></button>
			</div>
			<?php echo form_close();?>
		</div>
	</div>
</div>

<div id="modal_edit_module_role" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" autocomplete="off">
			<?php 
				echo form_open('','autocomplete="off"');
				echo form_hidden('act','update-module-access');
			?>
			<input type="hidden" name="id" id="id_module"/>
			<div class="modal-header">
				<h5><i class="icon-clipboard2 mr-2"></i><?php echo lang_line('mod_edit_role');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div id="view-edit-module"></div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="button btn-md btn-primary"><i class="fa fa-save mr-2"></i><?php echo lang_line('button_save');?></button>
				<button type="button" class="button btn-md btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times mr-2"></i><?php echo lang_line('button_cancel');?></button>
			</div>
			<?php echo form_close();?>
		</div>
	</div>
</div>

<div id="modal_delete_module" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php 
				echo form_open('','autocomplete="off"');
				echo form_hidden('act','modul-delete');
			?>
			<input type="hidden" name="id" id="idMod"/>
			<div class="modal-header">
				<h4><i class="fa fa-exclamation-triangle text-danger mr-3"></i><?php echo lang_line('dialog_delete_title');?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<h4><?php echo lang_line('dialog_delete_content');?></h4>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-md btn-danger"><i class="icon-bin mr-2"></i><?php echo lang_line('button_yes');?></button>
				<button type="button" class="btn btn-md btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out mr-2"></i><?php echo lang_line('button_no');?></button>
			</div>
			<?php echo form_close();?>
		</div>
	</div>
</div>