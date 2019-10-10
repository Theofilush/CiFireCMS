<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Admin_controller {
	
	public $mod = 'category';

	public function __construct() 
	{
		parent::__construct();
		
		$this->lang->load('mod/'.$this->mod, $this->_language);
		$this->meta_title(lang_line('mod_title'));
		$this->load->model('mod/category_model','mod_model');
	}


	public function index()
	{
		if ( $this->read_access ) 
		{
			if ( $this->input->is_ajax_request() ) 
			{
				$data_output = array();
				$data_categorys = $this->mod_model->get_datatables();

				foreach ($data_categorys as $val) 
				{
					$row = [];
					$row[] = '<div class="text-center"><input type="checkbox" class="row_data" value="'. encrypt($val['id']) .'"></div>';
					$row[] = $val['title'];
					$row[] = '<a href="'. site_url('category/'.$val['seotitle']) .'" target="_blank" class="text-default">'. $val['seotitle'] .'</a>';
					$row[] = $this->mod_model->get_parent_title($val['id_parent']);
					$row[] = ($val['active'] == 'Y' ? '<span class="badge badge-b badge-pill badge-primary">Active</span>' : '<span class="badge badge-b badge-pill badge-secondary">No</span>');
					$row[] = '<div class="text-center"><div class="btn-group">
							<a href="'.admin_url($this->mod.'/edit/'.$val['id']).'" class="button btn-xs btn-default" data-toggle="tooltip" data-placement="top" data-title="'.lang_line('button_edit').'"><i class="icon-pencil3"></i></a>
							<button type="button" class="button btn-xs btn-default delete_single" data-toggle="tooltip" data-placement="top" data-title="'.lang_line('button_delete').'" data-pk="'. encrypt($val['id']) .'"><i class="icon-bin"></i></button>
							</div></div>';
					$data_output[] = $row;
				}

				$output = array(
								"data" => $data_output,
								"draw" => $this->input->post('draw'),
								"recordsTotal" => $this->mod_model->count_all(),
								"recordsFiltered" => $this->mod_model->count_filtered()
								);

				$this->json_output($output);
			}
			else
			{
				$this->render_view('view_index', $this->vars);
			}
		}
		else 
		{
			$this->render_403();
		}
	}


	public function delete()
	{
		if ( $this->input->is_ajax_request() )
		{
			if ( $this->delete_access )
			{
				$data = $this->input->post('data');

				foreach ($data as $key)
				{
					$pk = xss_filter(decrypt($key),'sql');
					$this->mod_model->delete($pk);
				}

				$response['success'] = true;
				$response['alert']['type']    = 'success';
				$response['alert']['content'] = lang_line('form_message_delete_success');
				$this->json_output($response);
			} 
			else
			{
				$response['success'] = false;
				$response['alert']['type']    = 'error';
				$response['alert']['content'] = 'ERROR';
				$this->json_output($response);
			}
		}
		else
		{
			show_404();
		}
	}


	public function add_new()
	{
		if ( $this->write_access )
		{
			if ( $this->input->is_ajax_request() )
			{
				$this->form_validation->set_rules(array(
					array(
						'field' => 'title',
						'label' => lang_line('form_label_title'),
						'rules' => 'required|trim|min_length[2]|max_length[50]|callback__cek_add_seotitle'
					),
					array(
						'field' => 'parent',
						'label' => lang_line('form_label_parent'),
						'rules' => 'trim|required'
					),
					array(
						'field' => 'active',
						'label' => lang_line('form_label_active'),
						'rules' => 'trim'
					)
				));

				if ( $this->form_validation->run() ) 
				{
					$in_parent = $this->input->post('parent');
					$id_parent = ( $in_parent == '0' ? '0' : decrypt($in_parent) );
					$active    = ( $this->input->post('active') == '1' ? 'Y' : 'N' );

					$data_form = array(
						'id_parent'   => $id_parent,
						'title'       => xss_filter($this->input->post('title'), 'xss'),
						'seotitle'    => seotitle($this->input->post('title')),
						'description' => xss_filter($this->input->post('description'), 'xss'),
						'active'      => $active
					);

					$this->mod_model->insert($data_form);
					$this->alert->set($this->mod, 'success', lang_line('form_message_add_success'));
					$response['success'] = true;
					$this->json_output($response);
				}
				else 
				{
					$response['success'] = false;
					$response['alert']['type'] = 'error';
					$response['alert']['content'] = validation_errors();
					$this->json_output($response);
				}
			}
			else
			{	
				$this->render_view('view_add_new', $this->vars);
			} 
		}
		else
		{
			$this->render_403();
		}
	}


	public function edit($id_category = 0)
	{
		$id_category = xss_filter($id_category, 'sql');

		if ( $this->modify_access )
		{
			if ( !empty($id_category) && $this->mod_model->cek_id($id_category) == 1 ) 
			{
				if ( $this->input->is_ajax_request() ) 
				{
					$id_update = encrypt($id_category);
					$this->_submit_update($id_update);
				}
				else
				{
					$this->vars['res_category'] = $this->mod_model->get_category($id_category);
					$this->render_view('view_edit', $this->vars);
				}
			}
			else 
			{
				$this->render_404();
			}
		}
		else
		{
			$this->render_403();
		}
	}


	private function _submit_update($param = null)
	{
		if ( !is_null($param) && $this->modify_access ) 
		{
			$id = xss_filter(decrypt($param),'sql');

			$this->form_validation->set_rules(array(
				array(
					'field' => 'title',
					'label' => lang_line('form_label_title'),
					'rules' => 'required|trim|min_length[2]|max_length[50]|callback__cek_edit_seotitle'
				),
				array(
					'field' => 'parent',
					'label' => lang_line('form_label_parent'),
					'rules' => 'required|trim'
				),
				array(
					'field' => 'active',
					'label' => lang_line('form_label_active'),
					'rules' => 'trim'
				)
			));

			if ( $this->form_validation->run() ) 
			{
				$in_parent = $this->input->post('parent');
				$id_parent = ( $in_parent == '0' ? '0' : decrypt($in_parent) );
				$active    = ($this->input->post('active') == '1' ? 'Y' : 'N');

				$data = array(
					'id_parent'   => $id_parent,
					'title'       => xss_filter($this->input->post('title'), 'xss'),
					'seotitle'    => seotitle($this->input->post('title')),
					'description' => xss_filter($this->input->post('description'), 'xss'),
					'active'      => $active
				);

				$this->mod_model->update($id, $data);

				$response['success'] = true;
				$response['alert']['type'] = 'success';
				$response['alert']['content'] = lang_line('form_message_update_success');
			}
			else 
			{
				$response['success'] = false;
				$response['alert']['type'] = 'error';
				$response['alert']['content'] = validation_errors();
			}

			$this->json_output($response);
		}
		else
		{
			show_404();
		}
	}


	public function _cek_add_seotitle($seotitle = '') 
	{
		$seotitle = seotitle($seotitle);
		$cek      = $this->mod_model->cek_seotitle($seotitle);

		if ( $cek === FALSE ) 
		{
			$this->form_validation->set_message('_cek_add_seotitle', lang_line('form_message_already_exists'));
		}
		
		return $cek;
	}


	public function _cek_edit_seotitle($seotitle = '') 
	{
		$seotitle = seotitle($seotitle);
		$idEdit   = $this->uri->segment(4);
		$cek      = $this->mod_model->cek_seotitle2($idEdit, $seotitle);
		
		if ( $cek === FALSE ) 
		{
			$this->form_validation->set_message('_cek_edit_seotitle', lang_line('form_message_already_exists'));
		} 

		return $cek;
	}
} // End Class.