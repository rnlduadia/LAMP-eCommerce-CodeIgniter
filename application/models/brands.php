<?php

class Brands extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	function add($data)
	{
		$this->db->insert('brand', $data);
		return $this->db->insert_id();
	}

	function info($id)
	{
		$this->db->select('*');
		$this->db->where('b_id', $id);
		$result = $this->db->get('brand');
		$row = $result->row(1);

		return $row;
	}

	function listing($id = "",$name = "",$is_top = "")
	{
		$this->db->select('*');
		if($id != "")
			$this->db->where('m_id', $id);

		if($name != "");
			$this->db->like('b_name', $name, 'after');

		if($is_top != "") {
			$this->db->where ('is_top', $is_top ? 1 : 0);
			$this->db->where ('logo != ""', null, false);
		}

		$result = $this->db->get('brand');

		return $result->result();
	}

}

?>