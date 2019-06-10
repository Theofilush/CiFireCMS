<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag extends Web_controller {
	
	public $vars;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('paging');
		$this->load->model('web/tag_model');
	}
	
	public function index($seotitle = '')
	{
		$seotitle = xss_filter($seotitle,'xss');
		
		if ( !empty($seotitle) ) 
		{
			$data_tag = $this->tag_model->get_tag($seotitle);
			$page = $this->uri->segment(3);
			$page_batas  = $this->settings->website('page_item');
			$page_posisi = $this->paging->posisi($page_batas, $page);

			$this->vars['result_tag'] = $data_tag;
			$this->vars['tag_post'] = $this->tag_model->get_post($data_tag['seotitle'], $page_batas, $page_posisi);
			$jml_data = $this->tag_model->jml_data($seotitle);
			$jml_halaman  = $this->paging->jml_halaman($jml_data, $page_batas);
			$this->vars['page_link'] = $this->paging->link($page, $jml_halaman, base_url("tag/$seotitle"));

			$this->set_meta(array(
				'title' => $data_tag['title'],
				'keywords' => $data_tag['title'].', '.$this->settings->website('keyword'),
				'description' => $this->settings->website('description')
			));
			
			$this->render_view('tag', $this->vars);
		}
		else
		{
			return $this->render_view('404');
		}
	}

} // end class
