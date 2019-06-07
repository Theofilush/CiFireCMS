<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">

	<?=$this->alert->show($this->mod); ?>
	<div class="ajax_alert" style="display:none;"></div>

	<div class="block-content">
		<div class="row">
			<div class="col-md-12">
				<div class="block-header">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div clsas="col-md-3">
					<div>
						<img src="<?=user_photo(data_login('admin','photo'));?>" style="max-width:200px;"/>
					</div>
					<i class="fa fa-free-code-camp"></i> <?=$res_profil['level_title'];?>
				</div>
				<div clsas="col-md-9"></div>
			</div>
		</div>
	</div>
</div>
