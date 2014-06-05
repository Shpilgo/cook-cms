<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_functional_user_role extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'functional_id' => array(
				'type' => 'INT',
				'constraint' => 11
			),
			'user_role_id' => array(
				'type' => 'INT',
				'constraint' => 11
			)
		));
		
		$this->dbforge->create_table('functional_user_role');
	}

	public function down()
	{
		$this->dbforge->drop_table('functional_user_role');
	}
}