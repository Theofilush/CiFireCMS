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
					$row = [];
					$row[] = '<a href="'.admin_url(underscore($val['class'])).'">'.$val['name'].'</a>';
					$row[] = $val['type'];
					$row[] = ( $val['status'] == "Y" ? '<span class="badge badge-primary badge-pill">'.lang_line('installed').'</span>' : '<span class="badge badge-secondary badge-pill">'.lang_line('not-installed').'</span>' );

					if ($this->delete_access == TRUE) 
					{
						$row[] = '
								<div class="text-center">
									<div class="btn-group">
										<button class="button btn-xs btn-default" onclick="location.href=\''. admin_url($this->mod.'/backup/'.$val['id']) .'\'" data-toggle="tooltip" data-placement="top" data-title="Buckup"><i class="fa fa-download"></i></button>
										<button type="button" class="button btn-xs btn-default delete_single" data-toggle="tooltip" data-placement="top" data-title="'.lang_line('button_delete').'" data-pk="'. encrypt($val['id']) .'"><i class="icon-bin"></i></button>
									</div>
								</div>';
					}
					else
					{
						$row[] = '
								<div class="text-center">
									<div class="btn-group">
										<a href="'.admin_url(underscore($val['class'])).'" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" data-title="Go To Component"><i class="fa fa-puzzle-piece"></i></a>
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
				return $this->_submit_add();
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


	private function _submit_add()
	{
		$component_name = xss_filter($_POST['name'],'xss');
		$component_type = 'module';
		$class_name     = $_POST['class_name'];
		$table_name     = $_POST['table_name'];

		$class_file = ucfirst($class_name).".php";
		$model_file = ucfirst($class_name)."_model.php";
		$views_dir  = $class_name;
		$modjs      = $class_name.".js";

		$rand = random_string('numeric', 15);
		$zip_name = $rand.'.zip';
		$zip_path = CONTENTPATH."temp/".$zip_name;
		$upload_path = CONTENTPATH."temp";
		$dest_dir = CONTENTPATH."temp/".$rand;	
		
		
		switch ($component_type)
		{
			/* Start Module */
			case 'module':

			// cek component
			$cek_controllers_file = file_exists(APPPATH."controllers/".FADMIN."/".$class_file);
			$cek_model_file       = file_exists(APPPATH."models/mod/".$model_file);
			$cek_views            = file_exists(APPPATH."views/mod/".$views_dir);
			$cek_modjs            = file_exists(CONTENTPATH."modjs/".$modjs);

			// cek component db
			$cek_db_table = $this->db->table_exists($table_name);
			$cek_mod_db   = $this->db->where('class', $class_name)->get('t_component')->num_rows();

			// component not eksist (OK)
			if ($cek_mod_db == 0 && 
				$cek_controllers_file == FALSE && 
				$cek_model_file == FALSE && 
				$cek_views == FALSE &&
				$cek_modjs == FALSE &&
				$cek_db_table == FALSE
				)
			{
				// upload.
				$this->load->library('upload', array(
					'upload_path' => $upload_path,
					'allowed_types' => "zip",
					'file_name' => $zip_name,
					'overwrite' => FALSE,
					'max_size' => 1024 * 5
				));

				// run upload.
				if ( $this->upload->do_upload('file') )
				{
					// extract package at temp folder.
					$this->load->library('unzip', array($zip_path));
					$this->unzip->extract($dest_dir);

					// delete zip file from temp.
					@unlink($zip_path);

					if ( file_exists($dest_dir) == TRUE )
					{
						$src_dir = CONTENTPATH."temp/".$rand;
						
						if ( file_exists($src_dir."/table/table.php") ) 
						{
							// Scan folder.
							$u_controllers = array_diff(scandir($src_dir."/controllers"), array('.', '..'));
							$u_models      = array_diff(scandir($src_dir."/models"), array('.', '..'));
							$u_modjs       = array_diff(scandir($src_dir."/modjs"), array('.', '..'));

							// rename file controllers to same as class name.
							@rename($src_dir."/controllers/".$u_controllers[2], 
									$src_dir."/controllers/".ucfirst($class_name).".php");

							// rename file models to same as class name.
							@rename($src_dir."/models/".$u_models[2],
									$src_dir."/models/".ucfirst($class_name)."_model.php");

							// rename file modjs to same as class name.
							@rename($src_dir."/modjs/".$u_modjs[2],
									$src_dir."/modjs/$modjs");

							// Copy module from temp to system.
							copy_folder($src_dir."/controllers", $this->_path['controllers']);
							copy_folder($src_dir."/models", $this->_path['models']);
							copy_folder($src_dir."/views", $this->_path['views'].$class_name);
							copy_folder($src_dir."/modjs", $this->_path['modjs']);
							
							// insert to database table t_component.
							$this->component_model->insert(array(
								'name' => $component_name,
								'type' => $component_type,
								'class' => $class_name,
								'table_name' => $table_name,
								'status' => 'Y'
							));
							
							// include table configuration from temp.
							include_once($src_dir."/table/table.php");
							
							// load dbforge
							$this->load->dbforge();
							// set id to primary key
							$this->dbforge->add_key('id', TRUE);
							// Array $config['table'] from insinde file table.php
							$this->dbforge->add_field($config['table']); 
							$this->dbforge->create_table($table_name, TRUE, ['ENGINE' => 'InnoDB']);

							// Delete source folder from temp.
							@delete_folder($src_dir);

							// set alert status.
							$this->alert->set($this->mod, 'success', lang_line('form_message_add_success'));
							// redirect to all component
							redirect(admin_url($this->mod));
						}

						else
						{
							delete_folder($src_dir);
							$this->alert->set($this->mod.'add', 'danger', 'ERROR. Table config not found.');
							redirect(uri_string());
						}
					}

					// error extrak zip no folder.
					else
					{
						$this->alert->set($this->mod, 'danger', 'error upload');
						redirect(uri_string());
					}
				}
				// error upload
				else
				{
					$error_content = $this->upload->display_errors();
					$this->alert->set($this->mod.'add', 'danger', $error_content);
					redirect(uri_string());
				}
			}

			// component is exist (ERROR)
			else 
			{
				$r_cek_controllers_file = ($cek_controllers_file == TRUE ? "* Controllers $class_file file is exist <br>" : "");
				$r_cek_model_file       = ($cek_model_file == TRUE ? "* Model $model_file file is exist <br>": "");
				$r_cek_views            = ($cek_views == TRUE ? "* Views $views_dir folder is exist <br>" : "");
				$r_cek_modjs            = ($cek_modjs == TRUE ? "* Modjs $modjs file is exist <br>" : "");
				$r_cek_db_table         = ($cek_db_table == TRUE ? "* Table $table_name is exist <br>" : "");
				$r_cek_mod_db           = ($cek_mod_db == 1 ? "* Component row is exist <br>" : "");

				$this->alert->set($this->mod.'add', 'danger', "<i class='fa fa-exclamation-triangle'></i> &nbsp; ERROR <br>$r_cek_mod_db $r_cek_controllers_file $r_cek_model_file $r_cek_views $r_cek_db_table");

				redirect(uri_string());
			}

			break;
			/* End Module */

			/* Start Widget*/
			case 'widget':
				echo "Type Widget";
				$this->alert->set($this->mod."add", 'warning', "Component type is not suported");
				redirect(uri_string());
			break;
			/* End Widget */
		}
	}


	public function db_import_table($path) 
	{
		$sql_contents = file_get_contents($path);
		$sql_contents = explode(";", $sql_contents);
		foreach ($sql_contents as $query)
		{
			$this->db->query($query);
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

				if ( $this->component_model->delete($id_component, $component['table_name']) == TRUE )
				{
					// delete views views_dir
					if ( is_dir($views_dir) ) delete_folder($views_dir);

					// delete views controllers_file
					if ( file_exists($controllers_file) ) @unlink($controllers_file);

					// delete views models_file
					if ( file_exists($models_file) ) @unlink($models_file);

					// delete views modjs
					if ( file_exists($modjs) ) @unlink($modjs);

					$response['success']          = true;
					$response['alert']['type']    = 'success';
					$response['alert']['content'] = lang_line('form_message_delete_success');
					$this->json_output($response);
				}
				else
				{
					$response['success']        = false;
					$response['alert_type']     = "danger";
					$response['alert_messages'] = "Unknown error";
					$this->json_output($response);
				}
			}
			else
			{
				$response['success']          = false;
				$response['alert']['type']    = "danger";
				$response['alert']['content'] = "Component not found";
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

	private function _runBackup($component)
	{
		$c_table = $component['table_name'];
		$c_class = $component['class'];
		$c_type  = $component['type'];
		$c_name  = $component['name'];
		$c_status = $component['status'];

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
			$config_content = "<?php\n\$config['component_name'] = '{$c_name}';\n\$config['class_name'] = '{$c_class}';\n\$config['table_name'] = '{$c_table}';";
			write_file($path_temp_component . 'config.php', $config_content);

			// Copy controllers.
			$file_controller      = ucfirst($c_class).'.php';
			$path_app_controllers = $this->_path['controllers'].$file_controller;
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
			// return TRUE;
		}
	} 
} // End Class.




			// $this->db = $this->load->database('mysqli', TRUE);
			// $this->load->dbutil();
			// $backup = $this->dbutil->backup(array(
			// 		// 'tables'  => array('xxxxxx'), // Array of tables to backup.
			// 		// 'ignore'  => array(),    // List of tables to omit from the backup
			// 		'format'     => 'txt',      // gzip, zip, txt
			// 		// 'filename'   => $table,     // File name - NEEDED ONLY WITH ZIP FILES
			// 		'add_drop'   => TRUE,       // Whether to add DROP TABLE statements to backup file
			// 		'add_insert' => TRUE,       // Whether to add INSERT data to backup file
			// 		'newline'    => "\n"        // Newline character used in backup file
			// ));
			// write_file(CONTENTPATH."temp/$table", $backup);