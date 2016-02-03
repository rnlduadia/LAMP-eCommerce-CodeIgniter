<?php

class Datafeed extends CI_Model {

	function __construct()
	{
        // Call the Model constructor
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper('form');
		$this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('processedfiles');
	}

	function listing($id = "")
	{
		$this->db->select('*');
		if($id != "")
			$this->db->where('m_id', $id);

		$result = $this->db->get('buyer_data_feed');

		return $result->result();
	}

	function import(){
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type');
            if ($user_type == 2) // a buyer
            {
                $upDir = base_dir() . 'supplier_files/' . $this->session->userdata['id'];
                if(!file_exists($upDir) || is_file($upDir)) {
                    mkdir($upDir);
                }
            	$config['upload_path'] = $upDir;
            	$config['allowed_types'] = 'csv';
            	$config['max_size']	= '1000';

            	$this->load->library('upload', $config);

            	if ( ! $this->upload->do_upload())
            	{
            		$error = array('error' => $this->upload->display_errors());
            		print_r($error);
            	}
            	else
            	{
					// It's uploaded, so open it, loop through it and do what you need to do
            		$data = array('upload_data' => $this->upload->data());
            		$file_path = $data['upload_data']['full_path'];
            		$this->doImport($file_path);
                    $this->processedfiles->add($file_path);
            	}
            }
        }
    }

    /**
    DO NOT REMOVE THIS FUNCTION PLEASE REQUIRED BY CRON JOB CONTROLLER
    */
    public function doImport($filename) {
    	$row=1;
    	$count=0;
    	$db_row = array();
    	if (($handle = fopen($filename, "r")) !== FALSE) {
    		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    			$count++;
    			$row++;
    			if ( $count != 1 )
    			{
								//die;
								//$db_row[$row]['xxx'] = $data[0];
								// Any database insertion goes here...

								// post
    				$_POST['SKU'] = $data[0];
    				$_POST['Barcode'] = $data[1];
    				$_POST['Manufacturer_Part_Number'] = $data[2];
    				$_POST['Manufacturer_Name'] = $data[3];
    				$_POST['Brand_Name'] = $data[4];
    				$_POST['Title'] = $data[5];
    				$_POST['Description'] = $data[6];
    				$_POST['Category_ID'] = $data[7];
    				$_POST['Weight'] = $data[8];
    				$_POST['Ship_Alone'] = $data[9];
    				$_POST['Height'] = $data[10];
    				$_POST['Width'] = $data[11];
    				$_POST['Depth'] = $data[12];
    				$_POST['LeadTime'] = $data[13];
    				$_POST['Quantity_In_Stock'] = $data[14];
    				$_POST['Selling_Price'] = $data[15];
    				$_POST['MSRP'] = $data[16];
    				$_POST['Promo_Text'] = $data[17];
    				$_POST['MAP'] = $data[18];
    				$_POST['Shipping_Cost'] = $data[19];
    				$_POST['ImageURL1'] = $data[20];
    				$_POST['ImageURL2'] = $data[21];
    				$_POST['ImageURL3'] = $data[22];
    				$_POST['ImageURL4'] = $data[23];
    				$_POST['ImageURL5'] = $data[24];
    				$_POST['ImageURL6'] = $data[25];
    				$_POST['Case_Pack'] = $data[26];
    				$_POST['Min_Order'] = $data[27];

								// Set validation rules.
    				$validation_rules = array(
    					array('field' => 'SKU', 'label' => 'SKU', 'rules' => 'trim|required|callback__alpha_dash_space'),
    					array('field' => 'Barcode', 'label' => 'Barcode', 'rules' => 'trim|required|numeric'),
    					array('field' => 'Manufacturer_Part_Number', 'label' => 'Manufacturer_Part_Number', 'rules' => 'trim|required|callback__alpha_dash_space'),
    					array('field' => 'Manufacturer_Name', 'label' => 'Manufacturer_Name', 'rules' => 'trim|required|callback__alpha_dash_space'),
    					array('field' => 'Brand_Name', 'label' => 'Brand_Name', 'rules' => 'trim|required|callback__alpha_dash_space'),
    					array('field' => 'Title', 'label' => 'Title', 'rules' => 'trim|required|alpha_dash_space'),
    					array('field' => 'Description', 'label' => 'Description', 'rules' => 'trim|required|callback__alpha_dash_space'),
    					array('field' => 'Category_ID', 'label' => 'Category_ID', 'rules' => 'trim|required|numeric'),
    					array('field' => 'Weight', 'label' => 'Weight', 'rules' => 'trim|required|numeric'),
    					array('field' => 'Ship_Alone', 'label' => 'Ship_Alone', 'rules' => 'trim|required|callback__alpha_dash_space'),
    					array('field' => 'Height', 'label' => 'Height', 'rules' => 'trim|numeric'),
    					array('field' => 'Width', 'label' => 'Width', 'rules' => 'trim|numeric'),
    					array('field' => 'Depth', 'label' => 'Depth', 'rules' => 'trim|numeric'),
    					array('field' => 'LeadTime', 'label' => 'LeadTime', 'rules' => 'trim|required|numeric'),
    					array('field' => 'Quantity_In_Stock', 'label' => 'Quantity_In_Stock', 'rules' => 'trim|required|numeric'),
    					array('field' => 'Selling_Price', 'label' => 'Selling_Price', 'rules' => 'trim|required|numeric'),
    					array('field' => 'MSRP', 'label' => 'MSRP', 'rules' => 'trim|numeric'),
    					array('field' => 'Promo_Text', 'label' => 'Promo_Text', 'rules' => 'trim|callback__alpha_dash_space'),
    					array('field' => 'MAP', 'label' => 'MAP', 'rules' => 'trim|numeric'),
    					array('field' => 'Shipping_Cost', 'label' => 'Shipping_Cost', 'rules' => 'trim|numeric'),
    					array('field' => 'ImageURL1', 'label' => 'ImageURL1', 'rules' => 'trim|required|callback__alpha_dash_space'),
    					array('field' => 'ImageURL2', 'label' => 'ImageURL2', 'rules' => 'trim|callback__alpha_dash_space'),
    					array('field' => 'ImageURL3', 'label' => 'ImageURL3', 'rules' => 'trim|callback__alpha_dash_space'),
    					array('field' => 'ImageURL4', 'label' => 'ImageURL4', 'rules' => 'trim|callback__alpha_dash_space'),
    					array('field' => 'ImageURL5', 'label' => 'ImageURL5', 'rules' => 'trim|callback__alpha_dash_space'),
    					array('field' => 'ImageURL6', 'label' => 'ImageURL6', 'rules' => 'trim|callback__alpha_dash_space'),
    					array('field' => 'Case_Pack', 'label' => 'Case_Pack', 'rules' => 'trim|numeric'),
    					array('field' => 'Min_Order', 'label' => 'Min_Order', 'rules' => 'trim|numeric')
    				);

                    $this->form_validation->set_rules($validation_rules);

                    if ( $this->form_validation->run())
                    {
                    	$db_row[$row]['SKU'] = $data[0];
                    	$db_row[$row]['Barcode'] = $data[1];
                    	$db_row[$row]['Manufacturer_Part_Number'] = $data[2];
                    	$db_row[$row]['Manufacturer_Name'] = $data[3];
                    	$db_row[$row]['Brand_Name'] = $data[4];
                    	$db_row[$row]['Title'] = $data[5];
                    	$db_row[$row]['Description'] = $data[6];
                    	$db_row[$row]['Category_ID'] = $data[7];
                    	$db_row[$row]['Ship_Alone'] = $data[8];
                    	$db_row[$row]['Weight'] = $data[9];
                    	$db_row[$row]['Height'] = $data[10];
                    	$db_row[$row]['Width'] = $data[11];
                    	$db_row[$row]['Depth'] = $data[12];
                    	$db_row[$row]['LeadTime'] = $data[13];
                    	$db_row[$row]['Quantity_In_Stock'] = $data[14];
                    	$db_row[$row]['Selling_Price'] = $data[15];
                    	$db_row[$row]['MSRP'] = $data[16];
                    	$db_row[$row]['Promo_Text'] = $data[17];
                    	$db_row[$row]['MAP'] = $data[18];
                    	$db_row[$row]['Shipping_Cost'] = $data[19];
                    	$db_row[$row]['ImageURL1'] = $data[20];
                    	$db_row[$row]['ImageURL2'] = $data[21];
                    	$db_row[$row]['ImageURL3'] = $data[22];
                    	$db_row[$row]['ImageURL4'] = $data[23];
                    	$db_row[$row]['ImageURL5'] = $data[24];
                    	$db_row[$row]['ImageURL6'] = $data[25];
                    	$db_row[$row]['Case_Pack'] = $data[26];
                    	$db_row[$row]['Min_Order'] = $data[27];
                    }
                    else
                    {
                    	//echo validation_errors('<div>', '</div>');
                    }
                }
            }

							#print_r($db_row);
            while (list($var, $val) = each($db_row)) {
            	$sqlinsert = array(
            		'user_id' => $this->session->userdata['id'],
            		'SKU' => $data[0],
                	'Barcode' => $data[1],
                	'Manufacturer_Part_Number' => $data[2],
            		'Manufacturer_Name' => $data[3],
            		'Brand_Name' => $data[4],
            		'Title' => $data[5],
            		'Description' => $data[6],
                	'Category_ID' => $data[7],
                	'Ship_Alone' => $data[8],
            		'Weight' => $data[9],
            		'Height' => $data[10],
            		'Width' => $data[11],
            		'Depth' => $data[12],
                	'LeadTime' => $data[13],
                	'Quantity_In_Stock' => $data[14],
            		'Selling_Price' => $data[15],
            		'MSRP' => $data[16],
            		'Promo_Text' => $data[17],
            		'MAP' => $data[18],
                	'Shipping_Cost' => $data[19],
                	'ImageURL1' => $data[20],
            		'ImageURL2' => $data[21],
            		'ImageURL3' => $data[22],
            		'ImageURL4' => $data[23],
            		'ImageURL5' => $data[24],
                	'ImageURL6' => $data[25],
                	'Case_Pack' => $data[26],
            		'Min_Order' => $data[27]
            	);
				#print_r($sqlinsert);
               $this->db->insert('buyer_data_feed', $sqlinsert);
            }
            // done
            $row = $row -1;
            $message = "All $row feeds imported.";
            print ('<script>alert("'.$message.'");</script>');
        }
    }
}

?>