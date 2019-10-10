<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Member_login_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}


	public function cek_email($email = '')
	{
		$dataEmail = decrypt($email);
		$query = $this->db->select('id');
		$query = $this->db->where("BINARY email = '".$dataEmail."'", NULL, FALSE);
		$query = $this->db->where('level','4');
		$query = $this->db->where('active','Y');
		$query = $this->db->get('t_user');
		return $query->num_rows();
	}


	public function cek_reg_email($email = '')
	{
		$dataEmail = decrypt($email);
		$query = $this->db->select('id');
		$query = $this->db->where("BINARY email = '".$dataEmail."'", NULL, FALSE);
		$query = $this->db->get('t_user');
		$result = $query->num_rows();

		if ( $result == 1 )
			return FALSE;
		else
			return TRUE;
	}


	public function cek_login($input)
	{
		$query = $this->db->where("BINARY email = '".$input['email']."'", NULL, FALSE);
		$query = $this->db->where('level','4');
		$query = $this->db->where('active','Y');
		$query = $this->db->get('t_user');

		if ($query->num_rows() == 1)
		{
			$userdata = $query->row_array();

			if (decrypt($userdata['password']) == decrypt($input['password']))
				return TRUE;
			else
				return FALSE;
		}
		else
		{
			return FALSE;
		}
	}


	public function get_user($input)
	{
		$query = $this->db->where("BINARY email = '".$input['email']."'", NULL, FALSE);
		$query = $this->db->where('level','4');
		$query = $this->db->where('active','Y');
		$query = $this->db->get('t_user');
		$query = $query->row_array();
		return $query;
	}


	public function insert_member(array $data)
	{
		return $this->db->insert('t_user', $data);
	}
} // End class.