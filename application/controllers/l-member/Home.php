<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Member_controller {

	public $mod = 'home';

	public function __construct()
	{
		parent::__construct();
		$this->meta_title(lang_line('home_title'));
	}

	public function index()
	{
		$this->render_view('home', $this->vars);
	}
} // End Class.