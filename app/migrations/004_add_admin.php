<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_admin extends CI_Migration {

	public function up()
	{
		$this->db->query("INSERT INTO `users` (`id`, `email`, `password`, `name`) VALUES (NULL, 'admin@ecms.com', '9680EFFF369839560523D9A34AFE50D93FEAFD50702F96A7AB00B25B29C65B235EC41D3D6AE144E0399C7ABFB212801E1F58329B0888756257347F3D54F36132', 'admin')");
	}

	public function down()
	{
		$this->db->query("DELETE FROM `users` WHERE `email` = 'admin@ecms.com'");
	}
}