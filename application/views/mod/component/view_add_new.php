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

	<?=$this->alert->show($this->mod);?>

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
			<div class="mb-5">
				<p>Sebelum melanjutkan proses instalasi harap backup dahulu seluruh file web dan database.</p><p>Pastikan file package komponen berekstensi *.zip dan struktur filenya sesuai standar package CiFireCMS.</p>
				<p><a href="javascript:void(0)" class="c_structure"><i class="fa fa-dropbox mr-2"></i>Lihat struktur paket.</a></p>
				
			</div>
			<div class="form-group">
				<label><?=lang_line('form_label_file');?> (.zip)</label>
				<input type="file" name="file" required>
				<div class="form-input-error"><?=form_error('file');?></div>
			</div>
			<br>
			<hr>
			<div class="block-actions">
                <button type="submit" class="button btn-primary text-b"><i class="fa fa-check mr-2"></i><?=lang_line('button_install');?></button>
				<a href="<?=admin_url($this->mod);?>" class="pull-right button btn-md btn-default text-b"><i class="fa fa-times mr-2"></i><?=lang_line('button_cancel');?></a>
			</div>
			<?=form_close();?>
			</div>
		</div>
	</div>
</div>

<div id="c_structure" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Component Package Structure</h5>
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