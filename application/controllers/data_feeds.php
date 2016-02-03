<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class data_feeds extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		//$this->load->model('users');
		$this->load->model('categories');
    }

	public function index()
	{
            $data['feat_categories'] = $this->categories->listings(0); //main categories
	    $data['is_home'] = 0;	
            
            if($this->session->userdata('is_login') == TRUE)
            {
                $user_type = $this->session->userdata('type'); //get user type;
		if($user_type == 2) // 2 is supplier
		{
			$this->load->view('supplier/data-feeds',$data);
		}
			// Lanz Editted
		elseif($user_type == 3) // 3 is buyer
		{
			$this->load->view('buyer/data-feeds',$data);
		}
            }
            else
            {

                    $this->load->view('home-page',$data);
            }
	}
}
?>
