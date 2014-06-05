<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Frontend_Controller {

	function __construct () {
		parent::__construct();
		$this->load->model('page_m');
	}
	
	public function index() {
		// dump($this->uri->segment(1));
		$this->data['page'] = $this->page_m->get_by(array('slug' => (string) $this->uri->segment(1)), TRUE);
		// count($this->data['page']) || show_404(current_url());
		if (!count($this->data['page'])) {
			$page404 = new stdClass;
			$page404->id = 0;
			$page404->title = '404 Page Not Found';
			$page404->slug = '';
			$page404->order = 0;
			$page404->body = 'The page you requested was not found.';
			$page404->parent_id = 0;
			$page404->template = '404';
			$this->data['page'] = $page404;
		}
		
		add_meta_title($this->data['page']->title);
		
		$method = '_'.$this->data['page']->template;
		if (method_exists($this, $method)) {
			$this->$method();
		} else {
			log_message('error', 'Could not load template '.$method.' in file '.__FILE__.' at line '.__LINE__);
			show_error('Could not load template '.$method);
		}
		
		$this->data['subview'] = $this->data['page']->template;
		$this->load->view('_layout_main', $this->data);
	}
	
	private function _404() {
		$this->data['title'] = $this->data['page']->title;
		$this->data['body'] = $this->data['page']->body;
	}
	
	private function _page() {
		$this->data['title'] = $this->data['page']->title;
		$this->data['body'] = $this->data['page']->body;
	}
	
	private function _homepage() {
		$this->load->model('article_m');
		$this->db->where('pubdate <=', date('Y-m-d'));
		$this->db->limit(5);
		$this->data['articles'] = $this->article_m->get();
	}
	
	private function _news_archive() {
		$this->load->model('article_m');
		$this->db->where('pubdate <=', date('Y-m-d'));
		$count = $this->db->count_all_results('articles');
		$perpage = 4;
		if ($count > $perpage) {
			$this->load->library('pagination');
			$config['base_url'] = site_url($this->uri->segment(1).'/');
			$config['total_rows'] = $count;
			$config['per_page'] = $perpage;
			$config['uri_segment'] = 2;
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$offset = $this->uri->segment(2);
		} else {
			$this->data['pagination'] = '';
			$offset = 0;
		}
		$this->db->where('pubdate <=', date('Y-m-d'));
		$this->db->limit($perpage, $offset);
		$this->data['articles'] = $this->article_m->get();
	}
}