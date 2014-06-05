<?php
class Home extends Admin_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->lang->load('admin_'.str_class($this));
		$this->data['c_name'] = str_class($this);
	}
	
	private function migrate() {
		if (isset($_GET['v'])) {
			return $this->migration->version($_GET['v']);
		} else {
			return $this->migration->latest();
		}
	}
	
	public function index() {
		$this->load->library('migration');
		if (!$this->migrate()) {
			$this->data['migration_message'] = $this->migration->error_string();
			$this->data['migration_alert'] = 'danger';
		} else {
			$query = $this->db->query('SELECT version FROM migrations')->row();
			$this->data['migration_message'] = sprintf($this->lang->line('migration_version'), $query->version);
			$this->data['migration_alert'] = 'info';
		}
		
		$this->load->model('currency_rates_m');
		$this->lang->load('admin_currencies');
		$this->data['currency_rates'] = $this->currency_rates_m->get_last_rates();
		
		$this->data['subview'] = 'admin/'.str_class($this).'_'.__FUNCTION__.'_tpl';
		$this->load->view('admin/_layout_main', $this->data);
	}
		
	public function modal() {
		$this->load->view('admin/_layout_modal', $this->data);
	}
	
}