<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-inline">
		<div class="page-title">
			<h3>
				<span class="font-weight-semibold"><?=lang_line('mod_title');?></span>
			</h3>
		</div>
	</div>
	<div class="breadcrumb-line breadcrumb-line-light">
		<div class="breadcrumb">
			<a href="<?=admin_url('home');?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> <?=lang_line('admin_link_home');?></a>
			<span class="breadcrumb-item"><?=lang_line('mod_title');?></span>
			<span class="breadcrumb-item"><?=lang_line('mod_title_level');?></span>
		</div>
	</div>
</div>

<div class="content">

	<?=$this->alert->show($this->mod); ?>
	<div class="ajax_alert" style="display:none;"></div>
	
	<div class="block">
		<div class="block-header">
			<h3><?=lang_line('mod_title_level');?></h3>
			<div class="pull-right">
				<button class="button btn-sm btn-primary add_level"><i class="icon-add"></i> <?=lang_line('button_add_level');?></button>
				<a href="<?php echo admin_url($this->mod);?>" class="button btn-sm btn-default ml-2"><i class="fa fa-user"></i> <?php echo lang_line('mod_title');?></a>
			</div>
			<div class="btn-title pull-right">
				
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table id="DataTableLevel" class="display responsive no-wrap table table-striped table-bordered table-hover no-footer table-vcenter">
					<thead>
						<tr>
							<th>Id</th>
							<th><?=lang_line('table_title');?></th>
							<th><?=lang_line('table_level');?></th>
							<th>Menu</th>
							<th class="text-center"><?=lang_line('table_action');?></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<div id="modal_add_level" class="modal fade">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					<i class="icon-medal2  mr-1"></i><?=lang_line('mod_title_add');?>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<?php 
				echo form_open('','autocomplete="off"');
				echo form_hidden('act','add_level');
			?>
			<div class="modal-body">
				<div class="form-group">
					<label><?=lang_line('form_label_level');?></label>
					<input id="level-title-input" type="text" name="title" class="form-control" placeholder="Ex: Group Level" required>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="button btn-primary"><i class="fa fa-check mr-2"></i><?=lang_line('button_submit');?></button>
				<button type="reset" class="button btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times mr-2"></i><?=lang_line('button_cancel');?></button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<!-- <div id="modal_delete_level" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="form_delete_level" method="POST" action="" autocomplete="off">
			<?php 
				echo form_open('','autocomplete="off"');
				echo form_hidden('act','delete_level');
				echo form_input(array(
					'type' => 'hidden',
					'name' => 'id',
					'id' => 'idLevel'
				));
			?>
			<div class="modal-header">
					
				<h4 class="modal-title"><i class="fa fa-exclamation-triangle text-danger"></i>&nbsp; <?=lang_line('dialog_delete_title');?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body" style="font-size:18px;padding:30px 15px;">
					<?=lang_line('dialog_delete_content');?>
				</div>
			<div class="modal-footer">
				<button id="submit_delete_level" type="button" class="btn btn-md btn-danger"><i class="fa fa-trash"></i>&nbsp; <?=lang_line('button_yes');?></button>
				<button type="button" class="btn btn-md btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out"></i>&nbsp; <?=lang_line('button_no');?></button>
			</div>
			<?=form_close();?>
		</div>
	</div>
</div> -->




<div id="modal_preview_level" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5> <i class="icon-medal2 mr-1"></i>Level : <span class="badge badge-primary badge-pill" id="data-detail-title"></span> </h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div id="data-detail" class="modal-body">	
			</div>
		</div>
	</div>
</div>
