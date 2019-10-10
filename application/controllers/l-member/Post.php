<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends Member_controller {

	public $mod = 'post';
	public $mod_add  = 'add-new';
	public $mod_edit = 'edit';

	public function __construct()
	{
		parent::__construct();
		
		$this->meta_title(lang_line('post_title'));
		$this->load->model('member/post_model');
	}


	/**
	 * Fungsi untuk menampilkan halaman index post.
	 * @access 	public
	 * @return 	void | string | json
	*/
	public function index() 
	{
		if ( $this->input->is_ajax_request() )
		{
			$data_output = array();
			foreach ( $this->post_model->get_datatables() as $res )
			{
				$row = [];
				$row[] = '<div class="text-center"><input type="checkbox" class="row_data" value="'. encrypt($res['post_id']) .'"></div>';

				$headline = ( $res['post_headline'] == 'Y' ? '<span class="h-'. $res['post_id'] .'"><i class="fa fa-star text-warning"></i> Headline</span>' : '<span class="h-'. $res['post_id'] .'"></span>');
				
				// Title
				$row[] = '<div><a href="'. post_url($res['post_seotitle']) .'" target="_blank">'. $res['post_title'] .'</a></div> <div class="badge badge-pill mt-2 pl-2 pr-2" style="background-color:#f1f1f1;font-size:12px;color:#777;"> <span class="mr-2"><i class="fa fa-calendar mr-2"></i>'. ci_date($res['post_datepost'] . $res['post_timepost'],'l, d F Y, h:i A') .'</span> <span class="mr-2"><i class="fa fa-eye mr-2"></i>'. $res['post_hits'] .'</span> <span class="mr-2"><i class="fa fa-comments mr-2"></i>'. $res['comments'] .'</span> '. $headline .'</div> ';

				// category
				$row[] = $res['category_title'];

				// status
				$row[] = ($res['post_active'] == 'Y' ? '<span class="badge badge-b badge-pill badge-primary">Publish</span>' : '<span class="badge badge-b badge-pill badge-secondary">Archive</span>');

				// Action
				$h = ( $res['post_headline']=='Y' ? 'hedline_off' : 'headline_on' );
				$row[] = '<div class="text-center"><div class="btn-group">
						<button type="button" class="btn btn-sm btn-default headline_toggle" data-toggle="tooltip" data-placement="top" data-title="Headline" data-id="'. encrypt($res['post_id']) .'"><i class="fa fa-star"></i></button>
						<button type="button" onclick="location.href=\''. member_url($this->mod.'/edit/?id='.urlencode(encrypt($res['post_id']))) .'\'" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" data-title="'. lang_line('button_edit') .'"><i class="fa fa-pencil"></i></button>
						<button type="button" class="btn btn-sm btn-default delete_single" data-toggle="tooltip" data-placement="top" data-title="'. lang_line('button_delete') .'" data-pk="'. encrypt($res['post_id']) .'"><i class="fa fa-trash"></i></button>
						</div></div>';
				
				$data_output[] = $row;
			}

			$output = array(
							 'data' => $data_output,
							 'draw' => $this->input->post('draw'),
							 'recordsTotal' => $this->post_model->count_all(),
							 'recordsFiltered' => $this->post_model->count_filtered()
							);

			$this->json_output($output);
		}
		
		else
		{
			$this->render_view('post', $this->vars);
		}
	}


	/**
	 * Fungsi untuk ON/OFF headline post.
	 * @access 	public
	 * @return 	void | string | json
	*/
	public function headline()
	{
		if ( $this->input->is_ajax_request() )
		{
			$pk = decrypt($this->input->post('pk'));
			
			$query_headline = $this->db
				->select('id,headline')
				->where('id', decrypt($this->input->post('pk')))
				->get('t_post');

			if ( $query_headline->num_rows() == 1 )
			{
				$post = $query_headline->row_array();
				$headline = ( $post['headline'] == 'Y' ? 'N' : 'Y');

				$data = array(
					'headline' => $headline
				);
				$this->post_model->update_post($pk, $data);

				$response['status'] = true;
				$response['index']  = 'h-'.$pk;
				$response['html']   = ( $headline == 'Y' ? '<i class="fa fa-star text-warning"></i> Headline' : '' );
				$response['alert']['type'] = 'alert';
				$response['alert']['content'] = ( $headline == 'Y' ? '<i class="fa fa-exclamation-circle mr-2"></i> Headline ON' : '<i class="fa fa-exclamation-circle mr-2"></i> Headline OFF' );
			}
			else
			{
				$response['status'] = false;
				$response['alert']['type'] = 'error';
				$response['alert']['content'] = 'Error';
			}

			$this->json_output($response);
		}
		else
		{
			show_404();
		}
	}


	/**
	 * Fungsi untuk tambah post baru.
	 * @access 	public
	 * @return 	void
	*/
	public function add_new() 
	{
		$this->meta_title(lang_line('post_title_add_post'));
		
		if ( $this->input->is_ajax_request() ) 
		{
			return $this->_submit_add();
		}
		else
		{		
			$this->vars['all_category'] = $this->post_model->get_all_category();
			$this->vars['all_tag']      = $this->post_model->get_all_tag();
			$this->render_view('post_add', $this->vars);
		}
	}


	/**
	 * Fungsi aksi submit tambah post.
	 * @access 	private
	 * @return 	void | string | json
	*/
	private function _submit_add()
	{
		$this->form_validation->set_rules(array(
			array(
				'field' => 'title',
				'label' => lang_line('post_label_title'),
				'rules' => 'required|trim|min_length[6]|max_length[150]|callback__cek_add_seotitle'
			),
			array(
				'field' => 'category',
				'label' => lang_line('post_label_category'),
				'rules' => 'required|trim'
			),
			array(
				'field' => 'content',
				'label' => lang_line('post_label_content'),
				'rules' => 'required'
			)
		));

		if ( $this->form_validation->run() )
		{
			$tags_input = $this->input->post('tags');
			$tags_input_s = explode(',', $tags_input);
			$tags = '';
			foreach ($tags_input_s as $tval) 
			{
				$tag_title = seotitle($tval,'');
				$tags .= $tag_title.',';	
			}
			$tags = rtrim($tags, ',');

			$post_picture = ''; // Set default picutre name.

			if ( !empty($_FILES['fupload']['tmp_name']) ) // if isset image file.
			{
				$temp = current($_FILES);
				$img_name = date('YmdHis').'_'.md5(date('YmdHis'));
				$extension = pathinfo($temp['name'], PATHINFO_EXTENSION);

				$this->load->library('upload', array(
					'upload_path'   => CONTENTPATH.'uploads/post/',
					'allowed_types' => "jpg|jpeg|png|gif",
					'file_name'     => $img_name,
					'max_size'      => 1024 * 10,
					'overwrite'     => TRUE
				));

				if ( $this->upload->do_upload('fupload') )
				{
					$post_picture = "post/$img_name.$extension";

					// CREATE IMAGE.
					$this->load->library('simple_image');

					// Ori
					$this->simple_image
					     ->fromFile(CONTENTPATH.'uploads/'.$post_picture)
					     ->thumbnail(900, 600, 'center')
					     ->toFile(CONTENTPATH.'uploads/'.$post_picture);
					// Medium
					$this->simple_image
					     ->fromFile(CONTENTPATH.'uploads/'.$post_picture)
					     ->thumbnail(640, 426, 'center')
					     ->toFile(CONTENTPATH.'uploads/medium/'.$post_picture);

					// Thumb.
					$this->simple_image
					     ->fromFile(CONTENTPATH.'uploads/'.$post_picture)
					     ->thumbnail(122, 91, 'center')
					     ->toFile(CONTENTPATH.'thumbs/'.$post_picture);
				}
			}
			
			// Set data post.
			$title = xss_filter($this->input->post('title'));
			$data_post = array(
				'title'         => $title,
				'seotitle'      => seotitle($title),
				'content'       => xss_filter($this->input->post('content', TRUE)),
				'id_category'   => xss_filter(decrypt($this->input->post('category')),'sql'),
				'tag'           => $tags,
				'picture'       => $post_picture,
				'image_caption' => xss_filter($this->input->post('image_caption')),
				'datepost'      => date('Y-m-d'),
				'timepost'      => date('H:i:s'),
				'id_user'       => login_key('member'),
				'headline'      => ($this->input->post('headline') == '1' ? 'Y' : 'N'),
				'comment'       => ($this->input->post('comment') == '1' ? 'Y' : 'N'),
				'active'        => 'N'
			);
			
			// Insert data post to database.
			$this->post_model->insert_post($data_post);
			
			// set bootstrap alert message.
			$this->alert->set($this->mod, 'success', lang_line('form_message_add_success'));
			
			// set json response status.
			$response['success'] = true;
		}

		// form validation invalid.
		else
		{
			$response['success'] = false;
			$response['alert']['type'] = 'error';
			$response['alert']['content'] = validation_errors();
		}

		// send json response.
		$this->json_output($response);
	}


	/**
	 * Fungsi untuk ubah post.
	 * @access 	public
	 * @return 	void
	*/
	public function edit() 
	{
		$this->meta_title(lang_line('post_title_edit_post'));

		$getid = $this->input->get('id');
		$id_post = xss_filter(urldecode(decrypt($getid)),'sql');
		
		// Check id_post
		if ( $id_post != 0 || $this->post_model->cek_id($id_post) == 1 ) 
		{
			if ( $this->input->is_ajax_request() )
			{
				return $this->_submit_update();
			}
			else
			{			
				$result_post = $this->post_model->get_post($id_post);
				$this->vars['result_post']  = $this->post_model->get_post($id_post);
				$this->vars['cek_category'] = $this->post_model->val_cat($result_post['category_id']);
				$this->vars['all_category'] = $this->post_model->get_all_category();			
				$this->render_view('post_edit', $this->vars);
			}
		}
		else
		{
			$this->render_404();
		}
	}


	/**
	 * Fungsi aksi ubah post.
	 * @access 	private
	 * @return 	void | string | json
	*/
	private function _submit_update()
	{
		if ( $this->input->is_ajax_request() )
		{
			$pk = $this->input->post('pk');
			$id_post = xss_filter(decrypt($pk), 'sql');

			$this->form_validation->set_rules(array(
				array(
					'field' => 'title',
					'label' => lang_line('post_label_title'),
					'rules' => 'required|trim|min_length[6]|max_length[150]|callback__cek_edit_seotitle['. $id_post .']'
				),
				array(
					'field' => 'category',
					'label' => lang_line('post_label_category'),
					'rules' => 'required|trim'
				),
				array(
					'field' => 'content',
					'label' => lang_line('post_label_content'),
					'rules' => 'required'
				)
			));

			if ( $this->form_validation->run() )
			{
				$tags_input = $this->input->post('tags');
				$tags_input_s = explode(',', $tags_input);
				$tags = '';
				foreach ($tags_input_s as $tval) 
				{
					$tag_title = seotitle($tval,'');
					$tags .= $tag_title.',';	
				}
				$tags = rtrim($tags, ',');
				$data_post='';
				$data_picture = []; // Set default picutre name.
				
				if ( !empty($_FILES['fupload']['tmp_name']) ) // if isset image file.
				{
					$temp = current($_FILES);
					$img_name = date('YmdHis').'_'.md5(date('YmdHis'));
					$extension = pathinfo($temp['name'], PATHINFO_EXTENSION);

					$this->load->library('upload', array(
						'upload_path'   => CONTENTPATH.'uploads/post/',
						'allowed_types' => "jpg|jpeg|png",
						'file_name'     => $img_name,
						'max_size'      => 1024 * 10,
						'overwrite'     => TRUE
					));

					if ( $this->upload->do_upload('fupload') )
					{
						$post_picture = "post/$img_name.$extension";

						$this->load->library('simple_image');

						// Ori
						$this->simple_image
						     ->fromFile(CONTENTPATH.'uploads/'.$post_picture)
						     ->thumbnail(900, 600, 'center')
						     ->toFile(CONTENTPATH.'uploads/'.$post_picture);

						// Medium
						$this->simple_image
						     ->fromFile(CONTENTPATH.'uploads/'.$post_picture)
						     ->thumbnail(640, 426, 'center')
						     ->toFile(CONTENTPATH.'uploads/medium/'.$post_picture);

						// Thumb.
						$this->simple_image
						     ->fromFile(CONTENTPATH.'uploads/'.$post_picture)
						     ->thumbnail(122, 91, 'center')
						     ->toFile(CONTENTPATH.'thumbs/'.$post_picture);
					}
					else
					{
						$post_picture = '';
					}
					
					$data_picture = ['picture' => $post_picture];
				}
				
				// Set data post.
				$title = xss_filter($this->input->post('title'));
				$data_post = array(
					'title'         => $title,
					'seotitle'      => seotitle($title),
					'content'       => xss_filter($this->input->post('content', TRUE)),
					'id_category'   => xss_filter(decrypt($this->input->post('category')), 'sql'),
					'image_caption' => xss_filter($this->input->post('image_caption')),
					'tag'           => $tags,
					'comment'       => ($this->input->post('comment') == '1' ? 'Y' : 'N'),
					'headline'      => ($this->input->post('headline') == '1' ? 'Y' : 'N')
				);
				
				// Merge array $data_post & $data_picture.
				$data = array_merge_recursive($data_post,$data_picture);
				
				// Insert data post to database.
				$this->post_model->update_post($id_post, $data);

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
			$this->render_404();
		}
	}


	/**
	 * Fungsi aksi hapus post.
	 * @access 	public
	 * @return 	void | string | json
	*/
	public function delete()
	{
		if ( $this->input->is_ajax_request() )
		{
			$data_pk = $this->input->post('data');

			foreach ($data_pk as $key)
			{
				$pk = xss_filter(decrypt($key),'sql');
				$this->post_model->delete($pk);
			}

			$response['success'] = true;
			$response['alert']['type'] = 'success';
			$response['alert']['content'] = lang_line('form_message_delete_success');

			$this->json_output($response);
		}
		else
		{
			show_404();
		}
	}

	
	/**
	 * Fungsi untuk menampilkan tag saat di ketik pada inputan tags.
	 * @access 	public
	 * @return 	void | string | json
	*/
	public function ajax_tags()
	{
		if ( $this->input->is_ajax_request() )
		{
			$input  = seotitle($this->input->post('q'));
			$output = $this->post_model->ajax_tags($input);
			$this->json_output($output);
		}
		else
		{
			show_404();
		}
	}


	/**
	 * Fungsi untuk validasi seotitle untuk aksi tambah post.
	 * @access 	public
	 * @return 	bool | void
	*/
	public function _cek_add_seotitle($seotitle = '') 
	{
		$cek = $this->post_model->cek_seotitle(seotitle($seotitle));
		if ( $cek === FALSE ) 
			$this->form_validation->set_message('_cek_add_seotitle', lang_line('form_message_already_exists'));
		return $cek;
	}
	

	/**
	 * Fungsi untuk validasi seotitle untuk aksi ubah post.
	 * @access 	public
	 * @return 	bool | void
	*/
	public function _cek_edit_seotitle($id, $seotitle = '') 
	{
		$cek = $this->post_model->cek_seotitle2($id, seotitle($seotitle));
		if ( $cek === FALSE )
			$this->form_validation->set_message('_cek_edit_seotitle', lang_line('form_message_already_exists'));
		return $cek;
	}
} // End class.