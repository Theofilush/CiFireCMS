<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-inline">
		<div class="page-title">
			<h3><span class="font-weight-semibold"><?php echo lang_line('mod_title'); ?></span></h3>
		</div>
	</div>
	<div class="breadcrumb-line breadcrumb-line-light">
		<div class="breadcrumb">
			<a href="<?php echo admin_url('home'); ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> <?php echo lang_line('admin_link_home'); ?></a>
			<span class="breadcrumb-item"><a href="<?php echo admin_url($this->mod); ?>"><?php echo lang_line('mod_title'); ?></a></span>
			<span class="breadcrumb-item"><?php echo lang_line('mod_title_edit'); ?></span>
		</div>
	</div>
</div>

<div class="content">

	<?php echo $this->alert->show($this->mod); ?>
	
	<div class="block">
		<div class="block-header">
			<h2><?php echo lang_line('mod_title_edit'); ?></h2>
			<div class="pull-right">
				<a href="<?php echo admin_url($this->mod); ?>" class="button btn-sm btn-default"><i class="fa fa-arrow-circle-o-left"></i> <?php echo lang_line('mod_title');?></a>
			</div>
		</div>
		<?php 
			echo form_open_multipart('','id="form_update" autocomplete="off"');
		?>
		<div class="row">
			<div class="col-md-12">
				<!-- username -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('label_username');?></label>
					<div class="col-md-4">
						<input type="text" class="form-control" value="<?php echo $this->data['user_username'];?>" disabled>
						<p class="text-danger"><i><small>* <?php echo lang_line('label_username_note');?></small></i></p>
					</div>
				</div>
				<!--/ username -->
				<!-- email -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('label_email');?></label>
					<div class="col-md-4">
						<input type="text" name="email" class="form-control" value="<?php echo $this->data['user_email'];?>"/>
					</div>
				</div>
				<!--/ email -->
				<!-- password -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('label_password');?></label>
					<div class="col-md-4">
						<input type="password" name="input_password" class="form-control" placeholder="<?php echo lang_line('label_pass_placholder');?>">
						<input type="hidden" name="input_password2" value="<?php echo $this->data['user_password'];?>">
						<p><span class="text-danger">*</span> <small class="text-muted"> <?php echo lang_line('label_pass_placholder');?></small></p>
					</div>
				</div>
				<!--/ password -->
				<hr>
				<!-- fullname -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('label_fullname');?></label>
					<div class="col-md-4">
						<input type="text" name="name" value="<?php echo trim(set_value('name')) != "" ? trim(set_value('name')) : $this->data['user_name'];?>" placeholder="ex: Your Name" class="form-control">
					</div>
				</div>
				<!--/ fullname -->
				<!-- birthday -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('label_birthday');?></label>
					<div class="col-md-4">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-date"><i class="fa fa-calendar"></i></span>
							</div>
							<input type="text" id="input-datepicker" name="birthday" class="form-control" aria-label="Date" aria-describedby="basic-date" value="<?php echo $this->data['user_birthday'];?>" required>
						</div>
					</div>
				</div>
				<!--/ birthday -->
				<!-- gender -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('label_gender');?></label>
					<div class="col-md-10">
						<div class="form-group pl-0">
							<div class="form-group mb-3 mb-md-2">
								<div class="form-check form-check-inline">
									<label class="form-check-label">
										<input type="radio" class="form-check-input-styled" name="gender" value="M" <?php echo ( $this->data['user_gender'] == 'M' ? 'checked' : '');?> data-fouc>
										Male
									</label>
								</div>
								<div class="form-check form-check-inline">
									<label class="form-check-label">
										<input type="radio" class="form-check-input-styled" name="gender" value="F" <?php echo ( $this->data['user_gender'] == 'F' ? 'checked' : '');?> data-fouc>
										Female
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--/ gender -->
				<!-- Telephone -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('label_tlpn');?></label>
					<div class="col-md-4">
						<input type="text" name="tlpn" value="<?php echo trim(set_value('tlpn')) != "" ? trim(set_value('tlpn')) : $this->data['user_tlpn'];?>" placeholder="+62 000-0000-0000" class="form-control">
					</div>
				</div>
				<!--/ Telephone -->
				<!-- address -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('label_address');?></label>
					<div class="col-md-10">
						<textarea name="address" class="form-control"><?php echo trim(set_value('address')) != "" ? trim(set_value('address')) : $this->data['user_address'];?></textarea>
					</div>
				</div>
				<!--/ address -->
				<!-- about -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('label_about');?></label>
					<div class="col-md-10">
						<textarea name="about" class="form-control"><?php echo trim(set_value('about')) != "" ? trim(set_value('about')) : $this->data['user_about'];?></textarea>
					</div>
				</div>
				<!--/ about -->
				<!-- photo -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('label_photo');?></label>
					<div class="col-md-3">
						<div class="mb-2"><img id="image-preview" src="<?php echo user_photo($this->data['user_photo']);?>" class="thumbnail us-avatar" style="width:100px;"></div>
						<input id="upload-image" class="file_input form-control" type="file" name="fupload" accept="image/png, image/jpeg, image/gif" />

					</div>
				</div>
				<!--/ photo -->				
			</div>
		</div>
		<hr>
		<div class="block-actions">
			<button type="submit" class="submit_update button btn-primary mr-2"><i class="fa fa-save mr-2"></i><?php echo lang_line('button_save');?></button>
			<a href="<?php echo admin_url($this->mod);?>" class="button btn-default pull-right"><i class="fa fa-times mr-2"></i><?php echo lang_line('button_cancel');?></a>
		</div>
		<?php echo form_close();?>
	</div>
</div>