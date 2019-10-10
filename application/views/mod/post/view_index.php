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
	<?php echo $this->alert->show($this->mod); ?>
	<div class="ajax_alert" style="display:none;"></div>
	
	<div class="block">
		<div class="block-header">
			<h3><?php echo lang_line('mod_title_all');?></h3>
			<div class="pull-right">
				<a href="<?php echo admin_url($this->mod.'/add-new');?>" class="button btn-primary btn-sm"><i class="icon-add mr-1"></i><?php echo lang_line('button_add_new');?></a>
			</div>
		</div>
		<div class="row">
			<div class="table-responsive">
				<div class="col-md-12">
					<table id="DataTable" class="display responsive no-wrap table table-striped table-hover table-bordered table-content">
						<thead>
							<tr>
								<th class="no-sort text-center">
									<input type="checkbox" class="select_all" data-toggle="tooltip" data-placement="top" data-title="<?php echo lang_line('tooltip_select_all');?>">
								</th>
								<th><?php echo lang_line('table_title');?></th>
								<th><?php echo lang_line('table_category');?></th>
								<th>Status</th>
								<th class="th-action text-center"><?php echo lang_line('table_action');?></th>
							</tr>
						</thead>
						<tbody></tbody>
						<tr id="delall">
							<td colspan="5">
								<button type="button" class="button btn-sm btn-default text-danger delete_multi"><i class="icon-bin"></i> <?php echo lang_line('button_delete_selected_item');?></button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Delete -->
<div id="modal_delete" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="form_delete" method="POST" accept-charset="utf-8">
				<input type="hidden" name="act" value="delete">
				<input type="hidden" name="id" id="id_delete">
				<div class="modal-header">
					<h5 class="modal-title"><i class="icon-warning22 text-danger mr-2"></i><?php echo lang_line('dialog_delete_title');?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<h4><?php echo lang_line('dialog_delete_content');?></h4>
				</div>
				<div class="modal-footer">
					<button type="submit" class="button btn-default text-danger submit_delete"><i class="fa fa-trash mr-2"></i><?php echo lang_line('button_yes');?></button>
					<span class="button btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out mr-2"></i><?php echo lang_line('button_no');?></span>
				</div>
			</form>
		</div>
	</div>
</div>