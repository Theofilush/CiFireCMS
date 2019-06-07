<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">

	<?=$this->alert->show($this->mod.'edit');?>
	<div class="ajax_alert" style="display:none;"></div>

	<div class="block-content">
		<div class="row">
			<div class="col-md-12">
				<div class="block-header">
					<h3><?=lang_line('mod_title_edit');?>&nbsp;<?=lang_line('mod_title');?></h3>
					<ol class="breadcrumb">
						<li><a href="<?=admin_url();?>"><?=lang_line('admin_link_home');?></a></li>
						<li><?=lang_line('mod_title');?></li>
						<li><?=lang_line('mod_title_edit');?>&nbsp;<?=lang_line('mod_title');?></li>
					</ol>
				</div>
			</div>
		</div>
		<div class="row">
		<div class="col-md-12">
			<?php 
				echo form_open('', 'autocomplete="off" class="form-bordered"');
				echo form_hidden('act', 'edit');
			?>
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label><?=lang_line('form_label_parent');?></label>
						<select class="select-chosen" name="parent">
							<?php
								$scp = $this->db->like('id_parent', $res_category['id'])->get('t_category')->num_rows();
								if ($scp > 0) {
									echo '<option value="0" style="display:none;">'.lang_line('form_label_no_parent').'</option>';
								}
								else {
									$res_parent = $this->db->where('id',$res_category['id_parent'])->get('t_category')->row_array();

									if (!empty($res_parent['id'])) {
										echo '<option value="'.$res_parent['id'].'" style="display:none;">'.$res_parent['title'].'</option>';
									}
									else {
										echo '<option value="0" style="display:none;">'.lang_line('form_label_no_parent').'</option>';
									}
										
									foreach ($pcategory as $val_p) {
										echo '<option value="'.$val_p['id'].'">'.$val_p['title'].'</option>';
									}
								}
							?>
							<option value="0"><?=lang_line('form_label_no_parent');?></option>
						</select>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label><?=lang_line('form_label_active');?></label>
						<select class="form-control" name="active">
							<option value="<?=$res_category['active'];?>" style="display: none;"><?=$res_category['active'];?></option>
							<option value="Y">Y</option>
							<option value="N">N</option>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label><?=lang_line('form_label_title');?> <span class="text-danger">*</span></label>
				<input id="title" type="text" name="title" class="form-control" value="<?=$res_category['title'];?>">
				<div class="form-input-error"><?=form_error('title');?></div>
			</div>
			<div class="form-group">
				<label><?=lang_line('form_label_seotitle');?> <span class="text-danger">*</span></label>
				<input id="seotitle" type="text" name="seotitle" class="form-control" value="<?=$res_category['seotitle'];?>">
				<div class="form-input-error"><?=form_error('seotitle');?></div>
				<div class="pull-right">
					<small>Permalink : <span class="text-success"><?=site_url('category/');?><span id="permalink"><?=$res_category['seotitle'];?></span></span></small>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="form-group">
				<label><?=lang_line('form_label_description');?></label>
				<textarea name="description" class="form-control"><?=$res_category['description'];?></textarea>
			</div>
			<div class="block-actions">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;<?=lang_line('button_save');?></button>
				<a href="<?=admin_url($this->mod);?>" class="pull-right btn btn-danger"><i class="fa fa-times"></i> &nbsp;&nbsp;<?=lang_line('button_cancel');?></a>
				<div class="clearfix"></div>
			</div>
			<?=form_close();?>
		</div>
		</div>
	</div>
</div>