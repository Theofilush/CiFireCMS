<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag_model extends CI_Model {

	private $_table = 't_tag';
	private $_column_order = array(null,'title','tag_count');
	private $_column_search = array('t_tag.title');

	public function __construct()
	{
		parent::__construct();
	}


	private function _datatable_query()
	{
		$this->db->select('
		                  t_tag.*, 
		                  COUNT(t_post.id) AS tag_count
		                  ');
		
		$this->db->from($this->_table);

		$this->db->join('t_post', "t_post.tag LIKE CONCAT('%',t_tag.seotitle,'%')", 'LEFT');

		$i = 0;	
		foreach ($this->_column_search as $item) 
		{
			if ($this->input->post('search')['value'])
			{
				if ($i === 0)
				{
					$this->db->group_start();
					$this->db->like($item, $this->input->post('search')['value']);
				}
				else
				{
					$this->db->or_like($item, $this->input->post('search')['value']);
				}

				if (count($this->_column_search) - 1 == $i) 
				{
					$this->db->group_end(); 
				}
			}
			$i++;
		}
		
		if (!empty($this->input->post('order'))) 
		{
			$this->db->order_by(
				$this->_column_order[$this->input->post('order')['0']['column']], 
				$this->input->post('order')['0']['dir']
			);
		}
		else
		{
			$this->db->order_by('t_tag.id', 'DESC');
		}

		$this->db->group_by('t_tag.id');
	}


	function get_datatables()
	{
		$this->_datatable_query();

		if ($this->input->post('length') != -1) 
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


	function count_filtered()
	{
		$this->_datatable_query();
		$query = $this->db->get();
		return $query->num_rows();
	}


	public function count_all()
	{
		$query = $this->db->from($this->_table)->count_all_results();
		return $query;
	}

	
	public function insert($data)
	{
		$this->db->insert($this->_table, $data);
	}


	public function update($id,$data)
	{
		$this->db->where('id', $id)->update($this->_table, $data);
	}


	public function delete($id)
	{
		if ($this->cek_id($id) > 0) 
		{
			$this->db->where('id', $id);
			$this->db->delete($this->_table);
			return TRUE;
		}
		else
		{
			return FALSE;	
		}
	}


	public function get_tags($id) 
	{
		$query = $this->db->where('id',$id)->get($this->_table)->row_array();
		return $query;
	}


	public function cek_seotitle($seotitle)
	{
		$num_rows = $this->db
			->where('seotitle', $seotitle)
			->get($this->_table)
			->num_rows();

		if ($num_rows == 0)
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}


	public function cek_seotitle2($id, $seotitle)
	{
		$query = $this->db->where('seotitle', $seotitle)->get($this->_table);
		
		if ($query->num_rows() == 1 && $query->row_array()['id'] == $id || $query->num_rows() != 1) 
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}


	public function cek_id($id)
	{
		$num_rows = $this->db->where('id', $id)->get($this->_table)->num_rows();

		if ($num_rows < 1)
		{
			$num_rows = 0;
		}
		
		return $num_rows;
	}
} // End class.