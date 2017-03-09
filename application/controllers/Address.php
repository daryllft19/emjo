<?php
class Address extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url_helper');
                $this->load->library('tank_auth');
                $this->load->model('Address_model');
                $this->load->model('Cluster_model');
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
}