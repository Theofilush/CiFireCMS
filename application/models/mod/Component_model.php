<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Component_model extends CI_Model {

	public $vars;
	private $_table = 't_component';
	private $_column_order = array('name', 'type', 'status');
	private $_column_search = array('id', 'name');

	public function __construct()
	{
		parent::__construct();
	}


	private function _datatable_query()
	{
		$this->db->from($this->_table);

		$i = 0;	
		foreach ($this->_column_search as $item) 
		{
			if ( $this->input->post('search')['value'] )
			{
				if ( $i === 0 )
				{
					$this->db->group_start();
					$this->db->like($item, $this->input->post('search')['value']);
				}
				else
				{
					$this->db->or_like($item, $this->input->post('search')['value']);
				}

				if ( count($this->_column_search) - 1 == $i ) 
				{
					$this->db->group_end(); 
				}
			}
			$i++;
		}
		
		if ( !empty($this->input->post('order')) ) 
		{
			$this->db->order_by(
				$this->_column_order[$this->input->post('order')['0']['column']], 
				$this->input->post('order')['0']['dir']
			);
		}
		else
		{
			$this->db->order_by('id','DESC');
		}
	}


	public function get_datatables()
	{
		$this->_datatable_query();

		if ( $this->input->post('length') != -1 ) 
		{
			$this->db->limit($this->input->post('length'), $this->input->post('start'));
			$query = $this->db->get();
		}
		else
		{
			$query = $this->db->get();
		}
		
		return $query->result_array();
	}


	public function count_filtered()
	{
		$this->_datatable_query();
		$query = $this->db->get();
		return $query->num_rows();
	}


	public function count_all()
	{
		$this->db->from($this->_table);
		return $this->db->count_all_results();
	}


	public function get_modul($id = 0)
	{
		if ( $this->cek_id($id) == 1 )
		{
			$query = $this->db->where('id',$id)->get($this->_table)->row_array();
			return $query;
		}
		else 
			return FALSE;
	}


	public function insert($data)
	{
		$query = $this->db->insert($this->_table, $data);
		
		if ( $query == FALSE )
			return FALSE;
		else
			return TRUE;
	}


	public function delete($id = 0, $table_name = '')
	{
		if ( !empty($table_name) && $this->cek_id($id) == 1 ) 
		{
			$this->load->dbforge();
			if ( $this->dbforge->drop_table($table_name, TRUE) )
			{
				$this->db->where('id', $id)->delete($this->_table);
				return TRUE;
			}
			else return FALSE;
			
		}
		else return FALSE;
	}


	public function cek_id($id = 0)
	{
		$query = $this->db->select('id');
		$query = $this->db->where('id', $id);
		$query = $this->db->get($this->_table);
		$query = $query->num_rows();
		$int = (int)$query;
		return $int;
	}
} // End Class.