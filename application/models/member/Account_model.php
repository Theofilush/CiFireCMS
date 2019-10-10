<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends CI_Model {

	private $_table = 't_user';
	private $key;

	public function __construct()
	{
		parent::__construct();
		$this->key = login_key('member');
	}


	public function get_account()
	{
		$query = $this->db->select('username,email,name,gender,birthday,about,address,tlpn,photo')
			->where('id',$this->key)
			->get($this->_table)
			->row_array();
		return $query;
	}


	public function update_profile(array $data)
	{
		return $this->db->where('id', $this->key)->update($this->_table, $data);
	}


	public function delete()
	{
		return $this->db->where('id', $this->key)->delete($this->_table);
	}
} // End class.