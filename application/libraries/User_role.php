<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_role {

	public function __construct()
	{
		$this->CI =& get_instance();
	} 


	public function access($level, $module, $mode)
	{
		$user_role = $this->CI->db
			->where('level',$level)
			->where('module',$module)
			->get('t_user_role')
			->row_array();

		$user_level = $this->CI->db
			->where('id', $level)
			->get('t_user_level')
			->row_array();

		if ($level === '1' || $user_level['level'] === 'super-admin') 
		{
			return TRUE;
		}

		if ($user_role[$mode] === 'Y') 
		{
			return TRUE;
		}
		
		return FALSE;
	}
} // End class