<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AuthHandler extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
	}

	function index()
	{	
		// redirect('/AuthHandler/login');
		echo 'Nothing to see here!';
	}
	function login()
	{
		$ret = array();

		// if ($this->tank_auth->login(
		// 		$this->form_validation->set_value('login'),
		// 		$this->form_validation->set_value('password'),
		// 		$this->form_validation->set_value('remember'),
		// 		$data['login_by_username'],
		// 		$data['login_by_email'])) {								// success
		// 			redirect('');
		// 		}

		// $this->get->post
		// $ret
		$test = $this->input->post('password');
        echo json_encode($test);
	}

}