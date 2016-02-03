<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->model('users');
		$this->load->model('manufacturers');
		$this->load->model('inventories');
		$this->load->model('categories');
		$this->load->model('brands');
		$this->load->model('suppliers');
	    $this->load->model('administrators');
    }

	public function index()
	{
		if($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			if($user_type == 1) // 1 is admin
			{
				redirect('user','refresh');
			}
			elseif($user_type == 2) // 2 is supplier
			{
				redirect('supplier','refresh');
			}
			// Lanz Editted
			elseif($user_type == 3) // 3 is buyer
			{
				redirect('buyer','refresh');
			}
		}
		else
		{
			$data['feat_categories'] = $this->categories->listings(0); //main categories
			$data['search_selected'] = 'Category';
			$data['left_categories'] = $this->categories->listings(0) ;// categories + subcategories
			$data['brands'] = array();
			$data['manus'] = array();
			$data['suppliers'] = $this->suppliers->listing(1);
			$data['is_home'] = 1;
			$data['top_brands'] = $this->brands->listing("","",1);

			$rotatorsData = json_decode($this->administrators->get_settings('homepage'),true);

			$rotators = array();
			foreach($rotatorsData['rotator'] as $rotatorData){
				if(!empty($rotatorData['category'])){
					$categories = array_merge(array($rotatorData['category']),$this->categories->get_children($rotatorData['category']));
					$where = array();
					$where['inventory.c_id'] = $categories;
					$where['inventory.status'] = 'active';
					$where['inventory_child.ic_quan > '] = 0;
					$inventories = $this->inventories->listings_advance($where,1000,0,'inventory_child.ic_id','desc');
					shuffle($inventories);
					$rotators[] = array('title'=>$rotatorData['title'],'items'=>array_slice($inventories,0,$rotatorData['number']));
				}
			}
			$data['rotators'] = $rotators;
			$this->load->view('home-page',$data);
		}
	}
}
