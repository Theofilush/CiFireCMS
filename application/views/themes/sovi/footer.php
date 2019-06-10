<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
		</div>

		<!-- Maps -->
		<?php if ($this->uri->segment(1) === 'contact'): ?>
		<section class="map"><div id="map"></div></section>
		<?php endif ?>
		<!--/ Maps -->

		<footer class="footer">
			<div class="wrap">
				<div class="box-site-info">
					<a href="<?php echo site_url(); ?>" title="<?php echo $this->settings->website('web_name') ?>" class="logo">
						<img alt="" src="<?php echo favicon('logo'); ?>" />
					</a>
					<ul class="social-company">
						<li>
							<a href="#"><i class="fa fa-facebook-f"></i></a>
						</li>
						<li>
							<a href="#"><i class="fa fa-twitter"></i></a>
						</li>
						<li>
							<a href="#"><i class="fa fa-instagram"></i></a>
						</li>
						<li>
							<a href="#"><i class="fa fa-youtube"></i></a>
						</li>
						<li>
							<a href="#"><i class="fa fa-pinterest"></i></a>
						</li>
					</ul>
					<ul class="menu-footer">
						<li>
							<a href="<?php echo site_url(); ?>" title="Home"> Home </a>
						</li>
						<li>
							<a href="<?php echo site_url('about-us'); ?>" title="About Us">About Us<span></span></a>
						</li>
						<li>
							<a href="<?php echo site_url('contact'); ?>" title="Contact">Contact<span></span></a>
						</li>
					</ul>
				</div>
			</div>
			<div class="allright">
				<p>Copyright <?php echo date('Y'); ?> <a href="<?php echo site_url(); ?>" title="<?php echo $this->settings->website('web_name') ?>"><?php echo $this->settings->website('web_name') ?></a>. Powered By <a href="https://www.alweak.com/" title="Alweak CiFireCMS">Alweak</a></p>
			</div>
		</footer>
	</div>

	<!-- Link Go To Top -->
	<div class="totop"></div>

	<!-- JavaScript -->
	<script src="<?=$this->CI->theme_asset('js/bootstrap.min.js');?>"></script>
	<script src="<?=$this->CI->theme_asset('js/isotope.pkgd.min.js');?>"></script>
	<script src="<?=$this->CI->theme_asset('js/owl.carousel.min.js');?>"></script>
	<script src="<?=$this->CI->theme_asset('js/jquery.fancybox.min.js');?>"></script>
	<script src="<?=$this->CI->theme_asset('js/main.js');?>"></script>

	<script>
		function setLang(lang){
			var dataLang = lang;
			$.ajax({
				url: '<?=site_url("home/setlang")?>',
				type: 'POST',
				dataType: 'json',
				data:{
					data: dataLang
				},
				cache:false,
				success:function(response){
					window.location.reload();
				}
			});
		}
	</script>
</body>
</html>