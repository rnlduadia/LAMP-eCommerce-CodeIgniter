<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shipping extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->model('users');
		$this->load->model('manufacturers');
		$this->load->model('inventories');
		$this->load->model('categories');
		$this->load->model('brands');
		$this->load->model('suppliers');
		$this->load->model('buyers');
                $this->load->library('apputils');
		$this->load->library('pagination');

		//End Load Neccessary Models
        $this->config->load('authorized');
		define("AUTHORIZENET_API_LOGIN_ID", $this->config->item('AUTHORIZENET_API_LOGIN_ID'));
        define("AUTHORIZENET_TRANSACTION_KEY", $this->config->item('AUTHORIZENET_TRANSACTION_KEY'));
        define("AUTHORIZENET_MD5_SETTING", $this->config->item('AUTHORIZENET_MD5_SETTING'));
        define("AUTHORIZENET_SANDBOX", $this->config->item('AUTHORIZENET_SANDBOX'));
        define("AUTHORIZENET_LOG_FILE", $this->config->item('AUTHORIZENET_LOG_FILE'));

        $this->load->library('authorizenet');

   		// Load PayPal library
		$this->config->load('paypal');

		$config = array(
			'Sandbox' => $this->config->item('Sandbox'), 			// Sandbox / testing mode option.
			'APIUsername' => $this->config->item('APIUsername'), 	// PayPal API username of the API caller
			'APIPassword' => $this->config->item('APIPassword'), 	// PayPal API password of the API caller
			'APISignature' => $this->config->item('APISignature'), 	// PayPal API signature of the API caller
			'APISubject' => '', 									// PayPal API subject (email address of 3rd party user that has granted API permission for your app)
			'APIVersion' => $this->config->item('APIVersion')		// API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
		);

		// Show Errors
		/*if($config['Sandbox'])
		{
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
		}*/

		$this->load->library('paypal/Paypal_pro', $config);
    }

	public function index()
	{

	}

	function lists()
	{
		$data['feat_categories'] = $this->categories->listings(0); //main categories
		if($this->session->userdata('is_login') == TRUE)
		{
			$action = $this->input->post('action');
			$user_type = $this->session->userdata('type'); //get user type;
			if($action != '')
			{
				if($action == 'request')
				{

					if($user_type == 2) //supplier
					{
						$supplierId = $this->session->userdata('id');
						$page = (int)$this->input->get('page');
						$page = $page > 0 ? $page : 1;
						$sort_by = $this->input->post('sort_by');
						$sort_direction = $this->input->post('sort_direction');
						$sort_direction = ($sort_direction != '') ? $sort_direction : 'desc';
						$sort_by = ($sort_by != '') ? $sort_by : 'bt_time';
						/*$data['statuses'] = array(
							'' => 'All',
							'0' => 'Pending/Buyer Approved Shipping Fee',
							'-2' => "Pending buyer's consent for new shipping fees",
							'-1' => 'Cancelled Order',
							'-4' => 'Return Order',
							'-3' => 'Refund Order',
							'1' => 'Shipped',
							'2' => 'Completed'
						);*/
						$data['statuses'] = array_merge(array(''=>'All'),apputils::orderStatus());

						//filters
						$name =  $this->input->post('name');
						$sku =  $this->input->post('sku');
						$start =  $this->input->post('start');
						$end =  $this->input->post('end');
						$stat =  $this->input->post('stat');
						$invoice_id = $this->input->post('invoice_id');

						$rowsCount= count($this->suppliers->shipping_list_grouped($supplierId,'',$name,$invoice_id,$start,$end,$stat,'',25,$sort_by,$sort_direction));
						$items = $this->suppliers->shipping_list_grouped($supplierId,'',$name,$invoice_id,$start,$end,$stat,$page,25,$sort_by,$sort_direction);
						foreach($items as $k=>$item) {
							$item->bsd_status = apputils::orderStatus($item->bsd_status);

							if ($sku != '') {
								$btd = $this->suppliers->transaction_detail($supplierId,$item->bsd_id);
								$sku_list = array();
								foreach($btd as $btd_item){
							  		$sku_list[] = $btd_item->SKU;
								}
								$item->sku = implode(',',$sku_list);

								if (preg_match('/^.*'.$sku.'.*$/',$item->sku) == 0) unset($items[$k]);
							}

							$item->bt_total_sum = number_format($item->bt_total_sum,2);
						}

						$filters_data['filters'] = array(
							'name' => array('title'=>"Buyer's Name",'value'=>$name),
							'invoice_id' => array('title'=>"Invoice Id",'value'=>$invoice_id),
							'sku' =>  array('title'=>"Ordered SKU",'value'=>$sku),
							'start' => array('title'=>'From','value'=>$start, 'type'=>'datepicker'),
							'end' => array('title'=>'To','value'=>$end, 'type'=>'datepicker'),
							'stat' => array('title'=>'Status','value'=>$stat, 'type'=>'select', 'opts'=>$data['statuses'])
						);

						$data['items'] = $items;

						$data['columns'] = array(
							'bt_time' => array('title'=>'Date','sortable'=>true),
							'bt_invoice' => array('title'=>'Invoice ID','sortable'=>true),
							'u_username' => array('title'=>'Username','sortable'=>true),
							'c_code' => array('title'=>'Country','sortable'=>true),
							'bsd_total_item' => array('title'=>'Total Items','sortable'=>true),
							'bt_total_sum' => array('title'=>'Sum','sortable'=>true),
							'bsd_status' => array('title'=>'Status','sortable'=>true),
							'actions' => array(
								'title'=>'Action',
								'sortable'=>false,
								'items'=>array(
									'view' => array('link'=>'/supplier/order/', 'text'=> 'Order Detail', 'confirm'=>false, 'pk'=>'bsd_id')
								)
							),
						);
						$data['sorter']['by'] = $sort_by;
						$data['sorter']['dir'] = $sort_direction;

						$config['base_url'] = '/shipping/lists?';
						$config['total_rows'] = $rowsCount;
						$config['per_page'] = 25;
						$config['cur_page'] = $page;
						$config['use_page_numbers'] = true;
						$config['first_link'] = '<<';
						$config['last_link'] = '>>';
						$config['num_links'] = 3;
						$config['page_query_string'] = true;
						$config['query_string_segment'] = 'page';
						$config['num_tag_open'] = '<li>';
						$config['num_tag_close'] = '</li>';
						$config['first_tag_open'] = '<li>';
						$config['first_tag_close'] = '</li>';
						$config['last_tag_open'] = '<li>';
						$config['last_tag_close'] = '</li>';
						$config['next_tag_open'] = '<li>';
						$config['next_tag_close'] = '</li>';
						$config['prev_tag_open'] = '<li>';
						$config['prev_tag_close'] = '</li>';
						$config['cur_tag_open'] = '<li><a href="javascript:void(0);" style="color: #000;">';
						$config['cur_tag_close'] = '</a></li>';

						$this->pagination->initialize($config);

						$pages = array();
						$pages['links'] = $this->pagination->create_links();
						$pages['totals'] = ceil($rowsCount / 25);
						$pages['cur_page'] = $page;

						$this->load->view('tools/filters',$filters_data);
						$this->load->view('tools/table',$data);
						$this->load->view('tools/pagination',$pages);

					}

					if($user_type == 3) //buyer
					{
						$buyerId = $this->session->userdata('id');
                        // $sort_by = $this->input->post('sort_by');
						/*
						$data['statuses'] = array(
							'' => 'All',
							'0' => 'Pending/Buyer Approved Shipping Fee',
							'-2' => "Pending buyer's consent for new shipping fees",
							'-1' => 'Cancelled Order',
							'-4' => 'Return Order',
							'-3' => 'Refund Order',
							'1' => 'Shipped',
							'2' => 'Completed'
						);*/
						$data['statuses'] = array_merge(array(''=>'All'),apputils::orderStatus());

						$page = (int)$this->input->get('page');
						$page = $page > 0 ? $page : 1;
						$sort_by = $this->input->post('sort_by');
						$sort_direction = $this->input->post('sort_direction');
						$sort_direction = ($sort_direction != '') ? $sort_direction : 'desc';
						$sort_by = ($sort_by != '') ? $sort_by : 'bt_time';
						//filters
						$name =  $this->input->post('name');
						$start =  $this->input->post('start');
						$end =  $this->input->post('end');
						$stat =  $this->input->post('stat');

						$rowsCount= count($this->buyers->shipping_list_grouped($buyerId,'',$name,$start,$end,$stat,'',10,$sort_by,$sort_direction));
						$items = $this->buyers->shipping_list_grouped($buyerId,'',$name,$start,$end,$stat,$page,10,$sort_by,$sort_direction);
						foreach($items as $item) {
							$item->bsd_status = apputils::orderStatus($item->bsd_status);
							$item->bt_total_sum = number_format($item->bt_total_sum,2);
						}
						//$html = $this->load->view('supplier/supplier-search-shipping-result',$data,true);
						//echo $html;
						$filters_data['filters'] = array(
							'name' => array('title'=>"Company/Supplier's Name",'value'=>$name),
							'start' => array('title'=>'From','value'=>$start, 'type'=>'datepicker'),
							'end' => array('title'=>'To','value'=>$end, 'type'=>'datepicker'),
							'stat' => array('title'=>'Status','value'=>$stat, 'type'=>'select', 'opts'=>$data['statuses'])
						);

						$data['items'] = $items;
						$data['columns'] = array(
							'bt_time' => array('title'=>'Date','sortable'=>true),
							'bt_invoice' => array('title'=>'Invoice ID','sortable'=>true),
							'u_company' => array('title'=>'Company Name','sortable'=>true),
							'c_code' => array('title'=>'Country','sortable'=>true),
							'bsd_total_item' => array('title'=>'Total Items','sortable'=>true),
							'total_sum' => array('title'=>'Sum','sortable'=>true, 'format'=>"\$%01.2f"),
							'bsd_status' => array('title'=>'Status','sortable'=>true),
							'actions' => array(
								'title'=>'Action',
								'sortable'=>false,
								'items'=>array(
									'view' => array('link'=>'/buyer/order/', 'text'=> 'Order Detail', 'confirm'=>false, 'pk'=>'bsd_id')
								)
							),
						);
						$data['sorter']['by'] = $sort_by;
						$data['sorter']['dir'] = $sort_direction;

						$config['base_url'] = '/shipping/lists?';
						$config['total_rows'] = $rowsCount;
						$config['per_page'] = 10;
						$config['cur_page'] = $page;
						$config['use_page_numbers'] = true;
						$config['first_link'] = '<<';
						$config['last_link'] = '>>';
						$config['num_links'] = 3;
						$config['page_query_string'] = true;
						$config['query_string_segment'] = 'page';
						$config['num_tag_open'] = '<li>';
						$config['num_tag_close'] = '</li>';
						$config['first_tag_open'] = '<li>';
						$config['first_tag_close'] = '</li>';
						$config['last_tag_open'] = '<li>';
						$config['last_tag_close'] = '</li>';
						$config['next_tag_open'] = '<li>';
						$config['next_tag_close'] = '</li>';
						$config['prev_tag_open'] = '<li>';
						$config['prev_tag_close'] = '</li>';
						$config['cur_tag_open'] = '<li><a href="javascript:void(0);" style="color: #000;">';
						$config['cur_tag_close'] = '</a></li>';

						$this->pagination->initialize($config);

						$pages = array();
						$pages['links'] = $this->pagination->create_links();
						$pages['totals'] = ceil($rowsCount / 10);
						$pages['cur_page'] = $page;

						$this->load->view('tools/filters',$filters_data);
						$this->load->view('tools/table',$data);
						$this->load->view('tools/pagination',$pages);
					}
				}
			}
			else
			{
				if($user_type == 2) //supplier
				{
					$this->load->view('supplier/supplier-shipping-list', $data);
				}
				elseif($user_type == 3) //buyers
				{
					$this->load->view('buyer/buyer-transactions-request', $data);
				}
			}


		}
	}




	function request()
	{
		if($this->session->userdata('is_login') == TRUE)
		{
			$data['feat_categories'] = $this->categories->listings(0); //main categories
			$user_type = $this->session->userdata('type'); //get user type;
			//echo $user_type;
			if($user_type == 2)//supplier
			{
				$user_id = $this->session->userdata('id');
				$data['pending']  =  $this->suppliers->shipping_list_grouped($user_id, 0);
				$this->load->view('supplier/supplier-shipping-req', $data);
			}
			elseif($user_type == 3)//buyer
			{
				$user_id = $this->session->userdata('id');
				$data['pending']  =  $this->buyers->shipping_list_grouped($user_id, 0);
				
				//$this->load->view('buyer/buyer-test',$data);
				$this->load->view('buyer/buyer-transactions-request', $data);
			}
		}
	}

	function approved()
	{
		if($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			if($user_type == 2) //supplier
			{
				$user_id = $this->session->userdata('id');
				$data['app']  =  $this->suppliers->shipping_list_grouped($user_id,1);

				$this->load->view('supplier/supplier-shipping-app', $data);
			}
		}
	}

	function confirm()
	{

		if($this->session->userdata('is_login') == TRUE)
		{

			$user_type = $this->session->userdata('type'); //get user type;
			$user_id = $this->session->userdata('id');
			if($user_type == 2) //supplier
			{
				$action =  $this->input->post('action');

				if($action == 'add')
				{

					$track = $this->input->post('track');
					$bt_id = $this->input->post('bt_id');
					$start =  strtotime($this->input->post('start'));
					$bsd = $this->input->post('bsd');
					$method = $this->input->post('method');
					$carrier = $this->input->post('carrier');
					$extra_cost = $this->input->post('extra_cost');

					$shipped_info = $this->suppliers->shipping_list_grouped($user_id,$bsd);
					if ($shipped_info->bt_type)
					{
						switch($shipped_info->bt_type)
						{
							case 'paypal':
								$payment_result = $this->direct_cc_payment($bt_id,$bsd,$extra_cost);
								break;
							case 'credit card':
							default:
								$payment_result = $this->authorizenet_cc_payment($bt_id,$bsd,$extra_cost);
								break;
						}

					}


					/*modifed for testing purposes by @redix, issue#16*/
					if (1)/*($payment_result['status'] == 1)*/
					{

						$data_insert = array('bsd_id' =>$bsd ,
											 'u_id' =>$user_id, //supplier ID
											 'ssi_track' => $track,
											 'ssi_start' => $start,
											 'ssi_end' => '',
											 'ssi_shipMethod' => $method,
											 'ssi_carrier' => $carrier,
											 'ssi_shipExtra' => $extra_cost,
											 'ssi_time' => apputils::ConvertUnStampToMysqlDateTime(time()),
											 'ssi_status' => 1);

						$id = $this->suppliers->shipping_product_add_info($data_insert);
						$bsd_update = array('bsd_status' => '1', 'bsd_reason' => 'Shipped',
											'bsd_trans_id' => $payment_result['trans_id'],
										    'bsd_timestamp' =>strtotime($payment_result['time_stamp']),
										    'bsd_correlation_id' => $payment_result['cor_id'],
										    'bsd_ack' => $payment_result['ack'],
							);
						$this->suppliers->update_buyer_supplier_detail($bsd_update ,'bsd_id', $bsd);

						$email_data['transaction'] =  $this->suppliers->shipping_list_grouped($user_id,$bsd);
						$email_data['products'] =  $this->suppliers->transaction_detail($user_id,$bsd);
						$email_data['user'] = $this->users->info($email_data['transaction']->buyer_u_id);

						$email_data['email_type'] = "Confirm Shipping Expense";
						$email_content = $this->load->view('email/email-buyer-transaction',$email_data, true);

						$subject = "Oceantailer: Shipment Confirmation for Invoice #".$email_data['transaction']->bt_invoice;
						$from = "noreply-oceantailer@oceantailer.com";
						$sender = "OceanTrailer";
						$to = "".!empty($email_data['user']->u_additional_email)?$email_data['user']->u_additional_email:$email_data['user']->u_email;

						$this->send_message($email_content, $subject, $to, $from, $sender);

					}

					echo json_encode($payment_result);

				}
				elseif($action == 'request')
				{
					//$track = $this->input->post('track');
					//$bt_id = $this->input->post('bt_id');
					//$start =  strtotime($this->input->post('start'));
					$bsd = $this->input->post('bsd');
					//$method = $this->input->post('method');
					//$id_carrier = $this->input->post('carrier');
					$extra_cost = $this->input->post('extra_cost');
					//$country = $this->input->post('country');

					//$carrier = $this->suppliers->carrier_info($id_carrier);

					$data_insert = array('bsd_id' => $bsd,
										 'u_id' =>$user_id, //supplier ID
										 'ssi_shipExtra' => $extra_cost,
										 'ssi_status' => 0);

					$ssi_id = $this->suppliers->shipping_product_add_info($data_insert);

					$bsd_update = array('bsd_status' => '-2', 'bsd_reason' => "Pending buyer's consent for new shipping fees");

					$this->suppliers->update_buyer_supplier_detail($bsd_update ,'bsd_id', $bsd);

					$email_data['transaction'] =  $this->suppliers->shipping_list_grouped($user_id,$bsd);
					$email_data['products'] =  $this->suppliers->transaction_detail($user_id,$bsd);
					$email_data['user'] = $this->users->info($email_data['transaction']->buyer_u_id);

					$email_data['email_type'] = "Confirm Shipping Expense";
					$email_content = $this->load->view('email/email-buyer-transaction',$email_data, true);

					//$email_content;

					$subject = "Oceantailer: Shipment Confirmation for Invoice #".$email_data['transaction']->bt_invoice;
					$from = "noreply-oceantailer@oceantailer.com";
					$sender = "OceanTrailer";
					$to = "".!empty($email_data['user']->u_additional_email)?$email_data['user']->u_additional_email:$email_data['user']->u_email;

					//echo $email_content;exit;

					$this->send_message($email_content, $subject, $to, $from, $sender);
					$display = "<center><p>--Waiting for Cofirmation From the Buyer for the New Shipping Detail, Click <a href='#'>Here</a> to resend the Email--</p></center>";
					$returnmessage = array( 'display' => $display, 'status' => 1);
			        echo json_encode($returnmessage);
				}
			}
		}
	}
	function authorizenet_cc_payment($bt_id,$bsd_id,$total_shipping_include )
	{
		if($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			$supplierId = $this->session->userdata('id'); //id of the loged in user
			if($user_type == 2) //supplier
			{

				$shipped_info = $this->suppliers->shipping_list_grouped($supplierId,$bsd_id);
				$product_list =  $this->suppliers->transaction_detail($supplierId,$bsd_id);

				$trans_id = $shipped_info->bt_trans_id;

				$user = $this->users->info($shipped_info->buyer_u_id);

                $price = $shipped_info->bsd_total_paymet+$total_shipping_include;

        		$amount = number_format($price,2);

                $response = $this->authorizenet->priorAuthCapture($trans_id,$amount);


					$data_buyer_trans_update = array(
										  'bt_type' => 'credit card',
										  'bt_trans_id' => $response->transaction_id,
										  'bt_timestamp' =>  date("Y-m-d h:i:s",time()),
										  'bt_correlation_id' => $response->authorization_code,
										  'bt_ack' => $response->response_code,
										  'bt_status' => 0,
										  'bt_time_payed' => date("Y-m-d h:i:s",time()));

					$this->buyers->update_transaction($data_buyer_trans_update,'bt_id',$shipped_info->bt_id);


					foreach($product_list as $item) //update shipped stat
					{
						$data_update = array('btd_shipped_stat' => 1);
						$this->suppliers->update_buyer_shipping_det($data_update,'btd_id', $item->btd_id );
					}


					$data = array('result' => 1,
								  'invoice' => $shipped_info->bt_invoice,
								  'fullname' => $user->u_fname.$user->u_lname);


					// Buyer Payment Information
					$email_data['user'] =  $user;
					$email_data['transaction'] =  $this->buyers->get_trasaction_detail($shipped_info->bt_id);
					$email_data['ship'] =  $this->buyers->get_trasaction_detailShipping($shipped_info->bts_id);
					$email_data['products'] =  $product_list;

					$email_data['total'] =  $amount;
					$email_data['email_type'] = "Send Invoice";
					$email_content = $this->load->view('email/email-buyer-transaction',$email_data, true);

					//echo $email_content;

					// Buyer Payment Email Format
					$subject = "Oceantailer: Invoice Information";
					$from = "noreply-oceantailer@oceantailer.com";
					$sender = "http://www.oceantailer.com";
					$to = !empty($user->u_additional_email)?$user->u_additional_email:$user->u_email;

					// Send email to new Buyer
					$this->send_message($email_content, $subject, $to, $from, $sender);

					/////////////////////SENDING EMAIL TOWARDS RESPECTIVE SUPPLIER FOR THE NEW TRANSACTION MADE///////////////////

					$html_result = $this->load->view('buyer/buyer-payment-result',$data, TRUE);
					$returnmessage = array( 'display' => $html_result,
											'trans_id' => $response->transaction_id,
											'time_stamp' =>  date("Y-m-d h:i:s",time()),
											'cor_id' => $response->authorization_code,
											'ack' => $response->response_code,
											'status' => 1,'fullname' => $user->u_fname.$user->u_lname);
				    return $returnmessage;
      		}
		}
	}


	function direct_cc_payment($bt_id,$bsd_id,$total_shipping_include )
	{
		if($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			$supplierId = $this->session->userdata('id'); //id of the loged in user
			if($user_type == 2) //supplier
			{

				$is_Login_user = true;

				$shipped_info = $this->suppliers->shipping_list_grouped($supplierId,$bsd_id);
				$product_list =  $this->suppliers->transaction_detail($supplierId,$bsd_id);

				//echo print_r($shipped_info)."<br/><br/>tetst";

				$ba_id = $shipped_info->ba_id;

				$user = $this->users->info($shipped_info->buyer_u_id);
				$billing = $this->buyers->get_billing_info($ba_id);
				$cc = $this->buyers->creditcards($shipped_info->buyer_u_id,true);

				//echo print_r($cc);

				$shipping_used = $shipped_info->bt_is_sameBilling_to_ship;

				$country = $billing->c_id;
				$address1 = $billing->ba_add1;
				$address2 = $billing->ba_add2;
				$city = $billing->ba_city;
				$state = $billing->ba_province;
				$code = $billing->ba_postal;
				$phone = $billing->ba_phone_num;
				$phone_ext = $billing->ba_phone_num;

				if(!$shipping_used)
				{
					$country = $this->input->post('country');
					$address1 = $this->input->post('add1');
					$address2 = $this->input->post('add2');
					$city = $this->input->post('city');
					$state = $this->input->post('prov');
					$code = $this->input->post('postal');
					$phone = $this->input->post('phone_num');
					$phone_ext = $this->input->post('phone_ext');
				}

				if(strlen($cc->ccu_exp_month)==1)
					$cc->ccu_exp_month = "0".$cc->ccu_exp_month;

				$DPFields = array(
									'paymentaction' => 'Sale', 						// How you want to obtain payment.  Authorization indidicates the payment is a basic auth subject to settlement with Auth & Capture.  Sale indicates that this is a final sale for which you are requesting payment.  Default is Sale.
									'ipaddress' => $_SERVER['REMOTE_ADDR'], 							// Required.  IP address of the payer's browser.
									'returnfmfdetails' => '' 					// Flag to determine whether you want the results returned by FMF.  1 or 0.  Default is 0.
								);

				$CCDetails = array(
									'creditcardtype' => $cc->cc_type, 					// Required. Type of credit card.  Visa, MasterCard, Discover, Amex, Maestro, Solo.  If Maestro or Solo, the currency code must be GBP.  In addition, either start date or issue number must be specified.
									'acct' => $cc->ccu_number, 								// Required.  Credit card number.  No spaces or punctuation.
									'expdate' => $cc->ccu_exp_month.$cc->ccu_exp_year, 							// Required.  Credit card expiration date.  Format is MMYYYY
									'cvv2' => $cc->ccu_ccv, 								// Requirements determined by your PayPal account settings.  Security digits for credit card.
									'startdate' => '', 							// Month and year that Maestro or Solo card was issued.  MMYYYY
									'issuenumber' => ''							// Issue number of Maestro or Solo card.  Two numeric digits max.
								);

				$PayerInfo = array(
									'email' => $user->u_email, 								// Email address of payer.
									'payerid' => '', 							// Unique PayPal customer ID for payer.
									'payerstatus' => '', 						// Status of payer.  Values are verified or unverified
									'business' => $user->u_company 							// Payer's business name.
								);

				$PayerName = array(
									'salutation' => '', 						// Payer's salutation.  20 char max.
									'firstname' => $user->u_fname, 							// Payer's first name.  25 char max.
									'middlename' => '', 						// Payer's middle name.  25 char max.
									'lastname' => $user->u_lname, 							// Payer's last name.  25 char max.
									'suffix' => ''								// Payer's suffix.  12 char max.
								);

				$BillingAddress = array(
										'street' => $billing->ba_add1, 						// Required.  First street address.
										'street2' => $billing->ba_add2, 						// Second street address.
										'city' => $billing->ba_city, 							// Required.  Name of City.
										'state' => $billing->ba_province, 							// Required. Name of State or Province.
										'countrycode' => $billing->c_code, 					// Required.  Country code.
										'zip' => $billing->ba_postal, 							// Required.  Postal code of payer.
										'phonenum' => $billing->ba_phone_num.' '.$billing->ba_phone_ext					// Phone Number of payer.  20 char max.
									);

				$ShippingAddress = array(
										'shiptoname' => "", 					// Required if shipping is included.  Person's name associated with this address.  32 char max.
										'shiptostreet' => "", 					// Required if shipping is included.  First street address.  100 char max.
										'shiptostreet2' => "", 					// Second street address.  100 char max.
										'shiptocity' => "",					// Required if shipping is included.  Name of city.  40 char max.
										'shiptostate' => "", 					// Required if shipping is included.  Name of state or province.  40 char max.
										'shiptozip' => "", 						// Required if shipping is included.  Postal code of shipping address.  20 char max.
										'shiptocountry' => "", 					// Required if shipping is included.  Country code of shipping address.  2 char max.
										'shiptophonenum' => "",					// Phone number for shipping address.  20 char max.
										);

				$PaymentDetails = array(
										'amt' => ''.$shipped_info->bsd_total_paymet+$total_shipping_include, 							// Required.  Total amount of order, including shipping, handling, and tax.
										'currencycode' => 'USD', 					// Required.  Three-letter currency code.  Default is USD.
										'itemamt' => ''.$shipped_info->bsd_total_paymet, 						// Required if you include itemized cart details. (L_AMTn, etc.)  Subtotal of items not including S&H, or tax.
										'shippingamt' => $total_shipping_include, 					// Total shipping costs for the order.  If you specify shippingamt, you must also specify itemamt.
										'insuranceamt' => '', 					// Total shipping insurance costs for this order.
										'shipdiscamt' => '', 					// Shipping discount for the order, specified as a negative number.
										'handlingamt' => '', 					// Total handling costs for the order.  If you specify handlingamt, you must also specify itemamt.
										'taxamt' => '', 						// Required if you specify itemized cart tax details. Sum of tax for all items on the order.  Total sales tax.
										'desc' => '', 							// Description of the order the customer is purchasing.  127 char max.
										'custom' => '', 						// Free-form field for your own use.  256 char max.
										'invnum' => '', 						// Your own invoice or tracking number
										'buttonsource' => '', 					// An ID code for use by 3rd party apps to identify transactions.
										'notifyurl' => '', 						// URL for receiving Instant Payment Notifications.  This overrides what your profile is set to use.
										'recurring' => ''						// Flag to indicate a recurring transaction.  Value should be Y for recurring, or anything other than Y if it's not recurring.  To pass Y here, you must have an established billing agreement with the buyer.
									);

				// For order items you populate a nested array with multiple $Item arrays.
				// Normally you'll be looping through cart items to populate the $Item array
				// Then push it into the $OrderItems array at the end of each loop for an entire
				// collection of all items in $OrderItems.

				$OrderItems = array();
				$total_sub_amount_test = 0;
				foreach($product_list as $item)
				{
					$Item	 = array(
										'l_name' => $item->tr_title, 						// Item Name.  127 char max.
										'l_desc' => '', 						// Item description.  127 char max.
										'l_amt' => $item->btd_amount, 								// Cost of individual item.
										'l_number' => $item->ic_id, 						// Item Number.  127 char max.
										'l_qty' => $item->btd_quan, 							// Item quantity.  Must be any positive integer.
										'l_taxamt' => '', 						// Item's sales tax amount.
										'l_ebayitemnumber' => '', 				// eBay auction number of item.
										'l_ebayitemauctiontxnid' => '', 		// eBay transaction ID of purchased item.
										'l_ebayitemorderid' => '' 				// eBay order ID for the item.
								);

					$total_sub_amount_test += $item->btd_amount*$item->btd_quan;

					array_push($OrderItems, $Item);
				}

				$Secure3D = array(
							  'authstatus3d' => '',
							  'mpivendor3ds' => '',
							  'cavv' => '',
							  'eci3ds' => '',
							  'xid' => ''
							  );

				$PayPalRequestData = array(
									'DPFields' => $DPFields,
									'CCDetails' => $CCDetails,
									'PayerInfo' => $PayerInfo,
									'PayerName' => $PayerName,
									'BillingAddress' => $BillingAddress,
									'ShippingAddress' => $ShippingAddress,
									'PaymentDetails' => $PaymentDetails,
									'OrderItems' => $OrderItems,
									'Secure3D' => $Secure3D);

				$PayPalResult = $this->paypal_pro->DoDirectPayment($PayPalRequestData);
				/*echo "<pre>";print_r($PayPalResult);exit;*/
				if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
				{
					$errors = array('errors'=>$PayPalResult['ERRORS'], 'status' => 0,'payment' => $shipped_info->bsd_total_paymet.' = '.$total_sub_amount_test);

					$html_result = $this->load->view('buyer/buyer-payment-result',$data, TRUE);
					$returnmessage = array('errors'=>$PayPalResult['ERRORS'],'display' => $html_result, 'status' => 0);
				    return $errors;
				}
				else
				{

					$data_buyer_trans_update = array(
										  'bt_type' => 'paypal',
										  'bt_trans_id' => $PayPalResult['TRANSACTIONID'],
										  'bt_total_payment' => $PayPalResult['AMT'],
										  'bt_timestamp' => $PayPalResult['TIMESTAMP'],
										  'bt_correlation_id' => $PayPalResult['CORRELATIONID'],
										  'bt_ack' => $PayPalResult['ACK'],
										  'bt_status' => 0,
										  'bt_time_payed' => date("Y-m-d h:i:s",time()));

					$this->buyers->update_transaction($data_buyer_trans_update,'bt_id',$shipped_info->bt_id);


					foreach($product_list as $item) //update shipped stat
					{
						$data_update = array('btd_shipped_stat' => 1);
						$this->suppliers->update_buyer_shipping_det($data_update,'btd_id', $item->btd_id );
					}

					$data = array('resultPaypal'=> $PayPalResult,
								  'result' => 1,
								  'invoice' => $shipped_info->bt_invoice,
								  'fullname' => $user->u_fname.$user->u_lname);

					// Buyer Payment Information
					$email_data['user'] =  $user;
					$email_data['transaction'] =  $this->buyers->get_trasaction_detail($shipped_info->bt_id);
					$email_data['ship'] =  $this->buyers->get_trasaction_detailShipping($shipped_info->bts_id);
					$email_data['products'] =  $product_list;
					$email_data['total'] =  $shipped_info->bt_total_payment;
					$email_data['email_type'] = "Send Invoice";
					$email_content = $this->load->view('email/email-buyer-transaction',$email_data, true);

					//echo $email_content;

					// Buyer Payment Email Format
					$subject = "Oceantailer: Invoice Information";
					$from = "noreply-oceantailer@oceantailer.com";
					$sender = "http://www.oceantailer.com";
					$to = "".!empty($user->u_additional_email)?$user->u_additional_email:$user->u_email;

					// Send email to new Buyer
					$this->send_message($email_content, $subject, $to, $from, $sender);

					/////////////////////SENDING EMAIL TOWARDS RESPECTIVE SUPPLIER FOR THE NEW TRANSACTION MADE///////////////////



					$html_result = $this->load->view('buyer/buyer-payment-result',$data, TRUE);
					$returnmessage = array( 'display' => $html_result,
											'trans_id' => $PayPalResult['TRANSACTIONID'],
											'time_stamp' => $PayPalResult['TIMESTAMP'],
											'cor_id' => $PayPalResult['CORRELATIONID'],
											'ack' => $PayPalResult['ACK'],
											'status' => 1,'fullname' => $user->u_fname.$user->u_lname);
				    return $returnmessage;
				}

				/*$returnmessage = array( 'display' => $html_result  , 'status' => 1);
				return $returnmessage;*/
			}
		}
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

}

function DebToFile($contents, $IsClearText= true, $FileName= '') {
    try {
        if (empty($FileName))
            $FileName = '/_wwwroot/OTEngineers/log/logging_deb.txt';
        $fd = fopen($FileName, ( $IsClearText ? "w+" : "a+"));
        fwrite($fd, $contents . chr(13));
        fclose($fd);
        return true;
    } catch (Exception $lException) {
        return false;
    }
}
