<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $this->CI->meta_title;?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta name="description" content="<?php echo $this->CI->meta_description;?>"/>
	<meta name="keywords" content="<?php echo $this->CI->meta_keywords;?>"/>
	<meta name="author" content="<?php echo $this->settings->website('web_name');?>"/>
	<meta http-equiv="Copyright" content="<?php echo $this->settings->website('web_name');?>"/>
	<meta http-equiv="imagetoolbar" content="no"/>
	<meta name="language" content="<?php echo $this->_language;?>"/>
	<meta name="revisit-after" content="7"/>
	<meta name="webcrawlers" content="all"/>
	<meta name="rating" content="general"/>
	<meta name="spiders" content="all"/>

	<!-- Social Media Meta -->
	<?php $this->CI->load->view('meta_social'); ?>

	<!-- stylesheet -->
	<link rel="stylesheet" href="<?php echo $this->CI->theme_asset('css/bootstrap.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?php echo $this->CI->theme_asset('css/style.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?php echo $this->CI->theme_asset('css/dark.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?php echo $this->CI->theme_asset('css/font-icons.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?php echo $this->CI->theme_asset('css/animate.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?php echo $this->CI->theme_asset('css/magnific-popup.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?php echo $this->CI->theme_asset('css/responsive.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?php echo content_url('plugins/prism/prism.css');?>" type="text/css"/>
	
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Raleway:300,400,500,600,700|Crete+Round:400i" rel="stylesheet" type="text/css" />

	<link rel="shortcut icon" href="<?php echo favicon();?>">
</head>
<body class="stretched">
	<div id="wrapperX" class="clearfix">
		<!-- Top Bar -->
		<div id="top-bar">
			<div class="container clearfix">
				<div class="col_half nobottommargin">
					<!-- Top Links -->
					<div class="top-links">
						<ul>
							<li><a href="<?php echo site_url('about-us');?>">About Us</a></li>
							<li><a href="<?php echo site_url('contact');?>">Contact</a></li>
							<!-- <li>
								<?php
									/*
									if ( login_status('member') == TRUE ) {
										echo '<a href="'. member_url() .'"><i class="icon-user"></i> '. data_login('member', 'name') .'</a>';
									} else {
										echo '<a href="'. member_url() .'"><i class="icon-user"></i> Login</a>';
									}
									*/
								?>
							</li> -->
						</ul>
					</div>
				</div>
				
				<!-- top-social -->
				<div class="col_half fright col_last nobottommargin">
					<div id="top-social">
						<ul>
							<li>
								<a href="javascript:void(0)" class="si-facebook"><span class="ts-icon"><i class="icon-facebook"></i></span><span class="ts-text">Facebook</span></a>
							</li>
							<li>
								<a href="javascript:void(0)" class="si-twitter"><span class="ts-icon"><i class="icon-twitter"></i></span><span class="ts-text">Twitter</span></a>
							</li>
							<li>
								<a href="javascript:void(0)" class="si-instagram"><span class="ts-icon"><i class="icon-instagram2"></i></span><span class="ts-text">Instagram</span></a>
							</li>
							<li>
								<a href="tel:+62 000 0000 0000" class="si-call"><span class="ts-icon"><i class="icon-call"></i></span><span class="ts-text"><?php echo  $this->CI->settings->website('tlpn') ?></span></a>
							</li>
							<li>
								<a href="mailto:info@mail.org" class="si-email3"><span class="ts-icon"><i class="icon-email3"></i></span><span class="ts-text"><?php echo  $this->CI->settings->website('web_email') ?></span></a>
							</li>
						</ul>
					</div>
				</div>
				<!--/ top-social -->
			</div>
		</div>
		<!--/ Top Bar -->

		<header id="header" class="sticky-style-2">
			<div class="container clearfix">
				<!-- Logo -->
				<div id="logo">
					<a href="<?php echo site_url();?>" title="<?php echo $this->CI->settings->website('web_name');?>" class="standard-logo" data-dark-logo="<?php echo favicon('logo');?>"><img src="<?php echo favicon('logo').'?'.strtotime(date('Ymd'));?>" alt="Logo" style="width:50px;height:50px;margin-top:25px;"></a>
					<a href="index.html" class="retina-logo" data-dark-logo="<?php echo favicon('logo').'?'.strtotime(date('Ymd'));?>"><img src="<?php echo favicon('logo').'?'.strtotime(date('Ymd'));?>" alt="Logo"></a>
				</div>
				<div class="top-advert">
					<img src="<?php echo $this->CI->theme_asset('images/ad.jpg?'.strtotime(date('Ymd')));?>" alt="Ads">
				</div>
			</div>

			<div id="header-wrap">
				<!-- Primary Navigation -->
				<nav id="primary-menu" class="style-2">
					<div class="container clearfix">
						<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
						<?php echo  $this->CI->load_menu(4); ?>
						<!-- Top Search -->
						<div id="top-search">
							<a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
							<form action="<?php echo site_url('search');?>" method="POST" autocomplete="off">
								<input type="text" name="kata" class="form-control" placeholder="Type &amp; Enter.." required>
							</form>
						</div>
						<!--/ Top Search -->
					</div>
				</nav>
				<!--/ Primary Navigation -->
			</div>
		</header>