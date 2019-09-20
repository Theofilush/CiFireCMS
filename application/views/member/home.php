<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-12 text-center">
		<div class="mb-5">
			<h4><?=lang_line('home1')?> <?=data_login('member','name')?></h4>
			<h2><?=lang_line('home2')?></h2>
		</div>
		<a href="<?=member_url('post');?>" class="btn btn-lg btn-success mb-3 mr-3"><i class="fa fa-edit mr-3"></i><?=lang_line('home3')?></a>
		<a href="<?=member_url('account');?>" class="btn btn-lg btn-warning mb-3 mr-3"><i class="fa fa-user mr-3"></i><?=lang_line('home4')?></a>
		<a href="<?=member_url('change-password');?>" class="btn btn-lg btn-danger mb-3"><i class="fa fa-unlock-alt mr-3"></i><?=lang_line('change_password')?></a>
	</div>
</div>


