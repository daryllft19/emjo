<?php
class Setting_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function save($dArgs)
        {
        	try{
        		$this->db->update('admin_settings',$dArgs);
        		return 1;
        	}
        	catch(Exception $e)
        	{
        		return 0;
        	}
        } 

        public function get_admin_settings()
        {
        	$query = $this->db->get('admin_settings');
        	return $query->result_array();
        }

}