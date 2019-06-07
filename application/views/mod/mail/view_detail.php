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
			<span class="breadcrumb-item"><?=lang_line('mod_title_all');?></span>
			<span class="breadcrumb-item"><?=lang_line('mod_title_add');?></span>
			<span class="breadcrumb-item"><?=lang_line('mod_title_edit');?></span>
		</div>
	</div>
</div>

<div class="content">
	<?=$this->alert->show($this->mod.'detail'); ?>

	<div class="block">
		<div class="row">
			<div class="col-md-12">
				<div class="block-header">
					<h3><?=lang_line('mod_title');?></h3>
					<ol class="breadcrumb">
						<li><a href="<?=admin_url();?>"><?=lang_line('admin_link_home');?></a></li>
						<li><?=lang_line('mod_title');?></li>
						<li><?=lang_line('mod_title_detail');?></li>
					</ol>
					<div class="btn-title pull-right">
						<a href="<?=admin_url($this->mod);?>" class="btn btn-sm btn-info btn-b" idDel="<?=$res_message['id'];?>"><i class="fa fa-envelope"></i>&nbsp; <?=lang_line('mod_title');?></a>
						<button type="button" class="btn btn-sm btn-danger btn-b modal_delete_mail" idDel="<?=$res_message['id'];?>"><i class="fa fa-trash"></i>&nbsp; <?=lang_line('button_delete');?></button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table>
					<tr>
						<td><?=lang_line('table_from');?></td>
						<td width="20" class="text-center"> : </td>
						<td><?=$res_message['name'];?> (<?=$res_message['email'];?>)</td>
					</tr>
					<tr>
						<td><?=lang_line('table_date');?></td>
						<td width="20" class="text-center"> : </td>
						<td><small><?=date_time($res_message['date'],2);?></small></td>
					</tr>
					<tr>
						<td><?=lang_line('table_subject');?></td>
						<td width="20" class="text-center"> : </td>
						<td><?=$res_message['subject']?></td>
					</tr>
				</table>
				<br>
				<div><?=$this->security->xss_clean($res_message['message']);?></div>
			</div>
		</div>
	</div>
</div>

<div id="modal_delete" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php
				echo form_open('','autocomplete="off"');
				echo form_hidden('act','delete');
				echo form_input(array(
					'type' => 'hidden',
					'name' => 'id',
					'id' => 'idDel'
				));
			?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<i class="fa fa-exclamation-triangle text-danger"></i>&nbsp;&nbsp;<?=lang_line('dialog_delete_title');?>
			</div>
			<div class="modal-body">
				<?=lang_line('dialog_delete_mail_content');?>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-md btn-danger"><i class="fa fa-trash"></i>&nbsp; <?=lang_line('button_yes');?></button>
				<button type="button" class="btn btn-md btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out"></i>&nbsp; <?=lang_line('button_no');?></button>
			</div>
			<?=form_close(); ?>
		</div>
	</div>
</div>
