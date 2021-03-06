<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_user_roles extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			'status' => array(
				'type' => 'INT',
				'default' => 1
			)
		));
		
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('user_roles');
	}

	public function down()
	{
		$this->dbforge->drop_table('user_roles');
	}
}