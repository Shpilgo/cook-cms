<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_currency_types extends CI_Migration {

	public function up() {
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'currency' => array(
				'type' => 'VARCHAR',
				'constraint' => 3
			)
		));
		
		$this->dbforge->create_table('currency_types');
	}

	public function down() {
		$this->dbforge->drop_table('currency_types');
	}
}