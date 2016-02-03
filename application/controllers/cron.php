<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('import');
        $this->load->model('users');
        $this->load->model('import_history');
        $this->load->model('import_result');
    }

    public function parsesupplierscsv() {
        $filesDir = base_dir() . 'suppliers_files';
        if(!file_exists($filesDir) || !is_dir($filesDir)) {
            echo 'dir not found';
            exit;
        }
        $dir = opendir($filesDir);

        while(false !== ($file = readdir($dir))) {
            if($file == '.' || $file == '..' || !preg_match('/^\d+$/', $file))
                continue;

            $this->session->userdata['id'] = $file;

            $this->import($filesDir, 'txt');
            $this->import($filesDir, 'csv');
        }
        echo '';
        return;
    }

    public function import($filesDir, $type) {
        $userid = $this->session->userdata['id'];
        $dirName = $filesDir . DIRECTORY_SEPARATOR . $userid;
        $importFile = $dirName . DIRECTORY_SEPARATOR . "import." . $type;
        echo $importFile;
            
        if(file_exists($importFile) && is_file($importFile)) 
        {
            $result = $this->import_history->last($userid, $type);
            if($result) 
            {
                $lastUpdate = strtotime($result->created_at);
                $fileModifiedDate = filemtime($importFile);
                if($lastUpdate > $fileModifiedDate) 
                {
                    return;
                }
            }
            //Enter a record in the DB for starting the import process
            $id = $this->import_history->add($userid, 0, 0, 0, 0, 1, $type, -1, 0);
            
            $results = $this->import->doImport($importFile, $type, true);
            
            $result_id = $this->import_result->add($results);
            
            if($results['error']) {
                $id = $this->import_history->update($id, 0, 0, 0, 0, 1, $type, 0, $result_id);
            } else {
                $res = @unlink($importFile);
                if(!$res) {
                    echo "Can not remove file";
                }
                $id = $this->import_history->update($id, $results['total'], $results['inserted'], $results['updated'], 0, 1, $type, 1, $result_id);
            }
            if ($id==0)
            {
                echo "Could not update import status. Please contact us for assistance";
            }
        }
    }
}