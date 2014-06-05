<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_geo_city extends CI_Migration {

	public function up() {
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'city' => array(
				'type' => 'VARCHAR',
				'constraint' => 80
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('geo_city');
	}

	public function down() {
		$this->dbforge->drop_table('geo_city');
	}
}