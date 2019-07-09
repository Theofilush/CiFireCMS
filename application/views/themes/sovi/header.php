<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$this->CI->meta_title;?></title>
	<meta name="description" content="<?=$this->CI->meta_description;?>"/>
	<meta name="keywords" content="<?=$this->CI->meta_keywords;?>"/>
	<meta http-equiv="Copyright" content="<?=$this->settings->website('web_name');?>"/>
	<meta name="author" content="<?=$this->settings->website('web_name');?>"/>
	<meta http-equiv="imagetoolbar" content="no"/>
	<meta name="language" content="<?=$this->_language;?>"/>
	<meta name="revisit-after" content="7"/>
	<meta name="webcrawlers" content="all"/>
	<meta name="rating" content="general"/>
	<meta name="spiders" content="all">

	<!-- Social Media Meta -->
	<?php $this->CI->load->view('meta_social'); ?>

	<!-- CSS -->
	<link href="<?=content_url('plugins/font-awesome/font-awesome.min.css');?>" rel="stylesheet" />
	<link href="<?=$this->CI->theme_asset('css/bootstrap.min.css');?>" rel="stylesheet" />
	<link href="<?=$this->CI->theme_asset('css/main.min.css');?>" rel="stylesheet" />
	<link href="<?=$this->CI->theme_asset('css/owl.carousel.min.css');?>" rel="stylesheet" />
	<link href="<?=$this->CI->theme_asset('css/jquery.fancybox.min.css');?>" rel="stylesheet" />
	
	<!-- Favicons -->
	<link rel="shortcut icon" href="<?=favicon();?>">

	<!-- JavaScripts -->
	<script src="<?=$this->CI->theme_asset('js/jquery.min.js');?>"></script>
	<!--<script src="js/modernizr.js"></script>-->
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
    <!--preload-->
    <div class="loader" id="page-loader">
    	<p>Loading...</p>
    </div>
	<!--menu mobile-->
	<nav class="menu-res hidden-lg hidden-md">
		<div class="menu-res-inner">
			<?php 
				echo $this->CI->load_menu(
					$menu_id = 4, 
					$ul_attr = '', 
					$li_attr = 'class="menu-item-has-children"', 
					$a_attr ='', 
					$li_ul_attr = 'class="sub-menu"',  
					$ul_li_a_ul_li = ''
				);
			?>
		</div>
	</nav>
	<!--page-->
	<div class="page">
		<div class="wrap">
			<!--topbar-->
			<div class="topbar">
				<div class="topnav">
					<ul class="navbar-nav">
						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><img src="<?=content_url('images/flag/'.$this->_language.'.png')?>" alt=""><?=humanize($this->_language)?></a>
							<ul class="dropdown-menu dropdown-menu-right">
								<li class="dropdown-item"><a href="javascript:void(0)" onclick="setLang('indonesia')">Indonesia</a></li>
								<li class="dropdown-item"><a href="javascript:void(0)" onclick="setLang('english')">English</a></li>
							</ul>
						</li>
						<li class="nav-item">
							<a href="<?=member_url()?>" class="nav-link"><i class="fa fa-user-circle-o"></i> Login</a>
						</li>
					</ul>
				</div>
			</div>
			<!--header-->
			<header class="header">
				<div class="header-inner">
					<div class="logo-wrap">
						<a href="<?=site_url(); ?>" class="logo">
							<img alt="Logo" src="<?=$this->CI->theme_asset('images/logo.png')?>" />
						</a>
					</div>

					<!-- main nav menu -->
					<nav class="menu-main hidden-sm hidden-xs">
						<?php 
							echo $this->CI->load_menu(
								$menu_id = 4, 
								$ul_attr = '', 
								$li_attr = '', 
								$a_attr ='', 
								$li_ul_attr = 'class="sub-menu"',  
								$ul_li_a_ul_li = ''
							);
						?>
					</nav>

					<div class="header-right">
						<div class="search-box">
							<form action="<?=site_url('search');?>" method="POST" autocomplete="on">
								<input type="text" name="kata" placeholder="Typing and Enter..." />
							</form>
							<button type="button" class="search-icon">
								<i class="fa fa-search"></i>
							</button>
						</div>
						<div class="menu-icon hidden-lg hidden-md">
							<i class="fa fa-reorder"></i>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</header>
			<!-- breaking-news -->
			<section class="breaking-news">
				<span class="breaking-news-caption">News</span>
				<div class="owl-breaking-wrap">
					<div class="owl-carousel owl-breaking">
						<?php 
							$header_news = $this->db
								->select('title, seotitle, datepost, timepost')
								->where('active', 'Y')
								->order_by('id','DESC')
								->limit(5)
								->get('t_post')
								->result_array();
							foreach ($header_news as $row_hnews): ?>
						<div>
							<p>
								<a href="<?=post_url($row_hnews['seotitle']);?>" title="<?=$row_hnews['title'];?>">
								<small class="label label-danger" style="Ccolor:#F0FF00;"><?=ci_date($row_hnews['datepost'].$row_hnews['timepost'],'l, H:i A');?></small>&nbsp;
								<?=$row_hnews['title'];?>
								</a>
								
							</p>
						</div>
						<?php endforeach ?>
					</div>
				</div>
			</section>
