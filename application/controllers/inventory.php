<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class inventory extends CI_Controller
{
    var $sort_byinventories_outoput= '';
    var $sort_direction_byinventories_outoput= '';

    function __construct()
    {
        parent::__construct();
        $this->load->model('users');
        $this->load->model('manufacturers');
        $this->load->model('inventories');
        $this->load->model('categories');
        $this->load->model('countries');
        $this->load->model('suppliers');
        $this->load->model('brands');
        $this->load->model('administrators');
        $this->load->library('apputils'); // load library with ConvertUnStampToMysqlDateTime function
        $this->load->library('pagination');
    }

    public function index()
    {
        if ($this->session->userdata('is_login') == TRUE) {
            $data['feat_categories'] = $this->categories->listings(0); //main categories
            $user_type = $this->session->userdata('type'); //get user type;
            if ($user_type == 1) //1 is admin, 2 supplier
            {
                $data['list_manufac'] = $this->manufacturers->listing();
                $data['categories'] = $this->categories->listings();

                $inventory = $this->inventories->listings();
                $data['inventory_pagination'] = $inventory['pagination'];
                $data['inventory'] = $inventory['result'];

                $this->load->view('admin/inventory/inventory-page', $data);
            }
            elseif ($user_type == 2) //Intended for Supplier
            {
                $id = $this->session->userdata('id');
                $data['info'] = $this->users->info($id);
                //$data['inventories'] = $this->suppliers->child_list($id); //used ajax not load here go to search()
                $this->load->view('supplier/supplier-home-inventory', $data);
            }
        } else
            redirect('', 'refresh');
    }

    function search()
    {
        $search_type = $this->uri->segment(3);
        $sort_by = $this->input->post('sort_by');
        $sort_direction = $this->input->post('sort_direction');

        // listings($name = '', $manu = '', $brand = '', $sku = '', $upc_ean = '', $manunum = '', $ic_quan_zero= false)
        $data['left_categories'] = $this->categories->listings(0, '', '', '', '', '', true); // categories + subcategories
        $data['feat_categories'] = $this->categories->listings(0, '', '', '', '', '', true); //main categories
        $this->load->library('pagination');

        if ($search_type == 'supplier_search_add') //searching product in adding product process for supplier
        {
            $search_prod = $this->input->post('search_prod');

            $data['products'] = $this->inventories->search_forAddProduct($search_prod, false, true);

            $result_html = $this->load->view('supplier/searched-add-product', $data, TRUE);
            echo $result_html;

        } elseif ($search_type == 'quick') //loading result in the left sidebar in dropdown search
        {
            $prod_search = $this->input->post('val');
            $search_result = $this->inventories->search_forAddProduct($prod_search, true, true); //only get the title of the product

            $data['product'] = $search_result;
            $result_html = $this->load->view('search-sidebar-product-result', $data, TRUE);
            echo $result_html;
            /*echo '<pre>';print_r($data);echo '</pre>';*/
        } elseif ($search_type == 'product') {
            $search_via_link = urldecode($this->uri->segment(4));

            $action = $this->input->post('action');
            if ($action != '') //loading the data or other method that will be used in the future
            {
                if ($action == 'get') //getting all the result value
                {
                    $cat = $this->input->post('cat');
                    $manu = $this->input->post('manu');
                    $from = $this->input->post('from');
                    $to = $this->input->post('to');
                    $supplier = $this->input->post('supplier');

                    // function search_forProductSearch($search_value, $only_product_name = false, $cats, $manus, $from, $to, $supplier = "", $num = 10000, $offset = 0, $ic_quan_zero= false)
                    $all = $this->inventories->search_forProductSearch($search_via_link, false, $cat, $manu, $from, $to, $supplier, 10000, 0, true); //only get the title of the product

                    $config = $this->get_pagination_config('inventory/search/product/' . $search_via_link . '/', sizeof($all));
                    $this->pagination->initialize($config);

                    $data['inventories'] = $this->inventories->search_forProductSearch($search_via_link, false, $cat, $manu, $from, $to, $supplier, $config['per_page'], $this->uri->segment(5), true); //only get the title of the product

                    $result_html = $this->load->view('sidebar-product-result', $data, TRUE);
                    echo $result_html;
                    echo $this->pagination->create_links();

                }
            } else {
                $data['categories'] = $this->categories->listings_by_product($search_via_link); //main categories
                $data['manus'] = $this->manufacturers->listings_by_product($search_via_link);
                $data['search_page'] = false;
                $data['search_name'] = $search_via_link;
                $data['search_price_from'] = '';
                $data['search_price_to'] = '';
                $data['suppliers'] = $this->suppliers->listing(1);
                $page = '/';
                if (strpos($this->uri->segment(5), '?') === false && intval($this->uri->segment(5)) > 0) {
                    $page = '/' . $this->uri->segment(5);
                }
                $data['dym_link'] = base_url() . 'inventory/search/product/' . $search_via_link . $page;
                $data['random_products'] = $this->suppliers->get_random_products();
                $this->load->view('search-sidebar-result-page', $data);

            }


        } elseif ($search_type == 'supplier') {
            $search_via_link = urldecode($this->uri->segment(4));


            $action = $this->input->post('action');
            if ($action != '') //loading the data or other method that will be used in the future
            {
                if ($action == 'get') //getting all the result value
                {
                    $cat = $this->input->post('cat');
                    $manu = $this->input->post('manu');
                    $from = $this->input->post('from');
                    $to = $this->input->post('to');
                    $supplier = $this->input->post('supplier');
                    if (!$supplier) $supplier = $search_via_link;

                    $all = $this->inventories->search_forProductSearch('', false, $cat, $manu, $from, $to, $supplier, 10000, 0, true); //only get the title of the product
                    $config = $this->get_pagination_config('inventory/search/supplier/' . $supplier . '/', sizeof($all));
                    $this->pagination->initialize($config);

                    $data['inventories'] = $this->inventories->search_forProductSearch('', false, $cat, $manu, $from, $to, $supplier, $config['per_page'], $this->uri->segment(5), true); //only get the title of the product
                    $result_html = $this->load->view('sidebar-product-result', $data, TRUE);
                    echo $result_html;
                    echo $this->pagination->create_links();

                }
            } else {
                $data['categories'] = $this->categories->listings_by_product($search_via_link); //main categories
                $data['manus'] = $this->manufacturers->listings_by_product($search_via_link);
                $data['search_page'] = false;
                $data['search_name'] = $search_via_link;
                $data['search_supplier_products'] = $this->suppliers->supplierinfo($search_via_link)->u_company;
                $data['search_price_from'] = '';
                $data['search_price_to'] = '';
                $data['suppliers'] = $this->suppliers->listing(1);
                $page = '/';
                if (strpos($this->uri->segment(5), '?') === false && intval($this->uri->segment(5)) > 0) {
                    $page = '/' . $this->uri->segment(5);
                }
                $data['dym_link'] = base_url() . 'inventory/search/supplier/' . $this->uri->segment(4) . $page;
                $data['random_products'] = $this->suppliers->get_random_products();
                $this->load->view('search-sidebar-result-page', $data);

            }


        } elseif ($search_type == 'price') {
            $search_via_link = '';
            $from = $this->uri->segment(4);
            $to = $this->uri->segment(5);
            $action = $this->input->post('action');
            if ($action != '') //loading the data or other method that will be used in the future
            {
                if ($action == 'get') //getting all the result value
                {
                    $cat = $this->input->post('cat');
                    $manu = $this->input->post('manu');
                    $from = $this->input->post('from');
                    $to = $this->input->post('to');
                    $supplier = $this->input->post('supplier');
                    // function search_forProductSearch($search_value, $only_product_name = false, $cats, $manus, $from, $to, $supplier = "", $num = 10000, $offset = 0, $ic_quan_zero= false)
                    $data['inventories'] = $this->inventories->search_forProductSearch($search_via_link, false, $cat, $manu, $from, $to, $supplier, '', '', true); //only get the title of the product
                    $result_html = $this->load->view('sidebar-product-result', $data, TRUE);
                    echo $result_html;
                }
            } else {

                $data['categories'] = $this->categories->listings_by_product($search_via_link); //main categories
//				$data['manus'] = $this->manufacturers->listings_by_product($search_via_link);
                $data['search_page'] = true;
                $data['suppliers'] = $this->suppliers->listing(1);
                $data['search_name'] = $search_via_link;
                $data['search_price'] = '$' . $from . ' ~ $' . $to;
                $data['search_price_from'] = $from;
                $data['search_price_to'] = $to;
                if ($from != '' && $to != '')
                    $added_price_search = '/' . $from . '/' . $to;
                else
                    $added_price_search = '';

                $data['only_price'] = true; // has to be removed in the future
                $data['dym_link'] = base_url() . 'inventory/search/price/' . $added_price_search;
                $data['random_products'] = $this->suppliers->get_random_products();
                $this->load->view('search-sidebar-result-page', $data);
            }


        } elseif ($search_type == 'brand') {
            $action = $this->input->post('action');
            if ($action != '') //loading the data or other method that will be used in the future
            {
                if ($action == 'get') //getting all the result value
                {
                    $cat = $this->input->post('cat');
                    $manu = $this->input->post('manu');
                    $brand_search = urldecode($this->uri->segment(4));

                    // function searchProductCustom($search_value, $type, $num = 10000, $offset = 0, $ic_quan_zero= false)
                    $all = $this->inventories->searchProductCustom($brand_search, 'brand', 10000, 0, true); //only get the title of the product
                    $config = $this->get_pagination_config('inventory/search/brand/' . $brand_search . '/', sizeof($all));
                    $this->pagination->initialize($config);

                    $data['inventories'] = $this->inventories->searchProductCustom($brand_search, 'brand', $config['per_page'], $this->uri->segment(5), true
                    ); //only get the title of the product
                    $result_html = $this->load->view('sidebar-product-result', $data, TRUE);
                    echo $result_html;
                    echo $this->pagination->create_links();
                }
            } else {
                $brand_search = urldecode($this->uri->segment(4));
                $data['categories'] = $this->categories->listings_by_product($brand_search); //main categories
                $data['manus'] = $this->manufacturers->listings_by_product($brand_search);
                $data['search_page'] = true;
                $data['search_name'] = $brand_search;
                $data['suppliers'] = $this->suppliers->listing(1);
                $data['search_type'] = $search_type;
                $data['random_products'] = $this->suppliers->get_random_products();
                $page = '/';
                if (strpos($this->uri->segment(5), '?') === false && intval($this->uri->segment(5)) > 0) {
                    $page = '/' . $this->uri->segment(5);
                }
                $data['dym_link'] = base_url() . 'inventory/search/brand/' . $brand_search . $page;
                $this->load->view('search-sidebar-result-page', $data);
            }
        } elseif ($search_type == 'mf') {
            $action = $this->input->post('action');
            if ($action != '') //loading the data or other method that will be used in the future
            {
                if ($action == 'get') //getting all the result value
                {
                    $cat = $this->input->post('cat');
                    $manu = $this->input->post('manu');
                    $mf_search = urldecode($this->uri->segment(4));

                    $all = $this->inventories->searchProductCustom($mf_search, 'mf', 10000, 0, true); //only get the title of the product
                    $config = $this->get_pagination_config('inventory/search/mf/' . $mf_search . '/', sizeof($all));
                    $this->pagination->initialize($config);

                    $data['inventories'] = $this->inventories->searchProductCustom($mf_search, 'mf', $config['per_page'], $this->uri->segment(5), true
                    ); //only get the title of the product
                    $result_html = $this->load->view('sidebar-product-result', $data, TRUE);
                    echo $result_html;
                    echo $this->pagination->create_links();
                }
            } else {
                $mf_search = urldecode($this->uri->segment(4));
                $data['categories'] = $this->categories->listings_by_product($mf_search); //main categories
                $data['manus'] = $this->manufacturers->listings_by_product($mf_search);
                $data['search_page'] = true;
                $data['search_name'] = $mf_search;
                $data['suppliers'] = $this->suppliers->listing(1);
                $data['search_type'] = $search_type;
                $page = '/';
                if (strpos($this->uri->segment(5), '?') === false && intval($this->uri->segment(5)) > 0) {
                    $page = '/' . $this->uri->segment(5);
                }
                $data['dym_link'] = base_url() . 'inventory/search/mf/' . $mf_search . $page;
                $data['random_products'] = $this->suppliers->get_random_products();
                $this->load->view('search-sidebar-result-page', $data);
            }
        } else //this is for the admin or Supplier
        {
            $user_type = $this->session->userdata('type'); //get user type;
            if ($user_type == 1) //1 is admin
            {
                $name = $this->input->post('name');
                $manu = $this->input->post('manu');
                $brand = $this->input->post('brand');
                $sku = $this->input->post('sku');
                // listings($name = '', $manu = '', $brand = '', $sku = '', $upc_ean = '', $manunum = '', $ic_quan_zero= false)

                $inventory = $this->inventories->listings($name, $manu, $brand, $sku, '', '', true);
                $data['inventory'] = $inventory['result'];
                $data['pagination'] = $inventory['pagination'];

                //echo "<pre>";print_r($data['inventory']);exit;
                $result_html = $this->load->view('admin/inventory/search-result-table', $data, TRUE);
                echo $result_html;
            } elseif ($user_type == 2) // 2 supplier
            {
                $page = (int)$this->input->get('page');
                $page = $page > 0 ? $page : 1;
				$sort_direction = ($sort_direction != '') ? $sort_direction : 'desc';
				$sort_by = ($sort_by != '') ? $sort_by : 'i_id';
	            $i_id = $this->input->post('i_id');
                $name = $this->input->post('name');
                $manu = $this->input->post('manu');
                $brand = $this->input->post('brand');
                $sku = $this->input->post('sku');

                $id = $this->session->userdata('id');
                $rowsCount= count($this->suppliers->child_list($id, $name, $manu, $brand, $sku, '', 25, $sort_by, $sort_direction, $i_id));
                $items = $this->suppliers->child_list($id, $name, $manu, $brand, $sku, $page, 25 , $sort_by, $sort_direction, $i_id);

                $output = array();
                foreach ($items as $item) {
                    $item->remaining_quantity = $this->suppliers->get_child_remaining_quan($item->ic_id, $item->ic_quan);
                    $item->ic_time = date('m/d/Y h:i:s A T', strtotime($item->ic_time));
                    // $item->date = apputils::ShowFormattedDateTime( $item->ic_time, 'Common' ); //date('m/d/Y h:i:s A T', strtotime($item->ic_time));
                    $item->date_unix = strtotime($item->ic_time);
		    		$item->ic_price = number_format($item->ic_price,2);
		    		$item->ic_retail_price = number_format($item->ic_retail_price,2);
                    $item->tr_title = htmlentities($item->tr_title,ENT_SUBSTITUTE,"ISO8859-15");
                    $output[] = $item;
                }
                $this->sort_byinventories_outoput= (!empty($sort_by))?$sort_by:'i_id';
                $this->sort_direction_byinventories_outoput= (!empty($sort_direction))?$sort_direction:'desc';

                //uasort( $output, array($this, 'inventories_outoput_sort') );
                $sorted_array= array();
                foreach( $output as $item ) {
                    $sorted_array[] = $item;
                }

                $filters_data['filters'] = array(
	                'i_id' => array('title'=>'OCID','value'=>$i_id),
                    'name' => array('title'=>'Product Name','value'=>$name),
                    'manu' => array('title'=>'Manufacturer','value'=>$manu),
                    'brand' => array('title'=>'Brand','value'=>$brand),
                    'sku' => array('title'=>'SKU','value'=>$sku)
                );

                $data['items'] = $sorted_array;
                $data['columns'] = array(
	                'cb' => array(
		                        'pk'=>'i_id',
		                        'actions' => array(
				                    'delete' => array('link'=>'/inventory/delete/', 'text'=> 'Delete', 'confirm'=>'Delete selected inventories?'),
		                        ),
	                        ),
                    'i_id' => array('title'=>'OCID','sortable'=>true, 'link'=>'/inventory/detail/'),
                    'tr_title' => array('title'=>'Title','sortable'=>true),
                    'SKU' => array('title'=>'SKU','sortable'=>true),
                    'ic_quan' => array('title'=>'Quantity','sortable'=>true),
                    'ic_price' => array('title'=>'Price','sortable'=>true),
                    'ic_retail_price' => array('title'=>'MSRP','sortable'=>true),
                    'ic_time' => array('title'=>'Time Posted','sortable'=>true),
                    'actions' => array(
                        'title'=>'Action',
                        'sortable'=>false,
                        'items'=>array(
                            'update' => array('link'=>'/inventory/update/', 'text'=> 'Update', 'confirm'=>false, 'pk'=>'i_id'),
                            'delete' => array('link'=>'/inventory/delete/', 'text'=> 'Delete', 'confirm'=>'Delete this inventory?', 'pk'=>'i_id'),
                        )
                    ),
                );
                $data['sorter']['by'] = $this->sort_byinventories_outoput;
                $data['sorter']['dir'] = $this->sort_direction_byinventories_outoput;

                $config['base_url'] = '/inventory/search?';
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
        }
    }

    function inventories_outoput_sort($a, $b) {

        if ( $this->sort_byinventories_outoput == 'i_id' ) {
            if ($a->i_id == $b->i_id) {
                return 0;
            }
            if ( empty($this->sort_direction_byinventories_outoput) or $this->sort_direction_byinventories_outoput == 'asc' ) {
                return ($a->i_id < $b->i_id) ? -1 : 1;
            }   else {
                return ($a->i_id < $b->i_id) ? 1 : -1;
            }
        }
        if ( $this->sort_byinventories_outoput == 'tr_title' ) {
            if ($a->tr_title == $b->tr_title) {
                return 0;
            }
            if ( empty($this->sort_direction_byinventories_outoput) or $this->sort_direction_byinventories_outoput == 'asc' ) {
                return ($a->tr_title < $b->tr_title) ? -1 : 1;
            } else {
                return ($a->tr_title < $b->tr_title) ? 1 : -1;
            }
        }

        if ( $this->sort_byinventories_outoput == 'SKU' ) {
            if ($a->SKU == $b->SKU) {
                return 0;
            }
            if ( empty($this->sort_direction_byinventories_outoput) or $this->sort_direction_byinventories_outoput == 'asc' ) {
                return ($a->SKU < $b->SKU) ? -1 : 1;
            } else {
                return ($a->SKU < $b->SKU) ? 1 : -1;
            }
        }
        if ( $this->sort_byinventories_outoput == 'ic_quan' ) {
            if ($a->ic_quan == $b->ic_quan) {
                return 0;
            }
            if ( empty($this->sort_direction_byinventories_outoput) or $this->sort_direction_byinventories_outoput == 'asc' ) {
                return ($a->ic_quan < $b->ic_quan) ? -1 : 1;
            } else {
                return ($a->ic_quan < $b->ic_quan) ? 1 : -1;
            }
        }
        if ( $this->sort_byinventories_outoput == 'ic_price' ) {
            if ($a->ic_price == $b->ic_price) {
                return 0;
            }
            if ( empty($this->sort_direction_byinventories_outoput) or $this->sort_direction_byinventories_outoput == 'asc' ) {
                return ($a->ic_price < $b->ic_price) ? -1 : 1;
            } else {
                return ($a->ic_price < $b->ic_price) ? 1 : -1;
            }
        }
        if ( $this->sort_byinventories_outoput == 'ic_retail_price' ) {
            if ($a->ic_retail_price == $b->ic_retail_price) {
                return 0;
            }
            if ( empty($this->sort_direction_byinventories_outoput) or $this->sort_direction_byinventories_outoput == 'asc' ) {
                return ($a->ic_retail_price < $b->ic_retail_price) ? -1 : 1;
            } else {
                return ($a->ic_retail_price < $b->ic_retail_price) ? 1 : -1;
            }
        }

        if ( $this->sort_byinventories_outoput == 'ic_time' ) {
            if ( $a->date_unix == $b->date_unix ) {
                return 0;
            }
            if ( empty($this->sort_direction_byinventories_outoput) or $this->sort_direction_byinventories_outoput == 'asc' ) {
                return ($a->date_unix < $b->date_unix) ? -1 : 1;
            } else {
                return ($a->date_unix < $b->date_unix) ? 1 : -1;
            }
        }
    }


    function get_pagination_config($url, $num_rows)
    {

        $config['base_url'] = base_url() . $url;
        $config['per_page'] = '9';

        $config['full_tag_open'] = '<div class=\'navi-feat-wrapper\'><div class=\'navi-feat\'>';
        $config['full_tag_close'] = '</div></div>';

        $config['first_link'] = '';
        $config['last_link'] = '';

        $config['next_link'] = '&nbsp';
        $config['next_tag_open'] = '<div class=\'right-navi\'>';
        $config['next_tag_close'] = '</div>';

        $config['prev_link'] = '&nbsp';
        $config['prev_tag_open'] = '<div class=\'left-navi\'>';
        $config['prev_tag_close'] = '</div>';

//		$config['display_pages'] = FALSE;

        $config['num_tag_open'] = '<div class=\'num-tag\'>';
        $config['num_tag_close'] = '</div>';

        $config['total_rows'] = $num_rows;
        $config['uri_segment'] = 5;

        return $config;
    }

    function save_category_search()
    {
        $cat = $this->input->post('selected_category');

        $catdata = array(
            'category_search' => $cat,
        );

        $this->session->set_userdata($catdata);
    }

    function save_manu_search()
    {
        $manu = $this->input->post('selected_manu');

        $manudata = array(
            'manu_search' => $manu,
        );

        $this->session->set_userdata($manudata);
        echo print_r($manu);$data['search_price'];
    }

    function add()
    {

        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type'); //get user type;
            $uid = $this->session->userdata('id');
            if ($this->input->post('action') != "") {
                $action = $this->input->post('action');
                if ($action == 'add') //if adding inventory
                {

                    $upc_ean = $this->input->post('upc_ean');
                    $manu_num = $this->input->post('manu_num');
                    $manu = $this->input->post('manu');
                    $brand = $this->input->post('brand');
                    $weight = $this->input->post('weight');
                    $weight_scale = $this->input->post('weight_scale');
                    //$item_price = $this->input->post('item_price');
                    $ship_alone = $this->input->post('ship_alone');
                    $height = $this->input->post('height');
                    $width = $this->input->post('width');
                    $depth = $this->input->post('depth');
                    $d_scale = $this->input->post('d_scale');
                    $category = $this->input->post('category');

                    $case_pack = $this->input->post('case_pack');
                    $min_order = $this->input->post('min_order');

                    $this->load->library('form_validation');

                    if ($user_type == 2) //IF USER TYPE IS SUPPLIER, ADD INFORMATION FOR INVENTORY CHILD
                    {
                        $sku = $this->input->post('sku');
                        $quan = $this->input->post('quan');
                        $price = $this->input->post('price');
                        $ret_price = $this->input->post('ret_price');
                        
                        $ret_price = (trim($ret_price)=='' || $ret_price==0) ? ($price*3) : $ret_price;
                        
                        $lead_time = $this->input->post('lead_time');
                        $map = $this->input->post('map');
                        $ship_cost = ($this->input->post('ship_cost')=='') ? null :$this->input->post('ship_cost');
                        $ship_from = $this->input->post('ship_from');
                        $prom_text = $this->input->post('prom_text');

                        $this->form_validation->set_rules('sku', 'SKU', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('quan', 'Quantity', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('price', 'Price', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('ret_price', 'Retailed Price', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('lead_time', 'Lead Time', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('map', 'MAP', 'trim|xss_clean');
                    }

                    $this->form_validation->set_rules('upc_ean', 'UPC/EAN', 'trim|required|min_length[5]|numeric|xss_clean');
                    $this->form_validation->set_rules('manu_num', 'Manufacturer Part Number', 'trim|required|min_length[3]|xss_clean');
                    $this->form_validation->set_rules('manu', 'Manufacture', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('brand', 'Brand', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('weight', 'Weight', 'trim|required|xss_clean|numeric');
                    $this->form_validation->set_rules('weight_scale', 'Weight Scale', 'trim|required|xss_clean');
                    $this->form_validation->set_message('min_length', 'The %s must be at least %s characters long');

                    //$this->form_validation->set_rules('item_price','Item Price','trim|required|xss_clean|numeric');

                    $this->form_validation->set_rules('ship_alone', 'Ship Alone', 'trim|required|xss_clean');
                    //$this->form_validation->set_rules('height','Height','trim|required|xss_clean');
                    //$this->form_validation->set_rules('width','Width','trim|required|xss_clean');
                    //$this->form_validation->set_rules('depth','Depth','trim|required|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        //If has invalid input
                        $returnmessage = array('message' => validation_errors(), 'status' => 0);
                        echo json_encode($returnmessage);
                    } else {
                        $array_insert = array(
                            "u_id" => $uid,
                            "upc_ean" => $upc_ean,
                            "manuf_num" => $manu_num,
                            "m_id" => $manu,
                            "b_id" => $brand,
                            "c_id" => $category,
                            "weight" => $weight,
                            "weightScale" => $weight_scale,
                            "qty" => 0,
                            //"sup_fee" => $item_price, //CHANGED TO ITEM PRICE
                            "ship_alone" => $ship_alone,
                            "d_height" => $height,
                            "d_width" => $width,
                            "d_dept" => $depth,
                            "d_scale" => $d_scale,
                            "i_time" => apputils::ConvertUnStampToMysqlDateTime(time()),
                        );
                        @ini_set('display_errors', 'On');

                        $i_id = $this->inventories->add($array_insert);

                        $images = $this->input->post('images');
                        foreach ($images as $image) {
                            mkdir(base_dir() . 'product_image/' . $i_id);
                            copy(base_dir() . 'product_image/' . $image['filename'], base_dir() . 'product_image/' . $i_id . '/' . $image['filename']);

                            $image_id = $this->inventories->add_image(array("i_id" => $i_id,
                                "ii_name" => $image['filename'],
                                "ii_link" => 'product_image/' . $i_id . '/' . $image['filename'],
                                "ii_feat" => $image['featured'],
                                "ii_time" => apputils::ConvertUnStampToMysqlDateTime( time())) );
                        }

                        $lang_title = $this->input->post('lang_title');
                        $short_desc = $this->input->post('short_desc');
                        $long_decs = $this->input->post('long_decs');
                        $lang = $this->input->post('lang');

                        $data_add_language = array('i_id' => $i_id,
                            'c_id' => $lang,
                            'tr_title' => $lang_title,
                            'tr_short_desc' => $short_desc,
                            'tr_desc' => $long_decs,
                            'tr_time' => date("Y-m-d h:i:s",time()));

                        $this->inventories->add_product_translation($data_add_language);

                        if ($user_type == 2) //IF USER TYPE IS SUPPLIER, ADD INFORMATION FOR INVENTORY CHILD
                        {
                            $add_array = array('i_id' => $i_id,
                                'u_id' => $uid,
                                'SKU' => $sku,
                                'ic_quan' => $quan,
                                'ic_price' => $price,
                                'ic_retail_price' => $ret_price,
                                'ic_leadtime' => $lead_time,
                                'ic_map' => $map,
                                'ic_ship_cost' => $ship_cost,
                                'ic_ship_country' => $ship_from,
                                'ic_prom_text' => $prom_text,
                                'ic_min_order' => $min_order,
                                'ic_case_pack' => $case_pack,
                                'ic_time' => apputils::ConvertUnStampToMysqlDateTime(time()));
                            $stock_id = $this->inventories->add_stock($add_array);
                        }


                        if ($user_type == 2)
                            $returnmessage = array('message' => base_url() . 'inventory/detail/' . $i_id . "/" . $stock_id . "", 'status' => 1);
                        elseif ($user_type == 1)
                            $returnmessage = array('message' => base_url() . 'inventory/detail/' . $i_id . "", 'status' => 1);
                        echo json_encode($returnmessage);
                    }
                } elseif ($action == 'stock') {
                    $sku = $this->input->post('sku');
                    $quan = $this->input->post('quan');
                    $price = $this->input->post('price');
                    $ret_price = $this->input->post('ret_price');
                    $lead_time = $this->input->post('lead_time');
                    $i_id = $this->input->post('inv_id');
                    $map = $this->input->post('map');
                    $ship_cost = ($this->input->post('ship_cost')=='') ? null :$this->input->post('ship_cost');
                    $ship_from = $this->input->post('ship_from');
                    $prom_text = $this->input->post('prom_text');

                    $this->load->library('form_validation');

                    $this->form_validation->set_rules('sku', 'SKU', 'trim|required|min_length[4]|xss_clean');
                    $this->form_validation->set_rules('quan', 'Quantity', 'trim|required|numeric|xss_clean|greater_than[-1]');
                    $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric|xss_clean|greater_than[0]');
                    $this->form_validation->set_rules('ret_price', 'Retailed Price', 'trim|required|numeric|xss_clean|greater_than[0]');

                    if ($map != "")
                        $this->form_validation->set_rules('map', 'MAP', 'trim|numeric|xss_clean');

                    $this->form_validation->set_rules('ship_cost', 'Ship Cost', 'trim|numeric|xss_clean');
                    $this->form_validation->set_rules('ship_from', 'Ship Country', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('prom_text', 'Promo Text', 'trim|xss_clean');
                    $this->form_validation->set_rules('inv_id', 'Inventory ID', 'trim|required|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        $returnmessage = array('message' => validation_errors(), 'status' => 0);
                        echo json_encode($returnmessage);
                    } else {
                        $add_array = array('i_id' => $i_id,
                            'u_id' => $uid,
                            'SKU' => $sku,
                            'ic_quan' => $quan,
                            'ic_price' => $price,
                            'ic_retail_price' => $ret_price,
                            'ic_leadtime' => $lead_time,
                            'ic_map' => $map,
                            'ic_ship_cost' => $ship_cost,
                            'ic_ship_country' => $ship_from,
                            'ic_prom_text' => $prom_text,
                            'ic_time' => apputils::ConvertUnStampToMysqlDateTime(time()));

                        $ic_id = $this->inventories->add_stock($add_array);

                        $url_ext = $i_id . '/' . $ic_id;
                        $returnmessage = array('message' => "Stock is Added Succesfully", 'status' => 1, 'url_ext' => $url_ext);
                        echo json_encode($returnmessage);
                    }


                }
            } else {
                if ($user_type == 1) //1 is admin, 2 supplier
                {
                    $level = 0;
                    $data['list_manufac'] = $this->manufacturers->listing();
                    $data['scale_dimension'] = $this->categories->scale_dimension_listing();
                    $data['list_scale'] = $this->inventories->listing_scale();
                    $data['categories'] = $this->categories->listings($level);
                    $data['countries'] = $this->countries->listing_country();
                    $data['default_country'] = $this->countries->default_country();
                    $this->load->view('admin/inventory/add-inventory', $data);
                } elseif ($user_type == 2) //For Supplier
                {
                    $view_form = $this->uri->segment(3);
                    if ($view_form == "stock") //Add Child inventory to Main Inventory
                    {
                        $i_id = $this->uri->segment(4);
                        $this->addStockInventory($i_id); //redirect to another function for stock inventory page

                    } else
                        $this->addSupplierInventory(); //Add Product for Supplier
                }
            }
        } else
            redirect('', 'refresh');
    }

    function addSupplierInventory() //This function Serve for adding product for supplier Invetnory Master
    {
        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type'); //get user type;
            if ($user_type == 2) //2 supplier
            {
                $level = 0;
                $data['feat_categories'] = $this->categories->listings(0); //main categories
                $data['list_manufac'] = $this->manufacturers->listing();
                $data['scale_dimension'] = $this->categories->scale_dimension_listing();
                $data['list_scale'] = $this->inventories->listing_scale();
                $data['categories'] = $this->categories->listings($level);
                $data['countries'] = $this->countries->listing_country();
                $data['default_country'] = $this->countries->default_country();
                $this->load->view('supplier/supplier-add-masterProduct', $data);
            } else
                redirect('', 'refresh');
        } else
            redirect('', 'refresh');
    }

    function addStockInventory($i_id)
    {
        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type'); //get user type;
            if ($user_type == 2) //2 supplier
            {
                $data['feat_categories'] = $this->categories->listings(0); //main categories
                $data['inventory'] = $this->inventories->detail($i_id);
                $data['countries'] = $this->countries->listing_country();
                $data['image_list'] = $this->inventories->list_image($i_id);
                $this->load->view('supplier/supplier-add-stock', $data);
            } else
                redirect('', 'refresh');
        } else
            redirect('', 'refresh');

    }


    function update()
    {
        /*echo '<pre>$_POST::'.print_r($_POST,true).'</pre>';
        echo '<pre>$_GET::'.print_r($_GET,true).'</pre>';
        die("-1"); */
        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type'); //get user type;
            if ($this->input->post('action') != "") {
                $action = $this->input->post('action');
                if ($action == 'update_product') {
                    $i_id = $this->input->post('id');

                    $upc_ean = $this->input->post('upc_ean');
                    $manu_num = $this->input->post('manu_num');
                    $manu = $this->input->post('manu');
                    $brand = $this->input->post('brand');
                    $weight = $this->input->post('weight');
                    $weight_scale = $this->input->post('weight_scale');
                    //$item_price = $this->input->post('item_price');
                    $ship_alone = $this->input->post('ship_alone');
                    $height = $this->input->post('height');
                    $width = $this->input->post('width');
                    $depth = $this->input->post('depth');
                    $d_scale = $this->input->post('d_scale');
                    $category = $this->input->post('category');


                    $this->load->library('form_validation');

                    $this->form_validation->set_rules('upc_ean', 'UPC/EAN', 'trim|required|min_length[5]|numeric|xss_clean');
                    $this->form_validation->set_rules('manu_num', 'Manufacturing Number', 'trim|required|min_length[5]|xss_clean');
                    $this->form_validation->set_rules('manu', 'Manufacture', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('brand', 'Brand', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('weight', 'Weight', 'trim|required|xss_clean|numeric|greater_than[0]');
                    $this->form_validation->set_rules('weight_scale', 'Weight Scale', 'trim|required|xss_clean');

                    //$this->form_validation->set_rules('item_price','Item Price','trim|required|xss_clean|numeric');
                    $this->form_validation->set_rules('ship_alone', 'Ship Alone', 'trim|required|xss_clean');

                    /*
                    $this->form_validation->set_rules('height','Height','trim|required|xss_clean');
                    $this->form_validation->set_rules('width','Width','trim|required|xss_clean');
                    $this->form_validation->set_rules('depth','Depth','trim|required|xss_clean');
                    */
                    if ($this->form_validation->run() == FALSE) {
                        //If has invalid input
                        $returnmessage = array('message' => validation_errors(), 'status' => 0);
                        echo json_encode($returnmessage);
                    } else {
                        $array_update = array("upc_ean" => $upc_ean,
                            "manuf_num" => $manu_num,
                            "m_id" => $manu,
                            "b_id" => $brand,
                            "c_id" => $category,
                            "weight" => $weight,
                            "weightScale" => $weight_scale,
                            "qty" => 0,
                            //"sup_fee" => $item_price, //CHANGED TO ITEM PRICE
                            "ship_alone" => $ship_alone,
                            "d_height" => $height,
                            "d_width" => $width,
                            "d_dept" => $depth,
                            "d_scale" => $d_scale,
                            "i_time" => apputils::ConvertUnStampToMysqlDateTime(time()),
                        );

                        $where = "i_id";

                        $result = $this->inventories->update($array_update, $i_id, $where);
                        $returnmessage = array('message' => "Successfull Update", 'status' => 1);
                        echo json_encode($returnmessage);
                    }
                } elseif ($action == 'set_feature_image') //if setting featured image
                {
                    $id_sel = $this->input->post('imgid');
                    $product_id = $this->input->post('id');
                    $data_remove_set = array('ii_feat' => 0);
                    $data_new_set = array('ii_feat' => 1);

                    $this->inventories->update_featured_image($data_remove_set, $data_new_set, $id_sel, $product_id);
                } elseif ($action == 'update_stock') {
                    $sku = $this->input->post('sku');
                    $quan = $this->input->post('quan');
                    $price = $this->input->post('price');
                    $ret_price = $this->input->post('ret_price');
                    $lead_time = $this->input->post('lead_time');
                    $min_order = $this->input->post('min_order');
                    $ic_id = $this->input->post('ic_id');

                    $ic_ship_cost = ($this->input->post('ship_cost') != '') ? $this->input->post('ship_cost') : null;
                    $ic_ship_country = $this->input->post('ship_from');
                    $ic_map = $this->input->post('map');
                    $ic_prom_text = $this->input->post('prom_text');
                    $case_pack = $this->input->post('case_pack');
                    $min_order = $this->input->post('min_order');

                    $this->load->library('form_validation');

                    $this->form_validation->set_rules('sku', 'SKU', 'trim|required|min_length[4]|xss_clean');
                    $this->form_validation->set_rules('quan', 'Quantity', 'trim|required|numeric|xss_clean|greater_than[-1]');
                    $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric|xss_clean|greater_than[0]');
                    $this->form_validation->set_rules('ret_price', 'Retailed Price', 'trim|required|numeric|xss_clean|greater_than[0]');
                    $this->form_validation->set_rules('min_order', 'Minimum order', 'trim|required|numeric|xss_clean|greater_than[0]');

                    if ($ic_map != "")
                        $this->form_validation->set_rules('map', 'MAP', 'trim|numeric|xss_clean');

                    $this->form_validation->set_rules('ship_cost', 'Ship Cost', 'trim|numeric|xss_clean');
                    $this->form_validation->set_rules('ship_from', 'Ship Country', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('prom_text', 'Promo Text', 'trim|xss_clean');
                    $this->form_validation->set_rules('ic_id', 'Inventory Child ID', 'trim|required|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        $returnmessage = array('message' => validation_errors(), 'status' => 0);
                        echo json_encode($returnmessage);
                    } else {
                        $update_array = array('SKU' => $sku,
                            'ic_quan' => $quan,
                            'ic_price' => $price,
                            'ic_retail_price' => $ret_price,
                            'ic_leadtime' => $lead_time,
                            'ic_ship_cost' => $ic_ship_cost,
                            'ic_ship_country' => $ic_ship_country,
                            'ic_map' => $ic_map,
                            'ic_prom_text' => $ic_prom_text,
                            'ic_case_pack' => $case_pack,
                            'ic_min_order' => $min_order,
                            'ic_time' => apputils::ConvertUnStampToMysqlDateTime(time()));
                        $where = 'ic_id';

                        $this->inventories->update_stock($update_array, $where, $ic_id);

                        $returnmessage = array('message' => "Success Update Child Inventory", 'status' => 1);
                        echo json_encode($returnmessage);
                    }
                }
            } else //Different Viewing Form
            {
                $id_product = $this->uri->segment(3);

                if ($user_type == 1) //1 is admin
                {
                    $data['product'] = $this->inventories->detail($id_product);
                    $data['list_manufac'] = $this->manufacturers->listing();
                    $data['list_scale'] = $this->inventories->listing_scale();
                    $data['categories'] = $this->categories->listings("0");
                    $data['countries'] = $this->countries->listing_country();
                    $data['scale_dimension'] = $this->categories->scale_dimension_listing();

                    $data['default_country'] = $this->countries->default_country(); //select default country attribute

                    $data['translation_list'] = $this->inventories->list_product_translation($id_product);
                    $data['image_list'] = $this->inventories->list_image($id_product);
                    if ($data['product'] == false)
                        redirect('', 'refresh');
                    else
                        $this->load->view('admin/inventory/update-inventory', $data);

                } elseif ($user_type == 2) // 2 is Supplier
                {
                    $data['product'] = $this->suppliers->detail_main_inventory($id_product); //id of the product
                    if ($data['product']->master_uid == $this->session->userdata('id')) //if the owner or maker of the master inventory
                    {
                        $data['list_manufac'] = $this->manufacturers->listing();
                        $data['list_scale'] = $this->inventories->listing_scale();
                        $data['categories'] = $this->categories->listings("0");
                        $data['countries'] = $this->countries->listing_country();
                        $data['scale_dimension'] = $this->categories->scale_dimension_listing();

                        $data['default_country'] = $this->countries->default_country(); //select default country attribute

                        $data['translation_list'] = $this->inventories->list_product_translation($data['product']->i_id);
                        $data['image_list'] = $this->inventories->list_image($data['product']->i_id);
                        if ($data['product'] == false)
                            redirect('', 'refresh');
                        else
                            $this->load->view('supplier/supplier-update-inventory', $data);
                    } elseif ($data['product']->child_uid == $this->session->userdata('id')) //has previledge to edit the child details
                    {
                        $data['categories'] = $this->categories->listings("0");
                        $data['inventory'] = $data['product'];
                        $data['countries'] = $this->countries->listing_country();
                        $data['image_list'] = $this->inventories->list_image($data['product']->i_id);

                        $this->load->view('supplier/supplier-update-inventory', $data);
                    } else
                        redirect('', 'refresh');
                }
            }
        } else
            redirect('', 'refresh');
    }

    function detail()
    {
        $id_product = $this->uri->segment(3); //id id master inventory
        
        $supplier_id = $this->inventories->get_supplier_id($id_product);
        $supplier_status = $this->suppliers->get_supplier_status($supplier_id);
        
        $user_type = $this->session->userdata('type');
        $current_user_id = $this->session->userdata['id'];
        
        if( ($current_user_id==$supplier_id) || ( $user_type == '1') || ($supplier_status !=3 && $supplier_status !=2)){
        
        $data['left_categories'] = $this->categories->listings(0); //main categories
        if ($this->session->userdata('is_login') == TRUE) {
            //$user_type = $this->session->userdata('type'); //get user type;
            if ($user_type == 2 || $user_type == 3 || $user_type == 1) //2 is supplier or Buyer
            {
                
                $id_child_product = $this->uri->segment(4); //id for child inventory

                if ($id_product != "") {
                    if ($id_child_product == "") //checking all suppliers that has the lowest price
                        $id_child_product = $this->suppliers->check_lowest_bid($id_product);

                    if ($id_child_product == "") //if no childproduct must load normal product page
                    {
                        $data['categories'] = array(); //main categories
                        $data['brands'] = array();
                        $data['manus'] = array();

                        $data['has_child'] = false;

			$data['user'] = $this->users->info($this->session->userdata['id']);
                        $data['product'] = $this->suppliers->detail_main_inventory($id_product); //id of the child
                        $data['translations'] = $this->inventories->list_translation_product($data['product']->i_id, 'c_name, c_code, translation.c_id');
                        $data['image_list'] = $this->inventories->list_image($data['product']->i_id);
                        $data['general_feedback'] = $this->suppliers->general_feedback($data['product']->u_id);
                        $data['feedback_detail'] = $this->suppliers->feedback_detail($data['product']->u_id);
                        $this->load->view('view-product', $data);
                    } else {


 						$data['user'] = $this->users->info($this->session->userdata['id']);
                        $data['product'] = $this->suppliers->detail_child_inventory($id_child_product); //id of the child
                        $data['suppliers'] = $this->suppliers->list_supplier_child_attached($id_product, 0);
                        $data['translations'] = $this->inventories->list_translation_product($data['product']->i_id, 'c_name, c_code, translation.c_id');
                        $data['image_list'] = $this->inventories->list_image($data['product']->i_id);
                        $data['has_child'] = ($data['product']->ic_quan) ? true : false;

                        $data['general_feedback'] = $this->suppliers->general_feedback($data['product']->u_id);
                        $data['feedback_detail'] = $this->suppliers->feedback_detail($data['product']->u_id);
                        $data['categories'] = array(); //main categories
                        $data['brands'] = array();
                        $data['manus'] = array();

                        $this->db->select('id');
                        $this->db->from('buyer_data_feed');
                        $this->db->where('user_id', $this->session->userdata['id']);
                        $this->db->where('prod_id', $id_product);
                        $query = $this->db->get();

                        $data['is_in_feed'] = $query->num_rows;

                        if ($data['product'] == false)
                            redirect('', 'refresh');
                        else
                            $this->load->view('view-product', $data);
                    }
                } else
                    redirect('', 'refresh');
            }

        } else //If no user login
        {
            $id_product = $this->uri->segment(3); //id id master inventory
            $id_child_product = $this->uri->segment(4); //id for child inventory
            $data['feat_categories'] = $this->categories->listings(0); //main categories

            if ($id_product != "") {
                if ($id_child_product == "") //checking all suppliers that has the lowest price
                    $id_child_product = $this->suppliers->check_lowest_bid($id_product);

                $data['product'] = $this->suppliers->detail_child_inventory($id_child_product); //id of the child
                $data['suppliers'] = $this->suppliers->list_supplier_child_attached($id_product);

                if ($id_child_product == "") //if no childproduct must load normal product page
                {
                    $data['categories'] = array(); //main categories
                    $data['brands'] = array();
                    $data['manus'] = array();

                    $data['has_child'] = false;

                    $data['product'] = $this->suppliers->detail_main_inventory($id_product); //id of the child
                    $data['translations'] = $this->inventories->list_translation_product($data['product']->i_id, 'c_name, c_code, translation.c_id');
                    $data['image_list'] = $this->inventories->list_image($data['product']->i_id);
                    $data['general_feedback'] = $this->suppliers->general_feedback($data['product']->u_id);
                    $data['feedback_detail'] = $this->suppliers->feedback_detail($data['product']->u_id);
                    $this->load->view('view-product', $data);
                } else {
                    $data['feat_categories'] = $this->categories->listings(0); //main categories
                    $data['has_child'] = ($data['product']->ic_quan) ? true : false;
                    $data['translations'] = $this->inventories->list_translation_product($data['product']->i_id, 'c_name, c_code, translation.c_id');
                    $data['image_list'] = $this->inventories->list_image($data['product']->i_id);
                    $data['general_feedback'] = $this->suppliers->general_feedback($data['product']->u_id);
                    $data['feedback_detail'] = $this->suppliers->feedback_detail($data['product']->u_id);
                    $data['categories'] = array(); //main categories
                    $data['brands'] = array();
                    $data['manus'] = array();
                    $this->load->view('view-product', $data);
                }
            } else
                redirect('', 'refresh');

        }
        }else{
            redirect('', 'refresh');
        }
    }

    function translation()
    {
        if ($this->session->userdata('is_login') == TRUE) {
            $user_type = $this->session->userdata('type'); //get user type;
            if ($this->input->post('action') != "") {
                $action = $this->input->post('action');
                if ($action == 'add') //if adding inventory
                {
                    $translations = $this->inventories->list_product_translation($this->input->post('id'));
                    foreach ($translations as $tr) {
                        if ($tr->c_id == $this->input->post('lang')) {
                            echo json_encode(array('status' => 0, 'message' => 'Translation for that country already exists'));
                            return;
                        }
                    }
                    $data_insert = array('i_id' => $this->input->post('id'),
                        'c_id' => $this->input->post('lang'),
                        'tr_title' => trim($this->input->post('title')),
                        'tr_short_desc' => trim($this->input->post('short_desc')),
                        'tr_desc' => trim($this->input->post('desc')),
                        'tr_time' => date("Y-m-d h:i:s",time()),);


                    $id = $this->inventories->add_product_translation($data_insert);
                    $returnmessage = array('message' => "Translation added successfully", 'status' => 1);
                    echo json_encode($returnmessage);
                } elseif ($action == 'detail') //if get detail
                {
                    $tr_id = $this->input->post('id');
                    $result = $this->inventories->translation_detail($tr_id);

                    echo json_encode($result);
                } elseif ($action == 'edit') //if update
                {
                    $tr_id = $this->input->post('id');

                    $array_update = array('tr_title' => $this->input->post('title'),
                        /*'tr_short_desc'=> $this->input->post('short_desc'),*/
                        'tr_desc' => $this->input->post('desc'), 'c_id' => $this->input->post('lang'),);

                    $result = $this->inventories->update_translation($array_update, $tr_id);

                    $returnmessage = array('message' => "Translation updated successfully", 'status' => 1);
                    echo json_encode($returnmessage);
                } elseif ($action == 'delete') //if delete
                {
                    $tr_id = $this->input->post('id');
                    $result = $this->inventories->translation_delete($tr_id);

                    $returnmessage = array('message' => "Translation deleted successfully", 'status' => 1);
                    echo json_encode($returnmessage);
                }
            }
        } else
            redirect('', 'refresh');
    }

    function delete()
    {
        if ($this->session->userdata('is_login') == false) {
            redirect('', 'refresh');
        }
            if ($this->input->post('action') != "") {
                $action = $this->input->post('action');
                if ($action == 'image') //if deleteing image
                {
					$ii_id = $this->input->post('imgid');
					return $this->inventories->delete_image($ii_id);
				}
	    } else {
            $i_ids = explode(',',urldecode($this->uri->segment(3)));
	        if(!empty($i_ids)){
		        foreach($i_ids as $i_id)
			        $result = $this->inventories->update( array("status" =>'deleted' ), $i_id, 'i_id');
	        }
                if($this->input->get('is_ajax')==1){
                    echo json_encode(array( 'success'=>true, 'msg'=>'Successfully Deleted!'));
                }
                else{
                    redirect('/inventory/');
                }
	    }
    }


    public function run_timeconverting($developer= false) // alter table inventory drop column temp_i_time
    { //  http://local-ot-mainsite.com/inventory/run_timeconverting/1
        $this->load->library('timeconvert'); // load main library

        $dataChangesArray = array(
 /*           array('table_name' => 'inventory', 'field_name' => 'i_time', 'key_field' => 'i_id',
                'title'=>'Inventories, last modification time',
                'when_it_used'=>'For testing needs Adding/updating inventories manually and adding inventories with import. This field can be visible at Inventory detail/update
                 pages',

                'developer_changed_files_list'=>'mainsite/application/controllers/inventory.php,  mainsite/application/models/import.php,
                mainsite/application/views/view-product.php, mainsite/application/views/supplier/supplier-update-inventory.php ',
                'developer_notes'=>'I added inventory.i_time visible at Inventory detail/update pages. Do we need to show it somewhere else ? Maybe on some backend pages?'

            ),



            // `inventory_child`. `ic_time` t
            array('table_name' => 'inventory_child', 'field_name' => 'ic_time', 'key_field' => 'ic_id',
                'title'=>'Inventories child, last modification time',
                'when_it_used'=>'For testingg needs Adding/updating inventories manually and adding inventories with import. This field can be visible at search form',

                'developer_changed_files_list'=>'mainsite/application/controllers/inventory.php, mainsite/application/models/import.php,
                mainsite/application/views/supplier/supplier-search-product-list.php, mainsite/avatars/views/supplier/supplier-search-product-list.php ',
                'developer_notes'=>'ic_time field is used in search form. I changed code for it .'

            ),

            // inventory_image ii_time
            array('table_name' => 'inventory_image', 'field_name' => 'ii_time', 'key_field' => 'ii_id',
                'title'=>'Inventories image(?), last modification time',
                'when_it_used'=>'For testing needs Upload image in inventory manually and adding inventories with import. This field can be visible near with image thumbnail',

                'developer_changed_files_list'=>'mainsite/application/controllers/inventory.php, mainsite/application/models/import.php,
                mainsite/application/controllers/upload.php, mainsite/application/views/supplier/supplier-update-inventory.php,
                mainsite/application/views/admin/inventory/inventory-image-list.php, mainsite/admin/css/style.css ',
                'developer_notes'=>'all prior data for this fields were invalid, as for datetime field ii_time time() function was applied,
                and this set zero values. I added label of this field near with image thumbnail'

            ),

            // order_refund_record -> orr_date -> orr_id
            array('table_name' => 'order_refund_record', 'field_name' => 'orr_date', 'key_field' => 'orr_id',
                'title'=>'order_refund_record',
                'when_it_used'=>'No data in database for this field',

                'developer_changed_files_list'=>'mainsite/application/controllers/supplier.php, mainsite/application/controllers/supplier_ori.php',
                'developer_notes'=>'This field in written into database twice, but not used for reading. '

            ),
           array('table_name' => 'supplier_shipprod_info', 'field_name' => 'ssi_time', 'key_field' => 'ssi_id',
                'title'=>'supplier_shipprod_info',
                'when_it_used'=>'No data in database for this field ',

                'developer_changed_files_list'=>'mainsite/application/controllers/shipping.php, mainsite/application/models/users.php',
                'developer_notes'=>'Please, testing pay attention at users/enable_feedback script. ssi_time field is used in it, I fixed to valid format just review testing'

            ),  */

         /*array('table_name' => 'translation', 'field_name' => 'tr_time', 'key_field' => 'tr_id',
                            'title'=>'translation, last modification time',
                            'when_it_used'=>'In import uploading ',

                            'developer_changed_files_list'=>'mainsite/application/models/import.php, ',
                            'developer_notes'=>'I uncommented and fixed line tr_time => apputils::ConvertUnStampToMysqlDateTime( time() ) in import file. All current Data are
                            zero. It must work ok with future import'

                        ),

       array('table_name' => 'user', 'field_name' => 'u_time', 'key_field' => 'u_id',
                                        'title'=>'User, last modification time',
                                        'when_it_used'=>'when user is getting created/updated ',
                                        'developer_changed_files_list'=>'mainsite/application/controllers/administrator.php, mainsite/application/controllers/buyer.php,
mainsite/application/controllers/buyer2.php, mainsite/application/controllers/sale.php, mainsite/application/controllers/supplier.php,
mainsite/application/controllers/supplier_ori.php, mainsite/application/models/users.php, mainsite/application/views/supplier/supplier-feedback-list.php,
mainsite/application/views/supplier/supplier-home.php, mainsite/avatars/views/supplier/supplier-feedback-list.php, mainsite/avatars/views/supplier/supplier-home.php',
                                        'developer_notes'=>'User.u_time filed is used rather often. In case I had tostrto time function when I need to convert it to unix stamp,
like $range_week = $this->suppliers->rangeWeek(strtotime($supplier->u_time))  or  echo date(\'d/M/Y\',strtotime($feedback->u_time))'

                                    ),        */
            //    -  (when user is getting created/updated)
        );
        foreach ($dataChangesArray as $dataChange) {
            $timeConvert = new timeconvert($dataChange['table_name'], $dataChange['field_name'], $dataChange['key_field'], '');
            $timeConvert->addTempColumn();
            $timeConvert->copyRows(true);
            $timeConvert->dropSourceColumn();
            $timeConvert->dropRenameTmpColumn();
            $rowsWorked = $timeConvert->getRowsWorked();
            $skipppedRowsCount = $timeConvert->getSkipppedRowsCount();
            $skipppedWithWrongFormatRowsCount = $timeConvert->getSkipppedWithWrongFormatRowsCount();
            echo '<small><h1>'.$dataChange['title']. '</h1><br>'. '<b>' . $rowsWorked . '</b> rows were changed, <b>' . $skipppedRowsCount . '</b> rows were skipped as empty,
            ' . $skipppedWithWrongFormatRowsCount . ' were skipped as invalid format !<br>';
            echo $dataChange['when_it_used']. '<br>';
            if ($developer) {
                echo 'Changed files : <b>'. $dataChange['developer_changed_files_list']. '</b><br>';
                echo 'Developers notes : <b>'. $dataChange['developer_notes']. '</b><br><br>';

            }

            echo '</small><hr>';
        } //         foreach( $dataChangesArray as $dataChange ) {
    }

    public function manage(){
        $data = array();
        $this->load->model('import_history');
        $this->load->model('import_result');
        $this->load->model('import');
        $this->load->library('encrypt');
        $user_type = 0;
        if($this->session->userdata('is_login') == true) {
            $user_type = $this->session->userdata('type');
        }
        $data['results'] = false;
        if ($this->input->post('import'))
        {
            $id = $this->import_result->add(array());
            $this->session->set_userdata('import_result_id', $id);
            $userid = $this->session->userdata('id');
            $results = $this->import->datafeeds();
            $this->db->where('id', $id);
            $this->db->update('import_result', array('results' => serialize($results)));
            if($results['error']) {
                $h_id = $this->import_history->add($userid, 0, 0, 0, 0, 0, $results['extension'], 0, $id);
            } else {
                $h_id = $this->import_history->add($userid, $results['total'], $results['inserted'], $results['updated'], $results['deleted'],0, $results['extension'], 1, $id);
            }
            $this->db->where('id', $h_id);
            $this->db->update('import_history', array(
                'created_at' => $results['created_at'],
            ));
            redirect(current_url());
        } else {
            $id = $this->session->userdata('import_result_id');
            $page = (int)$this->input->get('page');
            $page = $page > 0 ? $page : 1;

            if($id) {
                $results = $this->import_result->get($id);
                if($results) {
                    $data['results'] = unserialize($results->results);
                    //$this->import_result->delete($id);
                }
                $this->session->set_userdata(array('import_result_id' => false));
            }

            $data['history'] = $this->import_history->get($this->session->userdata['id'], $page, 20);
            $this->db->where('user_id', $this->session->userdata['id']);
            $data['history_pages'] = ceil($this->db->count_all_results('import_history') / 20);
            $data['page'] = $page;
        }
        $this->load->view('admin/inventory/manage-inventory',$data);
    }
  
}

