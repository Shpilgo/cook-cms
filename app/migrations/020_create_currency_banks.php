<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_currency_banks extends CI_Migration {

	public function up() {
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'bank' => array(
				'type' => 'VARCHAR',
				'constraint' => 64
			)
		));
		
		$this->dbforge->create_table('currency_banks');
	}

	public function down() {
		$this->dbforge->drop_table('currency_banks');
	}
}