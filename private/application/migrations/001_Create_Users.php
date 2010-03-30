<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Create_users {
	function up() 
	{
		$CI =& get_instance();
 		
 		if($CI->migrate->verbose)
			echo "Creating table Users...";
 
		// Setup Users Table
		if(! $CI->db->table_exists('Users')) {
			$cols = array(
				'UsersId' => array('type' => 'INT', 'constraint' => 5, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'UsersFirstName' => array('type' => 'VARCHAR', 'constraint' => '200', 'null' => FALSE),
				'UsersLastName' => array('type' => 'VARCHAR', 'constraint' => '200', 'null' => FALSE),
				'UsersAddress' => array('type' => 'TEXT', 'null' => FALSE),
				'UsersCity' => array('type' => 'VARCHAR', 'constraint' => '200', 'null' => FALSE),
				'UsersState' => array('type' => 'VARCHAR', 'constraint' => '200', 'null' => FALSE),
				'UsersZip' => array('type' => 'VARCHAR', 'constraint' => '10', 'null' => FALSE),
				'UsersPrimaryPhone' => array('type' => 'VARCHAR', 'constraint' => '12', 'null' => FALSE),
				'UsersSecondaryPhone' => array('type' => 'VARCHAR', 'constraint' => '12', 'null' => FALSE),
				'UsersTitle' => array('type' => 'VARCHAR', 'constraint' => '200', 'null' => FALSE),
				'UsersEmail' => array('type' => 'VARCHAR', 'constraint' => '200', 'null' => FALSE),
				'UsersPassword' => array('type' => 'VARCHAR', 'constraint' => '200', 'null' => FALSE),
				'UsersUserType' => array('type' => 'enum("Employee","Admin")', 'default' => 'Employee', 'null' => FALSE),
				'UsersDOB' => array('type' => 'Date', 'null' => FALSE),
				'UsersUpdatePW' => array('type' => 'INT', 'constraint' => 1, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0)
			);
			$CI->dbforge->add_key('UsersId', TRUE);
    	$CI->dbforge->add_field($cols);
    	$CI->dbforge->add_field("CardsUpdatedAt TIMESTAMP DEFAULT now() ON UPDATE now()");
    	$CI->dbforge->add_field("CardsCreatedAt TIMESTAMP DEFAULT '0000-00-00 00:00:00'");
    	$CI->dbforge->create_table('Users', TRUE);
		}
	}
 
	function down() 
	{
		$CI =& get_instance();
		if($CI->migrate->verbose)
			echo "Dropping table users...";
		$CI->dbforge->drop_table('Users');
	}
}
?>