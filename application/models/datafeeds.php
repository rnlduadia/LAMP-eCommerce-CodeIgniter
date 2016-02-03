<?php


class Datafeeds extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


	function listing($id = "", $page = 0, $sort_by= 'tr_title')
	{
        $sort_by = $this->input->get('sort_by');
		$this->db->select('translation.tr_title, translation.tr_desc');
		$this->db->select('inventory_child.SKU');
		$this->db->select('inventory.upc_ean, inventory.manuf_num, inventory.i_id');
		$this->db->select('brand.b_name');
		$this->db->select('category.c_name');
	        $this->db->join('inventory_child', 'inventory_child.i_id = buyer_data_feed.prod_id', 'left');
	        $this->db->join('inventory', 'inventory.i_id = buyer_data_feed.prod_id', 'left');
	        $this->db->join('translation', 'translation.i_id = buyer_data_feed.prod_id', 'left');
	        $this->db->join('brand', 'brand.b_id = inventory.b_id', 'left');
	        $this->db->join('category', 'category.c_id = inventory.c_id', 'left');


		if($id != "")
			$this->db->where('user_id', $id);

		if($page > 0) {
			$limit = ($page * 10) - 10;
			$this->db->limit(10, $limit);
		}

		$this->db->group_by("inventory_child.i_id");
        if ( !empty($sort_by) ) {
            $this->db->order_by($sort_by);
        }


		$result = $this->db->get('buyer_data_feed');

		return $result->result();
	}

	function prodlist($type = "allprods", $supplier_id = "")
	{
		$df_per_ship = 6; $df_per_weight = 1;
		$ship_cost='IF ( (`inventory_child`.`ic_ship_cost` IS NULL), IF( `shipping_table`.`st_id` IS NOT NULL,(`shipping_table`.`s_per_shipment`+`shipping_table`.`s_per_weight`*`inventory`.`weight`), ('.$df_per_ship.' + '.$df_per_weight.' * `inventory`.`weight`) ) , `inventory_child`.`ic_ship_cost` )';
		$this->db->_protect_identifiers=false;
		$this->db->select('`translation`.`tr_title`, `translation`.`tr_desc`');
		$this->db->select('CAST( ( `inventory_child`.`ic_price` + ( '.$ship_cost.' ) ) AS DECIMAL(10, 2)) AS `ic_total_cost`');
		$this->db->select('CAST('.$ship_cost.'  AS DECIMAL(10,2))AS `ic_ship_cost`, `inventory_child`.`SKU`, `inventory_child`.`ic_leadtime`, `inventory_child`.`ic_quan`, `inventory_child`.`ic_price`, `inventory_child`.`ic_retail_price`, `inventory_child`.`ic_prom_text`, `inventory_child`.`ic_map`, inventory_child.ic_min_order, `inventory_child`.`ic_case_pack`, `inventory_child`.`ic_id`');
		$this->db->select('`inventory`.`i_id`, `inventory`.`upc_ean`, `inventory`.`manuf_num`, `inventory`.`weight`, `inventory`.`weightScale`, `inventory`.`ship_alone`, `inventory`.`d_height`, `inventory`.`d_width`, `inventory`.`d_dept`, `inventory`.`d_scale`');
		$this->db->select('`manufacturer`.`m_name`');
		$this->db->select('`brand`.`b_name`');
		$this->db->select('`category`.`c_name`, `category`.`c_id`');
	        $this->db->join('`inventory`', 'inventory.`i_id` = `inventory_child`.`i_id`', 'left');
	        $this->db->join('`translation`', 'translation.`i_id` = `inventory_child`.`i_id`', 'left');
	        $this->db->join('`brand`', 'brand.`b_id` = `inventory`.`b_id`', 'left');
	        $this->db->join('`manufacturer`', 'manufacturer.`m_id` = `inventory`.`m_id`', 'left');
	        $this->db->join('`category`', 'category.`c_id` = `inventory`.`c_id`', 'left');
		$this->db->join('`shipping_table`', 'shipping_table.`u_id` = `inventory_child`.`u_id` AND `shipping_table`.`s_level` = \'standard\'', 'left');

		$this->db->join('`user`', 'user.`u_id` = `inventory_child`.`u_id`');
		$this->db->where('(`user`.`u_admin_approve` <> 2) AND (`user`.`u_admin_approve` <> 3)');

		if($type == "dropshipping")
			$this->db->where("`inventory`.`ship_alone`", 1);

		if($type == "supplier")
			$this->db->where("`inventory_child`.`u_id`", $supplier_id);

		$this->db->group_by('`i_id`');
		$this->db->order_by("`ic_total_cost` ASC");

		$result = $this->db->get('`inventory_child`');

		$this->db->_protect_identifiers=true;
		return $result->result();
	}

	function delete_by_user($user_id){
	   $this->db->where('user_id', $user_id);
	   $this->db->delete('buyer_data_feed');
	}

	function delete_by_productid($user_id, $prod_id){
	   $this->db->where('user_id', $user_id);
	   $this->db->where('prod_id', $prod_id);
	   $this->db->delete('buyer_data_feed');
	}

	function custom_prodlist($u_id)
	{
		$df_per_ship = 6; $df_per_weight = 1;
		$ship_cost='IF ( (`inventory_child`.`ic_ship_cost` IS NULL), IF( `shipping_table`.`st_id` IS NOT NULL,(`shipping_table`.`s_per_shipment`+`shipping_table`.`s_per_weight`*`inventory`.`weight`), ('.$df_per_ship.' + '.$df_per_weight.' * `inventory`.`weight`) ) , `inventory_child`.`ic_ship_cost` )';
		$this->db->_protect_identifiers=false;
		$this->db->select('`translation`.`tr_title`, `translation`.`tr_desc`');
		$this->db->select('CAST( ( `inventory_child`.`ic_price` + ( '.$ship_cost.' ) ) AS DECIMAL(10, 2)) AS `ic_total_cost`');
		$this->db->select('CAST('.$ship_cost.'  AS DECIMAL(10,2))AS `ic_ship_cost`, `inventory_child`.`SKU`, `inventory_child`.`ic_leadtime`, `inventory_child`.`ic_quan`, `inventory_child`.`ic_price`, `inventory_child`.`ic_retail_price`, `inventory_child`.`ic_prom_text`, `inventory_child`.`ic_map`, inventory_child.ic_min_order, `inventory_child`.`ic_case_pack`, `inventory_child`.`ic_id`');
		$this->db->select('`inventory`.`i_id`, `inventory`.`upc_ean`, `inventory`.`manuf_num`, `inventory`.`weight`, `inventory`.`weightScale`, `inventory`.`ship_alone`, `inventory`.`d_height`, `inventory`.`d_width`, `inventory`.`d_dept`, `inventory`.`d_scale`');
		$this->db->select('`manufacturer`.`m_name`');
		$this->db->select('`brand`.`b_name`');
		$this->db->select('`category`.`c_name`, `category`.`c_id`');

	        $this->db->join('`inventory_child`', 'inventory_child.`i_id`= `buyer_data_feed`.`prod_id`', 'left');
	        $this->db->join('`inventory`', 'inventory.`i_id` = `inventory_child`.`i_id`', 'left');
	        $this->db->join('`translation`', 'translation.`i_id` = `inventory_child`.`i_id`', 'left');
	        $this->db->join('`brand`', 'brand.`b_id` = `inventory`.`b_id`', 'left');
	        $this->db->join('`manufacturer`', 'manufacturer.`m_id` = `inventory`.`m_id`', 'left');
	        $this->db->join('`category`', 'category.`c_id` = `inventory`.`c_id`', 'left');
		$this->db->join('`shipping_table`', 'shipping_table.`u_id` = `inventory_child`.`u_id` AND `shipping_table`.`s_level` = \'standard\'', 'left');

	    $this->db->where('`user_id`', $u_id);
		$this->db->order_by("`ic_total_cost` ASC");
		$this->db->group_by('`inventory_child`.`i_id`');

		$result = $this->db->get('`buyer_data_feed`');
		$this->db->_protect_identifiers=true;


		return $result->result();
	}

	function has_entries($user_id){
 	   $this->db->select('*');
	   $this->db->where('user_id', $user_id);
	   $result = $this->db->get('buyer_data_feed');
	   if ($result->num_rows() > 0) {
        	return true;
	   }
	   return false;

	}

}

?>