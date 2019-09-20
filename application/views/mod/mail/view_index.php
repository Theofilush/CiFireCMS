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
			<span class="breadcrumb-item"><?php echo lang_line('inbox');?></span>
		</div>
	</div>
</div>

<div class="content">
	<?php echo $this->alert->show($this->mod); ?>
	<div class="ajax_alert" style="display:none;"></div>

	<div class="block">
		<div class="block-header">
			<h3><?php echo lang_line('inbox');?></h3>
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
								<th class="text-align"><i class="fa fa-envelope-o text-muted"></i></th>
								<th><?php echo lang_line('table_from');?></th>
								<th><?php echo lang_line('table_subject');?></th>
								<th><?php echo lang_line('table_date');?></th>
								<th class="text-center no-sort"><?php echo lang_line('table_action');?></th>
							</tr>
						</thead>
						<tbody></tbody>
						<tr id="delall">
							<td colspan="6">
								<button type="button" class="button btn-sm btn-default text-danger delete_multi"><i class="icon-bin"></i> <?php echo lang_line('button_delete_selected_item');?></button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>