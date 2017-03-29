<?php
class Address_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->model('Cluster_model');
        }


		public function get_address($id = -1,$cluster=-1,$order= array())
		{
				foreach ($order as $order_item):
                	$this->db->order_by($order_item['category'],$order_item['type']);
                endforeach;

                if ($cluster != -1){
                		//$query = $this->db->get('address');
						$query = $this->db->get_where('address', array('cluster' => $cluster));
		                return $query->result_array();
                }
		        else if ($id == -1)
		        {
						$query = $this->db->get('address');
		                return $query->result_array();
		        }

		        $query = $this->db->get_where('address', array('id' => $id));
		        return $query->row_array();
		}

		public function search_address($filter=array(), $limit=0)
		{
			$query = '';
			$duplicate = FALSE;
			$tags = FALSE;
			if(isset($filter['tags']) && $filter['tags'] == TRUE)
			{
				unset($filter['tags']);
				$tags = TRUE;
			}
			if(isset($filter['duplicate']) && $filter['duplicate'] == 'true')
			{
				unset($filter['duplicate']);
				$duplicate = TRUE;
			}
			if(isset($filter['cluster']) && $filter['cluster'] == -1)
			{
				$this->db->order_by('id','asc');
				$query = $this->db->get('address');
			}
			elseif ($tags) {
				$this->db->distinct();
				foreach ($filter as $key => $value) {
					$this->db->select($key);
					$this->db->ilike($key,$value);
				}
				if ($limit >0)
					$this->db->limit($limit);
				$this->db->from('address');
				$query = $this->db->get();
				return $query->result_array();
			}
			else
			{
				$this->db->select('*');
				$this->db->from('address');
				if ($limit >0)
					$this->db->limit($limit);
				$sort = 'cluster, province, city, barangay, district, area, avenue, street';
				foreach ($filter as $key => $value) {
					if($key == 'cluster')
					{
						$this->db->where($key,$value);
					}
					else
					{
						if($duplicate == TRUE)
							$this->db->ilike($key,$value,'none');
						else
						{
							$this->db->ilike($key,$value);
							// if(!empty($value))
							// 	$sort = $key;
						}
					}

				}

				$this->db->order_by($sort,'asc');
				$query = $this->db->get();
				// return $query->result_array();
			}

				$all = $query->result_array();
				foreach ($all as $key => $value)
				{
					$clstr = $all[$key]['cluster'];
					$all[$key]['cluster'] = $this->Cluster_model->get_cluster($clstr)['name'];	
				}
				return $all;
			
		}

		public function set_address($data)
		{

			/*MALI!*/
		    $this->load->helper('url');
		    
		    $id = 0;
		    if(isset($data['id'])){
		    	$id = $data['id'];
		    	unset($data['id']);
		    }
		    try{
			    if($id > 0){
			    	$this->db->where('id',$id);
			    	$this->db->update('address',$data);
			    }
			    else{
			    	$this->db->insert('address', $data);
			    }
			    return 1;
		    }
		    catch(Exception $e)
		    {
		    	return 0;
		    }
		}

		public function delete_address($id)
		{

			/*MALI!*/
		    $this->load->helper('url');
		    

		    try{
			    $this->db->where('id',$id);
			    $this->db->delete('address');
			    
			    return 1;
		    }
		    catch(Exception $e)
		    {
		    	return 0;
		    }
		}

}