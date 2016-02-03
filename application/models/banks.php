<?php

class Banks extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	function get($bnk_id)
	{
		$this->db->select('*');
		$this->db->where('bnk_id', $bnk_id);
		$result = $this->db->get('bank_account')->result();
		return $result[0]; 
	}

	function get_default_bank($u_id)
	{
		$this->db->select('*');
		$this->db->where('u_id', $u_id);
		$result = $this->db->get('bank_account')->result();
		return $result[0]; 
	}
	
	function add_bank_account($data) {
			
		$this->db->insert('bank_account', $data);
		return $this->db->insert_id();
	}
	
	function update_bank_account($data,$id) {
			
		$this->db->where('bnk_id', $id);	
		$this->db->update('bank_account', $data);
		//echo $this->db->last_query();
	}
	
	function deletebank($id) {
		$this->db->where('bnk_id', $id);
		$this->db->delete('bank_account');
	}

}

?>