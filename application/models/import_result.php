<?php


class Import_result extends CI_Model {
    private $fields = array(
        'id' => array(
           'type' => 'INT',
           'unsigned' => TRUE,
           'auto_increment' => TRUE
        ),
        'results' => array(
            'type' => 'TEXT',
        )
    );

    public function __construct() {
        parent::__construct();
        $this->load->dbforge();

        $this->verify();
    }

    public function verify() {
        if(!$this->db->table_exists('import_result')) {
            $this->dbforge->add_field($this->fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table($this->db->dbprefix('import_result'));
        }
    }

    public function add($results) {
        $this->db->insert('import_result', array('results' => serialize($results)));

        return $this->db->insert_id();
    }

    public function get($id) {
        $this->db->where('id', $id);

        $res = $this->db->get('import_result')->result();

        if(count($res) > 0) {
            return $res[0];
        }

        return false;
    }

    public function delete($id) {
        $this->db->delete('import_result', array('id' => $id));
    }
}