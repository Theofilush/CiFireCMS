<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {

	public $vars;
	private $session_level;
	private $session_key;
	private $_table = 't_post';
	private $_column_order = array(null, 't_post.title', 't_category.seotitle', 't_post.active');
	private $_column_search = array('t_post.title', 't_category.seotitle');

	public function __construct()
	{
		parent::__construct();

		$this->session_level = login_level('member');
		$this->session_key = login_key('member');
	}


	private function _datatable_query()
	{
		$this->db->select('
							t_post.id        AS post_id,
							t_post.title     AS post_title,
							t_post.seotitle  AS post_seotitle,
							t_post.headline  AS post_headline,
							t_post.hits      AS post_hits,
							t_post.datepost  AS post_datepost,
							t_post.timepost  AS post_timepost,
							t_post.active    AS post_active,
							t_post.tag       AS post_tag,
							t_category.title AS category_title,
							COUNT(t_comment.id_post) AS comments
						');
		
		$this->db->from($this->_table);
		$this->db->join('t_comment', 't_comment.id_post = t_post.id', 'left');
		$this->db->join('t_category', 't_category.id = t_post.id_category', 'left');
		$this->db->where('t_post.id_user', $this->session_key);
		
		$i = 0;
		foreach ( $this->_column_search as $item ) 
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
			$this->db->order_by('t_post.id', 'DESC');
		}
		
		$this->db->group_by('t_post.id');
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
	
		if ( $this->session_level != 0 && $this->session_level <= 2 ) 
		{
			$this->db->join('t_category', 't_category.id = t_post.id_category', 'left');
			$this->db->join('t_user', 't_user.id = t_post.id_user', 'left');
		}

		if ($this->session_level != 0 && $this->session_level > 2)
		{
			$this->db->join('t_category', 't_category.id = t_post.id_category', 'left');
			$this->db->join('t_user', 't_user.id = t_post.id_user', 'left');
			$this->db->where('t_post.id_user', $this->session_key);
		}

		return $this->db->count_all_results();
	}


	public function ajax_tags($input = '')
	{
		$query = $this->db
			->like('seotitle', $input)
			->order_by('seotitle', 'ASC')
			->get('t_tag');
		
		if ( $query->num_rows() >= 1 )
			$result = $query->result_array();
		else 
			$result = NULL;

		return $result;
	}


	public function insert_post($data)
	{
		$this->db->insert($this->_table, $data);
	}


	public function insert_tag($tag)
	{
		$tagseo = seotitle($tag);
		
		$cek_tag = $this->db->where("BINARY seotitle='$tagseo'", NULL, FALSE)->get('t_tag')->num_rows();

		if ($cek_tag === 0 && !empty($tagtitle))
		{
			$data_tag = array(
				'title' => $tagtitle,
				'seotitle' => $tagseo
			);
			$this->db->insert('t_tag', $data_tag);
		}
	}


	public function update_post($id_post, array $data)
	{
		return $this->db->where('id', $id_post)->update($this->_table, $data);
	}


	public function delete($id)
	{
		if ($this->cek_id($id) == 1) 
		{
			$this->db->where('id', $id)->delete($this->_table);
			$respon = TRUE;
		}
		else
		{
			$respon = FALSE;
		}

		return $respon;
	}


	public function get_post($id_post)
	{
		$query = $this->db
			->select('
					 t_post.id            AS post_id,
					 t_post.title         AS post_title,
					 t_post.content       AS post_content,
					 t_post.tag           AS post_tag,
					 t_post.picture,
					 t_post.image_caption,
					 t_post.comment,
					 t_post.headline,
					 t_category.id        AS category_id,
					 t_category.title     AS category_title,
					 t_category.seotitle  AS category_seotitle,
					 t_user.id            AS user_id,
					 t_user.name          AS user_name
					')
			->from($this->_table)
			->join('t_category', 't_category.id = t_post.id_category', 'left')
			->join('t_user', 't_user.id = t_post.id_user', 'left')
			->where('t_post.id', $id_post)
			->get();

		$result = $query->row_array();
		
		return $result;
	}


	public function num_comment($id)
	{
		$query = $this->db->where('id_post', $id)->get('t_comment')->num_rows();
		return $query;
	}


	public function get_all_category() 
	{
		$query = $this->db
			->select('id,title')
			->order_by('title', 'ASC')
			->get('t_category')
			->result_array();

		return $query;
	}


	public function val_cat($id)
	{
		$query = $this->db->where('id', $id)->get('t_category')->row_array();
		return $query;
	}


	public function get_all_tag() 
	{
		$query = $this->db->order_by('title', 'ASC')->get('t_tag')->result_array();
		return $query;
	}


	public function valtag($tags = '')
	{
		$tag = '';
		if ( !empty($tags) )
		{
			$arrtags = explode(',', $tags);
			foreach ($arrtags as $key) {
				$query = $this->db->select('title')->where('seotitle', $key)->get('t_tag');
				
				if ( $query->num_rows() > 0 )
					$tag .= $query->row_array()['title'].',';
			}
		}
		return rtrim($tag,',');
	}


	public function get_all_user() 
	{
		$query = $this->db
			->select('
			         t_user.id    AS user_id,
				     t_user.level AS user_level,
				     t_user.name  AS user_name,

				     t_user_level.id    AS level_id,
				     t_user_level.title AS level_title
				    ')
			->where('t_user.active', 'Y')
			->join('t_user_level', 't_user_level.id = t_user.level', 'left')
			->get('t_user')
			->result_array();
		return $query;
	}


	public function cek_id($id)
	{
		$session_id_level = login_level('member');
		$session_level = login_level('member', TRUE);
		$session_key = login_key('member');
		$num_rows = 0;

		$num_rows = $this->db
					->select('id')
					->where('id', $id)
					->where('id_user', $session_key)
					->get($this->_table)
					->num_rows();

		return $num_rows;
	}


	public function cek_seotitle($seotitle)
	{
		$query = $this->db->where("BINARY seotitle = '$seotitle'", NULL, FALSE)->get($this->_table);
		$result = $query->num_rows();

		if ($result == 0)
			return TRUE;
		else
			return FALSE;
	}


	public function cek_seotitle2($id,$seotitle)
	{
		$cek = $this->db
			->where("BINARY seotitle = '$seotitle'", NULL, FALSE)
			->where('id_user', $this->session_key)
			->get($this->_table);
		if (
		    $cek->num_rows() == 1 && 
		    $cek->row_array()['id'] == $id || 
		    $cek->num_rows() != 1
		   ) 
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}	
} // End class.