<?php

class Import_history extends CI_Model {
    private $fields = array(
        'id' => array(
           'type' => 'INT',
           'unsigned' => TRUE,
           'auto_increment' => TRUE
        ),
        'user_id' => array(
            'type' => 'INT',
        ),
        'success' => array(
            'type' => 'INT',
        ),
        'result_id' => array(
            'type' => 'INT'
        ),
        'total' => array(
            'type' => 'INT',
        ),
        'inserted' => array(
            'type' => 'INT',
        ),
        'updated' => array(
            'type' => 'INT',
        ),
        'deleted' => array(
            'type' => 'INT',
        ),
        'type' => array(
            'type' => 'INT',
            'constraint' => 1,
            'default' => 0,
        ),
        'file_type' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                    'default' => 'csv'
                ),
        'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    );

    public function __construct() {
        parent::__construct();
        $this->load->dbforge();

        $this->verify();
    }

    public function verify() {
        if(!$this->db->table_exists('import_history') || !$this->db->field_exists('success', 'import_history') || !$this->db->field_exists('result_id', 'import_history')) {
            $this->dbforge->drop_table('import_history');
            $this->dbforge->add_field($this->fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table($this->db->dbprefix('import_history'));
        }

        if(!$this->db->field_exists('file_type', 'import_history')) {
            $fields = array(
                'file_type' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                    'default' => 'csv'
                )
            );
            $this->dbforge->add_column('import_history', $fields);
        }
    }

    public function add($userId, $total, $inserted, $updated, $deleted = 0, $type = 0, $file_type = 'csv', $success = 1, $result_id = 0) {
        $this->db->insert('import_history', array(
            'user_id' => $userId,
            'total' => $total,
            'inserted' => $inserted,
            'updated' => $updated,
            'deleted' => is_null($deleted)?0:$deleted,
            'type' => $type,
            'file_type' => $file_type,
            'success' => $success,
            'result_id' => $result_id
        ));

        return $this->db->insert_id();
    }
    
     public function update($import_history_id, $total, $inserted, $updated, $deleted = 0, $type = 0, $file_type = 'csv', $success = 1, $result_id = 0) {
        try
        {
          $this->db->where('id', $import_history_id);

          $this->db->update('import_history', array(
            'total' => $total,
            'inserted' => $inserted,
            'updated' => $updated,
            'deleted' => is_null($deleted)?0:$deleted,
            'type' => $type,
            'file_type' => $file_type,
            'success' => $success,
            'result_id' => $result_id
        )); 
          return 1;
        } 
        catch (Exception $ex) 
        {
           return 0;
        } 
         

        
    }
    

    public function get($userId, $page = 1, $perpage = 25) {
        $this->db->where('user_id', $userId);
        $this->db->order_by('created_at', 'desc');
        $offset = ($page - 1) * $perpage;
        $this->db->limit($perpage, $offset);
        $this->load->model('import_result');

        $results = $this->db->get('import_history')->result();
        foreach($results as $key => $result) {
            if($result->result_id != 0) {
                $re = $this->import_result->get($result->result_id);
                $results[$key]->results = unserialize($re->results);
            }
        }

        return $results;
    }

    public function last($userId, $type) {
        $this->db->where('user_id', $userId);
        $this->db->where('file_type', $type);

        $this->db->order_by('created_at', 'desc');

        $results = $this->db->get('import_history')->result();
        if(count($results) > 0) {
            return $results[0];
        }

        return false;
    }

}