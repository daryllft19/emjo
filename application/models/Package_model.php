<?php
class Package_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

		public function get_package($id = -1,$cluster=-1, $x=-1, $y=-1, $z=-1)
		{
				if ($cluster != -1 && $id == -1){
						//cluster = 2
						$this->db->select('package.*');
						$this->db->from('package');
						$this->db->join('container','container.id = container');
						$this->db->join('cluster','cluster.id = cluster');
						$this->db->where('cluster',$cluster);
						$query = $this->db->get();
						return $query->result_array();
				}
		        else if ($x != -1 && $y != -1 && $z != -1)
		        {
		        		$query = $this->db->get_where('package', array('x1 <=' => $x,'x2 >=' => $x, 'y1 <= ' => $y, 'y2 >= ' => $y, 'z2 =' => $z));	
		                return $query->row_array();
		        }
		        else if ($id == -1)
		        {
		                $query = $this->db->get('package');
		                return $query->result_array();
		        }

		        $query = $this->db->get_where('package', array('id' => $id));
		        return $query->row_array();
		}

		public function get_above($dArgs)
		{
			$container_list = array();
			$container = $this->get_package($dArgs['id']);
			$level = $dArgs['level'];
			list($x1,$x2, $y1,$y2, $z) = array($container['x1'],$container['x2'],$container['y1'],$container['y2'],$container['z2']);
			$query = $this->db->get_where('package', array('x1 >=' => (string)$x1,'x2 <=' => (string)$x2, 'y1 >= ' => (string)$y1, 'y2 <= ' => (string)$y2, 'z1 >=' => (string)$z));
			$container_list = $query->result_array();
			$layer = 0;
			$prev_z = 0; 

			//get all
			if($level == -1)
			{
				foreach ($container_list as $key => $con) {
					if($con['z1'] > $prev_z)
					{
						$layer++;
						$prev_z = $con['z1'];
					} 
					$container_list[$key]['layer'] = $layer;
				}
				// var_dump('container list', $container_list);
			}
			else
			{
				$temp = array();
				foreach ($container_list as $key => $con) {
					if($con['z1'] > $prev_z)
					{
						if($layer == $level)
						{
							break;
						}
						$layer++;
						$prev_z = $con['z1'];
					} 
					$con['layer'] = $layer;
					array_push($temp, $con);
				}
				// var_dump('container list', $temp);
				$container_list = $temp;
			}
			return $container_list;
		}

		public function get_below($dArgs)
		{
			$container_list = array();
			if(isset($dArgs['id']))
			{	
				$container = $this->get_package($dArgs['id']);
				list($x1,$x2, $y1,$y2, $z) = array($container['x1'],$container['x2'],$container['y1'],$container['y2'],$container['z1']);
			}
			elseif (isset($dArgs['coordinates'])) {
				list($x1,$x2, $y1,$y2, $z) = array($dArgs['coordinates']['x1'],$dArgs['coordinates']['x2'],$dArgs['coordinates']['y1'],$dArgs['coordinates']['y2'],$dArgs['coordinates']['z']);
			}
			else
			{
				return;
			}

			$query = $this->db->get_where('package', array('x1 <=' => (string)$x1,'x2 >=' => (string)$x2, 'y1 <= ' => (string)$y1, 'y2 >= ' => (string)$y2, 'z2 <=' => (string)$z));
			$level = $dArgs['level'];
			$container_list = $query->result_array();

			// var_dump('container_list', $container_list);
			$layer = 0;
			$prev_z = $z; 

			$z_temp = array();
            foreach ($container_list as $key => $row) {
           		$z_temp[$key] = $row['z2'];
            }
			array_multisort($z_temp, SORT_DESC, $container_list);
			
			if (!empty($container_list) && $container_list[0]['z2'] != (string)$z)
			{
				return;
			}

			//get all
			if($level == -1)
			{
				foreach ($container_list as $key => $con) {
					if($con['z1'] < $prev_z)
					{
						$layer++;
						$prev_z = $con['z1'];
					} 
					$container_list[$key]['layer'] = $layer;
				}
				// var_dump('container list', $container_list);
			}
			else
			{
				$temp = array();
				foreach ($container_list as $key => $con) {
					if($con['z1'] < $prev_z)
					{
						if($layer == $level)
						{
							break;
						}
						$layer++;
						$prev_z = $con['z1'];
					} 
					$con['layer'] = $layer;
					array_push($temp, $con);
				}
				// var_dump('container list', $temp);
				$container_list = $temp;
			}

			return $container_list;
		}

		public function get_sibling($id)
		{
			$below = $this->get_below(array('id' => $id, 'level' => 1));
			$package = $this->get_package($id);

			//if nothing below, packages are from bottom
			if(empty($below))
			{
				$query = $this->db->get_where('package', array('z1 =' => 0));
				$container_list = $query->result_array();
			}
			//get everything above the package below the indicated package
			else
			{	
				$below = $below[0];
				$container_list = $this->get_above(array('id'=>$below['id'], 'level'=>1));

			}
			foreach ($container_list as $key => $con) {
				if($con['id'] == $id)
				{
					unset($container_list[$key]);
				} 
				unset($container_list[$key]['layer']);
			}
			$container_list = array_values($container_list);
			return $container_list;
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

		public function set_package($container_id, $length, $width, $height, $weight, $fragile)
		{

		    $this->load->helper('url');
		    
		    // $container_id = $this->input->post('container');
		    // $length = $this->input->post('length');
		    // $width = $this->input->post('width');
		    // $height = $this->input->post('height');
		    // $weight = $this->input->post('weight');
		    // $fragile = $this->input->post('fragile');


		    $x = 0;//$this->Package_model->count_package(1);
		    $y = 0;
		    $z = 0;
		    $orientation = '';

		    //0 for STACK
		    //1 for BASE
		    $priority = 0;
		    $valid_package = $this->compute($container_id, (float)$length, (float)$width, (float)$height, (float)$weight, $x,$y,$z, $orientation, $priority);
		    if(is_array($valid_package) && !empty($valid_package))
		    {
		    	return $valid_package;
		    }
		    if(is_string($valid_package) && $valid_package == 'STOP')
		    {
		    	return 'STOP';
		    }
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

			    $this->db->insert('package', $data);
			    return true;
		    }
		    return false;
		}

		public function compute($container_id,$length, $width, $height, $weight, &$x,&$y,&$z, &$orientation, $priority)
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


			$corners = $this->get_corners($packages, true, $priority, $length, $width);

			//if cluster is empty, put at 0,0
			if(empty($packages))
			{
				$candidates = array();
				$cluster_length = $cluster['length'];
				$cluster_width = $cluster['width'];
				$cluster_height = $cluster['height'];

				//check first orientation
				$corner = array('x' => 0,  'y' => 0, 'z' => 0);
				$x2 = $length;				
				$y2 = $width; 
				$z2 = $height;
				//check if valid candidate
				if($x2 <= $cluster_length && $y2 <= $cluster_width && $z <= $cluster_height)
				{
					$corner['orientation']='horizontal';
					array_push($candidates, $corner);
				}

				//rotate
				$corner = array('x' => 0,  'y' => 0, 'z' => 0);
				$x2 = $width;				
				$y2 = $length; 
				$z2 = $height; 

				//check if valid candidate
				if($x2 <= $cluster_length && $y2 <= $cluster_width && $z <= $cluster_height)
				{
					$corner['orientation']='vertical';
					array_push($candidates, $corner);
				}
				$first_candidate = $this->get_minimum_area($packages, $candidates, $length, $width, $height);
				if(empty($first_candidate))
				{
					return false;
				}

				$x = $first_candidate['x'];
				$y = $first_candidate['y'];
				$z = $first_candidate['z'];
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
				$cluster_height = (float)$cluster['height'];

				//first iteration
				$first_iteration_flag = 1;
				$rotating_priority = $priority;
				while(true){	

		            foreach ($corners as $corner):
						//check first orientation
						$x2 = $corner['x'] + $length;				
						$y2 = $corner['y'] + $width;
						$z2 = $corner['z'] + $height;
						//check if valid candidate

						// var_dump('corner', $corner);
						// var_dump('test 1a',round($z2,2) <= round($cluster_height,2));
						// var_dump('test 1b',round($x2,2) <= round($cluster_length,2));
						// var_dump('test 1c',round($y2,2) <= round($cluster_width,2));
						// var_dump('test 1d',$this->has_no_collision($packages,$corner, $x2, $y2, $z2, 'horizontal', $priority));
						if( round($z2,2) <= round($cluster_height,2) && 
							round($x2,2) <= round($cluster_length,2) && 
							round($y2,2) <= round($cluster_width,2) && 
							$this->has_no_collision($packages,$corner, $x2, $y2, $z2, 'horizontal', $priority))
						{
							//GET PACKAGE WHERE IT IS ADJACENT AND CHECK IF NEW PACKAGE IS JUST STACKED
							$package = $this->Package_model->get_package(-1,-1,$x2,$y2,$corner['z']);
							// var_dump('package', $package);

							// //CHECK FOR OVERHANGING
							// var_dump($corner);
							// var_dump($package);
							if ($rotating_priority == 1 || (empty($package) && $corner['z'] == 0) ||

									($rotating_priority == 0 && $package['z2'] == $corner['z'] &&
									$corner['x'] >= $package['x1'] && $corner['y'] >= $package['y1'] &&
									$x2 <= $package['x2'] && $y2 <= $package['y2']
									)
								)
							{
								// if ($rotating_priority == 0){
								// 	var_dump('not overhanging');
								// }

								$corner['orientation']='horizontal';
								// var_dump('HORIZONTAL',$corner);
								if(!in_array($corner, $candidates))
									array_push($candidates, $corner);
								unset($corner['orientation']);	
							}

						}

						//rotate
						$x2 = $corner['x'] + $width;				
						$y2 = $corner['y'] + $length;
						$z2 = $corner['z'] + $height;

						// var_dump('test 2a',round($z2,2) <= round($cluster_height,2));
						// var_dump('test 2b',round($x2,2) <= round($cluster_length,2));
						// var_dump('test 2c',round($y2,2) <= round($cluster_width,2));
						// var_dump('test 2d',$this->has_no_collision($packages,$corner, $x2, $y2, $z2, 'vertical', $priority));
						//check if valid candidate
						if( round($z2,2) <= round($cluster_height,2) && 
							round($x2,2) <= round($cluster_length,2) && 
							round($y2,2) <= round($cluster_width,2) && 
							$this->has_no_collision($packages,$corner, $x2, $y2, $z2, 'vertical', $priority))
						{
							//GET PACKAGE WHERE IT IS ADJACENT AND CHECK IF NEW PACKAGE IS JUST STACKED
							$package = $this->Package_model->get_package(-1,-1,$x,$y,$corner['z']);
							//CHECK FOR OVERHANGING
							// var_dump('corner', $corner);
							// var_dump('package sa baba', $package);
							// var_dump('corner', $corner);
							// var_dump('$package[z2] == $corner[z]',$package['z2'] == $corner['z'] );
							// var_dump('$corner[x] >= $package[x1]',$corner['x'] >= $package['x1']);
							// var_dump('$corner[y] >= $package[y1]', $corner['y'] >= $package['y1']);
							// var_dump('$x2 <= $package[x2]',$x2 <= $package['x2']);
							// var_dump('$y2 <= $package[y2]',$y2 <= $package['y2']);
							// var_dump($corner);
							// var_dump(empty($package));
							if ($rotating_priority == 1 || (empty($package) && $corner['z'] == 0) ||
									($rotating_priority == 0 && $package['z2'] == $corner['z'] &&
									$corner['x'] >= $package['x1'] && $corner['y'] >= $package['y1'] &&
									$x2 <= $package['x2'] && $y2 <= $package['y2']
									)
								)
							{
								$corner['orientation']='vertical';
								// var_dump('VERTICAL',$corner);
								if(!in_array($corner, $candidates))
									array_push($candidates, $corner);
								unset($corner['orientation']);	
							}
						}
		            endforeach;
		            // var_dump('candidates',$candidates);
		            // Check if first iteration and candidate checking is unsuccessful
		            if($first_iteration_flag == 1){
		            	$first_iteration_flag = 0;
		            }else{
		            	break;
		            }

		            //Use next set of corners
		            $rotating_priority = ($rotating_priority+1)%2;
		            $corners = $this->get_corners($packages, true, $rotating_priority, $length, $width);
		            // ($packages, true, $priority, $length, $width);
		        }

		        $constraint = array();
		        
				
		        $weight_constraint = $this->weight_check($packages, $candidates, $length, $width, $weight);
				if(is_string($weight_constraint) && $weight_constraint == 'weight')
				{
					array_push($constraint, $weight_constraint);
				}
		        
		        $height_constraint = $this->height_check($packages, $candidates, $length, $width, $height);
				if(is_string($height_constraint) && $height_constraint == 'height')
				{
					array_push($constraint, $height_constraint);
				}

           	
           		//sort candidates depending on priority
            	$z_temp = array();
	            foreach ($candidates as $key => $row) {
	           		$z_temp[$key] = $row['z'];
	            }
	            if($priority==0){
		            array_multisort($z_temp, SORT_DESC, $candidates);
	        	}elseif ($priority==1) {
		            array_multisort($z_temp, SORT_ASC, $candidates);
	        	}

				// var_dump('candidates', $candidates);
		        var_dump('best', $this->get_minimum_area($packages, $candidates, $length, $width, $height));
				// return 'STOP';

				if(!empty($constraint))
				{
					return $constraint;
				}

				if(empty($candidates))
				{
					return false;
				}
				$candidate = $this->get_minimum_area($packages, $candidates, $length, $width, $height);
	            $x = $candidate['x'];
	            $y = $candidate['y'];			
	            $z = $candidate['z'];			
	            $orientation = $candidate['orientation'];
				//return true inserts package
				return true;
			}

		}
		public function weight_check($packages, &$candidates, $length, $width, $weight)
		{
			foreach ($candidates as $ckey=>$candidate) {
				$x = $candidate['x'] + ($candidate['orientation'] == 'horizontal'? $length:$width);
				$y = $candidate['y'] + ($candidate['orientation'] == 'horizontal'? $width:$length);
				$z = $candidate['z'] ;
		
				$packages_below = $this->get_below(array('coordinates'=>array('x1'=>$candidate['x'], 'x2'=>$x,'y1'=>$candidate['y'], 'y2'=>$y, 'z'=>$z),'level'=>-1));

				//all candidates that are placed at the base are automatically allowed
				if(empty($packages_below))
				{
					// var_dump('empty below');
					continue;
				}
				//only compute weight if package will be put above another package
				else
				{
					//includes all packages where the package is supposedly to be placed
					// $packages_below = $this->get_below(array('coordinates'=>array('x1'=>$candidate['x'], 'x2'=>$x,'y1'=>$candidate['y'], 'y2'=>$y, 'z'=>$z),'level'=>-1));
					// var_dump('below', $packages_below);
					// array_push($packages_below, $p);
					$weight_array = array();
					$pb_z = array();
		            foreach ($packages_below as $key => $row) {
		           		$pb_z[$key] = $row['z1'];
		            }
		            array_multisort($pb_z, SORT_ASC, $packages_below);
					foreach ( $packages_below as $pb) {
						array_push($weight_array, array('z'=>$pb['z1'], 'weight'=>$pb['weight']));
					}

					foreach ($weight_array as $key=>$val) {
						// var_dump('wa', $key, $val);
						$weight_temp = 0;
						for ($i=$key+1; $i <sizeof($weight_array); $i++) { 
							$weight_temp += $weight_array[$i]['weight'];
						}
						if($weight_temp+$weight > ($val['weight']*4))
						{
							// var_dump('wa', $weight_array);
							// var_dump('wt:', ($weight_temp+$weight),($val['weight']*4));
							// var_dump('exceeded: ', ($weight_temp+$weight > ($val['weight']*4)));
							var_dump('weight exceeded at '. $key .' !!!');
							var_dump('unsetting candidate', $candidates[$ckey]);
							unset($candidates[$ckey]);
							break;
						}

						// var_dump('handled weight', $weight_temp);
					}
					//return false means that is has not exceeded weight
					
					// var_dump('weight', $weight_array);
				}
			}
			if(empty($candidates))
			{
				return 'weight';
			}
			array_values($candidates);
			// var_dump('final candidates',$candidates);
			// return $candidates;
		}

		public function height_check($packages, &$candidates, $length, $width, $height)
		{
			foreach ($candidates as $ckey=>$candidate) {
				$x = $candidate['x'] + ($candidate['orientation'] == 'horizontal'? $length:$width);
				$y = $candidate['y'] + ($candidate['orientation'] == 'horizontal'? $width:$length);
				$z = $candidate['z'];
				
				$packages_below = $this->get_below(array('coordinates'=>array('x1'=>$candidate['x'], 'x2'=>$x,'y1'=>$candidate['y'], 'y2'=>$y, 'z'=>$z),'level'=>-1));
				
				//all candidates that are placed at the base are automatically allowed
				// var_dump(())
				if(empty($packages_below))
					continue;
				//only compute height if package will be put above another package
				else
				{
					//includes all packages where the package is supposedly to be placed
					// $packages_below = $this->get_below(array('id'=>$p['id'],'level'=>-1));
					// array_push($packages_below, $p);

					$height_array = array();
					$pb_z = array();
		            foreach ($packages_below as $key => $row) {
		           		$pb_z[$key] = $row['z1'];
		            }
		            array_multisort($pb_z, SORT_ASC, $packages_below);
					foreach ( $packages_below as $pb) {
						array_push($height_array, array('z'=>$pb['z1'], 'height'=>$pb['height'], 'length'=>$pb['length'], 'width'=>$pb['width']));
					}
					$height_temp = 0;
					foreach ($height_array as $ha) {
						$height_temp+=$ha['height'];	
					}

					foreach ($height_array as $key=>$val) {
						// var_dump('wa', $key, $val);
						$height_temp = 0;
						for ($i=$key+1; $i <sizeof($height_array); $i++) { 
							$height_temp += $height_array[$i]['height'];
						}

						// var_dump('height_temp+height', ($height_temp+$height));
						// var_dump('min', (min($val['width'],$val['length'])*3));
						if($height_temp+$height > (min($val['width'],$val['length'])*3))
						{

							var_dump('height exceeded at '. $key .' !!!');
							// var_dump($weight_temp+$weight.' >= '.($val['weight']*4));
							unset($candidates[$ckey]);
							break;
						}

						// var_dump('handled weight', $weight_temp);
					}
					//return false means that is has not exceeded weight
					
					// var_dump('weight', $weight_array);
				}
			}
			if(empty($candidates))
			{
				return 'height';
			}
			array_values($candidates);
			// return $candidates;
		}

		public function get_minimum_area($packages, $candidates, $length, $width, $height)
		{

			$max_x = 0;
			$max_y = 0;
			$max_z = 0;
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
				if ($package['z2'] > $max_z)
				{
					$max_z = $package['z2'];
				}
			endforeach;

			$prev_y = -1;
			$prev_x = -1;
			$min_tick = -1;
			foreach ($candidates as $candidate):
				// var_dump($candidate);
				$candidate_x  = ($candidate['orientation'] == 'vertical'? $candidate['x'] + $width:$candidate['x'] + $length);
				$candidate_y  = ($candidate['orientation'] == 'vertical'? $candidate['y'] + $length:$candidate['y'] + $width);
				$candidate_z  = $candidate['z'] + $height;
				$temp_x = ($max_x > $candidate_x? $max_x: $candidate_x);
				$temp_y = ($max_y > $candidate_y? $max_y: $candidate_y);
				$temp_z = ($max_z > $candidate_z? $max_z: $candidate_z);
				$prev_y = $temp_y;
				$min_tick = ($min_tick == -1? $candidate['y']: $min_tick);
				/*
				Criteria:
				1. get minimum area based on max x and y  
				2. if area is equal, get candidate with lesser y to prioritize putting on left side
				3. if area and y is equal, prioritize vertical
				*/
				var_dump('candidate', $candidate);;
				var_dump($temp_x.' '.$temp_y.' '.$temp_z);
				var_dump('candidate area', round($temp_x * $temp_y * $temp_z,4));
				// var_dump('get below',array('x1'=>$candidate['x'], 'x2'=>$candidate_x, 'y1'=>$candidate['y'], 'y2'=>$candidate_y, 'z'=>$candidate['z']));
				// var_dump('below it', $this->get_below(array('coordinates'=>array('x1'=>$candidate['x'], 'x2'=>$candidate_x, 'y1'=>$candidate['y'], 'y2'=>$candidate_y, 'z'=>$candidate['z']), 'level'=>1)));
				$below = $this->get_below(array('coordinates'=>array('x1'=>$candidate['x'], 'x2'=>$candidate_x, 'y1'=>$candidate['y'], 'y2'=>$candidate_y, 'z'=>$candidate['z']), 'level'=>1));
				if ($candidate['z']>0 && empty($below))
				{
					continue;
				}
				// var_dump('condition1: '.($min_area == -1?'true':'false'));
				// var_dump('condition2: '.(round($temp_x * $temp_y * $temp_z,4) < round($min_area,4)?'true':'false'));
				// var_dump('condition3: '.(abs($temp_x * $temp_y - $min_area) < 0?'true':'false'));
				// var_dump('condition4: '.(($temp_x * $temp_y == $min_area && $temp_x < $prev_x)?'true':'false'));
				// var_dump('condition5: '.(($temp_x * $temp_y == $min_area && $temp_x >= $prev_x && $temp_y < $prev_y)?'true':'false'));
				// var_dump('condition6: '.(($temp_x * $temp_y == $min_area && $temp_x >= $prev_x && $candidate['orientation'] == 'vertical' && $candidate['y'] <= $min_tick)?'true':'false'));
				if($min_area == -1 || 
					round($temp_x * $temp_y * $temp_z,4) < round($min_area,4) ||
					($temp_x * $temp_y * $temp_z == $min_area && $temp_x < $prev_x) ||
					($temp_x * $temp_y * $temp_z == $min_area && $temp_x < $prev_x && $temp_y < $prev_y) //||
					// ($temp_x * $temp_y * $temp_z == $min_area && $temp_x < $prev_x && $candidate['orientation'] == 'vertical' && $candidate['y'] <= $min_tick)
					)
				{
					$min_area = $temp_x * $temp_y * $temp_z;
					$prev_x = $temp_x;
					$min_candidate = $candidate;
					$min_tick = $candidate['y'];

				}
			endforeach;
			// var_dump('$min_candidate', $min_candidate);
			// var_dump('area', $temp_x*$temp_y*$temp_z);
			return $min_candidate;
		}

		public function has_no_collision($packages,$corner, $x2, $y2, $z2, $orientation, $priority)
		{
			foreach ($packages as $package):
				/*
				Collision detection criteria:
				Return false if collided 
				1. px1 <= x1 && x2 <= px2
				2. py1 <= y1 && y2 <= py2
				*/
				
				if($corner['x'] < (float)$package['x2'] && $x2 > (float)$package['x1'] &&
					$corner['y'] < (float)$package['y2'] && $y2 > (float)$package['y1'] && 
					$corner['z'] < (float)$package['z2'] && $z2 > (float)$package['z1'] 
					)
				{
					return false;

				}
            endforeach;
            // var_dump($corner);
            // var_dump($orientation);
            return true;	
		}

		//get all possible corners to put the package
		public function get_corners($packages, $placeable=false, $priority=-1, $length, $width, $tick=0.1)
		{
			$corners = array();
			$corners_hi_priority = array();

			foreach ($packages as $package):
				for ($x=1; $x <=2 ; $x++) { 
					for ($y=1; $y <=2 ; $y++) { 
						for ($z=1; $z <=2 ; $z++) { 

							//gets corners that can be placed with a package
							if($placeable)
								{
									if(
										($z == 2 ) &&
											(
												($x == 1 && $y == 2) ||
												($y == 1 && $x == 2) || 
												($x == 2 && $y == 2)
												) 
										)
										continue;

									//0 for stack
									// if($priority==0){
									// 	if ($z != 2)
									// 		continue;
									// }
									// //1 for base
									// if($priority==1){
									// 	if ($z == 2)
									// 		continue;
									// }
								}
								// var_dump($package);
							$corner = array('id' => (int)$package['id'], 'x' => (float)$package['x'.$x],  'y' => (float)$package['y'.$y],  'z' => (float)$package['z'.$z]);

							if (((float)$package['x'.$x] == 0 || (float)$package['y'.$y] == 0) && (float)$package['z'.$z] == 0)
							{
								array_push($corners_hi_priority,$corner);
							}
							else
							{
								array_push($corners,$corner);
							}
						}
					}
				}
            endforeach;

            //loop is to try to cover extra spaces
            foreach ($packages as $package):
            	// var_dump('PACKAGE CHECKPOINT');	
            	for ($x=$width; $x >= 0 ; $x=round($x-$tick,2)) {
            		if((float)$package['x1']-$x < 0) continue;
            		// var_dump('1: x='.((float)$package['x1']-$x));
            		$corner = array('id' => (int)$package['id'], 'x' => (float)$package['x1']-$x,  'y' => (float)$package['y2'],  'z' => (float)$package['z1']);

					if (((float)$package['x1']-$x == 0 || (float)$package['y2'] == 0) && (float)$package['z1'] == 0)
					{
						array_push($corners_hi_priority,$corner);
					}
					else
					{
						array_push($corners,$corner);
					}
					// var_dump('1', $corner);
				}
				for ($y=$length; $y >= 0 ; $y=round($y-$tick,2)) {
            		if((float)$package['y1']-$y < 0) continue;
            		// var_dump('2: y='.((float)$package['y1']-$y));
					$corner = array('id' => (int)$package['id'], 'x' => (float)$package['x2'],  'y' => (float)$package['y1']-$y,  'z' => (float)$package['z1']);

					if (((float)$package['x2'] == 0 || (float)$package['y1']-$y == 0) && (float)$package['z1'] == 0)
					{
						array_push($corners_hi_priority,$corner);
					}
					else
					{
						array_push($corners,$corner);
					}
					// var_dump('2', $corner);
				}
            endforeach;		



            $y_temp = array();
            foreach ($corners as $key => $row) {
           		$y_temp[$key] = $row['y'];
            }
            $x_temp = array();
            foreach ($corners as $key => $row) {
           		$x_temp[$key] = $row['x'];
            }
            $z_temp = array();
            foreach ($corners as $key => $row) {
           		$z_temp[$key] = $row['z'];
            }
            if($priority==0){
	            array_multisort($z_temp, SORT_DESC, $x_temp, SORT_ASC, $y_temp, SORT_ASC, $corners);
        	}elseif ($priority==1) {
				array_multisort($z_temp, SORT_ASC, $x_temp, SORT_ASC, $y_temp, SORT_ASC, $corners);
        	}

            $y_temp = array();
            foreach ($corners_hi_priority as $key => $row) {
           		$y_temp[$key] = $row['y'];
            }
            $x_temp = array();
            foreach ($corners_hi_priority as $key => $row) {
           		$x_temp[$key] = $row['x'];
            }
            $z_temp = array();
            foreach ($corners_hi_priority as $key => $row) {
           		$z_temp[$key] = $row['z'];
            }
            if($priority==0){
	            array_multisort($z_temp, SORT_DESC, $x_temp, SORT_ASC, $y_temp, SORT_ASC, $corners_hi_priority);
        	}elseif ($priority==1) {
				array_multisort($z_temp, SORT_ASC, $x_temp, SORT_ASC, $y_temp, SORT_ASC, $corners_hi_priority);
        	}

        	$corners = array_merge($corners_hi_priority, $corners);
        	// var_dump('corners',$corners);
            return $corners;
		}

} 	