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
		header('Content-Type: application/json');

		$name = $this->router->fetch_method();

		if (!$this->tank_auth->is_logged_in()  && ($name != 'login' && $name != 'is_authorized')) {
                    $ret['success'] = 0;
                    $ret['msg'] = 'User not authorized!';
                    echo json_encode($ret);
                    exit();
            }
	}

	function index()
	{	
		// redirect('/AuthHandler/login');
		echo 'Nothing to see here!';
	}
	function login()
	{
		$ret = array();
		$data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
					$this->config->item('use_username', 'tank_auth'));
		$data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

		$password = $this->input->post('password');
		if ($this->tank_auth->login(
				'admin',
				$password,
				0,
				$data['login_by_username'],
				$data['login_by_email'])) {								// success
					$ret['success'] = 1;
				}

		// $this->get->post
		// $ret
        echo json_encode($ret);
	}

	function change()
	{
		$ret = array();

		$params = $this->input->post('params');
		try{
			// $ret['params'] = $params;
			if($params['new'] == '')
				throw new Exception("Blank new password!", 1);
				
			$ret['success'] = $this->tank_auth->change_password($params['old'],$params['new']);
		}
		catch(Exception $e)
		{
			$ret['success'] = 0;
			$ret['msg'] = $e;
		}
        echo json_encode($ret);	
	}

	function is_authorized()
	{
		$ret = array();

		$ret['response'] = $this->tank_auth->is_logged_in();

        echo json_encode($ret);	
	}

	function logout()
	{
		$this->tank_auth->logout();
		redirect($this->input->get('redirect'));
	}

}