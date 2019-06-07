<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends Web_controller {
	
	public $vars;
	public $k;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('paging');
		$this->load->model('web/search_model');
	
	}
	

	public function index()
	{
		$get_q = !empty($this->input->get('q')) ? $this->input->get('q') : null;
		$get_q = cut($get_q,200,true);
		if ($_SERVER['REQUEST_METHOD'] && !empty($_POST['kata'])) 
		{
			// $kata = html_escape(trim($this->input->post('kata', TRUE)));
			$pos_kata = urlencode($this->input->post('kata'));
			$carikata = url_encode($pos_kata);
			return redirect(site_url('search?q='.$pos_kata.'&page=0'));
		}

		elseif ( !empty($get_q) )
		{

			$kata = urldecode($get_q);
			$katakan = xss_filter($kata);
			$cari_kata = clean_space(trim(xss_filter($kata,'xss')));

			$_page   = !empty($this->input->get('page')) ? $this->input->get('page') : 0;
			$_batas  = 5;
			$_posisi = $this->paging->posisi($_batas, $_page);

			$this->vars['search_post'] = $this->search_model->Search($cari_kata, 'hits DESC', $_batas, $_posisi);
			$jml_data = $this->search_model->jml_data($cari_kata);

			$jml_halaman  = $this->paging->jml_halaman($jml_data, $_batas);

			$this->vars['page_link'] = $this->paging->alink($_page, $jml_halaman, site_url('search?q='), urlencode($get_q));

			$this->vars['num_post'] = $jml_data;
			$this->vars['keywords'] = $katakan;

			$this->set_meta(array(
				'title' => 'Search - '.$this->settings->website('web_name'),
				'keywords' => $cari_kata,
				'description' => $this->settings->website('description')
			));

			if ($_page > $jml_halaman) 
			{
				$this->render_404();
			}
			else
			{
				$this->render_view('search', $this->vars);
			}

		}

/*	
		$_page   = xss_filter($this->uri->segment(3) ,'sql');
		$_batas  = 9;
		$_posisi = $this->paging->posisi($_batas, $_page);

		$this->vars['search_post'] = $this->search_model->Search($kata, 'hits DESC', $_batas, $_posisi);
		$jml_data = $this->search_model->jml_data($kata);

		$jml_halaman  = $this->paging->jml_halaman($jml_data, $_batas);

		$this->vars['page_link'] = $this->paging->link($_page, $jml_halaman, site_url("search/".urlencode($kata)));

		$this->vars['num_post'] = $jml_data;
		$this->vars['keywords'] = $kata;

		$this->set_meta(array(
			'title' => 'Search - '.$this->settings->website('web_name'),
			'keywords' => pecah_kata($pemisah = '-', $kata, 'N', $url = '', $separator = ',').', '.$this->settings->website('meta_keyword'),
			'description' => ''
		));

		if ($_page > $jml_halaman) 
		{
			$this->render_404();
		}
		else
		{
			$this->render_view('search', $this->vars);
		}*/
	}


	public function e($q='')
	{
		if (empty($q))
		{
			$this->render_view('404');
		}
		else
		{
			$kata    = html_escape(urldecode($q));

			$_page   = $this->uri->segment(5);

			$_batas  = $this->settings->website('page_item');
			$_posisi = $this->paging->posisi($_batas, $_page);

			$query = $this->search_model->Search($kata, 'id DESC');

			$this->vars['search_post'] = $query->result_array();

			$jml_data = $query->num_rows();

			$jml_halaman  = $this->paging->jml_halaman($jml_data, $_batas);
			
			$this->vars['page_link'] = $this->paging->link($_page, $jml_halaman, site_url("search/$kata"));

			$this->vars['num_post']     = $jml_data;
			$this->vars['keywords']     = $kata;

			$this->set_meta(array(
				'title' => 'Search - '.$this->settings->website('web_name'),
				'keywords' => pecah_kata($pemisah = '-', $kata, 'N', $url = '', $separator = ',').', '.$this->settings->website('meta_keyword'),
				'description' => ''
			));

			if ($_page > $jml_halaman) 
			{
				return $this->render_404();
			}
			else
			{
				$this->render_view('search', $this->vars);
			}
		}
	}
} // end class
