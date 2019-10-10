<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?=form_open('', 'id="form-login" class="login-form" autocomplete="on"');?>
	<div class="text-center">
		<img src="<?=favicon('logo');?>" class="logo mb-3" style="height:70px;"/>
	</div>
	<div class="text-center mb-3">
		<h5 class="mb-0"><?=lang_line('login2')?></h5>
	</div>
	<div class="card mb-0">
		<div class="card-body">
			<?= $this->alert->show('forgot'); ?>
			<div class="form-group">
				<label><?=lang_line('login_email')?></label>
				<input type="email" name="email" class="form-control" maxlength="80">
			</div>
			<button type="submit" class="button btn-primary btn-block mt-3"><?=lang_line('button_send')?> <i class="fa fa-paper-plane ml-2"></i></button>
		</div>
		<div class="text-center mt-1 mb-3">
			<a href="<?=admin_url()?>" class="text-default"><i class="fa fa-arrow-circle-o-left"></i> <?=lang_line('button_back_to_login')?></a>
		</div>
	</div>

	<p class="mt-3 text-center login-copyright">Copyright &copy; <?=date('Y');?> <?php echo $this->CI->settings->website('web_name'); ?></p>
<?=form_close();?>