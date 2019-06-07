<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

	public $vars;

	public function __construct()
	{
		parent::__construct();
	}

	public function get_headline()
	{
		$query = $this->db
			->select('
				t_post.title AS post_title,
				t_post.seotitle AS post_seotitle,
				t_post.picture,
				t_post.datepost,
				t_post.timepost,
				t_category.title AS category_title
			')
			->join('t_category', 't_category.id = t_post.id_category', 'LEFT')
			->where('t_post.active', 'Y')
			->where('t_post.headline', 'Y')
			->order_by('t_post.id','RANDOM')
			->get('t_post')
			->result_array();
		return $query;
	}


	public function posts_section_1()
	{
		$query = $this->db
			->select('*,
			         t_post.id             as   post_id,
			         t_post.id_category    as   post_id_category,
			         t_post.title          as   post_title, 
			         t_post.seotitle       as   post_seotitle, 
			         t_post.datepost       as   post_datepost, 
			         t_post.timepost       as   post_timepost, 
			         t_post.picture        as   post_picture, 
			         t_post.hits           as   post_hits,

			         t_category.id         as   category_id, 
			         t_category.title      as   category_title, 
			         t_category.seotitle   as   category_seotitle
			')
			->from('t_post')
			->join('t_category', 't_category.id = t_post.id_category', 'left')
			->where('t_post.active', 'Y')
			->order_by('RAND()')
			->limit(3)
			->get()
			->result_array();
		return $query;
	}


	public function posts_section_2($type='')
	{
		$query = $this->db->select('*,
			         t_post.id             as   post_id,
			         t_post.id_category    as   post_id_category,
			         t_post.title          as   post_title, 
			         t_post.seotitle       as   post_seotitle,
			         t_post.datepost       as   post_datepost, 
			         t_post.timepost       as   post_timepost, 
			         t_post.picture        as   post_picture, 
			         t_post.hits           as   post_hits,

			         t_category.id         as   category_id, 
			         t_category.title      as   category_title, 
			         t_category.seotitle   as   category_seotitle
			');
		$query = $this->db->from('t_post');
		$query = $this->db->join('t_category', 't_category.id = t_post.id_category', 'left');
		$query = $this->db->where('t_post.active', 'Y');
		$query = $this->db->order_by('RAND()');

		switch ($type) 
		{
			case 'a':
				$query = $this->db->limit(1);
				$query = $this->db->get();
				$result = $query->result_array();
			break;

			case 'b':
				$query = $this->db->limit(4);
				$query = $this->db->get();
				$result = $query->result_array();
			break;		
		}
			return $result;
	}


	public function posts_section_3()
	{
		$query = $this->db->select('
			         t_post.id             as   post_id,
			         t_post.id_category    as   post_id_category,
			         t_post.title          as   post_title, 
			         t_post.seotitle       as   post_seotitle, 
			         t_post.content        as   post_content,
			         t_post.datepost       as   post_datepost, 
			         t_post.timepost       as   post_timepost, 
			         t_post.picture        as   post_picture, 
			         t_post.hits           as   post_hits,

			         t_category.id         as   category_id, 
			         t_category.title      as   category_title, 
			         t_category.seotitle   as   category_seotitle
			');
		$query = $this->db->from('t_post');
		$query = $this->db->join('t_category', 't_category.id = t_post.id_category', 'left');
		$query = $this->db->where('t_post.active', 'Y');
		$query = $this->db->order_by('RAND()');

		$query = $this->db->limit(6);
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}


	public function posts_sidebar()
	{
		$query = $this->db->select('
			         t_post.id             as   post_id,
			         t_post.id_category    as   post_id_category,
			         t_post.title          as   post_title, 
			         t_post.seotitle       as   post_seotitle, 
			         t_post.content        as   post_content,
			         t_post.datepost       as   post_datepost, 
			         t_post.timepost       as   post_timepost, 
			         t_post.picture        as   post_picture, 
			         t_post.hits           as   post_hits,

			         t_category.id         as   category_id, 
			         t_category.title      as   category_title, 
			         t_category.seotitle   as   category_seotitle
			');
		$query = $this->db->from('t_post');
		$query = $this->db->join('t_category', 't_category.id = t_post.id_category', 'left');
		$query = $this->db->where('t_post.active', 'Y');
		$query = $this->db->order_by('RAND()');

		$query = $this->db->limit(8);
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}

} // End Class