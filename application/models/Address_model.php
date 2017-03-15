<?php
class Address_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
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
			$this->db->select('*');
			$this->db->from('address');
			if ($limit >0)
				$this->db->limit($limit);
			$sort = 'city';
			foreach ($filter as $key => $value) {
				$this->db->like($key,$value);
				if(!empty($value))
					$sort = $key;
			}

			$this->db->order_by($sort,'asc');
			$query = $this->db->get();
			return $query->result_array();
			
		}

		public function set_address()
		{

			/*MALI!*/
		    $this->load->helper('url');

		    $data = array(
		        'name' => $this->input->post('name'),
		        'city' => $this->input->post('city')
		        // 'keywords' => $this->input->post('keywords')
		    );

		    return $this->db->insert('cluster', $data);
		}

}