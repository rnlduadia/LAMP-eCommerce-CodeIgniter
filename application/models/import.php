<?php

class import extends CI_Model {

    private $version = 1.1;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('file');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('import_history');
        $this->load->library('apputils');
    }

    function datafeeds(){
        if ($this->session->userdata('is_login') == TRUE)
        {
            $user_type = $this->session->userdata('type');
            if ($user_type == 2 || $user_type == 1) // a supplier or admin
            {
                $allowedExts = array("csv", "txt");
                $temp = explode(".", $_FILES["userfile"]["name"]);
                $extension = end($temp);

                if (($_FILES["userfile"]["size"] < 20000000)
                    && in_array(strtolower($extension), $allowedExts)) {
                    if ($_FILES["userfile"]["error"] > 0) {
                        return array('error' => "Error: " . $_FILES["userfile"]["error"], 'extension' => $extension);
                    }
                    else
                    {
                        // It's uploaded, so open it, loop through it and do what you need to do
                        if(in_array($_FILES["userfile"]["name"],array('delete.csv','delete.txt')))
                            $res = $this->doDelete($_FILES['userfile']['tmp_name'], $extension);
                        else
                            $res = $this->doImport($_FILES['userfile']['tmp_name'], $extension);
                        $res['created_at'] = date('Y-m-d H:i:s', time() + 10);
                        $res['extension'] = $extension;
                        return $res;
                    }
                } else {
                    return array('error' => 'Invalid File', 'extension' => $extension);
                }
            }
        }
    }

    public function checkVersion($meta)
    {
        if(is_array($meta)) {
            $meta = $meta[0];
        }
        $parts = explode(":", $meta);

        if(count($parts) != 3) {
            return false;
        }

        $res = preg_match('/Ver=([^\A-z]+)/', $parts[2], $matches);
        if(!$res) {
            return false;
        }

        $version = (float)$matches[1];

        return $version == $this->version;
    }

    function doImport($file, $type = 'csv', $cron = false)
    {
        gc_enable();
        $separator = $type == 'csv' ? ';' : "\t";
        @set_time_limit(0);
        @ini_set('max_execution_time', 0);
        $this->load->library('form_validation');
        $row=0;
        $total=0;
        $updated = 0;
        $inserted = 0;
        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 0, $separator)) !== FALSE)
            {
                echo "\0";
                if($total == 0) {
                    if(!$this->checkVersion($data)) {
                        return array('error' => 'Not supported version');
                    }
                }
                $total++;
                $num = count($data);
                if ( $total > 2 )
                {
                    unset($_POST);
                    $_POST = array();
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
                    
					$_POST['MinStockQTYTier1'] = $data[15];
                    $_POST['StockPriceTier1'] = $data[16];
                    
                    $_POST['DropShip_Selling_Price'] = $data[17];
                    
                    $_POST['MSRP'] = (trim($data[18])=='' || $data[18]==0) ? ($data[16]*3) : $data[18];
                    
                    $_POST['Promo_Text'] = $data[19];
                    $_POST['MAP'] = $data[20];
                    $_POST['Shipping_Cost'] = $data[21];
                    $_POST['ImageURL1'] = str_replace(':/','://',str_replace('\\','/',$data[22]));
                    $_POST['ImageURL2'] = str_replace(':/','://',str_replace('\\','/',$data[23]));
                    $_POST['ImageURL3'] = str_replace(':/','://',str_replace('\\','/',$data[24]));
                    $_POST['ImageURL4'] = str_replace(':/','://',str_replace('\\','/',$data[25]));
                    $_POST['ImageURL5'] = str_replace(':/','://',str_replace('\\','/',$data[26]));
                    $_POST['ImageURL6'] = str_replace(':/','://',str_replace('\\','/',$data[27]));
                    $_POST['Case_Pack'] = $data[28];
                    $_POST['Min_Order'] = $data[29];
                    
                    $_POST['Material'] = $data[30];
                    $_POST['Color'] = $data[31];
                    $_POST['Team'] = $data[32];

                    // Set validation rules.
                    $validation_rules = array(
                        array('field' => 'SKU', 'label' => 'SKU', 'rules' => 'trim|required'),
                        array('field' => 'Barcode', 'label' => 'Barcode', 'rules' => 'trim|required|numeric'),
                        array('field' => 'Manufacturer_Part_Number', 'label' => 'Manufacturer_Part_Number', 'rules' => 'trim|required'),
                        array('field' => 'Manufacturer_Name', 'label' => 'Manufacturer_Name', 'rules' => 'trim|required'),
                        array('field' => 'Brand_Name', 'label' => 'Brand_Name', 'rules' => 'trim|required'),
                        array('field' => 'Title', 'label' => 'Title', 'rules' => 'trim|required'),
                        array('field' => 'Description', 'label' => 'Description', 'rules' => 'trim|required'),
                        array('field' => 'Category_ID', 'label' => 'Category_ID', 'rules' => 'trim|required|numeric'),
                        array('field' => 'Weight', 'label' => 'Weight', 'rules' => 'trim|required'),
                        array('field' => 'Ship_Alone', 'label' => 'Ship_Alone', 'rules' => 'trim|required'),
                        array('field' => 'Height', 'label' => 'Height', 'rules' => 'trim'),
                        array('field' => 'Width', 'label' => 'Width', 'rules' => 'trim'),
                        array('field' => 'Depth', 'label' => 'Depth', 'rules' => 'trim'),
                        array('field' => 'LeadTime', 'label' => 'LeadTime', 'rules' => 'trim|required|numeric'),
                        array('field' => 'Quantity_In_Stock', 'label' => 'Quantity_In_Stock', 'rules' => 'trim|required|numeric'),
                        array('field' => 'StockPriceTier1', 'label' => 'StockPriceTier1', 'rules' => 'trim|required|greater_than[0]'),
                        array('field' => 'MinStockQTYTier1', 'label' => 'MinStockQTYTier1', 'rules' => 'trim|numeric'),
                        array('field' => 'DropShip_Selling_Price', 'label' => 'DropShip_Selling_Price', 'rules' => 'trim|numeric'),
                        array('field' => 'MSRP', 'label' => 'MSRP', 'rules' => 'trim'),
                        array('field' => 'Promo_Text', 'label' => 'Promo_Text', 'rules' => 'trim'),
                        array('field' => 'MAP', 'label' => 'MAP', 'rules' => 'trim'),
                        array('field' => 'Shipping_Cost', 'label' => 'Shipping_Cost', 'rules' => 'trim'),
                        array('field' => 'ImageURL1', 'label' => 'ImageURL1', 'rules' => 'trim|required|callback_urlisvalid'),
                        array('field' => 'ImageURL2', 'label' => 'ImageURL2', 'rules' => 'trim|callback_urlisvalid'),
                        array('field' => 'ImageURL3', 'label' => 'ImageURL3', 'rules' => 'trim|callback_urlisvalid'),
                        array('field' => 'ImageURL4', 'label' => 'ImageURL4', 'rules' => 'trim|callback_urlisvalid'),
                        array('field' => 'ImageURL5', 'label' => 'ImageURL5', 'rules' => 'trim|callback_urlisvalid'),
                        array('field' => 'ImageURL6', 'label' => 'ImageURL6', 'rules' => 'trim|callback_urlisvalid'),
                        array('field' => 'Case_Pack', 'label' => 'Case_Pack', 'rules' => 'trim|numeric'),
                        array('field' => 'Min_Order', 'label' => 'Min_Order', 'rules' => 'trim|numeric|greater_than[0]'),
                        array('field' => 'Material', 'label' => 'Material', 'rules' => 'trim'),
                        array('field' => 'Color', 'label' => 'Color', 'rules' => 'trim'),
                        array('field' => 'Team', 'label' => 'Team', 'rules' => 'trim')
                    );

                    $this->form_validation->reset_validation();
                    $this->form_validation->set_rules($validation_rules);

                    if ( $this->form_validation->run())
                    {
                        $db_row = array();
                        $db_row['SKU'] = $data[0];
                        $db_row['Barcode'] = $data[1];
                        $db_row['Manufacturer_Part_Number'] = $data[2];
                        $db_row['Manufacturer_Name'] = $data[3];
                        $db_row['Brand_Name'] = $data[4];
                        $db_row['Title'] = $data[5];
                        $db_row['Description'] = $data[6];
                        $db_row['Category_ID'] = $data[7];
                        $db_row['Weight'] = (float)$data[8];
                        $db_row['Ship_Alone'] = $data[9];
                        $db_row['Height'] = (float)$data[10];
                        $db_row['Width'] = (float)$data[11];
                        $db_row['Depth'] = (float)$data[12];
                        $db_row['LeadTime'] = $data[13];
                        $db_row['Quantity_In_Stock'] = $data[14];
                        
						$db_row['MinStockQTYTier1'] = (float)$data[15];
                        $db_row['StockPriceTier1'] = (float)$data[16];
                        
                        $db_row['DropShip_Selling_Price'] = (float)$data[17];
                        
                        $db_row['MSRP'] = (float)(trim($data[18])=='' || (float)$data[18]==0) ? ((float)$data[16]*3) : (float)$data[18];
                        
                        $db_row['Promo_Text'] = $data[19];
                        $db_row['MAP'] = $data[20];
                        $db_row['Shipping_Cost'] = ($data[21]=='') ? null : (float)$data[21];
                        $db_row['ImageURL1'] = $data[22];
                        $db_row['ImageURL2'] = $data[23];
                        $db_row['ImageURL3'] = $data[24];
                        $db_row['ImageURL4'] = $data[25];
                        $db_row['ImageURL5'] = $data[26];
                        $db_row['ImageURL6'] = $data[27];
                        $db_row['Case_Pack'] = $data[28];
                        $db_row['Min_Order'] = $data[29];
                        
                        $db_row['Material'] = $data[30];
                        $db_row['Color'] = $data[31];
                        $db_row['Team'] = $data[32];

                        $res = $this->insertDB($db_row);
                        if($res) {
                            $updated++;
                        } else {
                            $inserted++;
                        }
                        $row++;
                        
                        if( ( !isset($data[15]) || $data[15]==null || $data[15] == '' ) && (isset($data[16]) && $data[16]!=null && $data[16] !='') ){
                              $validation_errors[] = "Row {$total}: <span class='error'>MinStockQTYTier1 is required when StockPriceTier1 is provided</span> ";
                        }
                    }
                    else
                    {
                        $validation_errors[] = "Row {$total}: " . validation_errors('<span class="error">', '</span> ');
                    }
                }
            }

            fclose($handle);

            $verrors = '';

            foreach($validation_errors as $err) {
                $verrors = $verrors . "<div>$err</div>";
            }

            // done
            return array('imported' => $row, 'updated' => $updated, 'inserted' => $inserted, 'total' => $total - 2, 'verr' => $verrors);
        }
    }

    public function downloadImage($url, $i_id) {
        $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
        if(!in_array($ext, array('jpg', 'png', 'gif', 'jpeg'))) {
            return false;
        }
        $file_name = sha1(time() . "_" . rand(0,9999)) . "." . $ext;
        $group_dir = base_dir() . 'product_image/' . $this->inventories->get_image_upload_group_id($i_id) .'/';
        if(!file_exists($group_dir) || is_file($group_dir)) {
            if(!mkdir($group_dir)) {
                return false;
            } else chmod($group_dir,0777);
        }

        $dir = base_dir() . 'product_image/' . $this->inventories->get_image_upload_group_id($i_id) .'/'. $i_id . '/';
        if(!file_exists($dir) || is_file($dir)) {
            if(!mkdir($dir)) {
                return false;
            }
        }
        $save_path = $dir . $file_name;

        $fp = fopen($save_path, 'wb');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        if(function_exists('getimagesize')) {
            if(!is_array(getimagesize($save_path))) {
                @unlink($save_path);
                return false;
            }
        }

        return $save_path;
    }

    public function copyToProduct($path, $i_id) {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if(!in_array($ext, array('jpg', 'png', 'gif', 'jpeg'))) {
            return false;
        }

        $file_name = sha1(time() . "_" . rand(0,9999)) . "." . $ext;
        $group_dir = base_dir() . 'product_image/' . $this->inventories->get_image_upload_group_id($i_id) .'/'. $i_id . '/';
        if(!file_exists($group_dir) || is_file($group_dir)) {
            if(!mkdir($group_dir)) {
                return false;
            }
        }

        $dir = base_dir() . 'product_image/' . $this->inventories->get_image_upload_group_id($i_id) .'/'. $i_id . '/';
        if(!file_exists($dir) || is_file($dir)) {
            if(!mkdir($dir)) {
                return false;
            }
        }
        $save_path = $dir . $file_name;

        file_put_contents($save_path, file_get_contents($path));
        if(function_exists('getimagesize')) {
            if(!is_array(getimagesize($save_path))) {
                @unlink($save_path);
                return false;
            }
        }

        return $save_path;
    }

    public function insertDB($val)
    {

        $this->load->model('brands');
        $this->load->model('manufacturers');
        $this->load->model('inventories');
    	$this->load->model('suppliers');
        $val['Ship_Alone'] = $val['Ship_Alone'] == 'Y' || $val['Ship_Alone'] == 1 ? 1 : 0;
        $res = $this->db->delete('supplier_datafeeds', array('SKU' => $val['SKU'], 'user_id' => $this->session->userdata['id']));
        $sqlinsert = array(
            'user_id' => $this->session->userdata['id'],
            'SKU' => $val['SKU'],
            'Barcode' => $val['Barcode'],
            'Manufacturer_Part_Number' => $val['Manufacturer_Part_Number'],
            'Manufacturer_Name' => $val['Manufacturer_Name'],
            'Brand_Name' => $val['Brand_Name'],
            'Title' => $val['Title'],
            'Description' => $val['Description'],
            'Category_ID' => $val['Category_ID'],
            'Ship_Alone' => $val['Ship_Alone'],
            'Weight' => $val['Weight'],
            'Height' => $val['Height'],
            'Width' => $val['Width'],
            'Depth' => $val['Depth'],
            'LeadTime' => $val['LeadTime'],
            'Quantity_In_Stock' => $val['Quantity_In_Stock'],
            'StockPriceTier1' => $val['StockPriceTier1'],
            'DropShip_Selling_Price' => $val['DropShip_Selling_Price'],
            'MSRP' => (trim($val['MSRP'])=='' || $val['MSRP']==0) ? ($val['StockPriceTier1']*3) : $val['MSRP'],
            
            'Promo_Text' => $val['Promo_Text'],
            'MAP' => $val['MAP'],
            'Shipping_Cost' => $val['Shipping_Cost'],
            'ImageURL1' => $val['ImageURL1'],
            'ImageURL2' => $val['ImageURL2'],
            'ImageURL3' => $val['ImageURL3'],
            'ImageURL4' => $val['ImageURL4'],
            'ImageURL5' => $val['ImageURL5'],
            'ImageURL6' => $val['ImageURL6'],
            'Case_Pack' => $val['Case_Pack'] == "" ? 1 : $val['Case_Pack'] ,
            'Min_Order' => $val['Min_Order'] == "" ? 1 : $val['Min_Order'],
            'Material' => $val['Material']== '' ? "":$val['Material'],
            'Color' => $val['Color']== '' ? "":$val['Color'],
            'Team' => $val['Team']== '' ? "":$val['Team'],
            'MinStockQTYTier1' => ($val['MinStockQTYTier1'] == null || $val['MinStockQTYTier1'] == '') ? 1 : $val['MinStockQTYTier1'] 
        );

        $manufacturers = $this->manufacturers->listing($sqlinsert['Manufacturer_Name']);
        if(count($manufacturers) == 0) {
            $m_id = $this->manufacturers->add(array('m_name' => $sqlinsert['Manufacturer_Name']));
        } else {
            $m_id = $manufacturers[0]->m_id;
        }

        $brands = $this->brands->listing("", $sqlinsert['Brand_Name']);
        if(count($brands) == 0) {
            $b_id = $this->brands->add(array('b_name' => $sqlinsert['Brand_Name'],'m_id' => $m_id));
        } else {
            $b_id = $brands[0]->b_id;
        }



        $this->db->like(array('SKU' => $sqlinsert['SKU'], 'u_id' => $this->session->userdata['id']));

        $results = $this->db->get('inventory_child')->result();
        $upd = false;
        if(count($results) > 0) {
            $upd = true;
            $i_id = $results[0]->i_id;
            $child = $results[0]->ic_id;
        }

        $product = array(
            'u_id' => $this->session->userdata['id'],
	    'status' => 'active',
            'upc_ean' => $sqlinsert['Barcode'],
            'manuf_num' => $sqlinsert['Manufacturer_Part_Number'],
            'm_id' => $m_id,
            'b_id' => $b_id,
            'c_id' => $sqlinsert['Category_ID'],
            'weight' => $sqlinsert['Weight'],
            'weightScale' => 'Pounds',
            'qty' => 0,
            'ship_alone' => $sqlinsert['Ship_Alone'],
            'd_height' => $sqlinsert['Height'],
            'd_width' => $sqlinsert['Width'],
            'd_dept' => $sqlinsert['Depth'],
            'd_scale' => 'Inches',
            'i_time' => apputils::ConvertUnStampToMysqlDateTime(time()),
            'material' => $sqlinsert['material']==''?"":$sqlinsert['material'],
            'color' => $sqlinsert['color']==''?"":$sqlinsert['color'],
            'team' => $sqlinsert['team']==''?"":$sqlinsert['team']
        );

        if($upd) {
            $this->inventories->update($product, $i_id, 'i_id');
        } else {
            $i_id = $this->inventories->add($product);
        }

        /**
        Delete all images
        */
        $this->db->where('i_id',$i_id);
        $this->db->where('ii_src_url',NULL);
        $results = $this->db->get('inventory_image')->result();
        foreach($results as $result) {
            $path = base_dir() . 'product_image/' . $this->inventories->get_image_upload_group_id($result->i_id) .'/'. $result->i_id . '/' . $result->ii_name;
            if(file_exists($path)) {
                @unlink($path);
            }
            $this->db->where('ii_id', $result->ii_id);
            $this->db->delete('inventory_image');
        }

        for($i = 1; $i <= 6; $i++) {
            $img = trim($sqlinsert["ImageURL{$i}"]);
    		$img = $this->suppliers->norm_url($img);

            if(!empty($img)) {
        		$this->db->where('i_id',$i_id);
        		$this->db->where('ii_src_url',$img);
        		$i_results = $this->db->get('inventory_image')->result();

        		if(count($i_results) == 0) {
                    $path = false;
                    if(filter_var($img, FILTER_VALIDATE_URL)) {
                        $path = $this->downloadImage($img, $i_id);
                    } else {
                        $path = base_dir() . $img;
                        if(file_exists($path)) {
                            $path = $this->copyToProduct($path, $i_id);
                        } else {
                            $path = false;
                        }
                    }

                    if($path != false) {
                        $link = str_replace(base_dir(), '', $path);
                        $image_id = $this->inventories->add_image(array("i_id" => $i_id,
                           "ii_name" => basename($path),
                           "ii_link" => $link,
                           "ii_feat" => 0,
                           "ii_src_url" => $img,
                           "ii_time" => apputils::ConvertUnStampToMysqlDateTime(time())
                        ));
                    }
                }
            }
        }

        $translation = array('i_id' => $i_id,
           'c_id' => 236,
           'tr_title' => $sqlinsert['Title'],
           'tr_short_desc' => '',
           'tr_desc' => $sqlinsert['Description'],
           'tr_time' => apputils::ConvertUnStampToMysqlDateTime( time() )
        );
        if($upd) {
            $this->db->where(array('i_id' => $i_id, 'c_id' => 236));
            $res = $this->db->get('translation')->result();
            if(count($res) > 0) {
                $tr_id = $res[0]->tr_id;
                $this->inventories->update_translation($translation, $tr_id);
            } else {
                $this->inventories->add_product_translation($translation);
            }
        } else {
            $this->inventories->add_product_translation($translation);
        }


        $stock = array('i_id' =>$i_id,
            'u_id' =>$this->session->userdata['id'],
            'SKU' =>$sqlinsert['SKU'],
            'ic_quan' =>$sqlinsert['Quantity_In_Stock'],
            //'ic_price' =>$sqlinsert['StockPriceTier1'],
            'ic_price' =>$sqlinsert['DropShip_Selling_Price'],
            'ic_retail_price' => $sqlinsert['MSRP'],
            'ic_leadtime' => $sqlinsert['LeadTime'],
            'ic_map' => $sqlinsert['MAP'],
            'ic_ship_cost' => $sqlinsert['Shipping_Cost'],
            'ic_ship_country' => '236',
            'ic_prom_text' => $sqlinsert['Promo_Text'],
            'ic_time' => apputils::ConvertUnStampToMysqlDateTime( time() ),
            'ic_stockPriceTier1' => $sqlinsert['StockPriceTier1'],
            'ic_minStockQTYTier1' => ( $sqlinsert['MinStockQTYTier1']==null || $sqlinsert['MinStockQTYTier1'] =='') ? 1 : $sqlinsert['MinStockQTYTier1']
        );
        if($upd) {
            $this->inventories->update_stock($stock, 'ic_id', $child);
        } else {
            $ic_id = $this->inventories->add_stock($stock);
        }

        $this->db->insert('supplier_datafeeds', $sqlinsert);

        return $upd;
    }

    public function doDelete($file, $type = 'csv', $cron = false){
        gc_enable();
        $separator = $type == 'csv' ? ';' : "\t";
        @set_time_limit(0);
        @ini_set('max_execution_time', 0);
        $this->load->library('form_validation');
        $row=0;
        $total=0;
        $deleted = 0;
        $user_type = $this->session->userdata('type');
        $errors = array();
        $this->load->model('inventories');
        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1024, $separator)) !== FALSE)
            {
                $total++;
                    if($user_type == 2) {
                        $is = $this->db->get_where('inventory_child', array('SKU' => $data[0], 'u_id'=>$this->session->userdata('id')))->result();
                        if(!$is) {
                            $errors[] = '<b>' . $data[0] . '</b> - inventory does not exist';
                            continue;
                        }
                        if($is['u_id'] == $this->session->userdata('id'));
                        $res = $this->db->delete ('inventory_child', array('SKU' => $data[0], 'u_id'=>$this->session->userdata('id')));
                        if($res)
                            $deleted++;
                    }else {
                        $is = $this->db->get_where('inventory', array('manuf_num' => $data[0]))->result();
                        if(!$is || empty($is)) {
                            $errors[] = '<b>' . $data[0] . '</b> - inventory does not exist';
                            continue;
                        }
                        foreach($is as $inv) {
                            $this->db->where ('i_id', $inv->i_id);
                            $this->db->where ('ii_src_url', NULL);
                            $results = $this->db->get ('inventory_image')->result ();
                            foreach ($results as $result) {
                                $path = base_dir () . 'product_image/' . $this->inventories->get_image_upload_group_id ($result->i_id) . '/' . $result->i_id . '/' . $result->ii_name;
                                if (file_exists ($path)) {
                                    @unlink ($path);
                                }
                            }

                            $tables = array('inventory', 'inventory_image', 'inventory_child');
                            $this->db->where ('i_id', $inv->i_id);
                            $res = $this->db->delete ($tables);
                            $deleted++;
                        }
                    }
            }
            fclose($handle);
            return array('imported' => $row, 'updated' => 0, 'inserted' => 0, 'deleted' => $deleted, 'total' => $total, 'verr' => implode('<br>',$errors));
        }
        return false;
    }
}

?>