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
            $ret['cluster'] = $this->Cluster_model->get_cluster($cluster_id);
            // $ret
            header('Content-Type: application/json');
            echo json_encode($ret);
        }

        public function add()
        {
            $ret = array();
            try{
                $params = $this->input->post('params');
                $address = $params['address'];
                $length = $params['length'];
                $width = $params['width'];
                $height = $params['height'];
                $weight = $params['weight'];
                $fragile = $params['fragile'];
                $height_constraint = $params['height_constraint'];
                $weight_constraint = $params['weight_constraint'];

                if($address <= 0 || $length <= 0 || $width <= 0 || $height <= 0 || $weight <= 0)
                    throw new Exception("Error Processing Request", 1);
                    

                $return_value = $this->Package_model->set_package('0000000',$address, $length, $width, $height, $weight, $fragile, $height_constraint, $weight_constraint);
                $ret['success'] = $return_value;
            }
            catch(Exception $e)
            {
                $ret['success'] = 0;
                $ret['msg'] = 'Error!';
            }
            // $ret
            header('Content-Type: application/json');
            echo json_encode($ret);   
        }

}