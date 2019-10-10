<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	
	public $vars;
	public $mod = 'login';

	public function __construct()
	{
		parent::__construct();
		$this->CI =& get_instance();

		$this->_language = strtolower($this->set_language());
		$this->lang->load('main', $this->_language);
		$this->lang->load('adminlogin_lang', $this->_language);
		$this->load->model('admin_login_model', 'login_model');

		$this->form_validation->set_error_delimiters('<div><small>*) ', '</small></div>');

		$this->vars['input_uname'] = encrypt('username');
		$this->vars['input_pwd']   = encrypt('password');
	}


	public function index()
	{
		$this->meta_title(lang_line('login_title'));

		if ( login_status('admin') == TRUE )
		{
			redirect(admin_url('home'));
		}
		else
		{
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
			{
				return $this->_submit();
			}
			else
			{
				$this->load->view('admin/log_header', $this->vars);
				$this->load->view('admin/log_signin', $this->vars);
				$this->load->view('admin/log_footer', $this->vars);
			}
		}
	}


	public function cek_username() 
	{
		if ( $this->input->is_ajax_request() )
		{
			$this->form_validation->set_rules(array(
				array(
					'field' => 'data',
					'label' => 'data',
					'rules' => 'required|trim|min_length[4]|max_length[20]|regex_match[/^[a-z0-9_.]+$/]'
				)
			));

			if ( $this->form_validation->run() )
			{
				$data = xss_filter($this->input->post('data'), 'xss');
				$username = encrypt($data);
				$cek_username = $this->login_model->cek_login_username($username);
				$response['status'] =  $cek_username;
				$response['html'] =  '<div class="form-group mt-3"><label for="password">'. lang_line('login_pass') .'</label><a href="'. admin_url('forgot') .'" class="pull-right"><small>'. lang_line('login_forgot') .'</small></a> <input type="password" name="'. $this->vars['input_pwd'] .'" id="password" class="form-control" required autofocus></div> </div><div class="form-group mb-0"> <button type="submit" class="button btn-primary btn-block mt-3">'. lang_line('button_signin') .' <i class="icon-circle-right2 ml-2"></i></button> </div>';
			}
			else
			{
				$response = 0;
			}
			$this->json_output($response);
		}
		else
		{
			show_404();
		}
	}


	private function _submit($name = NULL, $value = NULL)
	{
		foreach ($this->input->post() as $key => $val)
		{
			$name .= $key.',';
			$value .= $val.',';
		}

		$input_name = explode(',', $name);
		$input_value = explode(',', $value);

		if (
		    decrypt($input_name[0]) == decrypt($this->vars['input_uname']) && 
		    decrypt($input_name[1]) == decrypt($this->vars['input_pwd'])
		    )
		{
			$this->form_validation->set_rules(array(
				array(
					'field' => $input_name[0],
					'label' => 'Username',
					'rules' => 'required|trim|min_length[4]|max_length[20]|regex_match[/^[a-z0-9_.]+$/]'
				),
				array(
					'field' => $input_name[1],
					'label' => 'Password',
					'rules' => 'required|min_length[6]|max_length[20]'
				)
			));

			if ( $this->form_validation->run() ) 
			{
				$data_input = array(
					'username' => $this->input->post($input_name[0]),
					'password' => encrypt($this->input->post($input_name[1]))
				);

				$cek_data_input = $this->login_model->cek_login($data_input);

				if ( $cek_data_input == TRUE )
				{
					$get_user = $this->login_model->get_user($data_input);

					// set session filemanager_access.
					$filemanager_access = array(
 						'read' => $this->user_role->access($get_user['level'], 'filemanager', 'read_access'), 
 						'write' => $this->user_role->access($get_user['level'], 'filemanager', 'write_access'), 
 						'modify' => $this->user_role->access($get_user['level'], 'filemanager', 'modify_access'),  
 						'delete' => $this->user_role->access($get_user['level'], 'filemanager', 'delete_access')
					);

					// set session.
					$this->session->set_userdata('log_admin', array(
						'key'    => $get_user['id'],
						'access' => encrypt(random_string(16)),
						'level'  => $get_user['level'],
						'filemanager_access' => $filemanager_access
					));

					redirect(admin_url('home'), 'refresh');
				}

				else
				{
					$this->alert->set('login', 'danger', 'Log In error.');
					redirect(uri_string());
				}
			}
			
			else
			{
				$this->alert->set('login', 'danger', validation_errors());
				redirect(uri_string());
			}
		}
		
		else
		{
			show_400();
		}
	}


	public function forgot()
	{
		$this->meta_title(lang_line('login2'));

		if ( login_status('admin') == TRUE )
		{
			redirect(admin_url('home'));
		}
		else
		{		
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
			{
				$this->form_validation->set_rules(array(
					array(
					'field' => 'email',
					'label' => lang_line('login_email'),
					'rules' => 'required|trim|min_length[4]|max_length[80]|valid_email',
					)
				));

				if ( $this->form_validation->run() )
				{
					$user_email = $this->input->post('email', TRUE);
					$query = $this->db
						->select('name,email,password')
						->where("BINARY email='$user_email'", NULL, FALSE)
						->where('level !=', '4')
						->where('active', 'Y')
						->get('t_user');

					if ( $query->num_rows() == 1 )
					{
						$data = $query->row_array();

						$password      = decrypt($data['password']);
						$full_name     = $data['name'];
						$website_name  = $this->settings->website('web_name');
						$website_email = $this->settings->website('web_email');

						// Send activation link to email.
						$this->load->library('email');
						$this->email->initialize($this->settings->email_config());
						$this->email->from($website_email, $website_name);
						$this->email->to($user_email);
						$this->email->subject('Forgot Password Administrator For '.$website_name);
						// $this->email->set_newline("\r\n");

						$this->email->message('<html><body>
								Hi <b>'. $full_name .'</b>,<br /><br />
								If you have never requested message information about forgotten password in <a href="'. site_url() .'" target="_blank" title="'. $website_name .'">'. $website_name .'</a>, please to ignore this email.<br /><br />
								But if you really are asking for messages of this information, please to log in with the password and then change the default password to a more secure password.<br /><br />
								-------------------------------------------------------<br />
								Your password : '.$password.'<br />
								-------------------------------------------------------<br /><br />
								Warm regards,<br />
								<a href="'. site_url() .'" target="_blank" title="'. $website_name .'">'. $website_name .'</a>
							</body></html>');

						$this->email->send();

						// set allert and redirect;
						$this->alert->set('forgot', 'success', lang_line('forgot_send'));
						redirect(uri_string());
					} 
					else
					{
						$this->alert->set('forgot', 'warning', lang_line('err_mailnotexists'));
						redirect(uri_string());
					}
				} 
				else
				{
					$error_content = validation_errors();
					$this->alert->set('forgot', 'danger', $error_content);
					redirect(uri_string());
				}
			} 
			else 
			{
				$this->load->view('admin/log_header', $this->vars);
				$this->load->view('admin/log_forgot', $this->vars);
				$this->load->view('admin/log_footer', $this->vars);
			}
		}
	}


	private function _cek_username($username = '') 
	{
		$cek_username = $this->login_model->cek_username($username);

		if ($cek_username == '0') 
		{
			$this->form_validation->set_message('_cek_username', '{field} error.');
			return FALSE;
		}
		if ($cek_username == '1')
		{
			return TRUE;
		}
	}


	public function logout()
	{
		// $this->session->sess_destroy();
		$this->session->unset_userdata('log_admin');
		$this->session->unset_userdata('filemanager');
		redirect(admin_url());
	}
} // End Class.