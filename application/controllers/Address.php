<?php
class Address extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url_helper');
        }

        public function address()
        {
            $data['address']=$this->Address_model->get_address();
            $this->load->view('template/view_header');
            $this->load->view('template/view_top');
            $this->load->view('template/view_menu');
            $this->load->view('address/view_content',$data);
            $this->load->view('template/view_footer');
            
        }
}