<?php
class Cluster_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
                $this->load->model('Address_model');
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

        public function clear($id){
        	$address = $this->Address_model->search_address(array('cluster'=>$id));
			$address_id = array();
			try{
				foreach ($address as $key => $value) {
					array_push($address_id, $value['id']);
				}
	        	$this->db->where_in('address',$address_id);
	        	// $this->db->get('package');
	        	// $query = $this->db->get('package');
	        	$this->db->delete('package');
	        	return 1;
			}
			catch(Exception $e)
			{
				return 0;
			}
        }

        public function count($id){
        	$address = $this->Address_model->search_address(array('cluster'=>$id));
			$address_id = array();
			try{
				foreach ($address as $key => $value) {
					array_push($address_id, $value['id']);
				}
				$this->db->select('count(id)');
	        	$this->db->where_in('address',$address_id);
	        	// $this->db->get('package');
	        	// $query = $this->db->get('package');
	        	$query = $this->db->get('package');
	        	return $query->row_array();
			}
			catch(Exception $e)
			{
				return array('count'=>0);
			}
        }
}