<?php
class Cron extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->load->model('currency_rates_m');
		$this->currency_rates_m->update_rates();
	}
	
}