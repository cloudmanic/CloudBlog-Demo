<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cloudauth {
	function Cloudauth()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('users_model');
		$this->email = 'support@cloudmanic.com';
		$this->from = 'Cloudmanic Labs Support';
	}
	
	//
	// Call this function in the constuctor of your controller. It checks to see if we have a session. 
	// If we do it sets some vars. If not it redirects us out of here.
	//
	function sessioninit($groups = array('all'))
	{
		if($user = $this->CI->session->userdata('LoggedIn')) 
			if(isset($user['UsersId']))
				if($this->CI->data['me'] = $this->CI->users_model->get_by_id($user['UsersId'])) {
					unset($user['UsersPassword']);
					$this->CI->session->set_userdata('LoggedIn', $user);
					
					// Check to see if this user's group is allowed on this page
					$this->_checkgroups($groups, $this->CI->data['me']['UsersUserType']);
						
					return $this->CI->data['me'];
				}
		
		// User is not logged in.
		$this->CI->session->unset_userdata('LoggedIn');
		redirect(site_url());	
	}
	
	//
	// This function will auth a user and create their session. Returns 0 or 1
	//
	function auth($email, $password)
	{
		$email = trim($email);
		if(empty($email))
			return 0;
			
		if($user = $this->CI->users_model->get_by_email(trim($email))) {
			if(trim($user['UsersPassword']) == md5($password)) {
				unset($user['UsersPassword']);
				$this->CI->session->set_userdata('LoggedIn', $user);
		  	redirect(site_url());	
			}
		} 
		return 0;
	}
	

	//
	// Return the user if it exists.
	//
	function get_user_by_email($email)
	{
		return $this->CI->users_model->get_by_email($email);	
	}
	
	
	//
	// This function will take an email and if it is in the system rest the password and email the user.
	//
	function restpassword($email)
	{
		if($user = $this->get_user_by_email(trim($email))) {
			$data['pass'] = random_string('alnum', 9);
			$data['UsersPassword'] = md5($data['pass']);
			$data['UsersUpdatePW'] = 1;
			$this->CI->users_model->update($data, $user['UsersId']);
			$data['name'] = $user['UsersFirstName'];
		
			// Send email with temp password.
			$this->CI->email->from($this->email, $this->from);
			$this->CI->email->to($email);
			$this->CI->email->subject('Password Recovery');
			$this->CI->email->message($this->CI->load->view('emails/rest-password', $data, TRUE));
			$this->CI->email->send();
			return 1;
		}
		return 0;
	}
	
	//
	// This function will change a user's password by passing in a new password.
	//
	function changepassword($userid, $password)
	{
		if($user = $this->CI->users_model->get_by_id(trim($userid))) {
			$data['UsersPassword'] = md5($password);
			$data['UsersUpdatePW'] = 0;
			return $this->CI->users_model->update($data, $user['UsersId']);
		}
		return 0;
	}

	//
	// This function will log a user out of the system.
	//
	function logout()
	{
		$this->CI->session->sess_destroy();
		redirect(site_url());		
	}

	/* ------ Private helper Functions. --------------- */
	
	//
	// Check to see what groups are allowed on this page.
	//
	function _checkgroups($groups, $usergroup)
	{			
		foreach($groups AS $key => $row)
		{
			if($row == 'all')
				return 1;
			
			if($row == $usergroup)
				return 1;
		}
		
		// user not allowed here.
		redirect(site_url());
	}
}
?>