<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	$get_group_id = (!empty($this->input->get('group_id'))) ? $this->input->get('group_id') : 1;
?>
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-inline">
		<div class="page-title">
			<h3>
				<span class="font-weight-semibold"><?php echo lang_line('mod_title');?></span>
			</h3>
		</div>
	</div>
	<div class="breadcrumb-line breadcrumb-line-light">
		<div class="breadcrumb">
			<a href="<?php echo admin_url('home');?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> <?php echo lang_line('admin_link_home');?></a>
			<span class="breadcrumb-item"><?php echo lang_line('mod_title');?></span>
		</div>
	</div>
</div>

<script type="text/javascript">
	var current_group_id = <?php echo $get_group_id;?>;
</script>

<div class="content">	
	<div class="block">
		<div class="block-header">
			<p>Drag the menu list to re-order, and click <code>Save Position</code> to save the position.</p>
		</div>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3 mb-4">
					<div>
						<!-- Nav tabs -->
						<ul class="nav nav-tabs nav-tabs-highlight nav-justifiedx">
						<li class="nav-item">
							<a href="#AddMenu" class="nav-link active" data-toggle="tab">Add Menu</a>
						</li>
						<li class="nav-item">
							<a href="#MenuGroup" class="nav-link" data-toggle="tab">Menu Group</a>
						</li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="AddMenu">
								<br>
								<div class="box">
									<section>
										<form method="post" action="<?php echo admin_url('menumanager/actadd');?>" class="form-bordered" id="form-add-menu" autocomplete="off">
											<input type="hidden" name="gid" value="<?php echo $get_group_id;?>">
											<div class="form-group">
												<label for="menu-title">Ttitle</label>
												<input class="form-control" type="text" name="title" id="menu-title" required>
											</div>
											<div class="form-group">
												<label for="menu-url">Url</label>
												<input class="form-control" type="text" name="url" id="menu-url">
											</div>
											<div class="form-group">
												<label for="menu-class">Class</label>
												<input class="form-control" type="text" name="class" id="menu-class">
											</div>
											<div class="form-group">
												<label for="menu-class">Active</label>
												<select name="active" id="edit-menu-active" class="form-control" >
													<option value="Y">Y</option>
													<option value="N">N</option>
												</select>

											</div>
											<div class="form-group">
												<input type="hidden" name="group_id" value="<?php echo $group_id;?>">
												<button id="add-menu" type="submit" class="button btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
											</div>
										</form>
									</section>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="MenuGroup">
								<br>
								<div class="box">
									<h2>Menu Group</h2>
									<section>
										<?php 
											$g_title = '';
											if ( ! empty($this->input->get('group_id')) ) {
												$g_title = $this->db
													->where('id', $this->input->get('group_id'))
													->get('t_menu_group')
													->row_array();
											} else {
												$g_title = $this->db
													->order_by('id','ASC')
													->get('t_menu_group')
													->row_array();
											}
										?>
										<span id="edit-group-input"><b><?php echo $g_title['title'];?></b> </span>
										<span class="label label-warning"><small>ID: <?php echo $get_group_id;?></small></span>
										<div style="margin-top:5px;">
											<a href="javascript:void(0)" id="edit-group" class="button btn-sm btn-default"><i class="fa fa-edit"></i> Edit</a>
											<button id="submit-edit-group" type="submit" class="button btn-sm btn-default" style="display: none;">Submit</button>
											<?php if ($get_group_id > 2): ?>
											<a href="javascript:void(0)" id="delete-group" class="button btn-sm btn-default"><i class="fa fa-trash"></i> Delete</a>
											<?php endif ?>
										</div>
									</section>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-9 ul-menu">
					<div>
						<ul id="menu-group">
							<li id="add-group"><a href="#" title="Add menu group" data-toggle="tooltip" data-placement="top" data-title="Edit">+</a></li>
							<?php
								$menugroup = $this->db->get('t_menu_group')->result_array();
								foreach ($menugroup as $mgr) {
							?>
							<li id="group-<?php echo $mgr['id'];?>">
								<a href="<?php echo admin_url('menumanager/?group_id='.$mgr['id']);?>"><?php echo $mgr['title'];?></a>
							</li>
							<?php } ?>
						</ul>
					</div>
					<div class="clearfix"></div>
					<?php echo form_open(admin_url($this->mod.'/savemenuposition'), 'id="form-menu" autocomplete="off"');?>
						<div class="ns-row" style="background:#fff;border-radius:0px;font-weight:600;">
							<div class="ns-actions">Action</div>
							<div class="ns-active">Active</div>
							<div class="ns-class">Class</div>
							<div class="ns-url">URL</div>
							<div class="ns-title">Title</div>
						</div>          
						<?php echo $menu_ul;?>
						<div id="ns-footer">
							<hr>
							<button type="submit" id="btn-save-menu" class="button btn-sm btn-primary pull-left"><i class="fa fa-save"></i> Save Position</button>
							<button type="button" class="button btn-sm btn-default pull-right" onClick="window.location.reload()"><i class="fa fa-refresh"></i> Refresh</button>
						</div>
					<?php echo form_close(); ?>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div id="loading">
			<div id="loading-in">
				<img src="<?php echo content_url('images/menu/ajax-loader.gif')?>"/>
			</div>
		</div>
	</div>
</div>