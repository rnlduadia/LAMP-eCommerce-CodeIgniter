<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Lanz Editted - June 10, 2012
class administrator extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('users');
		$this->load->model('administrators');
        $this->load->model('logs');
		$this->load->model('categories');
	}

	public function index()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type');
			if ($user_type == 1)
			{
				$data['administrators'] = $this->administrators->adminlist();
				$this->load->view('admin/admin/admin-page',$data);
			}
		}
	}

	function add()
	{
		$this->load->view('admin/admin/admin-add-administrator');
	}

	function fix_image_setting()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$this->load->view('admin/admin/admin-fix-image');
		}
	}

	function fix_image()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$this->administrators->update_base_url_image();
		}
	}

	function addnewuser()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			if ($this->input->post('action') != "")
			{
				$action = $this->input->post('action');
				if ($action == "add")
				{
					$firstname = $this->input->post('firstname');
					$lastname = $this->input->post('lastname');
					$email = $this->input->post('email');
					$username = $this->input->post('username');
					$password = $this->input->post('password');
					$confirmpass = $this->input->post('con_pass');

					$this->load->library('form_validation');

					$this->form_validation->set_rules('firstname', 'First Name', 'trim|required|xss_clean');
					$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|xss_clean');
					$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|valid_email|xss_clean|callback_isEmailExist');
					$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|xss_clean|callback_isUserNameExist');
					$this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]|max_length[40]|required|xss_clean|matches[con_pass]');
					$this->form_validation->set_rules('con_pass','Confirm Password','trim|min_length[6]|max_length[40]|required|xss_clean');

					if ($this->form_validation->run() == FALSE)
					{
						$returnmessage = array( 'message' => validation_errors() , 'status' => 0);
				        echo json_encode($returnmessage);
					}
					else
					{
						// Set activation code to blank
						$activation_code = "";

						// New admin user data
						$add_user = array(
										'u_username'  => $username,
										'u_pass'  => $this->users->encript($password),
										'u_fname'  => $firstname,
										'u_lname'  => $lastname,
										'u_email'  => $email,
										'u_type'  => 1,
										'u_status'  => 1,
										'u_admin_approve'  => 1,
										'u_verify_code'  => $activation_code,
										'u_time'  => apputils::ConvertUnStampToMysqlDateTime(time())
							   		);

						// Add new admin user and return ID
						$user_id = $this->users->add($add_user);

						// Prompt success
						$returnmessage = array( 'message' => "New Administrator Account Added." , 'status' => 1);
			            echo json_encode($returnmessage);

			            // Lanz Editted - June 17, 2013
			            // Administrator Activate Email Information
						$email_data['username'] = $username;
						$email_data['password'] = $password;
						$email_data['email_type'] = "Administrator Account Activate Email";
						$email_content = $this->load->view('email/email-admin-activate',$email_data, true);

						// Buyer Activate Email Format
						$subject = "Oceantailer: Administrator Account Verification ";
						$from = "noreply-oceantailer@oceantailer.com";
						$sender = "http://www.oceantailer.com";
						$to = "".$email;

						// Send email to new Buyer
						$this->send_message($email_content, $subject, $to, $from, $sender);
					}
				}
			}
		}
	}

	function isEmailExist($mail)
    {
        $this->form_validation->set_message('isEmailExist','The Email %S is already exist');
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

	function send_message($message, $subject, $to, $from, $sender)
	{
		$this->load->library('email');

       	$config = array();
        $config['useragent']           = "CodeIgniter";
        $config['mailpath']            = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
        $config['protocol']            = "smtp";
       // $config['smtp_host']           = "localhost";
       // $config['smtp_port']           = "25";
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


	// Lanz Editted - June 12, 2013
	function managepermission()
	{
		$data['id'] = $this->uri->segment(3);
		$data['permissions'] = $this->administrators->permission_lists();
		$data['assigned_permission'] = $this->administrators->assigned_permission_list($data['id']);
		$this->load->view('admin/admin/admin-add-permission', $data);
	}

	// Lanz Editted - June 13, 2013
	function assignpermission()
	{
		$id = $this->uri->segment(3);
		$perm_id = $this->input->post('val');

		$this->administrators->delete_assigned_permissions($id);
		foreach ($perm_id as $perm)
		{
			$data = array('u_id' => $id, 'p_id' => $perm);
			$this->administrators->save_assigned_permission($data);
		}

		$returnmessage = array( 'message' => "User Permission Added." , 'status' => 1);
		echo json_encode($returnmessage);
	}

	function block()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$id = $this->uri->segment(3);

			$update_array =  array('u_status' => 2);

			$this->users->update($update_array, 'u_id', $id );

			redirect('administrator','refresh');
		}
	}

	function activate()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$id = $this->uri->segment(3);

			$update_array =  array('u_status' => 1);

			$this->users->update($update_array, 'u_id', $id );

			redirect('administrator','refresh');
		}
	}

	function setting_update()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type');
			if ($user_type == 1)
			{
				$action = $this->input->post('action');

				if($action == "authorized")
				{
					$update = array("auth_apiLogin" => $this->input->post('api_login'),
									"auth_apiKey" => $this->input->post('api_key'),
									"auth_apiSandbox" => $this->input->post('is_sandbox'));

					$result = $this->administrators->update_setting($update);
				}
				elseif($action == "supplier_settings")
				{
					$update = array("supplier_selFee" => $this->input->post('sup_fee'));

					$result = $this->administrators->update_setting($update);
				}elseif($action == "homepage"){
					$data = array();
					parse_str(str_replace(";","",$this->input->post("data")),$data);

					$update = array("homepage" => json_encode($data));
					$result = $this->administrators->update_setting($update);
				}

			}
		}
	}

	function setting_supplier()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type');
			if ($user_type == 1) //administrator
			{

				$data['settings'] = $this->administrators->get_settings();

				$this->load->view('admin/admin/supplier-setting',$data);
			}
		}
	}

	function setting_homepage()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type');
			if ($user_type == 1) //administrator
			{
				$data['settings'] = json_decode($this->administrators->get_settings('homepage'),true);
				$data['categories'] = $this->categories->listings();

				$this->load->view('admin/admin/homepage-settings',$data);
			}
		}
	}


	function loginAs()
    {
        if($this->session->userdata('is_login') == TRUE)
        {
            $viewed_by = $this->uri->segment(3);

            if ($viewed_by == "admin")
            {
                $u_id = $this->uri->segment(4);
                $data = $this->users->load($u_id);
                $dec_pass = $this->users->decript($data->u_pass);
                $newdata = array(
                    'id'  => $data->u_id,
                    'fname' => $data->u_fname,
                    'lname' => $data->u_lname,
                    'email' => $data->u_email,
                    'type' => $data->u_type,
                    'is_login' => TRUE,
                    'psw' => $dec_pass
                );

                $array_items = array('id' => '', 'is_login' => false, 'type' => '', 'email' => '', 'name' => '');
                $this->session->unset_userdata($array_items);
                $this->session->set_userdata($newdata);

                $d['u_id'] = $data->u_id;
                $d['event'] = "login";
                $d['module'] = "administrator/loginAs";
                $d['additional'] = $_SERVER['HTTP_REFERER'];
                $this->logs->add($d);
            }
        }
        redirect('index.php','refresh');
    }

	function logs()
	{
		if ($this->session->userdata('is_login') == TRUE)
		{
			$user_type = $this->session->userdata('type');
			if ($user_type == 1) //administrator
			{
                $view_type = $this->uri->segment(3);
                if ($view_type == 'filterbyuser')
                {
                   $u_id = $this->uri->segment(4);
                   $logs = $this->logs->listing($u_id);
                } else {
                   $logs = $this->logs->listing();
                }
                $data['pagination'] = $logs['pagination'];
                $data['logs'] = $logs['result'];

				$this->load->view('admin/admin/admin-logs-view',$data);
			}
		}
	}

    function search()
    {
        if ($this->session->userdata('is_login') == TRUE) {

            $user_type = $this->session->userdata('type'); //get user type;
            $user_id = $this->session->userdata('id'); //id of the loged in user
            $data= array();
            $this->load->view('buyer/buyer-search-form',$data);
        }
    }

    function make_search()
    {
        $u_type= !empty($_REQUEST['u_type']) ? $_REQUEST['u_type'] : '';

        $operation_company_name= !empty($_REQUEST['operation_company_name']) ? $_REQUEST['operation_company_name'] : 'Contains';
        $company_name= !empty($_REQUEST['company_name']) ? $_REQUEST['company_name'] : '';

        $operation_username= !empty($_REQUEST['operation_username']) ? $_REQUEST['operation_username'] : 'Contains';
        $username= !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';

        $operation_email= !empty($_REQUEST['operation_email']) ? $_REQUEST['operation_email'] : 'Contains';
        $email= !empty($_REQUEST['email']) ? $_REQUEST['email'] : '';

        $data= array();
        $data['foundUsersList'] = $this->users->getUsersSearch( $operation_company_name, $company_name, $operation_username, $username, $operation_email, $email, $u_type );
        ob_start();
        $this->load->view('buyer/buyer-search-form-results',$data);
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }

}
?>