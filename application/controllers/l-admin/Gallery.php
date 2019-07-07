<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends Admin_controller {
	
	public $mod = 'gallery';

	public function __construct() 
	{
		parent::__construct();
		
		$this->lang->load('mod/'.$this->mod, $this->_language);
		$this->meta_title(lang_line('mod_title'));
		$this->load->model('mod/gallery_model');
	}


	public function index()
	{
		if ( $this->write_access && $this->_act == 'add_album' )
		{
			if ( $this->write_access )
			{
				$this->form_validation->set_rules(array(
					array(
						'field' => 'title',
						'label' => lang_line('form_label_title'),
						'rules' => 'trim|min_length[4]|max_length[150]'
					)
				));
				
				if ( $this->form_validation->run() ) 
				{
					$title = !empty($this->input->post('title')) ? $this->input->post('title') : mdate(date('Y-m-d'), 2);

					$data_insert = array(
						'title'    => $title,
						'seotitle' => seotitle(date('Ymdhis').random_string('numeric', 12)),
						'active'   => 'Y'
					);

					$this->gallery_model->insert('t_album', $data_insert);
				}
				else 
				{
					$this->alert->set($this->mod, 'danger', validation_errors());
				}

				redirect(uri_string());
			}
			else
			{
				$this->render_404();
			}
		}

		elseif ( $this->delete_access && $this->_act == 'delete' )
		{
			if ( $this->delete_access ) 
			{
				$id = $this->input->post('id');
				$this->gallery_model->delete_album($id);
				redirect(uri_string());
			}
			else
			{
				$this->render_404();
			}
		}
		
		elseif ( $this->read_access )
		{
			$this->vars['albums'] = $this->gallery_model->all_album();
			$this->render_view('view_index', $this->vars);
		}

		else
		{
			$this->render_404();
		}
	}


	public function delete($param = '')
	{
		if ( $this->input->is_ajax_request() && $this->delete_access )
		{
			$data_pk = $this->input->post('data');
			foreach ($data_pk as $key)
			{
				$pk = xss_filter(decrypt($key),'sql');
				if ( $param == 'album' )
					$this->gallery_model->delete_album($pk);
				if ( $param == 'image' )
					$this->gallery_model->delete($pk);
			}
			$response['success'] = true;
			$response['dataDelete'] = decrypt($data_pk[0]);
			$response['alert']['type'] = 'success';
			$response['alert']['content'] = lang_line('form_message_delete_success');
			$this->json_output($response);
		}
		else
		{
			show_404();
		}
	}


	public function album($id_album = '')
	{
		if ( $this->write_access && $this->_act == 'add_picture' )
		{
			if ( $this->write_access )
			{
				$this->form_validation->set_rules(array(
					array(
						'field' => 'title',
						'label' => lang_line('form_label_title'),
						'rules' => 'trim|min_length[4]|max_length[150]',
					),
					array(
						'field' => 'picture',
						'label' => lang_line('form_label_picture'),
						'rules' => 'required',
					)
				));

				if ( $this->form_validation->run() ) 
				{
					$title = ( !empty($this->input->post('title')) ? $this->input->post('title') : random_string('numeric', 8).'-'.date('dmY') );
					
					$pictures = json_to_array($this->input->post('picture'));
					
					if ( count($pictures) == 0 )
					{
						$data = array(
							'id_album' => $this->input->post('id_album'),
							'title'    => $title,
							'seotitle' => seotitle($title."-".random_string('numeric', 10)),
							'picture'  => $this->input->post('picture')
						);

						$this->gallery_model->insert('t_gallery', $data);
					}
					else
					{
						$i = 1;
						foreach ($pictures as $val)
						{
							$i ++;
							$datas = array(
								'id_album' => $this->input->post('id_album'),
								'title'    => $title.$i,
								'seotitle' => seotitle($title.$i."-".random_string('numeric', 10)),
								'picture'  => $val
							);
							$this->gallery_model->insert('t_gallery', $datas);
						}
					}
					redirect(uri_string());
				}
				else 
				{
					$this->alert->set($this->mod, 'danger', validation_errors());
					redirect(uri_string());
				}
			}
			else
			{
				$this->render_404();
			}
		}

		if ( $this->delete_access && $this->_act == 'delete' )
		{
			if ( $this->delete_access ) 
			{
				$id_del = $this->input->post('id');
				$this->gallery_model->delete($id_del);
				redirect(uri_string());
			}
			else
			{
				$this->render_404();
			}
		}

		if ( $this->read_access )
		{
			$this->vars['res_album'] = $this->gallery_model->get_album($id_album);
			$this->vars['gallerys'] = $this->gallery_model->get_gallerys($id_album);
			
			$this->render_view('view_album', $this->vars);
		}
	}
} // End Class.