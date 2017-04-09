<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct() {        
	    parent::__construct();
	    $this->load->model('Cluster_model');
	    $this->load->model('Address_model');
	    $this->load->model('Package_model');
	    $this->load->model('Setting_model');
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
		redirect('index/');
		// $this->$page();
	}


	public function cluster()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('');
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
			redirect('');
		}

		$order = array(
				0 =>array(
					'category' => 'cluster, province, city, barangay, district, area, avenue, street',
					'type' => 'asc', 
					)
				);
		$address=$this->Address_model->get_address(-1,-1,$order);
        foreach ($address as $key => $value) {
            $clstr = $this->Cluster_model->get_cluster($value['cluster']);
            $address[$key]['cluster'] = $clstr;
        }

        $ret = array();
        $clusters = $this->Cluster_model->get_cluster();
        foreach ($clusters as $key => $value) {
        	$ret[$value['id']] = array('name'=>$value['name'], 'location'=>$value);
        }
        // $temp=$this->Address_model->get_address(-1,-1,$order);
        // foreach ($temp as $key => $value) {
        // 	$clstr = $this->Cluster_model->get_cluster($value['cluster']);
        // 	if(!isset($ret[$clstr['id']]))
        // 		$ret[$clstr['id']] = array('name'=>$clstr['name'],'location'=>array());

        // 	array_push($ret[$clstr['id']]['location'], $value);
        // }
		$data['address']=$address;
		$data['ret']=$ret;
		$this->load->view('template/view_header');
		$this->load->view('template/view_top');
		$this->load->view('template/view_menu');
		$this->load->view('address/view_content',$data);
		$this->load->view('template/view_footer');

	}

	public function package($cluster=-1)
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
		if($cluster != -1){
			redirect('/index/package?cluster='.$cluster);
			// $data['selected']=$cluster;
		}
		elseif(!empty($this->input->get('cluster')))
			$data['selected']=$this->input->get('cluster');

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
					)
				);
		$data['address']=$this->Address_model->get_address(-1,-1,$order);
		
		$data['province']=array();
		foreach ($data['address'] as $key => $value) {
			if(!in_array($value['province'], $data['province']))
				array_push($data['province'], $value['province']);
		}

		$this->load->helper('form');
        $this->load->library('form_validation');

		$this->form_validation->set_rules('address_id', 'Address', 'required');
		$this->form_validation->set_rules('serial', 'Serial Number', 'required');
		$this->form_validation->set_rules('length', 'Length', 'required|greater_than[0]');
		$this->form_validation->set_rules('width', 'Width', 'required|greater_than[0]');
		$this->form_validation->set_rules('height', 'Height', 'required|greater_than[0]');
		$this->form_validation->set_rules('weight', 'Weight', 'required|greater_than[0]');
		// $this->form_validation->set_rules('weight-constraint', 'Weight Constraint', 'required');
		// $this->form_validation->set_rules('height-constraint', 'height Constraint', 'required');

		$address_id = $this->input->post('address_id');
		$serial = $this->input->post('serial');
		$address = $this->input->post('address');
		$length = $this->input->post('length');
		$width = $this->input->post('width');
		$height = $this->input->post('height');
		$weight = $this->input->post('weight');
		$fragile = $this->input->post('fragile');
		$height_constraint = !empty($this->input->post('height-constraint'))?$this->input->post('height-constraint'):0;
		$weight_constraint = !empty($this->input->post('weight-constraint'))?$this->input->post('weight-constraint'):0;
		
		$data['input_address_id'] = $address_id;
		$data['input_address'] = $address;
		$data['serial'] = $serial;
		$data['length'] = $length;
		$data['width'] = $width;
		$data['height'] = $height;
		$data['weight'] = $weight;
		$data['height_constraint'] = $height_constraint;
		$data['weight_constraint'] = $weight_constraint;
		$data['fragile'] = $fragile;
		$constraint = $this->Setting_model->get_admin_settings()[0];
		$data['hconstraint_multiplier'] = $constraint['height_multiplier'];
		$data['wconstraint_multiplier'] = $constraint['weight_multiplier'];
		// var_dump();
		$this->form_validation->run();
		// if ($this->form_validation->run() === TRUE)
		// {
		// 	if($fragile == 'on')
		// 		$fragile = TRUE;
		// 	else
		// 		$fragile = FALSE;

		// 	$this->add($address_id, $length, $width, $height, $weight, $fragile, $height_constraint, $weight_constraint);
		// 	// echo '<script>alert("Wrong input!")</script>';
		// 	// $this->index('form');
		// }

		$this->load->view('template/view_header');
		$this->load->view('template/view_top');
		$this->load->view('template/view_menu');
		$this->load->view('form/add_content', $data);
		$this->load->view('template/view_footer');


		
		
	}

	public function add($container_id, $length, $width, $height,  $weight, $fragile, $height_constraint, $weight_constraint)
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
			$populate = FALSE;
			$return_value = FALSE;
			if ($populate){
				
				$array = [
					//0
					[
					[40,30,30,50],
					[40,30,40,60],
					[40,30,45,50],
					[30,30,40,50],
					[30,20,10,25],
					[20,20,40,30],
					[20,20,30,40]
					],
					//1
					[
					[30,30,30,50],
					[20,20,10,60],
					[20,20,35,55],
					[20,20,30,50]
					],
					//2
					[
					[30,30,50,45],
					[30,30,50,60],
					[30,30,30,70],
					[30,30,20,50],
					[30,30,20,20]
					],
					//3
					[
					[30,30,30,45],
					[30,30,30,60],
					[30,30,30,50],
					[30,30,20,50],
					[30,30,20,30]
					],
					//4
					[
					[30,30,30,45],
					[30,30,30,20],
					[30,30,30,30],
					[30,30,20,40],
					[30,30,20,30]
					],
					//5
					[
					[30,30,30,50],
					[30,30,30,30],
					[30,30,30,10],
					[30,30,20,40],
					[30,30,20,30]
					],
					//6
					[
					[30,30,30,50],
					[30,30,30,30],
					[30,30,30,30],
					[30,20,20,40],
					[30,30,10,30]
					],
					//7
					[
					[40,30,30,50],
					[40,30,40,60],
					[40,30,45,50],
					[30,30,40,50],
					[30,20,10,25],
					[20,20,40,30],
					[30,20,30,40],
					[20,10,20,25],
					[60,40,40,60],
					[20,20,40,50]
					],
					//8
					[
					[40,30,30,50],
					[40,30,40,60],
					[40,30,45,50],
					[30,30,40,50],
					[30,20,10,25],
					[20,20,40,30],
					[20,20,30,40],
					[10,20,20,25]//,
					// [60,50,40,60],
					// [20,20,40,50]
					],
					//9
					[
					[30,30,50,45],
					[50,40,40,40],
					[50,30,70,40],
					[30,20,30,60],
					[50,40,90,70],
					[30,20,30,40],
					[40,20,40,90],
					[20,20,20,30],
					],
					//10
					[
					[6,5,3,50],
					[3,3,12,90],
					[2,2,3,30],
					[4,3,6,60],
					[5,5,7,90],
					[8,8,14,180],
					[2,2,2,40]

					],
					//11
					[
					[50,60,30,	50],
					[30,30,12,90],
					[20,20,30,	30],
					[30,40,60,	60],
					[50,50,70,	90],
					[80,80,140,180],
					[20,20,20,	40]

					]

					];

				foreach ($array[9] as $temp) {
					list($length, $width, $height, $weight) = $temp;
					$this->Package_model->set_package('00000000',$container_id, $length, $width, $height, $weight, FALSE, min($length, $width)*3, $weight*4); 
				}
				$return_value = TRUE;
			}
			else{
				$return_value = $this->Package_model->set_package('0000000',$container_id, $length, $width, $height, $weight, $fragile, $height_constraint, $weight_constraint); 
			}

			if(is_array($return_value))
			{	
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

	public function settings()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('');
		}

		$data = array();
		$data['settings'] = $this->Setting_model->get_admin_settings()[0];

		$this->load->view('template/view_header');
		$this->load->view('template/view_top');
		$this->load->view('template/view_menu');
		$this->load->view('settings/view_content',$data);
		$this->load->view('template/view_footer');
	}

	public function export()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('');
		}
		
		$this->load->view('template/view_header');
		$this->load->view('template/view_top');
		$this->load->view('template/view_menu');
		$this->load->view('export/view_content');
		$this->load->view('template/view_footer');
	}

}
