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
			<span class="breadcrumb-item"><?=lang_line('mod_title_add');?></span>
		</div>
	</div>
</div>

<div class="content">

	<?=$this->alert->show($this->mod.'add');?>
	<div class="ajax_alert" style="display:none;"></div>

	<div class="block">
		<div class="row">
			<div class="col-md-12">
				<div class="block-header">
					<h3><?=lang_line('mod_title_add');?></h3>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
			<?php 
				echo form_open_multipart();
				echo form_hidden('act', 1);
			?>
			<div class="form-group">
				<label><?=lang_line('form_label_name');?></label>
				<input type="text" name="name" class="form-control" value="<?=set_value('title');?>" required>
				<div class="form-input-error"><?=form_error('name');?></div>
			</div>
			<div class="form-group">
				<label>Class</label>
				<input id="classname" type="text" name="class_name" class="form-control" required>
				<div class="form-input-error"><?=form_error('class_name');?></div>
			</div>
			<div class="form-group">
				<label><?=lang_line('form_label_table');?></label>
				<input id="tablename" type="text" name="table_name" class="form-control" required>
				<div class="form-input-error"><?=form_error('table_name');?></div>
			</div>
			<div class="form-group">
				<label><?=lang_line('form_label_file');?> (.zip)</label>
				<input type="file" name="file" required>
				<div class="form-input-error"><?=form_error('file');?></div>
			</div>
			<br>
			<hr>
			<div class="block-actions">
                <button type="submit" class="button btn-primary text-b"><i class="fa fa-check"></i> <?=lang_line('button_submit');?></button>
				<a href="<?=admin_url($this->mod);?>" class="pull-right button btn-md btn-default text-b"><i class="fa fa-times"></i> <?=lang_line('button_cancel');?></a>
			</div>
			<?=form_close();?>
			</div>
		</div>
	</div>
</div>