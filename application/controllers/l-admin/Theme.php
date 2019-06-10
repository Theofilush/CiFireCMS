<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Theme extends Admin_controller {

	public $mod = 'theme';

	public function __construct() 
	{
		parent::__construct();
		
		$this->lang->load('mod/'.$this->mod, $this->_language);
		$this->meta_title(lang_line('mod_title'));
		$this->load->model('mod/theme_model');
	}


	public function index()
	{
		if ($this->read_access == TRUE) 
		{
			if ($this->_act == 'blank_theme' && $this->write_access == TRUE)
			{
				return $this->_create_blank_theme();
			}
			
			elseif ($this->_act == 'active' && $this->modify_access == TRUE)
			{
				$id_theme = $this->input->post('id');
				$this->theme_model->active_theme($id_theme);
				$this->alert->set($this->mod, 'success', lang_line('message_active_success'));
				redirect(uri_string());
			}
			
			else
			{
				$this->vars['all_themes'] = $this->theme_model->all_themes();

				// load view
				$this->render_view('view_index', $this->vars);
			}
		}
		else
		{
			return $this->render_404();
		}
	}

	public function delete_theme()
	{
		$data = $this->input->post('data');
		$idTheme = xss_filter(decrypt($data['id']),'sql');
		$folderTheme = xss_filter(decrypt($data['folder']),'xss');
		
		if ( $this->theme_model->delete($idTheme) )
		{
			if ( 
				// delete theme views
			    @delete_folder(VIEWPATH.'themes/'.$folderTheme) && 
				// delete theme asset
			    @delete_folder(CONTENTPATH.'themes/'.$folderTheme) 
			    ) 
			{
				$response['success'] = true;
				$response['dataDelete'] = $idTheme;
				$response['alert']['type'] = 'success';
				$response['alert']['content'] = lang_line('message_delete_success');
				$this->json_output($response);
			}
		}
		else
		{
			$response['success'] = false;
			$response['dataDelete'] = '0';
			$response['alert']['type'] = 'error';
			$response['alert']['content'] = 'ERROR';
			$this->json_output($response);
		}
	}

	private function _create_blank_theme()
	{
		$this->form_validation->set_rules(array(array(
			'field' => 'title',
			'label' => lang_line('form_label_title'),
			'rules' => 'required|trim|min_length[3]|max_length[50]',
		)));

		if ($this->form_validation->run() == TRUE)
		{
			$title = $this->input->post('title');
			$folder = seotitle($title).'-'.md5(encrypt(1));
			$zip_path = CONTENTPATH."themes/blank-theme.zip";
			$destination_path = VIEWPATH."themes/$folder";

			$this->load->library('unzip', array($zip_path));
			$this->unzip->extract($destination_path);

			// create theme foler asset.
			@mkdir(CONTENTPATH.'themes/'.$folder, 0777, true);
			@fopen(CONTENTPATH."themes/$folder/index.html", "w");
			
			$this->theme_model->insert(array(
				'title' => $title,
				'folder' => $folder
			));

			$this->alert->set($this->mod, 'success', lang_line('message_add_success'));
		}
		else
		{
			$this->alert->set($this->mod, 'danger', validation_errors());
		}
		
		redirect(uri_string());
	}



	public function add_new()
	{
		if ($this->write_access == TRUE)
		{
			if ($this->_act == 'add_new')
			{
				$theme_title = xss_filter($this->input->post('title'), 'xss');
				$theme_folder = seotitle($theme_title)."-".md5($theme_title);

				$cek_db = $this->db->where('folder', $theme_title)->get('t_theme')->num_rows();

				if ( $cek_db > 0 )
				{
					echo "Oups..! Themes is exist.";
				}

				else
				{
					$this->theme_model->insert([
 						'title' => $theme_title,
 						'folder' => $theme_folder,
 						'active' => 'N'
					]);

					$zip_name = md5(date('Ymdhis'));

					$this->load->library('upload', array(
						'upload_path' => CONTENTPATH."temp/",
						'allowed_types' => "zip",
						'file_name' => $zip_name.".zip",
						'max_size' => 1024 * 30, // 30mb
						// 'overwrite' => TRUE
					));

					if ($this->upload->do_upload('fupload')) // upload
					{
						// Extract zip file.
						$unzip_path = CONTENTPATH."temp/$zip_name";
						$zip_file  = CONTENTPATH."temp/$zip_name.zip";
						$this->load->library('unzip', array($zip_file));
						$this->unzip->extract($unzip_path); // run extract.
						
						// Delete zip file.
						@unlink($zip_file);

						// Create views dir
						$view_destination_path = VIEWPATH."themes/$theme_folder";
						@mkdir($view_destination_path);
						
						// copy views temp to application views.
						$view_path = CONTENTPATH."temp/$zip_name/views/";
						@copy_folder($view_path,  $view_destination_path);

						// Create assets dir
						$assets_destination_path = CONTENTPATH."themes/$theme_folder";
						@mkdir($assets_destination_path);
						
						// copy assets temp to content themes.
						$assets_path = CONTENTPATH."temp/$zip_name/assets/";
						@copy_folder($assets_path,  $assets_destination_path);

						// Delete temp
						@delete_folder($unzip_path);

						$this->alert->set($this->mod,'success',lang_line('message_add_success'));
						redirect(admin_url($this->mod));
					}
					else
					{
						$error_content = $this->upload->display_errors();
						$this->alert->set($this->mod,'danger', $error_content);
						redirect(uri_string());
					}
				}
			}

			$this->render_view('view_add_new', $this->vars);
		}
		else
		{
			return $this->render_403();
		}
	}


	public function edit($id = 0, $file = 'home')
	{	
		$this->vars['res_theme'] = $this->theme_model->get_theme((int)$id);

		if ( $this->modify_access == TRUE )
		{
			if ( !empty($this->vars['res_theme']) ) 
			{
				$folder_edit = $this->vars['res_theme']['folder'];
				if ($this->_act == 'edit') 
				{
					$theme = $this->theme_model->get_theme($id);
					$code_content = $this->input->post('code_content');
					$data_content = str_replace("textarea_CI", "textarea", $code_content);
					$path = VIEWPATH.'themes/'.$theme['folder'].'/'.$file.'.php';
					write_file($path, $data_content);

					// alert
					$this->alert->set($this->mod,'success', "File <code>".$file.".php</code> ".lang_line('form_message_update_success'));

					redirect(uri_string());
				}

				elseif ( $this->_act == 'create_file' ) 
				{
					$file_name = seotitle($this->input->post('filename'));
					$path = VIEWPATH."themes/$folder_edit/$file_name.php";
					
					if (! file_exists($path)) 
					{
						write_file($path, '');
						// redirect(admin_url($this->mod."/edit/$id/$file_name"),'refresh');
						redirect(uri_string());
					}
					else
					{
						$this->alert->set($this->mod,'danger', lang_line('file_exist'));
						redirect(uri_string());
					}
				}

				elseif ( $this->_act == 'upload_theme_assets' )
				{
					$zip_name = md5("theme-assets-".date('Ymdhis'));

					$this->load->library('upload', array(
						'upload_path'   => CONTENTPATH."temp/",
						'allowed_types' => "zip",
						'file_name'     => $zip_name,
						'max_size'      => 1024 * 20, // 20Mb
						'overwrite'     => false
					));

					if ( $this->upload->do_upload('fupload') )
					{
						$zip_path = CONTENTPATH."temp/$zip_name.zip";
						$destination_path = CONTENTPATH."themes/$folder_edit/";

						$this->load->library('unzip', array($zip_path));

						if ( $this->unzip->extract($destination_path) )
						{
							@delete_folder($zip_path);

							redirect(uri_string());
						}
					}
					else
					{
						$this->upload->display_errors();
					}
				}

				else
				{
					$this->vars['file_layout'] = $file;
					$this->vars['res_theme'] = $this->theme_model->get_theme((int)$id);
					
					if (! file_exists(VIEWPATH.'themes/'.$this->vars['res_theme']['folder']."/$file.php"))
					{
						return $this->render_404();
					}

					// load view
					$this->render_view('view_edit', $this->vars);	
				}
			}
			else
			{
				return $this->render_404();
			}
		}
		else
		{
			return $this->render_403();
		}
	}
} // End Class.