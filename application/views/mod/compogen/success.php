<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content">
	<div class="compogen-heading text-center">
		<i class="icon-cup2"></i>
		<h2>CompoGen</h2>
		<p>Component Generator (Beta)</p>
	</div>
	<div class="text-center">
		<h4><?=lang_line('mod_success1')?></h4>
		<br>
		<button type="button" onclick="location.href='<?=admin_url($c_link)?>'" class="btn rounded-round btn-primary mb-3">
			<span class="ml-4 mr-4"><?=lang_line('button_goto_component')?></span>
		</button>
	</div>
</div>