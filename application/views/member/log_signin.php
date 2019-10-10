<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="log-content">
	<div class="content-wrapper">
		<div class="content d-flex justify-content-center align-items-center">
			<?= form_open('', 'id="form-login" class="login-form" autocomplete="on"'); ?>
				<div class="text-center">
					<img src="<?=favicon('logo');?>" class="logo mb-3" style="height:50px;"/>
				</div>
				<div class="text-center mb-3">
					<h5 class="mb-0"><?=lang_line('login1')?></h5>
				</div>
				<div class="card mb-0">
					<div class="card-body">
						<?= $this->alert->show('login'); ?>
						<div class="form-group">
							<label for="usermail"><?=lang_line("login_email");?></label>
							<input id="usermail" type="text" name="<?=$input_email;?>" class="form-control input-email" required>
						</div>
						<div class="input-password"></div>
						<div class="login-or">
							<hr class="hr-or"><span class="span-or"><?=lang_line('or')?></span>
						</div>
						<div class="text-center">
							<a href="<?=member_url('register')?>" class="btn btn-default btn-block"><?=lang_line('login2')?></a>
						</div>
					</div>
				</div>
				<p class="mt-3 text-center login-copyright">Copyright &copy; <?=date('Y');?> <?=$this->CI->settings->website('web_name'); ?></p>
			<?=form_close(); ?>
		</div>
	</div>
</div>