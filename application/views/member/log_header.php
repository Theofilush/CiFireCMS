<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title><?=$this->CI->meta_title;?></title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

	<!-- bootstrap -->
	<link href="<?=content_url('plugins/member/css/bootstrap.min.css')?>" rel="stylesheet" />
	<!-- font-awesome -->
	<link href="<?=content_url('plugins/font-awesome/font-awesome.min.css')?>" rel="stylesheet" />
	<!-- select2 -->
	<link href="<?=content_url('plugins/select2/select2.css')?>" rel="stylesheet" />
	<!-- tagsinput/typeahead -->
	<link rel="stylesheet" href="<?=content_url('plugins/tagsinput/typeahead.css')?>" type="text/css">

	<link href="<?=content_url('plugins/member/css/light-bootstrap-dashboard.css')?>" rel="stylesheet" />

	<!-- favicon -->
	<link rel="shortcut icon" href="<?=favicon()?>" />

	<script type="text/javascript">
		var _URL = '<?=member_url();?>';
	</script>
</head>
<body>
