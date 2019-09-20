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
			<span class="breadcrumb-item"><?php echo lang_line('mod_title_add');?></span>
		</div>
	</div>
</div>

<div class="content">
	<?php echo $this->alert->show($this->mod); ?>
	<div class="block">
		<div class="block-header">
			<h3><?php echo lang_line('mod_title_add');?></h3>
			<div class="pull-right">
				<a href="<?php echo admin_url($this->mod);?>" class="button btn-sm btn-default"><i class="fa fa-arrow-circle-o-left"></i> <?php echo lang_line('mod_title');?></a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo form_open_multipart('','autocomplete="offX"'); ?>
				<input type="hidden" name="act" value="add_new">
				<div>
					<div class="form-group">
						<label><?php echo lang_line('form_label_title');?> <span class="text-danger">*</span></label></label>
						<input type="text" name="title" class="form-control" required style="max-width:410px;" />
					</div>
					<div class="form-group">
						<label>Theme Package <span class="text-danger">*</span></label></label>
						<input type="file" name="fupload" class="file-input" 
							data-show-caption="false" 
							data-browse-label="Browse zip file" 
							data-remove-class="btn btn-danger" 
							data-upload-class="btn btn-primary" 
							data-upload-label="Install"
							data-upload-icon="<i class='fa fa-check mr-1'></i>"
							data-browse-class="btn btn-default" 
							data-fouc="" required>
					</div>
				</div>
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</div>