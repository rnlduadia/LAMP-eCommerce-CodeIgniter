<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class cart extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('suppliers');
        $this->load->model('inventories');
        $this->load->model('buyers');
        $this->load->model('users');
        $this->load->model('countries');
        $this->load->model('brands');
        $this->load->model('categories');
        $this->load->model('manufacturers');
    }

    public function index() {
        $data['feat_categories'] = $this->categories->listings(0); //main categories
        $data['left_categories'] = $this->categories->listings(0); //main categories
        $data['cart'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        $data['login'] = false;

        $data['categories'] = array(); //main categories
        $data['brands'] = array();
        $data['manus'] = array();

        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type'); //get user type;
            $id = $this->session->userdata('id');
            if ($user_type == 3) { //buyer
                $data['login'] = true;
            } elseif ($user_type == 2) { //supplier
                redirect('', 'refresh');
            }
        }

        $data['brands'] = $this->brands->listing();
        $data['user'] = $this->users->info($this->session->userdata['id']);
        $this->load->view('view-cart', $data);
    }

    function add() {
        $ic_id = $this->input->post('icid');
        $quan = $this->input->post('quan');
//		$ic_id  = $this->input->get('icid');
//		$quan  = $this->input->get('quan');
        $ic = $this->suppliers->detail_child_inventory($ic_id);
        $ic->tr_title = $ic->tr_title == '' ? 'title' : $ic->tr_title;
//$cp = $ic->ic_case_pack != null ? $ic->ic_case_pack : 1;
        $orderCount = $quan;
        if ($orderCount < $ic->ic_min_order) {
            echo json_encode(array('error' => 'Min order:' . $ic->ic_min_order));
            return;
        }
        $rem_qty = $this->suppliers->get_child_remaining_quan($ic->ic_id, $ic->ic_quan);
        if ($quan > $rem_qty) {
            echo json_encode(array('error' => 'Available quantity of this product is ' . $rem_qty . '. Please update the quantity and then click on add to cart'));
            return;
        }

        // check If qty >= Stock Min QTY , the price should be Stock Price.
        if ($quan >= $ic->ic_minStockQTYTier1 && $ic->ic_stockPriceTier1 > 0)
            $cart_item_price = (floatval($ic->ic_stockPriceTier1));
        else
            $cart_item_price = (floatval($ic->ic_price));

        $data = array(
            'id' => $ic->ic_id,
            'tot_qty' => $ic->ic_quan,
            'qty' => $quan,
            'price' => $cart_item_price,
            'name' => preg_replace('/[^\,\(\)\"\'\.\:\-_ a-zA-Z0-9]/', '', $ic->tr_title),
            'options' => array('ship_cost' => $ic->ic_ship_cost, 'fee' => $ic->c_feePercent, 'i_id' => $ic->i_id, 'shipping_cost' => $ic->ship_cost, 'ship_cost_per_item' => $ic->ship_cost_per_item, 'ic_minStockQTYTier1' => $ic->ic_minStockQTYTier1, 'ic_stockPriceTier1' => $ic->ic_stockPriceTier1, 'normal_price'=>(floatval($ic->ic_price)))
        );

        $this->cart->product_name_rules = '\,\(\)\"\'\.\:\-_ a-zA-Z0-9';
        $this->cart->insert($data);
        foreach ($this->cart->contents() as $items) {
            if ($items['id'] == $ic->ic_id)
                $tot_it_add = $items['qty'];
        }
        echo json_encode(array('rem_qty' => $rem_qty, 'total_item' => $this->cart->total_items(), 'total_item_add' => $tot_it_add));
    }

    function update() {
        $action = $this->uri->segment(3); //action

        if ($action == 'qty') {
            $qty = $this->input->post('qty');
            $rid = $this->input->post('rid');
            $i_id = $this->input->post('i_id');
            $totqty = $this->input->post('totqty');
            $rem_qty = $this->suppliers->get_child_remaining_quan($i_id, $totqty);

            $product_options = $this->cart->product_options($rid);
            if ($qty >= $product_options['ic_minStockQTYTier1'] && $product_options['ic_stockPriceTier1'] > 0) {
                $data = array(
                    'rowid' => $rid,
                    'qty' => $qty,
                    'price' => $product_options['ic_stockPriceTier1']
                );
            } else {
                $data = array(
                    'rowid' => $rid,
                    'qty' => $qty,
                    'price' => $product_options['normal_price']
                );
            }


            if ($qty <= $rem_qty) {
                $this->cart->update($data);
                echo json_encode(array("flag" => 1, 'rem_qty' => $rem_qty));
            } else {
                echo json_encode(array("flag" => 0, 'rem_qty' => $rem_qty));
            }
        }
    }

    function empty_cart() {
        $this->cart->destroy();
        redirect('cart', 'refresh');
    }

}
