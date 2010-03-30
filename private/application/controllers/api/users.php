<?php
require(APPPATH.'/libraries/REST_Controller.php');
 
class Users extends REST_Controller 
{
	//
	// Get all or by id.
	//
	function get_get()
	{
		if($this->get('id'))
			$data = $this->users_model->get_by_id($this->get('id'));
		else
			$data = $this->users_model->get();
		
		if($data) {
			$this->response($data, 200);
		} else {
			$data = array();
			$data['status'] = 'error';
			$data['error'] = 'No Data Found';
			$this->response($data, 200);
		}
	}
}
?>