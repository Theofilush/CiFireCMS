<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_controller {

	public $mod = 'user';
	public $dirout = 'mod/user/';
	public $path_photo = CONTENTPATH.'uploads/user/';

	public function __construct() 
	{
		parent::__construct();
		
		$this->lang->load('mod/'.$this->mod, $this->_language);
		$this->meta_title(lang_line('mod_title'));
		$this->load->model('mod/user_model');
	}


	public function index()
	{
		if ( $this->read_access )
		{
			if ( $this->input->is_ajax_request() )
			{
				$data_output = [];
				$users = $this->user_model->get_datatables();

				foreach ($users as $res) 
				{
					if ($res['user_username']==data_login('admin', 'username')) {
						continue;
					}
					$row = [];
					$row[] = '<div class="text-center"><input type="checkbox" class="row_data" value="'. encrypt($res['user_id']) .'"></div>';
					$row[] = '<div class="text-center"><a href="'.user_photo($res['user_photo']).'" class="fancybox"><img src="'.user_photo($res['user_photo']).'" style="background:#fff;padding:2px;width:40px;border-radius:50%;border:1px solid #ddd;"></a></div>';
					$row[] = $res['user_username'];
					$row[] = $res['user_name'];
					$row[] = $res['level_title'];
					// status
					$row[] = ($res['user_active'] == 'Y' ? '<span class="badge badge-b badge-pill badge-primary">Active</span>' : '<span class="badge badge-b badge-pill badge-secondary">No</span>');
					$row[] = '<div class="text-center"><div class="btn-group">
					<a href="'. admin_url($this->mod.'/edit/'.$res['user_username']) .'" class="button btn-xs btn-default" data-toggle="tooltip" data-placement="top" data-title="'. lang_line('button_edit') .'"><i class="icon-pencil3"></i></a>
					<button type="button" class="button btn-xs btn-default delete_single" data-toggle="tooltip" data-placement="top" data-title="'. lang_line('button_delete') .'" data-pk="'. encrypt($res['user_id']) .'"><i class="icon-bin"></i></button>
					</div></div>';
					$data_output[] = $row;
				}

				$json_output = array(
								"draw" => $this->input->post('draw'),
								"recordsTotal" => $this->user_model->count_all(),
								"recordsFiltered" => $this->user_model->count_filtered(),
								"data" => $data_output,
								);

				$this->json_output($json_output);
			}
			else 
			{
				$this->vars['all_users'] = $this->user_model->all_user();
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
		if ( $this->input->is_ajax_request() && $this->delete_access )
		{
			$act = $this->input->post('act');

			if ( $act == 'level' )
			{
				$id_del = xss_filter($this->input->post('id') ,'sql');
				
				if ($id_del > 4 && $id_del != 0) 
				{
					$this->user_model->delete_level($id_del);

					$json_output['alert_type'] = "success";
					$json_output['alert_messages'] = lang_line('level_delete_success');
					$json_output['status'] = TRUE;
					$this->json_output($json_output);
				}
				else
				{
					$json_output['alert_type'] = "danger";
					$json_output['alert_messages'] = "Oups..! ".lang_line('error_unknown');
					$json_output['status'] = TRUE;
					$this->json_output($json_output);
				}
			}

			else // default delete user account
			{
				$data_pk = $this->input->post('data');

				foreach ($data_pk as $key)
				{
					$pk = xss_filter(decrypt($key),'sql');
					$photo = $this->user_model->get_photo($pk);
					$this->user_model->delete_user($pk);
					
					// delete user photo.
					if ( !is_null($photo) )
						@unlink($this->path_photo.$photo);
				}

				$response['success'] = true;
				$response['alert']['type'] = 'success';
				$response['alert']['content'] = lang_line('form_message_delete_success');
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
						'field' => 'level',
						'label' => lang_line('form_label_level'),
						'rules' => 'required|numeric|max_length[1]'
					),
					array(
						'field' => 'username',
						'label' => lang_line('form_label_username'),
						'rules' => 'required|trim|min_length[4]|max_length[20]|regex_match[/^[a-z0-9._]+$/]|callback__cek_addusername',
					),
					array(
						'field' => 'email',
						'label' => lang_line('form_label_email'),
						'rules' => 'required|trim|min_length[10]|max_length[60]|valid_email|callback__cek_addemail',
					),
					array(
						'field' => 'input_password',
						'label' => lang_line('form_label_password'),
						'rules' => 'required|min_length[6]|max_length[20]',
					),
					array(
						'field' => 'name',
						'label' => lang_line('form_label_fullname'),
						'rules' => 'required|trim|min_length[4]|max_length[20]|alpha_numeric_spaces',
					),
					array(
						'field' => 'birthday',
						'label' => lang_line('form_label_birthday'),
						'rules' => 'required',
					),
					array(
						'field' => 'tlpn',
						'label' => lang_line('form_label_tlpn'),
						'rules' => 'required|min_length[4]|max_length[20]',
					),
				));

				if ( $this->form_validation->run() ) 
				{
					$active = ( !empty($this->input->post('active')) ? 'Y' : 'N' );
					$data = array(
						'level'    => xss_filter($this->input->post('level'), 'sql'),
						'username' => xss_filter($this->input->post('username')),
						'email'    => $this->input->post('email', TRUE),
						'password' => encrypt($this->input->post('input_password')),
						'name'     => xss_filter($this->input->post('name'), 'xss'),
						'gender'   => xss_filter($this->input->post('gender'), 'xss'),
						'tlpn'     => xss_filter($this->input->post('tlpn'), 'xss'),
						'address'  => xss_filter($this->input->post('address')),
						'about'    => xss_filter($this->input->post('about'), 'xss'),
						'active'   => $active,
						'photo'    => 'user-'.random_string('numeric', 20) .".jpg",
					);

					$this->user_model->insert_user($data);
					$response['success'] = true;
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
				$this->render_view('view_add_new', $this->vars);
			}
		}
		else
		{
			$this->render_403();
		}
	}


	public function edit($val = '')
	{
		if ( $this->modify_access )
		{
			$uname = xss_filter($val,'xss');
			$cek_uname = $this->user_model->cek_username($uname);

			if ( $cek_uname == TRUE )
			{
				return $this->render_404();
			}
			else
			{
				$id = $this->user_model->get_id($uname);

				$id_level = $this->user_model->get_level_by($id);

				if ( $id == 1 && login_level('admin', TRUE) != 'super-admin' )
				{
					$this->render_404();
				}
				elseif (empty($id) || $this->user_model->cek_id($id) != 1 ) 
				{
					$this->render_404();
				}
				elseif ( $id != login_key('admin') && login_level('admin',TRUE) == 'admin' && $id_level <= 2 )
				{
					$this->render_404();
				}
				else
				{			
					$this->vars['res_user'] = $this->user_model->get_user($id);
					$this->vars['select_levels'] = $this->user_model->select_level();
					$this->render_view('view_edit', $this->vars);
				}
			}
		}
		else
		{
			return $this->render_403();
		}
	}


	public function submit_update_user()
	{
		if ( $this->input->is_ajax_request() && $this->modify_access )
		{
			$pk = decrypt($this->input->post('pk'));
			$id = xss_filter($pk, 'sql');

			$this->form_validation->set_rules(array(array(
				'field' => 'name',
				'label' => lang_line('form_label_fullname'),
				'rules' => 'required|trim|min_length[4]|max_length[20]|alpha_numeric_spaces',
			)));

			$this->form_validation->set_rules(array(array(
				'field' => 'email',
				'label' => lang_line('form_label_email'),
				'rules' => 'required|trim|min_length[4]|max_length[80]|valid_email',
			)));

			$this->form_validation->set_rules(array(array(
				'field' => 'input_password',
				'label' => lang_line('form_label_password'),
				'rules' => 'min_length[6]|max_length[20]',
			)));
			
			$this->form_validation->set_rules(array(array(
				'field' => 'birthday',
				'label' => lang_line('form_label_birthday'),
				'rules' => 'required|trim',
			)));
			
			$this->form_validation->set_rules(array(array(
				'field' => 'birthday',
				'label' => lang_line('form_label_birthday'),
				'rules' => 'required',
			)));

			if ( login_level('admin',TRUE) == 'super-admin' )
			{
				$this->form_validation->set_rules(array(array(
					'field' => 'level',
					'label' => lang_line('form_label_level'),
					'rules' => 'required',
				)));
			}

			elseif ($id == login_key('admin') && login_level('admin',TRUE) == "admin")
			{
				$this->form_validation->set_rules(array(array(
					'field' => 'level',
					'label' => lang_line('form_label_level'),
					'rules' => 'required|numeric|max_length[1]|greater_than[1]',
					'errors' => array(
						'greater_than' => '{field} error'
					)
				)));
			}

			else
			{
				$this->form_validation->set_rules(array(array(
					'field' => 'level',
					'label' => lang_line('form_label_level'),
					'rules' => 'required|numeric|max_length[1]|greater_than[2]',
					'errors' => array(
						'greater_than' => '{field} error'
					)
				)));
			}

			$this->form_validation->set_rules(array(array(
				'field' => 'tlpn',
				'label' => lang_line('form_label_tlpn'),
				'rules' => 'max_length[20]|regex_match[/^[0-9-+ ]+$/]',
			)));

			if ( $this->form_validation->run() ) 
			{
				$email = $this->input->post('email', TRUE);

				$cek_email = $this->db
					->select('email')
					->where("BINARY email='$email'", NULL, FALSE)
					->get('t_user');

				$contMail = $cek_email->num_rows();
				$currentMail = $cek_email->row_array()['email'];
				
				$editMail =  $this->db
					->select('email')
					->where('id',$id)
					->get('t_user')
					->row_array()['email'];

				if ( 
				      $contMail == 1 &&
				      $currentMail == $editMail || 
				      $contMail != 1
				    )
				{
					$in_pass1 = $this->input->post('input_password');
					$in_pass2 = $this->input->post('input_password2');
					$password = empty($in_pass1) ? $in_pass2 : encrypt($in_pass1);
					
					$data = array(
						'level'    => xss_filter($this->input->post('level'), 'sql'),
						'password' => $password,
						'email'    => $email,
						'name'     => xss_filter($this->input->post('name'), 'xss'),
						'gender'   => xss_filter($this->input->post('gender'), 'gender'),
						'birthday' => date('Y-m-d',strtotime($this->input->post('birthday'))),
						'address'  => xss_filter($this->input->post('address')),
						'about'    => xss_filter($this->input->post('about'), 'xss'),
						'tlpn'     => xss_filter($this->input->post('tlpn'), 'xss'),
						'active'   => ( !empty($this->input->post('active')) ? 'Y' : 'N' )
					);

					if ( empty($_FILES['fupload']['tmp_name']) )
					{
						$this->user_model->update($id, $data);

						$response['success'] = true;
						$response['alert']['type'] = 'success';
						$response['alert']['content'] = lang_line('form_message_update_success');
						$this->json_output($response);
					}

					else
					{
						$new_photo = $this->user_model->get_photo($id);

						$this->load->library('upload', array(
							'upload_path'   => $this->path_photo,
							'allowed_types' => "jpg|png|jpeg",
							'file_name'     => $new_photo,
							'max_size'      => 1024 * 10,
							'overwrite'     => TRUE
						));

						if ($this->upload->do_upload('fupload')) 
						{
							$this->user_model->update($id, $data);

							// crop image.
							$this->load->library('simple_image');
							$this->simple_image
							     ->fromFile($this->path_photo.$new_photo)
							     ->thumbnail(200, 200, 'center')
							     ->toFile($this->path_photo.$new_photo);

							$response['success'] = true;
							$response['alert']['type'] = 'success';
							$response['alert']['content'] = lang_line('form_message_update_success');
							$this->json_output($response);
						}

						else
						{
							$response['success'] = false;
							$response['alert']['type'] = 'error';
							$response['alert']['content'] = $this->upload->display_errors();
							$this->json_output($response);
						}
					}
				}

				else
				{
					$response['success'] = false;
					$response['alert']['type'] = 'error';
					$response['alert']['content'] = lang_line('mail_exist');
					$this->json_output($response);
				}
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
			show_404();
		}
	}


	public function upload_photo()
	{
		if ( $this->input->is_ajax_request() && $this->write_access )
		{
			$pk = $this->input->post('pk');
			$photo_pk = $this->user_model->get_photo($pk);
		}
		else
		{
			show_404();
		}
	}


	public function _cek_addusername($username = '') 
	{
		$cek = $this->user_model->cek_username($username);

		if ($cek == FALSE) 
		{
			$this->form_validation->set_message('_cek_addusername', lang_line('form_message_already_exists'));
			return FALSE;
		}

		return $cek;
	}


	public function _cek_addemail($email = '') 
	{
		$cek = $this->user_model->cek_email($email);

		if ($cek == FALSE) 
		{
			$this->form_validation->set_message('_cek_addemail', lang_line('form_message_already_exists'));
			return FALSE;
		}

		return $cek;
	}


	public function _cek_editusername($username = '') 
	{
		$id = $this->uri->segment(4);
		$cek = $this->user_model->cek_username2($id, $username);

		if ($cek == FALSE) 
		{
			$this->form_validation->set_message('_cek_editusername', lang_line('form_message_already_exists'));
		}
		
		return $cek;
	}


	public function _cek_editemail($email = '') 
	{
		$id = $this->uri->segment(4);
		$cek = $this->user_model->cek_email2($id, $email);

		if ($cek == FALSE) 
		{
			$this->form_validation->set_message('_cek_editemail', lang_line('form_message_already_exists'));
		}
		
		return $cek;
	}


	public function level()
	{
		if ( $this->user_role->access(login_level('admin'), 'level', 'read_access') == TRUE )
		{
			if ( $this->input->is_ajax_request() )
			{
				if ( $this->_act == 'ajax_preview_level' )
				{
					$title = $this->input->post('title');
					$id_level = $this->input->post('id_level');
					$this->vars['level_title'] = $title;
					$modules = $this->user_model->get_level_role($id_level);
					
					$tr = '';
					foreach ($modules as $value) {
						$rModule = $value['module'];
						$rRead = ( $value['read_access'] == 'Y' ? '<span><i class="fa fa-check text-success"></i></span>' : '' );
						$rWrite = ( $value['write_access'] == 'Y' ? '<span><i class="fa fa-check text-success"></i></span>' : '' );
						$rModify = ( $value['modify_access'] == 'Y' ? '<span><i class="fa fa-check text-success"></i></span>' : '' );
						$rDelete = ( $value['delete_access'] === 'Y' ? '<span><i class="fa fa-check text-success"></i></span>' : '' );

						$tr .= '<tr>
									<td>'. $rModule .'</td>
									<td class="text-center">'. $rRead .'</td>
									<td class="text-center">'. $rWrite .'</td>
									<td class="text-center">'. $rModify .'</td>
									<td class="text-center">'. $rDelete .'</td>
								</tr>';
					}
					$rTable = '<table class="table table-bordered table-striped">
							<tr>
								<th>Module</th>
								<th>Read Access</th>
								<th>Write Access</th>
								<th>Modify Access</th>
								<th>Delete Access</th>
							</tr>
						'.$tr.'
						
						</table>';
					echo $rTable;
				}
			}

			elseif ($this->_act == 'add_level')
			{
				$this->form_validation->set_rules(array(array(
					'field' => 'title',
					'label' => 'level',
					'rules' => 'required|trim',
				)));

				if ($this->form_validation->run() == TRUE) 
				{
					$ititle = trim($this->input->post('title'));
					$ilevel = seotitle($ititle);

					if (
						$ilevel == "super-admin" || 
						$ilevel == "admin" || 
						$ilevel == "user" || 
						$ilevel == "member"
					)
					{
						$this->alert->set($this->mod, 'danger', 'Ivalid Level');
					}

					else
					{
						$this->user_model->insert_level(array(
							'title' => trim($this->input->post('title')),
							'level' => seotitle($this->input->post('title'))
						));
						
						$this->alert->set($this->mod, 'success', lang_line('level_add_success'));
					}
				}

				else
				{
					$this->alert->set($this->mod, 'danger', validation_errors());
				}

				redirect(uri_string());
			}


			else
			{
				$this->vars['all_level'] = $this->user_model->levels();
				$this->render_view('view_level', $this->vars);
			}
		}

		else
		{
			$this->render_403();
		}
	}

	
	public function data_table_level()
	{
		if (
		     $this->input->is_ajax_request() && 
		     $this->user_role->access(login_level('admin'), 'level', 'read_access') == TRUE
		    )
		{		
			$data = $this->user_model->get_datatables_level();
			$data_output = array();

			foreach ($data as $val) 
			{
				$row = [];
				$row[] = $val['level_id'];
				$row[] = $val['level_title'];
				$row[] = $val['level'];
				$row[] = $val['menu_title'];

				$action = '<div class="text-centerd"><div class="btn-group">';
				$level = $this->user_model->get_level($val['level']);

				if ($val['level_id'] != 1) 
				{
					$action .= '
					<button type="button" class="view_level button btn-xs btn-default" data-toggle="tooltip" data-placement="top" data-title="'. lang_line('button_view') .'" id-level="'. $val['level_id'] .'" title-level="'. $val['level_title'] .'"><i class="fa fa-list-alt"></i></button>
					<a href="'. admin_url($this->mod.'/role/'.$val['level_id']) .'" class="button btn-xs  btn-default" data-toggle="tooltip" data-placement="top" data-title="'. lang_line('button_config') .'"><i class="fa fa-key"></i></a>';
				}
				
				if ($val['level_id'] > 4) 
				{
					$action .='<button type="button" class="delete_single button btn-xs btn-default" data-toggle="tooltip" data-placement="top" data-title="'. lang_line('button_delete') .'" data-pk="'. $val['level_id'] .'" ><i class="fa fa-trash"></i></button>';
				}
				
				$action .= '</div></div>';
				$row[] = $action;
				$data_output[] = $row;
			}

			$output = array(
							"draw" => $this->input->post('draw'),
							"recordsTotal" => $this->user_model->count_all_level(),
							"recordsFiltered" => $this->user_model->count_filtered_level(),
							"data" => $data_output,
							);

			$this->json_output($output);
		}
		
		else
		{
			show_404();
		}
	}

	
	public function delete_level()
	{
		if ( 
		     $this->input->is_ajax_request() && 
		     login_level('admin') == 1 && 
		     $this->user_role->access(login_level('admin'), 'level', 'delete_access') == TRUE
		    )
		{
			$data_pk = $this->input->post('data');

			foreach ($data_pk as $key)
			{
				$pk = xss_filter($key,'sql');
				$this->user_model->delete_level($pk);
			}

			$response['success'] = true;
			$response['alert']['type'] = 'success';
			$response['alert']['content'] = lang_line('level_delete_success');
			$this->json_output($response);
		}

		else
		{
			show_404();
		}
	}


	public function role($param = '')
	{
		$level = xss_filter($param, 'sql');

		if (
		    $level != 1 &&
		    $this->user_role->access(login_level('admin'), 'level', 'read_access') == TRUE 
		    )
		{
			if ( $this->input->is_ajax_request() )
			{
				if ($this->_act == 'edit_module_role')
				{
					$id_module = $this->input->post('id_module');
					$this->vars['res_mod'] = $this->user_model->get_data_module($id_module);
					$this->load->view($this->dirout.'view_edit_module_role', $this->vars);
				}
			}
			
			else
			{
				if ( $this->_act == 'add-module' ) 
				{
					if ( ! empty($this->input->post('module')) )
					{
						$data_role = array(
							'level' => $level,
							'module' => trim($this->input->post('module'),'-'),
							'read_access' => is_null($this->input->post('read')) ? "N" : "Y",
							'write_access' => is_null($this->input->post('write')) ? "N" : "Y",
							'modify_access' => is_null($this->input->post('modify')) ? "N" : "Y",
							'delete_access' => is_null($this->input->post('delete')) ? "N" : "Y"
						);
						$this->user_model->insert_role($data_role);
					}

					else 
					{
						$this->alert->set($this->mod, 'warning', 'No data');
					}

					redirect(uri_string());
				}
				
				elseif ($this->_act == 'update-module-access') 
				{
					$id_module = $this->input->post('id');

					$data_role = array(
						'read_access' => empty($this->input->post('read')) ? "N": "Y",
						'write_access' => empty($this->input->post('write')) ? "N": "Y",
						'modify_access' => empty($this->input->post('modify')) ? "N": "Y",
						'delete_access' => empty($this->input->post('delete')) ? "N": "Y"
					);

					$this->user_model->update_module($id_module, $data_role);
					$this->alert->set($this->mod,'success', lang_line('mod_lang_2').' '.lang_line('form_message_update_success'));

					redirect(uri_string());
				}

				elseif ( $this->_act == 'modul-delete' )
				{
					$id_module = $this->input->post('id');
					$this->user_model->delete_module($id_module);
					
					redirect(uri_string());
				}

				else
				{
					$this->vars['res_level'] = $this->user_model->get_level($level);
					$this->vars['all_module'] = $this->user_model->level_modules($level);
					$this->render_view('view_role', $this->vars);
				}
			}
		}
		
		else
		{
			$this->render_403();
		}
	} 
} // End Class.