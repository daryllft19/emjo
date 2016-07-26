<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct() {        
	    parent::__construct();
	    $this->load->model('Cluster_model');
	    $this->load->model('Address_model');
	    $this->load->model('Package_model');
	    $this->load->helper('form');
	    $this->load->library('tank_auth');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index($page='auth')
	{


		redirect('auth');
		
		//if(!empty($page))
		//{
		//	redirect('auth');
		//}
		//$this->$page();
	}


	public function cluster()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}

		$data['cluster']=$this->Cluster_model->get_cluster();
		$this->load->view('template/view_header');
		$this->load->view('template/view_top');
		$this->load->view('template/view_menu');
		$this->load->view('cluster/view_content',$data);
		$this->load->view('template/view_footer');

	}

	public function address()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}

		$order = array(
				0 =>array(
					'category' => 'id',
					'type' => 'asc', 
					)
				);
		$data['address']=$this->Address_model->get_address(-1,-1,$order);
		$this->load->view('template/view_header');
		$this->load->view('template/view_top');
		$this->load->view('template/view_menu');
		$this->load->view('address/view_content',$data);
		$this->load->view('template/view_footer');

	}

	public function package()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}

		$data['package']=$this->Package_model->get_package();
		$this->load->view('template/view_header');
		$this->load->view('template/view_top');
		$this->load->view('template/view_menu');
		$this->load->view('package/view_content',$data);
		$this->load->view('template/view_footer');

	}

	public function form()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}

		$order = array(
				0 =>array(
					'category' => 'cluster',
					'type' => 'asc', 
					),
				1 =>array(
					'category' => 'keywords',
					'type' => 'asc', 
					)
				);
		$data['container']=$this->Address_model->get_address(-1,-1,$order);
		$this->load->view('template/view_header');
		$this->load->view('template/view_top');
		$this->load->view('template/view_menu');
		$this->load->view('form/add_content', $data);
		$this->load->view('template/view_footer');
	}

	public function add()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}

		$this->load->helper('form');
        $this->load->library('form_validation');

		$this->form_validation->set_rules('container', 'container', 'required');
		$this->form_validation->set_rules('length', 'Length', 'required');
		$this->form_validation->set_rules('width', 'Width', 'required');
		$this->form_validation->set_rules('height', 'Height', 'required');
		$this->form_validation->set_rules('weight', 'Weight', 'required');


		if ($this->form_validation->run() === FALSE)
		{
			echo '<script>alert("Wrong input!")</script>';
			$this->index('form');
		}
		else
		{

			$this->Package_model->set_package();
			// redirect(base_url('index.php/index/package'));
		}

	}

	public function analytics()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}

		$this->load->view('template/view_header');
		$this->load->view('template/view_top');
		$this->load->view('template/view_menu');
		$this->load->view('analytics/view_content');
		$this->load->view('template/view_footer');
	}

	public function export()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$this->load->view('template/view_header');
		$this->load->view('template/view_top');
		$this->load->view('template/view_menu');
		$this->load->view('export/view_content');
		$this->load->view('template/view_footer');
	}

}
