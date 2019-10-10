<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=lang_line('post_title_add_post')?></h5>
		<div class="pull-right">
			<a href="<?=member_url($this->mod)?>" class="btn btn-sm btn-default"><i class="fa fa-arrow-circle-o-left mr-2"></i>Post</a>
		</div>
	</div>
	<div class="card-body">
		<?=form_open_multipart('','id="form_post_add" autocomplete="off"');?>
		<div class="row post">
			<!-- Left -->
			<div class="col-lg-9">
				<div class="form-group">
					<input type="text" name="title" class="form-control post-title" placeholder="Title">
				</div>
				<br>
				<div class="form-group">
					<label for="Content"><?=lang_line('post_label_content')?></label>
					<input name="content" id="Content" class="form-control post-content">
				</div>
			</div>
			<!--/ Left -->
			<!-- Right -->
			<div class="col-lg-3" style="min-width:120px;">
				<div id="sticky">
					<div class="accordion post-setting" id="accordionPostX">
						<!-- Publish -->
						<div class="card">
							<div class="card-header" id="collapse-publish">
								<button class="btn btn-link" type="button" data-toggle="collapse" aria-expanded="true" data-target="#collapsePublish" aria-controls="collapsePublish">Publish</button>
							</div>
							<div id="collapsePublish" class="collapse show" aria-labelledby="collapse-publish" data-parent="#accordionPost">
								<div class="card-body">
									<div>
										<input id="c-headline" type="checkbox" name="headline" class="mr-2" value="1">
										<label for="c-headline"><?=lang_line('post_label_headline')?></label>
									</div>
									<div class="mb-2">
										<input id="c-comment" type="checkbox" name="comment" class="mr-2" value="1" checked>
										<label for="c-comment"><?=lang_line('post_label_comment')?></label>
									</div>
									<div class="mb-1">
										<button type="submit" class="btn_submit_post btn btn-sm btn-primary mr-2"><i class="fa fa-check"></i> <?=lang_line('button_submit')?></button>
										<button type="button" class="btn btn-sm btn-danger" onclick="location=href='<?=member_url($this->mod)?>'"><i class="fa fa-times"></i> <?=lang_line('button_cancel')?></button>
									</div>
								</div>
							</div>
						</div>
						<!--/ Publish -->

						<!-- Category -->
						<div class="card">
							<div class="card-header" id="collapse-category">
								<button class="btn btn-link" type="button" data-toggle="collapse" aria-expanded="true" data-target="#collapseCategory" aria-controls="collapseCategory"><?=lang_line('post_label_category');?></button>
							</div>
							<div id="collapseCategory" class="collapse" aria-labelledby="collapse-category" data-parent="#accordionPost">
								<div class="card-body">
									<div id="select-category"></div>
									<select name="category" class="select-2" data-placeholder="- <?=lang_line('post_label_category');?> -">
										<option value=""></option>
										<?php
											foreach ($all_category as $res_cat):
										?>
										<option value="<?=encrypt($res_cat['id'])?>"><?=$res_cat['title']?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
						</div>
						<!--/ Category -->
						
						<!-- Tags -->
						<div class="card">
							<div class="card-header" id="collapsed-tags">
								<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapsedTags" aria-expanded="false" aria-controls="collapsedTags"><?=lang_line('post_label_tags')?></button>
							</div>
							<div id="collapsedTags" class="collapse" aria-labelledby="collapsed-tags" data-parent="#accordionPost">
								<div class="card-body">
									<input id="tagsjs" type="text" name="tags" placeholder="Input Tag" class="form-control">
								</div>
							</div>
						</div>
						<!--/ Tags -->

						<!-- Picture -->
						<div class="card">
							<div class="card-header" id="collapsed-picture">
								<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapsedPicture" aria-expanded="false" aria-controls="collapsedPicture"><?=lang_line('post_label_picture')?></button>
							</div>
							<div id="collapsedPicture" class="collapse" aria-labelledby="collapsed-picture" data-parent="#accordionPost">
								<div class="card-body">
									<!-- Picture -->
									<div class="text-center mb-2">
										<img id="image-preview" src="<?=post_images('' ,'', TRUE);?>" class="imgprv">
									</div>
									<div class="custom-file">
										<input id="picture" type="file" accept="image/*" name="fupload" class="custom-file-input">
										<label class="custom-file-label" for="picture">
											<span class="d-inline-block text-truncate w-75">Chose image...</span>
										</label>
									</div>
									<!--/ Picture -->

									<!-- Image descrption -->
									<div class="mt-3 form-groupX">
										<label><?=lang_line('post_label_caption')?></label>
										<textarea name="image_caption" class="form-control" maxlength="100"></textarea>
									</div>
									<!--/ Image descrption -->
								</div>
							</div>
						</div>
						<!--/ Picture -->
					</div>
				</div>
			</div>
			<!--/ Right -->
		</div>
		<?=form_close();?>
	</div>
</div>