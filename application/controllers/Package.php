<?php
class Package extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url_helper');
                $this->load->model('Package_model');
                $this->load->model('Address_model');
        }

        public function index()
        {
            $cluster_id = $this->input->get('cluster_id');
            $ret = $this->Package_model->get_package(-1,$cluster_id);
            foreach ($ret as $key => $value) {
                $addr = $this->Address_model->get_address($ret[$key]['address']);
                $ret[$key]['address'] = $addr;
            }  
            header('Content-Type: application/json');
            echo json_encode($ret);
        }

}