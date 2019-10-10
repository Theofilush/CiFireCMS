<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Web_controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('paging');
		$this->load->model('web/index_model');

		$this->meta_title('Index');
	}
	

	public function index($get_page = 0)
	{
		$url         = site_url('index');
		$page        = xss_filter($get_page,'sql');
		$batas       = $this->settings->website('page_item');
		$posisi      = $this->paging->posisi($batas, $page);
		$jml_data    = $this->index_model->total_post();
		$jml_halaman = $this->paging->jml_halaman($jml_data, $batas);

		$data_post = $this->index_model->index_post($batas, $posisi);

		$this->vars['data_post'] = $data_post;
		$this->vars['page_link'] = $this->paging->link($page, $jml_halaman, $url);
		
		if ( $page > $jml_halaman || count($data_post) < 1 ) 
		{
			$this->render_404();
		}
		else
		{
			$this->render_view('index', $this->vars);
		}
	}
} // End class
