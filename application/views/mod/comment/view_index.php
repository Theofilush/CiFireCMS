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
	<?=$this->alert->show($this->mod); ?>
	<div class="ajax_alert" style="display:none;"></div>
	<div class="block">
		<div class="block-header">
			<h3><?=lang_line('mod_title_all');?></h3>
		</div>
		<div class="row">
			<div class="table-responsive">
				<div class="col-md-12">
					<table id="DataTable" class="display responsive no-wrap table table-striped table-hover table-bordered table-content">
						<thead>
							<tr>
								<th class="no-sort text-center">
									<input type="checkbox" class="select_all" data-toggle="tooltip" data-placement="top" data-title="<?=lang_line('tooltip_select_all');?>">
								</th>
								<th><i class="fa fa-eye"></i></th>
								<th><?=lang_line('table_name'); ?></th>
								<th><?=lang_line('table_comment'); ?></th>
								<th><?=lang_line('table_date'); ?></th>
								<th class="th-action text-center"><?=lang_line('table_action'); ?></th>
							</tr>
						</thead>
						<tbody></tbody>
						<tr id="delall">
							<td colspan="6">
								<button type="button" class="delete_multi button btn-sm btn-default text-danger"><i class="icon-bin"></i> <?=lang_line('button_delete_selected_item');?></button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="modal_detail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?=form_open(); ?>
			<input type="hidden" name="id_comment" id="id_comment">
			<input type="hidden" name="id_parent" id="id_parent">
			<input type="hidden" name="id_post" id="id_post">
			<div class="modal-header">
				<h5 class="modal-title"><i class="icon-bubble-dots4  mr-2"></i><?=lang_line('mod_lang_1');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div id="cdet"></div>
			</div>
			<div class="modal-footer">
				<span class="button btn-sm btn-default" data-dismiss="modal" aria-hidden="true"><?=lang_line('button_close');?></span>
			</div>
			<?=form_close(); ?>
		</div>
	</div>
</div>

<div id="modal_delete" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?=form_open('','id="form_delete"'); ?>
			<input id="idDel" type="hidden" name="id">
			<input type="hidden" name="act" value="delete">
			<div class="modal-header">
				<h5 class="modal-title"><i class="icon-warning22 text-danger mr-2"></i><?=lang_line('dialog_delete_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h4><?=lang_line('dialog_delete_content');?></h4>
			</div>
			<div class="modal-footer">
				<button id="submit_delete" type="button" class="button btn-default text-danger"><i class="fa fa-trash"></i>&nbsp; <?=lang_line('button_yes');?></button>
				<span class="button btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out"></i>&nbsp; <?=lang_line('button_no');?></span>
			</div>
			<?=form_close(); ?>
		</div>
	</div>
</div>

<div id="modal_block" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?=form_open('','id="form_blocked" autocomplete="off"'); ?>
			<input type="hidden" name="act" value="block">
			<input type="hidden" name="id" id="idCom" >
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-ban text-danger mr-2"></i><?=lang_line('dialog_block_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" id="cdet">
				<h4><?=lang_line('dialog_block_content');?></h4>
			</div>
			<div class="modal-footer">
				<button type="submit" class="button btn-default text-danger"><i class="fa fa-ban"></i> <?=lang_line('button_yes');?></button>
					<button type="button" class="button btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out"></i> <?=lang_line('button_no');?></button>
			</div>
			<?=form_close(); ?>
		</div>
	</div>
</div>

<div id="modal_unblock" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?=form_open('','id="form_blocked" autocomplete="off"'); ?>
			<input type="hidden" name="act" value="unblock">
			<input type="hidden" name="id" id="idComu" >
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-check-circle-o text-success mr-2"></i><?=lang_line('dialog_unblock_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" id="cdet">
				<h4><?=lang_line('dialog_unblock_content');?></h4>
			</div>
			<div class="modal-footer">
				<button type="submit" class="button btn-primary"><i class="fa fa-check"></i> <?=lang_line('button_yes');?></button>
					<button type="button" class="button btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out"></i> <?=lang_line('button_no');?></button>
			</div>
			<?=form_close(); ?>
		</div>
	</div>
</div>