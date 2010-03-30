<?php
class Users_Model extends Model {
  function Users_Model()
  {
    parent::Model();
    $this->CI =& get_instance();
    $this->table = 'Users';
  }

	//
	// This function will a delete by id.
	//
	function delete($id)
	{
		$this->db->where($this->table . 'Id', $id);
		$this->db->delete($this->table); 	
	}

	//
	// This function will return by id.
	//
	function get_by_id($id)
	{
		$data = 0;
		$this->db->where($this->table . 'Id', $id);
		if($row = $this->db->get($this->table)->row_array())
			$data = $this->_format_get($row);
		return $data;
	}

	//
	// This function will return by email.
	//
	function get_by_email($email)
	{
		$data = 0;
		$this->db->where($this->table . 'Email', $email);
		if($row = $this->db->get($this->table)->row_array())
			$data = $this->_format_get($row);
		return $data;
	}

	//
	// This function will return all records
	//
	function get($order = NULL)
	{
		$data = array();
		if(! is_null($order))
			$this->db->order_by($order);
		foreach($this->db->get($this->table)->result_array() AS $key => $row)
		{
			$row = $this->_format_get($row);
			$data[] = $row;
		}
		return $data;
	}
	
	//
	// This function will take the data passed in and insert it into the table
	//
	function insert($data)
	{
		if(! isset($data[$this->table . 'CreatedAt']))
			$data[$this->table . 'CreatedAt'] = date('Y-m-d G:i:s');
		$data = $this->_format_post($data);
		$q = $this->_set_data($data);
		$this->db->insert($this->table, $q);
		return $this->db->insert_id();
	}

	//
	// This function will take the data passed in and update it in the table by id.
	//
	function update($data, $id)
	{		
		$data = $this->_format_post($data);
		$q = $this->_set_data($data);
		$this->db->where($this->table . 'Id', $id);
		$this->db->update($this->table, $q);
		return 1;
	}

	
	/* ------- Formating Functions ---------- */
	
	//
	// This will take the post data and filter out the non table cols.
	//
	function _set_data($data)
	{
		$q = array();
		$fields = $this->db->list_fields($this->table);
		foreach ($fields AS $val) 
			if(isset($data[$val])) 
				$q[$val] = $data[$val];
		return $q;
	}
	
	//
	// Do some special formating for inserts and updates
	//
	function _format_post($data)
	{		
		return $data;	
	}
	
	//
	// Add extra data to get request.
	//
	function _format_get($data)
	{
		$data['FullName'] = $data['UsersFirstName'] . ' ' . $data['UsersLastName'];
		return $data;
	}
}
?>