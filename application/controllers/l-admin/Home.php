<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_controller {

	public $mod = 'home';

	public function __construct()
	{
		parent::__construct();
		
		if ($this->read_access == TRUE)
		{
			$this->lang->load('mod/'.$this->mod, $this->_language);
			$this->meta_title(lang_line('mod_title'));
		}
		else
		{
			$ths->render_404();
		}
	}



	public function index()
	{
		$this->vars['h_post']     = $this->db->get('t_post')->num_rows();
		$this->vars['h_category'] = $this->db->get('t_category')->num_rows();
		$this->vars['h_tag']      = $this->db->get('t_tag')->num_rows();
		$this->vars['h_comment']  = $this->db->get('t_comment')->num_rows();
		$this->vars['h_pages']    = $this->db->get('t_pages')->num_rows();
		$this->vars['h_theme']    = $this->db->get('t_theme')->num_rows();
		$this->vars['h_mail']     = $this->db->get('t_mail')->num_rows();
		$this->vars['h_users']    = $this->db->get('t_user')->num_rows();

		$notif_mail = $this->db->where('active','N')->get('t_mail')->num_rows();
		$this->vars['notif_mail'] = array(
		                                  $notif_mail,
		                                  lang_line('mod_notif_2')."&nbsp;".
		                                  $notif_mail."&nbsp;".
		                                  lang_line('mod_notif_5')."&nbsp;".lang_line('mod_notif_3')
		                                  );

		$notif_comment = $this->db->where('active','N')->get('t_comment')->num_rows();
		$this->vars['notif_comment'] = array(
		                                  $notif_comment,
		                                  lang_line('mod_notif_2')."&nbsp;".
		                                  $notif_comment."&nbsp;".
		                                  lang_line('mod_notif_4')."&nbsp;".lang_line('mod_notif_3')
		                                  );

		$pilchart = 'chartweek';
		
		if ($this->input->post())
		{
			$showchart = $this->input->post('showchart');
			$pilchart = $showchart;
		}
		
		$this->vars['pilchart'] = $pilchart;

		switch($pilchart) 
		{
			case "chartweek":
				$range = 6;

				for ($i = $range; $i >= 0; $i--) 
				{
					if ($i == 0) 
					{
						$visitorstemp = $this->db
							->where('date', date('Y-m-d'))
							->group_by('ip')
							->get('t_visitor')
							->result_array();

						$hitstemp = $this->db
							->select('SUM(hits) as hitstoday')
							->where('date', date('Y-m-d'))
							->group_by('date')
							->get('t_visitor')
							->row_array();
					} 
					else 
					{
						$visitorstemp = $this->db
							->where('date', date('Y-m-d', strtotime('-'.$i.' days')))
							->group_by('ip')
							->get('t_visitor')
							->result_array();

						$hitstemp = $this->db
							->select('SUM(hits) as hitstoday')
							->where('date', date('Y-m-d', strtotime('-'.$i.' days')))
							->group_by('date')
							->get('t_visitor')
							->row_array();
					}

					$arrvisitor[$i] = count($visitorstemp);
					$this->vars['arrhari'][$i] = '"'.date('D, d M', strtotime('-'.$i.' days')).'"';
					$arrhits[$i] = (empty($hitstemp['hitstoday']) ? '0' : $hitstemp['hitstoday']);
				}

				$this->vars['rvisitors'] = array_combine(array_keys($arrvisitor), array_reverse(array_values($arrvisitor)));
				$this->vars['rhits'] = array_combine(array_keys($arrhits), array_reverse(array_values($arrhits)));
			break;

			case "chartmonth":
				$lastend = $this->db
					->select('*, SUM(hits) as hitstotal')
					->where('YEAR(date) = '.date('Y'), null, false)
					->where('MONTH(date) = '.date('m'), null, false)
					->group_by('date')
					->order_by('date','DESC')
					->get('t_visitor')
					->row_array();
					
				$range = date('j', strtotime($lastend['date']));

				for ($i = $range; $i > 0; $i--) 
				{
					$stats = $this->db
						->select('*, SUM(hits) as hitstotal')
						->where('YEAR(date) = '.date('Y'), null, false)
						->where('MONTH(date) ='.date('m'), null, false)
						->where('DAY(date) =0'.$i, null, false)
						->group_by('date')
						->get('t_visitor')
						->row_array();

					if (empty($stats)) 
					{
						$this->vars['rvisitors'][$i] = 0;
						$this->vars['arrhari'][$i] = '"'.date('d M', strtotime(date('Y-m-').$i)).'"';
						$this->vars['rhits'][$i] = 0;
					} 
					else 
					{
						$unikvisitor = $this->db
							->select('ip')
							->where('MONTH(date) ='.date('m'), null, false)
							->where('DAY(date) =0'.$i, null, false)
							->group_by('ip')
							->get('t_visitor')
							->num_rows();

						$this->vars['rvisitors'][$i] = $unikvisitor;
						$this->vars['arrhari'][$i] = '"'.date('d M', strtotime($stats['date'])).'"';
						$this->vars['rhits'][$i] = $stats['hitstotal'];
					}
				}
				$this->vars['arrhari'] = array_reverse($this->vars['arrhari']);
			break;

			case "chartyear":
				$lastend = $this->db
					->select('*, SUM(hits) as hitstotal, count(date) as unikvisitor')
					->where('YEAR(date) ='.date('Y'), null,false)
					->group_by('MONTH(date)')
					->order_by('date','DESC')
					->get('t_visitor')
					->row_array(); 

				$range = date('n', strtotime($lastend['date']));

				for ($i = $range; $i > 0; $i--) 
				{
					$stats = $this->db
						->select('*, SUM(hits) as hitstotal')
						->where('YEAR(date) ='.date('Y'), null, false )
						->where('MONTH(date) = 0'.$i, null, false)
						->group_by('MONTH(date)')
						->order_by('date','DESC')
						->get('t_visitor')
						->row_array();



					if (empty($stats)) 
					{
						$this->vars['rvisitors'][$i] = 0;
						$this->vars['arrhari'][$i] = '"'.date('M', strtotime(date('Y-').$i.'-01')).'"';
						$this->vars['rhits'][$i] = 0;
					} 
					else 
					{
						$unikvisitor = $this->db
							->select('ip')
							->where('YEAR(date) ='.date('Y'), null, false )
							->where('MONTH(date) = 0'.$i, null, false)
							->group_by('date')
							->get('t_visitor')
							->num_rows();

						$this->vars['rvisitors'][$i] = $unikvisitor;
						$this->vars['arrhari'][$i] = '"'.date('M', strtotime(date('Y-').$i.'-01')).'"';
						$this->vars['rhits'][$i] = $stats['hitstotal'];
					}
				}
				
				$this->vars['arrhari'] = array_reverse($this->vars['arrhari']);
			break;
		}

		// load view.
		$this->render_view('view_index', $this->vars);
	}


	public function visitors()
	{
		$this->render_view('view_visitors', $this->vars);
	}


	public function _js_str($s)
	{
		return '"' . addcslashes($s, "\0..\37\"\\") . '"';
	}


	public function _js_array($array)
	{
		$temp = array_map(array($this, '_js_str'), $array);
		return '[' . implode(',', $temp) . ']';
	}


	public function setlang()
	{
		if ( $this->input->is_ajax_request() ) {
			# code...
			$session_lang['lang_active'] = $this->input->post('data');
			$this->session->set_userdata($session_lang);
			$response['status'] = true;
			$this->json_output($response);
		}
		//redirect(uri_string(), 'refresh');
	}
} // End Class.