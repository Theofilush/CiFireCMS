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
			<span class="breadcrumb-item"><?php echo lang_line('mod_title_all');?></span>
		</div>
	</div>
</div>

<div class="content">

	<?php echo $this->alert->show($this->mod);?>

	<div class="block">
		<div class="block-header">
			<h3><?php echo lang_line('mod_title_all');?></h3>
			<div class="pull-right">
				<a href="<?php echo admin_url($this->mod.'/add-new');?>" class="button btn-sm btn-primary mr-2"><i class="icon-add mr-2"></i><?php echo lang_line('button_add_new');?></a>
				<a href="<?php echo admin_url('compogen');?>" class="button btn-sm btn-default"><i class="icon-cup2 mr-2"></i>CompoGen</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table id="DataTable" class="display responsive no-wrap table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th><?php echo lang_line('table_name');?></th>
							<th><?php echo lang_line('table_type');?>
							<th><?php echo lang_line('table_status');?></th>
							<th class="no-sort text-center"><?php echo lang_line('table_action');?></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>