<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->CI->render_view('header');
?>
<div class="cols">
	<div class="colleft">
		<div class="box">
			<div class="box-caption">
				<h2><a href="#"><i class="fa fa-folder"></i> Category</a></h2>
			</div>
			<?php
				if ( count($data_post) > 0 ): 
				foreach ($data_post as $res):
			?>
			<div class="list-item-category">
				<article class="category-item">
					<div class="row row-fix">
						<div class="col-md-5 col-sm-5 col-xs-12 col-fix">
							<article class="news-item-big">
								<div class="post-thumb">
									<a href="<?=post_url($res['post_seotitle']);?>" title="<?=$res['post_title'];?>">
										<img src="<?=post_images($res['picture'],'medium',TRUE);?>" alt="<?=$res['post_title'];?>">
									</a>
								</div>
							</article>
						</div>
						<div class="col-md-7 col-sm-7 col-xs-12 col-fix">
							<div>
								<h3 class="post-title">
									<a href="<?=post_url($res['post_seotitle']);?>" title="<?=$res['post_title'];?>"><?=$res['post_title'];?></a>
								</h3>
								<div class="post-meta">
									<span class="post-date">
										<i class="fa fa-clock-o"></i>
										<span><?=ci_date($res['datepost'], 'l, d F Y');?></span>
									</span>
									<span class="post-category">
										<i class="fa fa-folder-o"></i>
										<span><?=$res['category_title'];?></span>
									</span>
								</div>
								<div class="post-des">
									<p><?=cut($res['content'],100);?>...</p>
								</div>
							</div>
						</div>
					</div>
				</article>
			</div>
			<?php endforeach ?>
			<div class="paging-outer">
				<div class="paging">
					<ul class="pagination"><?=$page_link;?></ul>
				</div>
			</div>
			<?php else: ?>
				<h5 class="text-center">No Result</h5>
			<?php endif ?>
		</div>
	</div>
	<!-- sidebar -->
	<?php $this->CI->render_view('sidebar'); ?>
	<!--/ sidebar -->
	<div class="clearfix"></div>
</div>
<?php $this->CI->render_view('footer'); ?>