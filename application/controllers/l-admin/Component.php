<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Component extends Admin_controller {
	
	public $mod = 'component';
	protected $_path = [];

	public function __construct() 
	{
		parent::__construct();
		
		$this->lang->load('mod/'.$this->mod, $this->_language);
		$this->meta_title(lang_line('mod_title'));
		$this->load->model('mod/component_model');
		
		$this->_path = array(
			'controllers' => APPPATH."controllers/".FADMIN."/",
			'models'      => APPPATH."models/mod/",
			'views'       => APPPATH."views/mod/",
			'modjs'       => CONTENTPATH."modjs/",
			'temp'        => CONTENTPATH."temp/",
		);
	}


	public function index()
	{
		if ( $this->read_access )
		{
			if ( $this->input->is_ajax_request() )
			{
				$data_mod = $this->component_model->get_datatables();
				$data_output = array();

				foreach ($data_mod as $val) 
				{
					$row   = [];
					$row[] = '<a href="'.admin_url(underscore($val['class'])).'">'.$val['name'].'</a>';
					$row[] = $val['type'];
					$row[] = ( $val['status'] == "Y" ? '<span class="badge badge-primary badge-pill">'. lang_line('installed') .'</span>' : '<span class="badge badge-secondary badge-pill">'. lang_line('not-installed') .'</span>' );

					if ( $this->delete_access ) 
					{
						$row[] = '
							<div class="text-center">
								<div class="btn-group">
									<button class="button btn-xs btn-default" onclick="location.href=\''.  admin_url($this->mod.'/backup/'.$val['id']) .'\'" data-toggle="tooltip" data-placement="top" data-title="Buckup"><i class="fa fa-download"></i></button>
									<button type="button" class="button btn-xs btn-default delete_single" data-toggle="tooltip" data-placement="top" data-title="'. lang_line('button_delete') .'" data-pk="'. encrypt($val['id']) .'"><i class="icon-bin"></i></button>
								</div>
							</div>';
					}
					else
					{
						$row[] = '
							<div class="text-center">
								<div class="btn-group">
									<a href="'. admin_url(underscore($val['class'])) .'" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" data-title="Go To Component"><i class="fa fa-puzzle-piece"></i></a>
								</div>
							</div>';
					}

					$data_output[] = $row;
				}

				$output = array(
								"data" => $data_output,
								"draw" => $this->input->post('draw'),
								"recordsTotal" => $this->component_model->count_all(),
								"recordsFiltered" => $this->component_model->count_filtered()
								);

				$this->json_output($output);
			}
			else
			{
				$this->render_view('view_index', $this->vars);
			}
		}
		else
		{
			$this->render_403();
		}
	}


	public function add_new()
	{
		if ( $this->read_access && $this->write_access )
		{
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
			{
				return $this->_install();
			}
			else
			{
				$this->render_view('view_add_new', $this->vars);
			}
		}
		else
		{
			$this->render_403();
		}
	}


	private function _install()
	{
		$sp = DIRECTORY_SEPARATOR;
		$rand = md5(date('YmdHis'));
		$package_zip = $rand.'.zip';

		// panggil library upload dan konfigurasi paket komponen (extensi *.zip).
		$this->load->library('upload', array(
			'upload_path'   => $this->_path['temp'],
			'allowed_types' => 'zip',
			'file_name'     => $package_zip,
			'overwrite'     => FALSE,
			'max_size'      => 1024 * 5 // 5Mb
		));

		// jalankan upload.
		if ( $this->upload->do_upload('file') )
		{
			$destinationdir_unzip = $this->_path['temp'].$rand;

			// panggil library unzip.
			$this->load->library('unzip', array($this->_path['temp'].$package_zip));
			$this->unzip->extract($destinationdir_unzip);
			
			// hapus file *.zip dari foder temp.
			@unlink($this->_path['temp'].$package_zip);

			// cek folder hasil unzip dan file config.php
			if ( 
			     file_exists($destinationdir_unzip) && 
			     file_exists($destinationdir_unzip.$sp.'config.php')
			    )
			{
				$src_dir = $destinationdir_unzip;

				// include-kan file config.php
				include_once($destinationdir_unzip.$sp.'config.php');

				// cek file dan folder komponen.
				$cek_controllers = file_exists($this->_path['controllers'].$_config['file_controller']);
				$cek_models      = file_exists($this->_path['models'].$_config['file_model']);
				$cek_views       = file_exists($this->_path['views'].$_config['class_name']);
				$cek_modjs       = file_exists($this->_path['modjs'].$_config['file_modjs']);

				// cek tabel & data t_component.
				$cek_table   = $this->db->table_exists($_config['table_name']);
				$cek_mod_db  = $this->db->where('class', $_config['class_name'])->get('t_component')->num_rows();

				// cek source di folder temp.
				$cek_src_controllers = file_exists($src_dir.$sp.'controllers'.$sp.$_config['file_controller']);
				$cek_src_models      = file_exists($src_dir.$sp.'models'.$sp.$_config['file_model']);
				$cek_src_views       = file_exists($src_dir.$sp.'views');
				$cek_src_modjs       = file_exists($src_dir.$sp.'modjs'.$sp.$_config['file_modjs']);
				$cek_src_sql         = file_exists($src_dir.$sp.'sql'.$sp.$_config['file_sql']);
				
				// jalankan cek.
				if (
				     // cek apakah komponen sudah ada di sistem.
					 $cek_controllers == FALSE && 
					 $cek_models == FALSE && 
					 $cek_views == FALSE && 
					 $cek_modjs == FALSE && 
					 $cek_table == FALSE && 
				     $cek_mod_db == 0 &&

				     // cek apakah ada file komponen di folder temp.
				     $cek_src_controllers == TRUE && 
				     $cek_src_models == TRUE  && 
				     $cek_src_views == TRUE && 
				     $cek_src_modjs == TRUE && 
				     $cek_src_sql == TRUE
					)
				{
					// Copy komopnen dari folder temp ke sistem.
					@copy_folder($src_dir.$sp."controllers", $this->_path['controllers']);
					@copy_folder($src_dir.$sp."models", $this->_path['models']);
					@copy_folder($src_dir.$sp."views", $this->_path['views'].$_config['class_name']);
					@copy_folder($src_dir.$sp."modjs", $this->_path['modjs']);

					// insert data t_component.
					$this->component_model->insert(array(
						'type'       => $_config['component_type'],
						'name'       => $_config['component_name'],
						'class'      => $_config['class_name'],
						'table_name' => $_config['table_name'],
						'status'     => 'Y'
					));

					if ( $this->_import_sql($src_dir.$sp.'sql'.$sp.$_config['file_sql']) ) // import data sql.
					{
						@delete_folder($destinationdir_unzip); // delete folder temp.
						$this->alert->set($this->mod, 'success', lang_line('form_message_add_success'));
						redirect(admin_url($this->mod));
					} 
					else 
					{
						@delete_folder($destinationdir_unzip); // delete folder temp.
						$this->alert->set($this->mod, 'danger', 'SQL Error..!');
						redirect(admin_url($this->mod));
					}
				}

				// Jika pengecekan gagal.
				// controllers, model, views dir, modjs, table, data t_component.
				else
				{
					@delete_folder($destinationdir_unzip); // delete folder temp.
					$this->alert->set($this->mod, 'danger', 'ERROR..! Component package is corrupt or some files have been installed before. Please check the structure of your component package.');
					redirect(uri_string());
				}
			}
			else
			{
				@delete_folder($destinationdir_unzip); // delete folder temp.
				$this->alert->set($this->mod, 'danger', 'ERROR..! Installation config not found.');
				redirect(uri_string());
			}
		}

		// Jika error upload paket komponen.
		else
		{
			$error_content = $this->upload->display_errors();
			$this->alert->set($this->mod.'add', 'danger', $error_content);
			redirect(uri_string());
		}
	}


	private function _import_sql($file) 
    {
        $this->db->trans_off();
        $this->db->trans_start(TRUE);
        $this->db->trans_begin();
        $sql = file_get_contents($file);
        $this->db->query($sql);

        if ( $this->db->trans_status() == TRUE ) 
        {
            $this->db->trans_commit();
            return true;
        }
        else 
        {
            $this->db->trans_rollback();
            return false;
        }
    }


    public function delete()
	{
		if ( $this->input->is_ajax_request() && $this->delete_access )
		{
			$data = $this->input->post('data');
			$id_component = decrypt($data[0]);
			$component    = $this->component_model->get_modul($id_component);
			
			if ( $component != FALSE )
			{
				$controllers_file = $this->_path['controllers'].ucfirst($component['class']).".php";
				$models_file      = $this->_path['models'].ucfirst($component['class'])."_model.php";
				$views_dir        = $this->_path['views'].$component['class'];
				$modjs            = $this->_path['modjs'].$component['class'].".js";

				if ( $this->component_model->delete($id_component, $component['table_name']) )
				{
					// delete views views_dir
					if ( is_dir($views_dir) )
						delete_folder($views_dir);

					// delete views controllers_file
					if ( file_exists($controllers_file) )
						@unlink($controllers_file);

					// delete views models_file
					if ( file_exists($models_file) )
						@unlink($models_file);

					// delete views modjs
					if ( file_exists($modjs) )
						@unlink($modjs);

					$response['success']          = true;
					$response['alert']['type']    = 'success';
					$response['alert']['content'] = lang_line('form_message_delete_success');
					$this->json_output($response);
				}
				else
				{
					$response['success']        = false;
					$response['alert_type']     = 'danger';
					$response['alert_messages'] = 'Unknown error';
					$this->json_output($response);
				}
			}
			else
			{
				$response['success']          = false;
				$response['alert']['type']    = 'danger';
				$response['alert']['content'] = 'Component not found';
				$this->json_output($response);
			}
		}
		else
		{
			show_404();
		}
	}


	public function backup($id = 0)
	{
		if ( $this->write_access )
		{
			$id_component = xss_filter($id, 'sql');
			$query = $this->db->where('id', $id_component)->get('t_component');
			$cek = $query->num_rows();
			
			if ( $query->num_rows() == 1 )
			{
				$component = $query->row_array();
				$this->_runBackup($component);
			}
			else
			{
				$this->alert->set($this->mod, 'danger', 'ERROR..! Component not found.');
				redirect(admin_url($this->mod));
			}
		}
		else
		{
			$this->render_403();
		}
	}


	private function _runBackup($component)
	{
		$c_date       = date('Y-m-d, h:i A');
		$c_type       = $component['type'];
		$c_name       = $component['name'];
		$c_class      = $component['class'];
		$c_table      = $component['table_name'];
		$c_sql        = $component['table_name'].'.sql';
		$c_controller = ucfirst($component['class']).'.php';
		$c_model      = ucfirst($component['class']).'_model.php';
		$c_views      = $component['class'];
		$c_modjs      = $component['class'].'.js';

		$c_status = 'Y';

		$dir_name = 'backup-'.seotitle($c_class);
		$path_temp_component = $this->_path['temp'].$dir_name.'/';

		// create temp folder and config file.
		if ( @mkdir($path_temp_component) ) 
		{
			@mkdir($path_temp_component . 'controllers');
			@mkdir($path_temp_component . 'models');
			@mkdir($path_temp_component . 'modjs');
			@mkdir($path_temp_component . 'views');
			@mkdir($path_temp_component . 'sql');

			// create file config.
			$config_content = "<?php\n/**\n * - Ini adalah file konfigurasi instalasi komponen CiFireCMS.\n * - Komponen   : {$c_name}\n * - Tipe       : {$c_type}\n * - Tanggal    : {$c_date}\n*/\n\n\$_config['component_type']  = '{$c_type}';\n\$_config['component_name']  = '{$c_name}';\n\$_config['class_name']      = '{$c_class}';\n\$_config['table_name']      = '{$c_table}';\n\$_config['file_sql']        = '{$c_sql}';\n\$_config['file_controller'] = '{$c_controller}';\n\$_config['file_model']      = '{$c_model}';\n\$_config['dir_views']       = '{$c_views}';\n\$_config['file_modjs']      = '{$c_modjs}';";

			write_file($path_temp_component . 'config.php', $config_content);

			// Copy controllers.
			$file_controller       = ucfirst($c_class).'.php';
			$path_app_controllers  = $this->_path['controllers'].$file_controller;
			$path_temp_controllers = $path_temp_component . "controllers/$file_controller";

			if ( file_exists($path_app_controllers) )
				r_copy($path_app_controllers, $path_temp_controllers);

			// Copy models.
			$file_model       = ucfirst($c_class).'_model.php';
			$path_app_models  = $this->_path['models'].$file_model;
			$path_temp_models = $path_temp_component . "models/$file_model";

			if ( file_exists($path_app_models) )
				r_copy($path_app_models, $path_temp_models);

			// Copy views.
			$path_app_views  = $this->_path['views'].$c_class;
			$path_temp_views = $path_temp_component.'views';

			if ( file_exists($path_app_views) )
				copy_folder($path_app_views, $path_temp_views);

			// Copy modjs.
			$file_modjs       = strtolower($c_class).'.js';
			$path_app_modjs   = $this->_path['modjs'].$file_modjs;
			$path_temp_modjs  = $path_temp_component."modjs/$file_modjs";

			if ( file_exists($path_app_modjs) )
				r_copy($path_app_modjs, $path_temp_modjs);

			// backup table database.
			$sql_name      = $c_table.'.sql';
			$path_temp_sql = $path_temp_component.'sql/'.$sql_name;

			$this->db = $this->load->database('mysqli', TRUE);
			$this->load->dbutil();

			$backup_database = $this->dbutil->backup(array(
				'tables'     => array($c_table), // Array of tables to backup.
				'ignore'     => array(),         // List of tables to omit from the backup
				'format'     => 'txt',           // gzip, zip, txt
				'add_drop'   => TRUE,            // Whether to add DROP TABLE statements to backup file
				'add_insert' => TRUE,            // Whether to add INSERT data to backup file
				'newline'    => "\n"             // Newline character used in backup file
			));

			write_file($path_temp_sql, $backup_database);
		}

		// archives component.
		$this->load->library('zip');
		$zip_name = 'component-'.$dir_name.'.zip';

		$this->zip->read_dir($path_temp_component . 'controllers', FALSE);
		$this->zip->read_dir($path_temp_component . 'models', FALSE);
		$this->zip->read_dir($path_temp_component . 'views', FALSE);
		$this->zip->read_dir($path_temp_component . 'modjs', FALSE);
		$this->zip->read_dir($path_temp_component . 'sql', FALSE);
		$this->zip->read_file($path_temp_component . 'config.php');
		$this->zip->compression_level = 2;
		$this->zip->archive($path_temp_component.$zip_name);
		$this->zip->clear_data();

		// copy backup zip to content/uploads/file/.
		r_copy($path_temp_component.$zip_name, CONTENTPATH.'uploads/file/'.$zip_name);

		// delete temp.
		@delete_folder($path_temp_component);

		// Download backup zip from content/uploads/file/.
		$this->load->helper('download');

		if ( force_download(CONTENTPATH.'uploads/file/'.$zip_name, NULL) ) 
		{
			redirect(admin_url($this->mod));
		}
	} 
} // End Class.