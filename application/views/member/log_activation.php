<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="log-content">
	<div class="content-wrapper">
		<div class="content d-flex justify-content-center align-items-center">
			<div class="col-md-8 login-form">
				<div class="text-center">
					<img src="<?=favicon('logo');?>" class="logo mb-3" style="width:70px;"/>
				</div>
				<div class="text-center mb-3">
					<h5 class="mb-0"><?=lang_line('login_activation')?></h5>
				</div>
				<hr>
				<div class="card mb-0">
					<div class="card-body text-center">
						<?=$data;?>
					</div>
				</div>
				<hr>
				<p class="mt-3 text-center login-copyright">Copyright &copy; <a href="https://alweak.com" target="_blank">CiFireCMS</a> <?=date('Y');?>. <a href="https://opensource.org/licenses/MIT" target="_blank">MIT License</a></p>
			</div>
		</div>
	</div>
</div>