<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

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
	public function index($page='package')
	{


		// redirect('index/'.$page);
		if(!empty($page))
		{
			redirect('index/'.$page);
		}
		redirect('index/package');
		// $this->$page();
	}


	public function cluster()
	{
		// if (!$this->tank_auth->is_logged_in()) {
		// 	redirect('/auth/login/');
		// }

		$data['cluster']=$this->Cluster_model->get_cluster();
		$this->load->view('template/view_header');
		$this->load->view('template/view_top');
		$this->load->view('template/view_menu');
		$this->load->view('cluster/view_content',$data);
		$this->load->view('template/view_footer');

	}

	public function address()
	{
		// if (!$this->tank_auth->is_logged_in()) {
		// 	redirect('/auth/login/');
		// }

		$order = array(
				0 =>array(
					'category' => 'id',
					'type' => 'asc', 
					)
				);
		$address=$this->Address_model->get_address(-1,-1,$order);
        foreach ($address as $key => $value) {
            $clstr = $this->Cluster_model->get_cluster($value['cluster']);
            $address[$key]['cluster'] = $clstr;
        }

        $ret = array();
        $temp=$this->Address_model->get_address(-1,-1,$order);
        foreach ($temp as $key => $value) {
        	$clstr = $this->Cluster_model->get_cluster($value['cluster']);
        	if(!isset($ret[$clstr['id']]))
        		$ret[$clstr['id']] = array('name'=>$clstr['name'],'location'=>array());

        	array_push($ret[$clstr['id']]['location'], $value);
        }
		$data['address']=$address;
		$data['ret']=$ret;
		$this->load->view('template/view_header');
		$this->load->view('template/view_top');
		$this->load->view('template/view_menu');
		$this->load->view('address/view_content',$data);
		$this->load->view('template/view_footer');

	}

	public function package()
	{
		// if (!$this->tank_auth->is_logged_in()) {
		// 	redirect('/auth/login/');
		// }

		$data['package']=$this->Package_model->get_package();
		// $data['cluster']=$this->Cluster_model->get_cluster();
		$data['address']=$this->Address_model->get_address();

		$order = array(
				0 =>array(
					'category' => 'id',
					'type' => 'asc', 
					)
				);

        $ret = array();
        $temp=$this->Address_model->get_address(-1,-1,$order);
        foreach ($temp as $key => $value) {
        	$clstr = $this->Cluster_model->get_cluster($value['cluster']);
        	if(!isset($ret[$clstr['id']]))
        		$ret[$clstr['id']] = array('name'=>$clstr['name'],'location'=>array());

        	array_push($ret[$clstr['id']]['location'], $value);
        }
		$data['ret']=$ret;

		$this->load->view('template/view_header');
		$this->load->view('template/view_top');
		$this->load->view('template/view_menu');
		$this->load->view('package/view_content',$data);
		$this->load->view('template/view_footer');

	}

	public function form()
	{
		// if (!$this->tank_auth->is_logged_in()) {
		// 	redirect('/auth/login/');
		// }

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


		$this->load->helper('form');
        $this->load->library('form_validation');

		$this->form_validation->set_rules('container', 'container', 'required');
		$this->form_validation->set_rules('length', 'Length', 'required');
		$this->form_validation->set_rules('width', 'Width', 'required');
		$this->form_validation->set_rules('height', 'Height', 'required');
		$this->form_validation->set_rules('weight', 'Weight', 'required');

		$container_id = $this->input->post('container');
		$length = $this->input->post('length');
		$width = $this->input->post('width');
		$height = $this->input->post('height');
		$weight = $this->input->post('weight');
		$fragile = $this->input->post('fragile');
		
		$data['length'] = $length;
		$data['width'] = $width;
		$data['height'] = $height;
		$data['weight'] = $weight;
		
		if ($this->form_validation->run() === TRUE)
		{
			$this->add($container_id, $length, $width, $height, $weight, $fragile);
			// echo '<script>alert("Wrong input!")</script>';
			// $this->index('form');
		}

		$this->load->view('template/view_header');
		$this->load->view('template/view_top');
		$this->load->view('template/view_menu');
		$this->load->view('form/add_content', $data);
		$this->load->view('template/view_footer');


		
		
	}

	public function add($container_id, $length, $width, $height,  $weight, $fragile)
	{
		// if (!$this->tank_auth->is_logged_in()) {
		// 	redirect('/auth/login/');
		// }

		$this->load->helper('form');
  //       $this->load->library('form_validation');

		// $this->form_validation->set_rules('container', 'container', 'required');
		// $this->form_validation->set_rules('length', 'Length', 'required');
		// $this->form_validation->set_rules('width', 'Width', 'required');
		// $this->form_validation->set_rules('height', 'Height', 'required');
		// $this->form_validation->set_rules('weight', 'Weight', 'required');


		// if ($this->form_validation->run() === FALSE)
		// {
		// 	echo '<script>alert("Wrong input!")</script>';
		// 	$this->index('form');
		// }
		// else
		// {
			$populate = TRUE;
			$return_value = FALSE;
			if ($populate){
				
				$array = [
					//0
					[
					[.4,.3,.3,50],
					[.4,.3,.4,60],
					[.4,.3,.45,50],
					[.3,.3,.4,50],
					[.3,.2,.1,25],
					[.2,.2,.4,30],
					[.2,.2,.3,40]
					],
					//1
					[
					[.3,.3,.3,50],
					[.2,.2,.1,60],
					[.2,.2,.35,55],
					[.2,.2,.3,50]
					],
					//2
					[
					[.3,.3,.5,45],
					[.3,.3,.5,60],
					[.3,.3,.3,70],
					[.3,.3,.2,50],
					[.3,.3,.2,20]
					],
					//3
					[
					[.3,.3,.3,45],
					[.3,.3,.3,60],
					[.3,.3,.3,50],
					[.3,.3,.2,50],
					[.3,.3,.2,30]
					],
					//4
					[
					[.3,.3,.3,45],
					[.3,.3,.3,20],
					[.3,.3,.3,30],
					[.3,.3,.2,40],
					[.3,.3,.2,30]
					],
					//5
					[
					[.3,.3,.3,50],
					[.3,.3,.3,30],
					[.3,.3,.3,10],
					[.3,.3,.2,40],
					[.3,.3,.2,30]
					],
					//6
					[
					[.3,.3,.3,50],
					[.3,.3,.3,30],
					[.3,.3,.3,30],
					[.3,.2,.2,40],
					[.3,.3,.1,30]
					],
					//7
					[
					[.4,.3,.3,50],
					[.4,.3,.4,60],
					[.4,.3,.45,50],
					[.3,.3,.4,50],
					[.3,.2,.1,25],
					[.2,.2,.4,30],
					[.3,.2,.3,40],
					[.2,.1,.2,25],
					[.6,.4,.4,60],
					[.2,.2,.4,50]
					],
					//8
					[
					[.4,.3,.3,50],
					[.4,.3,.4,60],
					[.4,.3,.45,50],
					[.3,.3,.4,50],
					[.3,.2,.1,25],
					[.2,.2,.4,30],
					[.2,.2,.3,40],
					[.1,.2,.2,25],
					[.6,.5,.4,60],
					[.2,.2,.4,50]
					],
					//9
					[
					[.3,.3,.5,45],
					[.5,.4,.4,40],
					[.5,.3,.7,40],
					[.3,.2,.3,60],
					[.5,.4,.9,70],
					[.3,.2,.3,40],
					[.4,.2,.4,90],
					[.2,.2,.2,30],
					],
					//10
					[
					[.6,.5,.3,50],
					[.3,.3,1.2,90],
					[.2,.2,.3,30],
					[.4,.3,.6,60],
					[.5,.5,.7,90],
					[.8,.8,1.4,180],
					[.2,.2,.2,40]

					],
					//11
					[
					[.6,.5,.3,	50],
					[.3,.3,1.2,	90],
					[.2,.2,.3,	30],
					[.4,.3,.6,	60],
					[.5,.5,.7,	90],
					[.8,.8,1.4,	180],
					[.2,.2,.2,	40]

					]

					];

				foreach ($array[8] as $temp) {
					list($length, $width, $height, $weight) = $temp;
					$this->Package_model->set_package($container_id, $length, $width, $height, $weight, FALSE); 
				}
				$return_value = TRUE;
			}
			else{
				$return_value = $this->Package_model->set_package($container_id, $length, $width, $height, $weight, $fragile); 
			}

			if (in_array('height', $return_value) && !in_array('weight', $return_value)) {
				echo '<script>alert("Package cannot be accomodated due to excess height!")</script>';	
				// echo '<script>alert("Package is too heavy!")</script>';	
			}
			elseif (in_array('weight', $return_value) && !in_array('height', $return_value)) {
				echo '<script>alert("Package cannot be accomodated due to excess weight!")</script>';	
				// echo '<script>alert("Package is too heavy!")</script>';	
			}
			elseif (in_array('weight', $return_value) && in_array('height', $return_value)) {
				echo '<script>alert("Package cannot be accomodated due to excess height and weight!")</script>';	
			}
			elseif($return_value)
			// if($return_value)
			{
				// redirect(base_url('index.php/index/package'));	
				redirect(base_url('/index/form'));	
			}
			else
			{
				echo '<script>alert("Container cannot accomodate package!")</script>';	
			}
		// }
	}

	public function analytics()
	{
		// if (!$this->tank_auth->is_logged_in()) {
		// 	redirect('/auth/login/');
		// }

		$this->load->view('template/view_header');
		$this->load->view('template/view_top');
		$this->load->view('template/view_menu');
		$this->load->view('analytics/view_content');
		$this->load->view('template/view_footer');
	}

	public function export()
	{
		// if (!$this->tank_auth->is_logged_in()) {
		// 	redirect('/auth/login/');
		// }
		
		$this->load->view('template/view_header');
		$this->load->view('template/view_top');
		$this->load->view('template/view_menu');
		$this->load->view('export/view_content');
		$this->load->view('template/view_footer');
	}

}
