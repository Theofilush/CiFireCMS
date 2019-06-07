<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo $this->alert->show($this->mod); ?>
<div class="row">
	<div class="col-md-12">
		<div class="card ">
			<div class="card-header">
				<h5 class="card-title"><?=lang_line('post_title_all_post')?></h5>
				<div class="pull-right">
					<a href="<?=member_url($this->mod.'/'.$this->mod_add)?>" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle mr-2"></i><?=lang_line('button_add_new')?></a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="DataTable" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="no-sort text-center">
									<input type="checkbox" class="select_all" data-toggle="tooltip" data-placement="top" data-title="<?=lang_line('tooltip_select_all');?>">
								</th>
								<th><?=lang_line('post_table_title');?></th>
								<th><?=lang_line('post_table_category');?></th>
								<th>Status</th>
								<th class="th-action text-center"><?=lang_line('post_table_action');?></th>
							</tr>
						</thead>
						<tbody></tbody>
						<tr id="delall">
							<td colspan="5">
								<button type="button" class="btn btn-sm btn-danger delete_multi"><i class="fa fa-trash mr-2"></i> <?=lang_line('button_delete_selected_item');?></button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>