<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
			<span class="breadcrumb-item"><?php echo lang_line('mod_title_add'); ?></span>
		</div>
	</div>
</div>

<div class="content">

	<?php echo $this->alert->show($this->mod);?>
	
	<div class="block">
		<div class="block-header">
			<h2><?php echo lang_line('mod_title_add');?></h2>
			<div class="pull-right">
				<a href="<?php echo admin_url($this->mod);?>" class="button btn-sm btn-default"><i class="fa fa-arrow-circle-o-left"></i> <?php echo lang_line('mod_title');?></a>
			</div>
		</div>

		<?php
			echo form_open('','id="form_add_user"');
			echo form_hidden('act','add');
		?>
		<div class="row">
			<div class="col-md-12">
				<!-- levell -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('form_label_level');?></label>
					<div class="col-md-4">
						<select class="select-2-nosearch" name="level"  data-placeholder="Level">
							<?php 
								echo '<option value=""></option>';
								$levels = $this->CI->user_model->select_level();
								foreach ($levels as $res_level) {
									echo '<option value="'. $res_level['id'] .'">'. $res_level['title'] .'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<!--/ levell -->

				<!-- username -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('form_label_username');?></label>
					<div class="col-md-4">
						<input type="text" name="username" class="form-control" placeholder="ex: username">
					</div>
				</div>
				<!--/ username -->

				<!-- email -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('form_label_email');?></label>
					<div class="col-md-4">
						<input type="text" name="email" class="form-control" placeholder="ex: your@email.com">
					</div>
				</div>
				<!--/ email -->

				<!-- password -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('form_label_password');?></label>
					<div class="col-md-4">
						<input type="password" name="input_password" class="form-control input_password">
					</div>
				</div>
				<!--/ password -->

				<!-- fullname -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('form_label_fullname');?></label>
					<div class="col-md-4">
						<input type="text" name="name" class="form-control" placeholder="ex: Your Name">
					</div>
				</div>
				<!--/ fullname -->

				<!-- birthday -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('form_label_birthday');?></label>
					<div class="col-md-4">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-date"><i class="fa fa-calendar"></i></span>
							</div>
							<input type="text" id="input-datepicker" name="birthday" class="form-control" aria-label="Date" aria-describedby="basic-date" value="<?php echo date('Y-m-d');?>" required>
						</div>
					</div>
				</div>
				<!--/ birthday -->

				<!-- gender -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('form_label_gender');?></label>
					<div class="col-md-10">
						<div class="form-group pl-0">
							<div class="form-group mb-3 mb-md-2">

								<div class="form-check form-check-inline">
									<label class="form-check-label">
										<input type="radio" class="form-check-input-styled" name="gender" value="M" checked data-fouc>
										Male
									</label>
								</div>

								<div class="form-check form-check-inline">
									<label class="form-check-label">
										<input type="radio" class="form-check-input-styled" name="gender" value="F"  data-fouc>
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
					<label class="col-form-label col-md-2"><?php echo lang_line('form_label_tlpn');?></label>
					<div class="col-md-4">
						<input type="text" name="tlpn" class="form-control" placeholder="+62 000-0000-0000">
					</div>
				</div>
				<!--/ Telephone -->

				<!-- address -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('form_label_address');?></label>
					<div class="col-md-10">
						<textarea name="address" class="form-control"></textarea>
					</div>
				</div>
				<!--/ address -->

				<!-- about -->
				<div class="form-group row">
					<label class="col-form-label col-md-2"><?php echo lang_line('form_label_about');?></label>
					<div class="col-md-10">
						<textarea name="about" class="form-control"></textarea>
					</div>
				</div>
				<!--/ about -->

				<!-- active -->
				<div class="form-group row">
					<label class="col-form-label col-md-2">Status</label>
					<div class="col-md-10">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" id="cActiveb" name="active" value="1">
							<label class="form-check-label" for="cActiveb"><?php echo lang_line('form_label_active');?></label>
						</div>
					</div>
				</div>
				<!--/ active -->	
			</div>
		</div>
		<hr>
		<div class="block-actions">
			<button type="submit" class="button btn-primary submit_add"><i id="submit_icon" class="fa fa-check mr-2"></i>Submit</button>
			<a href="<?php echo admin_url($this->mod);?>" class="button btn-default pull-right"><i class="fa fa-times mr-2"></i><?php echo lang_line('button_cancel');?></a>
		</div>
		<?php echo form_close();?>
	</div>
</div>