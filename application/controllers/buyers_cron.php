<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

set_time_limit(0);

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

class buyers_cron extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->model('users');
		$this->load->model('buyers');
		$this->load->model('suppliers');
		$this->load->model('datafeeds');
		$this->load->model('datafeedfiles');
    }

    public function index($type = 'all')
	{

        $filesDir = base_dir() . 'buyers_files';
        if(!file_exists($filesDir) || !is_dir($filesDir)) {
			mkdir($filesDir, 0777, true);
        }

		switch($type) {
		  case 'custom':
			//custom
			$listings = $this->buyers->listing(1);
			foreach($listings as $buyer){
			  $u_id = $buyer->u_id;
			  $uiddir = $filesDir . DIRECTORY_SEPARATOR . $u_id;
       		 	  if(!file_exists($uiddir) || !is_dir($uiddir)) {
  			  	mkdir($uiddir, 0777, true);
      		 	  }
			  $datafeed = $this->datafeeds->custom_prodlist($u_id);
			  $this->export($datafeed, 'custom', $uiddir);
 			}
		   break;
		   case 'supplier':
			//supplier
			$supplier_list = $this->suppliers->listing(1);
			foreach ($supplier_list as $supplier) {

                  	  $s_id = $supplier->u_id;
                  	  $supplier_info = $this->users->info($s_id);
    			  $datafeed = $this->datafeeds->prodlist('supplier', $s_id);
                   	  $companyName = strtolower(preg_replace('/[\s]+/i', '_', $supplier_info->u_company));
                  	  $extract = preg_replace('/[\_]{2,}/i', '_', $companyName);
			  $this->export($datafeed, $extract, $filesDir);

			}
		   break;
		   case 'dropshipping':
			//dropshipping
			$datafeed = $this->datafeeds->prodlist('dropshipping');
			$this->export($datafeed, 'dropshipping', $filesDir);

		   break;
		   case 'all':
		   default:
			//all
			$datafeed = $this->datafeeds->prodlist();
			$this->export($datafeed, 'all', $filesDir);
		   break;
		}

        echo '';
        return;

    }

    protected function export($datafeed, $extract, $uiddir)
    {
        $this->file($datafeed, ';', $uiddir . DIRECTORY_SEPARATOR . $extract . ".csv");

        $this->file($datafeed, "\t", $uiddir . DIRECTORY_SEPARATOR . $extract . ".txt");

        $this->xml($datafeed, $uiddir . DIRECTORY_SEPARATOR . $extract . ".xml");

        $this->xls($datafeed, $uiddir . DIRECTORY_SEPARATOR . $extract . ".xls");

    }


    protected function xml($datafeed, $filename)
    {
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
                $pic_name = $dom->createElement("image", "http://shop.oceantailer.com/" . $image->ii_link);
                $images->appendChild($pic_name);
            }
            foreach($params as $param){
                $item->appendChild($param);
            }
            $item->appendChild($images);
            $root->appendChild($item);
        }

	$dom->save($filename);
	return;
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

    function file($datafeed, $separator, $filename) {
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
                $images[$i] = "http://shop.oceantailer.com/" . $image_list[$i]->ii_link;
            }

            $row = array_merge($row, $images, array($feed->ic_case_pack, $feed->ic_min_order));
            $output = $output . "\r\n" . str_putcsv($row, $separator);
        }

    	$handle = fopen($filename, 'w');
		fwrite($handle, $output);
    	fclose($handle);

        return ;
    }

	protected function xls($datafeed, $filename)
	{

			$this->load->helper('download');
			$this->load->library('PHPExcel');
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
			$data['header'] = $header_row;
			foreach($datafeed as $feed){
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


				$this->load->model('inventories');
				$image_list = $this->inventories->list_image($feed->i_id);
				$images = array('','','','','', '');
				for($i=0; $i<count($image_list); $i++){
					if($i >= count($images))
						break;
					$images[$i] = base_url() . $image_list[$i]->ii_link;
				}

				$row = array_merge($row, $images, array($feed->ic_case_pack, $feed->ic_min_order));
				$data[] = $row;
			}
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A1');
			$objPHPExcel->setActiveSheetIndex(0);


			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save($filename);

			return;

	}


}