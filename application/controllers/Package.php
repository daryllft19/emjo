<?php
class Package extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url_helper');
        }

        public function package()
        {
            $data['package']=$this->Package_model->get_package();
            $this->load->view('template/view_header');
            $this->load->view('template/view_top');
            $this->load->view('template/view_menu');
            $this->load->view('package/view_content',$data);
            $this->load->view('template/view_footer');
            
        }

}