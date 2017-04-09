<?php
class Setting extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                // $this->load->helper('url_helper');
                $this->load->model('Setting_model');
                $this->load->library('tank_auth');
                header('Content-Type: application/json');

                if (!$this->tank_auth->is_logged_in()) {
                    $ret['success'] = 0;
                    $ret['msg'] = 'User not authorized!';
                    echo json_encode($ret);
                    exit();
                }
        }

        public function save(){
            $ret = array();
            
            try{
                $params = $this->input->post('params');

                $ret['success'] = $this->Setting_model->save($params);
            }
            catch(Exception $e)
            {
                $ret['error'] = 1;
            }
            echo json_encode($ret);
        }
    }