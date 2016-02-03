<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ContentSite extends CI_Controller {

	function __construct()
   	 {
        parent::__construct();
   	 }

	public function index()
	{
			$data = array("title"=>"Join the most trusted B2B marketplace");
			$this->load->view('www/home-page',$data);

	}

	public function about_us()
	{
			$data = array("title"=>"About Us");
			$this->load->view('www/about_us',$data);

	}
	public function buyer_benefits()
	{
			$data = array("title"=>"Buyer's Benefits");
			$this->load->view('www/buyer_benefits',$data);

	}
	public function buyer_insight()
	{
			$data = array("title"=>"Buyer's Insight");
			$this->load->view('www/buyer_insight',$data);

	}
	public function buyer_register()
	{
			$data = array("title"=>"Buyer's Registration");
			$this->load->view('www/buyer_register',$data);

	}
	public function completed_registration()
	{
			$data = array("title"=>"Registration Completed");
			$this->load->view('www/completed_registration',$data);

	}
	public function contact()
	{
			$data = array("title"=>"Contact Us");
			$this->load->view('www/contact',$data);

	}
	public function dropshipping_info()
	{
			$data = array("title"=>"What is DropShipping?");
			$this->load->view('www/dropshipping_info',$data);

	}
	public function faqs()
	{
			$data = array("title"=>"FAQ's");
			$this->load->view('www/faqs',$data);

	}

	public function how_it_works()
	{
			$data = array("title"=>"How OceanTailer works");
			$this->load->view('www/how_it_works',$data);

	}

	public function privacy_policy()
	{
			$data = array("title"=>"OceanTailer's Privacy Policy");
			$this->load->view('www/privacy_policy',$data);

	}

	public function shipping_info()
	{
			$data = array("title"=>"Shipping Information");
			$this->load->view('www/shipping_info',$data);

	}

	public function supplier_benefits()
	{
			$data = array("title"=>"Supplier's Benefits");
			$this->load->view('www/supplier_benefits',$data);

	}

	public function supplier_insight()
	{
			$data = array("title"=>"Supplier's Insight");
			$this->load->view('www/supplier_insight',$data);

	}

	public function seller_register()
	{
			$data = array("title"=>"Seller's Registration");
			$this->load->view('www/seller_register',$data);

	}

	public function tax_id_info()
	{
			$data = array("title"=>"Tax ID Information");
			$this->load->view('www/tax_id_info',$data);

	}

	public function terms_of_use()
	{
			$data = array("title"=>"OceanTailer's Terms of use");
			$this->load->view('www/terms_of_use',$data);

	}

}