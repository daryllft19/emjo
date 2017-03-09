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
            $order = array(
                0 =>array(
                    'category' => 'id',
                    'type' => 'asc', 
                    )
                );
            $address=$this->Address_model->get_address(-1,$this->input->get('cluster_id'),$order);
            foreach ($address as $key => $value) {
                $clstr = $this->Cluster_model->get_cluster($this->input->get('cluster_id'));
                if(!isset($ret[$clstr['id']]))
                    $address[$clstr['id']] = array('name'=>$clstr['name'],'location'=>array());

                array_push($address[$clstr['id']]['location'], $value);
            }

            header('Content-Type: application/json');
            echo json_encode($address);
        
        }
}