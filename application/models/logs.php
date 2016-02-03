<?php

class Logs extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	function add($data)
	{
		$this->db->insert('logs', $data);
		return $this->db->insert_id();
	}

	function info($id)
	{
		$this->db->select('*');
		$this->db->where('log_id', $id);
		$result = $this->db->get('logs');
		$row = $result->row(1);

		return $row;
	}

	function listing($u_id = '')
	{
		$this->db->select('*');
		$this->db->join('user', 'user.u_id = logs.u_id', 'left');
		if ($u_id != '')
		  $this->db->where('logs.u_id', $u_id);
		$this->db->order_by(logtime,'DESC');

        // pagination start
        $pagination = array();
        $pagination['curent_page'] = intval($_GET['page'])>0 ? intval($_GET['page']) : 1 ;
        $pagination['per_page'] = 20;
        // pagination end

        $start_limit = ($pagination['curent_page'] - 1) * $pagination['per_page'];
        $result = $this->db->limit($pagination['per_page'], $start_limit);

		$result = $this->db->get('logs');

        $this->db->select("FOUND_ROWS() as count",false);
		if ($u_id != '')
		  $this->db->where('logs.u_id', $u_id);
        $count = $this->db->get('logs');
        $pagination['num_strings'] = $count->num_rows;
        $pagination['num_pages'] = ceil($pagination['num_strings'] / $pagination['per_page']);

        $return = array('result' => $result->result(), 'pagination' => $pagination);

		return $return;
	}

}

?>