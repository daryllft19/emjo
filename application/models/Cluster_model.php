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
		        		$this->db->order_by('id');
		                $query = $this->db->get('cluster');
		                return $query->result_array();
		        }

		        $query = $this->db->get_where('cluster', array('id' => $id));
		        return $query->row_array();
		}

		public function set_cluster($data)
		{

		    try{
			    $id = 0;
			    if(isset($data['id'])){
			    	$id = $data['id'];
			    	unset($data['id']);
			    }

			    if($this->count($id)['count'] > 0 )
			    	return array('error'=>'Cannot modify if cluster contains packages.','info'=>$this->count($id));

			    if($id > 0){
			    	$this->db->where('id',$id);
			    	return $this->db->update('cluster',$data);
			    }
			    else{
			    	$this->db->insert('cluster', $data);
			    }
			    return 1;
		    }
		    catch(Exception $e)
		    {
			    return array('error'=>$e);
		    }
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

        public function delete($id){
			try{
			    if($this->count($id)['count'] > 0 )
			    	return array('error'=>'Cannot modify if cluster contains packages.','info'=>$this->count($id));

	        	$this->db->where_in('id',$id);
	        	$this->db->delete('cluster');
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

        public function export($id){
        	$address = $this->Address_model->search_address(array('cluster'=>$id));
        	$address_id = array();

			try{
				foreach ($address as $key => $value) {
					array_push($address_id, $value['id']);
				}
				$this->db->select('serial_no, length, width, height, weight, height_constraint, weight_constraint, arrival_date,is_fragile');
	        	$this->db->where_in('address',$address_id);
	        	// $this->db->get('package');
	        	// $query = $this->db->get('package');
	        	$query = $this->db->get('package');
	        	return $query->result_array();
			}
			catch(Exception $e)
			{
				return array('count'=>0);
			}			
        }
}