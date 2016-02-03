<?php

class Inventories extends CI_Model
{
    //including country tables info and crud

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function listing_scale()
    {
        $this->db->select('*');
        $result = $this->db->get('scale');
        return $result->result();
    }

    function add($data)
    {
        $this->db->insert('inventory', $data);
        return $this->db->insert_id();
    }

    function update($data, $id, $where)
    {
        $this->db->where($where, $id);
        $this->db->update('inventory', $data);
    }

    function delete($where, $value)
    {
        $this->db->like($where, $value);
        $this->db->delete('inventory');
        return true;
    }

    function detail($id)
    {
        $this->db->select('*');
        $this->db->select('inventory.c_id as cat_id, inventory.i_id, inventory.u_id as master_uid');
        $this->db->join('manufacturer', 'manufacturer.m_id = inventory.m_id', 'left');
        $this->db->join('brand', 'brand.b_id = inventory.b_id', 'left');
        $this->db->join('category', 'category.c_id = inventory.c_id', 'left');
        $this->load->model('countries');
        $default_country = $this->countries->default_country();
        $this->db->join('translation', 'translation.i_id = inventory.i_id AND translation.c_id = ' . $default_country, 'left'); // 1 English
        $this->db->where('inventory.i_id', $id);
        $result = $this->db->get('inventory');

        if ($result->num_rows() == 1)
            return $result->row(1);
        else
            return false;
    }

    function total_quantity($i_id)
    {
        $this->db->select('ic_quan');
        $this->db->where('i_id', $i_id);
        $result = $this->db->get('inventory_child');

        $result = $result->result();
        $quan = 0;
        foreach ($result as $row) {
            $quan += $row->ic_quan;
        }

        return $quan;
    }

    function range_price($i_id)
    {
        $this->db->select('ic_price');
        $this->db->where('i_id', $i_id);
        $this->db->order_by('ic_price', 'asc');
        $result = $this->db->get('inventory_child');

        $result = $result->result();

        if (count($result) == 0)
            return 'N/A';
        elseif (count($result) == 1)
            return $result[0]->ic_price;
        else
            return $result[0]->ic_price . ' ~ ' . $result[1]->ic_price;
    }

    function add_image($data)
    {
        $this->db->insert('inventory_image', $data);
        return $this->db->insert_id();
    }

    function list_image($id, $limit = "", $featured = false)
    {
        $this->db->select('*');
        $this->db->where('i_id', $id);
        if ($limit != "") {
            $this->db->limit($limit);
        }
        if ($featured) {
            $this->db->order_by('ii_feat', 'desc');
        }
        $result = $this->db->get('inventory_image');

        $res = $result->result();
        $output = array();
        foreach ($res as $image) {
            if (file_exists(base_dir() . $image->ii_link)) {
                $output[] = $image;
            }
        }

        return $output;
    }

    function listings($name = '', $manu = '', $brand = '', $sku = '', $upc_ean = '', $manunum = '')
    {
        $this->db->select('*');
        $this->db->select('inventory.i_id');
        $this->db->select('inventory.c_id as cat_id');
        $this->db->select('inventory_child.SKU as SKU');
        $this->db->join('inventory_child', 'inventory.i_id = inventory_child.i_id', 'left');
        $this->db->join('manufacturer', 'manufacturer.m_id = inventory.m_id', 'left');
        $this->db->join('brand', 'brand.b_id = inventory.b_id', 'left');
        $this->db->join('category', 'category.c_id = inventory.c_id', 'left');
        $this->load->model('countries');
        $default_country = $this->countries->default_country();
        $this->db->join('translation', 'translation.i_id = inventory.i_id AND translation.c_id = ' . $default_country, 'left'); // 1 English

	    $this->db->join('user', 'user.u_id = inventory_child.u_id');
	    $this->db->where('(user.u_admin_approve <> 2) AND (user.u_admin_approve <> 3)');

        if ($name != "")
            $this->db->like('tr_title', $name);

        if ($manu != "")
            $this->db->like('manufacturer.m_name', $manu);

        if ($brand != "")
            $this->db->like('brand.b_name', $brand);

        if ($upc_ean != "")
            $this->db->where('upc_ean', $upc_ean);

        if ($manunum != "")
            $this->db->where('manuf_num', $manunum);

        if ($sku != '')
            $this->db->where('inventory_child.SKU', $sku);

        $this->db->group_by('inventory.i_id');

        // pagination start
        $pagination = array();
        $pagination['curent_page'] = intval($_GET['page'])>0 ? intval($_GET['page']) : 1 ;
        $pagination['per_page'] = 50;
        // pagination end

        $start_limit = ($pagination['curent_page'] - 1) * $pagination['per_page'];
        $result = $this->db->limit($pagination['per_page'], $start_limit);

        $result = $this->db->get('inventory');


        $this->db->select("FOUND_ROWS() as count",false);
        $count = $this->db->get('inventory');
        $pagination['num_strings'] = $count->num_rows;
        $pagination['num_pages'] = ceil($pagination['num_strings'] / $pagination['per_page']);


        $return = array('result' => $result->result(), 'pagination' => $pagination);
        return $return;
    }

    function listings_advance($where = "", $num = 10000, $offset = 0, $order_by = "inventory.i_id", $order_dir = "asc")
    {
        $this->db->select('inventory.*')->from('inventory')->join('inventory_child', 'inventory_child.i_id = inventory.i_id')->group_by('inventory.i_id')->limit($num, $offset);
        $this->db->order_by($order_by, $order_dir);
	    $this->db->join('user', 'user.u_id = inventory_child.u_id');
	    $this->db->where('(user.u_admin_approve <> 2) AND (user.u_admin_approve <> 3)');
        if ($where != "" && !is_array($where['inventory.c_id']))
            $this->db->where($where);
        elseif (is_array($where['inventory.c_id'])) {
            $this->db->where_in('inventory.c_id', $where['inventory.c_id']);
            unset($where['inventory.c_id']);
            $this->db->where($where);
        }
        $subquery = $this->db->select_query();
        $this->db->reset();

        $this->db->select('inventory.*, translation.*');
        $this->db->select('inventory.i_id');
        $this->db->select('inventory.c_id as cat_id');
        $this->db->join('manufacturer', 'manufacturer.m_id = inventory.m_id', 'left');
        $this->db->join('brand', 'brand.b_id = inventory.b_id', 'left');
        $this->db->join('category', 'category.c_id = inventory.c_id', 'left');
        $this->load->model('countries');
        $default_country = $this->countries->default_country();
        $this->db->join('translation', 'translation.i_id = inventory.i_id AND translation.c_id = ' . $default_country, 'left'); // 1 English
        $this->db->join('inventory_child', 'inventory_child.i_id = inventory.i_id');

        $this->db->group_by('inventory.i_id');


        $this->db->ar_from[] = "($subquery) AS inventory";

        $result = $this->db->get();
        return $result->result();
    }

    function listings_advance_count($where = "")
    {
        $this->db->select('inventory.*');
        $this->db->join('inventory_child', 'inventory_child.i_id = inventory.i_id');

        if ($where != "" && !is_array($where['inventory.c_id']))
            $this->db->where($where);
        elseif (is_array($where['inventory.c_id'])) {
            $this->db->where_in('inventory.c_id', $where['inventory.c_id']);
            unset($where['inventory.c_id']);
            $this->db->where($where);
        }

	    $this->db->join('user', 'user.u_id = inventory_child.u_id');
	    $this->db->where('(user.u_admin_approve <> 2) AND (user.u_admin_approve <> 3)');

        $this->db->group_by('inventory.i_id');

        $result = $this->db->get('inventory');

        return $result->num_rows();
    }

    function search_forAddProduct($search_value, $only_product_name = false)
    {
        if ($only_product_name)
            $this->db->select('tr_title, inventory.i_id');
        else
            $this->db->select('*');
        $this->db->select('inventory.i_id');
        $this->db->select('inventory.c_id as cat_id'); //c_id conflict with c_id in country
        /*$this->db->select('inventory_child.ic_quan');*/
        $this->db->join('manufacturer', 'manufacturer.m_id = inventory.m_id', 'left');
        $this->db->join('brand', 'brand.b_id = inventory.b_id', 'left');
        $this->db->join('category', 'category.c_id = inventory.c_id', 'left');

        $this->load->model('countries');
        $default_country = $this->countries->default_country();

        $this->db->join('translation', 'translation.i_id = inventory.i_id AND translation.c_id = ' . $default_country, 'left'); // 1 English
        /*$this->db->join('inventory_child', 'inventory.i_id = inventory_child.i_id AND inventory_child.ic_quan > 0', 'inner');*/

        $this->db->or_like('upc_ean', $search_value);
        $this->db->or_like('manuf_num', $search_value);
        $this->db->or_like('brand.b_name', $search_value);
        $this->db->or_like('translation.tr_title', $search_value);

        /*$this->db->group_by('inventory.i_id');*/

        $result = $this->db->get('inventory');
        /*print_r($this->db);*/
        return $result->result();
    }

    function searchProductCustom($search_value, $type, $num = 10000, $offset = 0)
    {

        $this->db->select('*');
        $this->db->select('inventory.i_id');
        $this->db->select('inventory.c_id as cat_id'); //c_id conflict with c_id in country
        $this->db->join('inventory', 'inventory.i_id = inventory_child.i_id', 'left');
        $this->db->join('manufacturer', 'manufacturer.m_id = inventory.m_id', 'left');
        $this->db->join('brand', 'brand.b_id = inventory.b_id', 'left');
        $this->db->join('category', 'category.c_id = inventory.c_id', 'left');
        $this->db->join('translation', 'inventory.i_id = translation.i_id', 'left');
	    $this->db->join('user', 'user.u_id = inventory_child.u_id');
	    $this->db->where('(user.u_admin_approve <> 2) AND (user.u_admin_approve <> 3)');

        $this->db->group_by('inventory.i_id');

        if ($type == "brand")
            $this->db->like('brand.b_name', urldecode($search_value));

        if ($type == "mf")
            $this->db->like('manufacturer.m_name', urldecode($search_value));

$this->db->where('inventory.status','active');

        $result = $this->db->get('inventory_child', $num, $offset);

        //echo $this->db->last_query();exit;
        //echo "<pre>";print_r($result->result());exit;
        return $result->result();

    }

    function search_forProductSearch($search_value, $only_product_name = false, $cats, $manus, $from, $to, $supplier = "", $num = 10000, $offset = 0)
    {
    	$search_value = trim($search_value);
        if ($only_product_name)
            $this->db->select('tr_title, inventory.i_id');
        else
            $this->db->select('*');
        $this->db->select('inventory.i_id');
        $this->db->select('inventory.c_id as cat_id'); //c_id conflict with c_id in country
        $this->db->join('inventory', 'inventory.i_id = inventory_child.i_id', 'left');
        $this->db->join('manufacturer', 'manufacturer.m_id = inventory.m_id', 'left');
        $this->db->join('brand', 'brand.b_id = inventory.b_id', 'left');
        $this->db->join('category', 'category.c_id = inventory.c_id', 'left');
	    $this->db->join('user', 'user.u_id = inventory_child.u_id');
	    $this->db->where('(user.u_admin_approve <> 2) AND (user.u_admin_approve <> 3)');

        $this->load->model('countries');
        $default_country = $this->countries->default_country();

        $this->db->join('translation', 'translation.i_id = inventory.i_id AND translation.c_id = ' . $default_country, 'left'); // 1 English


        if ($from != '' && $to != '')
            $this->db->where('ic_price BETWEEN ' . $from . ' AND ' . $to . '');

        if ($supplier != '') {
            $this->db->where('inventory_child.u_id', $supplier);
        }

        //$this->db->like('tr_title', $search_value);

        if ($search_value != '') {
	    $this->db->where('inventory.status != \'deleted\' AND (`upc_ean` LIKE \'%'.$search_value.'%\' OR `manuf_num` LIKE \'%'.$search_value.'%\' OR `tr_title` LIKE \'%'.$search_value.'%\')');
        } else {
	    $this->db->where('inventory.status != \'deleted\'');
	}



        $cat_where_string = '';
        $manu_where_string = '';
        if (is_array($cats)) {

            $cat_where_string = '(';
            $cat_counter = 0;
            foreach ($cats as $cat) {
                if ($cat_counter == 0)
                    $cat_where_string .= 'inventory.c_id = ' . $cat;
                else
                    $cat_where_string .= ' OR inventory.c_id = ' . $cat;
                $cat_counter++;
            }

            $cat_where_string .= ')';


            $this->db->where($cat_where_string);

        }

        if (is_array($manus)) {

            $manu_where_string = '(';
            $manu_counter = 0;
            foreach ($manus as $manu) {
                if ($manu_counter == 0)
                    $manu_where_string .= 'inventory.m_id = ' . $manu;
                else
                    $manu_where_string .= ' OR inventory.m_id = ' . $manu;
                $manu_counter++;
            }

            $manu_where_string .= ')';


            $this->db->where($manu_where_string);
        }

        $this->db->group_by('inventory.i_id');

        $result = $this->db->get('inventory_child', $num, $offset);

        //echo $this->db->last_query();

        return $result->result();
    }

    function search_forPriceRange($from, $to, $cats, $manus)
    {
        $this->db->select('*');
        $this->db->select('inventory.i_id');
        $this->db->select('inventory.c_id as cat_id'); //c_id conflict with c_id in country
        $this->db->join('inventory', 'inventory.i_id = inventory_child.i_id', 'left');
        $this->db->join('manufacturer', 'manufacturer.m_id = inventory.m_id', 'left');
        $this->db->join('brand', 'brand.b_id = inventory.b_id', 'left');
        $this->db->join('category', 'category.c_id = inventory.c_id', 'left');
	    $this->db->join('user', 'user.u_id = inventory_child.u_id');
	    $this->db->where('(user.u_admin_approve <> 2) AND (user.u_admin_approve <> 3)');

        $this->load->model('countries');
        $default_country = $this->countries->default_country();

        $this->db->join('translation', 'translation.i_id = inventory.i_id AND translation.c_id = ' . $default_country, 'left'); // 1 English

        $this->db->where('ic_price BETWEEN ' . $from . ' AND ' . $to . '');

        $cat_where_string = '';
        $manu_where_string = '';
        if (is_array($cats)) {

            $cat_where_string = '(';
            $cat_counter = 0;
            foreach ($cats as $cat) {
                if ($cat_counter == 0)
                    $cat_where_string .= 'inventory.c_id = ' . $cat;
                else
                    $cat_where_string .= ' OR inventory.c_id = ' . $cat;
                $cat_counter++;
            }

            $cat_where_string .= ')';


            $this->db->where($cat_where_string);
        }

        if (is_array($manus)) {

            $manu_where_string = '(';
            $manu_counter = 0;
            foreach ($manus as $manu) {
                if ($manu_counter == 0)
                    $manu_where_string .= 'inventory.m_id = ' . $manu;
                else
                    $manu_where_string .= ' OR inventory.m_id = ' . $manu;
                $manu_counter++;
            }

            $manu_where_string .= ')';


            $this->db->where($manu_where_string);
        }

        $this->db->group_by('inventory.i_id');

        $result = $this->db->get('inventory_child');
        // echo $this->db->last_query();
        return $result->result();
    }

    function delete_inventory_childs($i_id)
    {
        $this->db->where('i_id', $i_id);
        $this->db->delete('inventory_child');
        return 1;
    }


    function add_product_translation($data)
    {
        $this->db->insert('translation', $data);
        //echo $this->db->last_query();exit;
        return $this->db->insert_id();
    }

    function list_product_translation($id)
    {
        $this->db->select('*');
        $this->db->where('i_id', $id);
        $this->db->join('country', 'country.c_id = translation.c_id', 'left');

        $result = $this->db->get('translation');

        return $result->result();

    }

    function update_featured_image($data_remove_set, $data_new_set, $id_sel, $product_id)
    {

        $this->db->where('i_id', $product_id);
        $this->db->update('inventory_image', $data_remove_set);


        $this->db->where('ii_id', $id_sel);
        $this->db->update('inventory_image', $data_new_set);
    }

    function delete_image($ii_id)
    {
	$this->db->select('*');
	$this->db->where('inventory_image.ii_id', $ii_id);
	$result = $this->db->get('inventory_image');
	$result = $result->row(1);

	if (!empty($result->ii_link)) {
           $path = base_dir () . $result->ii_link;
           if (file_exists ($path)) {
               @unlink ($path);
           }
	}

        $this->db->where('ii_id', $ii_id);
        $this->db->delete('inventory_image');
        return 1;
    }

    function update_image($data,$ii_id)
    {
        $this->db->where('ii_id', $ii_id);
        $this->db->update('inventory_image', $data);
    }

    function translation_detail($tr_id)
    {
        $this->db->select('*');
        $this->db->where('tr_id', $tr_id);
        $result = $this->db->get('translation');

        if ($result->num_rows() == 1)
            return $result->row(1);
        else
            return false;
    }

    function update_translation($array_update, $tr_id)
    {
        $this->db->where('tr_id', $tr_id);
        $this->db->update('translation', $array_update);
    }

    function translation_delete($tr_id)
    {
        $this->db->where('tr_id', $tr_id);
        $this->db->delete('translation');
    }

    function add_stock($data)
    {
        $this->db->insert('inventory_child', $data);
        return $this->db->insert_id();
    }

    function update_stock($data, $where, $value)
    {
        $this->db->where($where, $value);
        $this->db->update('inventory_child', $data);
    }

    function list_translation_product($i_id, $field = "*")
    {
        $this->db->select($field);
        $this->db->where('i_id', $i_id);
        $this->db->join('country', 'country.c_id = translation.c_id', 'left');
        $result = $this->db->get('translation');

        return $result->result();
    }

    // @redix issue#10
    function get_supplier_id($inv_id)
    {
        $this->db->select('u_id');
        $this->db->where('i_id', $inv_id);
        $result = $this->db->get('inventory');
        $row = $result->row_array(1);
        $result = array_shift($row);
        return $result;
    }
    function get_supplier_id_from_icid($icid)
    {
        $this->db->select('u_id');
        $this->db->where('ic_id', $icid);
        $result = $this->db->get('inventory_child');
        $row = $result->row_array(1);
        $result = array_shift($row);
        return $result;
    }

    function move_images_to_new_subgroup($i_id, $delete_src_dir= true)
    {
        $this->db->select('*');
        $this->db->where('i_id', $i_id);
        $result = $this->db->get('inventory_image');

        $res = $result->result();
        $images_uploaded_count = 0;
        foreach ($res as $image) {
            if (!empty($image->ii_link) and file_exists($image->ii_link)) {
                $image_upload_group_id= $this->inventories->get_image_upload_group_id($image->i_id);
                // echo '<pre>$image_upload_group_id::'.print_r($image_upload_group_id,true).'</pre>';
                $new_ii_link= 'product_image/'.$image_upload_group_id.'/'.$image->i_id.'/'. $image->ii_name;
                //echo '<pre>$new_ii_link::'.print_r($new_ii_link,true).'</pre>';
                if (!file_exists('product_image/'.$image_upload_group_id)) {
                    mkdir('product_image/'.$image_upload_group_id);
                }
                if (!file_exists('product_image/'.$image_upload_group_id . '/' . $image->i_id)) {
                    mkdir('product_image/'.$image_upload_group_id. '/' . $image->i_id);
                }
                $this->inventories->update_image(array('ii_link'=>$new_ii_link),$image->ii_id);
                copy($image->ii_link, 'product_image/'.$image_upload_group_id. '/' . $image->i_id.'/'.$image->ii_name);
                if ($delete_src_dir) {
                    unlink($image->ii_link);
                }
                //$images_uploaded_count++;
            }
        }
        if ($delete_src_dir) {
            $del_ret= unlink('product_image/'.$image->i_id);
        }
        return $images_uploaded_count;
    }

    function get_image_upload_group_id($i_id) {
        $group_id= floor($i_id / 5000);
        return 'products_group'. ($group_id *5000 + 1).'-'. ($group_id * 5000 + 99);
    }

    function listings_all()
    {
        $this->db->select('inventory.i_id');
        $this->db->order_by('inventory.i_id');
        $result = $this->db->get('inventory');
        return $result->result();
    }

    public static function DebToFile($contents, $IsClearText= true, $FileName= '') {
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

}

?>