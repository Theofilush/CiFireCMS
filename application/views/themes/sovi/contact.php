<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- 
*******************************************************
	Include Header Template
******************************************************* 
-->
<?php require_once('header.php'); ?>
<!-- End Header -->

<!-- 
*******************************************************
	Insert Content
******************************************************* 
-->
<section id="page-title">
	<div class="container clearfix">
		<h1>Contact</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url();?>">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Contact</li>
		</ol>
	</div>
</section>
<section id="content">
	<div class="content-wrap">
		<div class="container clearfix">
			<!-- Postcontent -->
			<div class="postcontent nobottommargin">
				<div class="contact-widget">
					<div class="contact-form-result"></div>
					<?php
						$this->alert->show('contact');
						echo form_open('','class="nobottommargin" id="template-contactform" autocomplete="off"');
					?>
						<div class="form-process"></div>

						<div class="col_half">
							<label for="cf-name">Nama</label>
							<input type="text" id="cf-name" name="name_contact" class="sm-form-control required" required/>
						</div>

						<div class="col_half col_last">
							<label for="cf-email">Email</label>
							<input id="cf-email" type="email" name="email_contact" class="required email sm-form-control" required/>
						</div>

						<div class="clear"></div>

						<div class="col_full">
							<label for="cf-subject">Subyek</label>
							<input id="cf-subject" type="text" name="subject_contact" class="required sm-form-control" required/>
						</div>

						<div class="clear"></div>

						<div class="col_full">
							<label for="cf-message">Pesan</label>
							<textarea id="cf-message" class="required sm-form-control" name="message_contact" rows="6" cols="30" required></textarea>
						</div>

						<div class="col_full">
							<div class="g-recaptcha pull-right" data-sitekey="<?php echo $this->settings->website('recaptcha_site_key')?>" style="margin-bottom:5px;"></div>
							<script src='https://www.google.com/recaptcha/api.js'></script>
							<button type="submit" class="button button-3d m-0"><?php echo lang_line('button_send')?> <i class="icon-paperplane"></i></button>
						</div>
					<?php echo form_close();?>
				</div>
			</div>
			<!--/ Postcontent -->
			<!-- Sidebar -->
			<div class="sidebar col_last nobottommargin">
				<address>
					<strong>Address:</strong><br>
					<?php echo htmlspecialchars_decode($this->CI->settings->website('address'));?>
				</address>
				<abbr title="Phone Number"><strong>Phone : </strong></abbr> <?php echo $this->CI->settings->website('tlpn');?><br>
				<abbr title="Fax"><strong>Fax : </strong></abbr> <?php echo $this->CI->settings->website('fax');?><br>
				<abbr title="Email Address"><strong>Email : </strong></abbr> <?php echo $this->CI->settings->website('web_email');?>

				<div class="widget noborder notoppadding">
					<a href="#" class="social-icon si-small si-dark si-facebook">
						<i class="icon-facebook"></i>
						<i class="icon-facebook"></i>
					</a>

					<a href="#" class="social-icon si-small si-dark si-twitter">
						<i class="icon-twitter"></i>
						<i class="icon-twitter"></i>
					</a>

					<a href="#" class="social-icon si-small si-dark si-instagram">
						<i class="icon-instagram"></i>
						<i class="icon-instagram"></i>
					</a>

					<a href="#" class="social-icon si-small si-dark si-youtube">
						<i class="icon-youtube"></i>
						<i class="icon-youtube"></i>
					</a>

					<a href="#" class="social-icon si-small si-dark si-pinterest">
						<i class="icon-pinterest"></i>
						<i class="icon-pinterest"></i>
					</a>

					<a href="#" class="social-icon si-small si-dark si-rss">
						<i class="icon-rss"></i>
						<i class="icon-rss"></i>
					</a>
				</div>
			</div>
			<!--/ Sidebar -->
		</div>
	</div>
</section>
<!-- End Content -->

<!-- 
*******************************************************
	Include Footer Template
******************************************************* 
-->
<?php require_once('footer.php'); ?>
<!-- End Footer -->