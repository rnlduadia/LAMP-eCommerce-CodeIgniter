<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ComingSoon extends CI_Controller {

	function __construct()
    {
        parent::__construct();
	//	$this->load->model('users');
		$this->load->model('categories');
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
			$data['is_home'] = 0;
			$this->load->view('coming-soon',$data);
		}
	}
}
