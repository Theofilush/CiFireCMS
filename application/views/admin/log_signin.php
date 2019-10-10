<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?=form_open('', 'id="form-login" class="login-form" autocomplete="off"');?>
	<div class="text-center">
		<img src="<?=favicon('logo');?>" class="logo mb-3" style="height:70px;"/>
	</div>
	<div class="text-center mb-3">
		<h5 class="mb-0"><?=lang_line('login1')?></h5>
	</div>
	<div class="card mb-0">
		<div class="card-body">
			<?= $this->alert->show('login'); ?>
			<div class="form-group">
				<label for="username"><?=lang_line('login_username')?></label>
				<input id="username" type="text" name="<?=$input_uname;?>" class="form-control input-username" maxlength="20">
			</div>
			<div class="input-password"></div>
		</div>
	</div>
	<p class="mt-3 text-center login-copyright">Copyright &copy; <?=date('Y');?> <?php echo $this->CI->settings->website('web_name'); ?></p>
<?=form_close();?>