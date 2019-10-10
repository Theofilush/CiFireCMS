<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pages_model extends CI_Model {

	private $_table = 't_pages';
	private $_column_order = array(null, 'title','seotitle','active');
	private $_column_search = array('title');

	public function __construct()
	{
		parent::__construct();
	}


	private function _datatable_query()
	{
		$this->db->select('*');
		$this->db->from($this->_table);

		$i = 0;	
		foreach ($this->_column_search as $item) 
		{
			if ( $this->input->post('search')['value'] )
			{
				if ( $i == 0 )
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
			$this->db->order_by('id', 'DESC');
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


	public function insert($data)
	{
		$query = $this->db->insert($this->_table, $data);
		return $query;
	}


	public function update($id, $data)
	{
		$query = $this->db->where('id', $id);
		$query = $this->db->update($this->_table, $data);
		return $query;
	}


	public function delete($id)
	{
		if ( $this->cek_id($id) > 0 ) 
		{
			$query = $this->db->where('id', $id);
			$query = $this->db->delete($this->_table);
			return TRUE;
		}
		else
			return FALSE;
	}


	public function get_pages($id) 
	{
		$query = $this->db->where('id', $id);
		$query = $this->db->get($this->_table);
		$query = $query->row_array();
		return $query;
	}


	public function cek_id($id=0)
	{
		$query = $this->db->select('id');
		$query = $this->db->where('id', $id);
		$query = $this->db->get($this->_table);
		$result = $query->num_rows();
		$int = (int)$result;
		return $int;
	}
	

	public function cek_seotitle($seotitle)
	{
		$query = $this->db
			     ->where('seotitle',$seotitle)
			     ->get($this->_table)
			     ->num_rows();
		return $query;
	}


	public function cek_seotitle2($id, $seotitle)
	{
		$query = $this->db
			     ->select('id,seotitle')
			     ->where('seotitle', $seotitle)
			     ->get($this->_table);

		if (
		    $query->num_rows() == '1' && 
		    $query->row_array()['id'] == $id || 
		    $query->num_rows() != '1'
		   ) 
		{
			return TRUE;
		}
		else 
			return FALSE;
	}
} // End class.