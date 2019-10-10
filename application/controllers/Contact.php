<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends Web_controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('web/contact_model');
		$this->meta_title('Contact');
	}
	
	
	public function index()
	{
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
		{
			return $this->_submit();
		}
		else
		{
			$this->render_view('contact', $this->vars);
		}
	}


	public function _submit()
	{
		if ( $this->captcha() == TRUE && googleCaptcha()->success == FALSE )
		{
			$this->alert->set('contact', 'danger', 'Please complete the captcha');
			redirect(uri_string());
		}
		else
		{
			$this->form_validation->set_rules(array(
				array(
					'field' => 'name',
					'label' => 'Name',
					'rules' => 'required|trim|min_length[4]|max_length[150]|regex_match[/^[a-zA-Z0-9-. ]+$/]',
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'required|trim|max_length[60]|valid_email'
				),
				array(
					'field' => 'subject',
					'label' => 'Subject',
					'rules' => 'required|trim|max_length[300]'
				),
				array(
				    'field' => 'message',
					'label' => 'Message',
					'rules' => 'required'
				),
			));

			if ( $this->form_validation->run() ) 
			{
				$data_contact = array(
					'name'    => xss_filter($this->input->post('name'), 'xss'),
					'email'   => $this->input->post('email', TRUE),
					'subject' => xss_filter($this->input->post('subject'), 'xss'),
					'message' => xss_filter($this->input->post('message'), 'xss'),
					'ip'      => $this->CI->input->ip_address(),
					'box'     => 'in',
					'active'  => 'N'
				);

				$this->contact_model->insert($data_contact);

				$website_name   = $this->settings->website('web_name');
				$website_email  = $this->settings->website('web_email');

				$this->load->library('email');
				$this->email->initialize($this->settings->email_config());
				$this->email->from($website_email, $website_name);
				$this->email->to($data_contact['email']);
				$this->email->subject('No Reply');
				$this->email->message("Thanks to contact our website.");

				$this->email->send();

				$this->alert->set('contact', 'success', 'Success');
				redirect(uri_string());
			}
			else
			{
				$this->alert->set('contact', 'danger', validation_errors());
				redirect(uri_string());
			}
		}
	}
} // End class.