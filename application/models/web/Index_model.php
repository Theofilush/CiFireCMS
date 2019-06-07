<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}



	public function get_post_lmit_by_category($id_category = '', array $limit)
	{
		$query = $this->db
			->select('
			         t_post.title AS post_title,
			         t_post.seotitle AS post_seotitle,
			         t_post.picture,
			         t_post.datepost,
			         t_post.timepost,
			         t_post.content,

			         t_category.id AS category_id,
			         t_category.title AS category_title,
			         t_category.seotitle AS category_seotitle
			         ')
			->from('t_post')
			->join('t_category', 't_category.id=t_post.id_category', 'LEFT')
			->where('t_post.active', 'Y')
			->where('t_post.id_category', $id_category)
			->order_by('t_post.id','DESC');

		if ( count($limit) == 1 )
			$query = $this->db->limit($limit[0]);
		else
			$query = $this->db->limit($limit[0], $limit[1]);

		$query = $this->db->get();
		$result = $query->result_array();

		return $result;
	}

	public function get_category_by($col = 'id', $val = '1', $param = 'row')
	{
		$query = $this->db->where($col, $val);
		$query = $this->db->order_by('id', 'DESC');
		$query = $this->db->get('t_category');

		if ( $param == 'result' )
			$result = $query->result_array();
		if ( $param == 'row' )
			$result = $query->row_array();

		return $result;
	}


} // End Class