<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content">
	<div class="block-header">
		<h2>File Manager</h2>
	</div>
	<div class="block-content">
		<style>iframe.flstyle{width: 100% !important; min-height:600px !important; border:1px solid #ddd; background-color: #fff !important; } </style>
		<iframe class="flstyle" frameborder="0" src="<?php echo content_url('plugins/filemanager/dialog.php?type=0&sort_by=extension&descending=1');?>"></iframe>
	</div>
</div>