<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->CI->render_view('header');
?>
<div class="cols">
	<div class="colleft">
		<div class="box">
			<div class="box-caption">
				<h2><a href="#"><i class="fa fa-search"></i> Search Results</a></h2>
			</div>
			<div class="searching-box">
				<?=form_open('search');?>
					<div class="field-item">
						<input name="kata" value="<?=$keywords?>" placeholder="Search...">
					</div>
					<button type="submit" class="my-btn my-btn-dark">Search</button>
				<?=form_close()?>
			</div>

			<div class="search-result">
				<small>
					<?php
						echo '<strong>'.$num_post.'</strong> Search results for keywords "<strong>'.$keywords.'</strong>"';
					?>
				</small>
				<br>
				<ul>
					<?php foreach ($search_post as $row): ?>
					<li>
						<h4><a href="<?=post_url($row['seotitle']);?>"><?=$row['title'];?></a></h4>
						<p><?=cut($row['content'],150);?>...</p>
					</li>
					<?php endforeach ?>
				</ul>
			</div>

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