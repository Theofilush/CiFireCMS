<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$tabactive = (!empty($this->CI->input->get('tab')) ? $this->CI->input->get('tab') : "tab-general" );
function tabactive($tabactive, $tab = '') {
	$class = '';
	if ($tabactive == $tab)
		$class = 'active';
	return $class;
}
?>
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-inline">
		<div class="page-title">
			<h3>
				<span class="font-weight-semibold"><?=lang_line('mod_title');?></span>
			</h3>
		</div>
	</div>
	<div class="breadcrumb-line breadcrumb-line-light">
		<div class="breadcrumb">
			<a href="<?=admin_url('home');?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> <?=lang_line('admin_link_home');?></a>
			<span class="breadcrumb-item"><?=lang_line('mod_title');?></span>
		</div>
	</div>
</div>
<div class="content">

	<?=$this->alert->show($this->mod);?>
	<div class="ajax_alert" style="display:none;"></div>
	
	<div class="block">
			<div class="card-bodyX">
				<ul class="nav nav-tabs nav-justified">
					<li class="nav-item">
						<a href="#Tab-General" class="nav-link active" data-toggle="tab" style="color:#2B89CA;"><i class="fa fa-desktop mr-2"></i><?=lang_line('tab_general');?></a>
					</li>
					<li class="nav-item">
						<a href="#Tab-Picture" class="nav-link" data-toggle="tab" style="color:#ef6c00;"><i class="fa fa-image mr-2"></i><?=lang_line('tab_picture');?></a>
					</li>
					<li class="nav-item">
						<a href="#Tab-Local" class="nav-link" data-toggle="tab" style="color:#009688;"><i class="fa fa-globe mr-2"></i><?=lang_line('tab_local');?></a>
					</li>
					<li class="nav-item">
						<a href="#Tab-Mail" class="nav-link" data-toggle="tab" style="color:#7e57c2;"><i class="fa fa-envelope mr-2"></i><?=lang_line('tab_mail');?></a>
					</li>
					<li class="nav-item">
						<a href="#Tab-Config" class="nav-link" data-toggle="tab" style="color:#795548;"><i class="fa fa-gears mr-2"></i><?=lang_line('tab_config');?></a>
					</li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content mt-3">
					<!-- Tab-General -->
					<div id="Tab-General" class="tab-pane fadeX showX active">
						<div class="box-body">
							<div class=" table-responsive">
								<table class="table table-striped no-row-border mb-0">
									<tr>
										<td width="200" class="link-setting"><?=lang_line('table_web_name');?></td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="website_name" data-type="text" data-pk="website_name" data-url="<?=admin_url('setting/submit');?>" data-msg="<?=lang_line('form_message_required');?>"><?=$this->settings->website('web_name');?></a>
										</td>
									</tr>

									<tr>
										<td class="link-setting"><?=lang_line('table_web_url');?></td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="website_url" data-type="text" data-pk="website_url" data-url="<?=admin_url('setting/submit');?>" data-msg="<?=lang_line('form_message_required');?>"><?=$this->settings->website('web_url');?></a>
										</td>
									</tr>

									<tr>
										<td class="link-setting"><?=lang_line('table_web_desc');?></td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="meta_description" data-type="textarea" data-pk="meta_description" data-url="<?=admin_url('setting/submit');?>" data-msg="<?=lang_line('form_message_required');?>"><?=$this->settings->website('meta_description');?></a>
										</td>
									</tr>

									<tr>
										<td class="link-setting"><?=lang_line('table_web_keyword');?></td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="meta_keyword" data-type="text" data-pk="meta_keyword" data-url="<?=admin_url('setting/submit');?>" data-msg="<?=lang_line('form_message_required');?>"><?=$this->settings->website('meta_keyword');?></a>
										</td>
									</tr>

									<tr>
										<td class="link-setting"><?=lang_line('table_email');?></td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="web_email" data-type="text" data-pk="web_email" data-url="<?=admin_url('setting/submit');?>" data-msg="<?=lang_line('form_message_required');?>"><?=$this->settings->website('web_email');?></a>
										</td>
									</tr>

									<tr>
										<td class="link-setting"><?=lang_line('table_tlpn');?></td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="tlpn" data-type="text" data-pk="tlpn" data-url="<?=admin_url('setting/submit');?>" data-msg="<?=lang_line('form_message_required');?>"><?=$this->settings->website('tlpn');?></a>
										</td>
									</tr>

									<tr>
										<td class="link-setting"><?=lang_line('table_fax');?></td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="fax" data-type="text" data-pk="fax" data-url="<?=admin_url('setting/submit');?>" data-msg="<?=lang_line('form_message_required');?>"><?=$this->settings->website('fax');?></a>
										</td>
									</tr>

									<tr>
										<td class="link-setting"><?=lang_line('table_address');?></td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="address" data-type="textarea" data-pk="address" data-url="<?=admin_url('setting/submit');?>"><?=$this->settings->website('address');?></a>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>

					<!-- Tab-Picture -->
					<div id="Tab-Picture" class="tab-pane fadeX showX ">
						<div class="box-body">
							<div class=" table-responsive">
								<table class="table table-striped mb-0">
									<!-- Favicon -->
									<tr>
										<td  width="120"><?=lang_line('table_favicon');?></td>
										<td>
											<div class="mb-2">
												<img src="<?=favicon();?>" class="f1_edit">
											</div>
										</td>
									</tr>
									<!--/ Favicon -->
									<!-- Logo -->
									<tr>
										<td><?=lang_line('table_web_logo');?></td>
										<td>
											<div class="mb-2">
												<img src="<?=favicon('logo');?>" class="f2_edit" style="max-width:150px;">
											</div>
										</td>
									</tr>
									<!-- Logo -->
								</table>
							</div>
						</div>
					</div>

					<!-- Tab-Local -->
					<div id="Tab-Local" class="tab-pane fadeX showX ">
						<div class="box-body">
							<div class=" table-responsive">
								<table class="table table-striped no-row-border mb-0">
									<!-- country -->
									<tr>
										<td width="200" class="link-setting"><?=lang_line('table_country');?></td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="country" data-type="select2" data-pk="country" data-url="<?=admin_url('setting/submit');?>" data-value="<?=$this->settings->website('country');?>"><?=$this->settings->website('country');?></a>
										</td>
									</tr>
									<!--/ country -->

									<!-- timezone -->
									<tr>
										<td class="link-setting"><?=lang_line('table_timezone');?></td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="timezone" data-type="select2" data-pk="timezone" data-url="<?=admin_url('setting/submit');?>" data-value="<?=$this->settings->website('timezone');?>"><?=$this->settings->website('timezone');?><br/>
												<div>
													<?=lang_line('mod_lang_date');?> : 
													<?=date('Y-m-d');?> ~ 
													<?=lang_line('mod_lang_time');?> : 
													<?=date('h:i:s');?>
												</div>
											</a>
										</td>
									</tr>
									<!--/ timezone -->

									<!-- language -->
									<tr>
										<td class="link-setting"><?=lang_line('table_language');?></td>
										<td class="link-setting">
											<div class="form-roup">
												<?php
													echo form_open(admin_url($this->mod.'/submit'), 'onchange="submit()"');
													echo form_hidden('pk','language');
												?>
												<select name="lang" class="form-control input-sm" style="max-width:200px;">
													<option style="display:none;"><?=$this->settings->website('language');?></option>
													<?php
														$langs = $this->db->where('active','Y')->get('t_language')->result_array();
														foreach ($langs as $res_lang) {
													?>
													<option value="<?=$res_lang['id'];?>"><?=$res_lang['title'];?></option>
													<?php } ?>
												</select>
												<?=form_close();?>
											</div>
										</td>
									</tr>
									<!--/ language -->
								</table>
							</div>
						</div>
					</div>

					<!-- Tab-Mail -->
					<div id="Tab-Mail" class="tab-pane fadeX showX ">
						<div class="box-body">
							<div class=" table-responsive">
								<table class="table table-striped no-row-border mb-0">
									<!-- SMTP -->
									<tr>
										<td width="200">Protocol</td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="protocol" data-type="select" data-pk="mail_protocol" data-url="<?=admin_url('setting/submit');?>" data-value="<?=$this->settings->website('protocol');?>"><?=$this->settings->website('protocol');?></a>
										</td>
									</tr>
									<tr>
										<td width="200">Hostname</td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="hostname" data-type="text" data-pk="mail_hostname" data-url="<?=admin_url('setting/submit');?>" data-value="<?=$this->settings->website('hostname');?>"><?=$this->settings->website('hostname');?></a>
										</td>
									</tr>
									<tr>
										<td width="200">Username</td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="username" data-type="text" data-pk="mail_username" data-url="<?=admin_url('setting/submit');?>" data-value="<?=$this->settings->website('username');?>"><?=$this->settings->website('username');?></a>
										</td>
									</tr>
									<tr>
										<td width="200">Password</td>
										<td class="link-setting"><a href="javascript:void(0)" id="password" data-type="password" data-pk="mail_password" data-url="<?=admin_url('setting/submit');?>" data-value="">
										<?php
											if (!empty($this->settings->website('password')))
												echo "[hidden]";
										?>
										</a></td>
									</tr>
									<tr>
										<td width="200">Port</td>
										<td class="link-setting"><a href="javascript:void(0)" id="port" data-type="text" data-pk="mail_port" data-url="<?=admin_url('setting/submit');?>" data-value="<?=$this->settings->website('port');?>"><?=$this->settings->website('port');?></a></td>
									</tr>
									<!--/ SMTP -->
								</table>
							</div>
						</div>
					</div>

					<!-- Tab-Config -->
					<div id="Tab-Config" class="tab-pane fadeX showX ">
						<div class="box-body">
							<div class=" table-responsive mb-3">
								<table class="table table-striped no-row-border mb-0">
									<!-- maintenance -->
									<tr>
										<td width="200"><?=lang_line('table_maintenance');?></td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="maintenance" data-type="select" data-pk="maintenance" data-url="<?=admin_url('setting/submit');?>" data-value="<?=$this->settings->website('maintenance');?>"><?=$this->settings->website('maintenance');?></a>
										</td>
									</tr>
									<!--/ maintenance -->
									<!-- member_registration -->
									<tr>
										<td><?=lang_line('table_member_reg');?></td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="member_registration" data-type="select" data-pk="member_registration" data-url="<?=admin_url('setting/submit');?>" data-value="<?=$this->settings->website('member_registration');?>"><?=$this->settings->website('member_registration');?></a>
										</td>
									</tr>
									<!--/ member_registration -->

									<!-- Cache -->
									<tr>
										<td class="valign-middle">Cache</td>
										<td>

											<?=form_open(admin_url($this->mod.'/submit'),'class="form-inline"');?>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">Status</span>
												</div>
												<select name="cache" class="form-control" style="max-width:70px;">
													<option value="<?=$this->settings->website('cache');?>" style="display:none;"><?=$this->settings->website('cache');?></option>
													<option value="Y">Y</option>
													<option value="Y">N</option>
												</select>
												<div class="input-group-prepend">
													<span class="input-group-text">Expire time</span>
												</div>
												<select name="cache_time" class="form-control" style="max-width:120px;">
													<option value="<?=$this->settings->website('cache_time');?>" style="display:none;"><?=$this->settings->website('cache_time');?> Minutes</option>
													<option value="1">1 Minutes</option>
													<option value="2">2 Minutes</option>
													<option value="3">3 Minutes</option>
													<option value="4">4 Minutes</option>
													<option value="5">5 Minutes</option>
												</select>
												<div class="input-group-append">
													<button type="submit" name="pk" value="cache" class="input-group-text btn btn-default text-primary"><i class="fa fa-check mr-2"></i>Submit</button>
												</div>
												<?=form_close();?>
												<?=form_open(admin_url($this->mod.'/submit'),'class="form-inline"');?>
												<div class="input-group-append">
													<button type="submit" name="pk" value="del_cache" class="input-group-text btn btn-flat btn-default text-danger"><i class="icon-bin mr-2"></i>Delete</button>
												</div>
												<?=form_close();?>
											</div>											
										</td>
									</tr>
									<!--/ Cache -->

									<!-- sitemap -->
									<tr>
										<td class="valign-middle"><?=lang_line('table_sitemap');?></td>
										<td>
											<form method="post" action="<?=admin_url('setting/submit');?>" autocomplete="off" class="form-inline">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"><?=lang_line('button_frequency');?></span>
												</div>
												<select name="changefreq" class="form-control">
													<option value="" selected="">None</option>
													<option value="always">Always</option>
													<option value="hourly">Hourly</option>
													<option value="daily">Daily</option>
													<option value="weekly">Weekly</option>
													<option value="monthly">Monthly</option>
													<option value="yearly">Yearly</option>
													<option value="never">Never</option>
												</select>
												<div class="input-group-prepend">
													<span class="input-group-text"><?=lang_line('button_priority');?></span>
												</div>
												<select name="priority" class="form-control">
													<option value="0.1" selected="">0.1</option>
													<option value="0.2">0.2</option>
													<option value="0.3">0.3</option>
													<option value="0.4">0.4</option>
													<option value="0.5">0.5</option>
													<option value="0.6">0.6</option>
													<option value="0.7">0.7</option>
													<option value="0.8">0.8</option>
													<option value="0.9">0.9</option>
													<option value="1.0">1.0</option>
												</select>
												<div class="input-group-append">
													<button type="submit" name="pk" value="sitemap" class="input-group-text btn btn-default text-primary"><?=lang_line('button_create_sitemap');?></button>
												</div>
											</div>
											</form>
										</td>
									</tr>
									<!--/ sitemap -->

									<!-- Slug Url -->
									<tr>
										<td width="200">Slug Url</td>
										<td class="link-setting">
											<?php
												$dtslg = $this->settings->website('slug_url');
												$slug_title = $this->CI->db->where('title', $dtslg)->get('t_slug')->row_array()['title'];
											?>
											<a href="javascript:void(0)" id="slug_url" data-type="select2" data-pk="slug_url" data-url="<?=admin_url('setting/submit');?>" data-value="<?=$slug_title;?>"><?=$slug_title;?></a>
										</td>
									</tr>
									<!--/ Slug Url -->

									<!-- Slug Title -->
									<tr>
										<td width="200">Slug Title</td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="slug_title" data-type="text" data-pk="slug_title" data-url="<?=admin_url('setting/submit');?>"><?=$this->settings->website('slug_title');?></a>
										</td>
									</tr>
									<!--/ Slug Title -->

									<!-- Page Item -->
									<tr>
										<td width="200"><?=lang_line('table_pageitem');?></td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="page_item" data-type="text" data-pk="page_item" data-url="<?=admin_url('setting/submit');?>" data-msg="<?=lang_line('form_message_required');?>"><?=$this->settings->website('page_item');?></a>
										</td>
									</tr>
									<!--/ Page Item -->

									<!-- site key -->
									<tr>
										<td><?=lang_line('table_site_key');?></td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="recaptcha_site_key" data-type="text" data-pk="recaptcha_site_key" data-url="<?=admin_url('setting/submit');?>"><?=$this->settings->website('recaptcha_site_key');?></a>
										</td>
									</tr>
									<!--/ site key -->

									<!-- secret key -->
									<tr>
										<td><?=lang_line('table_secret_key');?></td>
										<td class="link-setting">
											<a href="javascript:void(0)" id="recaptcha_secret_key" data-type="text" data-pk="recaptcha_secret_key" data-url="<?=admin_url('setting/submit');?>"><?=$this->settings->website('recaptcha_secret_key');?></a>
										</td>
									</tr>
									<!--/ secret key -->
								</table>
							</div>
							<hr>
							<h4><?=lang_line('mod_lang_metasocial');?></h4>
							<form method="POST" id="form-meta">
								<?php
									// $filename_meta = FCPATH.'application/config/config.php';
									$filename_meta = VIEWPATH.'meta_social.php';
									
									if (file_exists("$filename_meta")) 
									{
										$fh_meta = fopen($filename_meta, "r") or die("Could not open file!");
										$data_meta = fread($fh_meta, filesize($filename_meta)) or die("Could not read file!");
										fclose($fh_meta);
								?>
								<input type="hidden" name="pk" value="meta_social" />
								<style type="text/css">
									.CodeMirror { height:600px; margin-bottom: 5px;}
								</style>

								<textarea class="form-control content" id="code_metasocial" name="meta_content"><?=$data_meta;?></textarea>

								<button type="button" id="submit-meta" class="btn btn-md btn-primary pull-right"><i class="fa fa-save"></i> &nbsp; <?=lang_line('button_save');?> <?=lang_line('mod_lang_metasocial');?></button>
								<div class="clearfix"></div>
								<?php } ?>
							</form>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>



<div id="modal_fedit" class="modal fade" id="modal-1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modal_title"><i class="fa fa-upload"></i></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			</div>
			<div class="modal-body text-center">
				<?php echo form_open_multipart(admin_url('setting/submit'),'autocomplete="off"');?>
				<input id="data_act" type="hidden" name="pk">
				<input type="file" name="fupload" class="file-input" 
					data-show-caption="false" 
					data-browse-label="Browse" 
					data-remove-class="btn btn-sm btn-danger" 
					data-upload-class="btn btn-sm btn-dark" 
					data-browse-class="btn btn-sm btn-default" 
					data-fouc="">
				<?=form_close();?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->