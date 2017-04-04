<?php
class Address extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url_helper');
                $this->load->library('tank_auth');
                $this->load->model('Address_model');
                $this->load->model('Cluster_model');

                $name = debug_backtrace()[1]['function'];

                if (!$this->tank_auth->is_logged_in() && ($name == 'delete' || $name == 'modify' || $name == 'add')) {
                    $ret['success'] = 0;
                    $ret['msg'] = 'User not authorized!';
                    header('Content-Type: application/json');
                    echo json_encode($ret);
                    exit();
                }
        }

        public function index()
        {
            $cluster_id = max($this->input->get('cluster_id'), -1);

            $order = array(
                0 =>array(
                    'category' => 'id',
                    'type' => 'asc', 
                    )
                );
            $address=$this->Address_model->get_address(-1,$cluster_id,$order);
            $ret = array();

            if($cluster_id > -1)
            {
                foreach ($address as $key => $value) {
                    $clstr = $this->Cluster_model->get_cluster($cluster_id);
                    if(!isset($ret[$clstr['id']]))
                        $ret[$clstr['id']] = array('name'=>$clstr['name'],'location'=>array());

                    array_push($ret[$clstr['id']]['location'], $value);
                }
            }
            else
            {
                foreach ($address as $key => $value) {
                    $clstr = $this->Cluster_model->get_cluster($value['cluster']);
                    $address[$key]['cluster'] = $clstr;
                    $ret = $address;
                }  
            }

            header('Content-Type: application/json');
            echo json_encode($ret);
        
        }


        public function search()
        {
            $ret = array('top'=>array());
            $limit = 0;
            if(empty($this->input->get('limit')))
                $limit = 0;
            else
                $limit = $this->input->get('limit');
            $ret['top'] = $this->Address_model->search_address($this->input->get('params'), $this->input->get('limit'));

            header('Content-Type: application/json');
            echo json_encode($ret);     
        }

        public function modify()
        {
            $ret = array('success'=>0);

            $params = $this->input->get('params');
            
            $ret['success'] = $this->Address_model->set_address($params);
            
            $ret['params'] = $params;
            header('Content-Type: application/json');
            echo json_encode($ret); 
        }

        public function delete()
        {
            $ret = array('success'=>0);

            $id = intval($this->input->post('id'));
            
            $ret['success'] = $this->Address_model->delete_address($id);
            header('Content-Type: application/json');
            echo json_encode($ret); 
        }

        public function add()
        {
            $ret = array('success'=> 0);

            $params = $this->input->post('params');
            if(!isset($params['duplicate']))
                $params['duplicate'] = TRUE;
            
            if( empty($this->Address_model->search_address($params, 1)))
            {
                unset($params['duplicate']);
                $this->Address_model->set_address($params);
                $ret['success'] = 1;
            }
            header('Content-Type: application/json');
            echo json_encode($ret); 
        }

        public function get_tags()
        {
            $ret = array();
            $attr = $this->input->get('attr');
            $value = $this->input->get('value');

            $all = $this->Address_model->search_address(array($attr=>$value,'tags'=>TRUE),10); 
            $ret['params'] = array($attr=>$value);
            $tags = array();
                    // array_push($tags, $all);
            foreach ($all as $key => $value) {
                if(!in_array($value[$attr], $tags) && !empty($value[$attr]))
                    array_push($tags, $value[$attr]);
                // if($key > 10)
                //     break;
            }
            // $tags = array_slice($tags, 0,5);
            $ret['tags'] = $tags;

            header('Content-Type: application/json');
            echo json_encode($ret);             
        }
}