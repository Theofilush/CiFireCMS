<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	
	public $vars;
	public $mod = 'login';

	public function __construct()
	{
		parent::__construct();

		$this->CI =& get_instance();

		if ( $this->settings->website('member_registration') == 'Y' )
		{
			$this->_key = login_key('member');
			$this->_language = strtolower($this->set_language());
			$this->lang->load('main', $this->_language);
			$this->lang->load('member', $this->_language);
			$this->load->model('member_login_model','login_model');

			$this->form_validation->set_error_delimiters('<div>*) ', '.</div>');

			$this->vars['input_email'] = encrypt('email');
			$this->vars['input_pwd'] = encrypt('password');
		}
		else
		{
			return show_404();
		}
	}


	public function meta_title($param = '')
	{
		$title = !empty($param) ? lang_line('ci_member').' - '.$param : lang_line('ci_member');
		$this->meta_title = $title;
		return $this;
	}


	public function index()
	{
		$this->meta_title(lang_line('login1'));

		if ( login_status('member') == TRUE )
		{
			redirect(member_url('home'), 'refresh');
		}
		else
		{
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
			{
				return $this->_submit_login();
			}
			else
			{
				$this->load->view('member/log_header', $this->vars);
				$this->load->view('member/log_signin', $this->vars);
				$this->load->view('member/log_footer', $this->vars);
			}
		}
	}


	private function _submit_login($name = NULL, $value = NULL)
	{
		foreach ($this->input->post() as $key => $val)
		{
			$name .= $key.',';
			$value .= $val.',';
		}

		$input_name = explode(',', $name);
		$input_value = explode(',', $value);

		if (
		     decrypt($input_name[0]) == decrypt($this->vars['input_email']) && 
		     decrypt($input_name[1]) == decrypt($this->vars['input_pwd'])
		    )
		{

			$this->form_validation->set_rules(array(
				array(
					'field' => $input_name[0],
					'label' => 'Email',
					'rules' => 'required|trim|min_length[4]|max_length[50]|valid_email',
				),
				array(
					'field' => $input_name[1],
					'label' => 'Password',
					'rules' => 'required|min_length[4]|max_length[18]',
				)
			));

			if ( $this->form_validation->run() ) 
			{
				$data_input = array(
					'email' => $this->input->post($input_name[0]),
					'password' => encrypt($this->input->post($input_name[1]))
				);

				if ( $this->login_model->cek_login($data_input) == TRUE )
				{
					$get_user = $this->login_model->get_user($data_input);

					$this->session->set_userdata('log_member', array(
						'key'    => $get_user['id'],
						'access' => encrypt(random_string(16)),
						'level'  => $get_user['level']
					));

					redirect(member_url('home'), 'refresh');
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
			show_404();
		}
	}

	
	public function register()
	{
		$this->meta_title(lang_line('login2'));

		if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
		{
			$this->form_validation->set_rules(array(
				array(
					'field' => 'name',
					'label' => lang_line("login_name"),
					'rules' => 'required|trim|min_length[4]|max_length[20]|alpha_numeric_spaces'
				),
				array(
					'field' => 'email',
					'label' => lang_line("login_email"),
					'rules' => 'required|trim|min_length[4]|max_length[80]|valid_email|callback__cek_reg_email'
				),
				array(
					'field' => 'password',
					'label' => lang_line("login_pass"),
					'rules' => 'required|trim|min_length[4]|max_length[18]'
				),
				array(
					'field' => 'password2',
					'label' => lang_line("login_pass2"),
					'rules' => 'required|trim|min_length[4]|max_length[18]|matches[password]',
					'errors' => array(
						// 'matches' => '%s '
						'matches' => lang_line('err_match')
					)
				)
			));

			if ( $this->form_validation->run() )
			{
				$photo    = 'user-'.md5(strtotime(date('YmdHis'))).'.jpg';
				$email    = $this->input->post('email',TRUE);
				$username = seotitle($this->input->post('name')).strtotime(date('YmdHis'));
				$password = encrypt($this->input->post('password'));
				$activation_key = md5('reg'.strtotime(date('YmdHis')).random_string('alnum', 16));

				// insert member to database.
				$this->login_model->insert_member(array(
					'name'           => $this->input->post('name',TRUE),
					'username'       => $username,
					'email'          => $email,
					'password'       => $password,
					'photo'          => $photo,
					'level'          => '4',
					'active'         => 'N',
					'activation_key' => $activation_key
				));

				// set flash data reg_success.
				$this->session->set_flashdata('reg_success', 1);
				$enkey = encrypt($activation_key);
				$urlenkey = urlencode($enkey);
				$activationlink = member_url("activation/?key=$urlenkey");

				// Send vctivation key to email.
				$this->load->library('email');
				$this->email->initialize($this->settings->email_config());
				$this->email->set_newline("\r\n");
				$this->email->from(
				                    $this->settings->website('web_email'),
				                    $this->settings->website('web_name')
				                  );
				$this->email->to($email);
				$this->email->subject('Registration Confirmation');
				$this->email->message('Activation link : <a href="'. $activationlink .'" target="_blank">'. $activationlink .'</a> <br> To activate your account, please click the link above.');
				$this->email->send();

				$this->session->set_flashdata('reg_success','1');
				redirect(uri_string());
			}
			else
			{
				$error_content = validation_errors();
				$this->alert->set('register','danger',$error_content);
				redirect(uri_string());
			}
		}
		elseif ( !empty($this->session->flashdata('reg_success')) )
		{
			$this->load->view('member/log_header', $this->vars);
			$this->load->view('member/log_register_success', $this->vars);
			$this->load->view('member/log_footer', $this->vars);
		}
		else
		{
			$this->load->view('member/log_header', $this->vars);
			$this->load->view('member/log_register', $this->vars);
			$this->load->view('member/log_footer', $this->vars);
		}
	}


	public function _cek_reg_email($email='')
	{
		if ( empty($email) )
		{
			$this->form_validation->set_message('_cek_reg_email', '%s '.lang_line('err_required'));
			return FALSE;
		} 
		else
		{
			$input_email = encrypt(xss_filter($email,'xss'));
			$cekmail = $this->login_model->cek_reg_email($input_email);

			if ( $cekmail == FALSE )
			{
				$this->form_validation->set_message('_cek_reg_email', lang_line('err_mailexists'));
				return FALSE;
			} 
			else 
			{
				return TRUE;
			}
		}
	}


	public function activation()
	{
		$key =  decrypt($this->input->get('key', TRUE));

		if ( !empty($key) )
		{
			$query_key = $this->db->where("BINARY activation_key='$key'", NULL, FALSE)->get('t_user');

			if ( $query_key->num_rows() == 1 )
			{
				$data = $query_key->row_array();

				$this->db->where('id', $data['id'])->update('t_user', ['active'=>'Y','activation_key'=>'0']);

				$this->vars['data'] = lang_line('ativation_success').'<br><a href="'. member_url() .' " class="btn btn-success mb-4">'. lang_line('login1') .'</a>';

				$this->load->view('member/log_header', $this->vars);
				$this->load->view('member/log_activation', $this->vars);
				$this->load->view('member/log_footer', $this->vars);
			}
			else
			{
				$this->vars['data'] = lang_line('err_ativation');
				$this->load->view('member/log_header', $this->vars);
				$this->load->view('member/log_activation', $this->vars);
				$this->load->view('member/log_footer', $this->vars);
			}
		} 
		else
		{
			show_404();
		}
	}


	public function forgot()
	{
		$this->meta_title(lang_line('login3'));

		if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
		{
			$this->form_validation->set_rules(array(
				array(
					'field' => 'email',
					'label' => lang_line('login_email'),
					'rules' => 'required|trim|min_length[4]|max_length[80]|valid_email'
				)
			));

			if ( $this->form_validation->run() )
			{
				$email = $this->input->post('email', TRUE);
				$query = $this->db
					->select('email,password')
					->where("BINARY email='$email'", NULL, FALSE)
					->where('level', '4')
					->where('active', 'Y')
					->get('t_user');

				if ( $query->num_rows() == 1 )
				{
					$data = $query->row_array();
					$password = decrypt($data['password']);

					// Send key to email.
					$this->load->library('email');
					$this->email->initialize($this->settings->email_config());
					$this->email->set_newline("\r\n");
					$this->email->from(
					                   $this->settings->website('web_email'),
					                   $this->settings->website('web_name')
					                   );
					$this->email->to($email);
					$this->email->subject('Forgot Password');
					$this->email->message('<p>Your Password is : '. $password .'<p>');
					$this->email->send();

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
			$this->load->view('member/log_header', $this->vars);
			$this->load->view('member/log_forgot', $this->vars);
			$this->load->view('member/log_footer', $this->vars);
		}
	}


	public function cek() 
	{
		if ( $this->input->is_ajax_request() )
		{
			$this->form_validation->set_rules(array(
				array(
					'field' => 'data',
					'label' => 'data',
					'rules' => 'required|trim|min_length[4]|max_length[80]|valid_email'
				)
			));

			if ( $this->form_validation->run() )
			{
				$data = xss_filter($this->input->post('data'), 'xss');
				$logemail = encrypt($data);
				$response['status'] =  $this->login_model->cek_email($logemail);

				if ( $response['status'] == 1 ) 
				{
					$response['html'] =  '<div class="form-group mt-3">
						<label for="password">'. lang_line('login_pass') .'</label>
						<a href="'. member_url('forgot') .'" class="pull-right"><small>'. lang_line('login_forgot') .'</small></a>
						<input type="password" name="'. $this->vars['input_pwd'] .'" id="password" class="form-control" required autofocus>
					</div>
					<div class="form-group mb-0">
						<button type="submit" class="btn btn-primary btn-block mt-3">'. lang_line('login_button_signin') .'</button>
					</div>';
				}
				else 
				{
					$response['html'] = '';
				}
			}
			else
			{
				$response['status'] = '0';
				$response['html'] = '';
			}
			$this->json_output($response);
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
		$this->session->unset_userdata('log_member');
		redirect(member_url());
	}
} // End Class.