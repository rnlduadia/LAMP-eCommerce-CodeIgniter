<?php

class Datafeedfiles extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	function add($data)
	{
		$this->db->insert('buyer_data_feed_files', $data);
		return $this->db->insert_id();
	}

	function update_date($id, $date)
	{
		$this->db->where('id', intval($id));
		$this->db->update('buyer_data_feed_files', array('date'=>$date));
	}

	function get_file($user_id = "", $type)
	{
		$this->db->select('*');
		if($user_id != "")
			$this->db->where('user_id', intval($user_id));
		if($type != "")
			$this->db->where('type', $type);

		$this->db->order_by('date', 'desc');

		$result = $this->db->get('buyer_data_feed_files');

		if($type == "datafeed"){
			return $result->result();
		}

		if($result->num_rows == 1)
			$result = $result->row(1);
		elseif($result->num_rows > 1)
		{
			$result = reset($result->result());
		}
		else $result = false;

		return $result;
	}
	
	function delete($id){
     	   $this->db->select('*');
 	   $this->db->where('id', $id);
	   $result = $this->db->get('buyer_data_feed_files');
	   if ($result->num_rows() > 0) {
        	$result = $result->row(1);
	   }
	   $filename = $result->filename;
	   $this->db->where('id', $id);
	   $this->db->delete('buyer_data_feed_files'); 
	   if($this->db->affected_rows()){
		// delete file
		$file = realpath(APPPATH . "../user_export_files") . DIRECTORY_SEPARATOR . $filename;
		unlink($file);
	   }
	}

}

?>