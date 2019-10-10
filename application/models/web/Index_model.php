<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Index_model extends CI_Model {

	public $vars;

	public function __construct()
	{
		parent::__construct();
	}

	public function index_post($batas, $posisi)
	{
		$query = $this->db
			->select('
					 t_post.id            AS  post_id,
					 t_post.title         AS  post_title,
					 t_post.seotitle      AS  post_seotitle,
					 t_post.active        AS  post_active,
					 t_post.content,
					 t_post.picture,
			         t_post.datepost,
			         t_post.timepost,
			         t_post.tag,
			         t_post.hits,
					 t_category.id        AS  category_id,
					 t_category.title     AS  category_title,
					 t_category.seotitle  AS  category_seotitle,
					 t_user.id            AS  user_id,
					 t_user.name          AS  user_name,
					')
			->join('t_category', 't_category.id = t_post.id_category', 'left')
			->join('t_user', 't_user.id = t_post.id_user', 'left')
			->where('t_post.active', 'Y')
			->order_by('t_post.id', 'DESC')
			->limit($batas, $posisi)
			->get('t_post');

		return $query->result_array();
	}


	public function total_post()
	{
		$query = $this->db->select('id');
		$query = $this->db->where('active', 'Y');
		$query = $this->db->get('t_post');
		return $query->num_rows();
	}


	public function get_post_lmit_by_category($id_category = '', array $limit)
	{
		$query = $this->db
			->select('
			         t_post.title         AS  post_title,
			         t_post.seotitle      AS  post_seotitle,
			         t_post.picture,
			         t_post.datepost,
			         t_post.timepost,
			         t_post.content,
			         t_category.id        AS  category_id,
			         t_category.title     AS  category_title,
			         t_category.seotitle  AS  category_seotitle
			         ')
			->from('t_post')
			->join('t_category', 't_category.id=t_post.id_category', 'LEFT')
			->where('t_post.active', 'Y')
			->where('t_post.id_category', $id_category)
			->or_where('t_category.id_parent', $id_category)
			->order_by('t_post.id','DESC');

		if ( count($limit) == 1 )
		{
			$query = $this->db->limit($limit[0]);
		}
		else 
		{
			$query = $this->db->limit($limit[0], $limit[1]);
		}

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
		{
			$result = $query->result_array();
		}
		
		if ( $param == 'row' )
		{
			$result = $query->row_array();
		}

		return $result;
	}
} // End class.