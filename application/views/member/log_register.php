<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="log-content">
	<div class="content-wrapper">
		<div class="content d-flex justify-content-center align-items-center">
			<?= form_open('', 'class="login-form" autocomplete="on"'); ?>
				<div class="text-center">
					<img src="<?=favicon('logo');?>" class="logo mb-3" style="height:50px;"/>
				</div>
				<div class="text-center mb-3">
					<h5 class="mb-0"><?=lang_line('login2')?></h5>
				</div>
				<div class="card mb-0">
					<div class="card-body">
						<?= $this->alert->show('register'); ?>
						<div class="form-group mb-3">
							<label><?=lang_line("login_name");?></label>
							<input type="text" name="name" class="form-control input-email" maxlength="100" >
						</div>
						<div class="form-group mb-3">
							<label><?=lang_line("login_email");?></label>
							<input type="text" name="email" class="form-control input-email" maxlength="100" >
						</div>
						<div class="row mb-3">
							<div class="col-md-6">
								<div class="form-group mb-3">
									<label><?=lang_line("login_pass");?></label>
									<input type="password" name="password" class="form-control input-email" maxlength="100" >
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-3">
									<label><?=lang_line("login_pass2");?></label>
									<input type="password" name="password2" class="form-control input-email" maxlength="100" >
								</div>
							</div>
						</div>
						<?php if ($this->CI->captcha() == TRUE): ?>
						<div style="display:table;margin:auto;">
							<div class="g-recaptcha" data-sitekey="<?php echo $this->settings->website('recaptcha_site_key')?>" style="margin-bottom:20px;"></div>
							<script src='https://www.google.com/recaptcha/api.js'></script>
						</div>
						<?php endif ?>
						<button type="submit" class="btn btn-success btn-block"><?=lang_line('login_button_reg')?></button>
						<div class="login-or">
							<hr class="hr-or"><span class="span-or"><?=lang_line('or')?></span>
						</div>
						<div class="text-center">
							<a href="<?=member_url()?>" class="btn btn-default btn-block"><i class="fa fa-arrow-circle-o-left mr-2"></i><?=lang_line('login_button_back_to_login')?></a>
						</div>
					</div>
				</div>
				<p class="mt-3 text-center login-copyright">Copyright &copy; <?=date('Y');?> <?=$this->CI->settings->website('web_name'); ?></p>
			<?=form_close(); ?>
		</div>
	</div>
</div>