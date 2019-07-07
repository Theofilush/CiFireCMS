<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_model extends CI_Model {
	
	private $table = 't_theme';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param 	array 	$data
	 * @return 	void
	*/
	public function insert(array $data)
	{
		$this->db->insert($this->table, $data);
	}


	/**
	 * @param 	int|string 	$id
	 * @param 	array 		$data
	 * @return 	bool
	*/
	public function update($id = 0, array $data)
	{
		if ( $this->cek_id($id) == 1 )
		{
			$this->db->where('id', $id)->update($this->table, $data);
			return TRUE;
		}
		else
			return FALSE;
	}


	/**
	 * delete()
	 * @param 	int|string 	$id
	 * @return 	bool
	*/
	public function delete($id = 0)
	{
		if ( $this->cek_id($id) == 1 ) 
		{
			$this->db->where('id', $id)->delete($this->table);
			return TRUE;
		}
		else
			return FALSE;
	}


	/**
	 * active_theme()
	 * @param 	int|string 	$id
	 * @return 	bool
	*/
	public function active_theme($id = 0)
	{
		if ( $this->cek_id($id) == 1 ) 
		{		
			$get_active_theme = $this->db->where('active', 'Y')->get($this->table)->row_array();
			$id_theme_active = $get_active_theme['id'];

			if ( $this->update($id_theme_active, array('active'=>'N')) )
			{
				$this->update($id, array('active'=>'Y'));
				return TRUE;
			}
			else 
				return FALSE;
		}
		else 
			return FALSE;
	}


	/**
	 * @return 	array
	*/
	public function all_themes() 
	{
		$query = $this->db->order_by('id', 'DESC');
		$query = $this->db->get($this->table);
		$result = $query->result_array();
		return $result;
	}

	/**
	 * @param 	int|string 	$id
	 * @return 	array|NULL
	*/
	public function get_theme($id = 0) 
	{
		if ( $this->cek_id($id) == 1 )
		{		
			$query = $this->db->where('id', $id);
			$query = $this->db->get($this->table);
			$result = $query->row_array();
			return $result;
		}
		else
			return NULL;
	}


	/**
	 * @param 	int|string 	$id
	 * @return 	int
	*/
	public function cek_id($id = 0)
	{
		if ( empty($id) || $id==0 )
			return 0;
		
		else
		{
			$query = $this->db->select('id');
			$query = $this->db->where('id',$id);
			$query = $this->db->get($this->table);
			$result = $query->num_rows();

			if ( $result == 1 )
				return $result;
			else
				return 0;
		}
	}


	public function cek_theme_folder($param = '')
	{
		$query = $this->db->select('folder')->where('folder', $param)->get($this->table)->num_rows();

		if ( $query == 0 )
			return TRUE;
		else
			return FALSE;
	}


	/**
	 * @return bool
	*/
	public function cek_seotitle($seotitle = '')
	{
		if ( !empty($seotitle) )
		{
			$query = $this->db->select('seotitle');
			$query = $this->db->where("BINARY seotitle = '$seotitle'", NULL, FALSE);
			$query = $this->db->get($this->table);
			$query = $query->num_rows();

			if ( $query == 0 ) 
				return TRUE;
			else 
				return FALSE;
		}
		else
			return FALSE;
	}

	/**
	 * @return bool
	*/
	public function cek_seotitle2($id = 0, $seotitle = '')
	{
		if ( $id != 0 && !empty($id) && !empty($seotitle) )
		{
			$query = $this->db->select('id,seotitle');
			$query = $this->db->where("BINARY seotitle = '$seotitle'", NULL, FALSE);
			$query = $this->db->get($this->table);

			if (
			    $query->num_rows() == 1 && 
			    $query->row_array()['id'] == $id || 
			    $query->num_rows() != 1
			   ) 
			{
				return TRUE;
			}
			else
				return FALSE;
		}
		else
			return FALSE;
	}
} // End class.