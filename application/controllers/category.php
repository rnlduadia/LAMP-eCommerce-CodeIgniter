<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class category extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->model('users');
		$this->load->model('manufacturers');
		$this->load->model('inventories');
		$this->load->model('categories');
		$this->load->model('suppliers');
		$this->load->model('brands');
		$this->load->model('administrators');
    }

	public function index()
	{
		redirect('','refresh');
	}

	function info() //show list of product depending on the number of level, and name of product at url
	{
		$number_levels = $this->uri->segment(3);
		$array_links = array();
		for($i = 1; $i <= $number_levels+1;$i++)
		{
			array_push($array_links,$this->uri->segment(3+$i));
		}
		$c_id = $this->categories->get_category_id_linked($array_links);

		$pagination_uri_segment = 7;
		if($number_levels == 1) {
			$c_id_arr = array();
			$c_id_arr = $this->categories->listings(2, $c_id);
			$return = array();
			if($c_id_arr && is_array($c_id_arr)) foreach($c_id_arr as $sub_c_id){
				$return[] = $sub_c_id->c_id;
			}
			else $return[] = $c_id->c_id;
			$where_data['inventory.c_id'] = $return;
			$pagination_uri_segment = 6;
		}
		elseif($number_levels == 0) {
			$c_id_arr = array();
			$c_id_arr = $this->categories->listings(1, $c_id);
			foreach($c_id_arr as $sub_c_id){
				$c_id_sub_arr = $this->categories->listings(2, $sub_c_id->c_id);
				if($c_id_sub_arr && is_array($c_id_sub_arr)){
					foreach($c_id_sub_arr as $sub_sub_c_id){
						$return[] = $sub_sub_c_id->c_id;
					}
				}
				else $return[] = $sub_c_id->c_id;
			}
			$where_data['inventory.c_id'] = $return;
			$pagination_uri_segment = 5;
		}

		if(!isset($c_id_arr)) $where_data = array('inventory.c_id' => $c_id);

		$where_data['inventory_child.ic_quan >'] = 0;
		
		$data['breadcrumbs'] = $this->categories->create_breadcrumb($c_id,$number_levels,true);

		if($number_levels == 0){
			$data['search_selected'] = $data['breadcrumbs'];
		}

		$this->load->library('pagination');
		$all = $this->inventories->listings_advance_count($where_data);
		$config = $this->get_pagination_config('category/info/'.$number_levels.'/'.implode('/', $array_links), $all, $pagination_uri_segment);
		$this->pagination->initialize($config);

		$data['inventories'] = $this->inventories->listings_advance($where_data, $config['per_page'], $this->uri->segment($pagination_uri_segment));
		$data['pagination'] = $this->pagination->create_links();

		$data['left_categories'] = $this->categories->listings(0); //main categories
		$data['feat_categories'] = $this->categories->listings(0); //main categories
		$data['categories'] = array(); //main categories
		$data['brands'] = array();
		$data['manus'] = array();
		$data['suppliers'] = $this->suppliers->listing(1);
		
		$data['brands'] = $this->brands->listing();
		$this->load->view('category-product-list', $data);
	}

	function get_pagination_config($url, $num_rows, $pagination_uri_segment = 7){

		$config['base_url'] = base_url().$url;
		$config['per_page'] = '9';

		$config['full_tag_open'] = '<div class=\'navi-feat-wrapper\'><div class=\'navi-feat\'>';
		$config['full_tag_close'] = '</div></div>';

		$config['first_link'] = '';
		$config['last_link'] = '';
					
		$config['next_link'] = '&nbsp';
		$config['next_tag_open'] = '<div class=\'right-navi\'>';
		$config['next_tag_close'] = '</div>';

		$config['prev_link'] = '&nbsp';
		$config['prev_tag_open'] = '<div class=\'left-navi\'>';
		$config['prev_tag_close'] = '</div>';

//		$config['display_pages'] = FALSE; 
	
		$config['num_tag_open'] = '<div class=\'num-tag\'>';
		$config['num_tag_close'] = '</div>';

		$config['total_rows'] = $num_rows;
		$config['uri_segment'] = $pagination_uri_segment;
		
		return $config;
	}

	function add()
	{
		if($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			if($this->input->post('action') != "") 
			{
				$action = $this->input->post('action');
				if($action == 'add') //if adding manufacturer
				{
					$category_name = $this->input->post('category_name');
					$level = $this->input->post('level');
					$parent = $this->input->post('parent');
					$fee = $this->input->post('category_fee');
					$data_insert = array('c_name' => $category_name,
										 'c_level' => $level, 
										 'c_parent' =>$parent, 
										 'c_link' => $this->categories->url_convert($category_name),
										 'c_feePercent' => $fee);
					$result = $this->categories->add($data_insert);

					redirect('category/add','refresh');
				}

			}
			else
			{
				if($user_type == 1) //1 is admin, 2 supplier
				{
					$level = 0;
					$data['categories'] = $this->categories->listings($level);
					$this->load->view('admin/category/category-page',$data);
				}
			}
		}
		else
			redirect('','refresh');
	}

	function update()
	{
		if($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			if($user_type == 1)
			{	

				$data_update = array('c_name' => $this->input->post('category_name'),
									 'c_link' => $this->categories->url_convert($this->input->post('category_name')),
								     'c_feePercent' => $this->input->post('fee'));
				$where = 'c_id';
				$value = $this->input->post('parent');
				$this->categories->update($data_update,$where,$value);
			}

		}

	}

	function delete()
	{
		if($this->session->userdata('is_login') == TRUE)
		{
			if($this->input->post('type') != "") 
			{
				
				$type = $this->input->post('type');
				if($type == 'deleteAll')  //delete category including the attached product
				{
					$cat = $this->input->post('cat');

					$cat_info_sel = $this->categories->detail($cat);

					$level = $this->input->post('level');
					$where = "c_id";
					$result = $this->categories->delete($where,$cat); //delete the category

					//update sub folder to level 0, if it has sub folder

					if($level == 0)
						$level = 0;

					$update = array('c_parent' => $cat_info_sel->c_parent, 'c_level' => $level);
					$where = "c_parent";
					$value = $cat;

					$this->categories->update($update,$where,$value);

					//delete product that attached to the deleted category
					$where = "c_id";
					$this->inventories->delete($where,$value);

					echo 'haha';
				}
				elseif($type == 'deleteChange')
				{
					$cat = $this->input->post('cat');
					$cat_to_change = $this->input->post('cat_change');

					$cat_info_sel = $this->categories->detail($cat);

					$level = $this->input->post('level');
					$where = "c_id";
					$result = $this->categories->delete($where,$cat); //delete the category

					//update sub folder to level 0, if it has sub folder

					$update = array('c_parent' => $cat_info_sel->c_parent, 'c_level' => $level);
					$where = "c_parent";
					$value = $cat;

					$this->categories->update($update,$where,$value);

					//update the c_id selected to transfer to the existing category
					$where = "c_id";
					$update_array = array('c_id' => $cat_to_change);
					$this->inventories->update($update_array,$cat,$where);

					echo 'haha';
				}
			}
			else
			{

			}
		}
	}

	function detail()
	{
		if($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			if($this->input->post('view_type') != "") 
			{
				$view_type = $this->input->post('view_type');
				if($view_type == 'table') //if table format
				{
					$category = $this->input->post('id');
					$result = $this->categories->listing_subcategory($category);

					$data['categories'] = $result;
					$html_ = $this->load->view('admin/category/category-table',$data,TRUE);

					echo $html_;
				}
				elseif($view_type == 'dropdown') //if dropdown format
				{
					$category = $this->input->post('id');
					$result = $this->categories->listing_subcategory($category);
					$data['categories'] = $result;
					$data['level'] = $this->input->post('level');
					$html_ = $this->load->view('admin/category/category-dropdown',$data,TRUE);

					echo $html_;
				}
				elseif($view_type == 'breadcrumbs') //if dropdown format
				{
					$category = $this->input->post('id');
					$level = $this->input->post('level');

					$breadcrumb = "";

					$cat_sel = $this->categories->detail($category);
					$breadcrumb = $cat_sel->c_name;
					//echo print_r($cat_sel);
					$category = $cat_sel->c_parent;

					for($i = $cat_sel->c_level; 0 < $i; $i--)
					{
						$result = $this->categories->detail($category);
						$breadcrumb = $result->c_name.">".$breadcrumb;
						$category = $result->c_parent;
					}

					echo $breadcrumb;

				} 
				elseif($view_type == 'image') //if dropdown format
				{
					$category = $this->input->post('id');
					$cat_sel = $this->categories->detail($category);
					$image_html = "";
					if($cat_sel->c_default_image != "")
						$image_html = "<img src='".$cat_sel->c_default_image."' />";

					echo $image_html;
				}
			}
		}
		else
			redirect('','refresh');
	}


/*	function gen_link()
	{
		$this->categories->generate_link_fill_db();
		echo 'done';
	}*/


}
