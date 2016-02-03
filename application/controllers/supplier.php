<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class supplier extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('users');
        $this->load->model('manufacturers');
        $this->load->model('inventories');
        $this->load->model('creditcards');
        $this->load->model('countries');
        $this->load->model('categories');
        $this->load->model('brands');
        $this->load->model('suppliers'); // Lanz Editted
        $this->load->model('buyers'); // Lanz Editted
        $this->load->model('administrators');
        $this->load->model('banks');
        $this->load->model('import');
        $this->load->helper('form');
        $this->load->library('pagination');
        //End Load Neccessary Models
        $this->config->load('authorized');
        define("AUTHORIZENET_API_LOGIN_ID", $this->config->item('AUTHORIZENET_API_LOGIN_ID'));
        define("AUTHORIZENET_TRANSACTION_KEY", $this->config->item('AUTHORIZENET_TRANSACTION_KEY'));
        define("AUTHORIZENET_MD5_SETTING", $this->config->item('AUTHORIZENET_MD5_SETTING'));
        define("AUTHORIZENET_SANDBOX", $this->config->item('AUTHORIZENET_SANDBOX'));
        define("AUTHORIZENET_LOG_FILE", $this->config->item('AUTHORIZENET_LOG_FILE'));

        /* require_once(base_url().'application/config/authorized.php'); */
        $this->load->library('authorizenet');
    }

    public function index() {
        if ($this->session->userdata('is_login') == TRUE) {
            $data['feat_categories'] = $this->categories->listings(0); //main categories
            $user_type = $this->session->userdata('type'); //get user type;
            if ($user_type == 2) {
                $id_user = $this->session->userdata('id');
                $data['supplier'] = $this->suppliers->supplierinfo($id_user);
                $data['general_feedback'] = $this->suppliers->general_feedback($id_user);
                $data['feedback_detail'] = $this->suppliers->feedback_detail($id_user);
                $data['random_products'] = $this->suppliers->get_random_products($id_user);
                $this->load->view('supplier/supplier-home', $data);
            } else if ($user_type == 1) {
                $page = $this->input->get('page') ? $this->input->get('page') : 1;
                $order = $this->input->post('sort_by') ? $this->input->post('sort_by') : 'u_id';
                $dir = $this->input->post('sort_direction') ? $this->input->post('sort_direction') : 'desc';
                $user_type_num = 0;

                $data['user_type'] = 'supplier';
                $data['list_type'] = 'pending';
                $data['page'] = $page;
                $data['order_by'] = $order;
                $data['dir'] = $dir;
                $data['totals'] = count($this->suppliers->listing($user_type_num));

                $data['items'] = $this->suppliers->listing($user_type_num, $page, 10, $order, $dir);
                $data['columns'] = array(
                    'u_lname' => array('title' => 'Supplier Name', 'sortable' => true),
                    'u_email' => array('title' => 'Email', 'sortable' => true),
                    'u_username' => array('title' => 'Username', 'sortable' => true),
                    'actions' => array(
                        'title' => 'Action',
                        'sortable' => false,
                        'items' => array(
                            'view_profile' => array('link' => '/supplier/viewSupplierProfile/admin/', 'text' => 'View Profile', 'confirm' => false, 'pk' => 'u_id'),
                            'approve' => array('link' => '/supplier/update/approved/', 'text' => '<i class="ot_approve_icon"></i>', 'confirm' => false, 'pk' => 'u_id', 'options' => array('class' => 'approve')),
                            'suspend' => array('link' => '/supplier/update/suspended/', 'text' => '<i class="ot_suspend_icon"></i>', 'confirm' => false, 'pk' => 'u_id', 'options' => array('class' => 'suspend')),
                            'deny' => array('link' => '/supplier/update/denied/', 'text' => '<i class="ot_deny_icon"></i>', 'confirm' => false, 'pk' => 'u_id', 'options' => array('class' => 'deny'))
                        )
                    ),
                );

                $data['sorter']['by'] = $order;
                $data['sorter']['dir'] = $dir;

                $config['base_url'] = '/supplier/?';
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

                $filters = $this->load->view('tools/filters', array(), true);
                $table = $this->load->view('tools/table', $data, true);
                $paging = $this->load->view('tools/pagination', $pages, true);
                //$this->load->view('admin/buyer/buyer-page', $data);
                $this->load->view('admin/users-list', array_merge($data, array('filters' => $filters, 'table' => $table, 'paging' => $paging)));
            }
        } else {
            redirect('', 'refresh');
        }
    }

    function detail() {
        $data['feat_categories'] = $this->categories->listings(0); //main categories
        $data['categories'] = array(); //main categories
        $data['brands'] = array();
        $data['manus'] = array();
        $data['suppliers'] = $this->suppliers->listing(1);

        $id_user = $this->uri->segment(3);
        $data['supplier'] = $this->suppliers->supplierinfo($id_user);
        $data['general_feedback'] = $this->suppliers->general_feedback($id_user);
        $data['feedback_detail'] = $this->suppliers->feedback_detail($id_user);
        $data['random_products'] = $this->suppliers->get_random_products($id_user);

        if (!$data['supplier'])
            redirect('', 'refresh');
        else
            $this->load->view('supplier/supplier-home', $data);
    }

    /* Lanz - Editted */

    function view() {
        if ($this->session->userdata('is_login') == TRUE) {
            $data['feat_categories'] = $this->categories->listings(0); //main categories
            $user_type = $this->session->userdata('type'); //get user type
            if ($user_type == 1) { // admin
                $view_type = $this->uri->segment(3);
                $page = $this->input->get('page') ? $this->input->get('page') : 1;
                $order = $this->input->post('sort_by') ? $this->input->post('sort_by') : 'u_id';
                $dir = $this->input->post('sort_direction') ? $this->input->post('sort_direction') : 'desc';
                $user_type_num = 0;
                switch ($view_type) {
                    case 'pending': $user_type_num = 0;
                        break;
                    case 'approved': $user_type_num = 1;
                        break;
                    case 'denied': $user_type_num = 2;
                        break;
                    case 'suspended': $user_type_num = 3;
                        break;
                }
                $data['user_type'] = 'supplier';
                $data['list_type'] = $view_type;
                $data['page'] = $page;
                $data['order_by'] = $order;
                $data['dir'] = $dir;
                $data['totals'] = count($this->suppliers->listing($user_type_num));

                $data['items'] = $this->suppliers->listing($user_type_num, $page, 10, $order, $dir);
                $data['columns'] = array(
                    'u_lname' => array('title' => 'Supplier Name', 'sortable' => true),
                    'u_email' => array('title' => 'Email', 'sortable' => true),
                    'u_username' => array('title' => 'Username', 'sortable' => true),
                    'actions' => array(
                        'title' => 'Action',
                        'sortable' => false,
                        'items' => array(
                            'view_profile' => array('link' => '/supplier/viewSupplierProfile/admin/', 'text' => 'View Profile', 'confirm' => false, 'pk' => 'u_id'),
                        )
                    ),
                );
                if ($user_type_num == 0) {
                    $data['columns']['actions']['items']['approve'] = array('link' => '/supplier/update/approved/', 'text' => '<i class="ot_approve_icon"></i>', 'confirm' => false, 'pk' => 'u_id', 'options' => array('class' => 'approve'));
                    $data['columns']['actions']['items']['suspend'] = array('link' => '/supplier/update/suspended/', 'text' => '<i class="ot_suspend_icon"></i>', 'confirm' => false, 'pk' => 'u_id', 'options' => array('class' => 'suspend'));
                    $data['columns']['actions']['items']['deny'] = array('link' => '/supplier/update/denied/', 'text' => '<i class="ot_deny_icon"></i>', 'confirm' => false, 'pk' => 'u_id', 'options' => array('class' => 'deny'));
                } elseif ($user_type_num == 1) {
                    $data['columns']['actions']['items']['login'] = array('link' => '/administrator/loginAs/admin/', 'text' => 'Log In', 'confirm' => false, 'pk' => 'u_id');
                    $data['columns']['actions']['items']['suspend'] = array('link' => '/supplier/update/suspended/', 'text' => '<i class="ot_suspend_icon"></i>', 'confirm' => false, 'pk' => 'u_id', 'options' => array('class' => 'suspend'));
                    $data['columns']['actions']['items']['deny'] = array('link' => '/supplier/update/denied/', 'text' => '<i class="ot_deny_icon"></i>', 'confirm' => false, 'pk' => 'u_id', 'options' => array('class' => 'deny'));
                } elseif ($user_type_num == 2) {
                    $data['columns']['actions']['items']['approve'] = array('link' => '/supplier/update/approved/', 'text' => '<i class="ot_approve_icon"></i>', 'confirm' => false, 'pk' => 'u_id', 'options' => array('class' => 'approve'));
                    $data['columns']['actions']['items']['suspend'] = array('link' => '/supplier/update/suspended/', 'text' => '<i class="ot_suspend_icon"></i>', 'confirm' => false, 'pk' => 'u_id', 'options' => array('class' => 'suspend'));
                } elseif ($user_type_num == 3) {
                    $data['columns']['actions']['items']['approve'] = array('link' => '/supplier/update/approved/', 'text' => '<i class="ot_approve_icon"></i>', 'confirm' => false, 'pk' => 'u_id', 'options' => array('class' => 'approve'));
                    $data['columns']['actions']['items']['deny'] = array('link' => '/supplier/update/denied/', 'text' => '<i class="ot_deny_icon"></i>', 'confirm' => false, 'pk' => 'u_id', 'options' => array('class' => 'deny'));
                }


                $data['sorter']['by'] = $order;
                $data['sorter']['dir'] = $dir;

                $config['base_url'] = '/supplier/view/' . $view_type . '?';
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

                $filters = $this->load->view('tools/filters', array(), true);
                $table = $this->load->view('tools/table', $data, true);
                $paging = $this->load->view('tools/pagination', $pages, true);
                //$this->load->view('admin/buyer/buyer-page', $data);
                $this->load->view('admin/users-list', array_merge($data, array('filters' => $filters, 'table' => $table, 'paging' => $paging)));
            }
        } else {
            redirect('', 'refresh');
        }
    }

    /* Lanz - Editted  */

    function update() {
        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type'); //get user type
            if ($user_type == 1) { // admin
                $supplier_id = $this->uri->segment(4);
                $action_type = $this->uri->segment(3);
                if ($action_type == "approved") {
                    $data = array('u_admin_approve' => 1);

                    // update supplier data
                    $this->suppliers->update($supplier_id, $data);

                    // get user info
                    $user_info = $this->users->info($supplier_id);

                    // assign email info to a variable
                    $email_content = $this->supplierApprovedEmail($user_info);

                    // send email from admin to supplier
                    $subject = "Oceantailer: Administration Account Verification";
                    $from = "noreply-oceantailer@oceantailer.com";
                    $sender = "OceanTailer";
                    $to = $user_info->u_email;
                    $this->send_message($email_content, $subject, $to, $from, $sender);

                    // redirect to approvbr
                    redirect('supplier/', 'refresh');
                } else if ($action_type == "denied") {
                    $data = array('u_admin_approve' => 2);
                    $this->suppliers->update($supplier_id, $data);
                    redirect('supplier/', 'refresh');
                } else if ($action_type == "suspended") {
                    $data = array('u_admin_approve' => 3);
                    $this->suppliers->update($supplier_id, $data);
                    redirect('supplier/', 'refresh');
                } else if ($action_type == "restriction") {
                    $restrict_content = $this->input->post('res');
                    $data = array('u_restriction' => $restrict_content);
                    $this->suppliers->update($supplier_id, $data);
                    echo $restrict_content . ' dsadsa ' . $supplier_id . ' ' . $restrict_content;
                }
            }
        } else {
            redirect('', 'refresh');
        }
    }

    function update_post() {
        if ($this->session->userdata('is_login') == TRUE) {
            $u_id = $this->session->userdata('id'); //get user type
            $user_type = $this->session->userdata('type'); //get user type
            if ($user_type == 2) { //supplier
                $action_type = $this->input->post('action');

                if ($action_type == "restriction") {
                    $restrict_content = $this->input->post('res');
                    $data = array('u_restriction' => $restrict_content);
                    $this->suppliers->update($u_id, $data);
                    echo $restrict_content . ' dsadsa ' . $u_id . ' ' . $restrict_content;
                } elseif ($action_type == "return") {
                    $return_data = $this->input->post('return_val');
                    $data = array('u_return' => $return_data);
                    $this->suppliers->update($u_id, $data);
                    echo $restrict_content . ' dsadsa ' . $u_id . ' ' . $restrict_content;
                }
            }
        } else {
            redirect('', 'refresh');
        }
    }

    function add() {
        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type'); //get user type;
            if ($user_type == 2) { // 2 supplier
                $action = $this->uri->segment(3);
                if ($action == 'product') {
                    $this->addProduct();
                }
            }
        } else {
            if ($this->input->post('action') != "") {
                $action = $this->input->post('action');
                if ($action == 'register') { //if registering user
                    $firstname = $this->input->post('firstname');
                    $lastname = $this->input->post('lastname');

                    $uname = $this->input->post('uname');
                    $email = $this->input->post('email');
                    $company = $this->input->post('company');
                    $permit = $this->input->post('permit');

                    $pass = $this->input->post('pass');
                    $conpass = $this->input->post('conpass');

                    $u_module = $this->input->post('u_module');

                    /*
                      $cctype = $this->input->post('cctype');
                      $ccuname = $this->input->post('ccuname');
                      $ccunum = $this->input->post('ccunum');
                      $ccuccv = $this->input->post('ccuccv');
                      $exp_month = $this->input->post('exp_month');
                      $exp_year = $this->input->post('exp_year');

                      $bnk_country = $this->input->post('bnk_country');
                      $bk_owner = $this->input->post('bk_owner');
                      $bk_name = $this->input->post('bk_name');
                      $bk_name_add = $this->input->post('bk_name_add');
                      $bk_acc = $this->input->post('bk_acc');
                      $bnk_code = $this->input->post('bnk_code');
                     */
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
                    $avg_sales = $this->input->post('avg_sales');

                    $this->load->library('form_validation');

                    $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('uname', 'Username', 'trim|required|min_length[5]|xss_clean|callback_isUserNameExist');
                    $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|valid_email|xss_clean|callback_isEmailExist');
                    $this->form_validation->set_rules('company', 'Company', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('permit', 'Permit', 'trim|required|xss_clean');

                    $this->form_validation->set_rules('pass', 'Password', 'trim|min_length[5]|max_length[40]|required|xss_clean');
                    $this->form_validation->set_rules('conpass', 'Confirm Password', 'trim|min_length[5]|max_length[40]|required|xss_clean|matches[pass]');

                    $this->form_validation->set_rules('u_module', 'Subscription Type', 'trim|required');

                    /* 	$this->form_validation->set_rules('cctype','Credit Card','trim|required|xss_clean');
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

                      $this->form_validation->set_rules('bnk_country','Bank Country','trim|required|xss_clean');
                      $this->form_validation->set_rules('bk_owner','Bank Account Name','trim|required|xss_clean');
                      $this->form_validation->set_rules('bk_name','Bank Name','trim|xss_clean');
                      $this->form_validation->set_rules('bk_name_add','Bank Address','trim|xss_clean');
                      $this->form_validation->set_rules('bnk_code','Routing Number','trim|exact_length[9]|numeric|xss_clean');
                     */
                    $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('add1', 'Address 1', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('add2', 'Address 2', 'trim|xss_clean');
                    $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('prov', 'Province', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('phone_num', 'Phone Number', 'trim|required|numeric|xss_clean');
                    $this->form_validation->set_rules('phone_ext', 'Phone Extension', 'trim|numeric|xss_clean');

                    // Additional Information Validation
                    $this->form_validation->set_rules('website', 'Website', 'trim|xss_clean');
                    $this->form_validation->set_rules('how_you_find', 'How You Find Us', 'trim|xss_clean');
                    $this->form_validation->set_rules('avg_sales', 'Average Sales', 'trim|xss_clean');


                    if ($this->form_validation->run() == FALSE) {
                        $returnmessage = array('message' => "<div class='error-cont' style='color:red'>" . str_replace("\n", "<br>", validation_errors()) . "</div>", 'status' => 0);
                        echo json_encode($returnmessage);
                    } else {
                        $activation_code = strtolower($this->rndm_strng('alnum', 25));

                        $add_user = array(
                            'u_username' => $uname,
                            'u_pass' => $this->users->encript($pass),
                            'u_fname' => $firstname,
                            'u_lname' => $lastname,
                            'u_company' => $company,
                            'u_permit' => $permit,
                            'u_email' => $email,
                            'u_type' => 2,
                            'u_status' => 1,
                            'u_admin_approve' => 0,
                            'u_verify_code' => $activation_code,
                            'u_pic' => "",
                            'u_time' => apputils::ConvertUnStampToMysqlDateTime(time()),
                            'u_module' => $u_module
                        );

                        $user_id = $this->users->add($add_user);

                        /* $add_ccu = array(
                          'u_id'  => $user_id,
                          'cc_id'  => $cctype,
                          'ccu_name'  => $ccuname,
                          'ccu_number'  => $ccunum,
                          'ccu_ccv'  => $ccuccv,
                          'ccu_exp_month'  => $exp_month,
                          'ccu_exp_year'  => $exp_year,
                          );

                          $ccu_id = $this->users->ccu_add($add_ccu);
                         */
                        $add_billing = array(
                            'u_id' => $user_id,
                            'c_id' => $country,
                            'ba_add1' => $add1,
                            'ba_add2' => $add2,
                            'ba_city' => $city,
                            'ba_province' => $prov,
                            'ba_postal' => $postal,
                            'ba_phone_num' => $phone_num,
                            'ba_phone_ext' => $phone_ext,
                        );

                        $ba_id = $this->users->business_address_add($add_billing);
                        /*
                          $add_bank_acc = array(
                          'u_id'  => $user_id,
                          'c_id'  => $bnk_country,
                          'bnk_owner'  => $bk_owner,
                          'bnk_name'  => $bk_name,
                          'bnk_address' => $bk_name_add,
                          'bnk_account'  => $bk_acc,
                          'bnk_id_code'  => $bnk_code,
                          );

                          $bnk_id = $this->users->bank_acc_add($add_bank_acc);
                         */

                        $add_more_info = array(
                            'u_id' => $user_id,
                            'website' => $website,
                            'how_you_find' => $how_you_find,
                            'important' => '',
                            'avg_sales' => $avg_sales
                        );

                        $ba_id = $this->users->add_more_info($add_more_info);


                        $returnmessage = array('message' => "<div class='success-cont' style='color:green'>" . "<p>Registration Success, Check Your Email for Confirmation</p>" . "</div>", 'status' => 1);
                        echo json_encode($returnmessage);

                        $email_data['user'] = $uname;
                        $email_data['pasword'] = $pass;
                        $email_data['activate'] = $activation_code;
                        $email_data['email_type'] = "User Activate Account";
                        $email_content = $this->load->view('email/user-email', $email_data, true);

                        $subject = "Oceantailer: Account Verification ";
                        $from = "noreply-oceantailer@oceantailer.com";
                        $sender = "OceanTailer";
                        $to = $email;
                        $this->send_message($email_content, $subject, $to, $from, $sender);

                        /////////////add ticket system ////////////////////////

                        $salt = $this->rndm_strng('alnum', 64);

                        $hash_password = $this->hash_password($pass, $salt);

                        /* $add_user_ticket = array(
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

                         */
                    }
                }
            } else {
                redirect('supplier/register', 'refresh');
            }
        }
    }

    public function hash_password($password, $user_salt) {
        $salt_global = $this->users->salt_value();
        return hash_hmac('sha512', $password . $user_salt, $salt_global);
    }

    function addProduct() {
        if ($this->session->userdata('is_login') == TRUE) {
            $data['feat_categories'] = $this->categories->listings(0); //main categories
            $user_type = $this->session->userdata('type'); //get user type;
            if ($user_type == 2) { // 2 supplier
                $this->load->view('supplier/supplier-add-product', $data);
            }
        } else
            redirect('', 'refresh');
    }

    function activate() {
        $id_activate = $this->uri->segment(3);
        if ($this->users->validate_regisCode($id_activate)) {
            $user_id = $this->session->userdata('id');
            if ($user_id) {
                @mkdir(base_dir() . 'suppliers_files' . DIRECTORY_SEPARATOR . $user_id, 0777);
            }
            redirect('supplier', 'refresh');
        } else {
            echo 'Invalid registration Code, or the Code is Already used';
        }
    }

    function logout() {
        $this->users->logout();
        redirect('', 'refresh');
    }

    function register() {
        $data['creditcards'] = $this->creditcards->listing();
        $data['countries'] = $this->countries->listing_country();
        $data['countr_sel'] = $this->countries->default_country();
        $data['states'] = $this->countries->states($data['countr_sel']);
        $this->load->view('register-supplier-page', $data);
    }

    function isEmailExist($mail) {
        $this->form_validation->set_message('isEmailExist', 'The Email %S is already exist');
        if ($this->users->check_email_exist($mail))
            return false;
        else
            return true;
    }

    function isUserNameExist($username) {
        $this->form_validation->set_message('isUserNameExist', 'The Username %S is already exist');
        if ($this->users->check_username_exist($username))
            return false;
        else
            return true;
    }

    function rndm_strng($type, $size) {
        $this->load->helper('string');
        return random_string($type, $size);
    }

    function send_message($message, $subject, $to, $from, $sender) {
        $this->load->library('email');

        $config = array();
        $config['useragent'] = "CodeIgniter";
        $config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
        $config['protocol'] = "smtp";
        //$config['smtp_host']           = "localhost";
        //$config['smtp_port']           = "25";
        $config['smtp_host'] = "ssl://smtp.googlemail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "daphne.b@oceantailer.com";
        $config['smtp_pass'] = "California";
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);

        $this->email->from($from, $sender);
        $this->email->to($to);
        $this->email->bcc("accounts@oceantailer.com");

        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->send();
        //echo $this->email->print_debugger();
    }

    /* Lanz - Test Email */

    function supplierApprovedEmail($user_info) {
        $email_data['supplier_info'] = $user_info;
        $email_data['email_type'] = "Supplier Approval Email";
        $suppApproveEmail = $this->load->view('email/email-admin-activate', $email_data, true);
        return $suppApproveEmail;
    }

    /* Lanz - View Supplier Profile */

    function viewSupplierProfile() {
        if ($this->session->userdata('is_login') == TRUE) {
            $viewed_by = $this->uri->segment(3);

            if ($viewed_by == "admin") {
                $supplier_id = $this->uri->segment(4);
                $data['supplier_profile'] = $this->suppliers->supplierinfo($supplier_id);
                $this->load->view('admin/supplier/supplier-view-profile', $data);
            }
        }
    }

    // Lanz Editted - June 7, 2013
    function profile() {
        if ($this->session->userdata('is_login') == TRUE) {
            $data['feat_categories'] = $this->categories->listings(0); //main categories
            $viewed_by = $this->uri->segment(3);

            if ($viewed_by == "admin") {
                $buyer_id = $this->uri->segment(4);
                $data['buyer_profile'] = $this->buyers->buyerinfo($buyer_id);
                $this->load->view('admin/buyer/buyer-profile', $data);
            } else if ($viewed_by == "supplier") {
                $supplier_viewtype = $this->uri->segment(4);
                $supplier_id = $this->session->userdata('id');

                if ($supplier_viewtype == "view") {
                    $data['bt_list'] = $this->suppliers->shipping_list_grouped($supplier_id, '', '', '', '', 1); // 1 for shipped status
                    $data['supplier_profile'] = $this->suppliers->supplierinfo($supplier_id);
                    $data['supplierID'] = $supplier_id;
                    $this->load->view('supplier/supplier-view-profile', $data);
                } else if ($supplier_viewtype == "update") {
                    $data['countr_sel'] = $this->countries->default_country();
                    $data['states'] = $this->countries->states($data['countr_sel']);
                    $data['creditcards'] = $this->creditcards->listing();
                    $data['countries'] = $this->countries->listing_country();
                    $data['supplier_profile'] = $this->suppliers->supplierinfo($supplier_id);
                    $this->load->view('supplier/supplier-edit-profile', $data);
                }
            }
        }
    }

    // Lanz Editted - June 7, 2013
    function updatesupplierprofile() {
        if ($this->session->userdata('is_login') == TRUE) {
            $supplier_id = $this->session->userdata('id');
            if ($this->input->post('action') != "") {
                $action = $this->input->post('action');
                if ($action == 'update') { //if registering user
                    // Basic Information
                    $firstname = $this->input->post('firstname');
                    $lastname = $this->input->post('lastname');
                    $email = $this->input->post('email');
                    $additional_email = $this->input->post('additional_email');
                    $comp = $this->input->post('comp');
                    $permit = $this->input->post('permit');

                    //$id = $this->input->post('id');
                    // Load Form Validation Library
                    $this->load->library('form_validation');

                    // Basic Information Validation
                    $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|xss_clean');

                    $buyer_info = $this->suppliers->supplierinfo($supplier_id);
                    if ($buyer_info->u_email != $email) //old and new password is not equal
                        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|valid_email|xss_clean|callback_isEmailExist');

                    if ($buyer_info->u_additional_email != $additional_email && $buyer_info->u_email != $additional_email)
                        $this->form_validation->set_rules('additional_email', 'Order Notifications Email', 'trim|min_length[5]|valid_email|xss_clean|callback_isEmailExist');


                    $this->form_validation->set_rules('comp', 'Company', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('permit', 'FEID/Business Number/VAT Registration Number', 'trim|required|xss_clean');

                    // Run validation
                    if ($this->form_validation->run() == FALSE) {
                        $returnmessage = array('message' => validation_errors(), 'status' => 0);
                        echo json_encode($returnmessage);
                    } else {
                        // New Buyer Basic Information
                        $updated_info = array(
                            'u_fname' => $firstname,
                            'u_lname' => $lastname,
                            'u_email' => $email,
                            'u_additional_email' => $additional_email,
                            'u_company' => $comp,
                            'u_permit' => $permit,
                        );

                        // Update Basic Info
                        $this->suppliers->updatebasicinfo($updated_info, $supplier_id);

                        $returnmessage = array('message' => "Information Successfully updated! [" . $supplier_id . " ]", 'status' => 1);
                        echo json_encode($returnmessage);
                    }
                }
            } else {
                redirect('supplier', 'refresh');
            }
        }
    }

    // Lanz Editted - June 7, 2013
    function billing() {
        $data['feat_categories'] = $this->categories->listings(0); //main categories
        if ($this->session->userdata('is_login') == TRUE) {
            if ($this->input->post('action') != "") { //when action occurs
                $action = $this->input->post('action');
                $user_id = $this->session->userdata('id'); //id of the loged in user
                if ($action == 'add') { //add billing
                    $country = $this->input->post('country');
                    $add1 = $this->input->post('add1');
                    $add2 = $this->input->post('add2');
                    $city = $this->input->post('city');
                    $prov = $this->input->post('prov');
                    $postal = $this->input->post('postal');
                    $phone_num = $this->input->post('phone_num');
                    $phone_ext = $this->input->post('phone_ext');

                    $this->load->library('form_validation');

                    $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('add1', 'Address 1', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('add2', 'Address 2', 'trim|xss_clean');
                    $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('prov', 'Province', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('postal', 'Postal', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('phone_num', 'Phone Number', 'trim|required|numeric|xss_clean');
                    $this->form_validation->set_rules('phone_ext', 'Phone Extension', 'trim|numeric|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        $returnmessage = array('message' => validation_errors(), 'status' => 0);
                        echo json_encode($returnmessage);
                    } else {
                        $add_billing = array(
                            'u_id' => $user_id,
                            'c_id' => $country,
                            'ba_add1' => $add1,
                            'ba_add2' => $add2,
                            'ba_city' => $city,
                            'ba_province' => $prov,
                            'ba_postal' => $postal,
                            'ba_phone_num' => $phone_num,
                            'ba_phone_ext' => $phone_ext,
                            'ba_isset' => 0
                        );

                        $ba_id = $this->users->business_address_add($add_billing);

                        $returnmessage = array('message' => "New Billing Address.", 'status' => 1);
                        echo json_encode($returnmessage);
                    }
                } elseif ($action == 'update') { //update billing
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

                    $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('add1', 'Address 1', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('add2', 'Address 2', 'trim|xss_clean');
                    $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('prov', 'Province', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('phone_num', 'Phone Number', 'trim|required|numeric|xss_clean');
                    $this->form_validation->set_rules('phone_ext', 'Phone Extension', 'trim|numeric|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        $returnmessage = array('message' => validation_errors(), 'status' => 0);
                        echo json_encode($returnmessage);
                    } else {
                        $updated_billingaddress = array(
                            'c_id' => $country,
                            'ba_add1' => $add1,
                            'ba_add2' => $add2,
                            'ba_city' => $city,
                            'ba_province' => $prov,
                            'ba_postal' => $postal,
                            'ba_phone_num' => $phone_num,
                            'ba_phone_ext' => $phone_ext,
                        );

                        // Update Billing Address
                        $this->suppliers->updatebillingaddress_ba_id($updated_billingaddress, $id);
                        $returnmessage = array('message' => "Billing Address Updated.", 'status' => 1);
                        echo json_encode($returnmessage);
                    }
                }
            } else { //viewing purposes
                $view_type = $this->uri->segment(3);
                if ($view_type != "") {
                    if ($view_type == 'add') {
                        $data['countr_sel'] = $this->countries->default_country();
                        $data['states'] = $this->countries->states($data['countr_sel']);
                        $data['countries'] = $this->countries->listing_country();
                        $this->load->view('supplier/supplier-add-billing-address', $data);
                    } elseif ($view_type == 'update') {
                        $data['selected_ba'] = $this->uri->segment(4);
                        $data['billing'] = $this->suppliers->get_billing_info($data['selected_ba']);
                        $data['countr_sel'] = $this->countries->default_country();
                        $data['states'] = $this->countries->states($data['countr_sel']);
                        $data['countries'] = $this->countries->listing_country();

                        $this->load->view('supplier/supplier-update-billing-address', $data);
                    }
                    // Lanz Editted - June 7, 2013
                    elseif ($view_type == 'delete') { // delete billing
                        $ba_id = $this->uri->segment(4);
                        $this->suppliers->deleteaddress($ba_id);
                        redirect('supplier/billing', 'refresh');
                    }
                    // Lanz Editted - June 7, 2013
                    else if ($view_type == "setactive") { // set current billing address
                        $ba_id = $this->uri->segment(4);
                        $u_id = $this->uri->segment(5);

                        $this->suppliers->updatecurrentaddress($ba_id, $u_id);
                        redirect('supplier/billing', 'refresh');
                    }
                } else {
                    $id = $this->session->userdata("id");
                    $data['billing_address'] = $this->suppliers->billingaddresses($id);
                    $this->load->view('supplier/supplier-management-billing-address', $data);
                }
            }
        }
    }

    // Lanz Editted - June 8, 2013
    function creditcard() {
        $data['feat_categories'] = $this->categories->listings(0); //main categories
        $id = $this->session->userdata('id');
        $data['credit_cards'] = $this->suppliers->creditcards($id);
        $this->load->view("supplier/supplier-management-creditcard-user", $data);
    }

    // Lanz Editted - June 8, 2013
    function addcreditcard() {
        $data['creditcards'] = $this->creditcards->listing();
        $this->load->view("supplier/supplier-add-creditcard", $data);
    }

    // Lanz Editted - June 8, 2013
    function addnewcreditcard() {
        if ($this->session->userdata('is_login') == TRUE) {
            if ($this->input->post('action') != "") { //when action occurs
                $action = $this->input->post('action');
                $user_id = $this->session->userdata('id'); //id of the loged in user
                if ($action == 'add') { //add new credit card
                    $cctype = $this->input->post('cctype');
                    $ccuname = $this->input->post('ccuname');
                    $ccunum = $this->input->post('ccunum');
                    $ccuccv = $this->input->post('ccuccv');
                    $exp_month = $this->input->post('exp_month');
                    $exp_year = $this->input->post('exp_year');

                    $this->load->library('form_validation');

                    $this->form_validation->set_rules('cctype', 'Card Type', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('ccuname', 'Card Holder', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('ccunum', 'Card Number', 'trim|min_length[16]|xss_clean');
                    $this->form_validation->set_rules('ccuccv', 'Card CCV', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('exp_month', 'Card Expiration Month', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('exp_year', 'Card Expiration Year', 'trim|required|numeric|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        $returnmessage = array('message' => validation_errors(), 'status' => 0);
                        echo json_encode($returnmessage);
                    } else {
                        $add_creditcard = array(
                            'u_id' => $user_id,
                            'cc_id' => $cctype,
                            'ccu_name' => $ccuname,
                            'ccu_number' => $ccunum,
                            'ccu_ccv' => $ccuccv,
                            'ccu_exp_month' => $exp_month,
                            'ccu_exp_year' => $exp_year,
                            'ccu_isset' => 0
                        );

                        $card_id = $this->users->buyer_add_creditcard($add_creditcard);

                        $returnmessage = array('message' => "New Credit Card Added.", 'status' => 1);
                        echo json_encode($returnmessage);
                    }
                }
            }
        }
    }

    // Lanz Editted - June 8, 2013
    function cardaction() {
        if ($this->session->userdata('is_login') == TRUE) {

            $action = $this->uri->segment(3);
            $ccu_id = $this->uri->segment(4);
            $u_id = $this->uri->segment(5);

            if ($action == "update") {
                $data['creditcards'] = $this->creditcards->listing();
                $data['credit_info'] = $this->creditcards->creditcardinfo($ccu_id);
                $this->load->view("supplier/supplier-edit-creditcard", $data);
            } else if ($action == "delete") {
                $this->suppliers->deletecard($ccu_id);
                redirect('supplier/creditcard', 'refresh');
            } else if ($action == "setactive") {
                $this->suppliers->updatecurrentcard($ccu_id, $u_id);
                redirect('supplier/creditcard', 'refresh');
            }
        }
    }

    // Lanz Editted - June 8, 2013
    function updatecard() {
        if ($this->session->userdata('is_login') == TRUE) {
            if ($this->input->post('action') != "") { //when action occurs
                $action = $this->input->post('action');
                $user_id = $this->session->userdata('id'); //id of the loged in user
                if ($action == 'update') { // update credit card
                    $cctype = $this->input->post('cctype');
                    $ccuname = $this->input->post('ccuname');
                    $ccunum = $this->input->post('ccunum');
                    $ccuccv = $this->input->post('ccuccv');
                    $exp_month = $this->input->post('exp_month');
                    $exp_year = $this->input->post('exp_year');
                    $ccuid = $this->input->post('ccuid');

                    $this->load->library('form_validation');

                    $this->form_validation->set_rules('cctype', 'Card Type', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('ccuname', 'Card Holder', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('ccunum', 'Card Number', 'trim|exact_length[16]|xss_clean');
                    $this->form_validation->set_rules('ccuccv', 'Card CCV', 'trim||exact_length[3]required|xss_clean');
                    $this->form_validation->set_rules('exp_month', 'Card Expiration Month', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('exp_year', 'Card Expiration Year', 'trim|required|numeric|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        $returnmessage = array('message' => validation_errors(), 'status' => 0);
                        echo json_encode($returnmessage);
                    } else {
                        $update_creditcard = array(
                            'u_id' => $user_id,
                            'cc_id' => $cctype,
                            'ccu_name' => $ccuname,
                            'ccu_number' => $ccunum,
                            'ccu_ccv' => $ccuccv,
                            'ccu_exp_month' => $exp_month,
                            'ccu_exp_year' => $exp_year
                                //'ccu_isset' => 0
                        );

                        $card_id = $this->users->buyer_update_creditcard($update_creditcard, $ccuid);

                        $returnmessage = array('message' => "Credit Card Updated.", 'status' => 1);
                        echo json_encode($returnmessage);
                    }
                }
            }
        }
    }

    function order() {
        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type'); //get user type;
            $supplierId = $this->session->userdata('id'); //id of the loged in user
            if ($user_type == 2) { // 2 supplier
                $bsd_id = $this->uri->segment(3);
                $bt_status = $this->uri->segment(4);

                if ($bt_status == '')
                    $bt_status = 0;

                $data['supplier'] = $this->suppliers->supplierinfo($supplierId);
                $data['cancels'] = $this->suppliers->cancelOrderList(2);
                $data['bt'] = $this->suppliers->shipping_list_grouped($supplierId, $bsd_id);

                $data['buyer'] = $this->buyers->buyerinfo($data['bt']->u_buyer);
                $data['btd'] = $this->suppliers->transaction_detail($supplierId, $bsd_id);
                $data['delivery_carrier'] = $this->suppliers->shipping_carrier($data['bt']->c_id);
                $data['email_notification'] = $this->users->new_email_count($bsd_id, 2);
//print_r($this->suppliers->transaction_detail(26,3));
//die($bsd_id." test".$supplierId);
                if ($data['btd'] == false)
                    redirect('', 'refresh');
                else {
                    $this->load->view('supplier/supplier-order-detail', $data);
                }
            }
        }
    }

    function order_cancel() {
        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type'); //get user type;
            $supplierId = $this->session->userdata('id'); //id of the loged in user
            if ($user_type == 2) { // 2 supplier
                $bsd_id = $this->uri->segment(3);

                $data['supplier'] = $this->suppliers->supplierinfo($supplierId);
                $data['cancels'] = $this->suppliers->cancelOrderList(2);
                $data['bt'] = $this->suppliers->shipping_list_grouped($supplierId, $bsd_id);

                $data['buyer'] = $this->buyers->buyerinfo($data['bt']->u_buyer);
                $data['btd'] = $this->suppliers->transaction_detail($supplierId, $bsd_id);
                $data['delivery_carrier'] = $this->suppliers->shipping_carrier($data['supplier']->country_user);
                $data['email_notification'] = $this->users->new_email_count($bsd_id, 2);

                if ($data['btd'] == false)
                    redirect('', 'refresh');
                else {
                    $this->load->view('supplier/supplier-order-detail-cancel', $data);
                }
            }
        }
    }

    function orderUpdate() {
        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type'); //get user type;
            $user_id = $this->session->userdata('id'); //id of the loged in user
            if ($user_type == 2 || $user_type == 3) { // 2 supplier , 3 buyer
                $reason = $this->input->post('reason');
                $bsd_id = $this->input->post('bsd_id');

                $action = $this->input->post('action');

                if ($action == 'cancel') {
                    $voidtrans = $this->void_transaction($bsd_id);
                    if ($voidtrans != 0)
                        $status = -1;
                }
                elseif ($action == 'pending')
                    $status = 0;
                elseif ($action == 'in_progress')
                    $status = 10;

                $array = array('bsd_reason' => $reason, 'bsd_status' => $status);
                $result = $this->suppliers->update_buyer_supplier_detail($array, 'bsd_id', $bsd_id);

                if ($status == -1) {
                    $email_data['transaction'] = $this->suppliers->shipping_list_grouped($user_id, $bsd_id);
                    $email_data['products'] = $this->suppliers->transaction_detail($user_id, $bsd_id);
                    $email_data['user'] = $this->users->info($email_data['transaction']->buyer_u_id);

                    $email_data['email_type'] = "Cancellation";
                    $email_content = $this->load->view('email/email-buyer-transaction', $email_data, true);

                    $subject = "Oceantailer: Order Cancellation";
                    $from = "noreply-oceantailer@oceantailer.com";
                    $sender = "OceanTrailer";
                    $to = "" . !empty($email_data['user']->u_additional_email) ? $email_data['user']->u_additional_email : $email_data['user']->u_email;

                    $this->send_message($email_content, $subject, $to, $from, $sender);
                }
                echo $result;
            }
        }
    }

    function void_transaction($bsd_id) {
        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type'); //get user type;
            $supplierId = $this->session->userdata('id'); //id of the loged in user
            if ($user_type == 2) { //supplier
                $shipped_info = $this->suppliers->shipping_list_grouped($supplierId, $bsd_id);
                $trans_id = $shipped_info->bt_trans_id;
                if (!empty($trans_id)) {
                    $response = $this->authorizenet->void($trans_id);
                    return $response;
                } else {
                    return 0;
                }
            }
        }
    }

    function sales() {
        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type'); //get user type;
            $supplierId = $this->session->userdata('id'); //id of the loged in user
            if ($user_type == 2) { // 2 supplier
                $view_type = $this->uri->segment(3);
                if ($view_type == "") {
                    $supplier_info = $this->suppliers->supplierinfo($supplierId);
                    $start_register = strtotime($supplier_info->u_time);
                    $data['range_week'] = $this->suppliers->rangeWeek($start_register);
                    $data['bt_list'] = $this->suppliers->shipping_list_grouped($supplierId, '', '', '', '', 'shipped');
                    $data['user'] = $this->suppliers->supplierinfo($supplierId);
                    $data['supplierID'] = $supplierId;
                    $this->load->view('supplier/supplier-sales', $data);
                } elseif ($view_type == "transaction") {
                    $supplier_info = $this->suppliers->supplierinfo($supplierId);
                    $start_register = strtotime($supplier_info->u_time);
                    $data['range_week'] = $this->suppliers->rangeWeek($start_register);
                    $data['bt_list'] = $this->suppliers->shipping_list_grouped($supplierId, '', '', '', '', 'shipped');
                    $data['user'] = $this->suppliers->supplierinfo($supplierId);
                    $data['supplierID'] = $supplierId;
                    $this->load->view('supplier/supplier-sales-trans', $data);
                } elseif ($view_type == "all") {
                    $supplier_info = $this->suppliers->supplierinfo($supplierId);
                    $start_register = strtotime($supplier_info->u_time);
                    $data['user'] = $this->suppliers->supplierinfo($supplierId);
                    $data['supplierID'] = $supplierId;
                    $this->load->view('supplier/supplier-sales-all', $data);
                }
            }
        }
    }

    /* Lanz Editted - July 21, 2013 */

    function updatepassword() {
        $data['feat_categories'] = $this->categories->listings(0); //main categories
        if ($this->session->userdata('is_login') == TRUE) {
            $this->load->view('supplier/supplier-update-password', $data);
        }
    }

    /* Lanz Editted - July 22, 2013 */

    function passwordupdate() {
        if ($this->session->userdata('is_login') == TRUE) {
            if ($this->input->post('action') == "update") {
                $buyer_id = $this->session->userdata('id');
                $current_password = $this->input->post('curr_pass');
                $new_password = $this->input->post('new_pass');
                $new_password1 = $this->input->post('new_pass1');

                $current_pass = $this->users->password($buyer_id);
                if ($current_password == $current_pass) {
                    if (empty($new_password) || empty($new_password1)) {
                        $message = array('status' => 1, 'message' => 'Must provide new password');
                        echo json_encode($message);
                    } else if ($new_password != $new_password1) {
                        $message = array('status' => 0, 'message' => 'Password does not match');
                        echo json_encode($message);
                    } else {
                        $new_pass = $this->users->encript($new_password);
                        $updated_pass = array(
                            'u_pass' => $new_pass
                        );

                        $this->users->updatepassword($updated_pass, $buyer_id);

                        $message = array('status' => 2, 'message' => 'Password Updated Successfully');
                        echo json_encode($message);
                    }
                } else if (empty($current_password) || empty($new_password) || empty($new_password1)) {
                    $message = array('status' => 0, 'message' => 'Please provide password');
                    echo json_encode($message);
                } else {
                    $message = array('status' => 0, 'message' => 'Password does not match');
                    echo json_encode($message);
                }
            }
        }
    }

    /* Lanz Editted - July 22, 2013 */

    function validate_address1($mail) {
        $this->form_validation->set_message('validate_address1', 'Address 1 invalid');
        if (is_numeric($mail)) {
            return false;
        }

        $this->form_validation->set_message('validate_address1', 'Address 1 you entered already exist');
        if ($this->users->check_address1($this->session->userdata('id'), $mail)) {
            return false;
        } else {
            return true;
        }
    }

    /* Lanz Editted - July 22, 2013 */

    function validate_address2($mail) {
        $this->form_validation->set_message('validate_address2', 'Address 2 invalid');
        if (is_numeric($mail)) {
            return false;
        }

        $this->form_validation->set_message('validate_address2', 'Address 2 you entered already exist');
        if ($this->users->check_address2($this->session->userdata('id'), $mail)) {
            return false;
        } else {
            return true;
        }
    }

    /* Lanz Editted - July 22, 2013 */

    function validate_phonenumber($number) {
        $this->form_validation->set_message('validate_phonenumber', 'Phone number is invalid');
        if (!is_numeric($number)) {
            return false;
        }

        $this->form_validation->set_message('validate_address2', 'Phone number already exist');
        if ($this->users->check_address2($this->session->userdata('id'), $number)) {
            return false;
        } else {
            return true;
        }
    }

    /* Lanz Editted - July 22, 2013 */

    function validate_zipcode($number) {
        $this->form_validation->set_message('validate_zipcode', 'Zip Code/Postal Code is invalid');
        if (!is_numeric($number)) {
            return false;
        }
    }

    /* Lanz Editted - July 22, 2013 */

    function validate_town($town) {
        $this->form_validation->set_message('validate_town', 'Town/City is invalid');
        if (is_numeric($town)) {
            return false;
        }
    }

    /* Lanz Editted - July 22, 2013 */

    function validate_credit_card($creditcard_num) {
        $this->form_validation->set_message('validate_credit_card', 'Invalid creditcard');
        if (!is_numeric($creditcard_num)) {
            return false;
        }

        $this->form_validation->set_message('validate_credit_card', 'Creditcard already exist');
        if ($this->users->check_creditcard($creditcard_num)) {
            return false;
        } else {
            return true;
        }
    }

    /* Lanz Editted - July 22, 2013 */

    function validate_cardholder($creditcard_holder_name) {
        $this->form_validation->set_message('validate_cardholder', 'Card holder name is invalid');
        if (is_numeric($creditcard_holder_name)) {
            return false;
        }
    }

    /* Lanz Editted - July 22, 2013 */

    function validate_cardccv($creditcard_ccv) {
        $this->form_validation->set_message('validate_cardccv', 'Creditcard CCV is invalid');
        if (!is_numeric($creditcard_ccv)) {
            return false;
        }
    }

    function no_zero($var) {
        if (empty($var))
            $this->form_validation->set_message('no_zero', 'The %s couldn\'t be zero.');
        return (!empty($var));
    }

    function urlisvalid($uri) {
        $exists = true;
        $URL = $this->suppliers->norm_url($uri);
        $file_headers = @get_headers($URL);
        $InvalidHeaders = array('404', '403', '500');
        foreach ($InvalidHeaders as $HeaderVal) {
            if (strstr($file_headers[0], $HeaderVal)) {
                $this->form_validation->set_message('urlisvalid', 'The URL "' . $uri . '" is not valid.');
                $exists = false;
                break;
            }
        }
        $SemiInvalidHeaders = array('302' => 'text/html');
        foreach ($SemiInvalidHeaders as $HeaderVal => $ErrorToken) {
            if (strstr($file_headers[0], $HeaderVal)) {
                foreach ($file_headers as $theader) {
                    if (strstr($theader, $ErrorToken)) {
                        $this->form_validation->set_message('urlisvalid', 'The URL "' . $uri . '" is not valid.');
                        $exists = false;
                        break;
                    }
                }
            }
        }
        return $exists;
    }

    function feedback() {
        $data['feat_categories'] = $this->categories->listings(0); //main categories
        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type'); //get user type;
            $supplierId = $this->session->userdata('id'); //id of the loged in user
            if ($user_type == 2) { // 2 supplier
                $data['feedback_detail'] = $this->suppliers->feedback_detail($supplierId);
                $this->load->view('supplier/supplier-feedback-list', $data);
            }
        }
    }

    function memo() {
        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type'); //get user type;
            $supplierId = $this->session->userdata('id'); //id of the loged in user
            if ($user_type == 2) { // 2 supplier
                if ($this->input->post('action') != "") {
                    $action = $this->input->post('action');
                    if ($action == 'update') {
                        $memo = $this->input->post('memo');
                        $bsd_id = $this->input->post('id');

                        $data_update = array('bsd_memo' => $memo);
                        $this->suppliers->update_buyer_supplier_detail($data_update, 'bsd_id', $bsd_id);
                    }
                }
            }
        }
    }

    function inbox() {
        if ($this->session->userdata('is_login') == TRUE) {

            $data['feat_categories'] = $this->categories->listings(0); //main categories
            $user_type = $this->session->userdata('type'); //get user type;
            $supplierId = $this->session->userdata('id'); //id of the loged in user
            if ($user_type == 2) { // 2 supplier
                if ($this->input->post('action') == "") {
                    $bsm_id = $this->uri->segment(3);

                    if ($bsm_id == "") {
                        $data['supplier'] = $this->suppliers->supplierinfo($supplierId);
                        $data['messages'] = $this->users->get_all_personal_message($supplierId, 'supplier');

                        $this->load->view('supplier/supplier-inbox', $data);
                    } else {
                        $data['supplier'] = $this->suppliers->supplierinfo($supplierId);
                        $data['message'] = $this->users->get_personal_message_detail($bsm_id, 'supplier');
                        $this->load->view('supplier/supplier-inbox-detail', $data);
                    }
                }
            }
        }
    }

    function refund() {
        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type'); //get user type;
            $supplierId = $this->session->userdata('id'); //id of the loged in user
            if ($user_type == 2) { // 2 supplier
                $bsd_id = $this->uri->segment(3);

                if ($this->input->post('action') != "") {
                    $action = $this->input->post('action');

                    if ($action == 'save') {
                        $prod_ref = $this->input->post('product_refund');
                        $ship_ref = $this->input->post('product_shipping');
                        $reason = $this->input->post('reason');
                        $memo = $this->input->post('memo');
                        $bsd = $this->input->post('bsd');

                        $refund_is_exist = $this->suppliers->check_refund_record($bsd_id); //if exist only update. else add a recorc

                        $add_refund = array('orr_date' => apputils::ConvertUnStampToMysqlDateTime(time()),
                            'bsd_id' => $bsd,
                            'orr_prod_amnt' => $prod_ref,
                            'orr_ship_amnt' => $ship_ref,
                            'orr_total' => $prod_ref + $ship_ref,
                            'orr_memo' => $memo,
                            'orr_reason' => $reason);


                        $array = array('bsd_reason' => "Order Refund", 'bsd_status' => -3); //-3 for refund order status
                        $result = $this->suppliers->update_buyer_supplier_detail($array, 'bsd_id', $bsd);

                        if ($refund_is_exist)
                            $result = $this->suppliers->update_refund_record($add_refund, 'bsd_id', $bsd);
                        else
                            $result = $this->suppliers->add_refund_record($add_refund);
                    }
                    elseif ($action == 'delete') {
                        
                    }
                } else {

                    $data['supplier'] = $this->suppliers->supplierinfo($supplierId);
                    $data['refund_lists'] = $this->suppliers->list_refund();
                    $data['bt'] = $this->suppliers->shipping_list_grouped($supplierId, $bsd_id);

                    $data['buyer'] = $this->buyers->buyerinfo($data['bt']->u_buyer);
                    $data['btd'] = $this->suppliers->transaction_detail($supplierId, $bsd_id);

                    if ($data['btd'] == false)
                        redirect('', 'refresh');
                    else {
                        $this->load->view('supplier/supplier-refund', $data);
                    }
                }
            }
        }
    }

    function bankaccount() {
        $data['feat_categories'] = $this->categories->listings(0); //main categories
        $id = $this->session->userdata('id');
        $data['bank_details'] = $this->suppliers->bankaccount($id);
        $this->load->view("supplier/supplier-management-bank-user", $data);
    }

    // Lanz Editted - June 8, 2013
    function addbankaccount() {
        $data['countries'] = $this->countries->listing_country();
        $data['countr_sel'] = $this->countries->default_country();
        $this->load->view("supplier/supplier-add-bank", $data);
    }

    // Lanz Editted - June 8, 2013
    function addnewbankaccount() {
        if ($this->session->userdata('is_login') == TRUE) {
            if ($this->input->post('action') != "") { //when action occurs
                $action = $this->input->post('action');
                $user_id = $this->session->userdata('id'); //id of the loged in user
                if ($action == 'add') { //add new credit card
                    $bank_country = $this->input->post('bnk_country');
                    $bank_owner = $this->input->post('bnk_owner');
                    $bank_name = $this->input->post('bnk_name');
                    $bank_address = $this->input->post('bnk_address');
                    $bank_account = $this->input->post('bnk_account');
                    $bank_id_code = $this->input->post('bnk_id_code');

                    $this->load->library('form_validation');

                    $this->form_validation->set_rules('bnk_owner', 'Bank Owner', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('bnk_name', 'Bank Name', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('bnk_address', 'Bank Address', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('bnk_account', 'Bank Account', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('bnk_id_code', 'Bank ID Code', 'trim|required|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        $returnmessage = array('message' => validation_errors(), 'status' => 0);
                        echo json_encode($returnmessage);
                    } else {
                        $add_bank = array(
                            'u_id' => $user_id,
                            'c_id' => $bank_country,
                            'bnk_owner' => $bank_owner,
                            'bnk_name' => $bank_name,
                            'bnk_address' => str_replace("\n", ",", $bank_address),
                            'bnk_account' => $bank_account,
                            'bnk_id_code' => $bank_id_code
                        );

                        $bank_id = $this->banks->add_bank_account($add_bank);

                        $returnmessage = array('message' => "Bank account added", 'status' => 1);
                        echo json_encode($returnmessage);
                    }
                }
            }
        }
    }

    // Lanz Editted - June 8, 2013
    function bankaction() {
        if ($this->session->userdata('is_login') == TRUE) {

            $action = $this->uri->segment(3);
            $b_id = $this->uri->segment(4);
            $u_id = $this->uri->segment(5);

            if ($action == "update") {
                $data['countries'] = $this->countries->listing_country();
                $data['bank_detail'] = $this->banks->get($b_id);
                //echo "<pre>";print_r($data['countries']);exit;
                $this->load->view("supplier/supplier-edit-bank", $data);
            } else if ($action == "delete") {
                $this->banks->deletebank($b_id);
                redirect('supplier/bankaccount', 'refresh');
            }
        }
    }

    // Lanz Editted - June 8, 2013
    function updatebank() {
        if ($this->session->userdata('is_login') == TRUE) {
            if ($this->input->post('action') != "") { //when action occurs
                $action = $this->input->post('action');
                $user_id = $this->session->userdata('id'); //id of the loged in user
                if ($action == 'update') { //add new credit card
                    $bank_id = $this->input->post('bnk_id');
                    $bank_country = $this->input->post('bnk_country');
                    $bank_owner = $this->input->post('bnk_owner');
                    $bank_name = $this->input->post('bnk_name');
                    $bank_address = $this->input->post('bnk_address');
                    $bank_account = $this->input->post('bnk_account');
                    $bank_id_code = $this->input->post('bnk_id_code');

                    $this->load->library('form_validation');

                    $this->form_validation->set_rules('bnk_owner', 'Bank Owner', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('bnk_name', 'Bank Name', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('bnk_address', 'Bank Address', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('bnk_account', 'Bank Account', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('bnk_id_code', 'Bank ID Code', 'trim|required|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        $returnmessage = array('message' => validation_errors(), 'status' => 0);
                        echo json_encode($returnmessage);
                    } else {
                        $add_bank = array(
                            'u_id' => $user_id,
                            'c_id' => $bank_country,
                            'bnk_owner' => $bank_owner,
                            'bnk_name' => $bank_name,
                            'bnk_address' => str_replace("\n", ",", $bank_address),
                            'bnk_account' => $bank_account,
                            'bnk_id_code' => $bank_id_code
                        );

                        $bank_id = $this->banks->update_bank_account($add_bank, $bank_id);

                        $returnmessage = array('message' => "Bank account updated", 'status' => 1);
                        echo json_encode($returnmessage);
                    }
                }
            }
        }
    }

    function shippingtable() {
        $data['feat_categories'] = $this->categories->listings(0); //main categories
        $id = $this->session->userdata('id');
        $data['shippingtable'] = $this->suppliers->shippingtable($id);
        $this->load->view("supplier/supplier-shipping-table", $data);
    }

    function update_shippingtable() {
                
        if ($this->session->userdata('is_login') == TRUE) {

            if ($this->input->post('action') != "") { //when action occurs
                $action = $this->input->post('action');
                $user_id = $this->session->userdata('id'); //id of the loged in user
                if ($action == 'update') { //add new credit card
                    $std_cb = $this->input->post('std_cb');
                    $exp_cb = $this->input->post('exp_cb');
                    $two_cb = $this->input->post('two_cb');
                    $one_cb = $this->input->post('one_cb');
                    $bands = $this->input->post('band');
                    $tier = $this->input->post('tier');
                    if(isset($bands)){
if($std_cb=='true'){
                    $update_st = array(
                        'u_id' => $user_id,
                        's_level' => "standard",
                        's_tier' => $tier,
                        's_price_bands' => isset($bands['price'])&&isset($bands['price']['std'])? json_encode($bands['price']['std']): '',
                        's_weight_bands' => isset($bands['weight'])&&isset($bands['weight']['std'])? json_encode($bands['weight']['std']): ''
                    );

                    $st_id = $this->suppliers->update_shippingtable_data($update_st);
}else{
                    $update_st = array(
                        'u_id' => $user_id,
                        's_level' => "standard",
                        's_tier' => $tier,
                        's_price_bands' => '',
                        's_weight_bands' => ''
                    );

                    $st_id = $this->suppliers->update_shippingtable_data($update_st);
}
if($exp_cb=='true'){
                    $update_st = array(
                        'u_id' => $user_id,
                        's_level' => "expedited",
                        's_tier' => $tier,
                        's_price_bands' => isset($bands['price'])&&isset($bands['price']['exp'])? json_encode($bands['price']['exp']): '',
                        's_weight_bands' => isset($bands['weight'])&&isset($bands['weight']['exp'])? json_encode($bands['weight']['exp']): ''
                    );

                    $st_id = $this->suppliers->update_shippingtable_data($update_st);
}else{
                    $update_st = array(
                        'u_id' => $user_id,
                        's_level' => "expedited",
                        's_tier' => $tier,
                        's_price_bands' => '',
                        's_weight_bands' => ''
                    );

                    $st_id = $this->suppliers->update_shippingtable_data($update_st);
}
if($two_cb=='true'){
                    $update_st = array(
                        'u_id' => $user_id,
                        's_level' => "two-day",
                        's_tier' => $tier,
                        's_price_bands' => isset($bands['price'])&&isset($bands['price']['two'])? json_encode($bands['price']['two']): '',
                        's_weight_bands' => isset($bands['weight'])&&isset($bands['weight']['two'])? json_encode($bands['weight']['two']): ''
                    );

                    $st_id = $this->suppliers->update_shippingtable_data($update_st);
}else{
                    $update_st = array(
                        'u_id' => $user_id,
                        's_level' => "two-day",
                        's_tier' => $tier,
                        's_price_bands' => '',
                        's_weight_bands' => ''
                    );

                    $st_id = $this->suppliers->update_shippingtable_data($update_st);
}
if($one_cb=='true'){
                    $update_st = array(
                        'u_id' => $user_id,
                        's_level' => "one-day",
                        's_tier' => $tier,
                        's_price_bands' => isset($bands['price'])&&isset($bands['price']['one'])? json_encode($bands['price']['one']): '',
                        's_weight_bands' => isset($bands['weight'])&&isset($bands['weight']['one'])? json_encode($bands['weight']['one']): ''
                    );

                    $st_id = $this->suppliers->update_shippingtable_data($update_st);
}else{
                    $update_st = array(
                        'u_id' => $user_id,
                        's_level' => "one-day",
                        's_tier' => $tier,
                        's_price_bands' => '',
                        's_weight_bands' => ''
                    );

                    $st_id = $this->suppliers->update_shippingtable_data($update_st);
}
                    }
                    $returnmessage = array('message' => "Shipping Table updated", 'status' => 1);
                    echo json_encode($returnmessage);
                }
            }
        }
    }

    /* 	function sync_ticket()
      {
      $this->db->select('*');
      $this->db->from('user');
      $this->db->where('u_type = 2 OR u_type = 3');
      $result_list = $this->db->get()->result();
      } */

    function datafeeds() {
        $data = array();
        $this->load->model('import_history');
        $this->load->model('import_result');
        $this->load->library('encrypt');
        $user_type = 0;
        if ($this->session->userdata('is_login') == true) {
            $user_type = $this->session->userdata('type');
        }
        if ($user_type == 2) {
            $user_id = $this->session->userdata('id');
            $data['hashes'] = array(
                'reference' => array(
                    'xlsx' => $this->encrypt->encode(serialize(array('extract' => 'template', 'type' => 'xlsx', 'user_id' => $user_id))),
                )
            );
        }

        $data['results'] = false;
        // If 'Registration' form has been submitted, attempt to register their details as a new account.
        if ($this->input->post('import')) {
            $id = $this->import_result->add(array());
            $this->session->set_userdata('import_result_id', $id);
            $userid = $this->session->userdata('id');
            $results = $this->import->datafeeds();
            $this->db->where('id', $id);
            $this->db->update('import_result', array('results' => serialize($results)));
            if ($results['error']) {
                $h_id = $this->import_history->add($userid, 0, 0, 0, 0, 0, $results['extension'], 0, $id);
            } else {
                $h_id = $this->import_history->add($userid, $results['total'], $results['inserted'], $results['updated'], $results['deleted'], 0, $results['extension'], 1, $id);
            }
            $this->db->where('id', $h_id);
            $this->db->update('import_history', array(
                'created_at' => $results['created_at'],
            ));
            echo "<script>location.href='/supplier/datafeeds';</script>";
        } else {
            $id = $this->session->userdata('import_result_id');
            $page = (int) $this->input->get('page');
            $page = $page > 0 ? $page : 1;

            if ($id) {
                $results = $this->import_result->get($id);
                if ($results) {
                    $data['results'] = unserialize($results->results);
                    //$this->import_result->delete($id);
                }
                $this->session->set_userdata(array('import_result_id' => false));
            }

            $data['history'] = $this->import_history->get($this->session->userdata['id'], $page, 20);
            $this->db->where('user_id', $this->session->userdata['id']);
            $data['history_pages'] = ceil($this->db->count_all_results('import_history') / 20);
            $data['page'] = $page;

            $this->load->view('supplier/supplier-data-feeds', $data);
        }
    }

    function messages($message_id = FALSE) {

        if ($message_id) {

            if ($this->session->userdata('is_login') == TRUE) {

                $array = array('read' => '1');
                $result = $this->suppliers->update_message_from_buyer($array, 'id', $message_id);

                $data['msg'] = $this->suppliers->get_message_from_buyer_detail($message_id);
                if (!$data['msg']) {
                    redirect('', 'refresh');
                } else {
                    $this->load->view('supplier/supplier-message-from-buyer-detail', $data);
                }
            }
        } else {
            if ($this->session->userdata('is_login') == TRUE) {
                $action = $this->input->post('action');
                $user_type = $this->session->userdata('type'); //get user type;
                if ($action != '') {

                    $supplierId = $this->session->userdata('id');
                    $page = (int) $this->input->get('page');
                    $page = $page > 0 ? $page : 1;
                    $sort_by = $this->input->post('sort_by');
                    $sort_direction = $this->input->post('sort_direction');
                    $sort_direction = ($sort_direction != '') ? $sort_direction : 'desc';
                    $sort_by = ($sort_by != '') ? $sort_by : 'time';


                    $data['statuses'] = $data['statuses'] = array(
                        '' => 'All',
                        '1' => 'Read',
                        '0' => "Unread",
                    );

                    //filters
                    $buyer_name = $this->input->post('buyer_name');
                    $buyer_email = $this->input->post('buyer_email');
                    $buyer_phone = $this->input->post('buyer_phone');
                    $start = $this->input->post('start');
                    $end = $this->input->post('end');
                    $status = $this->input->post('status');


                    $filters_data['filters'] = array(
                        'buyer_name' => array('title' => "Buyer's Name", 'value' => $buyer_name),
                        'buyer_email' => array('title' => "Buyer's Email", 'value' => $buyer_email),
                        'buyer_phone' => array('title' => "Buyer's Phone", 'value' => $buyer_phone),
                        'start' => array('title' => 'From', 'value' => $start, 'type' => 'datepicker'),
                        'end' => array('title' => 'To', 'value' => $end, 'type' => 'datepicker'),
                        'status' => array('title' => 'Status', 'value' => $stat, 'type' => 'select', 'opts' => $data['statuses'])
                    );

                    $rowsCount = count($this->suppliers->get_messages_from_buyer($buyer_name, $buyer_email, $buyer_phone, $start, $end, $status, $page, 25, $sort_by, $sort_direction));

                    $items = $this->suppliers->get_messages_from_buyer($buyer_name, $buyer_email, $buyer_phone, $start, $end, $status, $page, 25, $sort_by, $sort_direction);

                    foreach ($items as $item) {
                        $item->read = $item->read ? 'read' : 'unread';
                    }

                    $data['items'] = $items;
                    $data['columns'] = array(
                        'time' => array('title' => 'Date', 'sortable' => true),
                        'buyer_name' => array('title' => 'Buyer Name', 'sortable' => true),
                        'buyer_email' => array('title' => 'Buyer Email', 'sortable' => true),
                        'buyer_phone' => array('title' => 'Buyer Phone', 'sortable' => true),
                        'product_link' => array('title' => 'Product Link', 'sortable' => true),
                        'read' => array('title' => 'Status', 'sortable' => true),
                        'actions' => array(
                            'title' => 'Action',
                            'sortable' => false,
                            'items' => array(
                                'view' => array('link' => '/supplier/messages/', 'text' => 'View Message', 'confirm' => false, 'pk' => 'id')
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

                    $this->load->view('tools/filters', $filters_data);
                    $this->load->view('tools/table', $data);
                    $this->load->view('tools/pagination', $pages);
                } else {

                    $this->load->view('supplier/supplier-messages-from-buyer', $data);
                }
            }
        }
    }

    function message_to_supplier() {
        $icid = $_POST['icid'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $link = $_POST['link'];
        $message = $_POST['message'];

        if ($icid != '' && $name != '' && $email != '' && $phone != '' && $link != '' && $message != '') {

            $supplier_id = $this->inventories->get_supplier_id_from_icid($icid);
            $supplier = $this->suppliers->supplierinfo($supplier_id);

            $to = $supplier->u_email;

            $data = array(
                'supplier_id' => $supplier_id,
                'icid' => $icid,
                'product_link' => $link,
                'message' => $message,
                'buyer_name' => $name,
                'buyer_email' => $email,
                'buyer_phone' => $phone,
                'read' => '0',
                'status' => '1',
                'time' => date('Y-m-d H:i:s')
            );

            $this->suppliers->save_buyer_message_to_supplier($data);

            /* send message to supplier */

            $email_data['message'] = $message;
            $email_data['link'] = $link;
            $email_data['phone'] = $phone;
            $email_data['name'] = $name;
            $email_data['email'] = $email;

            $email_data['email_type'] = "message_to_supplier";

            $email_content = $this->load->view('email/email-supplier-transaction', $email_data, true);

            $subject = "Oceantailer: Message from Buyer";
            $from = "noreply-oceantailer@oceantailer.com";
            $sender = "OceanTrailer";

            $this->send_message($email_content, $subject, $to, $from, $sender);


            $result = array('result' => 1, 'message' => 'Message sent to supplier.');
        } else
            $result = array('result' => 0, 'message' => 'All fields are required.');

        echo json_encode($result);
    }

}
