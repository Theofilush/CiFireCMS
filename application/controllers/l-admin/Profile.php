<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Admin_controller {
	
	public $mod = 'profile';
	public $dirout = 'mod/profile/';
	public $path_photo = CONTENTPATH.'uploads/user/';

	public function __construct() 
	{
		parent::__construct();
		
		$this->lang->load('mod/'.$this->mod, $this->_language);
		$this->meta_title(lang_line('mod_title'));
		$this->load->model('mod/profile_model');
		$this->data = $this->profile_model->get_data();
	}


	public function index()
	{
		$this->vars['gender'] = ($this->data['user_gender']=='M' ? lang_line('label_male') : lang_line('label_female'));
		$this->render_view('view_index', $this->vars);
	}


	public function edit()
	{
		$this->vars['res'] = $this->profile_model->get_data();
		$this->render_view('view_edit', $this->vars);
	}


	public function submit_update()
	{
		if ( $this->input->is_ajax_request() )
		{
			$id = login_key('admin');

			$rules = array(
				array(
					'field' => 'name',
					'label' => lang_line('label_fullname'),
					'rules' => 'required|trim|min_length[4]|max_length[20]|alpha_numeric_spaces',
				),
				array(
					'field' => 'email',
					'label' => lang_line('label_email'),
					'rules' => 'required|trim|min_length[4]|max_length[80]|valid_email',
				),
				array(
					'field' => 'input_password',
					'label' => lang_line('label_password'),
					'rules' => 'min_length[6]',
				),
				array(
					'field' => 'birthday',
					'label' => lang_line('label_birthday'),
					'rules' => 'required|trim',
				),
				array(
					'field' => 'tlpn',
					'label' => lang_line('label_tlpn'),
					'rules' => 'max_length[20]|regex_match[/^[0-9-+ ]+$/]',
				),
				array(
					'field' => 'address',
					'label' => lang_line('label_address'),
					'rules' => 'trim|max_length[600]',
				),
				array(
					'field' => 'about',
					'label' => lang_line('label_about'),
					'rules' => 'trim|max_length[600]',
				)
			);

			$this->form_validation->set_rules($rules);

			if ( $this->form_validation->run() ) 
			{
				$email = xss_filter($this->input->post('email', TRUE), 'xss');

				$cek_email = $this->db
					->select('email')
					->where("BINARY email='$email'", NULL, FALSE)
					->get('t_user');

				$countMail = $cek_email->num_rows();
				$currentMail = $cek_email->row_array()['email'];
				
				$editMail =  $this->db
					->select('email')
					->where('id',$id)
					->get('t_user')
					->row_array()['email'];

				if ( 
				      $countMail == 1 &&
				      $currentMail == $editMail || 
				      $countMail != 1
				    )
				{
					$in_pass1 = $this->input->post('input_password');
					$in_pass2 = xss_filter($this->input->post('input_password2'));
					$password = empty($in_pass1) ? $in_pass2 : encrypt($in_pass1);
					
					$data = array(
						'password' => $password,
						'email'    => $email,
						'name'     => xss_filter($this->input->post('name'), 'xss'),
						'gender'   => xss_filter($this->input->post('gender'), 'gender'),
						'birthday' => date('Y-m-d',strtotime($this->input->post('birthday'))),
						'about'    => $this->input->post('about'),
						'address'  => $this->input->post('address'),
						'tlpn'     => xss_filter($this->input->post('tlpn'), 'xss')
					);

					if ( empty($_FILES['fupload']['tmp_name']) )
					{
						$this->profile_model->update($data);

						$response['success'] = true;
						$response['alert']['type'] = 'success';
						$response['alert']['content'] = lang_line('form_message_update_success');
						$this->json_output($response);
					}
					else
					{
						$new_photo = $this->profile_model->get_photo();

						$this->load->library('upload', array(
							'upload_path'   => $this->path_photo,
							'allowed_types' => "jpg|png|jpeg",
							'file_name'     => $new_photo,
							'max_size'      => 1024 * 10,
							'overwrite'     => TRUE
						));

						if ($this->upload->do_upload('fupload')) 
						{
							$this->profile_model->update($data);

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
} // End Calss