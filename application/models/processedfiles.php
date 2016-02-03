<?php

class ProcessedFiles extends CI_Model {
    private $fields = array(
        'id' => array(
           'type' => 'INT',
           'constraint' => 5, 
           'unsigned' => TRUE,
           'auto_increment' => TRUE
        ),
        'path' => array(
           'type' => 'VARCHAR',
           'constraint' => '255',
        )
    );

    public function __construct() {
        parent::__construct();
        $this->load->dbforge();

        $this->verify();
    }

    public function verify() {
        if(!$this->db->table_exists('processed_files')) {
            $this->dbforge->add_field($this->fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_key('path');
            $this->dbforge->create_table($this->db->dbprefix('processed_files'));
        }
    }

    public function exists($fileName) {
        $res = $this->db->select()->where('path', $fileName)->get('processed_files');

        return $res->num_rows() > 0;
    }

    public function add($fileName) {
        $this->db->insert('processed_files', array('path' => $fileName));
    }

}