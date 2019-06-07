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
			'modjs'       => CONTENTPATH."modjs/"
		);
	}

	
	public function index()
	{
		if ($this->read_access == TRUE)
		{
			$this->render_view('view_index', $this->vars);
		}
		else
		{
			$this->render_404();
		}
	}


	public function data_table()
	{
		if ($this->input->is_ajax_request() == TRUE && $this->read_access == TRUE)
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
									<button class="button btn-xs btn-default" onclick="location.href=\''. admin_url(underscore($val['class'])) .'\'" data-toggle="tooltip" data-placement="top" data-title="Go To Component"><i class="fa fa-puzzle-piece"></i></button>
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
			return $this->render_404();
		}
	}


	public function add_new()
	{
		if ( $this->read_access == FALSE || $this->write_access == FALSE )
		{
			return $this->render_403();
		}
		elseif ( $_SERVER['REQUEST_METHOD'] == 'POST' )
		{
			return $this->_submit_add();
		}
		else
		{
			return $this->render_view('view_add_new', $this->vars);
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
			$cek_model_file = file_exists(APPPATH."models/mod/".$model_file);
			$cek_views = file_exists(APPPATH."views/mod/".$views_dir);
			$cek_modjs = file_exists(CONTENTPATH."modjs/".$modjs);

			// cek component db
			$cek_db_table = $this->db->table_exists($table_name);
			$cek_mod_db = $this->db->where('class', $class_name)->get('t_component')->num_rows();

			// component not eksist (OK)
			if ($cek_mod_db == 0 && 
				$cek_controllers_file == FALSE && 
				$cek_model_file == FALSE && 
				$cek_views == FALSE &&
				$cek_modjs == FALSE &&
				$cek_db_table == FALSE
				)
			{
				// upload config.
				$max_file_size =  1024 * 5;
				$this->load->library('upload', array(
					'upload_path' => $upload_path,
					'allowed_types' => "zip",
					'file_name' => $zip_name,
					'overwrite' => FALSE,
					'max_size' => $max_file_size,
				));

				// run upload.
				if ($this->upload->do_upload('file'))
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
							$u_models = array_diff(scandir($src_dir."/models"), array('.', '..'));
							$u_modjs = array_diff(scandir($src_dir."/modjs"), array('.', '..'));

							// rename file controllers to same as class.
							@rename($src_dir."/controllers/".$u_controllers[2], 
									$src_dir."/controllers/".ucfirst($class_name).".php");

							// rename file models to same as class.
							@rename($src_dir."/models/".$u_models[2],
									$src_dir."/models/".ucfirst($class_name)."_model.php");

							// rename file modjs to same as class.
							@rename($src_dir."/modjs/".$u_modjs[2],
									$src_dir."/modjs/$modjs");
							// Copy module from temp to system.
							copy_folder($src_dir."/controllers", $this->_path['controllers']);
							copy_folder($src_dir."/models", $this->_path['models']);
							copy_folder($src_dir."/views", $this->_path['views'].$class_name);
							copy_folder($src_dir."/modjs", $this->_path['modjs']);
							
							// insert db
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
							$this->dbforge->create_table($table_name,TRUE,array('ENGINE' => 'InnoDB'));

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
							$this->alert->set($this->mod."add", 'danger', "error table_config");
							// redirect to add new page
							redirect(uri_string());
						}
					}

					// error extrak zip no folder.
					else
					{
						$this->alert->set($this->mod,'danger', "error upload");
						redirect(uri_string());
					}
				}
				// error upload
				else
				{
					$error_content = $this->upload->display_errors();
					$this->alert->set($this->mod."add", "danger", $error_content);
					redirect(uri_string());
				}
			}

			// component is exist (ERROR)
			else 
			{
				$r_cek_mod_db = ($cek_mod_db == 1 ? "* Component row is exist <br>" : "");
				$r_cek_controllers_file = ($cek_controllers_file == TRUE ? "* Controllers $class_file file is exist <br>" : "");
				$r_cek_model_file = ($cek_model_file == TRUE ? "* Model $model_file file is exist <br>": "");
				$r_cek_views = ($cek_views == TRUE ? "* Views $views_dir folder is exist <br>" : "");
				$r_cek_modjs = ($cek_modjs == TRUE ? "* Modjs $modjs file is exist <br>" : "");
				$r_cek_db_table = ($cek_db_table == TRUE ? "* Table $table_name is exist <br>" : "");

				$this->alert->set($this->mod."add", "danger", "<i class='fa fa-exclamation-triangle'></i> &nbsp; ERROR <br>$r_cek_mod_db $r_cek_controllers_file $r_cek_model_file $r_cek_views $r_cek_db_table");

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



	/**
	 * - Function Delete.
	 *
	 * @var string $id_data
	 * @return void, string, json
	 * @access public
	*/
	public function delete()
	{
		if ($this->input->is_ajax_request() == TRUE && $this->delete_access == TRUE)
		{
			$data = $this->input->post('data');
			$id_component = decrypt($data[0]);
			$component = $this->component_model->get_modul($id_component);
			
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
			return show_404();
		}
	} // End Function.


} // End Class.