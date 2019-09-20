<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-inline">
		<div class="page-title">
			<h3>
				<span class="font-weight-semibold"><?php echo lang_line('mod_title'); ?></span>
			</h3>
		</div>
	</div>
	<div class="breadcrumb-line breadcrumb-line-light">
		<div class="breadcrumb">
			<a href="<?php echo admin_url('home'); ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> <?php echo lang_line('admin_link_home') ?></a>
			<span class="breadcrumb-item"><?php echo lang_line('mod_title'); ?></span>
			<span class="breadcrumb-item"><?php echo lang_line('mod_title_all'); ?></span>
		</div>
	</div>
</div>
<div class="content">
	<?php echo $this->alert->show($this->mod);?>
	<div class="ajax_alert" style="display:none;"></div>
	<div class="block">
		<div class="block-header">
			<h3><?php echo lang_line('mod_title_all');?></h3>
			<div class="pull-right">
				<button class="modal_add button btn-primary btn-sm"><i class="icon-add"></i> <?php echo lang_line('button_add_new');?></button>
			</div>
		</div>
		<div class="row">
			<div class="table-responsive">
				<div class="col-md-12">
					<table id="DataTable" class="display responsive no-wrap table table-bordered table-striped table-hover table-content">
						<thead>
							<tr>
								<th class="no-sort text-center">
									<input type="checkbox" class="select_all" data-toggle="tooltip" data-placement="top" data-title="<?php echo lang_line('tooltip_select_all');?>">
								</th>
								<th>Title</th>
								<th>Count</th>
								<th class="th-action text-center">Action</th>
							</tr>
						</thead>
						<tbody></tbody>
						<tr id="delall" class="table-delall">
							<td colspan="4">
								<button type="button" class="button btn-sm btn-default text-danger delete_multi"><i class="icon-bin"></i> <?php echo lang_line('button_delete_selected_item');?></button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="modal_add" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?php echo form_open();?>
			<input type="hidden" name="act" value="input">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-tags mr-2"></i><?php echo lang_line('dialog_add_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div>
					<input id="tag" type="text" name="tags" class="input-tags" required>
					<small><i><?php echo lang_line('mod_lang_1'); ?></i></small>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="button btn-primary"><i class="fa fa-check"></i> <?php echo lang_line('button_submit');?></button>
				<span class="button btn-default" data-dismiss="modal" aria-hidden="true"><?php echo lang_line('button_cancel');?></span>
			</div>
			<?php echo  form_close(); ?>
		</div>
	</div>
</div>