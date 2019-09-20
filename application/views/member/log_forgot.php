<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="log-content">
	<div class="content-wrapper">
		<div class="content d-flex justify-content-center align-items-center">
			<?= form_open('', 'class="login-form" autocomplete="on"'); ?>
				<div class="text-center">
					<img src="<?=favicon('logo');?>" class="logo mb-3" style="width:70px;"/>
				</div>
				<div class="text-center mb-3">
					<h5 class="mb-0"><?=lang_line('login3')?></h5>
				</div>
				<div class="card mb-0">
					<div class="card-body">
						<?= $this->alert->show('forgot'); ?>
						<div class="form-group mb-3">
							<label><?=lang_line("login_email");?></label>
							<input type="text" name="email" class="form-control input-email" maxlength="100" >
						</div>
						<button type="submit" class="btn btn-success btn-block"><i class="fa fa-paper-plane mr-2"></i> <?=lang_line('button_send')?></button>
						<div class="login-or">
							<hr class="hr-or"><span class="span-or"><?=lang_line('or')?></span>
						</div>
						<div class="text-center">
							<a href="<?=member_url()?>" class="btn btn-default btn-block"><i class="fa fa-arrow-circle-o-left mr-2"></i><?=lang_line('login_button_back_to_login')?></a>
						</div>
					</div>
				</div>
				<p class="mt-3 text-center login-copyright">Copyright &copy; <a href="https://alweak.com" target="_blank">CiFireCMS</a> <?=date('Y');?>. <a href="https://opensource.org/licenses/MIT" target="_blank">MIT License</a></p>
			<?=form_close(); ?>
		</div>
	</div>
</div>