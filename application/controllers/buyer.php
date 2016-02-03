<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class buyer extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
        $this->load->library('apputils'); // load library with ConvertUnStampToMysqlDateTime function
		$this->load->model('buyers');
		$this->load->model('suppliers');
		$this->load->model('users');
		$this->load->model('creditcards');
		$this->load->model('countries');
		$this->load->model('categories');
		$this->load->model('manufacturers');
		$this->load->model('inventories');
		$this->load->model('administrators');
		$this->load->model('datafeeds');
		$this->load->model('datafeedfiles');
		$this->load->model('brands');
		$this->load->helper('form');
        $this->load->library('pagination');
	}

	function index()
	{
		if($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			if($user_type == 3)
			{
				$data['left_categories'] = $this->categories->listings(0) ;// categories + subcategories
				$data['feat_categories'] = $this->categories->listings(0); //main categories
				$data['categories'] = array(); //main categories
				$data['brands'] = array();
				$data['manus'] = array();
				$data['suppliers'] = $this->suppliers->listing(1);
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

				$this->load->view('buyer/buyer-home',$data);
			}
			else if ($user_type == 1)
			{
                $page = $this->input->get('page')?$this->input->get('page'):1;
                $order = $this->input->post('sort_by')?$this->input->post('sort_by'):'u_id';
                $dir = $this->input->post('sort_direction')?$this->input->post('sort_direction'):'desc';
                $user_type_num = 0;

                $data['user_type'] = 'buyer';
                $data['list_type'] = 'pending';
                $data['page'] = $page;
                $data['order_by'] = $order;
                $data['dir'] = $dir;
                $data['totals'] = count($this->buyers->listing($user_type_num));

                $data['items'] = $this->buyers->listing($user_type_num, $page, 10, $order, $dir);
                $data['columns'] = array(
                    'u_lname' => array('title'=>'Buyer Name','sortable'=>true),
                    'u_email' => array('title'=>'Email','sortable'=>true),
                    'u_username' => array('title'=>'Username','sortable'=>true),
                    'u_company' => array('title'=>'Company Name','sortable'=>true),
                    'actions' => array(
                        'title'=>'Action',
                        'sortable'=>false,
                        'items'=>array(
                            'view_profile' => array('link'=>'/buyer/profile/admin/', 'text'=> 'View Profile', 'confirm'=>false, 'pk'=>'u_id'),
                            'approve' => array('link'=>'/buyer/update/approved/', 'text'=> '<i class="ot_approve_icon"></i>', 'confirm'=>false, 'pk'=>'u_id', 'options'=>array('class'=>'approve')),
                            'deny' => array('link'=>'/buyer/update/denied/', 'text'=> '<i class="ot_deny_icon"></i>', 'confirm'=>false, 'pk'=>'u_id', 'options'=>array('class'=>'deny'))
                        )
                    ),
                );

                $data['sorter']['by'] = $order;
                $data['sorter']['dir'] = $dir;

                $config['base_url'] = '/buyer/?';
                $config['total_rows'] = $data['totals'];
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
                $pages['totals'] = ceil($data['totals'] / 10);
                $pages['cur_page'] = $page;

                $filters = $this->load->view('tools/filters',array(), true);
                $table = $this->load->view('tools/table',$data,true);
                $paging = $this->load->view('tools/pagination',$pages,true);
                $this->load->view('admin/users-list', array_merge($data,array('filters'=>$filters,'table'=>$table,'paging'=>$paging)));
			}
		}
		else
			redirect('','refresh');
	}

	/* Lanz Editted - July 21, 2013 */
	function updatepassword()
	{
		$data['feat_categories'] = $this->categories->listings(0); //main categories
		if ($this->session->userdata('is_login') == TRUE)
		{
			$this->load->view('buyer/buyer-update-password',$data);
		}
	}

	function list_suppliers()
	{
		$this->load->library('encrypt');
		if($this->session->userdata('is_login') == true) {
			$user_type = $this->session->userdata('type');
		}
		if($user_type == 3) {
			$user_id = $this->session->userdata('id'); //id of the loged in user
			$page = (int)$this->input->get('page');
			$page = $page < 1 ? 1 : $page;

			$res = $this->suppliers->listing(1, $page);
			$output = array();
			foreach($res as $r) {
				$hashes = array(
					'txt' => $this->encrypt->encode(serialize(array('id' => $r->u_id, 'extract' => 'supplier', 'user_id' => $user_id, 'type' => 'txt'))),
					'csv' => $this->encrypt->encode(serialize(array('id' => $r->u_id, 'extract' => 'supplier', 'user_id' => $user_id, 'type' => 'csv'))),
					'xml' => $this->encrypt->encode(serialize(array('id' => $r->u_id, 'extract' => 'supplier', 'user_id' => $user_id, 'type' => 'xml'))),
					'xls' => $this->encrypt->encode(serialize(array('id' => $r->u_id, 'extract' => 'supplier', 'user_id' => $user_id, 'type' => 'xls'))),
				);
				$output[] = array('u_company' => $r->u_company, 'hashes' => $hashes);
			}
			echo json_encode(array('items' => $output));
		}
	}

	function datafeed()
	{
        $this->load->library('encrypt');
		$user_type = 0;
		if($this->session->userdata('is_login') == true) {
			$user_type = $this->session->userdata('type');
		}
        //DebToFile('$user_type::'.print_r($user_type,true));
		if($user_type == 3) {
			$user_id = $this->session->userdata('id'); //id of the loged in user
			if($this->input->is_ajax_request()) {
				$page = (int)$this->input->get('page');
				$page = '';//$page < 1 ? 1 : $page;
                //function listing($id = "", $page = 0, $sort_by= 'i_id')
				$feed = $this->datafeeds->listing($user_id, $page);
				echo json_encode(array('items' => $feed));
                //$this->load->view('admin/buyer/buyer-data-feed-result', array('items' => $feed));
				return;
			}

			$data['hashes'] = array(
				'all' => array(
					'csv' => $this->encrypt->encode(serialize(array('extract' => 'all', 'type' => 'csv', 'user_id' => $user_id))),
					'txt' => $this->encrypt->encode(serialize(array('extract' => 'all', 'type' => 'txt', 'user_id' => $user_id))),
					'xml' => $this->encrypt->encode(serialize(array('extract' => 'all', 'type' => 'xml', 'user_id' => $user_id))),
					'xls' => $this->encrypt->encode(serialize(array('extract' => 'all', 'type' => 'xls', 'user_id' => $user_id))),
				),
				'dp' => array(
					'csv' => $this->encrypt->encode(serialize(array('extract' => 'dropshipping', 'type' => 'csv', 'user_id' => $user_id))),
					'txt' => $this->encrypt->encode(serialize(array('extract' => 'dropshipping', 'type' => 'txt', 'user_id' => $user_id))),
					'xml' => $this->encrypt->encode(serialize(array('extract' => 'dropshipping', 'type' => 'xml', 'user_id' => $user_id))),
					'xls' => $this->encrypt->encode(serialize(array('extract' => 'dropshipping', 'type' => 'xls', 'user_id' => $user_id))),
				),
				'custom' => array(
					'csv' => $this->encrypt->encode(serialize(array('extract' => 'custom', 'type' => 'csv', 'user_id' => $user_id))),
					'txt' => $this->encrypt->encode(serialize(array('extract' => 'custom', 'type' => 'txt', 'user_id' => $user_id))),
					'xml' => $this->encrypt->encode(serialize(array('extract' => 'custom', 'type' => 'xml', 'user_id' => $user_id))),
					'xls' => $this->encrypt->encode(serialize(array('extract' => 'custom', 'type' => 'xls', 'user_id' => $user_id))),
				)
			);

			$data['feat_categories'] = $this->categories->listings(0); //main categories
			//$data['datafeed'] = $this->datafeeds->listing($user_id, 1);
			$data['datafeed_total'] = ceil(count($this->datafeeds->listing($user_id)) / 10);
			$data['suppliers_total'] = ceil(count($this->suppliers->listing(1)) / 20);
			$this->load->library('encrypt');
			$data['hash'] = urlencode($this->encrypt->encode($this->session->userdata('id')));
	//		$data['datafeedall'] = $this->datafeeds->prodlist($user_id);
			$data['datafeedfile']['allprods'] = $this->datafeedfiles->get_file($user_id, "allprods");
			$data['datafeedfile']['dropshipping'] = $this->datafeedfiles->get_file($user_id, "dropshipping");
			$data['datafeedfile']['suppliers'] = $this->datafeedfiles->get_file($user_id, "suppliers");
			$data['datafeedfile']['datafeed'] = $this->datafeedfiles->get_file($user_id, "datafeed");
            //DebToFile('$data::'.print_r($data,true));

			$this->load->view('admin/buyer/buyer-data-feed', $data);
		} else {
			redirect('/','refresh');
		}

	}

	/* Lanz - Editted */
	function view()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type
			if ($user_type == 1) // admin
			{
				$view_type = $this->uri->segment(3);

                $filter_operation_company_name= !empty($_REQUEST['filter_operation_company_name']) ? $_REQUEST['filter_operation_company_name'] : 'Contains';
                $filter_company_name= !empty($_REQUEST['filter_company_name']) ? $_REQUEST['filter_company_name'] : '';

                $filter_operation_username= !empty($_REQUEST['filter_operation_username']) ? $_REQUEST['filter_operation_username'] : 'Contains';
                $filter_username= !empty($_REQUEST['filter_username']) ? $_REQUEST['filter_username'] : '';

                $filter_operation_email= !empty($_REQUEST['filter_operation_email']) ? $_REQUEST['filter_operation_email'] : 'Contains';
                $filter_email= !empty($_REQUEST['filter_email']) ? $_REQUEST['filter_email'] : '';

                $page = $this->input->get('page')?$this->input->get('page'):1;
                $order = $this->input->post('sort_by')?$this->input->post('sort_by'):'u_id';
                $dir = $this->input->post('sort_direction')?$this->input->post('sort_direction'):'desc';
                $user_type_num = 0;
                switch($view_type){
                    case 'pending': $user_type_num =0; break;
                    case 'approved': $user_type_num =1; break;
                    case 'denied': $user_type_num =2; break;
                }

                $data['user_type'] = 'buyer';
                $data['list_type'] = $view_type;
                $data['page'] = $page;
                $data['order_by'] = $order;
                $data['dir'] = $dir;
                
                $data['totals'] = count($this->buyers->listing(  $user_type_num, 0, 0, $order, $dir, addslashes($filter_operation_company_name), addslashes($filter_company_name), addslashes($filter_operation_username), addslashes($filter_username),addslashes($filter_operation_email), addslashes($filter_email)  ));
                
                $data['items'] = $this->buyers->listing(  $user_type_num, $page, 10, $order, $dir, addslashes($filter_operation_company_name), addslashes($filter_company_name), addslashes($filter_operation_username), addslashes($filter_username),addslashes($filter_operation_email), addslashes($filter_email)  ); //

                $data['filter_operation_company_name']= $filter_operation_company_name;
                $data['filter_company_name']= $filter_company_name;
                $data['filter_operation_username']= $filter_operation_username;
                $data['filter_username']= $filter_username;
                $data['filter_operation_email']= $filter_operation_email;
                $data['filter_email']= $filter_email;

                $data['columns'] = array(
                    'u_lname' => array( 'title'=>'Buyer Name','sortable'=>true ),
                    'u_email' => array( 'title'=>'Email','sortable'=>true ),
                    'u_username' => array('title'=>'Username','sortable'=>true),
                    'u_company' => array('title'=>'Company Name','sortable'=>true),
                    'actions' => array(
                        'title'=>'Action',
                        'sortable'=>false,
                        'items'=>array(
                            'view_profile' => array('link'=>'/buyer/profile/admin/', 'text'=> 'View Profile', 'confirm'=>false, 'pk'=>'u_id'),
                        )
                    ),
                );
                if($user_type_num == 0){
                    $data['columns']['actions']['items']['approve'] = array('link'=>'/buyer/update/approved/', 'text'=> '<i class="ot_approve_icon"></i>', 'confirm'=>false, 'pk'=>'u_id', 'options'=>array('class'=>'approve'));
                    $data['columns']['actions']['items']['deny'] = array('link'=>'/buyer/update/denied/', 'text'=> '<i class="ot_deny_icon"></i>', 'confirm'=>false, 'pk'=>'u_id', 'options'=>array('class'=>'deny'));
                }elseif($user_type_num == 1){
                    $data['columns']['actions']['items']['login'] = array('link'=>'/administrator/loginAs/admin/', 'text'=> 'Log In', 'confirm'=>false, 'pk'=>'u_id');
                    $data['columns']['actions']['items']['deny'] = array('link'=>'/buyer/update/denied/', 'text'=> '<i class="ot_deny_icon"></i>', 'confirm'=>false, 'pk'=>'u_id', 'options'=>array('class'=>'deny'));
                }elseif($user_type_num == 2){
                    $data['columns']['actions']['items']['approve'] = array('link'=>'/buyer/update/approved/', 'text'=> '<i class="ot_approve_icon"></i>', 'confirm'=>false, 'pk'=>'u_id', 'options'=>array('class'=>'approve'));
                }

                $data['sorter']['by'] = $order;
                $data['sorter']['dir'] = $dir;

                $config['base_url'] = '/buyer/view/'.$view_type.'?';
                $config['total_rows'] = $data['totals'];
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
                $pages['totals'] = ceil($data['totals'] / 10);
                $pages['cur_page'] = $page;

                $filters = $this->load->view('tools/filters',array(), true);
                $table = $this->load->view('tools/table',$data,true);
                $paging = $this->load->view('tools/pagination',$pages,true);
                $this->load->view('admin/users-list', array_merge($data,array('filters'=>$filters,'table'=>$table,'paging'=>$paging)));
			}
		}
		else
		{
			redirect('','refresh');
		}
	}


	/* Lanz Editted - July 21, 2013 */
	function update()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type
			if ($user_type == 1) // admin
			{
				$supplier_id = $this->uri->segment(4);
				$action_type = $this->uri->segment(3);

				if ($action_type == "approved")
				{
					$data = array('u_admin_approve' => 1,'u_status' => 1);

                                        // update supplier data
					$this->buyers->update($supplier_id, $data);

					// get user info
					$user_info = $this->users->info($supplier_id);

					// assign email info to a variable
					$email_content = $this->buyerApprovedEmail($user_info);

					// send email from admin to supplier
					$subject = "Oceantailer: Administration Account Verification";
					$from = "noreply-oceantailer@oceantailer.com";
					$sender = "http://www.oceantailer.com";
					$to = $user_info->u_email;
					$this->send_message($email_content, $subject, $to, $from, $sender);

					// redirect to approvbr
					redirect('buyer/view/pending','refresh');
				}
				else if ($action_type == "denied")
				{
					$data = array('u_admin_approve' => 2);
					$this->buyers->update($supplier_id, $data);
					redirect('buyer/view/pending', 'refresh');
				}
			}

			if ($this->input->post('action') == "update")
			{
				$buyer_id = $this->session->userdata('id');
				$current_password = $this->input->post('curr_pass');
				$new_password = $this->input->post('new_pass');
				$new_password1 = $this->input->post('new_pass1');

				$current_pass = $this->users->password($buyer_id);
				if ($current_password == $current_pass)
				{
					if (empty($new_password) || empty($new_password1))
					{
						$message = array('status' => 1, 'message' => 'Must provide new password');
						echo json_encode($message);
					}
					else if ($new_password != $new_password1)
					{
						$message = array('status' => 0, 'message' => 'Password does not match');
						echo json_encode($message);
					}
					else
					{
						$new_pass = $this->users->encript($new_password);
						$updated_pass = array(
							'u_pass' => $new_pass
							);

						$this->users->updatepassword($updated_pass, $buyer_id);

						$message = array('status' => 2, 'message' => 'Password Updated Successfully');
						echo json_encode($message);
					}
				}
				else if (empty($current_password) || empty($new_password) || empty($new_password1))
				{
					$message = array('status' => 0, 'message' => 'Please provide password');
					echo json_encode($message);
				}
				else
				{
					$message = array('status' => 0, 'message' => 'Password does not match');
					echo json_encode($message);
				}
			}
		}
	}

	/* Lanz Editted - July 22, 2013 */
	function validate_address1($mail)
	{
		$this->form_validation->set_message('validate_address1','Address 1 invalid');
        if (is_numeric($mail))
        {
        	return false;
        }

        $this->form_validation->set_message('validate_address1','Address 1 you entered already exist');
        if ($this->users->check_address1($this->session->userdata('id'), $mail))
        {
        	return false;
        }
        else
        {
        	return true;
        }
	}

	/* Lanz Editted - July 22, 2013 */
	function validate_address2($mail)
	{
		$this->form_validation->set_message('validate_address2','Address 2 invalid');
        if (is_numeric($mail))
        {
        	return false;
        }

		$this->form_validation->set_message('validate_address2','Address 2 you entered already exist');
        if ($this->users->check_address2($this->session->userdata('id'), $mail))
        {
        	return false;
        }
        else
        {
        	return true;
        }
	}

	/* Lanz Editted - July 22, 2013 */
	function validate_phonenumber($number)
	{
		$this->form_validation->set_message('validate_phonenumber', 'Phone number is invalid');
		if (!is_numeric($number))
		{
			return false;
		}

		$this->form_validation->set_message('validate_address2','Phone number already exist');
        if ($this->users->check_address2($this->session->userdata('id'), $number))
        {
        	return false;
        }
        else
        {
        	return true;
        }
	}

	/* Lanz Editted - July 22, 2013 */
	function validate_zipcode($number)
	{
		$this->form_validation->set_message('validate_zipcode', 'Zip Code/Postal Code is invalid');
		if (!is_numeric($number))
		{
			return false;
		}
	}

	/* Lanz Editted - July 22, 2013 */
	function validate_town($town)
	{
		$this->form_validation->set_message('validate_town', 'Town/City is invalid');
		if (is_numeric($town))
		{
			return false;
		}
	}

	/* Lanz Editted - July 22, 2013 */
	function validate_credit_card($creditcard_num)
	{
		$this->form_validation->set_message('validate_credit_card', 'Invalid creditcard');
		if (!is_numeric($creditcard_num))
		{
			return false;
		}

		$this->form_validation->set_message('validate_credit_card','Creditcard already exist');
        if ($this->users->check_creditcard($creditcard_num))
        {
        	return false;
        }
        else
        {
        	return true;
        }
	}

	/* Lanz Editted - July 22, 2013 */
	function validate_cardholder($creditcard_holder_name)
	{
		$this->form_validation->set_message('validate_cardholder', 'Card holder name is invalid');
		if (is_numeric($creditcard_holder_name))
		{
			return false;
		}
	}

	/* Lanz Editted - July 22, 2013 */
	function validate_cardccv($creditcard_ccv)
	{
		$this->form_validation->set_message('validate_cardccv', 'Creditcard CCV is invalid');
		if (!is_numeric($creditcard_ccv))
		{
			return false;
		}
	}

	// Lanz Editted - June 4, 2013
	function add()
	{
		if($this->session->userdata('is_login') == TRUE)
		{
			redirect('buyer', 'refresh');
		}
		else
		{
			header('Access-Control-Allow-Origin: http://www.oceantailer.com');

			if($this->input->post('action') != "")
			{
				$action = $this->input->post('action');
				if($action == 'register') //if registering user
				{
					// Basic Information
					$firstname = $this->input->post('firstname');
					$lastname = $this->input->post('lastname');
					$uname = $this->input->post('uname');
					$email = $this->input->post('email');
					$company = $this->input->post('company');
					$permit = $this->input->post('permit');

     				$pass = $this->input->post('pass');
					$conpass = $this->input->post('conpass');

					// Credit Card Information
					/*$cctype = $this->input->post('cctype');
					$ccuname = $this->input->post('ccuname');
					$ccunum = $this->input->post('ccunum');
					$ccuccv = $this->input->post('ccuccv');
					$exp_month = $this->input->post('exp_month');
					$exp_year = $this->input->post('exp_year');
*/
					// Billing Address Information
					$country = $this->input->post('country');
					$add1 = $this->input->post('add1');
					$add2 = $this->input->post('add2');
					$city = $this->input->post('city');
					$prov = $this->input->post('prov');
					$postal = $this->input->post('postal');
					$phone_num = $this->input->post('phone_num');
					$phone_ext = $this->input->post('phone_ext');

					// Additional Information
					$website = $this->input->post('website');
					$how_you_find = $this->input->post('how_you_find');
					$important = $this->input->post('important');
					$avg_sales = $this->input->post('avg_sales');

					// Load Form Validation Library
					$this->load->library('form_validation');

					// Basic Information Validation
					$this->form_validation->set_rules('firstname','First Name','trim|required|xss_clean');
					$this->form_validation->set_rules('lastname','Last Name','trim|required|xss_clean');
					$this->form_validation->set_rules('uname','Username','trim|required|min_length[5]|xss_clean|callback_isUserNameExist');
					$this->form_validation->set_rules('email','Email','trim|required|min_length[5]|valid_email|xss_clean|callback_isEmailExist');
					$this->form_validation->set_rules('pass','Password','trim|min_length[6]|max_length[40]|required|xss_clean|matches[conpass]');
					$this->form_validation->set_rules('conpass','Confirm Password','trim|min_length[6]|max_length[40]|required|xss_clean');
					$this->form_validation->set_rules('permit','FEID or State License Number','trim|required|xss_clean');

					// Credit Card Validation
					/*$this->form_validation->set_rules('cctype','Credit Card','trim|required|xss_clean');
					$this->form_validation->set_rules('ccuname','Credit Card Name','trim|required|xss_clean');

					if($cctype == 3) // American Express
						$this->form_validation->set_rules('ccunum','Credit Card Number','trim|numeric|exact_length[15]|xss_clean');
					else
						$this->form_validation->set_rules('ccunum','Credit Card Number','trim|numeric|exact_length[16]|xss_clean');

					if($cctype == 3) // American Express
						$this->form_validation->set_rules('ccuccv','CCV Number','trim|numeric|exact_length[4]|xss_clean');
					else
						$this->form_validation->set_rules('ccuccv','CCV Number','trim|numeric|exact_length[3]|xss_clean');

					$this->form_validation->set_rules('exp_month','Expiration Month','trim|required|xss_clean');
					$this->form_validation->set_rules('exp_year','Expiration Year','trim|required|xss_clean');
                                        */
					// Billing Address Validation
					$this->form_validation->set_rules('country','Country','trim|required|xss_clean');
					$this->form_validation->set_rules('add1','Address 1','trim|required|xss_clean');
					$this->form_validation->set_rules('add2','Address 2','trim|xss_clean');
					$this->form_validation->set_rules('city','City','trim|required|xss_clean');
					$this->form_validation->set_rules('prov','State/Province','trim|required|xss_clean');
					$this->form_validation->set_rules('phone_num','Phone Number','trim|required|numeric|xss_clean');
					$this->form_validation->set_rules('phone_ext','Phone Extension','trim|numeric|xss_clean');

					// Additional Information Validation
					$this->form_validation->set_rules('website','Website','trim|xss_clean');
					$this->form_validation->set_rules('how_you_find','How You Find Us','trim|xss_clean');
					$this->form_validation->set_rules('important','Most Important From Suppliers','trim|xss_clean');
					$this->form_validation->set_rules('avg_sales','Average Sales','trim|xss_clean');

					// Run validation
					if($this->form_validation->run() == FALSE)
					{
						$returnmessage = array( 'message' => "<div class='error-cont' style='color:red'>".str_replace("\n","<br>",validation_errors())."</div>" , 'status' => 0);
			             echo json_encode($returnmessage);
					}
					else
					{
						// Generate Activaton Code
						$activation_code = strtolower($this->rndm_strng('alnum',25));

						// New Buyer Information
						$add_user = array(
										'u_username'  => $uname,
										'u_pass'  => $this->users->encript($pass),
										'u_fname'  => $firstname,
										'u_lname'  => $lastname,
          								'u_company' =>$company,
                                        'u_permit' =>$permit,
										'u_email'  => $email,
										'u_type'  => 3,
										'u_status'  => 0,
										'u_admin_approve'  => 0,
										'u_verify_code'  => $activation_code,
										'u_pic'  => "",
                                        'u_time'  => apputils::ConvertUnStampToMysqlDateTime( time() )
							   		);

						// Add new buyer and return ID
						$user_id = $this->users->add($add_user);

						// New Buyer Credit Card Information
						/*$add_ccu = array(
							   			'u_id'  => $user_id,
							   			'cc_id'  => $cctype,
							   			'ccu_name'  => $ccuname,
							   			'ccu_number'  => $ccunum,
							   			'ccu_ccv'  => $ccuccv,
							   			'ccu_exp_month'  => $exp_month,
							   			'ccu_exp_year'  => $exp_year,
							   			'ccu_isset' => 1
							   		);

						// Add new buyer credit card and return ID
						$ccu_id = $this->users->ccu_add($add_ccu);
                                                */
						// New Buyer Billing Address
						$add_billing = array(
				   					'u_id'  => $user_id,
				   					'c_id'  => $country,
				   					'ba_add1'  => $add1,
				   					'ba_add2'  => $add2,
				   					'ba_city'  => $city,
				   					'ba_province'  => $prov,
				   					'ba_postal'  => $postal,
				   					'ba_phone_num'  => $phone_num,
				   					'ba_phone_ext'  => $phone_ext,
				   					'ba_isset' => 1
				   					);

				   		$ba_id = $this->users->business_address_add($add_billing);

						// New Buyer Additional Information
						$add_more_info = array(
				   					'u_id'  => $user_id,
				   					'website'  => $website,
				   					'how_you_find'  => $how_you_find,
				   					'important'  => $important,
				   					'avg_sales'  => $avg_sales
				   					);

				   		$ba_id = $this->users->add_more_info($add_more_info);

				   		$returnmessage = array( 'message' => "<div class='success-cont' style='color: green'>"."<p>Registration Success, Check Your Email for Confirmation</p>"."</div>" , 'status' => 1);
			            echo json_encode($returnmessage);

			            $email_data['user'] =  $uname;
						$email_data['pasword'] = $pass;
						$email_data['activate'] = $activation_code;
						$email_data['email_type'] = "User Activate Account";
						$email_content = $this->load->view('email/user-email',$email_data, true);

						$subject = "Oceantailer: Account Verification ";
						$from = "noreply-oceantailer@oceantailer.com";
						$sender = "OceanTailer";
						$to = $email;
						$this->send_message($email_content, $subject, $to, $from, $sender);


						/////////////add ticket system ////////////////////////
/*
						$salt = $this->rndm_strng('alnum',64);

						$hash_password = $this->hash_password($pass,$salt);

						$add_user_ticket = array(
								   'name'  => $firstname.' '.$lasttname,
								   'username'  => $uname,
								   'password'  => $hash_password,
								   'salt'  => $salt,
								   'email' =>$company,
								   'authentication_id' =>1,
								   'group_id'  => 0,
								   'user_level'  => 1,
								   'allow_login'  => 1,
								   'site_id'  => 1,
								   'email_notifications'  => 1,
								   'phone_number'  => $phone_num.' '.$phone_ext,
								   'address'  => $add1
				   		);

				   		$result = $this->users->add_to_ticket($add_user_ticket);
				   		/////////////add ticket system end ////////////////////////

 */                                              }

				}
			}
			else
			{
				// Redirect to Buyer Register Page
				redirect('buyer/register', 'refresh');
			}
		}
	}

	public function hash_password($password, $user_salt) {
		$salt_global = $this->users->salt_value();
		return hash_hmac('sha512', $password . $user_salt, $salt_global);
	}


	function register()
	{

		$data['creditcards'] = $this->creditcards->listing();
		$data['countries'] = $this->countries->listing_country();
		$data['countr_sel'] = $this->countries->default_country();
		$data['states'] = $this->countries->states($data['countr_sel']);
		$this->load->view('register-buyer-page', $data);
	}

	function isEmailExist($mail)
    {
        $this->form_validation->set_message('isEmailExist','The Email %S already exists, please enter different one.');
        if($this->users->check_email_exist($mail))
            return false;
        else
            return true;
    }

    function isUserNameExist($username)
	{
		 $this->form_validation->set_message('isUserNameExist','The Username %S is already exist');
        if($this->users->check_username_exist($username))
            return false;
        else
            return true;
	}

	function rndm_strng($type,$size)
	{
		$this->load->helper('string');
		return random_string($type, $size);
	}

	function buyerApprovedEmail($user_info)
	{
		$email_data['buyer_info'] = $user_info;
		$email_data['email_type'] = "Buyer Activate Email";
		$buyerApproveEmail = $this->load->view('email/email-admin-activate', $email_data, true);
		return $buyerApproveEmail;
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
        $this->email->bcc_batch_mode = true;
		$this->email->bcc("accounts@oceantailer.com");
		$this->email->subject($subject);
		$this->email->message($message);

		$this->email->send();
		//echo $this->email->print_debugger();
	}

	function activate()
	{
		$id_activate = $this->uri->segment(3);
		if($this->users->validate_regisCode($id_activate))
		{
			 redirect('buyer','refresh');
		}
		else
		{
			echo 'Invalid registration Code, or the Code is Already used';
		}
	}

	// Lanz Editted - May 31, 2013
	function profile()
	{
		$data['feat_categories'] = $this->categories->listings(0); //main categories
		if ($this->session->userdata('is_login') == TRUE)
		{
			$viewed_by = $this->uri->segment(3);
			if ($viewed_by == "admin")
			{
				$buyer_id = $this->uri->segment(4);
				//echo $buyer_id;
				$data['buyer_profile'] = $this->buyers->buyerinfo($buyer_id);
				$this->load->view('admin/buyer/buyer-profile', $data);
			}
			else if ($viewed_by == "buyer")
			{
				$buyer_viewtype = $this->uri->segment(4);
				$buyer_id = $this->session->userdata('id');

				if ($buyer_viewtype == "view")
				{
					$data['buyer_profile'] = $this->buyers->buyerinfo($buyer_id);
					$this->load->view('buyer/buyer-view-profile', $data);
				}
				else if ($buyer_viewtype == "update")
				{
					$data['countr_sel'] = $this->countries->default_country();
					$data['states'] = $this->countries->states($data['countr_sel']);
					$data['creditcards'] = $this->creditcards->listing();
					$data['countries'] = $this->countries->listing_country();
					$data['buyer_profile'] = $this->buyers->buyerinfo($buyer_id);
					$this->load->view('buyer/buyer-edit-profile', $data);
				}
			}
		}
	}

	// Lanz Editted - May 31, 2013
	function updatebuyerprofile()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$buyer_id = $this->session->userdata('id');
			if($this->input->post('action') != "")
			{
				$action = $this->input->post('action');
				if($action == 'update') //if registering user
				{
					// Basic Information
					$firstname = $this->input->post('firstname');
					$lastname = $this->input->post('lastname');
					$email = $this->input->post('email');
					$additional_email = $this->input->post('additional_email');
					$comp = $this->input->post('comp');
					$permit = $this->input->post('permit');

					$id = $this->input->post('id');


					// Load Form Validation Library
					$this->load->library('form_validation');

					// Basic Information Validation
					$this->form_validation->set_rules('firstname','First Name','trim|required|xss_clean');
					$this->form_validation->set_rules('lastname','Last Name','trim|required|xss_clean');

					$buyer_info = $this->buyers->buyerinfo($buyer_id);
					if($buyer_info->u_email != $email) //old and new password is not equal
						$this->form_validation->set_rules('email','Email','trim|required|min_length[5]|valid_email|xss_clean|callback_isEmailExist'); // Lanz Editted - June 4, 2013 - callback_isEmaialExist

					if($buyer_info->u_additional_email != $additional_email && $buyer_info->u_email != $additional_email)
						$this->form_validation->set_rules('additional_email','Invoice Notifications Email','trim|min_length[5]|valid_email|xss_clean|callback_isEmailExist');


					$this->form_validation->set_rules('comp','Company','trim|required|xss_clean');
					$this->form_validation->set_rules('permit','Permit','trim|required|xss_clean');


					// Run validation
					if($this->form_validation->run() == FALSE)
					{
						$returnmessage = array( 'message' => validation_errors() , 'status' => 0);
			             echo json_encode($returnmessage);
					}
					else
					{
						// New Buyer Basic Information
						$updated_info = array(
										'u_fname'  => $firstname,
										'u_lname'  => $lastname,
										'u_email'  => $email,
										'u_additional_email'  => $additional_email,
										'u_company'  => $comp,
										'u_permit'  => $permit
							   		);

						// Update Basic Info
						$this->buyers->updatebasicinfo($updated_info, $id);


				   		$returnmessage = array( 'message' => "Information Successfully updated!", 'status' => 1);
			            echo json_encode($returnmessage);
					}
				}
			}
			else
			{
				redirect('buyer', 'refresh');
			}
		}
	}

	// Lanz Editted - May 31, 2013
	function redirectbuyer()
	{
		$this->load->view('buyer');
	}

	function billingValidate()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			if($user_type == 3) //when action occurs
			{
				$country = $this->input->post('country');
				$add1 = $this->input->post('add1');
				$add2 = $this->input->post('add2');
				$city = $this->input->post('city');
				$prov = $this->input->post('prov');
				$postal = $this->input->post('postal');
				$phone_num = $this->input->post('phone_num');
				$phone_ext = $this->input->post('phone_ext');

				$this->load->library('form_validation');

				$this->form_validation->set_rules('country','Country','trim|required|xss_clean');
				$this->form_validation->set_rules('add1','Address 1','trim|required|xss_clean');
				$this->form_validation->set_rules('add2','Address 2','trim|xss_clean');
				$this->form_validation->set_rules('city','City','trim|required|xss_clean');
				$this->form_validation->set_rules('prov','State/Province','trim|required|xss_clean');
				$this->form_validation->set_rules('postal','Postal','trim|required|xss_clean');
				$this->form_validation->set_rules('phone_num','Phone Number','trim|required|numeric|xss_clean');
				$this->form_validation->set_rules('phone_ext','Phone Extension','trim|numeric|xss_clean');

				if($this->form_validation->run() == FALSE)
		        {
					 $returnmessage = array( 'message' => validation_errors() , 'status' => 0);
		             echo json_encode($returnmessage);
		        }
		        else
		        {
		        	$returnmessage = array( 'message' => 'Billing Information Valid', 'status' => 1);
					echo json_encode($returnmessage);
		        }
    		}
		}
	}

	// Lanz Editted - June 7, 2013
	function billing()
	{
		$data['feat_categories'] = $this->categories->listings(0); //main categories
        //echo '<pre>$_GET::'.print_r($_GET,true).'</pre>';
        //echo '<pre>$_POST::'.print_r($_POST,true).'</pre>';
        $sort_by = $this->input->get('sort_by');
        //echo '<pre>$sort_by::'.print_r($sort_by,true).'</pre>';

		if ($this->session->userdata('is_login') == TRUE)
		{
			if($this->input->post('action') != "") //when action occurs
			{
				$action = $this->input->post('action');
				$user_id = $this->session->userdata('id'); //id of the loged in user
				if($action == 'add') //add billing
				{
					$country = $this->input->post('country');
					$add1 = $this->input->post('add1');
					$add2 = $this->input->post('add2');
					$city = $this->input->post('city');
					$prov = $this->input->post('prov');
					$postal = $this->input->post('postal');
					$phone_num = $this->input->post('phone_num');
					$phone_ext = $this->input->post('phone_ext');

					$this->load->library('form_validation');

					$this->form_validation->set_rules('country','Country','trim|required|xss_clean');
					$this->form_validation->set_rules('add1','Address 1','trim|required|xss_clean');
					$this->form_validation->set_rules('add2','Address 2','trim|xss_clean');
					$this->form_validation->set_rules('city','City','trim|required|xss_clean');
					$this->form_validation->set_rules('prov','Province','trim|required|xss_clean');
					$this->form_validation->set_rules('postal','Postal','trim|required|xss_clean');
					$this->form_validation->set_rules('phone_num','Phone Number','trim|required|numeric|xss_clean');
					$this->form_validation->set_rules('phone_ext','Phone Extension','trim|numeric|xss_clean');

					if($this->form_validation->run() == FALSE)
			        {
						 $returnmessage = array( 'message' => validation_errors() , 'status' => 0);
			             echo json_encode($returnmessage);
			        }
			        else
			        {
			        	$add_billing = array(
				   					'u_id'  => $user_id,
				   					'c_id'  => $country,
				   					'ba_add1'  => $add1,
				   					'ba_add2'  => $add2,
				   					'ba_city'  => $city,
				   					'ba_province'  => $prov,
				   					'ba_postal'  => $postal,
				   					'ba_phone_num'  => $phone_num,
				   					'ba_phone_ext'  => $phone_ext,
				   					'ba_isset' => 0
				   					);

			        	$ba_id = $this->users->business_address_add($add_billing);

			        	$returnmessage = array( 'message' => "New Billing Address Address." , 'status' => 1,'id' =>$ba_id);
			            echo json_encode($returnmessage);
			        }
				}
				elseif($action == 'update') //update billing
				{
					$id = $this->input->post('id');
					$country = $this->input->post('country');
					$add1 = $this->input->post('add1');
					$add2 = $this->input->post('add2');
					$city = $this->input->post('city');
					$prov = $this->input->post('prov');
					$postal = $this->input->post('postal');
					$phone_num = $this->input->post('phone_num');
					$phone_ext = $this->input->post('phone_ext');

					$this->load->library('form_validation');

					$this->form_validation->set_rules('country','Country','trim|required|xss_clean');
					$this->form_validation->set_rules('add1','Address 1','trim|required|xss_clean');
					$this->form_validation->set_rules('add2','Address 2','trim|xss_clean');
					$this->form_validation->set_rules('city','City','trim|required|xss_clean');
					$this->form_validation->set_rules('prov','Province','trim|required|xss_clean');
					$this->form_validation->set_rules('postal','Postal','trim|required|xss_clean');
					$this->form_validation->set_rules('phone_num','Phone Number','trim|required|numeric|xss_clean');
					$this->form_validation->set_rules('phone_ext','Phone Extension','trim|numeric|xss_clean');

					if($this->form_validation->run() == FALSE)
			        {
						 $returnmessage = array( 'message' => validation_errors() , 'status' => 0);
			             echo json_encode($returnmessage);
			        }
			        else
			        {
			        	$updated_billingaddress = array(
					   					'c_id'  => $country,
					   					'ba_add1'  => $add1,
					   					'ba_add2'  => $add2,
					   					'ba_city'  => $city,
					   					'ba_province'  => $prov,
					   					'ba_postal'  => $postal,
					   					'ba_phone_num'  => $phone_num,
					   					'ba_phone_ext'  => $phone_ext,
							   		);

						// Update Billing Address
						$this->buyers->updatebillingaddress_ba_id($updated_billingaddress, $id);
						$returnmessage = array( 'message' => "Billing Address Updated." , 'status' => 1);
			            echo json_encode($returnmessage);
			        }
				}
				elseif($action == 'validate') //just validation
				{
					$id = $this->input->post('id');
					$country = $this->input->post('country');
					$add1 = $this->input->post('add1');
					$add2 = $this->input->post('add2');
					$city = $this->input->post('city');
					$prov = $this->input->post('prov');
					$postal = $this->input->post('postal');
					$phone_num = $this->input->post('phone_num');
					$phone_ext = $this->input->post('phone_ext');

					$this->load->library('form_validation');

					$this->form_validation->set_rules('country','Country','trim|required|xss_clean');
					$this->form_validation->set_rules('add1','Address 1','trim|required|xss_clean');
					$this->form_validation->set_rules('add2','Address 2','trim|xss_clean');
					$this->form_validation->set_rules('city','City','trim|required|xss_clean');
					$this->form_validation->set_rules('prov','Province','trim|required|xss_clean');
					$this->form_validation->set_rules('postal','Postal','trim|required|xss_clean');
					$this->form_validation->set_rules('phone_num','Phone Number','trim|required|numeric|xss_clean');
					$this->form_validation->set_rules('phone_ext','Phone Extension','trim|numeric|xss_clean');

					if($this->form_validation->run() == FALSE)
			        {
						 $returnmessage = array( 'message' => validation_errors() , 'status' => 0);
			             echo json_encode($returnmessage);
			        }
			        else
			        {

						$returnmessage = array( 'message' => "Address is valid." , 'status' => 1);
			            echo json_encode($returnmessage);
			        }
				}
			}
			else //viewing purposes
			{
				$view_type = $this->uri->segment(3);
                // echo '<pre>$view_type::'.print_r($view_type,true).'</pre>';
				if($view_type != "")
				{
					if($view_type == 'add')
					{
						$data['countr_sel'] = $this->countries->default_country();
						$data['states'] = $this->countries->states($data['countr_sel']);
						$data['countries'] = $this->countries->listing_country();
						$this->load->view('buyer/buyer-add-billing-address',$data);
					}
					elseif($view_type == 'update')
					{
						$data['selected_ba'] = $this->uri->segment(4);
						$data['billing'] = $this->buyers->get_billing_info($data['selected_ba']);
						$data['countr_sel'] = $this->countries->default_country();
						$data['states'] = $this->countries->states($data['countr_sel']);
						$data['countries'] = $this->countries->listing_country();

						$this->load->view('buyer/buyer-update-billing-address',$data);
					}
					// Lanz Editted - June 7, 2013
					elseif ($view_type == 'delete') // delete billing
					{
						$ba_id = $this->uri->segment(4);
						$this->buyers->deleteaddress($ba_id);
						redirect('buyer/billing', 'refresh');
					}
					// Lanz Editted - June 7, 2013
					else if ($view_type == "setactive") // set current billing address
					{
						$ba_id = $this->uri->segment(4);
						$u_id = $this->uri->segment(5);

						$this->buyers->updatecurrentaddress($ba_id, $u_id);
						redirect('buyer/billing', 'refresh');
					}
				}
				else
				{
					$id = $this->session->userdata("id");
                    // billingaddresses($id, $default = false)
					$data['billing_address'] = $this->buyers->billingaddresses($id, false, $sort_by);
					$this->load->view('buyer/buyer-management-billing-address', $data);
				}
			}
		}
	}

	// Lanz Editted - June 5, 2013
	function creditcard()
	{
		$data['feat_categories'] = $this->categories->listings(0); //main categories
		$id = $this->session->userdata('id');
		$data['credit_cards'] = $this->buyers->creditcards($id);
		$this->load->view("buyer/buyer-management-creditcard-user", $data);
	}

	// Lanz Editted - June 5, 2013
	function addcreditcard()
	{
		$data['feat_categories'] = $this->categories->listings(0); //main categories
		$data['creditcards'] = $this->creditcards->listing();
		$this->load->view("buyer/buyer-add-creditcard", $data);
	}

	function validateCc()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			if($user_type == 3) //when action occurs
			{
				$this->load->library('form_validation');

				$this->form_validation->set_rules('cctype','Card Type','trim|required|xss_clean');
				$this->form_validation->set_rules('ccuname','Card Holder','trim|required|xss_clean');
//				$this->form_validation->set_rules('ccunum','Card Number','trim|required|exact_length[16]|xss_clean');
				$this->form_validation->set_rules('ccunum','Card Number','trim|required|xss_clean|callback_cc_number_validation');
//				$this->form_validation->set_rules('ccuccv','Card CCV','trim|exact_length[4]|required|xss_clean');
				$this->form_validation->set_rules('ccuccv','Card CCV','trim|required|xss_clean|callback_cc_ccv_validation');
				$this->form_validation->set_rules('exp_month','Card Expiration Month','trim|required|xss_clean');
				$this->form_validation->set_rules('exp_year','Card Expiration Year','trim|required|numeric|xss_clean');

				if($this->form_validation->run() == FALSE)
		        {
					 $returnmessage = array( 'message' => validation_errors() , 'status' => 0);
		             echo json_encode($returnmessage);
		        }
		        else
		        {
		        	$returnmessage = array( 'message' => "Credit Card Valid" , 'status' => 1);
		        	 echo json_encode($returnmessage);
		        }

			}
		}
	}

	function cc_number_validation($ccunum){
		$cctype = $this->input->post('cctype');
		$ccnum_length = $cctype == 3 ? 15 : 16;
		if (strlen($ccunum.'') == $ccnum_length)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('cc_number_validation', 'The Card Number field must be exactly '.$ccnum_length.' characters in length.');
			return FALSE;
		}
	}


	function cc_ccv_validation($ccv){
		if (strlen($ccv.'') == 3 || strlen($ccv.'') == 4)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('cc_ccv_validation', 'The CCV field must be 3-4 characters in length.');
			return FALSE;
		}
	}

	// Lanz Editted - June 5, 2013
	function addnewcreditcard()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			if($this->input->post('action') != "") //when action occurs
			{
				$action = $this->input->post('action');
				$user_id = $this->session->userdata('id'); //id of the loged in user
				if($action == 'add') //add new credit card
				{
					$cctype = $this->input->post('cctype');
					$ccuname = $this->input->post('ccuname');
					$ccunum = $this->input->post('ccunum');
					$ccuccv = $this->input->post('ccuccv');
					$exp_month = $this->input->post('exp_month');
					$exp_year = $this->input->post('exp_year');

					$this->load->library('form_validation');

					$this->form_validation->set_rules('cctype','Card Type','trim|required|xss_clean');
					$this->form_validation->set_rules('ccuname','Card Holder','trim|required|xss_clean');
					$this->form_validation->set_rules('ccunum','Card Number','trim|required|callback_cc_number_validation|xss_clean');
					$this->form_validation->set_rules('ccuccv','Card CCV','trim|required|callback_cc_ccv_validation|xss_clean');
//					$this->form_validation->set_rules('ccunum','Card Number','trim|required|exact_length[16]|xss_clean');
//					$this->form_validation->set_rules('ccuccv','Card CCV','trim|required||exact_length[3]xss_clean');
					$this->form_validation->set_rules('exp_month','Card Expiration Month','trim|required|xss_clean');
					$this->form_validation->set_rules('exp_year','Card Expiration Year','trim|required|numeric|xss_clean');

					if($this->form_validation->run() == FALSE)
			        {
						 $returnmessage = array( 'message' => validation_errors() , 'status' => 0);
			             echo json_encode($returnmessage);
			        }
			        else
			        {
			        	$add_creditcard = array(
				   					'u_id'  => $user_id,
				   					'cc_id' => $cctype,
				   					'ccu_name' => $ccuname,
				   					'ccu_number' => $ccunum,
				   					'ccu_ccv' => $ccuccv,
				   					'ccu_exp_month' => $exp_month,
				   					'ccu_exp_year' => $exp_year,
				   					'ccu_isset' => 0
				   					);

			        	$card_id = $this->users->buyer_add_creditcard($add_creditcard);

			        	$returnmessage = array( 'message' => "New Credit Card Added." , 'status' => 1, 'ccid' =>$card_id);
			            echo json_encode($returnmessage);
			        }
				}
			}
		}
	}

	// Lanz Editted - June 5, 2013
	function cardaction()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{

			$action = $this->uri->segment(3);
			$ccu_id = $this->uri->segment(4);
			$u_id = $this->uri->segment(5);

			if ($action == "update")
			{
				$data['creditcards'] = $this->creditcards->listing();
				$data['credit_info'] = $this->creditcards->creditcardinfo($ccu_id);
				$this->load->view("buyer/buyer-edit-creditcard", $data);
			}
			else if ($action == "delete")
			{
				$this->buyers->deletecard($ccu_id);
				redirect('buyer/creditcard', 'refresh');
			}
			else if ($action == "setactive")
			{
				$this->buyers->updatecurrentcard($ccu_id, $u_id);
				redirect('buyer/creditcard', 'refresh');
			}
		}
	}

	// Lanz Editted - June 6, 2013
	function updatecard()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			if($this->input->post('action') != "") //when action occurs
			{
				$action = $this->input->post('action');
				$user_id = $this->session->userdata('id'); //id of the loged in user
				if($action == 'update') // update credit card
				{
					$cctype = $this->input->post('cctype');
					$ccuname = $this->input->post('ccuname');
					$ccunum = $this->input->post('ccunum');
					$ccuccv = $this->input->post('ccuccv');
					$exp_month = $this->input->post('exp_month');
					$exp_year = $this->input->post('exp_year');
					$ccuid = $this->input->post('ccuid');

					$this->load->library('form_validation');

					$this->form_validation->set_rules('cctype','Card Type','trim|required|xss_clean');
					$this->form_validation->set_rules('ccuname','Card Holder','trim|required|xss_clean');
					$this->form_validation->set_rules('ccunum','Card Number','trim|required|callback_cc_number_validation|xss_clean');
					$this->form_validation->set_rules('ccuccv','Card CCV','trim|required|callback_cc_ccv_validation|xss_clean');
//					$this->form_validation->set_rules('ccuccv','Card CCV','trim|required||exact_length[4]xss_clean');
					$this->form_validation->set_rules('exp_month','Card Expiration Month','trim|required|xss_clean');
					$this->form_validation->set_rules('exp_year','Card Expiration Year','trim|required|numeric|xss_clean');

					if($this->form_validation->run() == FALSE)
			        {
						 $returnmessage = array( 'message' => validation_errors() , 'status' => 0);
			             echo json_encode($returnmessage);
			        }
			        else
			        {
			        	$update_creditcard = array(
				   					'u_id'  => $user_id,
				   					'cc_id' => $cctype,
				   					'ccu_name' => $ccuname,
				   					'ccu_number' => $ccunum,
				   					'ccu_ccv' => $ccuccv,
				   					'ccu_exp_month' => $exp_month,
				   					'ccu_exp_year' => $exp_year
				   					//'ccu_isset' => 0
				   					);

			        	$card_id = $this->users->buyer_update_creditcard($update_creditcard, $ccuid);

			        	$returnmessage = array( 'message' => "Credit Card Updated." , 'status' => 1);
			            echo json_encode($returnmessage);
			        }
				}
			}
		}
	}

	// Lanz Editted - June 7, 2013
	function address()
	{
		$id = $this->session->userdata("id");
		$data['billing_address'] = $this->buyers->billingaddresses($id);
		$this->load->view('buyer/buyer-management-billing-address', $data);
	}

	// Lanz Editted - June 18, 2013
/*	function transactionslist()
	{
		$id = $this->session->userdata('id');
		$data['transactions'] = $this->buyers->transactions($id);
		$this->load->view('buyer/buyer-transactions', $data);
	}
*/
	// James Editted - June 28, 2013
	function transaction()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			if($user_type == 2) //supplier
			{
				$id = $this->session->userdata('id');
				$data['transactions'] = $this->buyers->transactions($id);
				$this->load->view('buyer/buyer-transactions', $data);
			}
		}
	}


	function order()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			$user_id = $this->session->userdata('id'); //id of the loged in user
			if($user_type == 3) // 3 buyer
			{
				$bsd_id = $this->uri->segment(3);
				//$bt_supplier = $this->uri->segment(4);


				$data['bt'] =  $this->buyers->shipping_list_grouped($user_id,$bsd_id);
				$data['supplier_info'] = $this->suppliers->supplierinfo($data['bt']->u_supplier);
				$data['btd'] =  $this->buyers->transaction_detail($user_id,$data['bt']->bt_id,$data['bt']->u_supplier);
				$data['cancels'] = $this->buyers->cancelOrderList(3);

				$data['email_notification'] =  $this->users->new_email_count($bsd_id, 3);
				//echo print_r($data['btd']);
				if($data['btd'] == false)
					//redirect('','refresh');
				{
					echo $data['bt']->bt_id.' '.$data['bt']->u_supplier;
				}
				else
				{
					$this->load->view('buyer/buyer-order-detail',$data);
				}
			}
		}  else $this->load->view('login');

	}

	function updateOrder()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			$user_id = $this->session->userdata('id'); //id of the loged in user
			if($user_type == 3) // 3 buyer
			{
				$action = $this->input->post('action');

				if($action = 'updateStatus')
				{
					$ssiid = $this->input->post('ssiid');
					$status = $this->input->post('status');
					$update_status = array('ssi_status' => $status);

					$result = $this->buyers->update_ssi($update_status,'ssi_id',$ssiid);

				}
				else
					echo false;
			}
		}
	}

	function orderUpdate()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			$user_id = $this->session->userdata('id'); //id of the loged in user
			if($user_type == 2 || $user_type == 3) // 2 supplier , 3 buyer
			{
				$action = $this->input->post('action');
				$reason = $this->input->post('reason');
				$bsd_id = $this->input->post('bsd_id');

				if($action == 'cancel') {
					$status = - 1;
					$bt =  $this->buyers->shipping_list_grouped($user_id,$bsd_id);
					if($bt->bsd_status == 10)
						return false;
				}elseif($action == 'pending')
					$status = 0;
				elseif($action == 'return')
					$status = -4;
				elseif($action == 'in_progress')
					$status = 10;

				$array = array('bsd_reason' => $reason, 'bsd_status' => $status);
				$result = $this->suppliers->update_buyer_supplier_detail($array,'bsd_id', $bsd_id);
			}
		}
	}

	function orderCancel()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			$user_id = $this->session->userdata('id'); //id of the loged in user
			if($user_type == 3) //3 buyer
			{
				$reason = $this->input->post('reason');
				$bsd_id = $this->input->post('bsd_id');

				$array = array('bsd_reason' => $reason, 'bsd_status' => '-1');

				$result = $this->buyers->update_buyer_supplier_detail($array,'bsd_id', $bsd_id);
			}
		}
	}

	function confirmShippingFee()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			$user_id = $this->session->userdata('id'); //id of the loged in user
			if($user_type == 3) //3 buyer
			{
				$ssiid = $this->input->post('ssi');

				$data_update = array('ssi_status' => true);
				$this->buyers->update_ssi($data_update,'ssi_id',$ssiid);

			}
		}

	}

	function add_feedback()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			if($user_type == 3)//3 buyer
			{
				$feedback = $this->input->post('feedback');
				$rate = $this->input->post('rate');
				$bsd = $this->input->post('bsd');

				$data = array('bsd_buyer_rate' => $rate,
								   'bsd_buyer_feedback' => $feedback,
								   'bsd_feedback_date' =>  date("Y-m-d h:i:s",time()));

				$this->buyers->update_buyer_supplier_detail($data,'bsd_id', $bsd);
				echo 'success';

			}
		}
	}

	function inbox()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{

			$user_type = $this->session->userdata('type'); //get user type;
			$buyer_id = $this->session->userdata('id'); //id of the loged in user
			if($user_type == 3) // 3 buyer
			{
				if ($this->input->post('action') == "")
				{
					$bsm_id = $this->uri->segment(3);

					if($bsm_id == "")
					{
						$data['buyer'] = $this->buyers->buyerinfo($buyer_id);
						$data['messages'] = $this->users->get_all_personal_message($buyer_id, 'buyer');
						$this->load->view('buyer/buyer-inbox',$data);
					}
					else
					{
						$data['buyer'] =  $this->buyers->buyerinfo($buyer_id);
						$data['message'] = $this->users->get_personal_message_detail($bsm_id, 'buyer');
						$this->load->view('buyer/buyer-inbox-detail',$data);
					}

				}
			}
		}
	}

	function order_cancel()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			$user_id = $this->session->userdata('id'); //id of the loged in user
			if($user_type == 3) // 2 buyer
			{
				$bsd_id = $this->uri->segment(3);

				$data['bt'] =  $this->buyers->shipping_list_grouped($user_id,$bsd_id);
				$data['supplier_info'] = $this->suppliers->supplierinfo($data['bt']->u_supplier);
				$data['btd'] =  $this->buyers->transaction_detail($user_id,$data['bt']->bt_id,$data['bt']->u_supplier);
				$data['cancels'] = $this->buyers->cancelOrderList(3);



				if($data['btd'] == false)
					redirect('','refresh');
				else
				{
					$this->load->view('buyer/buyer-order-detail-cancel',$data);
				}
			}
		}
	}

	function order_return()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type'); //get user type;
			$user_id = $this->session->userdata('id'); //id of the loged in user
			if($user_type == 3) // 2 buyer
			{
				$bsd_id = $this->uri->segment(3);

				$data['bt'] =  $this->buyers->shipping_list_grouped($user_id,$bsd_id);
				$data['supplier_info'] = $this->suppliers->supplierinfo($data['bt']->u_supplier);
				$data['btd'] =  $this->buyers->transaction_detail($user_id,$data['bt']->bt_id,$data['bt']->u_supplier);
				$data['returns'] = $this->buyers->orderReturnList();



				if($data['btd'] == false)
					redirect('','refresh');
				else
				{
					$this->load->view('buyer/buyer-order-return',$data);
				}
			}
		}
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

?>