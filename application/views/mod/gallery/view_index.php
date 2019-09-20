<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
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
	<?php echo $this->alert->show($this->mod);?>
	<div class="block">
		<div class="block-header">
			<h3><?php echo lang_line('mod_title_all');?></h3>
			<div class="pull-right">
				<button type="button" class="button btn-sm btn-primary modal_add_album"><i class="icon-add"></i> <?php echo lang_line('button_add_album');?></button>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<?php 
						foreach ($albums as $res_album):
							$res = $this->db
								->select('picture')
								->where('id_album', $res_album['id'])
								->limit(1)
								->order_by('id', 'DESC')
								->get('t_gallery')
								->row_array();

							$photosrc = post_images($res['picture'],'thumb',TRUE);
					?>
					<div id="gallery-item<?php echo $res_album['id'];?>" class="col-lg-3">
						<div class="card">
							<div class="galdel delete_album" data-id="<?php echo encrypt($res_album['id']);?>"><i class="fa fa-times"></i></div>
							<div class="card-body text-center">
								<div class="theme-img-card mb-2">
								<a href="<?php echo admin_url($this->mod.'/album/'.$res_album['id']);?>" title="<?php echo $res_album['title'];?>">
									<img src="<?php echo content_url('images/medium_noimage.jpg');?>" data-src="<?php echo $photosrc;?>" class="lazy" style="width:100%;">
								</a>
								</div>
								<div><?php echo $res_album['title']?></div>
							</div>
						</div>
					</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<div id="modal_add_album" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo form_open('','autocomplete="off"');?>
			<div class="modal-header">
				<h5><i class="fa fa-book mr-2"></i><?php echo lang_line('dialog_title_add_album'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label><?php echo lang_line('form_label_title_album'); ?></label>
					<input type="text" name="title" class="form-control">
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" name="act" value="add_album" class="button btn-md btn-primary"><i class="fa fa-check mr-2"></i><?php echo lang_line('button_submit');?></button>
				<button type="reset" class="button btn-md btn-default" data-dismiss="modal" aria-hidden="true"><?php echo lang_line('button_cancel');?></button>
			</div>
			<?php echo form_close();?>
		</div>
	</div>
</div>

<div id="modal_delete" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			 <h5><i class="fa fa-exclamation-triangle text-danger mr-2"></i><?php echo lang_line('dialog_delete_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<?php echo form_open();?>
			<input type="hidden" name="act" value="delete">
			<input id="idDelAlbum" type="hidden" name="id">
			<div class="modal-body">
				<?php echo lang_line('dialog_delete_content_album');?>
			</div>
			<div class="modal-footer">
				<button type="submit" class="button btn-default text-danger"><i class="icon-bin mr-2"></i><?php echo lang_line('button_delete');?></button>
				<button type="button" class="button btn-default" data-dismiss="modal" aria-hidden="true"><?php echo lang_line('button_cancel');?></button>
			</div>
			<?php echo form_close();?>
		</div>
	</div>
</div>