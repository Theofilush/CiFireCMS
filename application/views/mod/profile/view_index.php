<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-inline">
		<div class="page-title">
			<h3>
				<span class="font-weight-semibold"><?php echo lang_line('mod_title'); ?></span>
			</h3>
		</div>
	</div>
	<div class="breadcrumb-line breadcrumb-line-light">
		<div class="breadcrumb">
			<a href="<?php echo admin_url('home'); ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> <?php echo lang_line('admin_link_home') ?></a>
			<span class="breadcrumb-item"><?php echo lang_line('mod_title'); ?></span>
		</div>
	</div>
</div>
<div class="content">
	<?php echo $this->alert->show($this->mod); ?>
	<div class="row">
		<div class="col-md-3">
			<div class="block">
				<div class="text-center">
					<img src="<?php echo user_photo(data_login('admin','photo'));?>" style="width:90%;border-radius:50%; margin:auto;display:table;margin-bottom:10px;">
					<div>
						<span class="badge badge-b badge-pill badge-warning"><i class="fa fa-star"></i> <?php echo user_level('title');?></span>
					</div>
					<div class="mt-2">
						<a href="<?php echo admin_url($this->mod.'/edit');?>" class="btn btn-xs btn-default"><?php echo lang_line('edit_profile');?></a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="block">
				<div class="row">
					<table class="table">
						<tr>
							<td width="140"><?php echo lang_line('label_fullname'); ?></td>
							<td width="1">:</td>
							<td><?php echo $this->data['user_username']; ?></td>
						</tr>
						<tr>
							<td><?php echo lang_line('label_email'); ?></td>
							<td>:</td>
							<td><?php echo $this->data['user_email']; ?></td>
						</tr>
						<tr>
							<td><?php echo lang_line('label_birthday'); ?></td>
							<td>:</td>
							<td><?php echo ci_date($this->data['user_birthday'], 'l, d F Y'); ?></td>
						</tr>
						<tr>
							<td><?php echo lang_line('label_gender'); ?></td>
							<td>:</td>
							<td><?php echo $gender;?></td>
						</tr>
						<tr>
							<td><?php echo lang_line('label_tlpn'); ?></td>
							<td>:</td>
							<td><?php echo $this->data['user_tlpn']; ?></td>
						</tr>
						<tr>
							<td><?php echo lang_line('label_address'); ?></td>
							<td>:</td>
							<td><?php echo $this->data['user_address']; ?></td>
						</tr>
						<tr>
							<td><?php echo lang_line('label_about'); ?></td>
							<td>:</td>
							<td><?php echo $this->data['user_about']; ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>