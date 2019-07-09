<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->CI->render_view('header');
?>
<div class="cols cols-full">
	<div class="colleft">
		<div class="box">
			<div class="sitemap">
				<a href="#">Home</a>
				<span><i class="fa fa-angle-right"></i></span>
				<a href="#">Gallery</a>
			</div>
			<div class="gallery-page">
				<div class="row">
					<?php
						foreach ($albums as $row_album):
							$cover = $this->CI->gallery_model->album_cover($row_album['id']);
							$pitures = $this->CI->gallery_model->get_gallery_images($row_album['id']);
					?>
					<div class="col-md-3 col-sm-4 col-xs-2">
						<div class="gallery-album">
							<a class="fancybox" data-fancybox-group="<?=$row_album['id']?>" href="<?=post_images($cover['picture']);?>" title="<?=$cover['title'];?>">
								<img src="<?=post_images($cover['picture'],'medium');?>">
								<h3><?=$row_album['title'];?></h3>
							</a>
							<div class="hidden">
								<?php
									foreach ($pitures as $img):
										if ( $img['picture'] === $cover['picture'])
											continue;
								?>
								<a class="fancybox" data-fancybox-group="<?=$row_album['id']?>" href="<?=post_images($img['picture']);?>" title="<?=$img['title'];?>"><?=$img['title'];?></a>
								<?php endforeach ?>
							</div>
						</div>
					</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<?php $this->CI->render_view('footer'); ?>