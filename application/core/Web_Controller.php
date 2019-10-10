<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Web_Controller extends MY_Controller {

	public function __construct() 
	{
		parent::__construct();
		
		$this->CI =& get_instance();

		if ( $this->settings->website('maintenance') == 'Y' ) 
		{
			redirect(site_url('maintenance'), 'refresh');
		}
		else 
		{
			$this->_language = strtolower($this->set_language());
			$this->CI->config->set_item('language', $this->_language);

			$this->set_cache();
			$this->set_meta();

			$this->load->model('web/index_model');
			$this->theme_folder = theme_active('folder');
		}

		$this->form_validation->set_error_delimiters('<div>*&nbsp; ', '</div>');
		
		// Visitors.
		if ( $this->settings->website('visitors') == 'Y' )
		{
			$this->get_visitors();
		} 
	}


	public function theme_asset($asset = '')
	{
		return content_url("themes/$this->theme_folder/$asset");
	}
	

	public function render_view($file = '', $data = NULL, $parm = FALSE)
	{
		if ( file_exists(VIEWPATH.'themes/'.$this->theme_folder.'/'.$file.'.php') )
		{
			$this->load->view("themes/$this->theme_folder/$file", $data, $parm);
		}
		else
		{
			show_404();
		}
	}


	public function render_404()
	{
		if ( file_exists(VIEWPATH."themes/$this->theme_folder/404.php") )
		{
			$this->meta_title('404 Page Not Found');
			$this->meta_description('The page you requested was not found.');
			$this->load->view("themes/$this->theme_folder/404");
		}
		else
		{
			show_404();
		}
	}


	public function load_menu($group_id = '', $ul = '', $ul_li = '', $ul_li_a ='', $ul_li_a_ul = '')
	{
		echo $this->menu->front_menu($group_id, $ul, $ul_li, $ul_li_a, $ul_li_a_ul);
		$this->menu->clear();
	}
} // End class.