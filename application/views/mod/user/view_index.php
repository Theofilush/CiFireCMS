<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
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
	<div class="block">
		<div class="block-header">
			<h2><?php echo lang_line('mod_title_all');?></h2>
			<div class="pull-right">
				<a href="<?php echo admin_url($this->mod.'/add-new');?>" class="button btn-primary btn-sm"><i class="icon-add mr-1"></i><?php echo lang_line('button_add_new');?></a>
				<!-- button level -->
				<?php if ( login_level('admin')==1 ): ?>
				<a href="<?php echo admin_url($this->mod.'/level');?>" class="button btn-default btn-sm ml-2"><i class="icon-medal2 mr-1"></i><?php echo lang_line('button_level_user');?></a>
				<?php endif ?>
			</div>
		</div>
		<div class="row">
			<div class="table-responsive">
				<div class="col-md-12">
					<table id="DataTable" class="display responsive no-wrap table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th class="no-sort text-center">
									<input type="checkbox" class="select_all" data-toggle="tooltip" data-placement="top" data-title="<?php echo lang_line('tooltip_select_all');?>">
								</th>
								<th class="no-sort text-center"><i class="fa fa-photo"></i></th>
								<th><?php echo lang_line('table_username');?></th>
								<th><?php echo lang_line('table_fullname');?></th>
								<th><?php echo lang_line('table_level');?></th>
								<th>Status</th>
								<th class="th-action text-center"><?php echo lang_line('table_action');?></th>
							</tr>
						</thead>
						<tbody></tbody>
						<tr id="delall">
							<td colspan="8">
								<button type="button" class="button btn-sm btn-default text-danger delete_multi"><i class="icon-bin"></i> <?php echo lang_line('button_delete_selected_item');?></button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>