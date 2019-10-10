<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model {

	public $vars;

	public function __construct()
	{
		parent::__construct();
	}


	public function Search($kata, $sort, $batas, $posisi)
	{
		$pisah_kata = explode(" ",$kata);
		$jml_kata = (integer)count($pisah_kata)-1;

		$query = $this->db->select('*');
		$query = $this->db->from('t_post');

		for ($i=0; $i<=$jml_kata; $i++)
		{
			$query = $this->db->or_group_start();
			$query = $this->db->like('title', $pisah_kata[$i]);
			$query = $this->db->or_like('content', $pisah_kata[$i]);
			$query = $this->db->or_like('tag', $pisah_kata[$i]);
			$query = $this->db->group_end();
			
			$query = $this->db->where('active', 'Y');
		}

		$query = $this->db->order_by('id', 'DESC');
		$query = $this->db->limit($batas,$posisi);
		$query = $this->db->get();

		$result = $query->result_array();

		return $result;
	}


	public function jml_data($kata)
	{
		$pisah_kata = explode(" ",$kata);
		$jml_kata = (integer)count($pisah_kata)-1;

		$query = $this->db->select('id');
		$query = $this->db->from('t_post');

		for ($i=0; $i<=$jml_kata; $i++)
		{
			$query = $this->db->or_group_start();
			  $query = $this->db->like('title', $pisah_kata[$i]);
			  $query = $this->db->or_like('content', $pisah_kata[$i]);
			  $query = $this->db->or_like('tag', $pisah_kata[$i]);
			$query = $this->db->group_end();
			
			$query = $this->db->where('active', 'Y');
		}

		$query = $this->db->get();

		$result = $query->num_rows();
		
		return $result;
	}
} // End Class