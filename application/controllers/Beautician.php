<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beautician extends CI_Controller 
{

	public function showrequests()
	{
		$email = $this->session->userdata('email');
		$this->load->model('model_users');
		$my_address = $this->model_users->get_my_address();
		$this->session->set_userdata(['my_address' => $my_address]);

		//Following is for Maps
		$this->load->library('googlemaps');
		//This is for center to beautician address
		$config['center'] = $this->session->userdata('my_address');
		$config['map_width'] = "80%";
		$config['map_height'] = "500px";
		$config['directions'] = TRUE;
		$this->googlemaps->initialize($config);

		//This is for marker at beautician's address
		$marker = array();
		$marker['position'] = $this->session->userdata('my_address');
		$marker['infowindow_content'] = 'My Position';
		$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
		$this->googlemaps->add_marker($marker);

		$this->load->model('model_users');
		$add_array = $this->model_users->get_customer_addresses();
		$data['addresses'] = $add_array;

		//Add markers to these addresses

		for($a=0; $a<count($data['addresses']); $a++)
		{
			$marker = array();
			$marker['position'] = $data['addresses'][$a];
			$marker['infowindow_content'] = $data['addresses'][$a];
			$this->googlemaps->add_marker($marker);
		}

		//This creates map. 
		$data['map'] = $this->googlemaps->create_map();

		$this->load->view('beautician_map', $data);
	}	

}

?>