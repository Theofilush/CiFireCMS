<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {
	
	public $mod_view;
	public $meta_title;
	public $_language;

	public function __construct() 
	{
		parent::__construct();

		$this->CI =& get_instance();

		if (login_status('admin') == TRUE) 
		{
			$this->_language = strtolower($this->set_language());
			$this->lang->load('main', $this->_language);
			
			$this->meta_title();

			$this->form_validation->set_error_delimiters('<div class="text-danger">*&nbsp;', '</div>');

			// set access.
			$this->read_access = $this->user_role->access(login_level('admin'), $this->mod, 'read_access');
			$this->write_access = $this->user_role->access(login_level('admin'), $this->mod, 'write_access');
			$this->delete_access = $this->user_role->access(login_level('admin'), $this->mod, 'delete_access');
			$this->modify_access = $this->user_role->access(login_level('admin'), $this->mod, 'modify_access');

			// post act.
			$this->_act = !empty($this->input->post('act')) ? $this->input->post('act') : NULL;
		}
		
		// not login.
		else
		{
			redirect(base_url(FADMIN.'/login'), 'refresh');
		}
	}
	

	public function global_access($mod)
	{
		$read_access = $this->user_role->access(login_level('admin'), $mod, 'read_access');
		$write_access = $this->user_role->access(login_level('admin'), $mod, 'write_access');
		$delete_access = $this->user_role->access(login_level('admin'), $mod, 'delete_access');
		$modify_access = $this->user_role->access(login_level('admin'), $mod, 'modify_access');

		if (
		    $read_access == FALSE || 
		    $write_access == FALSE || 
		    $delete_access == FALSE || 
		    $modify_access == FALSE
		    )
		{
			show_404();
		}
	}


	public function meta_title($param = '')
	{
		$title = !empty($param) ? lang_line('admin_meta_title').' - '.$param : lang_line('admin_meta_title');
		$this->meta_title = $title;
		
		return $this;
	}


	public function load_admin_content()
	{
		if ($this->mod_view == 'error403') 
		{
			$this->load->view('admin/error_403');
		}
		elseif ($this->mod_view == 'error404') 
		{
			$this->load->view('admin/error_404');
		}

		elseif ($this->mod_view && file_exists(VIEWPATH."mod/$this->mod/$this->mod_view.php"))
		{
			$this->load->view('mod/'.$this->mod.'/'.$this->mod_view);
		}

		else
		{
			$this->load->view('admin/error_404');
		}
	}


	public function render_view($view = '', $var = '', $parm = FALSE)
	{
		$this->mod_view = $view;
		$this->load->view('admin/index', $var, $parm);
	}


	public function render_400()
	{
		$this->mod_view = 'error400';
		$this->load->view('admin/index');
	}


	public function render_403()
	{
		$this->mod_view = 'error403';
		$this->load->view('admin/index');
	}


	public function render_404()
	{
		$this->mod_view = 'error404';
		$this->load->view('admin/index');
	}





	public function m_filter($str, $segment = 3) 
	{
		if ($this->uri->segment($segment) === $str) 
		{
			return show_404();
		}
	}

} // End class.