<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
		<footer id="footer" class="dark">
			<div class="container">
				<div class="footer-widgets-wrap clearfix">
					<div class="col_two_third">
						<div class="col_one_third">
							<div class="widget clearfix">
								<img src="<?php echo $this->CI->theme_asset();?>/images/footer-widget-logo.png" alt="logo" class="footer-logo">
								<div style="background: url('<?php echo $this->CI->theme_asset();?>/images/world-map.png') no-repeat center center; background-size: 100%;">
									<address>
										<strong>Address:</strong><br>
										<?php echo htmlspecialchars_decode($this->CI->settings->website('address'));?>
									</address>
									<abbr title="Phone Number"><strong>Phone : </strong></abbr> <?php echo $this->CI->settings->website('tlpn');?><br>
									<abbr title="Fax"><strong>Fax : </strong></abbr> <?php echo $this->CI->settings->website('fax');?><br>
									<abbr title="Email Address"><strong>Email : </strong></abbr> <?php echo $this->CI->settings->website('web_email');?>
								</div>
							</div>
						</div>

						<div class="col_one_third">
							<div class="widget widget_links clearfix">
								<h4>Category</h4>
								<ul>
									<?php
										$footer_category = $this->CI->db
											->select('id_category,COUNT(*)')
											->from('t_post')
											->where('active','Y')
											->group_by('id_category')
											->order_by('COUNT(*)','DESC')
											->get()
											->result_array();
										foreach ($footer_category as $rescount):
											$row_scategory = $this->CI->db
												->select('id,title,seotitle')
												->where('id',$rescount['id_category'])
												->where('id >','1')
												->where('active','Y')
												->get('t_category')
												->row_array();

											$num_spost = $this->CI->db
												->select('id')
												->where('id_category',$rescount['id_category'])
												->get('t_post')
												->num_rows();
											
											if ( is_null($row_scategory['id']) || $num_spost < 1 )
												continue;
									?>
									<li><a href="<?php echo site_url('category/'.$row_scategory['seotitle']);?>"><?php echo $row_scategory['title'];?></a></li>
									<?php endforeach ?>
								</ul>
							</div>
						</div>

						<div class="col_one_third col_last">
							<div class="widget clearfix">
								<h4>Popular</h4>
								<div id="post-list-footer">
									<?php
										$footer_populars = $this->CI->db
											->select('title,seotitle,datepost')
											->where('active','Y')
											->order_by('hits','DESC')
											->limit(3)
											->get('t_post')
											->result_array();

										foreach ($footer_populars as $row):
									?>
									<div class="spost clearfix">
										<div class="entry-c">
											<div class="entry-title">
												<h4>
													<a href="<?php echo post_url($row['seotitle'])?>" title="<?php echo $row['title'];?>"><?php echo cut($row['title'],50)?>...</a>
												</h4>
											</div>
											<ul class="entry-meta">
												<li><?php echo ci_date($row['datepost'],'l, d F Y');?></li>
											</ul>
										</div>
									</div>
									<?php endforeach ?>
								</div>
							</div>
						</div>
					</div>

					<div class="col_one_third col_last">
						<div class="widget subscribe-widget clearfix">
							<h5><strong>Subscribe</strong> :</h5>
							<div class="widget-subscribe-form-result"></div>
							<form id="widget-subscribe-form" action="#" role="form" method="post" class="nobottommargin">
								<div class="input-group divcenter">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="icon-email2"></i></div>
									</div>
									<input type="email" id="widget-subscribe-form-email" name="widget-subscribe-form-email" class="form-control required email" placeholder="Enter your Email">
									<div class="input-group-append">
										<button class="btn btn-success" type="submit">Subscribe</button>
									</div>
								</div>
							</form>
						</div>

						<div class="widget clearfix" style="margin-bottom: -20px;">
							<div class="row">
								<div class="col-lg-6 clearfix bottommargin-sm">
									<a href="#" class="social-icon si-dark si-colored si-facebook nobottommargin" style="margin-right: 10px;">
										<i class="icon-facebook"></i>
										<i class="icon-facebook"></i>
									</a>
									<a href="#"><small style="display: block; margin-top: 3px;"><strong>Like us</strong><br>on Facebook</small></a>
								</div>
								<div class="col-lg-6 clearfix">
									<a href="#" class="social-icon si-dark si-colored si-rss nobottommargin" style="margin-right: 10px;">
										<i class="icon-rss"></i>
										<i class="icon-rss"></i>
									</a>
									<a href="#"><small style="display: block; margin-top: 3px;"><strong>Subscribe</strong><br>to RSS Feeds</small></a>
								</div>
							</div>
						</div>
					
					</div>
				</div>
			</div>

			<div id="copyrights">
				<div class="container clearfix">
					<div class="col_half pt-1">
						Copyright &copy; <?php echo date('Y')?> <?php echo $this->CI->settings->website('web_name'); ?>. All Right Reserved. Powered by CiFireCMS MIT License.
					</div>

					<div class="col_half col_last tright">
						<div class="fright clearfix">
							<a href="#" class="social-icon si-small si-borderless si-facebook">
								<i class="icon-facebook"></i>
								<i class="icon-facebook"></i>
							</a>
							<a href="#" class="social-icon si-small si-borderless si-twitter">
								<i class="icon-twitter"></i>
								<i class="icon-twitter"></i>
							</a>
							<a href="#" class="social-icon si-small si-borderless si-pinterest">
								<i class="icon-pinterest"></i>
								<i class="icon-pinterest"></i>
							</a>
							<a href="#" class="social-icon si-small si-borderless si-github">
								<i class="icon-github"></i>
								<i class="icon-github"></i>
							</a>
						</div>

						<div class="clear"></div>
					</div>
				</div>
			</div>
		</footer>
	</div>

	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- JavaScripts -->
	<script src="<?php echo $this->CI->theme_asset('js/jquery.js');?>"></script>
	<script src="<?php echo $this->CI->theme_asset('js/plugins.js');?>"></script>
	<script src="<?php echo $this->CI->theme_asset('js/functions.js');?>"></script>
	<script src="<?php echo content_url('plugins/prism/prism.js');?>"></script>
	<script>
		$(document).ready(function(){
			$('.reply_comment').on('click', function(){
				var parent = $(this).attr('data-parent');
				$('.comment_parent').val(parent);
			});
		});
	</script>
</body>
</html>