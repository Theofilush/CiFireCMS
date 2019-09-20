<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-inline">
		<div class="page-title">
			<h3>
				<span class="font-weight-semibold"><?php echo lang_line('mod_title');?></span>
			</h3>
		</div>
	</div>
	<div class="breadcrumb-line breadcrumb-line-light">
		<div class="breadcrumb">
			<a href="<?php echo admin_url('home');?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> <?php echo lang_line('admin_link_home');?></a>
			<span class="breadcrumb-item"><?php echo lang_line('mod_title');?></span>
			<span class="breadcrumb-item"><?php echo lang_line('mod_title_read');?></span>
		</div>
	</div>
</div>

<div class="content">
	<div class="card">
		<div class="bg-lightX rounded-topX">
			<div class="navbar navbar-light navbar-right bg-light py-lg-2 rounded-top">
				<button type="button" class="button btn-sm btn-default" onclick="window.location.href = '<?php echo admin_url($this->mod)?>';"> <i class="icon-arrow-left7 mr-2"></i><?php echo lang_line('button_back')?></button> 
				<div class="btn-group pull-right mt-2 mb-2 mt-lg-0 mb-lg-0">
					<button type="button" class="button btn-sm btn-default" onClick="window.location.href='<?php echo admin_url($this->mod.'/reply/'.$res_mail['id'])?>'"> <i class="icon-reply"></i> <span class="d-none d-lg-inline-block ml-2"><?php echo lang_line('button_reply')?></span> </button>
					<!-- <button type="button" class="button btn-sm btn-default"> <i class="icon-printer"></i> <span class="d-none d-lg-inline-block ml-2"><?php //echo lang_line('button_print')?></span> </button> -->
					<button type="button" class="button btn-sm btn-default delete_read_mail" data-id="<?php echo encrypt($res_mail['id'])?>"> <i class="icon-bin"></i> <span class="d-none d-lg-inline-block ml-2"><?php echo lang_line('button_delete')?></span> </button> 
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="media flex-column flex-md-row">
				<span class="btn bg-blue-400 btn-icon btn-lg rounded-round mr-3" style="width:40px;height:40px;"><span class="icon-envelope"></span></span>
				<div class="media-body">
					<h4 class="mb-1"><?php echo $res_mail['subject'];?></h4>
					<div>
						<small class="letter-icon-title font-weight-semibold"><?php echo $res_mail['name'];?></small>
						<small class="text-muted"><?php echo $res_mail['email'];?></small>
					</div>
					<small class="text-muted"><?php echo ci_date($res_mail['date'], 'l, d F Y, h:i A');?></small>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="overflow-auto mw-100" style="min-height:400px;"><?php echo $res_mail['message'];?></div>
		</div>
	</div>
</div>