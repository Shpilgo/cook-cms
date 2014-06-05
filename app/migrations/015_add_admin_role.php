<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_admin_role extends CI_Migration {

	public function up() {
		$this->db->query("INSERT INTO `user_roles` (`id`, `name`, `status`) VALUES (1, 'Administrator', 1)");
		$this->db->query("UPDATE users SET `role_id` =  '1' WHERE `users`.`id` = 1");
		$this->db->query("INSERT INTO `functional` (`id`, `name`, `status`, `parent_id`, `link`) VALUES
			(5, 'pages', 1, 0, 'page'),
			(6, 'page order', 1, 5, 'page/order'),
			(7, 'news', 1, 0, 'article'),
			(8, 'users', 1, 0, 'user'),
			(11, 'user roles', 1, 8, 'user_roles'),
			(12, 'role functional', 1, 8, 'role_functional')");
		$this->db->query("INSERT INTO `functional_user_role` (`functional_id`, `user_role_id`) VALUES
			(5, 1),
			(6, 1),
			(7, 1),
			(8, 1),
			(11, 1),
			(12, 1)");
	}

	public function down() {
		// $this->db->query("");
	}
}