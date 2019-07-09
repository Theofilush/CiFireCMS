<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->CI->render_view('header');
?>
<div class="cols">
	<div class="colleft">
		<div class="box">
			<div class="box-caption">
				<h2><a href="#"><i class="fa fa-tags"></i> <?=$result_tag['title'];?></a></h2>
			</div>
			<?php foreach ($tag_post as $row): ?>
			<div class="list-item-category">
				<article class="category-item">
					<div class="row row-fix">
						<div class="col-md-6 col-sm-6 col-xs-12 col-fix">
							<article class="news-item-big">
								<div class="post-thumb">
									<a href="<?=post_url($row['post_seotitle']);?>" title="<?=$row['post_title'];?>">
										<img alt="<?=$row['post_title'];?>" src="<?=post_images($row['picture'],'medium',TRUE);?>">
									</a>
								</div>
							</article>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 col-fix">
							<div>
								<h3 class="post-title">
									<a href="<?=post_url($row['post_seotitle']);?>" title="<?=$row['post_title'];?>"><?=$row['post_title'];?></a>
								</h3>
								<div class="post-meta">
									<span class="post-date">
										<i class="fa fa-calendar"></i>
										<span><?=ci_date($row['datepost'].$row['timepost'], 'l, d M Y')?></span>
									</span>
									<span class="post-category">
										<i class="fa fa-folder-o"></i>
										<span><?=$row['category_title'];?></span>
									</span>
								</div>
								<div class="post-des">
									<p><?=cut($row['content'],100);?>...</p>
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
		</div>
	</div>
	<!-- sidebar -->
	<?php $this->CI->render_view('sidebar'); ?>
	<!--/ sidebar -->
	<div class="clearfix"></div>
</div>
<?php $this->CI->render_view('footer'); ?>