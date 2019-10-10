<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-inline">
		<div class="page-title">
			<h3>
				<span class="font-weight-semibold"><?=lang_line('mod_visitors');?></span>
			</h3>
		</div>
	</div>
	<div class="breadcrumb-line breadcrumb-line-light">
		<div class="breadcrumb">
			<a href="<?=admin_url('home');?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> <?=lang_line('admin_link_home');?></a>
			<span class="breadcrumb-item"><?=lang_line('mod_visitors');?></span>
		</div>
	</div>
</div>

<div class="content">
	<div class="block">
		<div class="row">
			<div class="col-md-12 text-center">
				<form class="form-inline" method="get" action="" autocomplete="off">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text"><?=lang_line('mod_from');?></span>
						</div>
						<div class="input-group-prepend">
							<input type="text" name="from" class="form-control input-flat" id="from_stat" value="<?=(empty($this->CI->input->get('from')) ? "" : $this->CI->input->get('from'));?>" placeholder="" required />
						</div>
						<div class="input-group-prepend input-group-append">
							<span class="input-group-text"><?=lang_line('mod_to');?></span>
						</div>
						<div class="input-group-prepend">
							<input type="text" name="to" class="form-control input-flat" id="to_stat" value="<?= (empty($this->CI->input->get('to')) ? "" : $this->CI->input->get('to'));?>" placeholder="" required />
						</div>
						<div class="input-group-append">
							<button type="submit" class="btn btn-primary"><?=lang_line('button_submit');?></button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 card">
				<div class="text-center" style="margin-top:20px;">
					<small><i class="fa fa-stop" style="color:#97BBCD;"></i> Visitors</small>
					<small><i class="fa fa-stop" style="color:#DCDCDC;margin-left:30px;"></i> Hits</small>
				</div>
				<div class="stats-desc">
					<canvas id="canvas-stats"></canvas>
				</div>
				<?php if ($this->CI->input->get('from') && $this->CI->input->get('to')) : ?>
				<?php
					$label_stats = array();
					$visitor_stats = array();
					$hits_stats = array();
					$start_stats = $current_stats = strtotime($this->CI->input->get('from'));
					$end_stats = strtotime($this->CI->input->get('to'));

					while ($current_stats <= $end_stats) 
					{
						$label_stats[] = date('d M', $current_stats);

						$visitor_stats[] = $this->db
							->select('ip, COUNT(ip) AS num_ip')
							->where('date', date('Y-m-d', $current_stats))
							->group_by('ip')
							->get('t_visitor')
							->num_rows();

						$hits_stats[] = $this->db
							->select('SUM(hits) as hitstoday')
							->where('date', date('Y-m-d', $current_stats))
							->get('t_visitor')
							->row_array()['hitstoday'];

						$current_stats = strtotime('+1 days', $current_stats);
					}
				?>
				<script type="text/javascript">
					var datastats = {
						labels: <?=$this->CI->_js_array($label_stats);?>,
						datasets: [
							{
								label: "visitors",
								fillColor: "rgba(151,187,205,0.1)",
								strokeColor: "rgba(151,187,205,1)",
								pointColor: "rgba(151,187,205,1)",
								pointStrokeColor: "#fff",
								pointHighlightFill: "#fff",
								pointHighlightStroke: "rgba(151,187,205,1)",
								data: <?=$this->CI->_js_array($visitor_stats);?>
							},
							{
								label: "hits",
								fillColor: "rgba(220,220,220,0.2)",
								strokeColor: "rgba(220,220,220,1)",
								pointColor: "rgba(220,220,220,1)",
								pointStrokeColor: "#fff",
								pointHighlightFill: "#fff",
								pointHighlightStroke: "rgba(220,220,220,1)",
								data: <?=$this->CI->_js_array($hits_stats);?>
							}
						]
					};
				</script>
				<?php else: ?>
				<?php
					$visitor1 = $this->db
						->where('date', date('Y-m-d', strtotime('-6 days')))
						->group_by('ip')
						->get('t_visitor')
						->result_array();

					$visitor2 = $this->db
						->where('date', date('Y-m-d', strtotime('-5 days')))
						->group_by('ip')
						->get('t_visitor')
						->result_array();

					$visitor3 = $this->db
						->where('date', date('Y-m-d', strtotime('-4 days')))
						->group_by('ip')
						->get('t_visitor')
						->result_array();

					$visitor4 = $this->db
						->where('date', date('Y-m-d', strtotime('-3 days')))
						->group_by('ip')
						->get('t_visitor')
						->result_array();

					$visitor5 = $this->db
						->where('date', date('Y-m-d', strtotime('-2 days')))
						->group_by('ip')
						->get('t_visitor')
						->result_array();

					$visitor6 = $this->db
						->where('date', date('Y-m-d', strtotime('-1 days')))
						->group_by('ip')
						->get('t_visitor')
						->result_array();

					$visitor7 = $this->db
						->where('date', date('Y-m-d'))
						->group_by('ip')
						->get('t_visitor')
						->result_array();

					$hits1 = $this->db
						->select('SUM(hits) as hitstoday')
						->where('date', date('Y-m-d', strtotime('-6 days')))
						->group_by('date')
						->get('t_visitor')
						->result_array();

					$hits2 = $this->db
						->select('SUM(hits) as hitstoday')
						->where('date', date('Y-m-d', strtotime('-5 days')))
						->group_by('date')
						->get('t_visitor')
						->result_array();

					$hits3 = $this->db
						->select('SUM(hits) as hitstoday')
						->where('date', date('Y-m-d', strtotime('-4 days')))
						->group_by('date')
						->get('t_visitor')
						->result_array();

					$hits4 = $this->db
						->select('SUM(hits) as hitstoday')
						->where('date', date('Y-m-d', strtotime('-3 days')))
						->group_by('date')
						->get('t_visitor')
						->result_array();

					$hits5 = $this->db
						->select('SUM(hits) as hitstoday')
						->where('date', date('Y-m-d', strtotime('-2 days')))
						->group_by('date')
						->get('t_visitor')
						->result_array();

					$hits6 = $this->db
						->select('SUM(hits) as hitstoday')
						->where('date', date('Y-m-d', strtotime('-1 days')))
						->group_by('date')
						->get('t_visitor')
						->result_array();

					$hits7 = $this->db
						->select('SUM(hits) as hitstoday')
						->where('date', date('Y-m-d'))
						->group_by('date')
						->get('t_visitor')
						->result_array();
				?>
				<script type="text/javascript">
					var datastats = {
						labels: [
							"<?=date('d M', strtotime('-6 days'));?>", 
							"<?=date('d M', strtotime('-5 days'));?>", 
							"<?=date('d M', strtotime('-4 days'));?>", 
							"<?=date('d M', strtotime('-3 days'));?>", 
							"<?=date('d M', strtotime('-2 days'));?>", 
							"<?=date('d M', strtotime('-1 days'));?>", 
							"<?=date('d M', strtotime('0 days'));?>"
						],
						datasets: [
							{
								label: "visitors",
								fillColor: "rgba(151,187,205,0.1)",
								strokeColor: "rgba(151,187,205,1)",
								pointColor: "rgba(151,187,205,1)",
								pointStrokeColor: "#fff",
								pointHighlightFill: "#fff",
								pointHighlightStroke: "rgba(151,187,205,1)",
								data: [
									<?=(empty($visitor1) ? '0' : count($visitor1));?>,
									<?=(empty($visitor2) ? '0' : count($visitor2));?>,
									<?=(empty($visitor3) ? '0' : count($visitor3));?>,
									<?=(empty($visitor4) ? '0' : count($visitor4));?>,
									<?=(empty($visitor5) ? '0' : count($visitor5));?>,
									<?=(empty($visitor6) ? '0' : count($visitor6));?>,
									<?=(empty($visitor7) ? '0' : count($visitor7));?>
								]
							},
							{
								label: "hits",
								fillColor: "rgba(220,220,220,0.2)",
								strokeColor: "rgba(220,220,220,1)",
								pointColor: "rgba(220,220,220,1)",
								pointStrokeColor: "#fff",
								pointHighlightFill: "#fff",
								pointHighlightStroke: "rgba(220,220,220,1)",
								data: [
									<?=(empty($hits1[0]['hitstoday']) ? '0' : $hits1[0]['hitstoday']);?>,
									<?=(empty($hits2[0]['hitstoday']) ? '0' : $hits2[0]['hitstoday']);?>,
									<?=(empty($hits3[0]['hitstoday']) ? '0' : $hits3[0]['hitstoday']);?>,
									<?=(empty($hits4[0]['hitstoday']) ? '0' : $hits4[0]['hitstoday']);?>,
									<?=(empty($hits5[0]['hitstoday']) ? '0' : $hits5[0]['hitstoday']);?>,
									<?=(empty($hits6[0]['hitstoday']) ? '0' : $hits6[0]['hitstoday']);?>,
									<?=(empty($hits7[0]['hitstoday']) ? '0' : $hits7[0]['hitstoday']);?>
								]
							}
						]
					};
				</script>
				<?php endif ?>
			</div>
		</div>

		<div class="row mt-5">
			<div class="col-md-6">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th colspan="2" class="text-center"><small class="text-uppercase text-strong">Top Browser</small></th>
						</tr>
						<tr>
							<th class="text-center">Browser</th>
							<th width="100" class="text-center">Hits</th>
						</tr>
					</thead>
					<?php
						if (isset($_GET['form']) && isset($_GET['to'])) 
						{
							$browsers = $this->CI->db
								->select('*, SUM(hits) as hitstoday')
								->where('date BETWEEN "'.$_GET['form'].'" AND "'.$_GET['to'].'"')
								->order_by('hitstoday DESC')
								->group_by('browser')
								->get('t_visitor')
								->result_array();
						} 
						else 
						{
							$browsers = $this->CI->db
								->select('*, SUM(hits) as hitstoday')
								->where('date', date('Y-m-d'))
								->order_by('hitstoday DESC')
								->group_by('browser')
								->get('t_visitor')
								->result_array();
						}
					?>
					<?php foreach ($browsers as $browser): ?>
					<tr>
						<td class="text-center"><?=($browser['browser'] == '' ? '-' : $browser['browser']);?></td>
						<td class="text-center"><span class="label label-success"><?=$browser['hitstoday'];?></span></td>
					</tr>
					<?php endforeach ?>
				</table>
			</div>
			<div class="col-md-6">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th colspan="2" class="text-center"><small class="text-uppercase text-strong">Platform</small></th>
						</tr>
						<tr>
							<th class="text-center">Platform</th>
							<th width="100" class="text-center">Hits</th>
						</tr>
					</thead>
					<?php
						$noplatform = 1;

						if (isset($_GET['from']) && isset($_GET['to'])) {
							$platforms = $this->CI->db
								->select('*, SUM(hits) as hitstoday')
								->where('date BETWEEN "'.$_GET['from'].'" AND "'.$_GET['to'].'"')
								->order_by('hitstoday DESC')
								->group_by('platform')
								->get('t_visitor')
								->result_array();
						}
						else {
							$platforms = $this->CI->db
								->select('*, SUM(hits) as hitstoday')
								->where('date', date('Y-m-d'))
								->order_by('hitstoday DESC')
								->group_by('platform')
								->get('t_visitor')
								->result_array();
						}
					?>
					<?php foreach($platforms as $platform): ?>
					<tr>
						<td class="text-center"><?=($platform['platform'] == '' ? $GLOBALS['_']['home_others'] : $platform['platform']);?></td>
						<td class="text-center"><span class="label label-danger"><?=$platform['hitstoday'];?></span></td>
					</tr>
					<?php endforeach ?>
				</table>
			</div>
			<div class="col-md-12 mt-5">
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th colspan="7" class="text-center"><small class="text-uppercase text-strong">Top Visitor</small></th>
							</tr>
							<tr>
								<th class="text-center">IP</th>
								<th class="text-center">Browser</th>
								<th class="text-center">Platform</th>
								<th class="text-center">Country</th>
								<th class="text-center">City</th>
								<th class="text-center">Hits</th>
							</tr>
						</thead>
						<?php
							$novisitor = 1;

							if (!empty($_GET['form']) && !empty($_GET['to'])) {
								$visitors = $this->CI->db
									->select('*, SUM(hits) as hitstoday')
									->where('date BETWEEN "'.$_GET['form'].'" AND "'.$_GET['to'].'"')
									->order_by('hits DESC')
									->group_by('ip')
									->limit(10)
									->get('t_visitor')
									->result_array();
							} 
							else {
								$visitors = $this->CI->db
									->select('*, SUM(hits) as hitstoday')
									->where('date', date('Y-m-d'))
									->group_by('ip')
									->limit(10)
									->get('t_visitor')
									->result_array();
							}
						?>
						<?php foreach ($visitors as $visitor): ?>
						<tr>
							<td class="text-center"><?=($visitor['ip'] == '' ? '-' : $visitor['ip']);?></td>
							<td class="text-center"><?=($visitor['browser'] == '' ? "-" : $visitor['browser']);?></td>
							<td class="text-center"><?=($visitor['platform'] == '' ? "-" : $visitor['platform']);?></td>
							<td class="text-center"><?=($visitor['country'] == '' ? "-" : $visitor['country']);?></td>
							<td class="text-center"><?=($visitor['city'] == '' ? "-" : $visitor['city']);?></td>
							<td class="text-center"><span class="label label-info"><?=$visitor['hitstoday'];?></span></td>
						</tr>
						<?php endforeach ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<p>&nbsp;</p>