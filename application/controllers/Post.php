<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends Web_controller {

	public $mod = 'post';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('web/post_model');
		$this->us = xss_filter($this->uri->segment(count($this->uri->segments)), 'xss');
		$this->seotitle = seotitle($this->us);
	}
	

	public function index()
	{
		if (!empty($this->seotitle) && $this->post_model->cek_post($this->seotitle) == TRUE) 
		{
			$id_post = $this->post_model->id_post($this->seotitle);
			
			// SUBMIT Komentar.
			if ($_SERVER['REQUEST_METHOD'] == 'POST') 
			{
				return $this->_submit_comment($id_post);
			}
			
			else
			{
				$data_post = $this->post_model->get_post($this->seotitle);
				$this->vars['result_post']  = $data_post;

				$this->vars['related_post'] = $this->post_model->related_post($data_post['tag'], $data_post['post_id'], 3);

				// link prev post & next post
				$this->vars['prev_post'] = $this->_prev_post($id_post); 
				$this->vars['next_post'] = $this->_next_post($id_post); 

				$this->set_meta(array(
					'title' => $data_post['post_title'],
					'keywords' => $this->vars['result_post']['tag'].', '.$this->settings->website('meta_keyword'),
					'description' => cut($data_post['content'], 150),
					'image' => post_images($this->vars['result_post']['picture'],'medium',TRUE),

				));

				$this->render_view('post', $this->vars);
				$set_hits = $data_post['hits'] + 1;
				$this->post_model->hits($id_post, $set_hits);
			}
		}
		else
		{

			$this->render_view('404', $this->vars);
		}
	}


	private function _submit_comment($id_post = 0)
	{
		if (googleCaptcha()->success == TRUE)
		{
			$form_rules = array(
				array(
					'field' => 'name',
					'label' => 'Nama',
					'rules' => 'required|trim|min_length[4]|max_length[150]|regex_match[/^[a-zA-Z0-9-. ]+$/]'
				),
				array(
				    'field' => 'email',
					'label' => 'Email',
					'rules' => 'required|trim|max_length[60]|valid_email'
				),
				array(
				    'field' => 'comment',
					'label' => 'Komentar',
					'rules' => 'required|trim|max_length[500]'
				),
			);

			$this->form_validation->set_rules($form_rules);

			if ($this->form_validation->run() == TRUE) 
			{
				$id_user = empty($this->input->post('id_user')) ? '0': $this->input->post('id_user');
				$active  = empty($this->input->post('id_user')) ? 'N': 'Y';
				$parent  = empty($this->input->post('parent')) ? '0': $this->input->post('parent');
				
				$data_comment = array(
					'id_user' => xss_filter($id_user, 'sql'),
					'id_post' => xss_filter($id_post, 'sql'),
					'parent'  => xss_filter($parent, 'sql'),
					'name'    => xss_filter($this->input->post('name'), 'xss'),
					'email'   => xss_filter($this->input->post('email')),
					'comment' => xss_filter($this->input->post('comment')),
					'ip'      => $this->CI->input->ip_address(),
					'active'  => $active
				);
				$this->post_model->insert_comment($data_comment);

				$this->alert->set('post_comment', 'success', 'Succes');
				redirect(uri_string().'#form_comment');
			}
			
			else 
			{
				$this->alert->set('post_comment', 'danger', validation_errors());
				redirect(uri_string().'#form_comment');
			}
		}
		else
		{
			$this->alert->set('post_comment', 'danger', 'Please complete the captcha');
			redirect(uri_string().'#form_comment');
		}
		
	}


	private function _prev_post($id = 0) 
	{
		$data = $this->post_model->prev_post($id);

		if ($data == FALSE) 
		{
			return NULL;
		}
		else
		{
			$result = array(
			                'title' => $data['title'], 
			                'url' =>  post_url($data['seotitle'])
			                );

			return $result;
		}
	}


	private function _next_post($id = 0) 
	{
		$data = $this->post_model->next_post($id);
		
		if ($data == FALSE)
		{
			return NULL;
		}
		else
		{	
			$result = array(
			                'title' => $data['title'], 
			                'url' =>  post_url($data['seotitle'])
			                );
			return $result;
		}
	}
	
	private function _cekpost()
	{
		if (!empty($this->seotitle) && $this->post_model->cek_post($this->seotitle) == TRUE)
		{
			$this->id_post = $this->post_model->id_post($this->seotitle);
		}
		else
		{
			return $this->render_404();
		}
	}
} // end class