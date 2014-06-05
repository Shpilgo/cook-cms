<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends Frontend_Controller {

	function __construct () {
		parent::__construct();
		$this->load->model('article_m');
	}
	
	public function index($id, $slug) {
		$this->db->where('pubdate <=', date('Y-m-d'));
		$this->data['article'] = $this->article_m->get($id);
		count($this->data['article']) || redirect('/404', 'refresh');
		// $requested_slug = $this->uri->segment(3);
		if ($slug != $this->data['article']->slug) {
			redirect('/article/'.$this->data['article']->id.'/'.$this->data['article']->slug, 'location', '301');
		}
		add_meta_title($this->data['article']->title);
		$this->data['subview'] = 'article';
		$this->load->view('_layout_main', $this->data);
	}
}