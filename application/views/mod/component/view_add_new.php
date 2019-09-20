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

	<?php echo $this->alert->show($this->mod);?>

	<div class="block">
		<div class="row">
			<div class="col-md-12">
				<div class="block-header">
					<h3><?php echo lang_line('mod_title_add');?></h3>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
			<?php 
				echo form_open_multipart();
				echo form_hidden('act', 1);
			?>
			<div class="mb-5">
				<p><?php echo lang_line('note1'); ?></p>
				<p><a href="javascript:void(0)" class="c_structure"><i class="fa fa-dropbox mr-2"></i><?php echo lang_line('note2'); ?></a></p>
			</div>
			<div class="form-group">
				<label><?php echo lang_line('form_label_file');?> (.zip)</label>
				<input type="file" name="file" required>
				<div class="form-input-error"><?php echo form_error('file');?></div>
			</div>
			<br>
			<hr>
			<div class="block-actions">
                <button type="submit" class="button btn-primary text-b"><i class="fa fa-check mr-2"></i><?php echo lang_line('button_install');?></button>
				<a href="<?php echo admin_url($this->mod);?>" class="pull-right button btn-md btn-default text-b"><i class="fa fa-times mr-2"></i><?php echo lang_line('button_cancel');?></a>
			</div>
			<?php echo form_close();?>
			</div>
		</div>
	</div>
</div>

<div id="c_structure" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang_line('package_structure'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
<pre><code><b>component-video.zip</b>/
 ├── <b>controllers</b>/
 │   └── Video.php
 ├── <b>models</b>/
 │   └── Video_model.php
 ├── <b>modjs</b>/
 │   └── video.js
 ├── <b>sql</b>/
 │   └── t_video.sql
 ├── <b>views</b>/
 │   ├── view_add_new.php
 │   ├── view_edit.php
 │   ├── view_index.php
 │   └── index.html
 └── config.php
</code></pre>
			</div>
		</div>
	</div>
</div>