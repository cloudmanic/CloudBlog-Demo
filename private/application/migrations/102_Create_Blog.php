<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Create_ClassComments {
	function up() 
	{
		$CI =& get_instance();
 		
 		if($CI->migrate->verbose)
			echo "Creating table ClassComments...";
 		
 		// Setup Comments Table
		if(! $CI->db->table_exists('ClassComments')) {
			$cols = array(
				'ClassCommentsId' => array('type' => 'INT', 'constraint' => 5, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'ClassCommentsUserId' => array('type' => 'INT', 'constraint' => '9', 'unsigned' => TRUE, 'null' => FALSE),
				'ClassCommentsMessageId' => array('type' => 'INT', 'constraint' => '9', 'unsigned' => TRUE, 'null' => FALSE),
				'ClassCommentsText' => array('type' => 'TEXT', 'null' => FALSE)
			);
			$CI->dbforge->add_key('ClassCommentsId', TRUE);
			$CI->dbforge->add_key('ClassCommentsUserId');
			$CI->dbforge->add_key('ClassCommentsMessageId');
    	$CI->dbforge->add_field($cols);
    	$CI->dbforge->add_field("ClassCommentsCreatedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
    	$CI->dbforge->create_table('ClassComments', TRUE);
		}
	}
 
	function down() 
	{
		$CI =& get_instance();
		if($CI->migrate->verbose)
			echo "Dropping table ClassComments...";
		$CI->dbforge->drop_table('ClassComments');
	}
}
?>