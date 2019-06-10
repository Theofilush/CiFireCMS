<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->CI->render_view('header');
?>
<div class="cols">
	<div class="colleft">
		<div class="box">
			<div class="post-meta">
				<span class="post-date">
					<i class="fa fa-calendar"></i>
					<span><?=ci_date($result_post['datepost'].$result_post['timepost'], 'l, d M Y, h:i A');?></span>
				</span>
				<span class="post-author">
					<i class="fa fa-user"></i>
					<span><?=$result_post['author_name'];?></span>
				</span>
				<span class="post-category">
					<i class="fa fa-folder-o"></i>
					<span><?=$result_post['category_title'];?></span>
				</span>
				<span class="post-hits">
					<i class="fa fa-eye"></i>
					<span><?=$result_post['hits'];?> kali dilihat</span>
				</span>
			</div>
			<article class="detail">
				<h1><?=$result_post['post_title'];?></h1>
				<?php if ( post_images($result_post['picture']) ):?>
				<div class="detail-thumbnail">
					<img src="<?=post_images($result_post['picture']);?>" alt="<?=$result_post['image_caption'];?>" class="post-image">
					<p class="post-image-caption"><?php echo $result_post['image_caption']; ?></p>
				</div>
				<?php endif ?>
				<div class="detail-content">
					<?=html_entity_decode($result_post['content']);?>
				</div>
			</article>

			<div class="detail-bottom">
				<div class="single-share">
					<div class="single-share-inner">
						<span>Share to:</span>
						<a href="#" class="facebook">
							<i class="fa fa-facebook"></i>
						</a>
						<a href="#" class="twitter">
							<i class="fa fa-twitter"></i>
						</a>
						<a href="#" class="google">
							<i class="fa fa-google-plus"></i>
						</a>
						<a href="#" class="pinterest">
							<i class="fa fa-pinterest"></i>
						</a>
						<a href="#" class="youtube">
							<i class="fa fa-youtube"></i>
						</a>
						<a href="#" class="instagram">
							<i class="fa fa-instagram"></i>
						</a>
						<a href="#" class="linkedin">
							<i class="fa fa-linkedin"></i>
						</a>
						<a href="#" class="soundcloud">
							<i class="fa fa-soundcloud"></i>
						</a>
						<a href="#" class="rss">
							<i class="fa fa-rss"></i>
						</a>
						<a href="#" class="email">
							<i class="fa fa-envelope"></i>
						</a>
					</div>
				</div>
				<!-- tags -->
				<div class="tags">
					<div class="box-detail-caption">
						<span>TAGS</span>
					</div>
					<div>
						<?php
							if (!empty($result_post['tag']))
							{
								$data_tags = explode(',', $result_post['tag']);

								foreach ($data_tags as $tag)
								{
									$tag_seo = seotitle($tag);
									$resultTag = $this->CI->db->where('seotitle',$tag_seo)->get('t_tag')->row_array();
									echo '<a href="'.site_url('tag/'.$tag_seo).'" rel="tag">'.$resultTag['title'].'</a>';
								}
							}
						?>
					</div>
				</div>
			</div>
			
			<!-- Related Post -->
			<div class="related-post">
				<div class="box-detail-caption">
					<span>Related Post</span>
				</div>
				<div class="row">
					<?php
						foreach ($related_post as $res_relatedpost):
							if ($res_relatedpost['id'] == $result_post['post_id']) {
								continue;
							}
					?>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<article class="news-item-big">
							<div class="post-thumb">
								<a href="<?=post_url($res_relatedpost['seotitle']);?>" title="<?=$res_relatedpost['title'];?>">
									<img src="<?=post_images($res_relatedpost['picture'],'medium',TRUE);?>" alt="<?=$res_relatedpost['title'];?>">
								</a>
							</div>
							<h3 class="post-title">
								<a href="<?=post_url($res_relatedpost['seotitle']);?>" title="<?=$res_relatedpost['title'];?>"><?=$res_relatedpost['title'];?></a>
							</h3>
						</article>
					</div>
					<?php endforeach ?>
				</div>
			</div>

			<!-- comments -->
			<div id="comments" class="comments-area">
				<div class="detail-caption">
					<span> <?=$result_post['comment'];?> comments  </span>
				</div>
				<ol class="comment-list">
					<?php
						$data_comments = $this->CI->db
							->where('id_post', $result_post['post_id'])
							->where('active != "N"')
							->where('parent = "0"', NULL, FALSE)
							->get('t_comment');

						foreach ($data_comments->result_array() as $comment):
							$usersa = $this->CI->db
								->select('id,photo')
								->where('id', $comment['id_user'])
								->get('t_user')
								->row_array();
					?>
					<li class="comment">
						<article class="comment-body">
							<footer class="comment-meta">
								<div class="comment-author vcard">
									<img src="<?=user_photo($usersa['photo']);?>" class="avatar">
									<b class="fn"><a href="#"><?=$comment['name'];?></a></b>
								</div>
								<div class="comment-metadata">
									<a href="#">
										<time datetime="2017-04-18T03:21:01+00:00">
										   <?=ci_date($comment['date'],'d M Y, h:i A');?>
										</time>
									</a>
								</div>
							</footer>
							<div class="comment-content">
								<p>
									<?php 
										if ($comment['active'] == 'X')
										{
											echo '<span class="text-danger">Komentar ini telah diblokir</span>';
										} 
										else
										{
											echo auto_link($comment['comment']);
										}
									?>
								</p>
							</div>
							<div class="reply"><a class="comment-reply-link" href="#">Reply</a></div>
						</article>
						<?php
							if ($comment['active'] != 'X'):
								
							$rep_comments = $this->CI->db
								->where('parent', $comment['id'])
								->where('active != "N"')
								->get('t_comment');

							foreach ($rep_comments->result_array() as $res_rep):
								$users_rep = $this->CI->db
									->select('id,photo')
									->where('id', $res_rep['id_user'])
									->where('active', 'Y')
									->get('t_user')
									->row_array();
						?>
						<ol class="children">
							<li class="comment even depth-2 parent">
								<article class="comment-body">
									<footer class="comment-meta">
										<div class="comment-author vcard">
											<img alt="" src="<?=user_photo($users_rep['photo']);?>" class="avatar">
											<b class="fn"><a href="#"><?=$res_rep['name'];?> </a></b>
										</div>
										<div class="comment-metadata">
											<a href="#">
												<time datetime="2017-04-18T03:21:01+00:00">
												   <?=ci_date($res_rep['date'],'d M Y, h:i A');?>
												</time>
											</a>
										</div>
									</footer>
									<div class="comment-content">
										<p>
											<?php 
												if ($res_rep['active'] == 'X') 
												{
													echo '<i class="text-danger">Komentar ini telah diblokir</i>';
												} 
												else
												{
													echo auto_link($res_rep['comment']);
												}
											?>
										</p>
									</div>
									<div class="reply"><a class="comment-reply-link" href="#">Reply</a></div>
								</article>
							</li>
						</ol>
						<?php endforeach ?>

						<?php endif ?>
					</li>
					<?php endforeach ?>
				</ol>
			</div>

			<!--comment form-->
			<div id="form_comment" class="comment-respond">
				<h3 id="reply-title" class="comment-reply-title">
					<span>Leave Your comment</span>
				</h3>
				<?php $this->alert->show('post_comment'); ?>
				<?=form_open('','class="comment-form" autocomplete="on"');?>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="field-item">
								<p class="field-caption">
									Name <span>*</span>
								</p>
								<input id="author" type="text" name="name" tabindex="1">
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="field-item">
								<p class="field-caption">
									Email <span>*</span>
								</p>
								<input id="email" type="email" name="email" tabindex="2">
							</div>
						</div>
					</div>
					<div class="field-item">
						<p class="field-caption">
							Message <span>*</span>
						</p>
						<textarea id="comment" name="comment" aria-required="true" placeholder=""></textarea>
					</div>
					<p class="form-submit">
						<div class="g-recaptcha pull-right" data-sitekey="<?=$this->settings->website('recaptcha_site_key')?>" style="margin-bottom:5px;"></div>
						<script src='https://www.google.com/recaptcha/api.js'></script>
						<button type="submit" class="my-btn my-btn-dark">SUBMIT</button>
					</p>
				<?=form_close(); ?>
			</div>
		</div>
	</div>
	
	<!-- sidebar -->
	<?php $this->CI->render_view('sidebar'); ?>
	<!--/ sidebar -->
	<div class="clearfix"></div>
</div>
<?php $this->CI->render_view('footer'); ?>