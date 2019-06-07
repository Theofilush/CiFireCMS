<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $vars;
	public $mod;

	public $meta_url;
	public $meta_site_name;
	public $meta_title;
	public $meta_keywords;
	public $meta_description;
	public $meta_image;
	
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

	
	public function set_meta()
	{
		$parm = func_get_args();
		// meta_title
		$this->meta_title = !empty($parm[0]['title']) ? $parm[0]['title'].' - '.$this->settings->website('web_name') : $this->settings->website('web_name');
		// meta_keywords
		$this->meta_keywords = !empty($parm[0]['keywords']) ? $parm[0]['keywords'] : $this->settings->website('meta_keyword');
		// meta_description
		$this->meta_description = !empty($parm[0]['description']) ? $parm[0]['description'] : $this->settings->website('meta_description');
		// meta_image
		$this->meta_image = !empty($parm[0]['image']) ? $parm[0]['image'] : favicon('logo');

		return $this;	
	}


	public function set_cache()
	{
		if ($this->settings->website('cache') == 'Y')
			return $this->output->cache($this->settings->website('cache_time'));
	}


	public function json_output($parm)
	{
		// ->set_output(json_encode($parm, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($parm, JSON_HEX_APOS | JSON_HEX_QUOT))
			 ->_display();
		exit();
	}

	public function get_visitors() 
	{
		$this->load->library('user_agent');
		
		$ipinfo        = json_decode(@file_get_contents("https://ipinfo.io/"));
		$ipvi          = !empty($ipinfo->ip) ? $ipinfo->ip : $this->input->ip_address();
		$country       = !empty($ipinfo->country) ? $ipinfo->country : "Others";
		$city          = !empty($ipinfo->city) ? $ipinfo->city : "Others";
		// $country       = "Others";
		// $city          = "Others";
		// $ipvi          = $this->input->ip_address();
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

		if ($totalvi < 1) 
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

}

require_once 'Web_Controller.php';
require_once 'Admin_Controller.php';
require_once 'Member_Controller.php';