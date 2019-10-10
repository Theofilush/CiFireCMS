<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Alert {

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('session');
	}


	public function set($alert_name = '', $alert_type = '', $alert_content = '') 
	{
		$session_alert = 'alert_'.$alert_name;
		$this->CI->session->set_flashdata($session_alert, array($alert_type,$alert_content));
	}


	public function alert($type = '', $content = '')
	{		
		$alert = '<div class="alert alert-'.$type.' alert-styled-left alert-arrow-left alert-dismissible"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'.$content.'</div>';
		return $alert;
	}


	public function show($alert_name = '', $type = '', $content = '') 
	{
		$sesname = 'alert_'.$alert_name;
		
		$alert = '';
		if ( !empty($this->CI->session->flashdata($sesname)) )
		{
			$ses = $this->CI->session->flashdata($sesname);
			$alert = $this->alert($ses[0], $ses[1]);
		}
		
		echo $alert;
		$this->CI->session->unset_userdata($sesname);
	}
} // End class