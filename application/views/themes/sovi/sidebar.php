<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="colright">
	<!-- advertising -->
	<div class="box hidden-xs">
		<div class="box-advertising">
			<a href="#">
				<img alt="ads" src="<?=post_images('ads/ads.jpg');?>" />
			</a>
		</div>
	</div>

	<!-- latest - popular -->
	<div class="box hidden-xs">
		<div class="tab-caption">
			<ul role="tablist">
				<li class="active">
					<a href="#tabPopular" role="tab" data-toggle="tab"><i class="fa fa-heart"></i> Popular</a>
				</li>
				<li>
					<a href="#tabLatest" role="tab" data-toggle="tab"><i class="fa fa-clock-o"></i> Latest</a>
				</li>
			</ul>
		</div>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="tabPopular">
				<ul class="list-news list-news-right">
					<?php
						$sidebar_popular = $this->db
							->select('title,seotitle,picture')
							->where('active','Y')
							->order_by('hits','DESC')
							->limit(4)
							->get('t_post')
							->result_array();
						foreach ($sidebar_popular as $row_spopular):
					?>
					<li>
						<div class="post-thumb">
							<a href="<?=post_url($row_spopular['seotitle']);?>" title="<?=$row_spopular['title'];?>">
								<img src="<?=post_images($row_spopular['picture'], 'thumb', TRUE);?>" alt="populer">
							</a>
						</div>
						<h3 class="lpr">
							<a href="<?=post_url($row_spopular['seotitle']);?>" title="<?=$row_spopular['title'];?>"><?=$row_spopular['title'];?></a>
						</h3>
					</li>
					<?php endforeach ?>
				</ul>
			</div>
			<div role="tabpanel" class="tab-pane" id="tabLatest">
				<ul class="list-news list-news-right">
					<?php
						$sidebar_latest = $this->db
							->select('title,seotitle,picture')
							->where('active','Y')
							->order_by('id','DESC')
							->limit(4)
							->get('t_post')
							->result_array();
						foreach ($sidebar_latest as $row_slatest):
					?>
					<li>
						<div class="post-thumb">
							<a href="<?=post_url($row_slatest['seotitle']);?>" title="<?=$row_slatest['title'];?>">
								<img src="<?=post_images($row_slatest['picture'], 'thumb', TRUE);?>" alt="populer">
							</a>
						</div>
						<h3 class="lpr">
							<a href="<?=post_url($row_slatest['seotitle']);?>" title="<?=$row_slatest['title'];?>"><?=$row_slatest['title'];?></a>
						</h3>
					</li>
					<?php endforeach ?>
				</ul>
			</div>
		</div>
	</div>
	<!--/ latest - popular -->

	<!-- category -->
	<div class="box">
		<div class="box-caption">
			<h2><a href="#">CATEGORY</a></h2>
		</div>
		<div class="box-category">
			<ul>
				<?php
					$sidebar_category = $this->CI->db
						->select('id_category,COUNT(*)')
						->from('t_post')
						->where('active','Y')
						->group_by('id_category')
						->order_by('COUNT(*)','DESC')
						->get()
						->result_array();

					foreach ($sidebar_category as $rescount):
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
							->where('active','Y')
							->get('t_post')
							->num_rows();
						
						if ( is_null($row_scategory['id']) || $num_spost < 1 )
							continue;
				?>
				<li><a href="<?=site_url('category/'.$row_scategory['seotitle']);?>"><?=$row_scategory['title'];?> <span><?=$num_spost;?></span></a></li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
	<!--/ category -->

	<!-- tags -->
	<div class="box">
		<div class="box-caption">
			<h2><a href="#">TAG CLOUD</a></h2>
		</div>
		<div class="box-tag">
			<div class="tagcloud">
				<?php
					$side_tags = $this->CI->db
						->select('
								  t_tag.title, 
								  t_tag.seotitle, 
								  COUNT(t_post.id) AS tag_count
								')
						->from('t_tag')
						->join('t_post', "t_post.tag LIKE CONCAT('%',t_tag.seotitle,'%')", 'LEFT')
						->group_by('t_tag.id')
						->get()
						->result_array();
					foreach ( $side_tags as $row_stag ):
						if ( $row_stag['tag_count'] == 0 )
							continue;
				?>
				<a href="<?=site_url('tag/'.$row_stag['seotitle']);?>"><?=$row_stag['title'];?></a>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<!--/ tags -->
</div>