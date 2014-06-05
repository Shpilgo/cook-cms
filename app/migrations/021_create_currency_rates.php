<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_currency_rates extends CI_Migration {

	public function up() {
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'created' => array(
				'type' => 'INT',
				'constraint' => 10
			),
			'currency_type' => array(
				'type' => 'INT',
				'constraint' => 11
			),
			'ask_average' => array(
				'type' => 'FLOAT'
			),
			'ask_max' => array(
				'type' => 'FLOAT'
			),
			'ask_max_bank' => array(
				'type' => 'INT',
				'constraint' => 11
			),
			'ask_min' => array(
				'type' => 'FLOAT'
			),
			'ask_min_bank' => array(
				'type' => 'INT',
				'constraint' => 11
			),
			'bid_average' => array(
				'type' => 'FLOAT'
			),
			'bid_max' => array(
				'type' => 'FLOAT'
			),
			'bid_max_bank' => array(
				'type' => 'INT',
				'constraint' => 11
			),
			'bid_min' => array(
				'type' => 'FLOAT'
			),
			'bid_min_bank' => array(
				'type' => 'INT',
				'constraint' => 11
			)
		));
		
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('currency_rates');
	}

	public function down() {
		$this->dbforge->drop_table('currency_rates');
	}
}