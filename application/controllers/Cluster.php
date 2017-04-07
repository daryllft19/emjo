<?php
class Cluster extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                // $this->load->helper('url_helper');
                $this->load->model('Address_model');
                $this->load->library('tank_auth');
                header('Content-Type: application/json');

                $name = $this->router->fetch_method();

                if (!$this->tank_auth->is_logged_in() && ($name == 'delete' || $name == 'modify' || $name == 'clear')) {
                    $ret['success'] = 0;
                    $ret['msg'] = 'User not authorized!';
                    echo json_encode($ret);
                    exit();
                }
        }

        public function index()
        {
        }

        public function clear()
        {
            $cluster_id = $this->input->get('cluster_id');
            $ret = array('success'=>0);
            $ret['success'] = $this->Cluster_model->clear($cluster_id);
            header('Content-Type: application/json');
            echo json_encode($ret);   
        }

        public function count()
        {
            $cluster_id = $this->input->get('cluster_id');
            $ret = array();
            $ret = $this->Cluster_model->count($cluster_id);
            header('Content-Type: application/json');
            echo json_encode($ret);
        }

        public function modify()
        {
            $ret = array();

            $params = $this->input->post('params');
            
            $ret['response'] = $this->Cluster_model->set_cluster($params);
            $ret['params'] = $params;
            header('Content-Type: application/json');
            echo json_encode($ret); 
        }

        public function delete()
        {
            $cluster_id = $this->input->get('cluster_id');
            $ret = array();
            $ret['success'] = $this->Cluster_model->delete($cluster_id);
            header('Content-Type: application/json');
            echo json_encode($ret);
        }


}