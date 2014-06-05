<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_images extends CI_Migration {

	public function up() {
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 64
			),
			'file_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 13
			),
			'file_size' => array(
				'type' => 'INT',
				'constraint' => 8
			),
			'width' => array(
				'type' => 'INT',
				'constraint' => 8
			),
			'height' => array(
				'type' => 'INT',
				'constraint' => 8
			)
		));
		
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('images');
	}

	public function down() {
		$this->dbforge->drop_table('images');
	}
}