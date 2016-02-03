<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class authorized extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //Load Neccessary Models
		$this->load->model('users');
		$this->load->model('manufacturers');
		$this->load->model('suppliers');
		$this->load->model('administrators');
		$this->load->model('banks');
		//End Load Neccessary Models
        $this->config->load('authorized');
		define("AUTHORIZENET_API_LOGIN_ID", $this->config->item('AUTHORIZENET_API_LOGIN_ID'));
        define("AUTHORIZENET_TRANSACTION_KEY", $this->config->item('AUTHORIZENET_TRANSACTION_KEY'));
        define("AUTHORIZENET_MD5_SETTING", $this->config->item('AUTHORIZENET_MD5_SETTING'));
        define("AUTHORIZENET_SANDBOX", $this->config->item('AUTHORIZENET_SANDBOX'));
        define("AUTHORIZENET_LOG_FILE", $this->config->item('AUTHORIZENET_LOG_FILE'));

        /*require_once(base_url().'application/config/authorized.php');*/
        $this->load->library('authorizenet');
    }

    function setting(){
        if ($this->session->userdata('is_login') == TRUE)
        {
            $user_type = $this->session->userdata('type');
            if ($user_type == 1) //administrator
            {

                $data['settings'] = $this->administrators->get_settings();

                $this->load->view('admin/admin/auth-net-setting',$data);
            }
        }
    }

    function sample(){

		// REMEMBER YOUR AMOUNT HAS TO INCLUDE THE TAX
		$price = 10;
		$tax = number_format($price * .095,2); // Set tax
		$amount = number_format($price + $tax,2); // Set total amount


    	$this->authorizenet->setFields(
		array(
		'amount' => '10.00',
		'card_num' => '370000000000002',
		'exp_date' => '04/17',
		'first_name' => 'James',
		'last_name' => 'Angub',
		'address' => '123 Main Street',
		'city' => 'Boston',
		'state' => 'MA',
		'country' => 'USA',
		'zip' => '02142',
		'email' => 'some@email.com',
		'card_code' => '782',
		)
		);
		$response = $this->authorizenet->authorizeAndCapture();

		/*print_r($response);*/

		if ($response->approved) {
		echo "approved";
        /*echo "APPROVED";*/
		} else {
        echo FALSE;
		/*echo "DENIED ".AUTHORIZENET_API_LOGIN_ID." ".AUTHORIZENET_TRANSACTION_KEY;*/
		}

    }

    /* Redix Group 05/09/2014 */
    function send_payment(){
/*$_POST::Array
(
    [ccu_name] => Gil Bar-Lev
    [ccu_exp_month] => 3
    [ccu_exp_year] => 2016
    [cc] => 38
    [billing] => 73
    [shipping_info] => 0
    [receiver_name] => Araceli Lesko
    [country] => 236
    [add1] => 4928 Zambrano St
    [add2] =>
    [city] => Commerce California, 90040
    [prov] => Alabama
    [postal] => 90040
    [phone_num] => 2134449078
    [phone_ext] =>
    [email] => sizredix@gmail.com
)*/
       // DebToFile('$_POST::'.print_r($_POST,true));
        $price = $this->input->post('amt');
        $card_num = $this->input->post('ccu_number');
        $cvv = $this->input->post('ccv');
        $name = $this->input->post('ccu_name');
        $name = explode(" ", $name);
        $last_name = array_pop($name);
        $first_name = implode(" ", $name);
        $exp_month = $this->input->post('ccu_exp_month');
        if (strlen($exp_month)==1) {$exp_month = '0'.$exp_month;}
        $exp_year = $this->input->post('ccu_exp_year');
        $exp_year = substr($exp_year,-2);
        $exp_date = $exp_month."/".$exp_year;
        $city = $this->input->post('city');
        $prov = $this->input->post('prov');
        $country = $this->input->post('country');
        $zip = $this->input->post('postal');
        $add = $this->input->post('add1');
        $add .= $this->input->post('add2');
        $email = $this->input->post('email');

        /*print_r($exp_date);*/

        $amount = number_format($price,2);
        /*DebToFile('++++++::'.print_r(array(
                'amount' => $amount,
                'card_num' => $card_num,
                'card_code' => $cvv,
                'exp_date' => $exp_date,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'address' => $add,
                'city' => $city,
                'state' => $prov,
                'country' => $country,
                'zip' => $zip,
                'email' => $email,
            ),true)); */

        $this->authorizenet->setFields(
            array(
                'amount' => $amount,
                'card_num' => $card_num,
                'card_code' => $cvv,
                'exp_date' => $exp_date,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'address' => $add,
                'city' => $city,
                'state' => $prov,
                'country' => $country,
                'zip' => $zip,
                'email' => $email,
                )
            );
        $response = $this->authorizenet->authorizeOnly();
	//$response = array("approved"=>1,"response_reason_text"=>"test mess");
        //DebToFile('$response::'.print_r($response,true));
        $response = json_encode($response);
        echo $response;
    }


    function detail(){
	$id = $this->input->get('id');

	$authorizenetmytd = new AuthorizeNetTD;

        $response = $authorizenetmytd->getTransactionDetails($id);
        //$response = $authorizenetmytd->getUnsettledTransactionList();

        //DebToFile('$response::'.print_r($response,true));
        //$response = json_encode($response);
	echo $response->response;
        //var_dump($response);
    }


    /*function send_payment()
    {
        if ($this->session->userdata('is_login') == TRUE)
        {
            $user_type = $this->session->userdata('type');
            if ($user_type == 1) //administrator
            {
                $bank_id = $this->input->post('bnk');
                $amount = $this->input->post('total_payment');
                $supplier_id = $this->input->post('supplier_id');
                $sup_info = $this->suppliers->supplierinfo($supplier_id);

                $bnk_detail = $this->banks->get($bank_id);


                $bank_aba_code = $bnk_detail->bnk_id_code;
                $bank_acct_num = $bnk_detail->bnk_account;
                $bank_acct_type = "SAVINGS"; //CHECKING, BUSINESSCHECKING, SAVINGS
                $bank_name = $bnk_detail->bnk_name;
                $bank_acct_name = $bnk_detail->bnk_owner;


                $feild_setting = array(
                    'amount' => $amount,
                    'first_name' => $sup_info->u_fname,
                    'last_name' => $sup_info->u_lname,
                    'address' => '',
                    'email' => $sup_info->u_email,
                    'method' => 'echeck', // for echeck method
                    'bank_aba_code' => $bank_aba_code,
                    'bank_acct_num' => $bank_acct_num,
                    'bank_acct_type' => "CHECKING",
                    'bank_name' => $bank_name,
                    'bank_acct_name' => $bank_acct_name,
                    'echeck_type' => 'WEB',
                    );
                $this->authorizenet->setECheck($bank_aba_code, $bank_acct_num, $bank_acct_type, $bank_name, $bank_acct_name, $echeck_type = 'WEB');

                $this->authorizenet->setFields($feild_setting);

                $response = $this->authorizenet->authorizeAndCapture();

                /*print_r($feild_setting);
                echo "<br/><br/>";
                print_r($response);*/

                /*if ($response->approved) {


                    $data_insert_payment = array('asp_amount' => $amount,
                                                  'u_id' => $supplier_id,
                                                  'bnk_id' => $bank_id,
                                                  'asp_date' => time(),
                                                  'asp_auth_respond' => json_encode($response),
                                                  'asp_value_send' => json_encode($feild_setting));

                    $data_result = $this->administrators->record_admin_payment($data_insert_payment);

                    $transaction_list = $this->suppliers->supplier_sales_detail($supplier_id); //get all approved list and update the status, completed

                    foreach($transaction_list as $trans)
                    {
                        $array = array('bsd_reason' => "Completed", 'bsd_status' => 2); //2 for completed transaction
                        $result = $this->suppliers->update_buyer_supplier_detail($array,'bsd_id', $trans->bsd_id);
                    }

                    echo "approved";
                } else {
                    echo "DENIED: PLEASE CONTACT THE SUPPLIER FOR THE BANK ACCOUNT INFORMATION";
                }
            }
        }
    }*/
}


function DebToFile($contents, $IsClearText= false, $FileName= '') {
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