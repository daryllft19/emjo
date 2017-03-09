<?php
class Cluster extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url_helper');
        }

        public function cluster()
        {
            $data['cluster']=$this->Cluster_model->get_cluster();
            $this->load->view('template/view_header');
            $this->load->view('template/view_top');
            $this->load->view('template/view_menu');
            $this->load->view('cluster/view_content',$data);
            $this->load->view('template/view_footer');
            
        }
}