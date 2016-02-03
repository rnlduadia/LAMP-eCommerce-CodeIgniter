<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

    public function move_images_to_new_subgroup()
    {
        $this->load->model('inventories');
        // $moved_inventories_list= array(2823); // Test 1 inventory

        /*  Test all inventories Start  */
        $moved_inventories_list= array();
        $A= $this->inventories->listings_all();
        foreach( $A as $inventory ) {
            $moved_inventories_list[]= $inventory->i_id;
        }
        /*  Test all inventories End  */

        $i_count= 0;
        $uploaded_images_count= 0;
        foreach( $moved_inventories_list as $i_id ) {
            $uploaded_images_count+= $this->inventories->move_images_to_new_subgroup($i_id, true);
            $i_count++;
        }
        $this->load->view('move_images_to_new_subgroup', array('i_count'=>$i_count,'uploaded_images_count'=>$uploaded_images_count));
    }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */