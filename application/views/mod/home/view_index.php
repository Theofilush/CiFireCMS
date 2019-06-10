<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-inline">
		<div class="page-title">
			<h3>
				<span class="font-weight-semibold"><?=lang_line('mod_welcome');?></span>
			</h3>
		</div>
	</div>
	<div class="breadcrumb-line breadcrumb-line-light">
		<div class="breadcrumb">
			<a href="<?=admin_url('home');?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> <?=lang_line('admin_link_home');?></a>
		</div>
	</div>
</div>

<div class="content">
	<?php if ( $notif_comment[0] > 0 ||  $notif_mail[0] > 0): ?>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body text-left">
					<?php if ( $notif_comment[0] > 0 ): ?>
					<p>
						<i class="fa fa-commenting-o mr-2"></i>
						<a href="<?=admin_url('comment');?>"><?=$notif_comment[1];?></a>
					</p>
					<?php endif ?>
					<?php if ( $notif_mail[0] > 0 ): ?>
					<p class="mb-0">
						<i class="icon-envelop2 mr-2"></i>
						<a href="<?=admin_url('mail');?>"><?=$notif_mail[1];?></a>
					</p>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif ?>

	<div class="row">
		<div class="col-md-5">
			<div class="card">
				<div class="card-header bg-white header-elements-inline">
					<h5 class="card-title"><i class="fa fa-heart text-danger  mr-2"></i> <?=lang_line('mod_box_title_1'); ?></h5>
					<div class="header-elements">
						<div class="list-icons">
	                		<a class="list-icons-item" data-action="collapse"></a>
	                	</div>
                	</div>
				</div>
				<div class="table-responsive table-scrollable">
					<table class="table">
						<tbody>
							<?php
								$popular_posts = $this->db
									->select('title,seotitle,picture,datepost,timepost,hits')
									->where('active', 'Y')
									->order_by('hits','DESC')
									->limit(10)
									->get('t_post')
									->result_array();
								foreach ($popular_posts as $res) {
							?>
							<tr>
								<td>
									<a href="<?=post_url($res['seotitle']);?>" target="_blank" title="<?=$res['title'];?>">
										<img src="<?=post_images($res['picture'],'thumb',TRUE);?>" alt="<?=$res['title'];?>" class="" width="70"/>
									</a>
								</td>
								<td>
									<div class="text-muted mb-1">
										<small><i class="fa fa-calendar"></i> <?=ci_date($res['datepost'].$res['timepost'], 'd M Y, h:i A');?> &nbsp; <i class="fa fa-eye"></i> <?=$res['hits'];?></small>
									</div>
									<a href="<?=post_url($res['seotitle']);?>" target="_blank" title="<?=$res['title'];?>"><small class="text-strong"><?=$res['title'];?></small></a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>


		<div class="col-md-7">
			<div class="card">
				<div class="card-header bg-white header-elements-inline">
					<h5 class="card-title"><i class="icon-chart text-primary mr-2"></i> <?=lang_line('mod_box_title_3'); ?></h5>
					<div class="header-elements">
						<a href="<?=admin_url('home/visitors'); ?>" class="button btn-xs btn-default" title="Detail"><i class="fa fa-line-chart"></i></a>
                	</div>
				</div>
				<div class="card-body">
					<div class="stats-desc">
						<div class="text-center">
							<i class="fa fa-stop" style="color:#97BBCD;"></i> visitors
							<i class="fa fa-stop" style="color:#DCDCDC; margin-left:15px;"></i> hits
						</div>
						<canvas id="canvas-stats"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	<?php
		$rrhari = implode($arrhari, ",");
		$rrvisitors = implode(array_reverse($rvisitors), ",");
		$rrhits = implode(array_reverse($rhits), ",");
	?>
	var datastats = {
		labels: [<?=implode($arrhari, ",");?>],
		datasets: [
			{
				label: "Visitor",
				fillColor: "rgba(151,187,205,0.2)",
				strokeColor: "rgba(151,187,205,1)",
				pointColor: "rgba(151,187,205,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,187,205,1)",

				
				data: [
					<?=implode(array_reverse($rvisitors), ",");?>
				]
			},
			{
				label: "Hits",
				fillColor: "rgba(220,220,220,0.2)",
				strokeColor: "rgba(220,220,220,1)",
				pointColor: "rgba(220,220,220,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(220,220,220,1)",
				data: [
					<?=implode(array_reverse($rhits), ",");?>
				]
			}
		]
	};
</script>