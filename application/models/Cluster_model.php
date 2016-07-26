<?php
class Cluster_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

		public function get_cluster($id = -1)
		{
		        if ($id == -1)
		        {
		                $query = $this->db->get('cluster');
		                return $query->result_array();
		        }

		        $query = $this->db->get_where('cluster', array('id' => $id));
		        return $query->row_array();
		}

		public function set_cluster()
		{

			/*MALI!*/
		    $this->load->helper('url');

		    $data = array(
		        'name' => $this->input->post('name'),
		        'city' => $this->input->post('city'),
		        'keywords' => $this->input->post('keywords')
		    );

		    return $this->db->insert('cluster', $data);
		}

		public function generate_candidates($packages)
		{
			
		}


}