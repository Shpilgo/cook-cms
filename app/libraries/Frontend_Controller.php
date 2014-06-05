<?php
class Frontend_Controller extends MY_Controller {
	
	function __construct () {
		parent::__construct();
		
		$this->load->model('page_m');
		
		$this->data['menu'] = $this->page_m->get_nested();
		$this->data['news_archive_link'] = $this->page_m->get_archive_link();
		
		$this->load->model('article_m');
		$this->data['recent_news'] = $this->article_m->get_recent_news();
		$this->data['meta_title'] = config_item('site_name');
		
		$this->load->library('session');
		$this->load->model('user_m');
		$ip = $this->session->userdata('ip_address');
		if ($ip == '127.0.0.1') {
			$ip = '93.77.6.5';
		}
		if (!$this->session->userdata('country') && $ip != '127.0.0.1') {
			$this->load->model('geo_ip_m');
			$geo_ip = $this->geo_ip_m->get_data_short($ip);
			if ($geo_ip != false) {
				$this->session->set_userdata($geo_ip);
			}
		}
		// dump($this->session->all_userdata());
	}
}