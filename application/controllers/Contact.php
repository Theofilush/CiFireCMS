<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
			if ( googleCaptcha()->success == TRUE )
			{
				$this->form_validation->set_rules(array(
					array(
						'field' => 'name_contact',
						'label' => 'name',
						'rules' => 'required|trim|min_length[4]|max_length[150]|regex_match[/^[a-zA-Z0-9-. ]+$/]',
					),
					array(
						'field' => 'email_contact',
						'label' => 'email',
						'rules' => 'required|trim|max_length[60]|valid_email'
					),
					array(
						'field' => 'subject_contact',
						'label' => 'subject',
						'rules' => 'required|trim|max_length[300]'
					),
					array(
					    'field' => 'message_contact',
						'label' => 'message',
						'rules' => 'required'
					),
				));

				if ( $this->form_validation->run() ) 
				{
					$data_contact = array(
						'name'    => xss_filter($this->input->post('name_contact')),
						'email'   => xss_filter($this->input->post('email_contact')),
						'subject' => xss_filter($this->input->post('subject_contact')),
						'message' => xss_filter($this->input->post('message_contact')),
						'ip'      => $this->CI->input->ip_address(),
						'box'     => 'in',
						'active'  => 'N'
					);

					$this->contact_model->insert($data_contact);

					$this->load->library('email');
					$this->email->initialize($this->settings->email_config());
					$this->email->set_newline("\r\n");
					$this->email->from(
					                   $this->settings->website('web_email'),
					                   $this->settings->website('web_name')
					                   );
					$this->email->to($data_contact['email']);
					$this->email->subject('No Reply');
					$this->email->message("Thanks to contact our website !");
					$this->email->send();

					$this->alert->set('contact', 'success', 'Succes');
					redirect(uri_string());
				}
				else
				{
					$this->alert->set('contact', 'danger', validation_errors());
					redirect(uri_string());
				}
			}

			else
			{
				$this->alert->set('contact', 'danger', 'Please complete the captcha');
				redirect(site_url(uri_string()));
			}
		}

		else
		{
			$this->render_view('contact', $this->vars);
		}
	}
} // End class.