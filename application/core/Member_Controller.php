<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Member_Controller extends MY_Controller {
	
	public $mod_view;
	public $meta_title;
	public $_key;
	public $_language;
	public $lang_line;

	public function __construct() 
	{
		parent::__construct();

		$this->CI =& get_instance();
		
		if ( $this->settings->website('member_registration') == 'N' )
		{
			show_404();
		}
		
		elseif ( login_status('member') == FALSE )
		{
			redirect(member_url('login'), 'refresh');
		}
		
		else
		{
			$this->_key = login_key('member');
			$this->_language = strtolower($this->set_language());
			$this->datatable_lang = content_url('plugins/datatable/lang/'.$this->_language.'.json');
			
			$this->lang->load('main', $this->_language);
			$this->lang->load('member', $this->_language);
			
			$this->meta_title();

			$this->form_validation->set_error_delimiters('<div>*) ', '.</div>');
		}
	}
	

	public function meta_title($param = '')
	{
		$title = !empty($param) ? lang_line('ci_member').' - '.$param : lang_line('ci_member');
		$this->meta_title = $title;
		return $this;
	}


	public function load_content()
	{
		if ($this->mod_view && file_exists(VIEWPATH."member/$this->mod_view.php"))
		{
			$this->load->view('member/'.$this->mod_view);
		}
		else
		{
			show_404();
		}
	}


	public function render_view($view = '', $var = '', $parm = FALSE)
	{
		$this->mod_view = $view;
		$this->load->view('member/index', $var, $parm);
	}


	public function render_400()
	{
		$this->mod_view = 'error400';
		$this->load->view('member/index');
	}


	public function render_403()
	{
		$this->mod_view = 'error403';
		$this->load->view('member/index');
	}


	public function render_404()
	{
		$this->mod_view = 'error404';
		$this->load->view('member/index');
	}


	public function json_output($parm)
	{
		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($parm, JSON_HEX_APOS | JSON_HEX_QUOT))
			 ->_display();
		exit();
	}


	public function menu_class($mod='home')
	{
		$class = ( $this->mod == $mod ? 'active' : '' );
		return $class;
	}
} // End class.