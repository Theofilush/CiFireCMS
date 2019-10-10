<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $vars;
	public $mod;
	public $meta_url;
	public $meta_site_name;
	public $meta_title;
	public $meta_keywords;
	public $meta_description;
	public $meta_image;
	public $read_access;
	public $write_access;
	public $modify_access;
	public $delete_access;

	public function __construct()
	{
		parent::__construct();
		$this->CI =& get_instance();

		$this->load->helper(array(
			'inflector',
			'form',
			'html',
			'security',
			'string',
			'file',
			'directory',
			'download',
			'text'
		));

		$this->load->library(array(
			'user_role',
			'alert',
			'menu'
		));
	}


	/**
	 * - Fungsi ini digunakan untuk menentukan role access user berdasarkan level.
	 * @return void
	*/
	public function set_access()
	{
		$this->read_access = $this->user_role->access(login_level('admin'), $this->mod, 'read_access');
		$this->write_access = $this->user_role->access(login_level('admin'), $this->mod, 'write_access');
		$this->delete_access = $this->user_role->access(login_level('admin'), $this->mod, 'delete_access');
		$this->modify_access = $this->user_role->access(login_level('admin'), $this->mod, 'modify_access');
		return $this;
	}


	/**
	 * - Fungsi ini digunakan untuk menentukan role access secara keseluruhan,
	 * @return void
	*/
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


	/**
	 * - Fungsi ini digunakan untuk menentukan bahasa.
	 * @return void | string
	*/
	public function set_language()
	{
		if ( isset($this->session->lang_active) )
		{
			$langActive = strtolower($this->session->lang_active);
			$this->CI->config->set_item('language', $langActive);
		}
		else
		{
			$langActive = strtolower($this->CI->global_model->lang());
			$this->CI->config->set_item('language', $langActive);
			$session['lang_active'] = $langActive;
			$this->session->set_userdata($session);
		}
		
		return $langActive;
	}


	/**
	 * - Fungsi ini digunakan untuk menentukan meta pada view.
	 * @return void
	*/
	public function set_meta()
	{
		$param = func_get_args();

		// meta_title
		$meta_title = ( !empty($param[0]['title']) ? $param[0]['title'] : $this->settings->website('web_name') );
		$this->meta_title($meta_title);

		// meta_keywords
		$meta_keywords = ( !empty($param[0]['keywords']) ? $param[0]['keywords'] : $this->settings->website('meta_keyword') );
		$this->meta_keywords($meta_keywords);

		// meta_description
		$meta_description = ( !empty($param[0]['description']) ? $param[0]['description'] : $this->settings->website('meta_description') );
		$this->meta_description($meta_description);

		// meta_image
		$meta_image = ( !empty($param[0]['image']) ? $param[0]['image'] : favicon('web_image') );
		$this->meta_image($meta_image);

		return $this;
	}


	/**
	 * - Fungsi ini digunakan untuk menentukan meta title pada view.
	 * @return void
	*/
	public function meta_title($param = NULL)
	{
		$this->meta_title = $param;
		return $this;
	}


	/**
	 * - Fungsi ini digunakan untuk menentukan meta keyword pada view.
	 * @return void
	*/
	public function meta_keywords($param = NULL)
	{
		$this->meta_keywords = $param;
		return $this;
	}


	/**
	 * - Fungsi ini digunakan untuk menentukan meta description pada view.
	 * @return void
	*/
	public function meta_description($param = NULL)
	{
		$this->meta_description = $param;
		return $this;
	}


	/**
	 * - Fungsi ini digunakan untuk menentukan meta image pada view.
	 * @return void
	*/
	public function meta_image($param = NULL)
	{
		$this->meta_image = $param;
		return $this;
	}


	/**
	 * - Fungsi untuk set cache.
	 * @return void
	*/
	public function set_cache()
	{
		$output = NULL;
		if ( $this->settings->website('cache') == 'Y' )
		{
			$output = $this->output->cache($this->settings->website('cache_time'));
		}
		return $output;
	}


	public function captcha()
	{
		if ($this->settings->website('captcha') == 'Y')
			return TRUE;
		else
			return FALSE;
	}


	/**
	 * - Fungsi ini digunakan untuk output json.
	 * @return void | string | json
	*/
	public function json_output($parm)
	{
		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($parm, JSON_HEX_APOS | JSON_HEX_QUOT))
			 ->_display();
		exit();
	}


	/**
	 * - Fungsi ini digunakan untuk mencatat pengunjung.
	 * @return void
	*/
	public function get_visitors() 
	{
		$this->load->library('user_agent');
		
		$ipinfo        = json_decode(@file_get_contents("https://ipinfo.io/"));
		$ipvi          = !empty($ipinfo->ip) ? $ipinfo->ip : $this->input->ip_address();
		$country       = !empty($ipinfo->country) ? $ipinfo->country : "Others";
		$city          = !empty($ipinfo->city) ? $ipinfo->city : "Others";
		// $country    = "Others";
		// $city       = "Others";
		// $ipvi       = $this->input->ip_address();
		$os_stat       = $this->input->user_agent();
		$platform_stat = $this->agent->platform();
		$browser_stat  = $this->agent->browser();
		$datestat      = date("Y-m-d");
		$timestat      = time();
		$url           = $_SERVER['REQUEST_URI'];

		$totalvi = $this->db
			->where('ip', $ipvi)
			->where('date', $datestat)
			->where('url', $url)
			->get('t_visitor')
			->num_rows();

		if ( $totalvi < 1 ) 
		{
			$this->db->insert('t_visitor', array(
				'ip'       => $ipvi,
				'platform' => $platform_stat,
				'os'       => $os_stat,
				'browser'  => $browser_stat,
				'country'  => $country,
				'city'     => $city,
				'date'     => $datestat,
				'hits'     => 1,
				'url'      => $url 
			));
		}
		else 
		{
			$statpro = $this->db
				->where('ip', $ipvi)
				->where('date', $datestat)
				->where('url', $url)
				->get('t_visitor')
				->row_array();

			$hitspro = $statpro['hits'] + 1;

			$data_update = array(
				'platform' => $platform_stat,
				'os'       => $os_stat,
				'browser'  => $browser_stat,
				'country'  => $country,
				'city'     => $city,
				'hits'     => $hitspro,
				'online'   => $timestat,
				'url'      => $url
			);

			$this->db->where('ip', $ipvi)
					 ->where('date', $datestat)
					 ->where('url', $url)
					 ->update('t_visitor', $data_update);
		}
	}
} // End class.

require_once 'Web_Controller.php';
require_once 'Admin_Controller.php';
require_once 'Member_Controller.php';