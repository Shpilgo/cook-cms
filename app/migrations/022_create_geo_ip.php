<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_geo_ip extends CI_Migration {

	public function up() {
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'ip' => array(
				'type' => 'VARCHAR',
				'constraint' => 15
			),
			'country' => array(
				'type' => 'VARCHAR',
				'constraint' => 2,
				'null' => TRUE
			),
			'region_id' => array(
				'type' => 'INT',
				'constraint' => 11
			),
			'city_id' => array(
				'type' => 'INT',
				'constraint' => 11
			),
			'lat' => array(
				'type' => 'VARCHAR',
				'constraint' => 20
			),
			'lon' => array(
				'type' => 'VARCHAR',
				'constraint' => 20
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('geo_ip');
	}

	public function down() {
		$this->dbforge->drop_table('geo_ip');
	}
}