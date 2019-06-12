<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Web_controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('paging');
		$this->load->model('web/category_model');
	}
	

	public function index($param = NULL)
	{
		$seotitle = xss_filter($param ,'xss');
		$check_seotitle = $this->category_model->check_seotitle($seotitle);

		if ( empty($seotitle) || $check_seotitle == FALSE ) 
		{
			return $this->render_404();
		}
		else
		{
			$data = $this->category_model->get_data($seotitle);
			$this->vars['result_category'] = $data;

			$page = $this->uri->segment(3);
			$page = xss_filter($page,'sql');
			$_batas  = $this->settings->website('page_item');
			$_posisi = $this->paging->posisi($_batas, $page);
			
			$this->vars['data_post'] = $this->category_model->get_post($data['id'], $_batas, $_posisi);

			$jml_data = $this->category_model->jml_data($data['id']);
			$jml_halaman = $this->paging->jml_halaman($jml_data, $_batas);
			
			$this->vars['page_link'] = $this->paging->link($page, $jml_halaman, site_url("category/$seotitle"));

			if ($page > $jml_halaman) 
			{
				return $this->render_404();
			}
			else
			{
				$this->set_meta(array(
					'title' => $data['title'],
					'keywords' => $data['title'].', '.$this->settings->website('meta_keyword'),
					'description' => $data['description']
				));
				$this->render_view('category', $this->vars);
			}
		}
	}
} // End class
