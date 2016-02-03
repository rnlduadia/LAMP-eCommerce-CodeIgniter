<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('str_putcsv'))
{
    function str_putcsv($input, $delimiter = ',', $enclosure = '"')
    {
        // Open a memory "file" for read/write...
        $fp = fopen('php://temp', 'r+');
        // ... write the $input array to the "file" using fputcsv()...
        fputcsv($fp, $input, $delimiter, $enclosure);
        // ... rewind the "file" so we can read what we just wrote...
        rewind($fp);
        // ... read the entire line into a variable...
        $data = fread($fp, 1048576);
        // ... close the "file"...
        fclose($fp);
        // ... and return the $data to the caller, with the trailing newline from fgets() removed.
        return rtrim($data, "\n");
    }
}

if(!function_exists('my_force_download'))
{
    function my_force_download($file_name)
    {

// make sure it's a file before doing anything!
     if(is_file($file_name)) {


	// required for IE
	if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');	}

	// get the file mime type using the file extension
	switch(strtolower(substr(strrchr($file_name, '.'), 1))) {
		case 'pdf': $mime = 'application/pdf'; break;
		case 'zip': $mime = 'application/zip'; break;
		case 'jpeg':
		case 'jpg': $mime = 'image/jpg'; break;
		default: $mime = 'application/force-download';
	}
	header('Pragma: public'); 	// required
	header('Expires: 0');		// no cache
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file_name)).' GMT');
	header('Cache-Control: private',false);
	header('Content-Type: '.$mime);
	header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: '.filesize($file_name));	// provide file size
	header('Connection: close');
	readfile($file_name);		// push it out
	exit();

      }
    }
}

class datafeed extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //Load Neccessary Models
	$this->load->model('datafeeds');
	$this->load->model('datafeedfiles');
	$this->load->model('logs');
		//$this->load->model('');
        //End Load Neccessary Models
        //$this->config->load('authorized');
        //$this->load->view('',$data);

    }

    function add(){
        $result = array("result"=>"false");
        $user_type = 0;
        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type');
        }
        if ($user_type == 3) // a buyer
        {
            // $this->session->userdata['id']; - user ID
            // $this->input->get(''); // $_GET
            // `buyer_data_feed`
            //echo $this->input->is_ajax_request()?'y':'n';
            //echo $this->input->get('product_id');
            if($this->session->userdata('is_login') == TRUE) {
                $this->db->select('id');
                $this->db->from('buyer_data_feed');
                $this->db->where('user_id', $this->session->userdata['id']);
                $this->db->where('prod_id', intval($this->input->get('product_id')));
                $query = $this->db->get();

                if(!$query->num_rows){
                    $data = array(
                       'user_id' => $this->session->userdata['id'],
                       'prod_id' => intval($this->input->get('product_id'))
                    );
                    $this->db->insert('buyer_data_feed', $data);
                }

                $result = array("result"=>"true");
            }
        }

        echo json_encode($result);
    }

    function download(){
	    $this->load->model('users');
        $this->load->library('encrypt');
        $result = array("result"=>"false");
        $user_type = 0;
        if($this->session->userdata('is_login') == true) {
            $user_type = $this->session->userdata('type');
        } else {
            $user_type = 3;
        }
        $hash = $this->input->get('hash');
        if(!$hash) {
            redirect('/');
            return;
        }

        $hash = $this->encrypt->decode($hash);
        $data = unserialize($hash);
        if(!$data) {
            redirect('/');
            return;
        }

		$datal['u_id'] = $this->session->userdata('id');
		$datal['event'] = "download";
		$datal['module'] = "datafeed/download";
		$datal['additional'] = $data['extract'].".".$data['type'];
		$this->logs->add($datal);

        if ($user_type == 3 && $data['extract']) // a buyer
        {
    		$extract = trim($data['extract']);
            $type = $data['type'];

            $temp_dir = base_dir() . 'buyers_files' . DIRECTORY_SEPARATOR;
			if (!file_exists($temp_dir.$extract.".".$type)||($extract!=('all'||'dropshipping'))) {

    		switch($extract){
    			case 'custom':
                    $u_id = $data['user_id'];
                    if(!$u_id) {
                        redirect("/");
                    }
                    $datafeed = $this->datafeeds->custom_prodlist($u_id);
    			break;
    			case 'supplier':
                    $s_id = $data['id'];
                    $supplier_info = $this->users->info($s_id);
    				$datafeed = $this->datafeeds->prodlist($extract, $s_id);
                    $companyName = strtolower(preg_replace('/[\s]+/i', '_', $supplier_info->u_company));
                    $extract = preg_replace('/[\_]{2,}/i', '_', $companyName);
    			break;
    			case 'dropshipping':
    				$datafeed = $this->datafeeds->prodlist($extract);
    			break;
    			case 'all':
    			default:
    				$datafeed = $this->datafeeds->prodlist();
    			break;
    		}

    		}

	    $usrdir = ($extract == 'custom') ? $data['user_id'] . DIRECTORY_SEPARATOR : '';
            switch($type) {
                case 'csv':
                    $this->file($datafeed, ';', $extract . ".csv", $usrdir);
                    break;
                case 'txt':
                    $this->file($datafeed, "\t", $extract . ".txt", $usrdir);
                    break;
	            case 'xls':
		            $this->xls($datafeed, $extract . ".xls", $usrdir);
		            break;
                case 'xml':
                default:
                    $this->xml($datafeed, $extract . ".xml", $usrdir);
                    break;
            }
        } else {

          if ($user_type == 2 && $data['extract']) // a supplier
          {
			if ($data['type'] == 'xlsx' && $data['extract'] == 'template')
			{
				$filename = base_dir() . 'references' . DIRECTORY_SEPARATOR . "feed_template.xlsx";
				my_force_download($filename);
			}
	  	  }
		}

    }
    protected function xml($datafeed, $filename, $user_id = '')
    {
		$temp_file = base_dir() . 'buyers_files' . DIRECTORY_SEPARATOR . $user_id . $filename;
		if (!file_exists($temp_file)) {

	        $this->load->helper('download');
	        $dom = new domDocument("1.0", "utf-8");
	        $root = $dom->createElement("items");
	        $dom->appendChild($root);
	        foreach($datafeed as $feed){
	            if($feed->ic_id == "") continue;
                    
                      
            $feed->ic_retail_price = (trim($feed->ic_retail_price)=='' || $feed->ic_retail_price==0) ? ($feed->ic_price*3) : $feed->ic_retail_price ;
            
           
                    
	            $item = $dom->createElement("item");
	            $item->setAttribute("id", $feed->ic_id);
	            $params = array();
	            $params['SKU'] = $dom->createElement("SKU", $feed->SKU);
	            $params['Barcode'] = $dom->createElement("Barcode", $feed->upc_ean);
	            $params['Manufacturer_Part_Number'] = $dom->createElement("Manufacturer_Part_Number", $feed->manuf_num);
	            $params['Manufacturer_Name'] = $dom->createElement("Manufacturer_Name", $feed->m_name);
	            $params['Brand_Name'] = $dom->createElement("Brand_Name", $feed->b_name);
	            $params['Title'] = $dom->createElement("Title", $feed->tr_title);
	            $params['Description'] = $dom->createElement("Description", htmlspecialchars(strip_tags($feed->tr_desc)));
	            $params['Category_ID'] = $dom->createElement("Category_ID", $feed->c_id);
	            $params['Category_Name'] = $dom->createElement("Category_Name", htmlspecialchars($this->getFullCategoryName($feed->c_id)));
	            $params['Weight'] = $dom->createElement("Weight", $feed->weight + " " + $feed->weightScale);
	            $params['Ship_Alone'] = $dom->createElement("Ship_Alone", $feed->ship_alone);
	            $params['Height'] = $dom->createElement("Height", $feed->d_height + " " + $feed->d_scale);
	            $params['Width'] = $dom->createElement("Width", $feed->d_width + " " + $feed->d_scale);
	            $params['Depth'] = $dom->createElement("Depth", $feed->d_dept + " " + $feed->d_scale);
	            $params['LeadTime'] = $dom->createElement("LeadTime", $feed->ic_leadtime);
	            $params['Quantity_In_Stock'] = $dom->createElement("Quantity_In_Stock", $feed->ic_quan);
	            $params['Selling_Price'] = $dom->createElement("Selling_Price", $feed->ic_price);
	            $params['MSRP'] = $dom->createElement("MSRP", $feed->ic_retail_price);
	            $params['Promo_Text'] = $dom->createElement("Promo_Text", $feed->ic_prom_text);
	            $params['MAP'] = $dom->createElement("MAP", $feed->ic_map);
	            $params['Shipping_Cost'] = $dom->createElement("Shipping_Cost", $feed->ic_ship_cost);
	            $params['Min_Order'] = $dom->createElement("Min_Order", $feed->ic_min_order);
	            $params['Case_Pack'] = $dom->createElement("Case_Pack", $feed->ic_case_pack);
	            $this->load->model('inventories');
	            $image_list = $this->inventories->list_image($feed->i_id);
	            $images = $dom->createElement("images");
	            foreach($image_list as $image){
	                $pic_name = $dom->createElement("image", base_url() . $image->ii_link);
	                $images->appendChild($pic_name);
	            }
	            foreach($params as $param){
	                $item->appendChild($param);
	            }
	            $item->appendChild($images);
	            $root->appendChild($item);
	        }
			force_download($filename, $dom->saveXML());
		} else {
			set_time_limit(0);
			ini_set('memory_limit', '512M');
	        my_force_download($temp_file);
		}
    }

	protected function xls($datafeed, $filename, $user_id = '')
	{
		$temp_file = base_dir() . 'buyers_files' . DIRECTORY_SEPARATOR . $user_id . $filename;
		if (!file_exists($temp_file)) {
			set_time_limit(0);
			ini_set('memory_limit', '512M');
			$this->load->helper('download');
			$this->load->model('inventories');
			$this->load->library('PHPExcel');
// Initiate cache
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
			$cacheSettings = array( 'memoryCacheSize' => '32MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			$objPHPExcel = new PHPExcel();
			$data = array();
			$header_row = array(
				'SKU',
				'Barcode',
				'Manufacturer Part Number',
				'Manufacturer Name',
				'Brand',
				'Title',
				'Description',
				'Category ID',
				'Category Name',
				'Weight',
				'Ship Alone',
				'Height',
				'Width',
				'Depth',
				'Lead Time',
				'Quantity In Stock',
				'Selling Price',
				'MSRP',
				'Promo text',
				'MAP',
				'Shipping cost',
				'Image 1',
				'Image 2',
				'Image 3',
				'Image 4',
				'Image 5',
				'Image 6',
				'Case Pack',
				'Min Order',
			);
			$objPHPExcel->setActiveSheetIndex(0);

			$objPHPExcel->getActiveSheet()->fromArray($header_row, NULL, 'A1');
			foreach($datafeed as $key => $feed){
				if($feed->ic_id == "") continue;
                                  
            $feed->ic_retail_price = (trim($feed->ic_retail_price)=='' || $feed->ic_retail_price==0) ? ($feed->ic_price*3) : $feed->ic_retail_price ;
            
           
				$row = array(
					(string)$feed->SKU,
					(string)$feed->upc_ean,
					$feed->manuf_num,
					html_entity_decode(htmlentities(trim($feed->m_name),ENT_SUBSTITUTE,"cp1252",false),ENT_QUOTES,"UTF-8"),
					html_entity_decode(htmlentities(trim($feed->b_name),ENT_SUBSTITUTE,"cp1252",false),ENT_QUOTES,"UTF-8"),
					html_entity_decode(htmlentities(trim($feed->tr_title),ENT_SUBSTITUTE,"cp1252",false),ENT_QUOTES,"UTF-8"),
					html_entity_decode(htmlentities(trim($feed->tr_desc),ENT_SUBSTITUTE,"cp1252",false),ENT_QUOTES,"UTF-8"),
					$feed->c_id,
					$this->getFullCategoryName($feed->c_id),
					$feed->weight + " " + $feed->weightScale,
					$feed->ship_alone,
					$feed->d_height + " " + $feed->d_scale,
					$feed->d_width + " " + $feed->d_scale,
					$feed->d_dept + " " + $feed->d_scale,
					$feed->ic_leadtime,
					$feed->ic_quan,
					$feed->ic_price,
					$feed->ic_retail_price,
					html_entity_decode(htmlentities(trim($feed->ic_prom_text),ENT_SUBSTITUTE,"cp1252",false),ENT_QUOTES,"UTF-8"),
					$feed->ic_map,
					$feed->ic_ship_cost
				);

				$image_list = $this->inventories->list_image($feed->i_id);
				$images = array('','','','','', '');
				for($i=0; $i<count($image_list); $i++){
					if($i >= count($images))
						break;
					$images[$i] = base_url() . $image_list[$i]->ii_link;
				}

				$row = array_merge($row, $images, array($feed->ic_case_pack, $feed->ic_min_order));
				$objPHPExcel->getActiveSheet()->fromArray($row, NULL, 'A'.($key+2));
				unset($row);
			}
			$objPHPExcel->setActiveSheetIndex(0);

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save($temp_file);
			my_force_download($temp_file);
		} else {
			set_time_limit(0);
			ini_set('memory_limit', '512M');
			my_force_download($temp_file);
		}
	}

    protected function getFullCategoryName($c_id)
    {
        $this->load->model('categories');
        $cat_sel = $this->categories->detail($c_id);
        $breadcrumb = $cat_sel->c_name;
        $category = $cat_sel->c_parent;

        for($i = $cat_sel->c_level; 0 < $i; $i--)
        {
            $result = $this->categories->detail($category);
            $breadcrumb = $result->c_name." > ".$breadcrumb;
            $category = $result->c_parent;
        }
        return $breadcrumb;
    }

    function file($datafeed, $separator, $filename, $user_id = '') {

	$temp_file = base_dir() . 'buyers_files' . DIRECTORY_SEPARATOR . $user_id . $filename;
	if (!file_exists($temp_file)) {

        $this->load->helper('download');
        $output = "";
        $row = array(
            'SKU',
            'Barcode',
            'Manufacturer Part Number',
            'Manufacturer Name',
            'Brand',
            'Title',
            'Description',
            'Category ID',
            'Category Name',
            'Weight',
            'Ship Alone',
            'Height',
            'Width',
            'Depth',
            'Lead Time',
            'Quantity In Stock',
            'Selling Price',
            'MSRP',
            'Promo text',
            'MAP',
            'Shipping cost',
            'Image 1',
            'Image 2',
            'Image 3',
            'Image 4',
            'Image 5',
            'Image 6',
            'Case Pack',
            'Min Order',
        );
        $output = $output . str_putcsv($row, $separator);
        foreach($datafeed as $feed) {
            
            $feed->ic_retail_price = (trim($feed->ic_retail_price)=='' || $feed->ic_retail_price==0) ? ($feed->ic_price*3) : $feed->ic_retail_price ;
            
            $row = array(
                $feed->SKU,
                $feed->upc_ean,
                $feed->manuf_num,
                $feed->m_name,
                $feed->b_name,
                $feed->tr_title,
                str_replace(array("\n", "\r\n", "\t"), " ", strip_tags($feed->tr_desc)),
                $feed->c_id,
                $this->getFullCategoryName($feed->c_id),
                $feed->weight + " " + $feed->weightScale,
                $feed->ship_alone,
                $feed->d_height + " " + $feed->d_scale,
                $feed->d_width + " " + $feed->d_scale,
                $feed->d_dept + " " + $feed->d_scale,
                $feed->ic_leadtime,
                $feed->ic_quan,
                $feed->ic_price,
                $feed->ic_retail_price,
                str_replace(array("\n", "\r\n", "\t"), " ", $feed->ic_prom_text),
                $feed->ic_map,
                $feed->ic_ship_cost
            );

            $this->load->model('inventories');
            $image_list = $this->inventories->list_image($feed->i_id);
            $images = array('','','','','', '');
            for($i=0; $i<count($image_list); $i++){
                if($i >= count($images))
                    break;
                $images[$i] = base_url() . $image_list[$i]->ii_link;
            }

            $row = array_merge($row, $images, array($feed->ic_case_pack, $feed->ic_min_order));
            $output = $output . "\r\n" . str_putcsv($row, $separator);
        }

        force_download($filename, $output);
	} else {

	set_time_limit(0);
	ini_set('memory_limit', '512M');


        my_force_download($temp_file);

	}
    }

    function delete(){
        $result = array("result"=>"false");
        if ($this->session->userdata('is_login') == TRUE)
        {
            $user_type = $this->session->userdata('type');
            if ($user_type == 3 && $this->input->get('id')) { // a buyer
        		$id = $this->input->get('id');
        		if($id == "all"){
        		    $user_id = $this->session->userdata['id'];
        		    $this->load->model('datafeeds');
        		    $this->datafeeds->delete_by_user($user_id);
        /*		    $this->load->model('datafeedfiles');
        		    $this->datafeedfiles->delete($user_id, "datafeed");*/
        		    $result = array("result"=>"true");
        		}
        		else {
        		    $id = intval($id);
        		    if($id > 0){
        		        $user_id = $this->session->userdata['id'];
        		        $this->load->model('datafeeds');
        		        $this->datafeeds->delete_by_productid($user_id, $id);
        /*			if(!$this->datafeeds->has_entries($user_id)){
        			    $this->load->model('datafeedfiles');
        			    $this->datafeedfiles->delete($user_id, "datafeed");
        			}*/
        			$result = array("result"=>"true");
        		    }
        		}
	        }
	    }
        echo json_encode($result);
    }

    function delete_file(){
        $result = array("result"=>"false");
        if ($this->session->userdata('is_login') == TRUE)
        {
            $user_type = $this->session->userdata('type');
            if ($user_type == 3 && $this->input->get('id')) { // a buyer
		$id = intval($this->input->get('id'));
		if($id > 0){
		    $this->load->model('datafeedfiles');
		    $this->datafeedfiles->delete($id);
		    $result = array("result"=>"true");
	        }
	    }
	}
        echo json_encode($result);
    }
}
?>