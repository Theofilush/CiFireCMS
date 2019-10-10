<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tag extends Web_controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('paging');
		$this->load->model('web/tag_model');
	}
	
	public function index($seotitle = '')
	{
		$seotitle = xss_filter($seotitle, 'xss');
		
		if ( !empty($seotitle) && $this->tag_model->cek_tag($seotitle) ) 
		{
			$url         = base_url("tag/$seotitle");
			$page        = xss_filter($this->uri->segment(3), 'sql');
			$batas       = $this->settings->website('page_item');
			$posisi      = $this->paging->posisi($batas, $page);
			$jml_data    = $this->tag_model->jml_data($seotitle);
			$jml_halaman = $this->paging->jml_halaman($jml_data, $batas);
			
			$data_tag = $this->tag_model->get_tag($seotitle);

			$this->vars['page_link']  = $this->paging->link($page, $jml_halaman, $url);
			$this->vars['result_tag'] = $data_tag;
			$this->vars['tag_post']   = $this->tag_model->get_post($data_tag['seotitle'], $batas, $posisi);

			if ( $page > $jml_halaman || $jml_data == 0 ) 
			{
				$this->render_404();
			}
			else
			{			
				$this->meta_title('Tag - '.$data_tag['title']);
				$this->meta_keywords($data_tag['title'].', '.$this->settings->website('meta_keyword'));
				$this->meta_description($this->settings->website('meta_description'));
				$this->render_view('tag', $this->vars);
			}
		}
		else
		{
			$this->render_404();
		}
	}
} // End class.
