<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
		if ( !empty($this->seotitle) && $this->post_model->cek_post($this->seotitle) == TRUE ) 
		{
			$id_post = $this->post_model->id_post($this->seotitle);
			
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' )  // Submit Komentar.
			{
				return $this->_submit_comment($id_post);
			}
			else
			{
				$data_post = $this->post_model->get_post($this->seotitle);
				$this->vars['result_post']  = $data_post;
				$this->vars['related_post'] = $this->post_model->related_post($data_post['tag'], $data_post['post_id'], 3);

				// link prev post & next post.
				$this->vars['prev_post'] = $this->_prev_post($id_post); 
				$this->vars['next_post'] = $this->_next_post($id_post);

				$this->meta_title($data_post['post_title']);
				$this->meta_keywords($this->vars['result_post']['tag'].', '.$this->settings->website('meta_keyword'));
				$this->meta_description(cut($data_post['content'], 150));
				$this->meta_image(post_images($this->vars['result_post']['picture'], 'medium', TRUE));

				$this->render_view('post', $this->vars);

				// set new hits.
				$set_hits = $data_post['hits'] + 1;
				$this->post_model->hits($id_post, $set_hits);
			}
		}
		else
		{
			$this->render_404();
		}
	}


	private function _submit_comment($id_post = 0)
	{
		if ( $this->captcha() == TRUE && googleCaptcha()->success == FALSE )
		{
			$this->alert->set('alert_comment', 'danger', 'Please complete the captcha');
			redirect(uri_string().'#form_comment');
		}

		else
		{
			$this->form_validation->set_rules(array(
				array(
					'field' => 'name',
					'label' => 'Name',
					'rules' => 'required|trim|min_length[4]|max_length[150]|regex_match[/^[a-zA-Z0-9-. ]+$/]'
				),
				array(
				    'field' => 'email',
					'label' => 'Email',
					'rules' => 'required|trim|max_length[60]|valid_email'
				),
				array(
				    'field' => 'comment',
					'label' => 'Comment',
					'rules' => 'required|trim|max_length[500]'
				)
			));

			if ( $this->form_validation->run() ) 
			{
				$id_user = ( login_status('member') == TRUE ? data_login('member', 'id') : '0' );
				$parent  = ( !empty($this->input->post('parent')) ? $this->input->post('parent') : '0' );
				$name    = ( login_status('member') == TRUE ? data_login('member', 'name') : xss_filter($this->input->post('name'), 'xss') );
				$email   = ( login_status('member') == TRUE ? data_login('member', 'email') :  xss_filter($this->input->post('email')) );
				$active  = ( login_status('member') == TRUE ? 'Y': 'N' );

				$data_comment = array(
					'id_user' => xss_filter($id_user, 'sql'),
					'id_post' => xss_filter($id_post, 'sql'),
					'parent'  => xss_filter(decrypt($parent), 'sql'),
					'name'    => $name,
					'email'   => $email,
					'comment' => xss_filter($this->input->post('comment', TRUE)),
					'ip'      => $this->CI->input->ip_address(),
					'active'  => $active
				);

				$this->post_model->insert_comment($data_comment);
				$this->alert->set('alert_comment', 'success', 'Succes');
				redirect(uri_string().'#form_comment');
			}
			else 
			{
				$this->alert->set('alert_comment', 'danger', validation_errors());
				redirect(uri_string().'#form_comment');
			}
		}
	}


	private function _prev_post($id = 0) 
	{
		$data = $this->post_model->prev_post($id);

		if ( $data == FALSE )
		{
			return NULL;
		}

		else
		{
			$result = array(
				'title' => $data['title'], 
				'url'   => post_url($data['seotitle'])
			);

			return $result;
		}
	}


	private function _next_post($id = 0) 
	{
		$data = $this->post_model->next_post($id);
		
		if ( $data == FALSE )
		{
			return NULL;
		}
		else
		{	
			$result = array(
				'title' => $data['title'], 
				'url'   => post_url($data['seotitle'])
			);
			return $result;
		}
	}


	private function _cekpost()
	{
		if ( !empty($this->seotitle) && $this->post_model->cek_post($this->seotitle) == TRUE )
		{
			$this->id_post = $this->post_model->id_post($this->seotitle);
		}
		else
		{
			$this->render_404();
		}
	}
} // End class.