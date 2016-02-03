<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class payment extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->model('users');
		$this->load->model('manufacturers');
		$this->load->model('buyers');
		$this->load->model('countries');
		$this->load->model('inventories');
    }

	public function index()
	{

			redirect('','refresh');
	}

	function buyer()
	{
		$is_Login_user = false;
		if($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			$user_id = $this->session->userdata('id');
			if($user_type == 3) //3 is Buyer
			{
				$is_Login_user = true;

				$b_id = $this->input->post('billing');
				$ccu_id = $this->input->post('cc');
				$trans_id = $this->input->post('trans_id');

				$user = $this->users->info($user_id);
				$billing = $this->buyers->get_billing_info($b_id);
				//$cc = $this->buyers->get_creditcard_info($ccu_id);

				$shipping_used = $this->input->post('shipping_info');

				$full_name = $user->u_fname.$user->u_lname;
				$country = $billing->c_id;
				$address1 = $billing->ba_add1;
				$address2 = $billing->ba_add2;
				$city = $billing->ba_city;
				$state = $billing->ba_province;
				$code = $billing->ba_postal;
				$phone = $billing->ba_phone_num;
				$phone_ext = $billing->ba_phone_ext;

				if(!$shipping_used)
				{
					$full_name = $this->input->post('receiver_name');
					$country = $this->input->post('country');
					$address1 = $this->input->post('add1');
					$address2 = $this->input->post('add2');
					$city = $this->input->post('city');
					$state = $this->input->post('prov');
					$code = $this->input->post('postal');
					$phone = $this->input->post('phone_num');
					$phone_ext = $this->input->post('phone_ext');
				}
				$invoice = $user_id.'-'.$this->rndm_strng('numeric',10);

				$carts = $this->cart->contents(); //James, cart content

				$total_shipping = 0;
				foreach($carts as $itemd)
				{
				        $item_ship_cost = (empty($itemd['options']['ship_cost_per_item'])) ? $itemd['options']['ship_cost']*$itemd['qty'] : $itemd['options']['shipping_cost']+$itemd['options']['ship_cost_per_item']*$itemd['qty'];
					$total_shipping += $item_ship_cost;
				}

				$bt_type = $this->input->post('type');
				if(!$bt_type) {
					$bt_type = 'credit card';
				}

				$bt_status = 0;
				$bt_reason = 'Pending';
				if($bt_type == 'apruve') {
					$bt_status = -100;
					$bt_reason = 'Awaiting Payment';
				}

				$data_buyer_trans = array('u_id' => $user_id,
										  'ccu_id' => $ccu_id,
										  'ba_id' => $b_id,
										  'bt_invoice' => $invoice,
										  'bt_type' => $bt_type,
										  'bt_trans_id' => $trans_id,
										  'bt_total_shipping' => $total_shipping,
										  'bt_total_payment' => $this->cart->total(),
										  'bt_total_item' => $this->cart->total_items(),
										  'bt_timestamp' => '',
										  'bt_correlation_id' => '',
										  'bt_ack' => '',
										  'bt_status' => 0,
										  'bt_time' => date("Y-m-d h:i:s",time()),
										  'bt_is_sameBilling_to_ship' => $shipping_used);

				$bt_id = $this->buyers->add_transaction($data_buyer_trans);


				foreach($carts as $itemd)
				{
					$item_ship_cost = (empty($itemd['options']['ship_cost_per_item'])) ? $itemd['options']['ship_cost']*$itemd['qty'] : $itemd['options']['shipping_cost']+$itemd['options']['ship_cost_per_item']*$itemd['qty'];

					$data_tras_detail = array('bt_id' => $bt_id,
											  'ic_id' => $itemd['id'],
											  'btd_quan' => $itemd['qty'],
											  'btd_amount' => $itemd['price'],
											  'btd_shipamount' => $item_ship_cost,
											  'btd_subamount' => $itemd['subtotal'],
											  'btd_shipped_stat' => 0,
											  'btd_productFee' =>  $itemd['options']['fee']); //status to zero if not shipped yet

					$btd_id = $this->buyers->add_transaction_detail($data_tras_detail);
				}

				$data_shiipping_det = array('bt_id' => $bt_id,
										   'bts_name' => $full_name,
										   'c_id' => $country,
										   'bts_add1' => $address1,
										   'bts_add2' => $address2,
										   'bts_city' => $city,
										   'bts_prov' => $state,
										   'bts_postal' => $code,
										   'bts_phone_num' => $phone,
										   'bts_phone_ext' => $phone_ext);

				$bts_id = $this->buyers->add_transaction_shipdet($data_shiipping_det);

				// Buyer Payment Information
				$email_data['user'] =  $user;
				$email_data['transaction'] =  $this->buyers->get_trasaction_detail($bt_id);
				$email_data['ship'] =  $this->buyers->get_trasaction_detailShipping($bts_id);
				$email_data['email_type'] = "Send Pre Invoice";
				$email_content = $this->load->view('email/email-buyer-transaction',$email_data, true);

				// Buyer Payment Email Format
				$subject = "Oceantailer: Invoice Information";
				$from = "noreply-oceantailer@oceantailer.com";
				$sender = "http://www.oceantailer.com";
				$to = "".!empty($user->u_additional_email)?$user->u_additional_email:$user->u_email;

				// Send email to the Buyer
				$this->send_message($email_content, $subject, $to, $from, $sender);

				// @redix issue#10 Send emails to all the Suppliers in the cart

				$cart = $this->cart->_cart_contents;

				$supplieremails = array();

				foreach ($cart as $item) {
					// Get supplier email by inventory id
					$inv_id = $item['options']['i_id'];
					$supplierId = $this->inventories->get_supplier_id($inv_id);
					$supplierEmail = $this->users->get_user_email($supplierId, true);

					//Fill emails array
					$supplieremails[$supplierId]=$supplierEmail;
				}

				// Remove duplicate and empty elements from emails array
				$supplieremails = array_filter(array_unique($supplieremails));

				foreach ($supplieremails as $sup_id=>$email) {
					$sup_cart = $cart;
					$cart_total =0;
					$total_items =0;
					foreach ($sup_cart as $k=>$item) {
						$inv_id = $item['options']['i_id'];
						$supplierId = $this->inventories->get_supplier_id($inv_id);
						if (($supplierId != $sup_id)) unset($sup_cart[$k]);
						else { $total_items += 1; $cart_total += $item['subtotal'];}
					}
					$email_data['carts'] = $sup_cart;
					$email_data['total'] = $cart_total;
					// Set email parameters
					$email_content = $this->load->view('email/email-supplier-transaction',$email_data,true);
					$subject = "Oceantailer: Order Information";
					$from = "noreply-oceantailer@oceantailer.com";
					$sender = "http://www.oceantailer.com";
					$to = $email;

					// Send email to the supplier
					$this->send_message($email_content, $subject, $to, $from, $sender);
				}

				$keep = $this->input->get('keep');
				if(!$keep) {
					$this->cart->destroy();//destroy all content in the cart
				}

			    // Create automatically grouped payment from sepparate supplier

			    $trans_supplier_group = $this->buyers->search_shipping_list_grouped($bt_id);

			    foreach($trans_supplier_group as $group)
			    {
			    	$data_insert = array('bt_id' => $group->bt_id,
			    						 'u_supplier' => $group->invent_child_supplier,
			    						 'u_buyer' => $group->u_id,
			    						 'bsd_total_item' => $group->total_quan,
			    						 'bsd_total_paymet' => $group->total_amount,
			    						 'bsd_status' => $bt_status,
			    						 'bsd_reason' => $bt_reason);

			    	$this->buyers->buyer_supplier_detail($data_insert);
			    }

				$data = array('result' => 1, 'invoice' => $invoice, 'fullname' => $user->u_fname.$user->u_lname);

				$html_result = $this->load->view('buyer/buyer-payment-result',$data, TRUE);

				$returnmessage = array( 'display' => $html_result  , 'status' => 1, 'bt_id' => $bt_id);
			    echo json_encode($returnmessage);

			}
		}

	}

	function rndm_strng($type,$size)
	{
		$this->load->helper('string');
		return random_string($type, $size);
	}

	function send_message($message, $subject, $to, $from, $sender)
	{
		$this->load->library('email');

       	$config = array();
        $config['useragent']           = "CodeIgniter";
        $config['mailpath']            = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
        $config['protocol']            = "smtp";
        //$config['smtp_host']           = "localhost";
        //$config['smtp_port']           = "25";
		$config['smtp_host']           = "ssl://smtp.googlemail.com";
        $config['smtp_port']           = "465";
        $config['smtp_user']           = "daphne.b@oceantailer.com";
        $config['smtp_pass']           = "California";
        $config['mailtype'] = 'html';
        $config['charset']  = 'utf-8';
        $config['newline']  = "\r\n";
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);

		$this->email->from($from, $sender);
		$this->email->to($to);

		$this->email->subject($subject);
		$this->email->message($message);

		$this->email->send();

		//echo $this->email->print_debugger();
	}

	function test()
	{
		$trans_supplier_group = $this->buyers->search_shipping_list_grouped(31);
		echo print_r($trans_supplier_group);
	}
}