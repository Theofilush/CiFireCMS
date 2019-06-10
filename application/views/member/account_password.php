<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row justify-content-md-center">
		<div class="col-md-6">
		<?php echo form_open(); ?>
			<h2><i class="fa fa-unlock-alt mr-3"></i><?=lang_line('change_password')?></h2>
			<hr>
			<?php echo $this->alert->show($this->mod); ?>
			<div class="form-group">
				<label><?=lang_line('old_password')?></label>
				<input type="password" name="old-pass" class="form-control">
				<small class="text-danger">* <i><?=lang_line('mod_lang3')?></i></small>
			</div>
			<div class="form-group">
				<label><?=lang_line('new_password1')?></label>
				<input type="password" name="new-pass1" class="form-control">
			</div>
			<div class="form-group">
				<label><?=lang_line('new_password2')?></label>
				<input type="password" name="new-pass2" class="form-control">
			</div>
			<hr>
				<button type="submit" class="btn btn-lg btn-success"><i class="fa fa-edit mr-2"></i><?=lang_line('change_password')?></button>
			<div class="text-center">
			</div>
		<?php echo form_close(); ?>
		</div>
	</div>
</div>

<div id="modal_delete" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-exclamation-triangle text-danger mr-2"></i> <?=lang_line('dialog_delete_title');?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="">
					<div class="modal-body">
						<p><?=lang_line('delete_confirmation')?></p>
						<div class="form-group">
							<label for=""><?=lang_line('your_password')?></label>
							<input type="password" name="confirm" class="form-control">
							<small class="text-danger"><i>* <?=lang_line('mod_lang3')?></i></small>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger delete_account"><i class="fa fa-user-times mr-2"></i> <?=lang_line('mod_lang1')?></button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang_line('button_cancel')?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>