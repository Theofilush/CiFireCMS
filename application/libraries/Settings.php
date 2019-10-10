<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings {
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->_default_timezone();
	}


	protected function _default_timezone() 
	{
		$default_timezone = (! empty(config_item('timezone'))) ? config_item('timezone') : $this->website('timezone');
		date_default_timezone_set($default_timezone);
	}


	public function theme($param='') 
	{
		$query = $this->CI->db->where('active', 'Y')->get('t_theme');
		
		if ($query->num_rows() !== 1)
			show_error('Template not found','','Error');

		$folder = $query->row_array()[$param];
		return $folder;
	}


	public function website($param = '')
	{
		if ($param == 'language') 
		{
			$query = $this->CI->db
				->select('value')
				->where('options', 'language')
				->get('t_setting')
				->row_array();
			$lang = $this->CI->db
				->where('id', $query['value'])
				->get('t_language')
				->row_array();
			$result = $lang['title'];
		}
		elseif ($param == 'lang_id') 
		{
			$query = $this->CI->db
				->select('value')
				->where('options', 'language')
				->get('t_setting')
				->row_array();
			$lang = $this->CI->db
				->where('id', $query['value'])
				->get('t_language')
				->row_array();
			$result = $lang['id'];
		}
		else 
		{
			$query = $this->CI->db
				->select('value')
				->where('options', $param)
				->get('t_setting')
				->row_array();
			$result = $query['value'];
		}

		return $result;
	}
	

	public function email_config()
	{
		$email_config = array(
			'useragent' => $this->website('web_name'),
			'protocol'  => $this->website('protocol'),
			'smtp_host' => $this->website('hostname'),
			'smtp_port' => $this->website('port'),
			'smtp_user' => $this->website('username'),
			'smtp_pass' => decrypt($this->website('password')),
			// 'smtp_crypto' => 'ssl',
			'smtp_timeout' => 10,
			'newline'   => "\r\n",
			'crlf'      => "\r\n",
			'mailtype'  => 'html',
			'charset'   => 'iso-8859-1', // iso-8859-1 or utf-8
			'wordwrap'  => TRUE
		);

		return $email_config;
	}


	public function lang_active($param = 'english')
	{
		$lang_id = $this->website('lang_id');

		$lang = $this->CI->db->where('id', $lang_id);
		$lang = $this->CI->db->get('t_language');
		$lang = $lang->row_array();

		$result = $lang[$param];

		return $result;
	}
} // End Class.