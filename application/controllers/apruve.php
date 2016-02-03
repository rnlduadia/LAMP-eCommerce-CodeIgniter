<?php


class Apruve extends CI_Controller
{
	private $test = false;
	private $api_key = "75e43864739e8b9363e5af65b159f63a";
	private $_version = "v3";
	private $statuses = array('pending' => 1, 'captured' => 2, 'rejected' => 10, 'authorized' => 2);

	public function setTransactionOrder()
	{
		$this->load->model('apruve_requests');
		$transactionId = $this->input->post('transaction_id');
		$orderId = $this->input->post('order_id');

		$request = $this->apruve_requests->get($transactionId);

		if($request) {
			$this->apruve_requests->update($transactionId, array('bt_id' => $orderId));
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	public function confirm()
	{
		$this->load->model('apruve_requests');
		$requestId = $this->input->post('request_id');
		$orderId = $this->input->post('order_id');

		$request = $this->apruve_requests->get($orderId);

		$res = $this->sendRequest($requestId, $request->total_cents);

		if($res) {
			$this->apruve_requests->update($orderId, array('status' => 1, 'request_id' => $requestId));
		}

		echo json_encode(array('success' => $res));
	}

	public function callback()
	{
		$this->load->model('apruve_requests');
		$this->load->model('buyers');
		$data = file_get_contents("php://input");
		$data = json_decode($data, true);
		$payment = $data['payment_request_id'];

		$request = $this->apruve_requests->get_by_request_id($payment);
		if(!$request) {
			return;
		}
		file_put_contents(dirname(__FILE__) . "/test.log", $content);
		if($data['status']) {
			$this->apruve_requests->update($request->id, array('status' => $this->statuses[$data['status']]));
		}

		if($request->bt_id) {
			if($data['status'] == 'rejected') {
				$this->buyers->update_transaction(array('status' => -1), 'bt_id', $request->bt_id);
				$this->buyers->update_buyer_supplier_detail(array('status' => -1, 'bsd_reason' => 'Payment Rejected'), 'bt_id', $request->bt_id);
			}

			if($data['status'] == 'captured' || $data['status'] == 'authorized') {
				$this->buyers->update_transaction(array('status' => 0), 'bt_id', $request->bt_id);
				$this->buyers->update_buyer_supplier_detail(array('status' => 0, 'bsd_reason' => 'Pending'), 'bt_id', $request->bt_id);
			}
		}
	}

	protected function sendRequest($paymentRequestId, $amount)
	{
		$data = json_encode(array('amount_cents' => $amount, 'currency' => 'USD'));
		$url = $this->_getPaymentUrl($paymentRequestId);
        $c = curl_init($url);

        curl_setopt($c, CURLOPT_HTTPHEADER, $this->_getHeaders());
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($c, CURLOPT_HEADER, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data );
        $response = curl_exec($c);
        $http_status = curl_getinfo($c, CURLINFO_HTTP_CODE);
        curl_close($c);

        if($http_status == '201') {
            return true;
        } else {
            return false;
        }
	}

	protected function _getPaymentUrl($paymentRequestId)
    {
        return $this->getBaseUrl(true).$this->_getApiUrl().'payment_requests/'.$paymentRequestId.'/payments';
    }

    protected function _getHeaders()
    {
        return array(
            'Content-type: application/json',
            'Apruve-Api-Key: ' . $this->api_key,
        );
    }

    protected function _convertPrice($price)
    {
        return $price * 100;
    }

    public function getBaseUrl($secure = false)
    {
        $http = $secure ? 'https://' : 'http://';
        if($this->test) {
            return $http.'test.apruve.com/';
        } else {
            return $http.'www.apruve.com/';
        }
    }

    protected function _getApiUrl()
    {
        return 'api/'.$this->_version.'/';
    }

    public function hash()
    {
    	if($this->session->userdata('is_login') == TRUE) {
	    	$this->load->model('apruve_requests');
	    	$items = array();
	    	$total =  0;
	    	$widget_data = "";
	    	foreach($this->cart->contents() as $item) {
				$i = array(
					'title' => $item['name'],
					'amount_ea_cents' => ($item['options']['ship_cost'] + $item['price']) * 100, 
					'amount_cents' => ($item['options']['ship_cost'] + $item['subtotal']) * 100,
					'quantity' => $item['qty']
				);
				$items[] = $i;
				$widget_data .= implode("", array_values($i));
				$total = (int)$total + (int)$i['amount_cents'];
			}

			$requestId = $this->apruve_requests->add(array('user_id' => $this->session->userdata('id'), 'status' => 0, 'total_cents' => $total));


			$data['request'] = array(
				  "merchant_id" => "345e1c6d8cd3d05299b701ec6b10e141",
				  "merchant_order_id" => $requestId,
				  "amount_cents" => $total ,
				  "currency" => "USD",
			);

			$request = implode("", array_values($data['request']));

			$data['request']['line_items'] = $items;

			$order_data = "75e43864739e8b9363e5af65b159f63a{$request}{$widget_data}";
			$data['hash'] = hash("sha256", $order_data);
			$data['success'] = true;
			echo json_encode($data);
    	} else {
    		redirect('/');
    	}
    }
}