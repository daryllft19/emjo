<?php
class Cluster extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                // $this->load->helper('url_helper');
                $this->load->model('Address_model');
                $this->load->library('tank_auth');
                header('Content-Type: application/json');

                $name = $this->router->fetch_method();

                if (!$this->tank_auth->is_logged_in() && ($name == 'delete' || $name == 'modify' || $name == 'clear')) {
                    $ret['success'] = 0;
                    $ret['msg'] = 'User not authorized!';
                    echo json_encode($ret);
                    exit();
                }
        }

        public function export()
        {
            $ret = array();
            $type = $this->input->get('type');

            try{
                if($type=='csv'){
                    header('Content-Type: text/csv; charset=utf-8');
                    header('Content-Disposition: attachment; filename=data.csv');
                    $output = fopen('php://output', 'w');

                    $csv_str = '';
                    $clusters = $this->Cluster_model->get_cluster();

                    foreach ($clusters as $cluster_key => $cluster) {
                        $export = $this->Cluster_model->export($cluster['id']);
                        $csv_str .= $cluster['name']." \n";
                        $csv_str .= 'Length (cm): '.$cluster['length'].',Width (cm): '.$cluster['width'].',Height (cm): '.$cluster['height']."\n";
                        // $header = $header;
                        $csv_str .= "Serial No,Length,Width,Height,Weight,Address,Timestamp,Fragile\n";
                        if(!empty($export))
                            foreach ($export as $package_key => $package) {
                                $csv_str .= $package["serial_no"].",";
                                $csv_str .= $package["length"].",";
                                $csv_str .= $package["width"].",";
                                $csv_str .= $package["height"].",";
                                $csv_str .= $package["weight"].",";
                                $address = $this->Address_model->get_address($package["address"]);

                                $temp = "";
                                foreach (array("area", "street","avenue","district","barangay","city","province") as $attr) {
                                    $temp .= $address[$attr];
                                    if(strlen($address[$attr]) != 0 && $attr!="province")
                                        $temp .= ", ";

                                }
                                $csv_str .= "\"".$temp."\"".",";
                                $csv_str .= $package["arrival_date"].",";
                                $csv_str .= $package["is_fragile"]."\n";
                            }
                        else
                            $csv_str .= "NO PACKAGES\n";
                        $csv_str .= "\n";
                    }

                    $ret['csv'] = $csv_str;
                    $output = $csv_str;
                    echo $output;

                    // $ret['cluster'] = $clusters;
                }
                else{
                    $this->load->library('zip');

                    $filename = (!empty($this->input->get('filename'))?$this->input->get('filename') :'test').'.bak';
                    $cluster_id = $this->input->get('cluster_id');
                    if(empty($cluster_id))
                        throw new Exception();

                    $data = $this->Cluster_model->export($cluster_id);
                    $this->zip->add_data('packages', serialize($data));

                    $filename = (!empty($this->input->get('filename'))?$this->input->get('filename') :'test').'.bak';
                    $this->zip->download($filename);
                    $ret['out'] = $data;    
                }
            }
            catch(Exception $e)
            {
                $ret['error'] = 1;
            }
            // echo json_encode($ret);   
        }

        // public function import()
        // {
        //     $ret = array();
        //     try{
        //         $this->load->library('zip');

        //         $filename = (!empty($this->input->get('filename'))?$this->input->get('filename') :'test').'.bak';
        //         $cluster_id = $this->input->get('cluster_id');
        //         if(empty($cluster_id))
        //             throw new Exception();

        //         $data = $this->Cluster_model->export($cluster_id);
        //         $this->zip->add_data('packages', serialize($data));

        //         $filename = (!empty($this->input->get('filename'))?$this->input->get('filename') :'test').'.bak';
        //         $this->zip->download($filename);
        //         $ret['out'] = $data;
        //     }
        //     catch(Exception $e)
        //     {
        //         $ret['error'] = 1;
        //     }
        //     echo json_encode($ret);   
        // }

        public function clear()
        {
            $cluster_id = $this->input->get('cluster_id');
            $ret = array('success'=>0);
            $ret['success'] = $this->Cluster_model->clear($cluster_id);
            echo json_encode($ret);   
        }

        public function count()
        {
            $cluster_id = $this->input->get('cluster_id');
            $ret = array();
            $ret = $this->Cluster_model->count($cluster_id);
            header('Content-Type: application/json');
            echo json_encode($ret);
        }

        public function modify()
        {
            $ret = array();

            $params = $this->input->post('params');
            
            $ret['response'] = $this->Cluster_model->set_cluster($params);
            $ret['params'] = $params;
            header('Content-Type: application/json');
            echo json_encode($ret); 
        }

        public function delete()
        {
            $cluster_id = $this->input->get('cluster_id');
            $ret = array();
            $ret['success'] = $this->Cluster_model->delete($cluster_id);
            header('Content-Type: application/json');
            echo json_encode($ret);
        }


}