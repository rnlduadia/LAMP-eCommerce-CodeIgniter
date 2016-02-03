<?php

class Apruve_Requests extends CI_Model {
    private $fields = array(
        'id' => array(
           'type' => 'INT',
           'unsigned' => TRUE,
           'auto_increment' => TRUE
        ),
        'user_id' => array(
            'type' => 'INT'
        ),
        'bt_id' => array(
            'type' => 'INT'
        ),
        'request_id' => array(
            'type' => 'VARCHAR',
            'constraint' => 255
        ),
        'total_cents' => array(
            'type' => 'INT'
        ),
        'status' => array(
            'type' => 'INT',
        ),
        'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    );

    public function __construct() {
        parent::__construct();
        $this->load->dbforge();

        $this->verify();
    }

    public function verify() {
        if(!$this->db->table_exists('apruve_requests')) {
            $this->dbforge->add_field($this->fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table($this->db->dbprefix('apruve_requests'));
        }
    }

    public function add($data)
    {
        $this->db->insert('apruve_requests', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->update('apruve_requests', $data, array('id' => $id));
    }

    public function get($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('apruve_requests')->row();
    }

    public function get_by_request_id($request_id)
    {
        $this->db->where('request_id', $request_id);

        return $this->db->get('apruve_requests')->row();
    }
}