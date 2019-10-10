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
			<span class="breadcrumb-item"><?php echo lang_line('mod_title_edit');?></span>
		</div>
	</div>
</div>
<div class="content">
	<?php echo $this->alert->show($this->mod); ?>
	<div class="block">
		<div class="block-header">
			<h3><?php echo lang_line('mod_title_edit'); ?> - <i><?php echo $res_theme['title'];?></i> </h3>
			<div class="pull-right">
				<a href="<?php echo admin_url($this->mod);?>" class="button btn-sm btn-default"><i class="fa fa-arrow-circle-o-left"></i> <?php echo lang_line('mod_title');?></a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php 
					echo form_open('','autocomplete="off"'); 
					echo form_hidden('act','edit');
				?>
				<div class="box-body">
					<div class="btn-group">
						<!-- files -->
						<ul class="nav">
							<li class="nav-item dropdown">
								<a href="#" class="nav-link dropdown-toggle button btn-sm btn-flat btn-default" data-toggle="dropdown"><i class="fa fa-file-text-o mr-2"></i><?php echo $file_layout.".php";?></a>
								<div class="dropdown-menu dropdown-menu-left">
									<?php
										$fileLayout = VIEWPATH.'themes/'.$res_theme['folder']."/$file_layout.php";

										$data = read_file($fileLayout);
										$data = str_replace("textarea", "textarea_CI", $data);
										$theme_files = get_filenames(VIEWPATH.'themes/'.$res_theme['folder']);

										foreach ($theme_files as $value) {
											$ekstensi = pathinfo($value, PATHINFO_EXTENSION);
											$filename = pathinfo($value, PATHINFO_FILENAME);
											if ($ekstensi === 'php') {
												echo '<a class="dropdown-item" href="'.admin_url($this->mod.'/edit/'.$res_theme['id'].'/'.$filename).'">'.$value.'</a>';
											}
										}
									?>
								</div>
							</li>
						</ul>
						<!-- button create_file -->
						<button type="button" class="button btn-sm btn-flat btn-default create_file" data-toggle="tooltip" data-placement="top" title="Add New File"><i class="icon-file-plus "></i></button>
						<!-- button upload_theme_asets -->
						<button type="button" class="button btn-sm btn-flat btn-default upload_theme_asets" data-toggle="tooltip" data-placement="top" title="Upload theme assets"><i class="icon-upload"></i></button>
					</div>
					<!-- button Editor Shortcut Key -->
					<button type="button" class="pull-right button btn-sm btn-flat btn-default modal-helper" data-toggle="tooltip" data-placement="top" title="Editor Shortcut Key"><i class="fa fa-question-circle"></i></button>
					<style type="text/css">.CodeMirror{heightX:500px;font-family:consolas;}.CodeMirror.CodeMirror-fullscreen{z-index:1060;height: 100% !important;}</style>
					<textarea id="AreaCodemirrors" name="code_content" class="form-control mt-0"><?php echo $data;?></textarea>
				</div>
				<div class="block-actions mt-3">
					<button type="submit" class="button btn-md btn-primary text-b"><i class="fa fa-save mr-2"></i><?php echo lang_line('button_save');?></button>
				</div>	
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</div>

<div id="modal_create_file" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php 
				echo form_open('','autocomplete="off"');
				echo form_hidden('act','create_file');
			?>
			<div class="modal-header">
				<b><i class="icon-file-plus mr-2"></i>Create File</b>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>File name</label>
					<input type="text" name="filename" class="form-control" required="">
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="button btn-primary"><i class="fa fa-check mr-2"></i><?php echo lang_line('button_submit')?></button>
				<span class="button btn-default" data-dismiss="modal" aria-hidden="true"><?php echo lang_line('button_cancel')?></span>
			</div>
			<?php echo form_close();?>
		</div>
	</div>
</div>

<div id="modal_upload_theme_assets" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<b><i class="icon-upload mr-2"></i>Upload Theme Assets</b>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body text-center">
				<?php 
					echo form_open_multipart('','autocomplete="off"');
					echo form_hidden('act','upload_theme_assets');
				?>
				<div class="form-group">
					<input type="file" name="fupload" class="file-input" 
						data-show-caption="false" 
						data-browse-label="Browse zip file" 
						data-remove-class="btn btn-sm btn-danger" 
						data-upload-class="btn btn-sm btn-dark" 
						data-browse-class="btn btn-sm btn-default" 
						data-fouc="">
				</div>
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</div>

<div id="modal-helper" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fa fa-keyboard-o"></i> &nbsp; Editor Shortcut Key
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<small style="font-family: arial;">
				<ul class="fa-ul">
					<li><i class="fa fa-pencil fa-li"></i> Put the cursor on or inside a pair of tags to highlight them. Press <strong>Ctrl+J</strong> to jump to the tag that matches the one under the cursor.</li>
					<li><i class="fa fa-pencil fa-li"></i> Press <strong>F11</strong> when cursor is in the editor to toggle full screen editing. <strong>Esc</strong> can also be used to <i>exit</i> full screen editing.</li>
					<li><i class="fa fa-pencil fa-li"></i> Press <strong>Ctrl+Space</strong> to activate completion.</li>
					<li>
						<i class="fa fa-pencil fa-li"></i> Demonstration of primitive search/replace functionality. The keybindings (which can be overridden by custom keymaps) are :
						<ul>
							<li><strong>Ctrl+F / Cmd-F</strong> for Start searching</li>
							<li><strong>Ctrl+G / Cmd+G</strong> for Find next</li>
							<li><strong>Shift+Ctrl+G / Shift+Cmd+G</strong> for Find previous</li>
							<li><strong>Shift+Ctrl+F / Cmd+Option+F</strong> for Replace</li>
							<li><strong>Shift+Ctrl+R / Shift+Cmd+Option+F</strong> for Replace all</li>
						</ul>
					</li>
				</ul></small>
			</div>
			<div class="modal-footer">
				<span class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true">Close</span>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
	    var editor = CodeMirror.fromTextArea(document.getElementById("AreaCodemirrors"), {
	       mode: "php",
	        extraKeys: {
	            "Ctrl-J": "toMatchingTag",
	            "F11": function(cm) {
	                cm.setOption("fullScreen", !cm.getOption("fullScreen"));
	            },
	            "Esc": function(cm) {
	                if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
	            },
	            "Ctrl-Space": "autocomplete"
	        },
	       	theme: "github",
	        lineWrapping: true,
	        cursorBlinkRate: 200,
	        autocorrect: true,
	        autofocus: true,
	        lineNumbers: true,
	        gutters: ["CodeMirror-linenumbers"],
	        styleActiveLine: true,
	        autoCloseBrackets: true,
	        autoCloseTags: true
	        // scrollbarStyle:"simple",
	    });
	});
</script>