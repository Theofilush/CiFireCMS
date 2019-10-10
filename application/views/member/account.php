<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<?= $this->alert->show($this->mod); ?>
	<div class="row">
		<!-- left -->
		<div class="col-md-4">
			<div class="card card-user">
				<div class="card-header no-padding">
					<div class="card-image">
						<div class="btn_edit_photo"><i class="fa fa-camera"></i> <?=lang_line('edit_photo')?></div>
						<img src="<?=content_url('plugins/member/img/bg1.jpg')?>">
					</div>
				</div>
				<div class="card-body">
					<div class="author">
						<a href="#">
							<img class="avatar border-gray" src="<?=user_photo(data_login('member', 'photo'));?>">
						</a>
						<p class="card-description">
							<b><?=$row['name'];?></b><br>
							<small><?=$row['email'];?></small>
						</p>
					</div>
					<p class="card-description text-center">
						<small class="text-strong"><b>About me :</b></small><br>
						<?=$row['about'];?>
					</p>
					<hr class="text-center mt-4 mb-2">
					<div class="text-center">
						<a href="<?=member_url('delete-account');?>" class="btn btn-sm btn-danger mr-2"><i class="fa fa-user-times mr-2"></i><?=lang_line('button_delete_account')?></a>
						<a href="<?=member_url('change-password');?>" class="btn btn-sm btn-warning"><i class="fa fa-unlock-alt mr-2"></i><?=lang_line('change_password')?></a>
					</div>
				</div>
			</div>
		</div>
		<!--/ left -->
		<!-- right -->
		<div class="col-md-8">
			<form class="form" id="form_profile">
				<div class="card">
					<div class="card-header ">
						<h4 class="card-title"><?=lang_line('account_title');?></h4>
					</div>
					<div class="card-body">
						<div class="row mb-3">
							<!-- email -->
							<div class="col-md-6">
								<div class="form-group">
									<label><?=lang_line('account_label_email');?> <small class="text-danger">*</small></label>
									<input type="text" name="email" class="form-control" value="<?=$row['email'];?>" maxlength="50">
								</div>
							</div>
							<!--/ email -->
							<!-- username -->
							<div class="col-md-6">
								<div class="form-group">
									<label><?=lang_line('account_label_username');?></label>
									<input type="text" class="form-control" value="<?=$row['username'];?>" disabled>
									<small class="text-danger"><i>* <?=lang_line('account_note1');?></i></small>
								</div>
							</div>
							<!--/ username -->
						</div>
						<hr>
						<!-- name -->
						<div class="row mb-3">
							<div class="col-md-6">
								<div class="form-group">
									<label><?=lang_line('account_label_name');?> <small class="text-danger">*</small></label>
									<input type="text" name="name" class="form-control" value="<?=$row['name'];?>" maxlength="20">
								</div>
							</div>
						</div>
						<!--/ name -->
						<!-- Gender -->
						<div class="row mb-3">
							<div class="col-md-12">
								<div class="form-group">
									<label><?=lang_line('account_label_gender');?></label>
									<div class="rows">
										<?php
											$gender = ( $row['gender'] == 'M' ? 'Male':'Female'  );
										?>
										<?php if ( $row['gender'] == 'M' ): ?>	
											<div class="pull-left" style="width:100px;">
												<input id="male" type="radio" name="gender" value="M" checked="">
												<label for="male">Male</label>
											</div>
											<div class="pull-left" style="width:100px;">
												<input id="female" type="radio" name="gender" value="F">
												<label for="female">Female</label>
											</div>
										<?php else: ?>
											<div class="pull-left" style="width:100px;">
												<input id="male" type="radio" name="gender" value="M" >
												<label for="male">Male</label>
											</div>
											<div class="pull-left" style="width:100px;">
												<input id="female" type="radio" name="gender" value="F" checked>
												<label for="female">Female</label>
											</div>
										<?php endif ?>
									</div>
								</div>
							</div>
						</div>
						<!--/ Gender -->
						<!-- birthday -->
						<div class="row mb-3">
							<div class="col-md-6">
								<div class="form-group">
									<label><?=lang_line('account_label_birthday');?> <small class="text-danger">*</small></label>
									<div class="input-group">
										<input type="text" id="datepicker" name="birthday" class="form-control" value="<?=$row['birthday'];?>" required>
										<div class="input-group-append">
											<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--/ birthday -->
						<!-- Phone -->
						<div class="row mb-3">
							<div class="col-md-6">
								<div class="form-group">
									<label><?=lang_line('account_label_tlpn');?> <small class="text-danger">*</small></label>
									<div class="input-group">
										<input type="text" name="tlpn" class="form-control" value="<?=$row['tlpn'];?>">
										<div class="input-group-append">
											<span class="input-group-text"><i class="fa fa-phone"></i></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--/ Phone -->
						<!-- About -->
						<div class="row mb-3">
							<div class="col-md-12">
								<div class="form-group">
									<label><?=lang_line('account_label_about');?></label>
									<textarea name="about" class="form-control" rows="3"><?=$row['about'];?></textarea>
								</div>
							</div>
						</div>
						<!-- About -->
						<!-- Address -->
						<div class="row mb-3">
							<div class="col-md-12">
								<div class="form-group">
									<label><?=lang_line('account_label_address');?></label>
									<textarea name="address" class="form-control" rows="3"><?=$row['address'];?></textarea>
								</div>
							</div>
						</div>
						<!-- Address -->
						<hr>
						<button type="submit" class="btn_submit_profile btn btn-success"><i class="fa fa-save mr-2"></i><?=lang_line('button_save')?></button>
						<div class="clearfix"></div>
					</div>
				</div>
			</form>
		</div>
		<!--/ right -->
	</div>
</div>

<!-- modal edit photo -->
<div id="modal_edit_photo" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-camera mr-2"></i> <?=lang_line('edit_photo')?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<?php echo form_open_multipart(); ?>
					<div class="modal-body">
						<div class="form-group">
							<!-- Picture -->
							<div class="text-center mb-2">
								<img id="image-preview" src="<?=user_photo(data_login('member','photo'));?>" class="imgprv" style="max-width:200px;">
							</div>
							<div class="custom-file">
								<input id="picture" type="file" accept="image/*" name="fupload" class="custom-file-input" required>
								<label class="custom-file-label" for="picture">
									<span class="d-inline-block text-truncate w-75">Chose image...</span>
								</label>
							</div>
							<!--/ Picture -->
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary upload"><i class="fa fa-upload mr-2"></i> <?=lang_line('button_upload')?></button>
						<button type="button" class="btn btn-danger delete_photo"><i class="fa fa-trash mr-2"></i> <?=lang_line('button_delete')?></button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-sign-out"></i>  <?=lang_line('button_cancel')?></button>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<!--/ modal edit photo -->