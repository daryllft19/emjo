<?php
class Package extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url_helper');
                $this->load->model('Package_model');
                $this->load->model('Address_model');
                $this->load->model('Cluster_model');
        }

        public function index()
        {
            $cluster_id = $this->input->get('cluster_id');
            $ret = array();
            $ret['packages'] = $this->Package_model->get_package(-1,$cluster_id);
            foreach ($ret['packages'] as $key => $value) {
                $addr = $this->Address_model->get_address($ret['packages'][$key]['address']);
                $ret['packages'][$key]['address'] = $addr;
            }  
            header('Content-Type: application/json');
            $ret['cluster'] = $this->Cluster_model->get_cluster($cluster_id);
            // $ret
            echo json_encode($ret);
        }

}