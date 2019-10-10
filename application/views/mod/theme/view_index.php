<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-inline">
		<div class="page-title">
			<h3><span class="font-weight-semibold"><?php echo lang_line('mod_title');?></span></h3>
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
	<?php echo $this->alert->show($this->mod); ?>
	<div class="block">
		<div class="block-header">
			<h3><?php echo lang_line('mod_title_all'); ?></h3>
			<div class="pull-right">
				<a href="<?php echo admin_url($this->mod.'/add-new');?>" class="button btn-sm btn-primary mr-2"><i class="icon-add"></i> <?php echo lang_line('button_add_new');?></a>
				<span class="button btn-sm btn-default c_blank_theme"><i class="fa fa-magic"></i> <?php echo lang_line('button_create_blank_theme');?></span>
			</div>
		</div>
		<div class="row">
			<?php
				foreach ( $all_themes as $res ):
					$img_preview = ( file_exists(CONTENTPATH.'/themes/'.$res['folder'].'/preview.jpg') ? content_url('themes/'.$res['folder'].'/preview.jpg') : content_url('images/noimage.jpg') );
			?>
			<div id="theme-item-<?php echo $res['id'];?>" class="col-lg-3">
				<div class="card">
					<div class="card-body text-center">
						<style>
							.theme-img-card{
								background-color: #f1f1f1;
								overflow: hidden;
								width: 100%;
								height: 150px;
								border: 1px solid #ddd;
								display: block;
								border-radius: 3px;
								margin: auto;
							}
							.theme-img-card img{
								width: 100%;	
								margin-top: -4%;
							}
						</style>
						<p><?php echo $res['title'];?></p>
						<div class="theme-img-card">
							<a href="<?php echo $img_preview;?>" title="<?php echo $res['title'];?>" class="fancybox" data-fancybox-group="">
								<img src="<?php echo $img_preview;?>" style="width:100%;" alt="<?php echo $res['title'];?>">
							</a>
						</div>

						<p class="mb-3"></p>
						<div class="btn-group">
							<?php if ($res['active'] == 'Y'): ?>
							<span class="button btn-flat btn-sm btn-default"><i class="fa fa-star text-warning"></i> <?php echo lang_line('button_active');?></span>
							<?php endif ?>

							<?php if ($res['active'] == 'N'): ?>
							<span class="button btn-flat btn-sm btn-default modal_active" idActive="<?php echo $res['id'];?>" data-toggle="tooltip" data-title="<?php echo lang_line('button_active');?>"><i class='fa fa-check'></i></span>
							<?php endif ?>
							
							<a href="<?php echo admin_url($this->mod.'/edit/'.$res['id'].'/home');?>" class="button btn-flat btn-sm btn-default alertedit" data-toggle="tooltip" title="<?php echo lang_line('button_edit');?>"><i class="fa fa-edit"></i></a>

							<span class="button btn-flat btn-sm btn-default backup_theme" data-toggle="tooltip" data-title="Download" data-theme-id="<?php echo encrypt($res['id']);?>" data-theme-folder="<?php echo encrypt($res['folder']);?>" data-theme-title="<?php echo encrypt($res['title']);?>"><i class="fa fa-download"></i></span>

							<?php if ($res['active'] == 'N'): ?>
							<span class="button btn-flat btn-sm btn-default delete_theme" data-toggle="tooltip" data-title="<?php echo lang_line('button_delete');?>" data-id="<?php echo encrypt($res['id']);?>" data-folder="<?php echo encrypt($res['folder']);?>"><i class="fa fa-trash"></i></span>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>
			<?php endforeach ?>
		</div>
	</div>
</div>

<div id="modal_create_blank" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo form_open('','autocomplete="off"');?>
			<input type="hidden" name="act" value="blank_theme">
			<div class="modal-header">
				<h5><i class="fa fa-desktop text-default mr-3"></i><?php echo lang_line('dialog_title_create_blank'); ?></h5> 
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label><?php echo lang_line('form_label_title'); ?></label>
					<input type="text" name="title" class="form-control" required>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="button btn-md btn-primary"><i class="fa fa-magic"></i>&nbsp; <?php echo lang_line('button_create_now');?></button>
				<span class="button btn-md btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i>&nbsp; <?php echo lang_line('button_cancel');?></span>
			</div>
			<?php echo form_close();?>
		</div>
	</div>
</div>

<div id="modal_active" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php 
				echo form_open('','autocomplete="off"');
				echo form_hidden('act', 'active');
				echo form_input(array(
				                	'type' => 'hidden',
				                	'name' => 'id',
				                	'id'  => 'idActive',
				                ));
			?>
			<div class="modal-header">
				<h5><?php echo lang_line('dialog_title_activate'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
			</div>
			<div class="modal-body">
				<h4><?php echo lang_line('dialog_content_active_theme'); ?></h4>
			</div>
			<div class="modal-footer">
				<button type="submit" class="button btn-primary"><i class="fa fa-check mr-2"></i><?php echo lang_line('button_yes');?></button>
				<span class="button btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out mr-2"></i><?php echo lang_line('button_no');?></span>
			</div>
			<?php echo form_close();?>
		</div>
	</div>
</div>

<div id="modal_delete_theme" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php 
				echo form_open('','autocomplete="off"');
				echo form_hidden('act','delete');
				echo form_input(array(
				                	'type' => 'hidden',
				                	'name' => 'id',
				                	'id'   => 'idDel'
				                ));
				echo form_input(array(
				                	'type' => 'hidden',
				                	'name' => 'dir',
				                	'id'   => 'dirDel'
				                ));
			?>
			<div class="modal-header">
				<h5><i class="fa fa-exclamation-triangle text-danger mr-2"></i><?php echo lang_line('dialog_delete_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<h4><?php echo lang_line('dialog_delete_content');?></h4>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-md btn-danger"><i class="fa fa-trash"></i>&nbsp; <?php echo lang_line('button_yes');?></button>
				<button type="button" class="btn btn-md btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out"></i>&nbsp; <?php echo lang_line('button_no');?></button>
			</div>
			<?php echo form_close();?>
		</div>
	</div>
</div>