<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends Web_controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('paging');
		$this->load->model('web/search_model');
	}
	

	public function index()
	{
		$get_q = ( !empty($this->input->get('q')) ? $this->input->get('q') : NULL );
		$get_q = cut($get_q, 200, TRUE);

		if ( $_SERVER['REQUEST_METHOD'] && !empty($this->input->post('kata')) ) 
		{
			$pos_kata = urlencode($this->input->post('kata'));
			$carikata = url_encode($pos_kata);
			redirect(site_url('search?q='.$pos_kata.'&page=0'));
		}

		elseif ( !empty($get_q) )
		{
			$kata      = urldecode($get_q);
			$katakan   = xss_filter($kata);
			$cari_kata = clean_space(trim(xss_filter($kata,'xss')));

			$_url        = site_url('search?q=');
			$_page       = !empty($this->input->get('page')) ? $this->input->get('page') : 0;
			$_batas      = $this->settings->website('page_item');
			$_posisi     = $this->paging->posisi($_batas, $_page);
			$jml_data    = $this->search_model->jml_data($cari_kata);
			$jml_halaman = $this->paging->jml_halaman($jml_data, $_batas);

			$this->vars['search_post'] = $this->search_model->Search($cari_kata, 'hits DESC', $_batas, $_posisi);
			$this->vars['page_link'] = $this->paging->alink($_page, $jml_halaman, $_url, urlencode($get_q));
			$this->vars['num_post'] = $jml_data;
			$this->vars['keywords'] = $katakan;

			$this->meta_title('Search - '.$this->settings->website('web_name'));
			$this->meta_keywords($cari_kata);
			$this->meta_description($this->settings->website('meta_description'));

			if ( $_page > $jml_halaman ) 
			{
				$this->render_404();
			}
			else
			{
				$this->render_view('search', $this->vars);
			}
		}
		else
		{
			show_404();
		}
	}
} // End class.