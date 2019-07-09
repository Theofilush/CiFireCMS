<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- 
*******************************************************
	Include Header Template
******************************************************* 
-->
<?php include_once('header.php'); ?>
<!-- End Header -->

<!-- 
*******************************************************
	Insert Content
******************************************************* 
-->
<section id="page-title">
	<div class="container clearfix">
		<!-- <h1>Pages</h1> -->
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= site_url(); ?>">Home</a></li>
			<li class="breadcrumb-item"><a href="#">Pages</a></li>
			<li class="breadcrumb-item active" aria-current="page"><?=$res['title'];?></li>
		</ol>
	</div>
</section>
<section id="content">
	<div class="content-wrap pt-5">
		<div class="container clearfix">
			<div class="">
				<h1><?=$res['title'];?></h1>
			</div>
			<div class="col_full detail-content">
				<?=html_entity_decode($res['content']);?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</section>
<!-- End Content -->

<!-- 
*******************************************************
	Include Footer Template
******************************************************* 
-->
<?php include_once('footer.php'); ?>
<!-- End Footer -->