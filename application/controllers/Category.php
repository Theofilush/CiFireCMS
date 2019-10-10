<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Web_controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('paging');
		$this->load->model('web/category_model');
	}
	
	
	public function index($get_seotitle = NULL)
	{
		$seotitle = xss_filter($get_seotitle ,'xss');
		$check_seotitle = $this->category_model->check_seotitle($seotitle);

		if ( !empty($seotitle) && $check_seotitle == TRUE ) 
		{
			$data_category = $this->category_model->get_data($seotitle);
			$this->vars['result_category'] = $data_category;

			$url         = site_url('category/'.$seotitle);
			$page        = xss_filter($this->uri->segment(3), 'sql');
			$batas       = $this->settings->website('page_item');
			$posisi      = $this->paging->posisi($batas, $page);
			$jml_data    = $this->category_model->jml_data($data_category['id']);
			$jml_halaman = $this->paging->jml_halaman($jml_data, $batas);
			
			$this->vars['data_post'] = $this->category_model->get_post($data_category['id'], $batas, $posisi);
			$this->vars['page_link'] = $this->paging->link($page, $jml_halaman, $url);

			if ( $page > $jml_halaman ) 
			{
				$this->render_404();
			}
			else
			{
				$this->meta_title($data_category['title']);
				$this->meta_keywords($data_category['title'].', '.$this->settings->website('meta_keyword'));
				$this->meta_description($data_category['description']);

				$this->render_view('category', $this->vars);
			}
		}
		else
		{
			$this->render_404();
		}
	}
} // End class.