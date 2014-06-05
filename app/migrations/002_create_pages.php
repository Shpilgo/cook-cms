<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_pages extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE
			),
			'slug' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE
			),
			'order' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'body' => array(
				'type' => 'TEXT',
				'null' => TRUE
			)
		));
		
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('pages');
	}

	public function down()
	{
		$this->dbforge->drop_table('pages');
	}
}