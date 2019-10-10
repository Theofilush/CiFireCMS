<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
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
			<span class="breadcrumb-item"><?php echo lang_line('mod_title_album');?></span>
		</div>
	</div>
</div>

<div class="content">

	<?php echo $this->alert->show($this->mod); ?>

	<div class="block">
		<div class="block-header">
			<h2><?php echo lang_line('mod_title_album');?> : <small><?php echo $res_album['title'];?></small></h2>
			<div class="pull-right">
				<button type="button" idAlbum="<?php echo $res_album['id'];?>" class="modal_add_picture button btn-sm btn-primary mr-2"><i class="fa fa-image"></i>&nbsp; <?php echo lang_line('button_add_picture'); ?></button>
				<a href="<?php echo admin_url($this->mod);?>" class="button btn-sm btn-default"><i class="fa fa-arrow-circle-o-left"></i>&nbsp; <?php echo lang_line('mod_title'); ?></a> &nbsp;
			</div>
		</div>
		<div class="col-md-12">
			<div class="row">
				<?php 
					foreach ($gallerys as $res):
						$src_imgs = post_images($res['picture'], '', TRUE);
						$thumb = post_images($res['picture'], 'thumb', TRUE);
				?>
				<div id="gallery-item<?php echo $res['id'];?>" class="col-lg-2">
					<div class="card item-gal">
						<div class="galdel delete_gallery_image" data-id="<?php echo encrypt($res['id']);?>"><i class="fa fa-times"></i></div>
						<div class="card-body text-center">
							<div class="theme-img-card">
								<a class="fancybox" data-fancybox-group="gallery" title="<?php echo $res['title'];?>" href="<?php echo $src_imgs;?>">
									<img src="<?php echo content_url('images/medium_noimage.jpg');?>" data-src="<?php echo $thumb;?>" class="lazy" style="width:100%;">
								</a>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach ?>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<div id="modal_add_picture" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5><i class="fa fa-image mr-2"></i><?php echo lang_line('dialog_title_add_picture'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<?php echo form_open_multipart('','autocomplete="off"');?>
			<input id="id_album" type="hidden" name="id_album">
			<input type="hidden" name="act" value="add_picture">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label><?php echo lang_line('form_label_title'); ?></label>
							<input type="text" name="title" class="form-control" required>
						</div>
						<div class="form-group">
							<label><?php echo lang_line('form_label_picture'); ?></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<button type="button" id="browse-files" href="<?php echo content_url('plugins/filemanager/dialog.php?type=1&relative_url=1&field_id=pictures&sort_by=date&descending=1&akey='.login_key('admin'));?>" class="btn btn-default">
										<i class="fa fa-image"></i>&nbsp; Browse
									</button>
								</div>
								<input type="text" id="prv" class="form-control" placeholder="Browse..." disabled>
								<input type="hidden" name="picture" id="pictures" class="form-control" required>
							</div>
		                </div>
	                </div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="button btn-md btn-primary pull-left"><i class="fa fa-check mr-2"></i><?php echo lang_line('button_submit'); ?></button>
				<button type="reset" class="button btn-md btn-default delpict" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times mr-2"></i><?php echo lang_line('button_cancel'); ?></button>
			</div>
			<?php echo form_close();?>
		</div>
	</div>
</div>