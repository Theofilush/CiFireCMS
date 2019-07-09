<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->CI->render_view('header');
?>
<div class="cols cols-full">
	<div class="colleft">
		<div class="box">
			<div class="page-contact">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<h3>CONTACT INFORMATION</h3>
						<div class="contact-information">
							<div><?=htmlspecialchars_decode($this->settings->website('address'))?></div>
							<hr>
							<ul class="list-infomation">
								<li>
									<p><i class="fa fa-envelope"></i> <?=$this->settings->website('web_email')?></p>
								</li>
								<li>
									<p><i class="fa fa-phone"></i> <?=$this->settings->website('tlpn')?></p>
								</li>
								<li>
									<p><i class="fa fa-fax"></i> <?=$this->settings->website('fax')?></p>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-md-6 col-sm-12">
						<?php
							$this->alert->show('contact');
							echo form_open('','autocomplete="on"');
						?>
							<div class="row">
								<div class="col-md-8">
									<div class="field-item">
										<input type="text" name="name_contact" placeholder="Name" />
									</div>
								</div>
								<div class="col-md-8">
									<div class="field-item">
										<input type="email" name="email_contact" placeholder="Email" />
									</div>
								</div>
								<div class="col-md-8">
									<div class="field-item">
										<input type="text" name="subject_contact" placeholder="Subject" />
									</div>
								</div>
							</div>
							<div class="field-item">
								<textarea name="message_contact" placeholder="Text here..."></textarea>
							</div>
							<div class="field-item">
								<div class="g-recaptcha pull-right" data-sitekey="<?=$this->settings->website('recaptcha_site_key')?>" style="margin-bottom:5px;"></div>
								<script src='https://www.google.com/recaptcha/api.js'></script>
								<button class="my-btn pull-left"><i class="fa fa-send"> </i> SEND</button>
							</div>
						<?=form_close();?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4aoOIudqSItjwJmznfbFFjMiieOTRFv8"></script>
	<script>/* Map */
!function(e){"use strict";google.maps.event.addDomListener(window,"load",function(){var e=new google.maps.LatLng(1.484732,124.8330983),o={zoom:14,center:e},n=new google.maps.Map(document.getElementById("map"),o);new google.maps.Marker({position:e,map:n})})}(jQuery);</script>
<?php $this->CI->render_view('footer'); ?>