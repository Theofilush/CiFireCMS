<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Global_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * - Fungsi insert data.
	 * @param   string  $table
	 * @param   array  	$data
	 * @return  void
	*/
	public function insert($table, array $data)
	{
		$this->db->insert($this->_table, $data);
	}


	/**
	 * - Fungsi delete data by id.
	 * @param   string  	$table
	 * @param   string|int  $id
	 * @return  bol
	*/
	public function delete_by_id($table = '', $id = '')
	{
		$cek_id = $this->cek_id($table, $id);
		
		if ( $cek_id == 1) 
		{
			$this->db->where('id', $id)->get($table);
			return TRUE;
		}
		else
			return FALSE;
	}


	/**
	 * - Fungsi untuk pengecekan data id.
	 * @param   string      $table
	 * @param   string|int  $id
	 * @return  int
	*/
	public function cek_id($table = '', $id = 0)
	{
		$int = 0;
		if ( $id!=0 && !empty($id) && !empty($table) )
		{
			$query = $this->db->where('id', $id)->get($table)->num_rows();
			
			if ( $query == 1 )
				$int = 1;
		}

		return $int;
	}


	/**
	 * - Fungsi untuk megnambil data tema yang aktif.
	 * @return  string
	*/
	public function get_theme_active()
	{
	   $query = $this->db->where('active','Y')->get('t_theme')->row_array();
	   return $query;
	}

	/**
	 * - Fungsi untuk megnambil data seting.
	 * @return  string
	*/
	public function get_setting()
	{
		$query = $this->db->get('t_setting')->row_array();
		return $query;
	}

	public function lang()
	{
		$query = $this->db
			->select('t_setting.value,t_language.seotitle')
			->from('t_setting')
			->where('t_setting.options', 'language')
			->join('t_language','t_language.id = t_setting.value', 'left')
			->get()
			->row_array();
		$result = $query['seotitle'];
		return $result;
	}


} // End class