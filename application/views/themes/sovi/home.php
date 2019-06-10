<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->CI->render_view('header');
?>
<div class="cols">
	<div class="colleft">
		<!-- Headlines -->
		<?php if ( !empty($headline) ): ?>
		<div class="box">
			<!--
			<div class="box-caption">
				<h2><a href="#">Headline</a></h2>
			</div>
			-->
			<div class="owl-category-wrap">
				<div class="owl-carousel owl-headlines">
					<?php foreach ($headline as $res_headline): ?>
					<div>
						<article>
							<div class="post-thumb">
								<a href="<?=post_url($res_headline['post_seotitle']);?>" title="<?=$res_headline['post_title'];?>">
									<img alt="<?=$res_headline['post_title'];?>" src="<?=post_images($res_headline['picture'],'',true);?>">
								</a>
							</div>
							<div class="owl-headlines-caption">
								<h3 class="post-title">
									<a href="<?=post_url($res_headline['post_seotitle']);?>" title="<?=$res_headline['post_title'];?>"><?=$res_headline['post_title'];?></a>
								</h3>
								<div class="post-meta">
										<span class="label label-danger">
									<span class="post-date">
											
										<i class="fa fa-calendar-o"></i>
										<span><?=ci_date($res_headline['datepost'].$res_headline['timepost'], 'l, d M Y');?></span>
									</span>
									<span class="post-category">
										<i class="fa fa-folder-o"></i>
										<span><?=$res_headline['category_title'];?></span>
									</span>
										</span>
								</div>
							</div>
						</article>
					</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
		<?php endif ?>
		<!--/ Headlines -->

		<!-- BOX 1 -->
		<div class="box">
			<?php
				$catPost1 = $this->CI->index_model->get_category_by('seotitle', 'travel', 'row');
			?>
			<div class="box-caption">
				<h2>
					<a href="<?=site_url('category/'.$catPost1['seotitle']);?>" title="<?=$catPost1['title'];?>">
					<i class="fa fa-folder"></i>
					<?=$catPost1['title'];?>
					</a>
				</h2>
			</div>
			<div class="row row-fix">
				<div class="col-md-6 col-sm-6 col-xs-12 col-fix">
					<?php
						$post1a = $this->CI->index_model->get_post_lmit_by_category($catPost1['id'], [1]);
						foreach ($post1a as $res_post1a):
					?>
					<article class="news-item-big">
						<div class="post-thumb">
							<a href="<?=post_url($res_post1a['post_seotitle'])?>" title="<?=$res_post1a['post_title'];?>">
								<img alt="<?=$res_post1a['post_title'];?>" src="<?=post_images($res_post1a['picture'], 'medium', TRUE);?>">
							</a>
						</div>
						<h3 class="post-title">
							<a href="<?=post_url($res_post1a['post_seotitle'])?>" title="<?=$res_post1a['post_title'];?>"><?=$res_post1a['post_title'];?></a>
						</h3>
						<div class="post-meta">
							<span class="post-date">
								<i class="fa fa-clock-o"></i>
								<span><?=ci_date($res_post1a['datepost'].$res_post1a['timepost'], 'l, d F Y');?></span>
							</span>
							<span class="post-category">
								<i class="fa fa-folder-o"></i>
								<span><?=$catPost1['title'];?></span>
							</span>
						</div>
						<div class="post-des">
							<p><?=cut($res_post1a['content'], 90);?>...</p>
						</div>
					</article>
					<?php endforeach ?>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12 col-fix">
					<ul class="list-news list-news-right">
						<?php
							$post1b = $this->CI->index_model->get_post_lmit_by_category($catPost1['id'], [4,1]);
							foreach ($post1b as $res_post1b):
						?>
						<li>
							<div class="post-thumb">
								<a href="<?=post_url($res_post1b['post_seotitle']);?>" title="<?=$res_post1b['post_title'];?>">
									<img alt="<?=$res_post1b['post_title'];?>" src="<?=post_images($res_post1b['picture'], 'thumb', TRUE);?>">
								</a>
							</div>
							<h3>
								<a href="<?=post_url($res_post1b['post_seotitle']);?>" title="<?=$res_post1b['post_title'];?>"><?=$res_post1b['post_title'];?></a>
							</h3>
						</li>
						<?php endforeach ?>
					</ul>
				</div>
			</div>
		</div>
		<!--/ BOX 1 -->

		<!-- GROUP BOX -->
		<div class="row row-fix">
			<!-- GROUP BOX 1 -->
			<div class="col-md-6 col-sm-6 col-xs-12 col-fix">
				<?php
					$catPost2 = $this->CI->index_model->get_category_by('seotitle', 'lifestyle', 'row');
				?>
				<div class="box">
					<div class="box-caption">
						<h2>
							<a href="<?=site_url('category/'.$catPost2['seotitle']);?>" title="<?=$catPost2['title'];?>">
							<i class="fa fa-folder"></i>
							<?=$catPost2['title']?>
							</a>
						</h2>
					</div>
					<?php
						$post2a = $this->CI->index_model->get_post_lmit_by_category($catPost2['id'], [1]);
						foreach ($post2a as $res_post2a):
					?>
					<article class="news-item-big">
						<div class="post-thumb">
							<a href="<?=post_url($res_post2a['post_seotitle']);?>" title="<?=$res_post2a['post_title'];?>">
								<img src="<?=post_images($res_post2a['picture'], 'medium', TRUE);?>" alt="<?=$res_post2a['post_title'];?>">
							</a>
						</div>
						<h3 class="post-title">
							<a href="<?=post_url($res_post2a['post_seotitle']);?>" title="<?=$res_post2a['post_title'];?>"><?=$res_post2a['post_title'];?></a>
						</h3>
						<div class="post-meta">
							<span class="post-date">
								<i class="fa fa-clock-o"></i>
								<span><?=ci_date($res_post2a['datepost'].$res_post2a['timepost'], 'l, d F Y');?></span>
							</span>
							<span class="post-category">
								<i class="fa fa-folder-o"></i>
								<span><?=$catPost2['title'];?></span>
							</span>
						</div>
						<div class="post-des">
							<p><?=cut($res_post2a['content'],90);?>...</p>
						</div>
					</article>
					<?php endforeach ?>
					<ul class="list-news">
						<?php
							$post2b = $this->CI->index_model->get_post_lmit_by_category($catPost2['id'], [2,1]);
							foreach ($post2b as $res_post2b):
						?>
						<li>
							<div class="post-thumb">
								<a href="<?=post_url($res_post2b['post_seotitle']);?>" title="<?=$res_post2b['post_title'];?>">
									<img src="<?=post_images($res_post2b['picture'],'thumb',TRUE);?>" alt="<?=$res_post2b['post_title'];?>">
								</a>
							</div>
							<h3>
								<a href="<?=post_url($res_post2b['post_seotitle']);?>" title="<?=$res_post2b['post_title'];?>"><?=$res_post2b['post_title'];?></a>
							</h3>
						</li>
						<?php endforeach ?>
					</ul>
				</div>
			</div>
			<!-- GROUP BOX 1 -->

			<!-- GROUP BOX 2 -->
			<div class="col-md-6 col-sm-6 col-xs-12 col-fix">
				<?php
					$catPost3 = $this->CI->index_model->get_category_by('seotitle', 'health', 'row');
				?>
				<div class="box">
					<div class="box-caption">
						<h2>
							<a href="<?=site_url('category/'.$catPost3['seotitle']);?>" title="<?=$catPost3['title'];?>">
							<i class="fa fa-folder"></i>
							<?=$catPost3['title']?>
							</a>
						</h2>
					</div>
					<?php
						$post3a = $this->CI->index_model->get_post_lmit_by_category($catPost3['id'], [1]);
						foreach ($post3a as $res_post3a):
					?>
					<article class="news-item-big">
						<div class="post-thumb">
							<a href="<?=post_url($res_post3a['post_seotitle']);?>" title="<?=$res_post3a['post_title'];?>">
								<img src="<?=post_images($res_post3a['picture'], 'medium', TRUE);?>" alt="<?=$res_post3a['post_title'];?>">
							</a>
						</div>
						<h3 class="post-title">
							<a href="<?=post_url($res_post3a['post_seotitle']);?>" title="<?=$res_post3a['post_title'];?>"><?=$res_post3a['post_title'];?></a>
						</h3>
						<div class="post-meta">
							<span class="post-date">
								<i class="fa fa-clock-o"></i>
								<span><?=ci_date($res_post3a['datepost'].$res_post3a['timepost'], 'l, d F Y');?></span>
							</span>
							<span class="post-category">
								<i class="fa fa-folder-o"></i>
								<span><?=$catPost3['title'];?></span>
							</span>
						</div>
						<div class="post-des">
							<p><?=cut($res_post3a['content'],90);?>...</p>
						</div>
					</article>
					<?php endforeach ?>
					<ul class="list-news">
						<?php
							$post3b = $this->CI->index_model->get_post_lmit_by_category($catPost3['id'], [2,1]);
							foreach ($post3b as $res_post3b):
						?>
						<li>
							<div class="post-thumb">
								<a href="<?=post_url($res_post3b['post_seotitle']);?>" title="<?=$res_post3b['post_title'];?>">
									<img src="<?=post_images($res_post3b['picture'],'thumb',TRUE);?>" alt="<?=$res_post3b['post_title'];?>">
								</a>
							</div>
							<h3>
								<a href="<?=post_url($res_post3b['post_seotitle']);?>" title="<?=$res_post3b['post_title'];?>"><?=$res_post3b['post_title'];?></a>
							</h3>
						</li>
						<?php endforeach ?>
					</ul>
				</div>
			</div>
			<!-- GROUP BOX 2 -->
		</div>
		<!--/ GROUP BOX  -->

		<!-- BOX 3 -->
		<div class="box">
			<?php
				$catPost4 = $this->CI->index_model->get_category_by('seotitle', 'tekno', 'row');
			?>
			<div class="box-caption">
				<h2>
					<a href="<?=site_url('category/'.$catPost4['seotitle']);?>" title="<?=$catPost4['title'];?>">
					<i class="fa fa-folder"></i>
					<?=$catPost4['title'];?>
					</a>
				</h2>
			</div>
			<div class="row row-fix">
				<?php
					$post4a = $this->CI->index_model->get_post_lmit_by_category($catPost4['id'], [1]);
					foreach ($post4a as $res_post4a):
				?>
				<div class="col-md-6 col-sm-6 col-xs-12 col-fix">
					<article class="news-item-big">
						<div class="post-thumb">
							<a href="<?=post_url($res_post4a['post_seotitle']);?>" title="<?=$res_post4a['post_title'];?>">
								<img src="<?=post_images($res_post4a['picture'],'medium',TRUE);?>" alt="<?=$res_post4a['post_title'];?>">
							</a>
						</div>
					</article>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12 col-fix">
					<div>
						<h3 class="post-title">
							<a href="<?=post_url($res_post4a['post_seotitle']);?>" title="<?=$res_post4a['post_title'];?>"><?=$res_post4a['post_title'];?></a>
						</h3>
						<div class="post-meta">
							<span class="post-date">
								<i class="fa fa-clock-o"></i>
								<span><?=ci_date($res_post4a['datepost'].$res_post4a['timepost'], 'l, d F Y');?></span>
							</span>
							<span class="post-category">
								<i class="fa fa-folder-o"></i>
								<span><?=$catPost4['title'];?></span>
							</span>
						</div>
						<div class="post-des">
							<p><?=cut($res_post4a['content'],90);?>...</p>
						</div>
					</div>
				</div>
				<?php endforeach ?>
			</div>
			<ul class="list-news list-news-two">
				<?php
					$post4b = $this->CI->index_model->get_post_lmit_by_category($catPost4['id'], [2,1]);
					foreach ($post4b as $res_post4b):
				?>
				<li>
					<div class="post-thumb">
						<a href="<?=post_url($res_post4b['post_seotitle']);?>" title="<?=$res_post4b['post_title'];?>">
							<img src="<?=post_images($res_post4b['picture'],'thumb',TRUE);?>" alt="<?=$res_post4b['post_title'];?>">
						</a>
					</div>
					<h3>
						<a href="<?=post_url($res_post4b['post_seotitle']);?>" title="<?=$res_post4b['post_title'];?>"><?=$res_post4b['post_title'];?></a>
					</h3>
				</li>
				<?php endforeach ?>
			</ul>
			<div class="clearfix"></div>
		</div>
		<!--/ BOX 3 -->




		<!-- BOX 4 
		<div class="box">
			<div class="box-caption">
				<h2><a href="category.html" title="">BOX 4</a></h2>
			</div>
			<div class="grid-outer">
				<div class="grid">
					<div class="grid-item">
						<article class="news-item-big">
							<div class="post-thumb">
								<a href="post.php">
									<img alt="" src="images/1.jpg">
								</a>
							</div>
							<h3 class="post-title">
								<a href="post.php">The iPhone X is the Beginning of the End for Phones</a>
							</h3>
							<div class="post-meta">
								<span class="post-date">
									<i class="fa fa-clock-o"></i>
									<span>02/10/2017</span>
								</span>
								<span class="post-category">
									<i class="fa fa-folder-o"></i>
									<span>Category</span>
								</span>
							</div>
							<div class="post-des">
								<p>Donec sollicitudin molestie malesuada. Sed porttitor lectus nibh. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Praesent sapien massa, convallis a pellentesque...</p>
							</div>
						</article>
					</div>
					<div class="grid-item">
						<article class="news-item-big">
							<div class="post-thumb">
								<a href="post.php">
									<img alt="" src="images/1.jpg">
								</a>
							</div>
							<h3 class="post-title">
								<a href="post.php">The iPhone X is the Beginning of the End for Phones</a>
							</h3>
							<div class="post-meta">
								<span class="post-date">
									<i class="fa fa-clock-o"></i>
									<span>02/10/2017</span>
								</span>
								<span class="post-category">
									<i class="fa fa-folder-o"></i>
									<span>Category</span>
								</span>
							</div>
							<div class="post-des">
								<p>Donec sollicitudin molestie malesuada. Sed porttitor lectus nibh. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Praesent sapien massa, convallis a pellentesque...</p>
							</div>
						</article>
					</div>
					
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<!--/ BOX 4 -->
	</div>
	<!-- colleft -->

	<!-- sidebar -->
	<?php $this->CI->render_view('sidebar');?>
	<!--/ sidebar -->
	<div class="clearfix"></div>
</div>
<?php $this->CI->render_view('footer');?>