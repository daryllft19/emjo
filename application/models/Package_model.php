<?php
class Package_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

		public function get_package($id = -1,$cluster=-1)
		{
				if ($cluster != -1){
						//cluster = 2
						$this->db->select('*');
						$this->db->from('package');
						$this->db->join('container','container.id = container');
						$this->db->join('cluster','cluster.id = cluster');
						$this->db->where('cluster',$cluster);
						$query = $this->db->get();
						return $query->result_array();
				}
		        else if ($id == -1)
		        {
		                $query = $this->db->get('package');
		                return $query->result_array();
		        }

		        $query = $this->db->get_where('package', array('id' => $id));
		        return $query->row_array();
		}

		public function count_package($cluster=-1)
		{
			$this->db->select('count(*)');
			$this->db->from('package');
			$this->db->join('container','container.id = container');
			$this->db->join('cluster','cluster.id = cluster');	

			if ($cluster != -1)
			{
				$this->db->where('cluster',$cluster);
			}

			$query = $this->db->get();
			return $query->row_array()['count'];
		}

		public function set_package()
		{

		    $this->load->helper('url');
		    
		    $container_id = $this->input->post('container');
		    $length = $this->input->post('length');
		    $width = $this->input->post('width');
		    $height = $this->input->post('height');
		    $weight = $this->input->post('weight');
		    $fragile = $this->input->post('fragile');


		    $x = 0;//$this->Package_model->count_package(1);
		    $y = 0;
		    $z = 0;
		    $orientation = '';

		    $valid_package = $this->compute($container_id, (float)$length, (float)$width, (float)$height, $x,$y,$z, $orientation);
		    
		    if($valid_package)
		    {
			    $data = array(
			        'container' => $container_id,
			        'length' => $length,
			        'width' => $width,
			        'height' => $height,
			        'weight' => $weight,
			        'x1' => $x,
			        //'x2' => $x+$length,
			        'y1' => $y,
			        //'y2' => $y+$width,
			        'z1' => $z,
			        'z2' => $z+$height,
			        'is_fragile' => $fragile
			    );
			    
			    if($orientation == 'horizontal')
			    {
			    	$data['x2'] = $x + $length;
			    	$data['y2'] = $y + $width;
			    	$data['orientation'] = 'horizontal';
			    }
			    elseif ($orientation == 'vertical') 
			    {
					$data['x2'] = $x + $width;
			    	$data['y2'] = $y + $length;
			    	$data['orientation'] = 'vertical';
			    }

			    return $this->db->insert('package', $data);
		    }
		}

		public function compute($container_id,$length, $width, $height, &$x,&$y,&$z, &$orientation)
		{
			/*
			Rules:
			1. For stacking
				*height <= 3x smallest dimensino
				*weight <= 4x weight below
			2. for space
				*
			*/

			//container/address where package came
			$container = $this->Address_model->get_address($container_id);

			//cluster to be inserted by the new package
			$cluster = $this->Cluster_model->get_cluster($container['cluster']);

			//packages in the cluster to be inserted by the new package
			$packages = $this->Package_model->get_package(-1,$container['cluster']);


			$corners = $this->get_corners($packages);

			//if cluster is empty, put at 0,0
			if(empty($packages))
			{
				$candidates = array();
				$cluster_length = $cluster['length'];
				$cluster_width = $cluster['width'];
				$z = 0;

				//check first orientation
				$corner = array('x' => 0,  'y' => 0);
				$x2 = 0 + $length;				
				$y2 = 0 + $width; 

				//check if valid candidate
				if($x2 <= $cluster_length && $y2 <= $cluster_width)
				{
					$corner['orientation']='horizontal';
					array_push($candidates, $corner);
				}

				//rotate
				$corner = array('x' => 0,  'y' => 0);
				$x2 = 0 + $width;				
				$y2 = 0 + $length; 

				//check if valid candidate
				if($x2 <= $cluster_length && $y2 <= $cluster_width)
				{
					$corner['orientation']='vertical';
					array_push($candidates, $corner);
				}

				$first_candidate = $this->get_minimum_area($packages, $candidates, $length, $width);
				if(empty($first_candidate))
				{
					return false;
				}

				$x = $first_candidate['x'];
				$y = $first_candidate['y'];
				$orientation = $first_candidate['orientation'];
				//return true inserts package
				return true;
			}
			//if cluster has packages
			else
			{
				$candidates = array();
				$cluster_length = (float)$cluster['length'];
				$cluster_width = (float)$cluster['width'];

				foreach ($corners as $corner):
					//check first orientation
					$x2 = $corner['x'] + $length;				
					$y2 = $corner['y'] + $width;
					//check if valid candidate

					if(round($x2,2) <= round($cluster_length,2) && round($y2,2) <= round($cluster_width,2) && $this->has_no_collision($packages,$corner, $x2, $y2, 'horizontal'))
					{
						$corner['orientation']='horizontal';
						// var_dump('taas',$corner);
						array_push($candidates, $corner);
						unset($corner['orientation']);	
					}

					//rotate
					$x2 = $corner['x'] + $width;				
					$y2 = $corner['y'] + $length;
					//check if valid candidate
					if(round($x2,2) <= round($cluster_length,2) && round($y2,2) <= round($cluster_width,2) && $this->has_no_collision($packages,$corner, $x2, $y2,'vertical'))
					{
						$corner['orientation']='vertical';
						// var_dump('baba',$corner);
						array_push($candidates, $corner);
						unset($corner['orientation']);	
					}
					// if ($corner['x'] == 0.2 && $corner['y'] == .8) {
					// 		var_dump($x2);
					// 		var_dump($cluster_length);
					// 		var_dump($y2);
					// 		var_dump($cluster_width);
					// 		var_dump($corner);
					// 		var_dump('vertical');
					// 		var_dump(round($x2,2) <= round($cluster_length,2));
					// 		var_dump(round($y2,2) <= round($cluster_width,2));
					// 		var_dump($this->has_no_collision($packages,$corner, $x2, $y2,'vertical'));
					// }

	            endforeach;

	            if(empty($candidates))
				{
					return false;
				}
				$candidate = $this->get_minimum_area($packages, $candidates, $length, $width);
	            $x = $candidate['x'];
	            $y = $candidate['y'];			
	            $orientation = $candidate['orientation'];
	            // var_dump($candidate);
				//return true inserts package
				return true;
			}

		}

		public function get_minimum_area($packages, $candidates, $length, $width)
		{

			$max_x = 0;
			$max_y = 0;
			$min_area = -1;
			$min_candidate = '';
			//Get area covered by all packages
			foreach ($packages as $package):
				if($package['x2'] > $max_x)
				{
					$max_x = $package['x2'];
				}
				if ($package['y2'] > $max_y)
				{
					$max_y = $package['y2'];
				}
			endforeach;

			$prev_y = -1;
			$min_tick = -1;
			foreach ($candidates as $candidate):
				//var_dump($candidate);
				$candidate_x  = ($candidate['orientation'] == 'vertical'? $candidate['x'] + $width:$candidate['x'] + $length);
				$candidate_y  = ($candidate['orientation'] == 'vertical'? $candidate['y'] + $length:$candidate['y'] + $width);
				$temp_x = ($max_x > $candidate_x? $max_x: $candidate_x);
				$temp_y = ($max_y > $candidate_y? $max_y: $candidate_y);
				$prev_y = $temp_y;
				$min_tick = ($min_tick == -1? $candidate['y']: $min_tick);
				/*
				Criteria:
				1. get minimum area based on max x and y  
				2. if area is equal, get candidate with lesser y to prioritize putting on left side
				3. if area and y is equal, prioritize vertical
				*/
				if($min_area == -1 || 
					$temp_x * $temp_y < $min_area || 
					($temp_x * $temp_y == $min_area && $temp_y < $prev_y) ||
					($temp_x * $temp_y == $min_area && $candidate['orientation'] == 'vertical' && $candidate['y'] <= $min_tick)
					)
				{
					$min_area = $temp_x * $temp_y;
					$min_candidate = $candidate;
					$min_tick = $candidate['y'];

				}
			endforeach;
			return $min_candidate;
		}

		public function has_no_collision($packages,$corner, $x2, $y2, $orientation)
		{
			foreach ($packages as $package):
				/*
				Collision detection criteria:
				Return false if collided 
				1. px1 <= x1 && x2 <= px2
				2. py1 <= y1 && y2 <= py2
				*/

				if(

						// ((float)$package['x1'] < $x2  && $x2 <= (float)$package['x2'] || (float)$package['y1'] < $y2  && $y2 <= (float)$package['y2'] ) &&
						// ((float)$package['x1'] < $x2  && $x2 <= (float)$package['x2'] || (float)$package['y1'] < $corner['y']  && $corner['y'] <= (float)$package['y2'] ) &&
						// ((float)$package['x1'] >= $corner['x']  && $corner['x'] <= (float)$package['x2'] || (float)$package['y1'] < $y2  && $y2 <= (float)$package['y2'] ) &&
						// ((float)$package['x1'] >= $corner['x']  && $corner['x'] <= (float)$package['x2'] || (float)$package['y1'] < $corner['y']  && $corner['y'] <= (float)$package['y2'] )
					
					($orientation == 'horizontal' &&
					($corner['x'] >= (float)$package['x1'] && $corner['x'] < (float)$package['x2'] &&
					$corner['y'] >= (float)$package['y1'] && $corner['y'] < (float)$package['y2'])
					) ||
					($orientation == 'vertical' &&
					($corner['x'] >= (float)$package['x1'] && $corner['x'] < (float)$package['x2'] &&
					$corner['y'] >= (float)$package['y1'] && $corner['y'] < (float)$package['y2'])
					)
				)
				{
		   //          var_dump($corner);
     //    		    var_dump($orientation);
     //    		    var_dump('package x1: '.$package['x1']);
					// var_dump('package x2: '.$package['x2']);
					// var_dump('package y1: '.$package['y1']);
					// var_dump('package y2: '.$package['y2']);
				
					// var_dump('collided');
					// if ($corner['x'] == 0.2 && $corner['y'] == .8)
					// {
					// 	var_dump('$x2: '.$x2);
					// 	var_dump('$y2: '.$y2);
					// 	var_dump((float)$package['x1'] < $x2  && $x2 <= (float)$package['x2'] || (float)$package['y1'] < $y2  && $y2 <= (float)$package['y2']);
					// 	var_dump((float)$package['x1'] < $x2  && $x2 <= (float)$package['x2'] || (float)$package['y1'] < $corner['y']  && $corner['y'] <= (float)$package['y2'] );
					// 	var_dump((float)$package['x1'] >= $corner['x']  && $corner['x'] <= (float)$package['x2'] || (float)$package['y1'] < $y2  && $y2 <= (float)$package['y2']);
					// 	var_dump((float)$package['x1'] >= $corner['x']  && $corner['x'] <= (float)$package['x2'] || (float)$package['y1'] < $corner['y']  && $corner['y'] <= (float)$package['y2']);
					// }
					return false;
				}
					// if ($corner['x'] == 0.2 && $corner['y'] == .8) {
						// var_dump('package',$orientation);
						// var_dump($package['x1']);
						// var_dump($package['y1']);
						// var_dump($corner['x'] >= (float)$package['x1']);
						// var_dump($corner['x'] < (float)$package['x2']);
						// var_dump($corner['y'] >= (float)$package['y1']);
						// var_dump($corner['y'] < (float)$package['y2']);

						//MAY PROBLEMA SA .02,.8 horizontal

					// }
            endforeach;
            // var_dump($corner);
            // var_dump($orientation);
            return true;	
		}

		//get all possible corners to put the package
		public function get_corners($packages)
		{
			$corners = array();

			foreach ($packages as $package):
				$corner1 = array('x' => (float)$package['x1'],  'y' => (float)$package['y1']);
				$corner2 = array('x' => (float)$package['x2'],  'y' => (float)$package['y1']);
				$corner3 = array('x' => (float)$package['x1'],  'y' => (float)$package['y2']);
				$corner4 = array('x' => (float)$package['x2'],  'y' => (float)$package['y2']);							
				array_push($corners,$corner1, $corner2, $corner3, $corner4);
            endforeach;		
            return $corners;
		}
} 	