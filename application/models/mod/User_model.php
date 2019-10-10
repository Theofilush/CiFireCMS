<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	private $_table = 't_user';
	private $_column_order = array(null, 't_user.id', 't_user.username', 't_user.level', 't_user.active', 't_user_level.title', 't_level');
	private $_column_search = array('t_user.id', 't_user.name', 't_user.username');


	public function __construct()
	{
		parent::__construct();
	}


	private function _datatable_query()
	{
		$session_level = login_level('admin');
		
		$this->db->select('
				         t_user.id           AS  user_id,
					     t_user.level        AS  user_level,
					     t_user.name         AS  user_name,
					     t_user.username     AS  user_username,
					     t_user.photo        AS  user_photo,
					     t_user.active       AS  user_active,
					     t_user_level.id     AS  level_id,
					     t_user_level.title  AS  level_title
					    ');

		$this->db->from($this->_table);

		if ( $session_level != 1 )
		{
			$this->db->where("t_user.level > '2'", NULL, FALSE);
			$this->db->or_where('t_user.id', login_key('admin'));
		}

		$this->db->join('t_user_level', 't_user_level.id = t_user.level', 'left');

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
			$this->db->order_by('t_user.id', 'DESC');
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


	private function _datatable_query_level()
	{
		$_column_order = array(
			't_user_level.id',
			't_user_level.title',
			't_user_level.level',
			't_user_level.menu'
		);
		
		$_column_search = array(
			't_user_level.id',
			't_user_level.title',
			't_user_level.level'
		);		
		
		$this->db->select('*,
		                  t_user_level.id     AS  level_id,
		                  t_user_level.title  AS  level_title,
		                  t_menu_group.title  AS  menu_title
		                ');

		$this->db->from('t_user_level');
		$this->db->join('t_menu_group','t_user_level.menu=t_menu_group.id','left');

		$i = 0;	
		foreach ($_column_search as $item) 
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

				if ( count($_column_search) - 1 == $i ) 
				{
					$this->db->group_end(); 
				}
			}
			$i++;
		}
		
		if ( !empty($this->input->post('order')) ) 
		{
			$this->db->order_by(
				$_column_order[$this->input->post('order')['0']['column']], 
				$this->input->post('order')['0']['dir']
			);
		}
	}


	public function get_datatables_level()
	{
		$this->_datatable_query_level();

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


	public function count_filtered_level()
	{
		$this->_datatable_query_level();
		$query = $this->db->get();
		return $query->num_rows();
	}


	public function count_all_level()
	{
		$this->db->from($this->_table);
		return $this->db->count_all_results();
	}


	public function insert_user($data)
	{
		$this->db->insert('t_user', $data);
	}


	public function insert_level(array $data)
	{
		if (
		    $data['level'] != "super-admin" || 
		    $data['level'] != "admin" || 
		    $data['level'] != "manager" || 
		    $data['level'] != "member"
		    )
		{
			$this->db->insert('t_user_level', $data);
		}
	}


	public function insert_role(array $data)
	{
		$this->db->insert('t_user_role', $data);
	}


	public function update($id, array $data)
	{
		if ( $this->cek_id($id) > 0 )
			$this->db->where('id',$id)->update($this->_table, $data);
	}


	public function update_module($id, array $data)
	{
		if ( $this->cek_id_module($id) === 1 )
			$this->db->where('id',$id)->update('t_user_role', $data);
	}


	public function delete_user($id)
	{
		if ( $this->cek_id($id) > 0 ) 
		{
			$log_level_id = user_level('id');
			$log_level_char = user_level('level');

			if ( $log_level_char == "super-admin" )
			{
				$this->db->where('id', $id)->delete($this->_table);
				$respon = TRUE;
			}
			else
			{
				$find_user_del = $this->db
					->where('id', $id)
					->get('t_user')
					->row_array();

				$find_user_del_level = $this->db
					->where('id', $find_user_del['level'])
					->get('t_user_level')
					->row_array();

				if ( $find_user_del['id'] == login_key('admin') )
				{
					$this->db->where('id', $id)->delete($this->_table);
					$respon = TRUE;
				}
				else
				{
					if ( $find_user_del_level['id'] > 2 )
					{
						$this->db->where('id', $id)->delete($this->_table);
						$respon = TRUE;
					}
					else
					{
						$respon = FALSE;
					}
				}
			}
		}
		else
		{
			$respon = FALSE;
		}

		return $respon;
	}


	public function delete_level($id)
	{
		if ( $this->cek_id_level($id) > 0 ) 
		{
			$this->db->where('id', $id)->delete('t_user_level');
			$this->db->where('level', $id)->delete('t_user_role');
		}
	}


	public function delete_module($id)
	{
		if ( $this->cek_id_module($id) > 0 ) 
		{
			$this->db->where('id', $id);
			$this->db->delete('t_user_role');
		}
	}


	public function all_user() 
	{
		$session_level = login_level('admin');

		if ( $session_level == '1' )
		{
			$query = $this->db
				->select('
				         t_user.id            AS  user_id,
					     t_user.level         AS  user_level,
					     t_user.name          AS  user_name,
					     t_user.username      AS  user_username,
					     t_user.photo         AS  user_photo,
					     t_user.active        AS  user_active,
					     t_user_level.id      AS  level_id,
					     t_user_level.title   AS  level_title
					    ')
				->join('t_user_level', 't_user_level.id = t_user.level')
				->get($this->_table);
		}
		else 
		{
			$query = $this->db
				->select('
				         t_user.id           AS  user_id,
					     t_user.level        AS  user_level,
					     t_user.name         AS  user_name,
					     t_user.username     AS  user_username,
					     t_user.photo        AS  user_photo,
					     t_user.active       AS  user_active,
					     t_user_level.id     AS  level_id,
					     t_user_level.title  AS  level_title
					    ')
				->join('t_user_level', 't_user_level.id = t_user.level')
				->where("t_user.level != '1'",NULL,FALSE)
				->get($this->_table);
		}
		
		$result = $query->result_array();
		return $result;
	}


	public function get_user($id) 
	{
		$session_level = login_level('admin');

		$query = $this->db
			->select('
			         t_user.id           AS  user_id,
				     t_user.level        AS  user_level,
				     t_user.username     AS  user_username,
				     t_user.password     AS  user_password,
				     t_user.email        AS  user_email,
				     t_user.name         AS  user_name,
				     t_user.gender       AS  user_gender,
				     t_user.birthday     AS  user_birthday,
				     t_user.about        AS  user_about,
				     t_user.address      AS  user_address,
				     t_user.tlpn         AS  user_tlpn,
				     t_user.photo        AS  user_photo,
				     t_user.active       AS  user_active,
				     t_user_level.id     AS  level_id,
				     t_user_level.title  AS  level_title
				    ');

		$query = $this->db->join('t_user_level', 't_user_level.id = t_user.level', 'left');
		
		if ( $session_level == 1 )
		{
			$query = $this->db->where('t_user.id', $id);
		}
		else
		{
			$query = $this->db->where('t_user.id', $id);
			$query = $this->db->where("t_user.level !='1'", NULL, FALSE);
		}

		$query = $this->db->get($this->_table);
		$result = $query->row_array();

		if ( $query->num_rows() == 1 )
			return $result;
		else
			show_404();
	}

	public function get_id($username='')
	{
		$query = $this->db->select('id');
		$query = $this->db->where("BINARY username = '$username'", NULL, FALSE);
		$query = $this->db->get($this->_table);
		$result = $query->row_array()['id'];
		return $result;
	}


	public function get_photo2($id) 
	{
		$query = $this->db->where('id', $id);
		$query = $this->db->get($this->_table);
		$result = $query->row_array();
		$photo = $result['photo'];
		return $photo;
	}


	public function get_photo($id)
	{
		if ( $this->cek_id($id) > 0 )
		{
			$query = $this->db->where('id', $id);
			$query = $this->db->get('t_user');
			$result = $query->row_array();
			$photo = $result['photo'];
			return $photo;
		}
		else 
		{
			return NULL;
		}
	}


	public function select_level() 
	{
		$session_level = (int)user_level('id');

		if ( $session_level == 1 )
		{
			$query = $this->db
				->order_by('id','DESC')
				->get('t_user_level')
				->result_array();
		}
		elseif ( $session_level >= 2 ) 
		{
			$query = $this->db
				->where("id > 2", NULL, FALSE)
				->get('t_user_level')
				->result_array();
		}

		return $query;
	}


	public function cek_id($id)
	{
		$query = $this->db->select('id');
		$query = $this->db->where('id', $id);
		$query = $this->db->get($this->_table);
		$result = $query->num_rows();

		if ( $result < 1 )
			$result = 0;
		
		return $result;
	}


	public function cek_id_level($id)
	{
		$query = $this->db->select('id');
		$query = $this->db->where('id', $id);
		$query = $this->db->get('t_user_level');
		$result = $query->num_rows();

		if ( $result < 1 )
			$result = 0;
		
		return $result;
	}


	public function cek_id_module($id)
	{
		$query = $this->db->select('id');
		$query = $this->db->where('id', $id);
		$query = $this->db->get('t_user_role');
		$result = $query->num_rows();

		if ( $result < 1 )
			$result = 0;
		
		return $result;
	}


	public function cek_username($username)
	{
		$query = $this->db->where("BINARY username = '$username'", NULL, FALSE);
		$query = $this->db->get($this->_table);
		$result = $query->num_rows();

		if ( $result == 0 )
			return TRUE;
		else 
			return FALSE;
	}

	
	public function cek_email($email)
	{
		$query = $this->db->where("BINARY email = '$email'", NULL, FALSE);
		$query = $this->db->get($this->_table);
		$result = $query->num_rows();

		if ( $result == 0 ) 
			return TRUE;
		else 
			return FALSE;
	}


	public function cek_username2($id, $username)
	{
		$query = $this->db->select('id,username');
		$query = $this->db->where("BINARY username = '$username'", NULL, FALSE);
		$query = $this->db->get($this->_table);

		if (
		    $query->num_rows() == 1 && 
		    $query->row_array()['id'] == $id || 
		    $query->num_rows() != 1
		   ) 
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}


	public function cek_email2($id, $email)
	{
		$query = $this->db->select('id,email');
		$query = $this->db->where("BINARY email = '$email'", NULL, FALSE);
		$query = $this->db->get($this->_table);

		if (
		    $query->num_rows() == 1 && 
		    $query->row_array()['id'] == $id || 
		    $query->num_rows() != 1
		   ) 
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}


	public function all_module()
	{
		$query = $this->db->select('*,
					t_user_role.id      AS  role_id,
					t_user_role.level   AS  role_id_level,
					t_user_level.id     AS  level_id,
					t_user_level.title  AS  level_title,
					t_user_level.level  AS  level_seotitle
				');
		$query = $this->db->join('t_user_level','t_user_level.id = t_user_role.level');
		$query = $this->db->order_by('t_user_role.level','DESC');
		$query = $this->db->get('t_user_role');
		$result = $query->result_array();
		return $result;
	}


	public function level_modules($level)
	{
		$query = $this->db->select('*,
					t_user_role.id      AS  role_id,
					t_user_role.level   AS  role_id_level,
					t_user_level.id     AS  level_id,
					t_user_level.title  AS  level_title,
					t_user_level.level  AS  level_seotitle,
				');
		$query = $this->db->join('t_user_level','t_user_level.id = t_user_role.level');
		$query = $this->db->order_by('t_user_role.id','ASC');
		$query = $this->db->where('t_user_role.level',$level);
		$query = $this->db->get('t_user_role');
		$result = $query->result_array();
		return $result;
	}


	public function module_list($level, $mod){
		
		$query = $this->db->select('module');
		$query = $this->db->where('module',$mod);
		$query = $this->db->where('level',$level);
		$query = $this->db->get('t_user_role');
		$result = $query->row_array();
		return $result['module'];
	}


	public function levels()
	{
		$query = $this->db->where("id > '1'", NULL, FALSE);
		$query = $this->db->get('t_user_level');
		$result = $query->result_array();
		return $result;
	}


	public function get_level_by($id)
	{
		$query = $this->db->where('id', $id);
		$query = $this->db->get('t_user');
		$result = $query->row_array();
		$level = $result['level'];
		return $level;
	}


	public function get_level($id)
	{
		$query = $this->db->where('id', $id);
		$query = $this->db->where("id != '1'", NULL, FALSE);
		$query = $this->db->get('t_user_level');
		$result = $query->row_array();
		return $result;
	}


	public function get_level_role($id_level)
	{
		$query = $this->db->where('level',$id_level);
		$query = $this->db->get('t_user_role');
		$result = $query->result_array();
		return $result;
	}


	public function get_data_module($id_mod)
	{
		$query = $this->db->where('id',$id_mod);
		$query = $this->db->get('t_user_role');
		$result = $query->row_array();
		return $result;
	}
} // End class.