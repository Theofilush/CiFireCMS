<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {

	private $table = 't_setting';

	public function __construct()
	{
		parent::__construct();
	}

	public function update($options = '',$data)
	{
		return $this->db->where('options', $options)->update($this->table, $data);
	}
} // End class.