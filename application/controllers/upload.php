<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class upload extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('inventories');
        $this->load->library('apputils'); // load library with ConvertUnStampToMysqlDateTime function
    }

    function product_attachment()
	{
		$id = $this->input->post('product_id');
		$file_name = $this->input->post('fname');
		$time = time();

        $image_upload_group_id= $this->inventories->get_image_upload_group_id($id);
        //$this->inventories->DebToFile('$image_upload_group_id::'.$image_upload_group_id, false);

        $image_link = 'product_image/'.$image_upload_group_id.'/'.$id."/".$file_name;
        //$this->inventories->DebToFile('$image_link::'.$image_link, false);
		$array_data =  array("i_id" => $id,
					   "ii_name" => $file_name,
					   "ii_link" => $image_link,
					   "ii_feat" => 0,
					   "ii_time" => apputils::ConvertUnStampToMysqlDateTime($time) );

		$image_id = $this->inventories->add_image($array_data);
        //$this->inventories->DebToFile('$image_id::'.$image_id, false);

		$data_link['link'] = $image_link;
		$data_link['id'] = $image_id;
		$image_result = $this->load->view('admin/inventory/inventory-image-list',$data_link, true);

		echo $image_result;

	}

    function new_product_attachment()
    {
        $file_name = $this->input->post('fname');
        $data_link['link'] = "product_image/{$file_name}";
        $data_link['id'] = $file_name;
        echo $this->load->view('admin/inventory/inventory-image-list', $data_link, true);
    }

    function delete_product_attachment()
    {
        $file_name = $this->input->post('fname');
        @unlink(base_dir() . "product_image/{$file_name}");
    }

	function do_upload()
   {
        $config['upload_path'] = './product_image/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']    = '144400';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        
        $this->load->library('upload', $config);
    
        if ( ! $this->upload->do_upload())
        {
            echo $this->upload->display_errors();
            
        }    
        else
        {
            $data = array('upload_data' => $this->upload->data());
            
            print_r($data);
        }
    } 


}
