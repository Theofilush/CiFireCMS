<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mail_model extends CI_Model {

	private $table;
	private $column_order;
	private $column_search;

	public function __construct()
	{
		parent::__construct();

		$this->table = "t_mail";
		$this->column_order = array(null, 'id', 'name', 'subject', 'date', 'active');
		$this->column_search = array('name', 'email', 'subject ', 'message');
	}


	protected function _datatable_query()
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('box','in');

		$i = 0;	
		foreach ($this->column_search as $item) // loop column 
		{
			if ( $this->input->post('search')['value'] ) // if datatable send POST for search
			{
				if ( $i === 0 ) // first loop
				{
					$this->db->group_start();
					$this->db->like($item, $this->input->post('search')['value']);
				}
				else
				{
					$this->db->or_like($item, $this->input->post('search')['value']);
				}

				// last loop
				if ( count($this->column_search) - 1 == $i )
				{
					$this->db->group_end(); //close bracket
				}
			}

			$i++;
		}
		
		if ( !empty($this->input->post('order')) ) 
		{
			$this->db->order_by(
				$this->column_order[$this->input->post('order')['0']['column']], 
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
		$query = $this->db->get()->num_rows();
		return $query;
	}


	public function count_all()
	{
		$query = $this->db->from($this->table)->count_all_results();
		return $query;
	}


	public function insert(array $data)
	{
		$this->db->insert($this->table, $data);
	}


	public function update($id = 0, array $data)
	{
		if ( $this->cek_id($id) == 1 ) 
		{
			$this->db->where('id',$id);
			$this->db->update($this->table, $data);
			return TRUE;
		}
		else
			return FALSE;
	}


	public function delete($id = 0)
	{
		if ( $this->cek_id($id) == 1 ) 
		{
			$this->db->where('id', $id);
			$this->db->delete($this->table);
			$respon = TRUE;
		}
		else
		{
			$respon = FALSE;
		}

		return $respon;
	}


	public function all_message() 
	{
		$query = $this->db->order_by('id','DESC')->get($this->table)->result_array();
		return $query;
	}


	public function get_message($id = 0) 
	{
		if ($this->cek_id($id) == 1 )
		{
			$num_row = $this->db->where('id',$id)->get($this->table)->row_array();
			return $num_row;
		}
		else
		{
			show_404();
		}
	}


	public function get_mail($id=0)
	{
		if ( $this->cek_id($id) == 1 )
			return $this->db->where('id',$id)->get($this->table)->row_array();
		else
			return NULL;
	}


	public function cek_id($id = 0)
	{
		if ( empty($id) || $id == 0 )
			return 0;
		
		else
		{		
			$query = $this->db
				->select('id')
				->where('id',$id)
				->get($this->table)
				->num_rows();

			if ( $query == 1 )
				return $query;
			else
				return 0;
		}
	}
} // End class.